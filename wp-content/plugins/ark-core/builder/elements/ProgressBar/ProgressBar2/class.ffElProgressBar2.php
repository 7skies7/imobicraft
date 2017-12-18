<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/one-page/one-page-business/index_profile_2.html#scrollTo__1000
 */

class ffElProgressBar2 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'progress-bar-2');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Progress Bar 2', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'progress-bar');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'progress bar');

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Value', 'ark' ) ) );
				$s->startAdvancedToggleBox('value', esc_attr( __('Value', 'ark' ) ) );

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', '75')
						->addParam('print-in-content', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Number (integer between 0 and 100)', 'ark' ) ) );

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'unit', '', '%')
						->addParam('print-in-content', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Unit', 'ark' ) ) );

				$s->endAdvancedToggleBox();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Title', 'ark' ) ) );
				$s->startAdvancedToggleBox('title', esc_attr( __('Title', 'ark' ) ) );
					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Designing')
						->addParam('print-in-content', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
					;
					$s->addOptionNL( ffOneOption::TYPE_SELECT, 'font', '', '')
						->addSelectValue( esc_attr( __('Normal', 'ark' ) ), 'font-style-inherit')
						->addSelectValue( esc_attr( __('Cursive', 'ark' ) ), '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Font style', 'ark' ) ) )
					;
				$s->endAdvancedToggleBox();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Design', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'style', '', 'xs')
					->addSelectValue( esc_attr( __('Large', 'ark' ) ), 'lg')
					->addSelectValue( esc_attr( __('Medium', 'ark' ) ), 'md')
					->addSelectValue( esc_attr( __('Small', 'ark' ) ), 'sm')
					->addSelectValue( esc_attr( __('Extra small', 'ark' ) ), 'xs')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Bar Height', 'ark' ) ) )
					;

				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'use-radius', ark_wp_kses( __('Apply border radius on the bar', 'ark' ) ), 0);
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'value-color', '', '[1]')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Value', 'ark' ) ) )
				;

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'progressbar-color', '', '[1]')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Bar Foreground', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '#f2f4f9')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Bar Background', 'ark' ) ) )
				;
				$s->addElement(ffOneElement::TYPE_NEW_LINE);
				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'use-stripped', ark_wp_kses( __('Apply "stripped" effect on the Bar', 'ark' ) ), 0);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

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



		echo '<section class="progress-box progress-box-v2">';

			$stripped = '';
			if( $query->get('use-stripped') ){
				$stripped = 'progress-bar-striped';
			}

			ffElProgressBar2::_renderColor( $query->getColor('value-color'), 'color', '.progress-box-v2-figure' );

			$this->_advancedToggleBoxStart( $query->get('value') );
				echo '<figure class="progress-box-v2-figure">';
					echo '<span class="counter">'. $query->getWpKses('value text') .'</span>'. $query->getWpKses('value unit');
				echo '</figure>';
			$this->_advancedToggleBoxEnd( $query->get('value') );

			$this->_advancedToggleBoxStart( $query->get('title') );
				echo '<h4 class="progress-title '. $query->getEscAttr('title font') .'">'. $query->getWpKses('title text') .'</h4>';
			$this->_advancedToggleBoxEnd( $query->get('title') );

			ffElProgressBar2::_renderColor( $query->getColor('bg-color'), 'background-color', '.progress' );

			echo ' <div class="progress radius-'. $query->getEscAttr('use-radius') .' progress-'. $query->getEscAttr('style') .'">';

				ffElProgressBar2::_renderColor( $query->getColor('progressbar-color'), 'background-color', '.progress-bar' );

				echo '<div class="progress-bar '. $stripped .'" role="progressbar" data-width="'. $query->getEscAttr('value text') .'"></div>';
			echo '</div>';


		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, preview ) {

				var value = query.get('value text');
				var unit = query.get('value unit');

				query.addHeadingLg(null, value, unit);
				query.addHeadingSm( 'title text' );

			}
		</script data-type="ffscript">
	<?php
	}


}