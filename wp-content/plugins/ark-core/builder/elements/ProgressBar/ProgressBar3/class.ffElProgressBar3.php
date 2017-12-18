<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_vertical_progress_bar.html#scrollTo__397
 */

class ffElProgressBar3 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'progress-bar-3');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Progress Bar 3', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'progress-bar');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'progress bar');

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Title', 'ark' ) ) );
				$s->startAdvancedToggleBox('title', esc_attr( __('Title', 'ark' ) ) );
					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'HTML/CSS')
						->addParam('print-in-content', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
					;
				$s->endAdvancedToggleBox();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Value', 'ark' ) ) );
				$s->startAdvancedToggleBox('value', esc_attr( __('Value', 'ark' ) ) );
					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', '92')
						->addParam('print-in-content', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Number (integer between 0 and 100)', 'ark' ) ) )
					;
					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'unit', '', '%')
						->addParam('print-in-content', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Unit', 'ark' ) ) )
					;
				$s->endAdvancedToggleBox();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Labels Alignment', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'align', '', 'text-center')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'text-left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'text-center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'text-right')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Progress Bar Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'progressbar-color', '', '[1]')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Bar Foreground', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '#f2f4f9')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Bar Background', 'ark' ) ) )
				;
				$s->addElement(ffOneElement::TYPE_NEW_LINE);
				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'use-stripped', ark_wp_kses( __('Apply "stripped" effect on the Bar', 'ark' ) ), 1)
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

	protected function _enqueueScriptsAndStyles( $query ) {
		wp_enqueue_script( 'ark-progress-bar' );
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		

		echo '<section class="progress-box progress-box-v3 '. $query->getEscAttr('align') .'">';

			$stripped = '';
			if( $query->get('use-stripped') ){
				$stripped = 'progress-bar-striped';
			}

			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.progress')
				->addParamsString('background-color: '. $query->getColor('bg-color') .';');

			echo '<div class="progress progress-vertical radius-0">';

				$this->getAssetsRenderer()->createCssRule()
					->addSelector('.progress-bar')
					->addParamsString('background-color: '. $query->getColor('progressbar-color') .';');

				echo '<div class="progress-bar '. $stripped .'" role="progressbar" data-height="'. $query->getEscAttr('value text') .'"></div>';
			echo '</div>';

			$this->_advancedToggleBoxStart( $query->get('title') );
				echo '<h2 class="progress-box-v3-title">'. $query->getWpKses('title text') .'</h2>';
			$this->_advancedToggleBoxEnd( $query->get('title') );

			$this->_advancedToggleBoxStart( $query->get('value') );
				echo '<span class="progress-box-number">'. $query->getWpKses('value text') . $query->getWpKses('value unit') .'</span>';
			$this->_advancedToggleBoxEnd( $query->get('value') );

		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, preview ) {

				var value = query.get('value text');
				var unit = query.get('value unit');

				query.addHeadingLg( 'title text' );
				query.addHeadingSm(null, value, unit);

			}
		</script data-type="ffscript">
	<?php
	}


}