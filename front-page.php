<?php
add_filter( 'genesis_attr_site-inner', 'sk_attributes_site_inner' );

function sk_attributes_site_inner( $attributes ) {
	$attributes['role']     = 'main';
	$attributes['itemprop'] = 'mainContentOfPage';
	return $attributes;
}
// Remove div.site-inner's div.wrap
add_filter( 'genesis_structural_wrap-site-inner', '__return_empty_string' );


get_header();
?>

<!-- Content -->

<?php
get_footer();
