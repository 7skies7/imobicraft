<?php
/**
 * @link
 * */

class ffElContactFormInput extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'contact-form-input');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Form Input', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'form');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'contact form, form, email, input, field');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);
	}

	protected function _getElementGeneralOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_START );
			
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Input Settings', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'input-type', '', 'text')
					->addSelectValue( esc_attr( __('Text', 'ark' ) ), 'text')
					->addSelectValue( esc_attr( __('Textarea', 'ark' ) ), 'textarea')
					->addSelectValue( esc_attr( __('Radio', 'ark' ) ), 'radio')
					->addSelectValue( esc_attr( __('Select', 'ark' ) ), 'select')
					->addSelectValue( esc_attr( __('Checkbox', 'ark' ) ), 'checkbox')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Input type', 'ark' ) ) )
				;

				$s->startHidingBox('input-type', array('text', 'textarea') );

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'placeholder', '', 'Name')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Placeholder', 'ark' ) ) )
					;
				$s->endHidingBox();

				$s->startHidingBox('input-type', array('checkbox') );

					$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'If the checkbox is checked, you will see "[1]" in your email, otherwise you will see "[0]"');

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'label', '', 'I agree to the Terms and Conditions')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Label', 'ark' ) ) )
					;
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'checkbox-selected', ark_wp_kses( __('Pre-select this checkbox', 'ark' ) ), 0);
				$s->endHidingBox();

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'name', '', 'Name:')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Internal field name', 'ark' ) ) )
				;

				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('This is how this input will be labeled in the e-mails you will be receiving.', 'ark' ) ));

				$s->startHidingBox('input-type', array('textarea') );
					$s->addOptionNL(ffOneOption::TYPE_TEXT,'rows', '', 5)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Rows', 'ark' ) ) )
					;
					$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('This value sets height for the textarea input only', 'ark' ) ));
				$s->endHidingBox();

				$s->startHidingBox('input-type', array('select', 'radio') );
			
					$s->addElement(ffOneElement::TYPE_NEW_LINE);
					$s->startRepVariableSection('repeated-lines');
						$s->startRepVariationSection('one-option', ark_wp_kses( __('Option', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'value', '', 'This is one option')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Option Label', 'ark' ) ) )
							;

							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'option-value', '', '')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Option Value', 'ark' ) ) )
							;
							$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('You can keep it blank and "Option Label" field will be used as value.', 'ark' ) ) );

							$s->addElement(ffOneElement::TYPE_NEW_LINE);		

							$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'selected', ark_wp_kses( __('Pre-Selected', 'ark' ) ), 0);
							$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('Please note that only one option can be set as <strong>pre-selected</strong> for this input.', 'ark' ) ) );

						$s->endRepVariationSection();
					$s->endRepVariableSection();
					$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->endHidingBox();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Input Validation', 'ark' ) ));
				$s->startHidingBox('input-type', array( 'radio', 'select') );
					$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('This type of input does not support validation. Only <strong>Text</strong>, <strong>Textarea</strong> and <strong>Checkbox</strong> types offer input validation.', 'ark' ) ));
				$s->endHidingBox();

				$s->startHidingBox('input-type', array('checkbox') );

					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'checkbox-validation', 'Checkbox must be checked', 0 );

					$s->startHidingBox('checkbox-validation', array('checked') );

						$s->addOptionNL(ffOneOption::TYPE_TEXT,'checkbox-validation-message','','Checking this box is required.')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Error message - Checking this box is required', 'ark' ) ))
						;

					$s->endHidingBox();

				$s->endHidingBox();


				$s->startHidingBox('input-type', array('text', 'textarea') );
					$s->addOptionNL(ffOneOption::TYPE_CHECKBOX,'is-required',ark_wp_kses( __('Input is required', 'ark' ) ),1);

					$s->startHidingBox('is-required', 'checked');
						$s->addOptionNL(ffOneOption::TYPE_TEXT,'is-required-message','','This field is required.')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Error message - Field is required', 'ark' ) ))
						;
					$s->endHidingBox();

					$s->addElement(ffOneElement::TYPE_NEW_LINE);

					$s->addOptionNL(ffOneOption::TYPE_CHECKBOX,'min-length-has',ark_wp_kses( __('Input must have a minimal length', 'ark' ) ),0);

					$s->startHidingBox('min-length-has', 'checked');
						$s->addOptionNL(ffOneOption::TYPE_TEXT,'min-length','',10)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Minimal Length (X number of characters)', 'ark' ) ))
						;

						$s->addOptionNL(ffOneOption::TYPE_TEXT,'min-length-message','','Minimal length is 10 characters')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Error message - Minimal length', 'ark' ) ))
						;
					$s->endHidingBox();

					$s->addElement(ffOneElement::TYPE_NEW_LINE);

					$s->addOptionNL( ffOneOption::TYPE_SELECT, 'validation-type', '', 'none' )
						->addSelectValue('None', 'none')
						->addSelectValue('E-mail', 'email')
						->addSelectValue('Number', 'number')
						->addSelectValue('Regex', 'regex')
						->addSelectValue('Custom Function', 'custom-function')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Validate input for', 'ark' ) ) )
					;

					$s->startHidingBox('validation-type', 'regex');
						$s->addOptionNL(ffOneOption::TYPE_TEXT,'validation-type-regex','','')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Test input with this regular expression', 'ark' ) ) )
						;

						$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('Please insert regexp in this format <code>^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$</code>', 'ark' ) ));
					$s->endHidingBox();


					$s->startHidingBox('validation-type', 'custom-function');
						$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('<code>function ( value, $element, $form) {</code>', 'ark' ) ));
						$s->addOptionNL(ffOneOption::TYPE_TEXTAREA_STRICT,'validation-type-custom-function','','')
						;
						$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('<code>}</code>', 'ark' ) ));


						$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('Write standard javacript there, return true / false for validation', 'ark' ) ));
					$s->endHidingBox();

					$s->startHidingBox('validation-type', array('email', 'number', 'regex') );
						$s->addOptionNL(ffOneOption::TYPE_TEXT,'validation-message','','This field is not valid.')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Error message - Validation', 'ark' ) ))
						;
					$s->endHidingBox();

				$s->endHidingBox();





			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Input Colors', 'ark' ) ));

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '' )
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Input Background', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-focus-color', '', '' )
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Input Background - Focus', 'ark' ) ) );

				$s->addElement( ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '', '' )
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Input Border', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-focus-color', '', '' )
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Input Border - Focus', 'ark' ) ) );

				$s->addElement( ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'placeholder-color', '', '' )
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Input Placeholder', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'placeholder-focus-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Input Placeholder - Focus', 'ark' ) ) );

				$s->addElement( ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-color', '', '' )
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Input Text', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-focus-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Input Text - Focus', 'ark' ) ) );

				$s->addElement( ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'validation-message-color', '', '' )
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Validation Message Text', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _checkIfContactFormWrapperIsParent() {
		if( !$this->_getStatusHolder()->isElementInStack('contact-form-wrapper') ) {
			echo '<div class="ffb-system-error">"Form Input" element must be direct or indirect child of "Form" element, otherwise it will not work</div>';
		}
	}

	protected function _eraseUserContent() {
		return $this->_getStatusHolder()->getCustomStackCurrentValue('erase-user-content');
	}

	/**
	 * @param ffOptionsQueryDynamic $query
	 */
	protected function _getFormFieldValue( $query ) {
		if( $this->_eraseUserContent() ) {
			return null;
		}

		$method = $this->_getStatusHolder()->getCustomStackCurrentValue('form-method');//form-method
		$request = ffContainer()->getRequest();

		if( $method == 'get' ) {
			$value = $request->get( $query->get('name') );
		} else {
			$value = $request->post( $query->get('name') );
		}

		return $value;
	}

//	protected

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		$this->_checkIfContactFormWrapperIsParent();
		$this->_renderColors( $query );

		switch( $query->get('input-type') ) {
			case 'text' :
				$this->_renderText( $query );
				break;

			case 'textarea' :
				$this->_renderTextarea( $query );
				break;

			case 'checkbox' :
				$this->_renderCheckbox( $query );
				break;

			case 'radio' :
				$this->_renderRadio( $query );
				break;

			case 'select' :
				$this->_renderSelect( $query );
				break;
		}
	}

	/**
	 * @param $query ffOptionsQuery
	 */
	protected function _renderColors( $query ) {
		$bg_color_selectors = array(
			'' => 'bg-color',
			':focus' => 'bg-focus-color',
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
			'' => 'border-color',
			':focus' => 'border-focus-color',
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
			'::-moz-placeholder' => 'placeholder-color',
			':-ms-input-placeholder' => 'placeholder-color',
			'::-webkit-input-placeholder' => 'placeholder-color',
			':focus::-moz-placeholder' => 'placeholder-focus-color',
			':focus:-ms-input-placeholder' => 'placeholder-focus-color',
			':focus::-webkit-input-placeholder' => 'placeholder-focus-color',
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
			'' => 'text-color',
			':focus' => 'text-focus-color',
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

		$text_color_selectors = array(
			'.form-control + label.error' => 'validation-message-color',
			'.checkbox + label.error' => 'validation-message-color',
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


	}


	/**
	 * @param $query ffOptionsQueryDynamic
	 * @return array
	 */
	protected function _getValidationData( $query, $returnAsEscapedString = true ) {
		$dataValidation = array();

		$dataValidation['checkbox-validation'] = $query->get('checkbox-validation');
		$dataValidation['checkbox-validation-message'] = $query->get('checkbox-validation-message');

		$dataValidation['is-required'] = $query->get('is-required');
		$dataValidation['is-required-message'] = $query->get('is-required-message');

		$dataValidation['validation-type'] = $query->get('validation-type');
		$dataValidation['validation-type-regex'] = $query->get('validation-type-regex');
		$dataValidation['validation-type-custom-function'] = $query->getWithoutComparationDefault('validation-type-custom-function', '');

		$dataValidation['validation-message'] = $query->get('validation-message');

		$dataValidation['min-length-has'] = $query->get('min-length-has');
		$dataValidation['min-length'] = $query->get('min-length');
		$dataValidation['min-length-message'] = $query->get('min-length-message');

		if( $returnAsEscapedString ) {
			$dataValidationJSON = json_encode( $dataValidation );
			$dataValidationEscaped = $this->_getWPLayer()->esc_attr( $dataValidationJSON );

			return $dataValidationEscaped;
		} else {
			return $dataValidation;
		}
	}

	/*----------------------------------------------------------*/
	/* TEXT
	/*----------------------------------------------------------*/
	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	protected function _renderText( $query ) {
		$element = ffContainer()->getMultiAttrHelper();

		// input type text
		$element->setParam('type', 'text');

		// name in the message
		$element->setParam('data-name',  $query->get('name') );

		// placeholder in the text input
		$element->addParam('placeholder', $query->getWpKses('placeholder') );

		// css classes
		$element->addParam('class', 'form-control');
		$element->addParam('class', 'ff-form-input');
		$element->addParam('class', 'ff-form-input-item');

		// input type
		$element->addParam('data-input-type', 'text');

		// data validation rules
		$dataValidationRules = $this->_getValidationData( $query );
		$element->addParam('data-validation', $dataValidationRules );

		$value = $this->_getFormFieldValue( $query );

		if( $value != null ) {
			$element->addParam('value', $value);
		}

		echo '<input ' . $element->getAttrString() . '>';
	}

	/*----------------------------------------------------------*/
	/* TEXTAREA
	/*----------------------------------------------------------*/
	/**
	 * @param $query ffOptionsQuery
	 */
	protected function _renderTextarea( $query ) {
		$element = ffContainer()->getMultiAttrHelper();

		// input type text
		$element->setParam('type', 'text');

		// name in the message
		$element->setParam('data-name',  $query->get('name') );

		// placeholder in the text input
		$element->addParam('placeholder', $query->getWpKses('placeholder') );

		// css classes
		$element->addParam('class', 'form-control');
		$element->addParam('class', 'ff-form-input');
		$element->addParam('class', 'ff-form-input-item');

		// input type
		$element->addParam('data-input-type', 'textarea');

		$element->addParam('rows', $query->get('rows') );

		// data validation rules
		$dataValidationRules = $this->_getValidationData( $query );
		$element->addParam('data-validation', $dataValidationRules );

		$value = $this->_getFormFieldValue( $query );

		echo '<textarea ' . $element->getAttrString() . '>'.$value.'</textarea>';
	}

	/*----------------------------------------------------------*/
	/* CHECKBOX
	/*----------------------------------------------------------*/
	/**
	 * @param $query ffOptionsQuery
	 */
	protected function _renderCheckbox( $query ) {
		$element = ffContainer()->getMultiAttrHelper();

		// input type text
		$element->setParam('type', 'checkbox');

		// name in the message
		$name = $query->get('name');
//		ffContainer()->getWPLayer()-

		$element->setParam('data-name',  $name );


		// value
		$element->addParam('value', '[1]' );

		// css classes
		$element->addParam('class', 'ff-form-input');
		$element->addParam('class', 'ff-form-input-item');



		$element->setParam('data-checked', '0');
		if( $query->get('checkbox-selected') ) {
			$element->addParam('checked', 'checked');
			$element->setParam('data-checked', '1');
		}
//
		$value = $this->_getFormFieldValue( $query );
		if( $value != null ) {
			$element->setParam('data-checked', $value);

			if( (int)$value == 1 ) {
				$element->setParam('checked', 'checked');
			} else {
				$element->removeParam('checked');
			}
		}


		// input type
		$element->addParam('data-input-type', 'checkbox');

		// data validation rules
		$dataValidationRules = $this->_getValidationData( $query );
		$element->addParam('data-validation', $dataValidationRules );

		echo '<div class="checkbox ff-form-checkbox-wrapper"><label><input ' . $element->getAttrString() . '> '. $query->getWpKses('label') . '</label></div>';
	}

	/*----------------------------------------------------------*/
	/* RADIO
	/*----------------------------------------------------------*/
	/**
	 * @param $query ffOptionsQuery
	 */
	protected function _renderRadio( $query ) {
		if ( $query->exists('repeated-lines') ) {

			$atLeastOneThingIsSelected = false;
			foreach( $query->getWithoutCallbacks('repeated-lines') as $oneOption ) {
				if( $oneOption->get('selected') ) {
					$atLeastOneThingIsSelected = true;
					break;
				}
			}

			$userValue = $this->_getFormFieldValue( $query );

			$oneThingHasBeenSelected = false;

			echo '<div class="radio-wrapper ff-form-input-item" data-input-type="radio" data-name="'.$query->get('name').'">';

				foreach( $query->get('repeated-lines') as $oneOption ) {
					$isChecked = false;

					if( $atLeastOneThingIsSelected && !$oneThingHasBeenSelected ) {
						$isChecked = $oneOption->get('selected');
					} else if( !$atLeastOneThingIsSelected && !$oneThingHasBeenSelected ) {
						$isChecked = true;
					}

					$value = $oneOption->getWithoutComparationDefault('option-value', '');

					if( empty( $value ) ) {
						$value = $oneOption->getWpKses('value');
					}

					if( $userValue != null ) {
						if( $userValue == $value ) {
							$isChecked = true;
						} else {
							$isChecked = false;
						}
					}

					if( $isChecked ) {
						$oneThingHasBeenSelected = true;
					}

					$isCheckedString = $isChecked ? 'checked' : '';
					$isCheckedDataAttr = $isChecked ? 'data-checked="1"' : '';



					echo '<div class="radio">';
					
						echo '<label class="ff-form-input-radio-label">';

							echo '<input type="radio" '.$isCheckedDataAttr.' class="ff-form-input-radio" value="' . $this->_getWPLayer()->esc_attr($value) . '" '.$isCheckedString.'>';

							$oneOption->printWpKses('value');

						echo '</label>';

					echo '</div>';
				}

			echo '</div>';

		}
	}

	/*----------------------------------------------------------*/
	/* SELECT
	/*----------------------------------------------------------*/
	/**
	 * @param $query ffOptionsQuery
	 */
	protected function _renderSelect( $query ) {
		if ( !$query->exists('repeated-lines') ) {
			return;
		}

		$element = ffContainer()->getMultiAttrHelper();

		$element->addParam('class', 'ff-form-input');
		$element->addParam('class', 'ff-form-input-item');
		$element->addParam('class', 'ff-form-input-select');
		$element->addParam('class', 'form-control');

		// input type
		$element->addParam('data-input-type', 'select');

		$element->addParam('data-name', $query->get('name') );

		$userValue = $this->_getFormFieldValue( $query );

		echo '<select ' . $element->getAttrString() . '>';

			foreach( $query->getWithoutCallbacks( 'repeated-lines') as $oneOption ) {
				$oneOptionElement = ffContainer()->getMultiAttrHelper();
				$oneOptionElement->setTag('option');

				$value = $oneOption->getWithoutComparationDefault('option-value', '');

				if( empty( $value ) ) {
					$value = $oneOption->getWpKses('value');
				}

				$oneOptionElement->setParam('value', $value );

				if( $oneOption->get('selected') ) {
					$oneOptionElement->setParam('selected', 'selected');
				}

				if( $userValue != null ) {
					$oneOptionElement->removeParam('selected');
					if( $userValue == $value ) {
						$oneOptionElement->setParam('selected', 'selected');
					}
				}

				$oneOptionElement->setContent( $oneOption->getWpKses('value') );

				// Escaped inner part of select
				echo ( $oneOptionElement->getElement() );
			}

		echo '</select>';
	}



	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element ) {

				query.addHeadingLg('placeholder' );
				query.addHeadingSm('name', '');

			}
		</script data-type="ffscript">
	<?php
	}


}