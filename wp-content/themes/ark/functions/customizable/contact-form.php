<?php

/**********************************************************************************************************************/
/* AUTO RESPONDER
/**********************************************************************************************************************/
if( !function_exists('ff_contact_form_send_ajax') ) {

	ffContainer()->getWPLayer()->getHookManager()->addAjaxRequestOwner('contactform-autoresponder-ajax', 'ff_contact_form_autoresponder_ajax');

	function ff_contact_form_autoresponder_ajax(  ffAjaxRequest $ajaxRequest ) {


		$data = $ajaxRequest->data;
		$formSerialize = $data['formInput'];
		$responderName = $data['responderName'];

		$output = array();
		parse_str( $formSerialize, $output);

		$nameToTitleMap = json_decode( $output['ff-name-to-title-map'], true );

		$form = [];
		foreach($output as $key=>$value){


			if( $key == 'ff-name-to-title-map' ) {
				continue;
			}

			if( $key == 'g-recaptcha-response') {
				continue;
			}

			if( !isset( $nameToTitleMap[ $key ] ) ) {
				$name = $key;
			} else {
				$name = $nameToTitleMap [ $key ];
			}

			$form[$name]= $output[$key];
		}

		$responderEncoded = ffContainer()->getDataStorageCache()->getOption('form_responders', $responderName);
		$responderPHP = ffContainer()->getCiphers()->freshfaceCipher_decode( $responderEncoded );

		/*----------------------------------------------------------*/
		/* RESPONDER ENCODED AN ITEM VALUES ARE ENCODED AS WELL
		/*----------------------------------------------------------*/
		// $responderPHP, $form;

		$email = eval( $responderPHP );

		if( $email != false ) {
			$result = wp_mail($email['to'], $email['subject'], $email['message'], $email['headers']);

			echo "\n\n";
			if( $result ) {
				echo 'Email has been sent.';
			} else {
				echo 'There was problem sending the email.';
			}

			echo $result;
		} else {
			echo 'Your email has been processed';
		}


	}
}

/**********************************************************************************************************************/
/* BIG CONTACT FORM
/**********************************************************************************************************************/
if( !function_exists('ff_contact_form_send_ajax') ) {

	ffContainer()->getWPLayer()->getHookManager()->addAjaxRequestOwner('contactform-send-ajax', 'ff_contact_form_send_ajax');

	function ff_contact_form_send_ajax(  ffAjaxRequest $ajaxRequest ) {

		$couldBeSend = true;

		$data = $ajaxRequest->data;


		$formSerialize = $data['formInput'];


		$output = array();
		parse_str( $formSerialize, $output);

		$nameToTitleMap = json_decode( $output['ff-name-to-title-map'], true );



		$contactInfo = $data['contactInfo'];

		$contactInfoDecoded = ffContainer::getInstance()->getCiphers()->freshfaceCipher_decode( $contactInfo );
		$contactInfoParsed = json_decode($contactInfoDecoded);


		$message = '';


		if( isset( $output['g-recaptcha-response'] ) ) {

			$http = ffContainer()->getHttp();

			$recaptchaSecretCoded = ( $output['g-recaptcha-data']);
			$recaptchaSecret = ffContainer::getInstance()->getCiphers()->freshfaceCipher_decode( $recaptchaSecretCoded );


			$verificationResponse = $http->post('https://www.google.com/recaptcha/api/siteverify',array('secret' => $recaptchaSecret, 'response' => $output['g-recaptcha-response'] ) );

			$responseDecoded = json_decode($verificationResponse['body'], true);

			if( !isset( $responseDecoded['success'] ) || $responseDecoded['success'] == false ) {
				$couldBeSend = false;
			}

		}

		$holder = array();

		foreach($output as $key=>$value){


			if( $key == 'ff-name-to-title-map' ) {
				continue;
			}

			if( $key == 'g-recaptcha-response') {
				continue;
			}

			if( !isset( $nameToTitleMap[ $key ] ) ) {
				$name = $key;
			} else {
				$name = $nameToTitleMap [ $key ];
			}

			$holder[$name]= $output[$key];
		}


		if( !isset( $contactInfoParsed->message ) ) {
			foreach($output as $key=>$value){


				if( $key == 'ff-name-to-title-map' ) {
					continue;
				}

				if( $key == 'g-recaptcha-response') {
					continue;
				}

				if( !isset( $nameToTitleMap[ $key ] ) ) {
					$name = $key;
				} else {
					$name = $nameToTitleMap [ $key ];
				}

				$message .= $name . $output[$key].PHP_EOL;
			}
		} else {

			$regexp = '/%([^%]*)%/';
			$message = $contactInfoParsed->message;

			$message = preg_replace_callback($regexp, function( $match) use( $holder ) {
				$inputName = $match[1];

				if( isset( $holder[ $inputName ] ) ) {
					return $holder[ $inputName ];
				} else {
					return $match[0] . ' - not found';
				}
			}, $message);

		}


		if( isset( $contactInfoParsed->headers ) ) {
			$regexp = '/%([^%]*)%/';

			$contactInfoParsed->headers = preg_replace_callback($regexp, function( $match) use( $holder ) {
				$inputName = $match[1];

				if( isset( $holder[ $inputName ] ) ) {
					return $holder[ $inputName ];
				} else {
					return $match[0] . ' - not found';
				}
			}, $contactInfoParsed->headers);
		} else {
			$contactInfoParsed->headers = '';
		}


		$regexp = '/%([^%]*)%/';

		$contactInfoParsed->subject = preg_replace_callback($regexp, function( $match) use( $holder ) {
			$inputName = $match[1];

			if( isset( $holder[ $inputName ] ) ) {
				return $holder[ $inputName ];
			} else {
				return $match[0] . ' - not found';
			}
		}, $contactInfoParsed->subject);

		$info = new stdClass();
		$info->email = $contactInfoParsed->email;
		$info->subject = $contactInfoParsed->subject;
		$info->message = $message;
		$info->headers = $contactInfoParsed->headers;
		$info->dataHolder = $holder;

		if( $couldBeSend ) {
			if( !empty( $contactInfoParsed->email ) ) {

				if(isset($contactInfoParsed->filter)){
					$value = apply_filters( $contactInfoParsed->filter, $info);
					if( $value === false) {
						return $value;
					}else{
						$result = wp_mail($info->email, $info->subject, $info->message, $info->headers);
						if ($result == false) {
							echo 'false';
						} else {
							$value = apply_filters( $contactInfoParsed->filter.'_sent', $info);
							echo 'true';
						}
						return $value;
					}
				}else {
					$result = wp_mail($info->email, $info->subject, $info->message, $info->headers);
					if ($result == false) {
						echo 'false';
					} else {
						echo 'true';
					}
				}
			}
		} else {
			echo 'true';
		}


	}
}

/**********************************************************************************************************************/
/* BIG CONTACT FORM
/**********************************************************************************************************************/
if( !function_exists('ff_contact_form_send_ajax_small') ) {

	ffContainer()->getWPLayer()->getHookManager()->addAjaxRequestOwner('contactform-send-ajax-small', 'ff_contact_form_send_ajax_small');

	function ff_contact_form_send_ajax_small(  ffAjaxRequest $ajaxRequest ) {

		$data = $ajaxRequest->data;

		$formSerialize = $data['formInput'];
		$output = array();
		parse_str( $formSerialize, $output);


		$contactInfo = $data['contactInfo'];

		$contactInfoDecoded = ffContainer::getInstance()->getCiphers()->freshfaceCipher_decode( $contactInfo );
		$contactInfoParsed = json_decode($contactInfoDecoded);

		$message = '';

		foreach( $output as $formName => $formValue ) {
			$message .= $formName  . ' ' . $formValue . PHP_EOL;
		}

		$info = new stdClass();
		$info->email = $contactInfoParsed->email;
		$info->subject = $contactInfoParsed->subject;
		$info->message = $message;

		if( !empty( $contactInfoParsed->email ) ) {

			if(isset($contactInfoParsed->filter)){
				$value = apply_filters( $contactInfoParsed->filter, $info);
				if( $value === false) {
					return $value;
				}else{
					$result = wp_mail($contactInfoParsed->email, $contactInfoParsed->subject, $message);
					if ($result == false) {
						echo 'false';
					} else {
						echo 'true';
					}
					return $value;
				}
			}else {
				$result = wp_mail($contactInfoParsed->email, $contactInfoParsed->subject, $message);
				if ($result == false) {
					echo 'false';
				} else {
					echo 'true';
				}
			}
		} else {
			echo 'false';
		}
	}
}
