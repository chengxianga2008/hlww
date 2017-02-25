<tr valign="top" id="packing_options">
	<th scope="row" class="titledesc"><?php esc_html_e( 'Box Sizes', 'woocommerce-shipping-australia-post' ); ?></th>
	<td class="forminp">
		<style type="text/css">
			.australia_post_boxes td, .australia_post_services td {
				vertical-align: middle;
				padding: 4px 7px;
			}

			.australia_post_boxes th, .australia_post_services th {
				vertical-align: middle;
				padding: 9px 7px;
			}

			.australia_post_boxes td input {
				margin-right: 4px;
			}

			.australia_post_boxes .check-column {
				vertical-align: middle;
				text-align: left;
				padding: 0 7px;
			}

			.australia_post_services th.sort {
				width: 16px;
			}

			.australia_post_services td.sort {
				cursor: move;
				width: 16px;
				padding: 0 16px;
				cursor: move;
				background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAgAAAAICAYAAADED76LAAAAHUlEQVQYV2O8f//+fwY8gJGgAny6QXKETRgEVgAAXxAVsa5Xr3QAAAAASUVORK5CYII=) no-repeat center;
			}
		</style>
		<table class="australia_post_boxes widefat">
			<thead>
			<tr>
				<th class="check-column"><input type="checkbox"/></th>
				<th><?php esc_html_e( 'Outer Length', 'woocommerce-shipping-australia-post' ); ?></th>
				<th><?php esc_html_e( 'Outer Width', 'woocommerce-shipping-australia-post' ); ?></th>
				<th><?php esc_html_e( 'Outer Height', 'woocommerce-shipping-australia-post' ); ?></th>
				<th><?php esc_html_e( 'Inner Length', 'woocommerce-shipping-australia-post' ); ?></th>
				<th><?php esc_html_e( 'Inner Width', 'woocommerce-shipping-australia-post' ); ?></th>
				<th><?php esc_html_e( 'Inner Height', 'woocommerce-shipping-australia-post' ); ?></th>
				<th><?php esc_html_e( 'Weight of box', 'woocommerce-shipping-australia-post' ); ?></th>
				<th><?php esc_html_e( 'Max Weight', 'woocommerce-shipping-australia-post' ); ?></th>
				<th><?php esc_html_e( 'Letter', 'woocommerce-shipping-australia-post' ); ?></th>
			</tr>
			</thead>
			<tfoot>
			<tr>
				<th colspan="3">
					<a href="#" class="button plus insert"><?php esc_html_e( 'Add Box', 'woocommerce-shipping-australia-post' ); ?></a>
					<a href="#"
					   class="button minus remove"><?php esc_html_e( 'Remove selected box(es)', 'woocommerce-shipping-australia-post' ); ?></a>
				</th>
				<th colspan="7">
					<small
						class="description"><?php esc_html_e( 'Items will be packed into these boxes depending based on item dimensions and volume. Outer dimensions will be passed to australia Post, whereas inner dimensions will be used for packing. Items not fitting into boxes will be packed individually.', 'woocommerce-shipping-australia-post' ); ?></small>
				</th>
			</tr>
			</tfoot>
			<tbody id="rates">
			<?php
			if ( $this->boxes ) {
				foreach ( $this->boxes as $key => $box ) {
					$dim_label = ( isset( $box['is_letter'] ) && true === $box['is_letter'] ) ? 'mm' : 'cm';
					$weight_label = ( isset( $box['is_letter'] ) && true === $box['is_letter'] ) ? 'g' : 'kg';
					?>
					<tr>
						<td class="check-column"><input type="checkbox"/></td>
						<td><input type="text" size="5" class="dimension" name="boxes_outer_length[<?php echo $key; ?>]"
						           value="<?php echo esc_attr( $box['outer_length'] ); ?>"/><span class="dim-label"><?php echo $dim_label; ?></label>
						</td>
						<td><input type="text" size="5" class="dimension" name="boxes_outer_width[<?php echo $key; ?>]"
						           value="<?php echo esc_attr( $box['outer_width'] ); ?>"/><span class="dim-label"><?php echo $dim_label; ?></label>
						</td>
						<td><input type="text" size="5" class="dimension" name="boxes_outer_height[<?php echo $key; ?>]"
						           value="<?php echo esc_attr( $box['outer_height'] ); ?>"/><span class="dim-label"><?php echo $dim_label; ?></label>
						</td>
						<td><input type="text" size="5" class="dimension" name="boxes_inner_length[<?php echo $key; ?>]"
						           value="<?php echo esc_attr( $box['inner_length'] ); ?>"/><span class="dim-label"><?php echo $dim_label; ?></label>
						</td>
						<td><input type="text" size="5" class="dimension" name="boxes_inner_width[<?php echo $key; ?>]"
						           value="<?php echo esc_attr( $box['inner_width'] ); ?>"/><span class="dim-label"><?php echo $dim_label; ?></label>
						</td>
						<td><input type="text" size="5" class="dimension" name="boxes_inner_height[<?php echo $key; ?>]"
						           value="<?php echo esc_attr( $box['inner_height'] ); ?>"/><span class="dim-label"><?php echo $dim_label; ?></label>
						</td>
						<td><input type="text" size="5" class="weight" name="boxes_box_weight[<?php echo $key; ?>]"
						           value="<?php echo esc_attr( $box['box_weight'] ); ?>"/><span class="weight-label"><?php echo $weight_label; ?></label>
						</td>
						<td><input type="text" size="5" class="weight" name="boxes_max_weight[<?php echo $key; ?>]"
						           value="<?php echo esc_attr( $box['max_weight'] ); ?>" placeholder="22"/><span class="weight-label"><?php echo $weight_label; ?></label>
						</td>
						<td><input type="checkbox"
						           class="letter"
						           name="boxes_is_letter[<?php echo esc_attr( $key ); ?>]" <?php checked( isset( $box['is_letter'] ) && $box['is_letter'] == true, true ); ?> />
						</td>
					</tr>
					<?php
				}
			}
			?>
			</tbody>
		</table>
		<script type="text/javascript">

			jQuery( window ).load( function () {

				jQuery( '#woocommerce_australia_post_packing_method' ).change( function () {

					if ( jQuery( this ).val() == 'box_packing' ) {
						jQuery( '#packing_options' ).show();
					} else {
						jQuery( '#packing_options' ).hide();
					}

					if ( jQuery( this ).val() == 'weight' ) {
						jQuery( '#woocommerce_australia_post_max_weight' ).closest( 'tr' ).show();
					} else {
						jQuery( '#woocommerce_australia_post_max_weight' ).closest( 'tr' ).hide();
					}

				} ).change();

				jQuery( '.australia_post_boxes .insert' ).click( function () {
					var $tbody = jQuery( '.australia_post_boxes' ).find( 'tbody' );
					var size = $tbody.find( 'tr' ).size();
					var code = '<tr class="new">\
							<td class="check-column"><input type="checkbox" /></td>\
							<td><input type="text" class="dimension" size="5" name="boxes_outer_length[' + size + ']" /><span class="dim-label">cm</span></td>\
							<td><input type="text" class="dimension" size="5" name="boxes_outer_width[' + size + ']" /><span class="dim-label">cm</span></td>\
							<td><input type="text" class="dimension" size="5" name="boxes_outer_height[' + size + ']" /><span class="dim-label">cm</span></td>\
							<td><input type="text" class="dimension" size="5" name="boxes_inner_length[' + size + ']" /><span class="dim-label">cm</span></td>\
							<td><input type="text" class="dimension" size="5" name="boxes_inner_width[' + size + ']" /><span class="dim-label">cm</span></td>\
							<td><input type="text" class="dimension" size="5" name="boxes_inner_height[' + size + ']" /><span class="dim-label">cm</span></td>\
							<td><input type="text" class="weight" size="5" name="boxes_box_weight[' + size + ']" /><span class="weight-label">kg</span></td>\
							<td><input type="text" class="weight" size="5" name="boxes_max_weight[' + size + ']" placeholder="22" /><span class="weight-label">kg</span></td>\
							<td><input type="checkbox" class="letter" name="boxes_is_letter[' + size + ']" /></td>\
						</tr>';

					$tbody.append( code );

					return false;
				} );

				jQuery( '.australia_post_boxes .remove' ).click( function () {
					var $tbody = jQuery( '.australia_post_boxes' ).find( 'tbody' );

					$tbody.find( '.check-column input:checked' ).each( function () {
						jQuery( this ).closest( 'tr' ).hide().find( 'input' ).val( '' );
					} );

					return false;
				} );

				// Ordering
				jQuery( '.australia_post_services tbody' ).sortable( {
					items: 'tr',
					cursor: 'move',
					axis: 'y',
					handle: '.sort',
					scrollSensitivity: 40,
					forcePlaceholderSize: true,
					helper: 'clone',
					opacity: 0.65,
					placeholder: 'wc-metabox-sortable-placeholder',
					start: function ( event, ui ) {
						ui.item.css( 'background-color', '#f6f6f6' );
					},
					stop: function ( event, ui ) {
						ui.item.removeAttr( 'style' );
						australia_post_services_row_indexes();
					}
				} );

				jQuery( '.australia_post_boxes' ).on( 'click', '.letter', function() {
					var parentContainer = jQuery( '.australia_post_boxes' );

					// need to convert measurements to mm and g for letter type
					if ( jQuery( this ).is( ':checked' ) ) {
						jQuery( this ).parents( 'tr' ).eq(0).find( '.dim-label' ).html( 'mm' );
						jQuery( this ).parents( 'tr' ).eq(0).find( '.weight-label' ).html( 'g' );

						// convert units
						jQuery( this ).parents( 'tr' ).eq(0).find( '.dimension' ).each( function( index, textBox ) {
							var cmToMm = jQuery( textBox ).val() * 10;
							jQuery( textBox ).val(  cmToMm );
							return true;
						});
						jQuery( this ).parents( 'tr' ).eq(0).find( '.weight' ).each( function( index, textBox ) {
							var kgToG = jQuery( textBox ).val() * 1000;
							jQuery( textBox ).val( kgToG );
							return true;
						});

					} else {

						jQuery( this ).parents( 'tr' ).eq(0).find( '.dim-label' ).html( 'cm' );
						jQuery( this ).parents( 'tr' ).eq(0).find( '.weight-label' ).html( 'kg' );
						// convert units
						jQuery( this ).parents( 'tr' ).eq(0).find( '.dimension' ).each( function( index, textBox ) {
							var mmToCm = jQuery( textBox ).val() / 10;
							jQuery( textBox ).val( mmToCm );
							return true;
						});
						jQuery( this ).parents( 'tr' ).eq(0).find( '.weight' ).each( function( index, textBox ) {
							var gToKg = jQuery( textBox ).val() / 1000;
							jQuery( textBox ).val( gToKg );
							return true;
						});
					}

				});

				function australia_post_services_row_indexes() {
					jQuery( '.australia_post_services tbody tr' ).each( function ( index, el ) {
						jQuery( 'input.order', el ).val( parseInt( jQuery( el ).index( '.australia_post_services tr' ) ) );
					} );
				};

			} );

		</script>
	</td>
</tr>
