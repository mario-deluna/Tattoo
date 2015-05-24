@modal = yes

[div #main-container]
{
	@modalClassSuffix = '-xs'
	
	if @modal
	{
		@this.class.add('modal' % @modalClassSuffix)
	}
	
	h1 => 'Hellö'
	
	[p] => 'Yeah'
	{
		@this.data.lang = 'de'
	}
}

<?php

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
	
	$__tattoo_tag->content .= new Tattoo\Engine\Tag( 'div', array(), function( $__tattoo_tag ) use( $__tattoo_vars )
	{
		if ( !isset( $__tattoo_tag->attributes['data'] ) )
		{
			$__tattoo_tag->attributes['data'] = array();
		}
		
		$__tattoo_tag->attributes['data']['lang'] = 'de';
	});
});

?>


<?php

$__tatto 

$modal = true;

$__tattoo_tag_2342 = new Tattoo\Engine\Tag( 'div', array( 'id' => 'main-container' ) );

$modalClassSuffix = '-xs';

if ( $modal ) 
{
	if ( !isset( $__tattoo_tag_2342->attributes['class'] ) )
	{
		$__tattoo_tag_2342->attributes['class'] = array();
	}
	
	$__tattoo_tag_2342->attributes['class'][] = 'modal' . $modalClassSuffix;
	
}

$__tattoo_tag_2342->childrend[] = '<h1>hellö</h1>';

?>

<div id="main-container" class="modal">
	 <h1>Hellö</h1>
	 <p data-lang="de">Yeah</p>
</div>