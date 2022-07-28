<?php

/*
* Plugin Name:      WPForms Spam Filter
* Description:      Barebone custom plugin: WPForms Spam Filter using the comment blacklist field in Settings>Discussion.
*/

// Filter out spam messages on forms
/**
* WPForms Spam Filter Using the Comment Blacklist
*
* @author Nikki Stokes
* @link https://thebizpixie.com/article/stop-wpforms-spam-using-comment-blacklist-field/
*
* @param string $honeypot, empty if not spam, honeypot text is used in WPForms Log
* @param array $fields
* @param array $entry
* @param array $form_data
*/


function nhs_wpforms_email_blacklist( $honeypot, $fields, $entry, $form_data ) {
	
	// Get comment blacklist values
	$mod_keys = trim( get_option( 'blacklist_keys' ) );
	if ( '' == $mod_keys ) {
	}
	else{
		$words = explode( "\n", $mod_keys );
		
		// Assign field content to variables
		// Adaptation: add entry values to a list to make sure that no value is overriden if two fields are of the same type
		$list_of_entries = array();
		foreach( $form_data['fields'] as $id => $field ) {
			if( 'email' == $field['type'] ){
				$email = $entry['fields'][$id];
				array_push($list_of_entries, $email);
			}
			if( 'text' == $field['type'] ){
				$text = $entry['fields'][$id];
				array_push($list_of_entries, $text);
			}	
			if( 'textarea' == $field['type'] ){
				$message = $entry['fields'][$id];
				$message_without_html = wp_strip_all_tags( $message );
				array_push($list_of_entries, $message);
				array_push($list_of_entries, $message_without_html);
			}
		}

		// Step through spam terms in turn
		foreach ( (array) $words as $word ) {
			$word = trim( $word );

			// Skip empty lines
			if ( empty( $word ) ) {
			continue; }

			// Escape terms so that '#' chars in the spam words don't break things
			$word = preg_quote( $word, '#' );
			
			// Match form fields to spam terms (new)
			$pattern = "#$word#i";
			foreach( $list_of_entries as $input_entry ) {
				if ( preg_match( $pattern, $input_entry )
				) {
					$honeypot = '[Blacklist] ' . $name . ', ' . $email . ', ' . $message;
				}
			}
		}
	}
	return $honeypot;
}
add_filter( 'wpforms_process_honeypot', 'nhs_wpforms_email_blacklist', 10, 4 );


/*
* Block URLs from inside form on Single Line Text and Paragraph Text form fields
*
* @link https://wpforms.com/developers/how-to-block-urls-inside-the-form-fields/
*/

function wpf_dev_check_for_urls( $field_id, $field_submit, $form_data ) {

	if( strpos($field_submit, 'http') !== false || strpos($field_submit, 'www.') !== false ) {
	wpforms()->process->errors[ $form_data['id'] ][ $field_id ] = esc_html__( 'No URLs allowed.', 'wpforms' );
	return;
	} 
}
add_action( 'wpforms_process_validate_textarea', 'wpf_dev_check_for_urls', 10, 3 );
add_action( 'wpforms_process_validate_text', 'wpf_dev_check_for_urls', 10, 3 );
