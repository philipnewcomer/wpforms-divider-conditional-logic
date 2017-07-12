<?php

namespace PhilipNewcomer\WPForms_Divider_Conditional_Logic;

/**
 * Enable conditional logic for Section Divider fields.
 *
 * @param array $field The field data.
 * @param \WPForms_Conditional_Logic_Fields
 *
 * @return void
 */
add_action( 'wpforms_field_options_after_advanced-options', function( $field, $instance ) {

	if ( 'divider' !== $field['type'] ) {
		return;
	}

	/**
	 * The following code is copy/pasted from WPForms_Conditional_Logic_Fields::builder_field_conditionals(). This is
	 * unfortunately the least-messy way to do this, as there is no filter in the core plugin that we can leverage for
	 * this.
	 */
	?>

	<div class="wpforms-conditional-fields wpforms-field-option-group wpforms-field-option-group-conditionals wpforms-hide" id="wpforms-field-option-conditionals-<?php echo $field['id']; ?>">

		<a href="#" class="wpforms-field-option-group-toggle">
			<?php _e( 'Conditionals', 'wpforms'); ?> <i class="fa fa-angle-right"></i>
		</a>

		<div class="wpforms-field-option-group-inner">
			<?php
			wpforms_conditional_logic()->builder_block( array(
				'form'     => $instance->form_id,
				'field'    => $field,
				'instance' => $instance,
			) );
			?>
		</div>

	</div>
	<?php
}, 10, 2 );

/**
 * Remove conditional logic field data for Section Divider fields on form submission.
 *
 * Because Section Divider fields do not submit data, they should not be processed like a normal conditional field.
 *
 * @param array $form_data The form data.
 *
 * @return array The filtered form data.
 */
add_filter( 'wpforms_process_before_form_data', function( $form_data ) {

	foreach ( $form_data['fields'] as $field ) {
		if ( 'divider' === $field['type'] ) {
			unset( $form_data['fields'][ $field['id'] ]['conditional_logic'] );
			unset( $form_data['fields'][ $field['id'] ]['conditional_type'] );
			unset( $form_data['fields'][ $field['id'] ]['conditionals'] );
		}
	}

	return $form_data;
}, 9 );
