<?php require __DIR__ . '/../vendor/autoload.php';

if ( !isset( $__tattoo_vars ) ) {
	$__tattoo_vars = array(
);
}

echo new Tattoo\Engine\Tag( 'span', array(
), function( $__tattoo_tag ) use( $__tattoo_vars )
{

$__tattoo_tag->content .= 'Hello World';
});

echo new Tattoo\Engine\Tag( 'button', array(
), function( $__tattoo_tag ) use( $__tattoo_vars )
{

$__tattoo_tag->content .= 'Click Me';
});

echo new Tattoo\Engine\Tag( 'p', array(
), function( $__tattoo_tag ) use( $__tattoo_vars )
{

$__tattoo_tag->content .= 'Im so useless';
});
