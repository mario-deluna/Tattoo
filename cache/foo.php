<?php require __DIR__ . '/../vendor/autoload.php';

if ( !isset( $__tattoo_vars ) ) {
	$__tattoo_vars = array(
);
}
foreach (array(
  0 => 'A',
  1 => 'B',
  2 => 'C',
) as $__tattoo_vars['item']) {
if ( !isset( $__tattoo_vars ) ) {
	$__tattoo_vars = array(
);
}

echo new Tattoo\Engine\Tag( 'span', array(
), function( $__tattoo_tag ) use( $__tattoo_vars )
{
$__tattoo_tag->content .= $__tattoo_vars['item'];
});

}
echo '
';