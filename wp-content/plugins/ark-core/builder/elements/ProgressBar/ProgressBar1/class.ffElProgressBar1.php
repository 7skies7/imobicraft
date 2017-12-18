<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_about_us_classic.html#scrollTo__2300
 * @link http://demo.freshface.net/html/h-ark/HTML/page_services_classic.html#scrollTo__2442
 */

class ffElProgressBar1 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'progress-bar-1');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Progress Bar 1', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'progress-bar');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'progress bar');

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Value', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'value', '', '83')
					->addParam('print-in-content', true)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Number (integer between 0 and 100)', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'unit', '', '%')
					->addParam('print-in-content', true)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Unit', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Title', 'ark' ) ) );
				$s->startAdvancedToggleBox('title', esc_attr( __('Title', 'ark' ) ) );

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Photoshop')
						->addParam('print-in-content', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
					;
					$s->addOptionNL( ffOneOption::TYPE_SELECT, 'font', '', 'font-style-inherit')
						->addSelectValue( esc_attr( __('Normal', 'ark' ) ), 'font-style-inherit')
						->addSelectValue( esc_attr( __('Cursive', 'ark' ) ), '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Font style', 'ark' ) ) )
					;
					$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'use-right-side', ark_wp_kses( __('Move Value closer to the Title', 'ark' ) ), 0)
					;

				$s->endAdvancedToggleBox();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Design', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'style', '', 'sm')
					->addSelectValue( esc_attr( __('Large', 'ark' ) ), 'lg')
					->addSelectValue( esc_attr( __('Medium', 'ark' ) ), 'md')
					->addSelectValue( esc_attr( __('Small', 'ark' ) ), 'sm')
					->addSelectValue( esc_attr( __('Extra small', 'ark' ) ), 'xs')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Bar Height', 'ark' ) ) );

				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'use-radius', ark_wp_kses( __('Apply border radius on the bar', 'ark' ) ), 0);
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'progressbar-color', '', '[1]')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Bar', 'ark' ) ) )
				;

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '#f2f4f9')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Bar background', 'ark' ) ) )
				;
				$s->addElement(ffOneElement::TYPE_NEW_LINE);
				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'use-stripped', ark_wp_kses( __('Apply "stripped" effect on the Bar', 'ark' ) ), 0);

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



		echo '<section class="progress-box progress-box-v1">';

			$stripped = '';
			if( $query->get('use-stripped') ){
				$stripped = 'progress-bar-striped';
			}

			$this->_advancedToggleBoxStart( $query->get('title') );
				echo '<h4 class="progress-title '. $query->getEscAttr('title font') .'">'. $query->getWpKses('title text') .'&nbsp;';

					if( $query->get('title use-right-side') ) {
						echo ' - '. $query->getWpKses('value') . $query->getWpKses('unit');
					} else {
						echo '<span class="pull-right">'. $query->getWpKses('value') . $query->getWpKses('unit') .'</span>';
					}

				echo '</h4>';
			$this->_advancedToggleBoxEnd( $query->get('title') );

			ffElProgressBar1::_renderColor( $query->getColor('bg-color'), 'background-color', '.progress' );

			echo ' <div class="progress radius-'. $query->getEscAttr('use-radius') .' progress-'. $query->getEscAttr('style') .'">';
				ffElProgressBar1::_renderColor( $query->getColor('progressbar-color'), 'background-color', '.progress-bar' );

				echo '<div class="progress-bar '. $stripped .'" role="progressbar" data-width="'. $query->getEscAttr('value') .'"></div>';
			echo '</div>';

		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, preview ) {

				var value = query.get('value');
				var unit = query.get('unit');

				query.addHeadingLg( 'title text' );
				query.addHeadingSm(null, value, unit);

			}
		</script data-type="ffscript">
	<?php
	}


}