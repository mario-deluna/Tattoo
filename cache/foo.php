<?php require __DIR__ . '/../vendor/autoload.php';

if ( !isset( $__tattoo_vars ) ) {
	$__tattoo_vars = array(
);
}

echo new Tattoo\Engine\Tag( 'html', array(
  'lang' => 'en',
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'head', array(
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'title', array(
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= 'Tattoo Demo';
});

$__tattoo_tag->content .= '<meta charset="utf-8" />';
$__tattoo_tag->content .= '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />';
});

$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'body', array(
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'nav', array(
  'id' => 'top',
  'class' => 
  array(
    0 => 'navbar',
    1 => 'navbar-default',
    2 => 'navbar-static-top',
  ),
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'div', array(
  'class' => 
  array(
    0 => 'container',
  ),
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'div', array(
  'class' => 
  array(
    0 => 'navbar-header',
  ),
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'a', array(
  'class' => 
  array(
    0 => 'navbar-brand',
  ),
  'href' => '/foo.php',
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= 'Tattoo Demo';
});

});

$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'div', array(
  'id' => 'navbar',
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'ul', array(
  'class' => 
  array(
    0 => 'nav',
    1 => 'navbar-nav',
  ),
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'li', array(
  'class' => 
  array(
    0 => 'active',
  ),
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'a', array(
  'class' => 
  array(
    0 => 'navigation-item',
  ),
  'href' => '/foo.php',
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= 'Home';
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
  'href' => '/about.php',
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= 'About';
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
  'href' => '/contact.php',
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= 'Contact';
});

});

});

});

});

});

$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'div', array(
  'id' => 'main-container',
  'class' => 
  array(
    0 => 'container',
  ),
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'div', array(
  'class' => 
  array(
    0 => 'row',
  ),
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'div', array(
  'class' => 
  array(
    0 => 'col-md-6',
    1 => 'col-md-offset-3',
  ),
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'h1', array(
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= 'Tattoo Demo';
});

$__tattoo_tag->content .= '<hr />';
$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'form', array(
  'class' => 
  array(
    0 => 'sign-in-form',
  ),
  'method' => 'post',
  'action' => '/login/',
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'div', array(
  'class' => 
  array(
    0 => 'form-group',
  ),
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'label', array(
  'for' => 'username-input',
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= 'Username';
});

$__tattoo_tag->content .= '<input class="form-control" id="username-input" type="text" />';
});

$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'div', array(
  'class' => 
  array(
    0 => 'form-group',
  ),
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'label', array(
  'for' => 'password-input',
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= 'Password';
});

$__tattoo_tag->content .= '<input class="form-control" id="password-input" type="password" />';
});

$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'button', array(
  'class' => 
  array(
    0 => 'btn',
    1 => 'btn-primary',
  ),
  'type' => 'submit',
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= 'Login';
});

});

});

});

$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'footer', array(
  'id' => 'layout-footer',
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'small', array(
  'data' => 
  array(
    'year' => 2015,
    'by' => 'Mario Döring',
  ),
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= 'Copyright 2015';
});

});

});

$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'script', array(
  'src' => 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js',
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= '';
});

$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'script', array(
  'src' => 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js',
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= '';
});

});

});

echo '
';