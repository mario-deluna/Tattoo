<?php require __DIR__ . '/../vendor/autoload.php';

if ( !isset( $__tattoo_vars ) ) {
	$__tattoo_vars = array(
);
}

echo new Tattoo\Engine\Tag( 'div', array(
  'id' => 'main-container',
  'class' => 
  array(
    0 => 'container',
    1 => 'container-white',
  ),
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= 'Hello World';
});

echo new Tattoo\Engine\Tag( 'p', array(
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= true;
});
