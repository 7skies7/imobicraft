<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_alerts.html#scrollTo__650
 */

class ffElAlert9 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'alert-9');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Alert 9', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'alert');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'alert, alertbox');

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Icon', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 fa-check')
					->addParam('print-in-content', true)
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-bg-color', '', '#009688')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Background Color', 'ark' ) ) )
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE TITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Well done!&nbsp;')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color', '', '#009688')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text Color', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE DESCRIPTION
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('description', ark_wp_kses( __('Description', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', ' You successfully read this important alert message.')
							->addParam('print-in-content', true)
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color', '', '#606060')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text Color', 'ark' ) ) )
						;
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$this->_getElementGeneralOptionsTextAlignClasses( $s, 'align', 'text-left' );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Close Button Settings', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'close-char', '', '&times;')
					->addParam('print-in-content', true)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, '&times; '.ark_wp_kses( __('Close Button Character', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'sr-text', '', 'Close')
					->addParam('print-in-content', true)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Hidden Screen Reader Text', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'close-color', '', '#000000')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text Color', 'ark' ) ) )
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Alert Box Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background', 'ark' ) ) )
				;

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '', '#ebeef6')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border', 'ark' ) ) )
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _renderColor( $query, $cssAttribute, $selector = null ) {

		if( $query && $selector ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector($selector)
				->addParamsString( $cssAttribute .': '. $query .';');;
		} else if( $query ){
			$this->getAssetsRenderer()->createCssRule()
				->addParamsString( $cssAttribute .': '. $query .';');
		}

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$this->_renderColor( $query->getColor('bg-color'), 'background-color' );
		$this->_renderColor( $query->getColor('border-color'), 'border-color' );

		echo '<section class="alert alert-v2 alert-box-general '
			. esc_attr( $this->_getGeneralTextAlignClasses( $query, 'align', 'text-left' ) )
			. '" role="alert">';

			$this->_renderColor( $query->getColor('close-color'), 'color', '.close');

			echo '<button type="button" class="close" data-dismiss="alert">';
				echo '<span aria-hidden="true">'. $query->getWpKses('close-char') .'</span>';
				echo '<span class="sr-only">'. $query->getWpKses('sr-text') .'</span>';
			echo '</button>';

			echo '<div class="theme-icons-wrap">';
				$this->_renderColor( $query->getColor('icon-bg-color'), 'background-color', '.theme-icons-red-bg');
				$this->_renderColor( $query->getColor('icon-color'), 'color', '.theme-icons-red-bg');

				echo '<i class="alert-box-element theme-icons theme-icons-red-bg theme-icons-md radius-circle '. $query->getEscAttr('icon') .'"></i>';
			echo '</div>';

			if( $query->exists('content') ){
				echo '<div class="alert-box-body">';

					foreach( $query->get('content') as $oneItem ) {
						switch ($oneItem->getVariationType()) {

							case 'title':
								$this->_renderColor( $oneItem->getColor('color'), 'color' );

								echo '<span class="alert-box-title">'. $oneItem->getWpKses('text') .'</span>';
								break;

							case 'description':
								$rule = $this->getAssetsRenderer()->createCssRule();
								$currentDescriptionCssClass = ' .' . $rule->removeSelectorFromScopeAndReturnIt();
								$rule->addSelector(' .alert-box-body', false);
								$rule->addSelector( $currentDescriptionCssClass, false );
								$rule->addParamsString( 'color' . ':' . $oneItem->getColor('color')  . ';');

								$rule = $this->getAssetsRenderer()->createCssRule();
								$currentDescriptionCssClass = ' .' . $rule->removeSelectorFromScopeAndReturnIt();
								$rule->addSelector(' .alert-box-body', false);
								$rule->addSelector( $currentDescriptionCssClass, false );
								$rule->setAddWhiteSpaceBetweenSelectors( false );
								$rule->addSelector('p', false);
								$rule->addParamsString( 'color' . ':' . $oneItem->getColor('color')  . ';');

								$oneItem->printWpKsesTextarea('text', '<p class="alert-box-paragraph">', '</p>', '<div class="alert-box-paragraph ff-richtext">', '</div>');
								break;

						}
					}

				echo '</div>';
			}

		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, preview ) {

				query.addIcon( 'icon' );

				if(query.queryExists('content')) {
					query.get('content').each(function(query, variationType ){
						switch(variationType){
							case 'title':
								query.addHeadingLg( 'text' );
								break;
							case 'description':
								query.addText( 'text' );
								break;

						}
					});
				}
				

			}
		</script data-type="ffscript">
	<?php
	}


}