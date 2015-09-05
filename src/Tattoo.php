<?php namespace Tattoo;

/**
 * Tattoo main interface
 **
 * @package         	Tattoo
 * @copyright       	2015 Mario Döring
 */

use Tattoo\Compiler\Scope as ScopeCompiler;
use Tattoo\Parser\Scope as ScopeParser;
use Tattoo\Node\Scope as ScopeNode;

class Tattoo
{
    /**
     * Tattoo engine configuration holder
     *
     * @var array
     */ 
    protected $configuration = array();

    /**
     * Generates the default configuration array
     *
     * @return array
     */
    private function getDefaultConfiguration() 
    {
        return array(

            // the default cache directory is inside the tattoo library
            'cache' => __DIR__ . '/../cache/',

            // the development mode forces tattoo to always 
            // rebuild the files.
            'development' => false,

            // compiler options
            'compiler' => array(

                // automatically escape all outputet variables
                'autoEscapeVariables' => true,

                // define the escaping function. This configuration
                // should always be a string, but calm your horses
                // the string will be directly used in the compiling
                // proccess so use this with attention.
                'defaultEscapeFunction' => 'htmlentities',
            ),
        );
    }

    /**
     * Construct a new tattoo engine
     *
     * @param array                 $configuration
     * @return void
     */
    public function __construct(array $configuration = array())
    {
        $this->configuration = array_merge($this->getDefaultConfiguration(), $configuration);
    }

    /**
     * Parse tattoo code
     *
     * @throws Tattoo\Exception
     *
     * @param string            $code
     * @return Node\Scope
     */
    public function parse($code)
    {
        $lexer = new Lexer($code);
        $parser = new ScopeParser($lexer->tokens());

        return $parser->parse();
    }

    /**
     * Compile tattoo scope to php
     *
     * @throws Tattoo\Exception
     *
     * @param Node\Scope            $code
     * @return array
     */
    public function compile(ScopeNode $scope)
    {
        $compiler = new ScopeCompiler($scope, $this->configuration['compiler']);
        return $compiler->compile();
    }

    /**
     * Render a tattoo template 
     *
     * @param string                $file
     * @param array                 $parameters
     * @return string
     */
    public function render($file, array $parameters = array())
    {
        if (!file_exists($file) || !is_readable($file))
        {
            throw new Exception('Tattoo file does not exists or is not accessable: '.$file);
        }

        $cacheFile = $this->configuration['cache'] . 'tattoo_' . md5($file) . '.php';

        // when we are not in development mode check if 
        // we have to rebuild the code
        if ($this->configuration['development'] === true || (!file_exists($cacheFile)) || filemtime($file) > filemtime($cacheFile))
        {
            file_put_contents($cacheFile, '<?php ' . static::compile(file_get_contents($file)));
        }

        // move the needed vars to avoid collisions
        $__tattooRenderCompiledFilePath = $cacheFile;
        $__tattoo_vars = $parameters;
        unset($cacheFile, $parameters);
            
        ob_start();
        
        require $__tattooRenderCompiledFilePath;

        return ob_get_clean();
    }
}
