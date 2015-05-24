<?php
require __DIR__ . '/../vendor/autoload.php';

$__tattoo_vars = array();

$__tattoo_vars['modal'] = true;

echo new Tattoo\Engine\Tag( 'div', array( 'id' => 'main-container' ), function( $__tattoo_tag ) use( $__tattoo_vars ) 
{
	$__tattoo_vars['modalClassSuffix'] = '-xs';

	if ( $__tattoo_vars['modal'] )
	{
		if ( !isset( $__tattoo_tag->attributes['class'] ) )
		{
			$__tattoo_tag->attributes['class'] = array();
		}

		$__tattoo_tag->attributes['class'][] = 'modal' . $__tattoo_vars['modalClassSuffix'];
	}

	$__tattoo_tag->content .= '<h1>Hellö</h1>';

	$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'p', array(), function( $__tattoo_tag ) use( $__tattoo_vars )
	{
		$__tattoo_tag->content .= 'yeah';
		
		if ( !isset( $__tattoo_tag->attributes['data'] ) )
		{
			$__tattoo_tag->attributes['data'] = array();
		}

		$__tattoo_tag->attributes['data']['lang'] = 'de';
	});
});
