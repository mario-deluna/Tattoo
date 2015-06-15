<?php require __DIR__ . '/../vendor/autoload.php';

if ( !isset( $__tattoo_vars ) ) {
	$__tattoo_vars = array(
);
}

echo new Tattoo\Engine\Tag( 'div', array(
  'id' => 'main',
  'class' => 
  array(
    0 => 'container',
    1 => 'strong',
    2 => 'uppercase',
  ),
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= 'Hello World';
});
