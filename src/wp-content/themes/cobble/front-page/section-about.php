<div class="front_page_section front_page_section_about<?php
	$cobble_scheme = cobble_get_theme_option( 'front_page_about_scheme' );
	if ( ! empty( $cobble_scheme ) && ! cobble_is_inherit( $cobble_scheme ) ) {
		echo ' scheme_' . esc_attr( $cobble_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( cobble_get_theme_option( 'front_page_about_paddings' ) );
	if ( cobble_get_theme_option( 'front_page_about_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$cobble_css      = '';
		$cobble_bg_image = cobble_get_theme_option( 'front_page_about_bg_image' );
		if ( ! empty( $cobble_bg_image ) ) {
			$cobble_css .= 'background-image: url(' . esc_url( cobble_get_attachment_url( $cobble_bg_image ) ) . ');';
		}
		if ( ! empty( $cobble_css ) ) {
			echo ' style="' . esc_attr( $cobble_css ) . '"';
		}
		?>
>
<?php
	// Add anchor
	$cobble_anchor_icon = cobble_get_theme_option( 'front_page_about_anchor_icon' );
	$cobble_anchor_text = cobble_get_theme_option( 'front_page_about_anchor_text' );
if ( ( ! empty( $cobble_anchor_icon ) || ! empty( $cobble_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_about"'
									. ( ! empty( $cobble_anchor_icon ) ? ' icon="' . esc_attr( $cobble_anchor_icon ) . '"' : '' )
									. ( ! empty( $cobble_anchor_text ) ? ' title="' . esc_attr( $cobble_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_about_inner
	<?php
	if ( cobble_get_theme_option( 'front_page_about_fullheight' ) ) {
		echo ' cobble-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$cobble_css           = '';
			$cobble_bg_mask       = cobble_get_theme_option( 'front_page_about_bg_mask' );
			$cobble_bg_color_type = cobble_get_theme_option( 'front_page_about_bg_color_type' );
			if ( 'custom' == $cobble_bg_color_type ) {
				$cobble_bg_color = cobble_get_theme_option( 'front_page_about_bg_color' );
			} elseif ( 'scheme_bg_color' == $cobble_bg_color_type ) {
				$cobble_bg_color = cobble_get_scheme_color( 'bg_color', $cobble_scheme );
			} else {
				$cobble_bg_color = '';
			}
			if ( ! empty( $cobble_bg_color ) && $cobble_bg_mask > 0 ) {
				$cobble_css .= 'background-color: ' . esc_attr(
					1 == $cobble_bg_mask ? $cobble_bg_color : cobble_hex2rgba( $cobble_bg_color, $cobble_bg_mask )
				) . ';';
			}
			if ( ! empty( $cobble_css ) ) {
				echo ' style="' . esc_attr( $cobble_css ) . '"';
			}
			?>
	>
		<div class="front_page_section_content_wrap front_page_section_about_content_wrap content_wrap">
			<?php
			// Caption
			$cobble_caption = cobble_get_theme_option( 'front_page_about_caption' );
			if ( ! empty( $cobble_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<h2 class="front_page_section_caption front_page_section_about_caption front_page_block_<?php echo ! empty( $cobble_caption ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( $cobble_caption, 'cobble_kses_content' ); ?></h2>
				<?php
			}

			// Description (text)
			$cobble_description = cobble_get_theme_option( 'front_page_about_description' );
			if ( ! empty( $cobble_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_description front_page_section_about_description front_page_block_<?php echo ! empty( $cobble_description ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( wpautop( $cobble_description ), 'cobble_kses_content' ); ?></div>
				<?php
			}

			// Content
			$cobble_content = cobble_get_theme_option( 'front_page_about_content' );
			if ( ! empty( $cobble_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_content front_page_section_about_content front_page_block_<?php echo ! empty( $cobble_content ) ? 'filled' : 'empty'; ?>">
					<?php
					$cobble_page_content_mask = '%%CONTENT%%';
					if ( strpos( $cobble_content, $cobble_page_content_mask ) !== false ) {
						$cobble_content = preg_replace(
							'/(\<p\>\s*)?' . $cobble_page_content_mask . '(\s*\<\/p\>)/i',
							sprintf(
								'<div class="front_page_section_about_source">%s</div>',
								apply_filters( 'the_content', get_the_content() )
							),
							$cobble_content
						);
					}
					cobble_show_layout( $cobble_content );
					?>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>
