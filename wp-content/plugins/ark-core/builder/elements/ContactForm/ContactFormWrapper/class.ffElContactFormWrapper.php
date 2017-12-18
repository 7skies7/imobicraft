<?php
/**
 * @link
 * */

class ffElContactFormWrapper extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'contact-form-wrapper');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Form Wrapper', 'ark' ) ));
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, true);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'form');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'contact form, form, email');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);

		$this->_addTab('Advanced', array($this, '_advancedTab'));
	}

	protected function _getElementGeneralOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Info', 'ark' ) ) );
				$s->addElement(ffOneElement::TYPE_HTML,'',ark_wp_kses( __('<i>If you are facing problems with sending e-mails we recommend you to download the <a href="//wordpress.org/plugins/postman-smtp/" target="_blank">Postman SMTP</a> plugin.</i>', 'ark' ) ));
				$s->addElement( ffOneElement::TYPE_NEW_LINE );
				$s->addElement(ffOneElement::TYPE_HTML,'',ark_wp_kses( __('<i>If you want to <b>show a message after the user sends the form</b>, please add the "Form Alert" element inside of the "Form Wrapper" element. The "Form Alert" element allows you to show an error or success message after the users sends the form. If you would like to show both alert messages you would need to insert 2 "Form Alert" elements and set them up accordingly. You can then insert any of the builder elements inside of the "Form Alert" element to achieve the desired output.</i>', 'ark' ) ));
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Form Settings', 'ark' ) ));

				$s->addOptionNL(ffOneOption::TYPE_SELECT,'form-action','','email')
					->addSelectValue('Send form as email (ajax)','email')
					->addSelectValue('Submit form','submit')
//					->addSelectValue('Connect with Custom Loop', 'connect-with-loop')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Action to do after submitting the form', 'ark' ) ) )
				;

				/*----------------------------------------------------------*/
				/* submit form - start
				/*----------------------------------------------------------*/
				$s->startHidingBox('form-action', 'submit');
					$s->startSection('form-action-submit');

						$s->addOptionNL(ffOneOption::TYPE_SELECT,'method','','post')
							->addSelectValue('Post','post')
							->addSelectValue('Get','get')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Form method', 'ark' ) ) )
						;

						$s->addOptionNL(ffOneOption::TYPE_TEXT, 'action', '', '#')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Action attribute of form (URL to where form is redirected after submit)', 'ark' ) ) )
						;

						$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'erase-user-content', 'Erase user content after submit', 1);

						$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'execute-php-code', 'Execute custom PHP code with the form data after submit', 0);

						$s->startHidingBox('execute-php-code', 'checked');
							$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'This PHP code will be executed only if this particular form has been submited. You can see the values by <strong>var_dump( $_POST );</strong> or <strong>var_dump( $_SERVER );</strong> ');

							$s->addOption(ffOneOption::TYPE_TEXTAREA_STRICT,'php-submit-code','', '')
								->addParam( ffOneOption::PARAM_CODE_EDITOR, 'php')
							;
						$s->endHidingBox();

					$s->endSection();


				$s->endHidingBox();
				/*----------------------------------------------------------*/
				/* submit form - end
				/*----------------------------------------------------------*/

				/*----------------------------------------------------------*/
				/* send form as email - start
				/*----------------------------------------------------------*/
				$s->startHidingBox('form-action', 'email');
					$s->addOptionNL(ffOneOption::TYPE_TEXT, 'email', '', 'your@email.com')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Your email address (where you will receive the e-mails)', 'ark' ) ) )
					;

					$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'In fields below, you can actually use the names of your inputs. They must be wrapped like this: <code>%your_input_name%</code>.
																			The name can be set in every input separately. Look for "Internal field name", default value of this field is "Name:",
																			so the usage would be <code>%Name:%</code>. Anyway we would recommend you to use only A-Z, 0-9 and _ characters. Preferably like "user_subject".
																			This will be invoked by <code>%user_subject%</code>');

					$s->addOptionNL(ffOneOption::TYPE_TEXT, 'subject', '', 'Contact Form')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Subject of the e-mails you will receive. Feel free to use the %fieldname% string here', 'ark' ) ) )
					;

					$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'use-custom-headers', 'Use custom email headers', 0);


					$s->startHidingBox('use-custom-headers', 'checked');
						$s->addOptionNL(ffOneOption::TYPE_TEXTAREA_STRICT, 'headers', '', '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Headers, you can keep it blank. Feel free to use the %fieldname% string here', 'ark' ) ) )
						;
						$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'Use code like <code>Reply-To:%user_email%</code>. For more info about email headers, google "email header"');
					$s->endHidingBox();

					$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'use-custom-message', 'Use custom message', 0);
					$s->startHidingBox('use-custom-message', 'checked');
						$s->addOptionNL(ffOneOption::TYPE_TEXTAREA_STRICT, 'message', '', '')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Custom message content. Feel free to use the %fieldname% string here, for example <code>First Name: %firstname%</code>', 'ark' ) ) )
							;
					$s->endHidingBox();

					$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'redirect-to-url', 'Redirect to URL after sending', 0);
					$s->startHidingBox('redirect-to-url', 'checked');
						$s->addOptionNL(ffOneOption::TYPE_TEXT, 'redirect-to-url-ok', '', 'http://yoursite.com/email-sent')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Email sent OK - redirect to this URL', 'ark' ) ) )
						;

						$s->addOptionNL(ffOneOption::TYPE_TEXT, 'redirect-to-url-wrong', '', 'http://yoursite.com/email-failed')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Email NOT SENT - redirect to this URL', 'ark' ) ) )
						;
					$s->endHidingBox();
				$s->endHidingBox();



		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Auto Responders', 'ark' ) ));

			$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'You can create unlimited amount of auto responders in this form');

			$s->startRepVariableSection('auto-responders');
				$s->startRepVariationSection('responder-advanced', ark_wp_kses( __('Advanced responder (PHP)', 'ark' ) ) );

					$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'All the form inputs are accessible through $form variable. ');

					$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', '<span style="color:red;">If you return false, no email is sent. You can just do whatever you want with these values (save into database for example)</span>');

					$s->addOptionNL(ffOneOption::TYPE_CHECKBOX,'print-output-in-console', ark_wp_kses( __('Print output in JS console (for debugging purposes)', 'ark' ) ) ,0);

					$phpCode = [];
					$phpCode[] = '// ***********************************************************';
					$phpCode[] = '// All form inputs are accessible through $form["input_name"];';
					$phpCode[] = '// ***********************************************************';
					$phpCode[] = '$email = array();';
					$phpCode[] = '$email["to"] = "email_to_send@justexample.com"; //(example) $form["Name:"]';
					$phpCode[] = '$email["subject"] = "Subject of the email sent";';
					$phpCode[] = '$email["message"] = "Content of your email";';
					$phpCode[] = '$email["headers"] = ""; // (example) Reply-To:John Doe <your_email@gmail.com>';

					$phpCode[] = 'return $email;';

					$phpCode = implode( "\n", $phpCode);

					$s->addOption(ffOneOption::TYPE_TEXTAREA_STRICT,'php-responder-code','', $phpCode)
						->addParam( ffOneOption::PARAM_CODE_EDITOR, 'php')
					;

				$s->endRepVariationSection();
			$s->endRepVariableSection();

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

	 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _advancedTab( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('JavaScript trigger', 'ark' ) ));
				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX,'use-js-trig', ark_wp_kses( __('Use JavaScript trigger', 'ark' ) ) ,0);
				$s->addOptionNL(ffOneOption::TYPE_TEXT, 'trigger-name', '', 'my-contact')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Trigger name', 'ark' ) ) )
				;
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('This is event, which will be triggered immediately before sending email. If you will use this option the event will be triggered twice. Once on the body and once on particular contact form. You can hook the events on both - body and contact form. It has to be done via jQuery.on function. So for example it will look like this:', 'ark' ) ) );
				$s->addElement( ffOneElement::TYPE_NEW_LINE );
				$s->addElement(ffOneElement::TYPE_HTML,'', ark_wp_kses( __('<code>jQuery("body").on("your_event _name", function($contactForm){});</code>', 'ark' ) ) );
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('There are also 2 additional events triggered, if the email was sent successfully or non-succesfully', 'ark' ) ) );
				$s->addElement(ffOneElement::TYPE_HTML,'', ark_wp_kses( __('<code>jQuery("body").on("your_event_name-sent-ok", function($contactForm){});</code>', 'ark' ) ) );
				$s->addElement( ffOneElement::TYPE_NEW_LINE );
				$s->addElement( ffOneElement::TYPE_NEW_LINE );
				$s->addElement(ffOneElement::TYPE_HTML,'', ark_wp_kses( __('<code>jQuery("body").on("your_event_name-sent-wrong", function($contactForm){});</code>', 'ark' ) ) );

		//-sent-ok

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('PHP filter', 'ark' ) ));
				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX,'use-php-filter', ark_wp_kses( __('Use PHP filter', 'ark' ) ),0);
				$s->addOptionNL(ffOneOption::TYPE_TEXT, 'filter-name', '', 'my-filter')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Filter name', 'ark' ) ) )
				;

				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('If you will use this option you need to create filter callback function and apply filter with the name you have inserted above.', 'ark' ) ) );
				$s->addElement( ffOneElement::TYPE_NEW_LINE );
				$s->addElement(ffOneElement::TYPE_HTML,'', ark_wp_kses( __('<code>add_filter("my-filter", function(){});</code> - for filter before sending', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_HTML,'', ark_wp_kses( __('<code>add_filter("my-filter_sent", function(){});</code> - for filter after sending', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}


	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$trigger = '';
		if($query->get('use-js-trig')){
			$trigger = $query->getWithoutComparationDefault('trigger-name');
		}

		wp_enqueue_script( 'ark-custom-contact-form' );

		$customFormSettings = [];

		if( $query->getWithoutComparationDefault('redirect-to-url', 0) ) {
			$customFormSettings['redirect-to-url-ok'] = $query->getWithoutComparationDefault('redirect-to-url-ok', '');
			$customFormSettings['redirect-to-url-wrong'] = $query->getWithoutComparationDefault('redirect-to-url-wrong', '');
		}

		/*----------------------------------------------------------*/
		/* Form Action
		/*----------------------------------------------------------*/
		$formAction = $query->getWithoutComparationDefault('form-action', 'email');
		$customFormSettings['form-action'] = $formAction;

		$formMethod = 'POST';
		$formActionAttr = '#';


		switch( $formAction ) {
			case 'submit':
				$submitQuery = $query->get('form-action-submit');

				$formMethod = $submitQuery->get('method');
				$formActionAttr = $submitQuery->get('action');



				$customFormSettings['form-method'] = $submitQuery->get('method');
				$customFormSettings['form-erase-user-content'] = $submitQuery->get('erase-user-content');

				if( $customFormSettings['form-erase-user-content'] ) {
					$this->_getStatusHolder()->addValueToCustomStack('erase-user-content', true);
				} else {
					$this->_getStatusHolder()->addValueToCustomStack('erase-user-content', false);
				}

				$this->_getStatusHolder()->addValueToCustomStack('form-method', $customFormSettings['form-method']);

				$request = ffContainer()->getRequest();
				if( $submitQuery->get('execute-php-code') ) {

					$submitFormId = null;
					if( $customFormSettings['form-method'] == 'get' ) {
						$submitFormId = $request->get('ff-form-unique-id');
					} else {
						$submitFormId = $request->post('ff-form-unique-id');
					}

					if( $submitFormId == $uniqueId ) {
						eval( $submitQuery->get('php-submit-code') );
					}
				}

				break;
		}


		$customFormSettingsString = esc_attr( json_encode($customFormSettings) );


		echo '<form action="'.$formActionAttr.'" method="'.$formMethod.'" data-unique-id="'.$uniqueId.'" data-custom-form-settings="'.$customFormSettingsString.'" data-trigger="'.$trigger.'" class="ff-custom-form">';

			echo ( $this->_doShortcode( $content ) );

			$data = array();
	
			$data['email'] = $query->get('email');
			$data['subject'] = $query->get('subject');
			if($query->get('use-php-filter')){
				$data['filter'] = $query->get('filter-name');
			}

			if( $query->getWithoutComparationDefault('use-custom-headers', 0) ) {
				$data['headers'] = $query->getWithoutComparationDefault('headers', '');
			}

			if( $query->getWithoutComparationDefault('use-custom-message', 0) ) {
				$data['message'] = $query->getWithoutComparationDefault('message', '');
			}






			$data = json_encode( $data );

			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.ff-contact-info')
				->addParamsString('display:none;');

			echo '<div class="ff-contact-info" style="display:none;">'.ffContainer::getInstance()->getCiphers()->freshfaceCipher_encode( $data ).'</div>';


			$autoResponders = $query->get('auto-responders');//print-output-in-console //php-responder-code

			$cache = ffContainer()->getDataStorageCache();
			$namespace = 'form_responders';

			if( !empty( $autoResponders) ) {


				foreach ($autoResponders as $key => $oneResponder) {

					$formResponderName = $uniqueId . '-' . $key;


					$phpCode = $oneResponder->get('php-responder-code');
					$printInConsole = $oneResponder->get('print-output-in-console');

					$phpCodeEncoded = ffContainer::getInstance()->getCiphers()->freshfaceCipher_encode($phpCode);

					$cache->setOption($namespace, $formResponderName, $phpCodeEncoded);

					echo '<div class="ff-autoresponder" data-form-responder-name="' . $formResponderName . '" data-print-console="' . $printInConsole . '">';
					echo '</div>';

				};
			}
		echo '</form>';

	}

}