<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_services_modern.html#scrollTo__808
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_services.html#scrollTo__2517
 * @link http://demo.freshface.net/html/h-ark/HTML/index_corporate_2.html#scrollTo__788
 * @link http://demo.freshface.net/html/h-ark/HTML/index_business_3.html#scrollTo__6488
 * */

class ffElContactForm1 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'contact-form1');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Contact Form', 'ark' ) ));
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'contact-form');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'contact form, form, email');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('light');
	}

	protected function _getElementGeneralOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Info', 'ark' ) ) );
				$s->addElement(ffOneElement::TYPE_HTML,'',ark_wp_kses( __('<i>If you are facing problems with sending e-mails we recommend you to download the <a href="//wordpress.org/plugins/postman-smtp/" target="_blank">Postman SMTP</a> plugin.</i>', 'ark' ) ));
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE HEADING
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('heading', ark_wp_kses( __('Heading', 'ark' ) ));

						$s->startRepVariableSection('repeated-lines');
							$s->startRepVariationSection('one-subtitle', ark_wp_kses( __('Subtitle', 'ark' ) ) );
									$s->addOptionNL( ffOneOption::TYPE_TEXT, 'subtitle', '', 'Stay')
										->addParam('print-in-content', true)
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Subtitle', 'ark' ) ) )
									;
							$s->endRepVariationSection();
							$s->startRepVariationSection('one-title', ark_wp_kses( __('Title', 'ark' ) ) );
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'title', '', 'in Touch')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Title', 'ark' ) ) )
								;
							$s->endRepVariationSection();
						$s->endRepVariableSection();

					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE FORM
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('form', ark_wp_kses( __('Form', 'ark' ) ));

						$s->startRepVariableSection('repeated-lines');

							$s->startRepVariationSection('one-field', ark_wp_kses( __('E-mail Field', 'ark' ) ) );
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'placeholder', '', 'Your E-mail')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Placeholder', 'ark' ) ) )
								;
								$s->addOptionNL(ffOneOption::TYPE_CHECKBOX,'is-required', ark_wp_kses( __('Field is required', 'ark' ) ),1);

								$s->startHidingBox('is-required', array('checked') );

									$s->addOptionNL( ffOneOption::TYPE_TEXT, 'required-text', '', 'This field is required.')
										->addParam('print-in-content', true)
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Error message - Field is required', 'ark' ) ) )
									;

								$s->endHidingBox();

								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'required-email-text', '', 'Please enter a valid e-mail address.')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Error message - E-mail address is not valid', 'ark' ) ) )
								;

								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'name-attr', '', 'From: ')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Internal field name', 'ark' ) ) )
									;
								$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('This is how this input will be labeled in the e-mails you will be receiving.', 'ark' ) ) );
							$s->endRepVariationSection();


							$s->startRepVariationSection('one-area', ark_wp_kses( __('Text Field', 'ark' ) ) );
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'placeholder', '', 'Message')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Placeholder', 'ark' ) ) )
								;

								$s->addOptionNL(ffOneOption::TYPE_CHECKBOX,'is-required', ark_wp_kses( __('Field is required', 'ark' ) ),1);

								$s->startHidingBox('is-required', array('checked') );

									$s->addOptionNL( ffOneOption::TYPE_TEXT, 'required-text', '', 'This field is required.')
										->addParam('print-in-content', true)
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Error message - Field is required', 'ark' ) ) )
									;

								$s->endHidingBox();

								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'name-attr', '', 'Message: ')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Internal field name', 'ark' ) ) )
									;
								$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('This is how this input will be labeled in the e-mails you will be receiving.', 'ark' ) ) );
							$s->endRepVariationSection();


							$s->startRepVariationSection('one-button', ark_wp_kses( __('Submit Button', 'ark' ) ) );
//								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'button-name', '', 'Submit')
//									->addParam('print-in-content', true)
//									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
//									;
								$this->_getBlock( ffThemeBlConst::BUTTON )->setParam( ffBlButton::PARAM_WITHOUT_URL, true )->injectOptions( $s );

							$s->endRepVariationSection();

						$s->endRepVariableSection();

					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);
			
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Contact Form Settings', 'ark' ) ) );
				$s->startSection('contact-form-user-input');
	
					$s->addOptionNL(ffOneOption::TYPE_TEXT, 'email', '', 'your@email.com')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Your email address (where you will receive the e-mails)', 'ark' ) ) )
					;
					$s->addOptionNL(ffOneOption::TYPE_TEXT, 'subject', '', 'Contact Form')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Subject of the e-mails you will receive', 'ark' ) ) )
					;
				$s->endSection();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
	
	
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Contact Form Messages', 'ark' ) ));
				$s->startSection('contact-form-messages');
	
					$s->addOptionNL(ffOneOption::TYPE_TEXT, 'message-send-ok', '', 'Your message has been successfully sent.')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Success message', 'ark' ) ) )
					;
					$s->addOptionNL(ffOneOption::TYPE_TEXT, 'message-send-wrong', '', 'Oops! Something went wrong.')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Error message', 'ark' ) ) )
					;

				$s->endSection();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$s->addOption( ffOneOption::TYPE_SELECT, 'align', '', 'text-left')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'text-left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'text-center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'text-right');
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Contact Form Colors', 'ark' ) ));

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-overlay-color', '' , 'rgba(52,52,60,0.7)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Overlay', 'ark' ) ) );

				$s->addElement( ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'sending-message-success-color', '' , null)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Sending Message - Success Text', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'sending-message-error-color', '' , null)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Sending Message - Error Text', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'validation-message-color', '' , null)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Input Validation Message Text', 'ark' ) ) );

				$s->addElement( ffOneElement::TYPE_NEW_LINE);

				$s->addElement( ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '' , null)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Input Background', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-focus-color', '' , null)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Input Background - Focus', 'ark' ) ) );

				$s->addElement( ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '' , null)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Input Border', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-focus-color', '' , null)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Input Border - Focus', 'ark' ) ) );

				$s->addElement( ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'placeholder-color', '' , null)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Input Placeholder', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'placeholder-focus-color', '' , null)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Input Placeholder - Focus', 'ark' ) ) );

				$s->addElement( ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-color', '' , null)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Input Text', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-focus-color', '' , null)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Input Text - Focus', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _enqueueScriptsAndStyles( $query ) {
		wp_enqueue_script( 'ark-contact-form' );
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		$bg_color_selectors = array(
			' .services-v2-form' => 'bg-color',
			' .services-v2-form:focus' => 'bg-focus-color',
			'' => 'bg-overlay-color'
		);

		foreach( $bg_color_selectors as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('background-color:' . $color . ';');
			}
		}

		$border_color_selectors = array(
			' .services-v2-form' => 'border-color',
			' .services-v2-form:focus' => 'border-focus-color',
		);

		foreach( $border_color_selectors as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('border-color:' . $color . ';');
			}
		}

		$placeholder_color_selectors = array(
			' .services-v2-form::-moz-placeholder' => 'placeholder-color',
			' .services-v2-form:-ms-input-placeholder' => 'placeholder-color',
			' .services-v2-form::-webkit-input-placeholder' => 'placeholder-color',
			' .services-v2-form:focus::-moz-placeholder' => 'placeholder-focus-color',
			' .services-v2-form:focus:-ms-input-placeholder' => 'placeholder-focus-color',
			' .services-v2-form:focus::-webkit-input-placeholder' => 'placeholder-focus-color',
		);

		foreach( $placeholder_color_selectors as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('color:' . $color . ';');
			}
		}

		$text_color_selectors = array(
			' .services-v2-form' => 'text-color',
			' .services-v2-form:focus' => 'text-focus-color',
		);

		foreach( $text_color_selectors as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('color:' . $color . ';');
			}
		}

		$validationMessageColor = array(
			' .alert-area .alert-area-message.alert-area-message-success' => 'sending-message-success-color',
			' .alert-area .alert-area-message.alert-area-message-error' => 'sending-message-error-color',			
			' label#email-error' => 'validation-message-color',
			' label#message-error' => 'validation-message-color',
			' label.error' => 'validation-message-color',
		);

		foreach( $validationMessageColor as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('color:' . $color . ';');
			}
		}

		echo '<section class="services-v2 '. $query->getEscAttr('align') .'">';
			echo '<form action="" class="ff-cform">';

			foreach( $query->get('content') as $oneLine ) {
				switch( $oneLine->getVariationType() ) {

					case 'heading':

						if( $oneLine->exists('repeated-lines') ) {

							echo '<div class="services-v2-header">';
							foreach( $oneLine->get('repeated-lines') as $oneHeading ) {
								switch( $oneHeading->getVariationType() ) {
									case 'one-subtitle':
										echo '<span class="services-v2-header-subtitle">';
											$oneHeading->printWpKses('subtitle');
										echo '</span>';
										break;

									case 'one-title':
										echo '<h3 class="services-v2-header-title">';
											$oneHeading->printWpKses('title');
										echo '</h3>';
										break;
								}
							}
							echo '</div>';

						}

						break;

					case 'form':

						if( $oneLine->exists('repeated-lines') ) {



							echo '<div>';
							foreach( $oneLine->get('repeated-lines') as $oneField ) {
								switch ($oneField->getVariationType()) {
									case 'one-field':
										$nameAttr = $oneField->getWpKses('name-attr');
										$requiredText = $oneField->get('required-text');
										$requiredEmailText = $oneField->get('required-email-text');
										echo '<input data-required-email-text="'.esc_attr($requiredEmailText).'" data-type="email" data-required-text="'.esc_attr($requiredText).'" data-name="'. $oneField->getWpKses('name-attr') .'" name="'.$nameAttr.'" type="text" class="'.($oneField->get('is-required') ? 'contact-form-required' : '').' form-control services-v2-form radius-0 cform-1-input-email '. $query->getEscAttr('align') .'" placeholder="'. $oneField->getWpKses('placeholder') .'">';
										break;

									case 'one-area':
										$nameAttr = $oneField->getWpKses('name-attr');
										$requiredText = $oneField->get('required-text');
										echo '<input data-required-text="'.esc_attr($requiredText).'" data-name="'. $oneField->getWpKses('name-attr') .'" name="'.$nameAttr.'" type="text" class="'.($oneField->get('is-required') ? 'contact-form-required' : '').' form-control services-v2-form radius-0 cform-1-input-text '. $query->getEscAttr('align') .'" placeholder="'. $oneField->getWpKses('placeholder') .'">';
										break;

									case 'one-button':
										echo '<span class="ff-submit-button-wrapper">';
											$this->_getBlock( ffThemeBlConst::BUTTON )->render( $oneField );
										echo '</span>';

										break;
								}
							}
							echo "</div>";
						}
						break;


				}
			}

			echo '<div class="alert-area"></div>';
	
			$data = array();
	
			$data['email'] = $query->get('contact-form-user-input email');
			$data['subject'] = $query->get('contact-form-user-input subject');
	
			$data = json_encode( $data );
	
			$cfMessages = $query->get('contact-form-messages');

			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.ff-contact-info')
				->addParamsString('display:none;');
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.ff-contact-messages')
				->addParamsString('display:none;');
	
			echo '<div class="ff-contact-info">'.ffContainer::getInstance()->getCiphers()->freshfaceCipher_encode( $data ).'</div>';
	
			echo '<div class="ff-contact-messages">';
	
				echo '<div class="ff-message-send-ok">'. $cfMessages->getWpKses('message-send-ok') .'</div>';
				echo '<div class="ff-message-send-wrong">'. $cfMessages->getWpKses('message-send-wrong') .'</div>';
	
			echo '</div>';

			echo '</form>';
		
		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element ) {


				query.get('content').each(function(query, variationType ){
					switch(variationType){
						case 'heading':
							query.get('repeated-lines').each(function(query, variationType ){
								switch(variationType){
									case 'one-title':
										query.addHeadingLg('title');
										break;
									case 'one-subtitle':
										query.addHeadingSm('subtitle');
										break;
								}
							});
							break;
						case 'form':
							query.get('repeated-lines').each(function(query, variationType ){
								switch(variationType){
									case 'one-field':
									case 'one-area':
										query.addText('placeholder');
										break;
								}
							});
							break;
					}

				});

			}
		</script data-type="ffscript">
	<?php
	}


}