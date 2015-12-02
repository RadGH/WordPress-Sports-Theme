<?php

/*
Usage:
Step 1: Set the $formID in the class to the ID of the Gravity Forms Contact form you create.

Step 2: Set the $fieldID to the drop down field of the form that will contain the email values.

Step 3: Set the $optionsID to the ACF Post ID containing the field values, normally "options".

Step 4: Make an ACF Repeater that uses "contact_form_options" as the primary key, it should contain two values: "subject" and "email".
*/



//ACF and Gravity forms dependency
if ( ! class_exists( 'GFForms' ) || ! class_exists('acf') ) {
	return;
}


class bt_contactForm {

	public static $formID = false;

	public static $fieldID = false;

	public static $optionsID = "options";

	public static $salt = 'NnBcnycAJpbAhWX3ixhfJglDv1wJEpKS'; //Doesn't need to be unique.

	public static function route_notification($notification, $form , $entry) {

		if(self::$formID === false || self::$fieldID === false) {
			 return $notification;
		}

		if($form['id'] == self::$formID) {
			$notification['to'] = self::decrypt(rgar($entry, self::$fieldID));
			$notification['toType'] = 'email';
		}
		
	    return $notification;
	}

	public static function update_entry_field($entry, $form) {
		if($form['id'] == self::$formID) {
			GFAPI::update_entry_field($entry['id'], self::$fieldID, self::decrypt(rgar($entry, self::$fieldID)));
		}
	}


	public static function update_gravity_form( $post_id ) {

		if(self::$formID === false || self::$fieldID === false) {
			return;
		}

		$formValues = get_field('contact_form_options',$post_id);

		if($post_id == self::$optionsID) {
			$form = GFAPI::get_form( self::$formID );
			$first = true;

			foreach($form['fields'] as $key => $value) {

			    if($form['fields'][$key]->id == self::$fieldID) {

			    	$form['fields'][$key]->choices = array();

			    	foreach($formValues as $key2 => $value2) {
			    		$form['fields'][$key]->choices[] = array(
			    			'text' => $value2['subject'],
			    			'value' => self::encrypt($value2['email']),
			    			'isSelected' => $first,
			    		);
			    		if($first == true) {
			    			$first = false;
			    		}
			    	}

			    }
			}

			GFAPI::update_form( $form );
		}
	}

	public static function encrypt($text) {
	    return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, self::$salt, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
	}

	public static function decrypt($text) {
         return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, self::$salt, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
    }

}

add_action( 'gform_after_submission', 'bt_contactForm::update_entry_field', 10, 2 );
add_filter( 'gform_notification', 'bt_contactForm::route_notification', 10, 3 );
add_action('acf/save_post', 'bt_contactForm::update_gravity_form', 20);