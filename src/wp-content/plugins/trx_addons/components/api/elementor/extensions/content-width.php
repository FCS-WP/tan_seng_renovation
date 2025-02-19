<?php
/**
 * Elementor extension: Content width and alignment for Columns
 *
 * @package ThemeREX Addons
 * @since v2.18.4
 */

// Don't load directly
if ( ! defined( 'TRX_ADDONS_VERSION' ) ) {
	exit;
}


if ( ! function_exists( 'trx_addons_elm_add_params_content_width_and_align' ) ) {
	add_action( 'elementor/element/before_section_end', 'trx_addons_elm_add_params_content_width_and_align', 10, 3 );
	/**
	 * Add parameter 'Content width' and 'Content alignment' to the Elementor's columns
	 * to enable align columns in the stretched rows on the page content area
	 * 
	 * @hooked elementor/element/before_section_end
	 *
	 * @param object $element  Element object
	 * @param string $section_id  Section ID
	 * @param array $args  Section params
	 */
	function trx_addons_elm_add_params_content_width_and_align( $element, $section_id, $args ) {

		if ( ! is_object( $element ) ) return;
		
		$el_name = $element->get_name();

		if ( ( $el_name == 'column' && $section_id == 'layout' ) || ( $el_name == 'container' && $section_id == 'section_layout_container' ) ) {

			$is_edit_mode = trx_addons_elm_is_edit_mode();

			// Change a name and a title of the parameter 'Width' to 'Inner width' for the container because it already has the parameter 'content_width'
			$element->add_responsive_control( ( $el_name == 'container' ? 'container_' : '' ) . 'content_width', array(
									'type' => \Elementor\Controls_Manager::SELECT,
									'label' => $el_name == 'container' ? __("Inner width", 'trx_addons') : __("Content width", 'trx_addons'),
									'options' => ! $is_edit_mode ? array() : trx_addons_get_list_sc_content_widths('none', false),
									'default' => '',	// 'none'
									'prefix_class' => 'sc%s_inner_width_',
								) );
			// Don't add 'Content alignment' parameter for the container - it already has parameters for alignment
			if ( $el_name != 'container' ) {
				$element->add_responsive_control( 'content_align', array(
									'type' => \Elementor\Controls_Manager::SELECT,
									'label' => __("Content alignment", 'trx_addons'),
									'options' => ! $is_edit_mode ? array() : array(
										'inherit' => __("Inherit", 'trx_addons'),
										'left'    => __("Left", 'trx_addons'),
										'center'  => __("Center", 'trx_addons'),
										'right'   => __("Right", 'trx_addons'),
									),
									'default' => 'inherit',
									'prefix_class' => 'sc%s_content_align_',
								) );
			}
		}
	}
}
