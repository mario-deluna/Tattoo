<?php require __DIR__ . '/../vendor/autoload.php';

if ( !isset( $__tattoo_vars ) ) {
	$__tattoo_vars = array(
);
}

echo new Tattoo\Engine\Tag( 'div', array(
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= 'Hello ';
$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'ul', array(
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= 'Foo';
$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'li', array(
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= 'f';
$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'a', array(
  'class' => 
  array(
    0 => 'navigation-item',
  ),
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'span', array(
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= 'Home';
});

});

$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'a', array(
  'class' => 
  array(
    0 => 'navigation-item',
  ),
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'span', array(
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= 'About';
});

});

$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'a', array(
  'class' => 
  array(
    0 => 'navigation-item',
  ),
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'span', array(
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= 'Contact';
});

});

});

});

});

echo '
';