<div class="front_page_section front_page_section_googlemap<?php
	$cobble_scheme = cobble_get_theme_option( 'front_page_googlemap_scheme' );
	if ( ! empty( $cobble_scheme ) && ! cobble_is_inherit( $cobble_scheme ) ) {
		echo ' scheme_' . esc_attr( $cobble_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( cobble_get_theme_option( 'front_page_googlemap_paddings' ) );
	if ( cobble_get_theme_option( 'front_page_googlemap_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$cobble_css      = '';
		$cobble_bg_image = cobble_get_theme_option( 'front_page_googlemap_bg_image' );
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
	$cobble_anchor_icon = cobble_get_theme_option( 'front_page_googlemap_anchor_icon' );
	$cobble_anchor_text = cobble_get_theme_option( 'front_page_googlemap_anchor_text' );
if ( ( ! empty( $cobble_anchor_icon ) || ! empty( $cobble_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_googlemap"'
									. ( ! empty( $cobble_anchor_icon ) ? ' icon="' . esc_attr( $cobble_anchor_icon ) . '"' : '' )
									. ( ! empty( $cobble_anchor_text ) ? ' title="' . esc_attr( $cobble_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_googlemap_inner
		<?php
		$cobble_layout = cobble_get_theme_option( 'front_page_googlemap_layout' );
		echo ' front_page_section_layout_' . esc_attr( $cobble_layout );
		if ( cobble_get_theme_option( 'front_page_googlemap_fullheight' ) ) {
			echo ' cobble-full-height sc_layouts_flex sc_layouts_columns_middle';
		}
		?>
		"
			<?php
			$cobble_css      = '';
			$cobble_bg_mask  = cobble_get_theme_option( 'front_page_googlemap_bg_mask' );
			$cobble_bg_color_type = cobble_get_theme_option( 'front_page_googlemap_bg_color_type' );
			if ( 'custom' == $cobble_bg_color_type ) {
				$cobble_bg_color = cobble_get_theme_option( 'front_page_googlemap_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_googlemap_content_wrap
		<?php
		if ( 'fullwidth' != $cobble_layout ) {
			echo ' content_wrap';
		}
		?>
		">
			<?php
			// Content wrap with title and description
			$cobble_caption     = cobble_get_theme_option( 'front_page_googlemap_caption' );
			$cobble_description = cobble_get_theme_option( 'front_page_googlemap_description' );
			if ( ! empty( $cobble_caption ) || ! empty( $cobble_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				if ( 'fullwidth' == $cobble_layout ) {
					?>
					<div class="content_wrap">
					<?php
				}
					// Caption
				if ( ! empty( $cobble_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h2 class="front_page_section_caption front_page_section_googlemap_caption front_page_block_<?php echo ! empty( $cobble_caption ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( $cobble_caption, 'cobble_kses_content' );
					?>
					</h2>
					<?php
				}

					// Description (text)
				if ( ! empty( $cobble_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_googlemap_description front_page_block_<?php echo ! empty( $cobble_description ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( wpautop( $cobble_description ), 'cobble_kses_content' );
					?>
					</div>
					<?php
				}
				if ( 'fullwidth' == $cobble_layout ) {
					?>
					</div>
					<?php
				}
			}

			// Content (text)
			$cobble_content = cobble_get_theme_option( 'front_page_googlemap_content' );
			if ( ! empty( $cobble_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				if ( 'columns' == $cobble_layout ) {
					?>
					<div class="front_page_section_columns front_page_section_googlemap_columns columns_wrap">
						<div class="column-1_3">
					<?php
				} elseif ( 'fullwidth' == $cobble_layout ) {
					?>
					<div class="content_wrap">
					<?php
				}

				?>
				<div class="front_page_section_content front_page_section_googlemap_content front_page_block_<?php echo ! empty( $cobble_content ) ? 'filled' : 'empty'; ?>">
				<?php
					echo wp_kses( $cobble_content, 'cobble_kses_content' );
				?>
				</div>
				<?php

				if ( 'columns' == $cobble_layout ) {
					?>
					</div><div class="column-2_3">
					<?php
				} elseif ( 'fullwidth' == $cobble_layout ) {
					?>
					</div>
					<?php
				}
			}

			// Widgets output
			?>
			<div class="front_page_section_output front_page_section_googlemap_output">
				<?php
				if ( is_active_sidebar( 'front_page_googlemap_widgets' ) ) {
					dynamic_sidebar( 'front_page_googlemap_widgets' );
				} elseif ( current_user_can( 'edit_theme_options' ) ) {
					if ( ! cobble_exists_trx_addons() ) {
						cobble_customizer_need_trx_addons_message();
					} else {
						cobble_customizer_need_widgets_message( 'front_page_googlemap_caption', 'ThemeREX Addons - Google map' );
					}
				}
				?>
			</div>
			<?php

			if ( 'columns' == $cobble_layout && ( ! empty( $cobble_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div></div>
				<?php
			}
			?>
		</div>
	</div>
</div>
