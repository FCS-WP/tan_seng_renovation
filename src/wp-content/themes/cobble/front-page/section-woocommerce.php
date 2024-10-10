<?php
$cobble_woocommerce_sc = cobble_get_theme_option( 'front_page_woocommerce_products' );
if ( ! empty( $cobble_woocommerce_sc ) ) {
	?><div class="front_page_section front_page_section_woocommerce<?php
		$cobble_scheme = cobble_get_theme_option( 'front_page_woocommerce_scheme' );
		if ( ! empty( $cobble_scheme ) && ! cobble_is_inherit( $cobble_scheme ) ) {
			echo ' scheme_' . esc_attr( $cobble_scheme );
		}
		echo ' front_page_section_paddings_' . esc_attr( cobble_get_theme_option( 'front_page_woocommerce_paddings' ) );
		if ( cobble_get_theme_option( 'front_page_woocommerce_stack' ) ) {
			echo ' sc_stack_section_on';
		}
	?>"
			<?php
			$cobble_css      = '';
			$cobble_bg_image = cobble_get_theme_option( 'front_page_woocommerce_bg_image' );
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
		$cobble_anchor_icon = cobble_get_theme_option( 'front_page_woocommerce_anchor_icon' );
		$cobble_anchor_text = cobble_get_theme_option( 'front_page_woocommerce_anchor_text' );
		if ( ( ! empty( $cobble_anchor_icon ) || ! empty( $cobble_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
			echo do_shortcode(
				'[trx_sc_anchor id="front_page_section_woocommerce"'
											. ( ! empty( $cobble_anchor_icon ) ? ' icon="' . esc_attr( $cobble_anchor_icon ) . '"' : '' )
											. ( ! empty( $cobble_anchor_text ) ? ' title="' . esc_attr( $cobble_anchor_text ) . '"' : '' )
											. ']'
			);
		}
	?>
		<div class="front_page_section_inner front_page_section_woocommerce_inner
			<?php
			if ( cobble_get_theme_option( 'front_page_woocommerce_fullheight' ) ) {
				echo ' cobble-full-height sc_layouts_flex sc_layouts_columns_middle';
			}
			?>
				"
				<?php
				$cobble_css      = '';
				$cobble_bg_mask  = cobble_get_theme_option( 'front_page_woocommerce_bg_mask' );
				$cobble_bg_color_type = cobble_get_theme_option( 'front_page_woocommerce_bg_color_type' );
				if ( 'custom' == $cobble_bg_color_type ) {
					$cobble_bg_color = cobble_get_theme_option( 'front_page_woocommerce_bg_color' );
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
			<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
				<?php
				// Content wrap with title and description
				$cobble_caption     = cobble_get_theme_option( 'front_page_woocommerce_caption' );
				$cobble_description = cobble_get_theme_option( 'front_page_woocommerce_description' );
				if ( ! empty( $cobble_caption ) || ! empty( $cobble_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					// Caption
					if ( ! empty( $cobble_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo ! empty( $cobble_caption ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( $cobble_caption, 'cobble_kses_content' );
						?>
						</h2>
						<?php
					}

					// Description (text)
					if ( ! empty( $cobble_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo ! empty( $cobble_description ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( wpautop( $cobble_description ), 'cobble_kses_content' );
						?>
						</div>
						<?php
					}
				}

				// Content (widgets)
				?>
				<div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs">
					<?php
					if ( 'products' == $cobble_woocommerce_sc ) {
						$cobble_woocommerce_sc_ids      = cobble_get_theme_option( 'front_page_woocommerce_products_per_page' );
						$cobble_woocommerce_sc_per_page = count( explode( ',', $cobble_woocommerce_sc_ids ) );
					} else {
						$cobble_woocommerce_sc_per_page = max( 1, (int) cobble_get_theme_option( 'front_page_woocommerce_products_per_page' ) );
					}
					$cobble_woocommerce_sc_columns = max( 1, min( $cobble_woocommerce_sc_per_page, (int) cobble_get_theme_option( 'front_page_woocommerce_products_columns' ) ) );
					echo do_shortcode(
						"[{$cobble_woocommerce_sc}"
										. ( 'products' == $cobble_woocommerce_sc
												? ' ids="' . esc_attr( $cobble_woocommerce_sc_ids ) . '"'
												: '' )
										. ( 'product_category' == $cobble_woocommerce_sc
												? ' category="' . esc_attr( cobble_get_theme_option( 'front_page_woocommerce_products_categories' ) ) . '"'
												: '' )
										. ( 'best_selling_products' != $cobble_woocommerce_sc
												? ' orderby="' . esc_attr( cobble_get_theme_option( 'front_page_woocommerce_products_orderby' ) ) . '"'
													. ' order="' . esc_attr( cobble_get_theme_option( 'front_page_woocommerce_products_order' ) ) . '"'
												: '' )
										. ' per_page="' . esc_attr( $cobble_woocommerce_sc_per_page ) . '"'
										. ' columns="' . esc_attr( $cobble_woocommerce_sc_columns ) . '"'
						. ']'
					);
					?>
				</div>
			</div>
		</div>
	</div>
	<?php
}
