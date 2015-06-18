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
  ),
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'h1', array(
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= 'Tattoo Demo';
});

$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'ul', array(
  'id' => 'main-navigation',
  'class' => 
  array(
    0 => 'navigation',
  ),
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'li', array(
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
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

});

$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'li', array(
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
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

});

$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'li', array(
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
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

$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'form', array(
  'class' => 
  array(
    0 => 'sign-in-form',
  ),
  'method' => 'post',
  'action' => '/login/',
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= '<input type="text" name="username" />';
});

$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'footer', array(
  'id' => 'layout-footer',
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'small', array(
  'data' => 
  array(
    'year' => 2015,
    'by' => 'ClanCats GmbH',
  ),
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= 'Copyright 2015';
});

});

});

echo '
';