<?php require __DIR__ . '/../vendor/autoload.php';

if ( !isset( $__tattoo_vars ) ) {
	$__tattoo_vars = array();
}

echo new Tattoo\Engine\Tag( 'ul', array('id' => 'demo-list'), function( $__tattoo_tag ) use( $__tattoo_vars )
{foreach (array(0 => 'This', 1 => 'is', 2 => 'Amazing') as $__tattoo_vars['item']) {
if ( !isset( $__tattoo_vars ) ) {
	$__tattoo_vars = array();
}

$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'li', array('class' => array(0 => 'demo-item')), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'a', array('href' => $__tattoo_vars['item']), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'span', array('class' => array(0 => 'strong')), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= $__tattoo_vars['item'];
});

});

});

}
});

echo '
';