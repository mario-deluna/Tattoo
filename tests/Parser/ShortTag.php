<?php namespace Tattoo\Tests;

/**
 * Tattoo Parser test
 **
 *
 * @package         Tattoo
 * @copyright         Mario Döring
 *
 * @group Tattoo
 * @group Tattoo_Parser
 * @group Tattoo_Parser_ShortTag
 */

use Tattoo\Lexer;
use Tattoo\Parser\ShortTag as ShortTagParser;

class Parser_ShortTag_Test extends Parser_Test
{
    /**
     * tests Parser
     */
    public function testSimple()
    {
        $node = $this->parse("span => 'Hello World'");
        $this->assertInstanceOf('Tattoo\\Node\\Tag', $node);

        $this->assertEquals(1, count($node->children));

        $child = reset($node->children);

        $this->assertInstanceOf('Tattoo\\Node\\Text', $child);
        $this->assertInstanceOf('Tattoo\\Node\\Value', $child->getContent());
        $this->assertEquals('Hello World', $child->getContent()->getValue());
        $this->assertEquals('string', $child->getContent()->getType());
    }

    /**
     * tests Parser
     */
    public function testWithAttributes()
    {
        $node = $this->parse("img src: 'foo.png'");
        $this->assertEquals(array('src' => 'foo.png'), $node->getAttributes()->convertToNative());
    }

    /**
     * tests Parser
     */
    public function testWithArrayAttributes()
    {
        $node = $this->parse("img class: {'foo', 'bar'}");
        $this->assertEquals(array('class' => array('foo', 'bar')), $node->getAttributes()->convertToNative());
    }

    /**
     * tests Parser
     */
    public function testWithSpecialAttributes()
    {
        $node = $this->parse("span #foo .bar => 'Hello World'");
        $this->assertEquals(array('id' => 'foo', 'class' => array('bar')), $node->getAttributes()->convertToNative());
    }

    /**
     * tests Parser
     */
    public function testWithAttributeMerging()
    {
        $node = $this->parse("img .yeah, class: {'foo', 'bar'}");
        $this->assertEquals(array('class' => array('yeah', 'foo', 'bar')), $node->getAttributes()->convertToNative());
    }

    /**
     * tests Parser
     */
    public function testWithAssignText()
    {
        $children = $this->parse("span => 'Test'")->getChildren();
        
        $firstAdd = reset($children);
        $text = $firstAdd->getNode();

        $this->assertEquals('Test', $text->getContent()->getValue());
    }

    /**
     * tests Parser
     */
    public function testWithAssignTextConcat()
    {
        $children = $this->parse("span => 'Foo' % ' - ' % 'Bar'")->getChildren();
        
        $concat = reset($children)->getNode();

        $this->assertCount(3, $concat->getContent()->getNodes());
    }

    /**
     * tests Parser
     */
    public function testWithAssignTextVar()
    {
        $children = $this->parse("span => @text")->getChildren();
        
        $text = reset($children)->getNode();

        $this->assertEquals('text', $text->getContent()->getName());
    }

    /**
     * tests Parser
     */
    public function testWithAssignTextVarWithAttributes()
    {
        $children = $this->parse("span.foo => @text")->getChildren();
        
        $text = reset($children)->getNode();

        $this->assertEquals('text', $text->getContent()->getName());
    }

    /**
     * parse attributes string and assert the results
     */
    protected function assertAttributesArray(array $expected, $code)
    {
        $lexer = new Lexer($code);
        $parser = new ShortTagParser($lexer->tokens());

        foreach($parser->parseAttributeTokens($parser->getTokens()) as $key => $values)
        {
            $this->assertEquals($expected[$key], $values);
        }
    }

    /**
     * tests Parser
     */
    public function testClassAndIDAttributeTokens()
    {
        // simple
        $this->assertAttributesArray(array(
            'id' => 'phpunit',
            'class' => array('main', 'foo', 'bar')
        ), '#phpunit.main.foo.bar');

        // one class
        $this->assertAttributesArray(array(
            'class' => array('container')
        ), '.container');

        // multiple classes
        $this->assertAttributesArray(array(
            'class' => array('container', 'main-container')
        ), '.container.main-container');

        // just id
        $this->assertAttributesArray(array(
            'id' => 'phpunit',
        ), '#phpunit');

        // with spaces n shit
        $this->assertAttributesArray(array(
            'id' => 'phpunit',
            'class' => array('main', 'foo', 'bar')
        ), ' #phpunit .main . foo.bar');

        // id after class
        $this->assertAttributesArray(array(
            'id' => 'maninthemiddle',
            'class' => array('main', 'foo', 'bar')
        ), '.main.foo#maninthemiddle.bar');
    }

    /**
     * tests Parser
     */
    public function testOtherAttribtes()
    {
        // simple
        $this->assertAttributesArray(array('src' => 'img/logo.png'), 'src: "img/logo.png"');

        // multiple
        $this->assertAttributesArray(array('src' => 'img/logo.png', 'title' => 'Foo'), 'src: "img/logo.png", title: "Foo"');

        // with id
        $this->assertAttributesArray(array(
            'id' => 'main',
            'src' => 'img/logo.png', 
            'title' => 'Bar'
        ), '#main, src: "img/logo.png", title: "Bar"');

        // with id and class 
        $this->assertAttributesArray(array(
            'id' => 'main',
            'class' => array('image'),
            'src' => 'img/logo.png', 
            'title' => 'Bar'
        ), '.image #main, src: "img/logo.png", title: "Bar"');
    }

    /**
     * tests Parser
     */
    public function testClassSpecialCase()
    {
        $this->assertAttributesArray(array(
            'id' => 'main',
            'class' => array('container', 'white-box', 'bordered'),
        ), '#main.container, class: "white-box bordered"');

        $this->assertAttributesArray(array(
            'id' => 'main',
            'class' => array('container', 'strong', 'uppercase'),
        ), '#main.container, class: {"strong", "uppercase"}');
    }

    /**
     * tests Parser
     */
    public function testClassPrefixPrepending()
    {
        $this->assertAttributesArray(array(
            'class' => array('foo', 'foo-bar', 'foo-test'),
        ), '.foo ~ bar ~ test');

        $this->assertAttributesArray(array(
            'class' => array('foo', 'foo-bar', 'foo-test'),
            'test' => 'phpunit',
            'id' => 'foo',
        ), '.foo ~ bar ~ test #foo, test: "phpunit"');

        $this->assertAttributesArray(array(
            'class' => array('foo', 'foo-bar', 'foo-test', 'col', 'col-md-6', 'col-xs-12'),
            'test' => 'phpunit',
            'id' => 'foo',
        ), '.foo ~ bar ~ test #foo .col ~ md-6 ~ xs-12, test: "phpunit"');
    }

    /**
     * tests Parser
     * 
     * @expectedException Exception
     */
    public function testAttributeTokensDoubleId()
    {
        $this->assertAttributesArray(array(), '#phpunit.main.foo.bar#fooid');
    }

    /**
     * tests Parser
     * 
     * @expectedException Exception
     */
    public function testAttributeTokensInvalid()
    {
        $this->assertAttributesArray(array(), '#phpunit.main.foo..ba');
    }
}
