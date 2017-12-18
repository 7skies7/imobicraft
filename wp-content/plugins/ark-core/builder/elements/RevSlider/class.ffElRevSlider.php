<?php
/** @link http://demo.freshface.net/html/h-ark/HTML/premium/rev-slider/carousel-media.html.wpmod.html */

class ffElRevSlider extends ffThemeBuilderElementBasic {
	protected function _initData(){
		$this->_setData(ffThemeBuilderElement::DATA_ID, 'revslider');
		$this->_setData(ffThemeBuilderElement::DATA_NAME, esc_attr( __('Revolution Slider', 'ark' ) ) );
		$this->_setData(ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData(ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		$this->_setData(ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

		$this->_setData(ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'revslider');
		$this->_setData(ffThemeBuilderElement::DATA_PICKER_TAGS, 'revslider, slider, revolution slider, plugins');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);


		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions($s) {

		$s->addElement(ffOneElement::TYPE_TABLE_START);
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Warning', 'ark' ) ) );
				$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', '<p class="warning">'.ark_wp_kses( __('Keep on mind, that Revolution Slider plugin must be active for using this element','ark') ) . '</p>' );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);
		$s->addElement(ffOneElement::TYPE_TABLE_END);

		$s->addElement(ffOneElement::TYPE_TABLE_START);
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Select Slider', 'ark') ) );
				 $s->addOption( ffOneOption::TYPE_REVOLUTION_SLIDER, 'slider', '', '');
//				$s->addOption( ffOneOption::TYPE_TEXT, 'slider', '', '' )
//					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Slider Alias', 'ark' ) ) );
				$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses( __('You can find your slider alias in <code>Revolution Slider Admin -> Select Slider -> Slider Settings > Slider Alias</code>', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);
		$s->addElement(ffOneElement::TYPE_TABLE_END);
	}

	protected function _render(ffOptionsQueryDynamic $query, $content, $data, $uniqueId) {

		echo '<section class="ffb-revolution-slider">';

			if( ! defined('RS_PLUGIN_PATH') ){
				echo "<!--\n\n\n\n\n\n";
				echo ark_wp_kses( __('The Revolution Slider element has been disabled, because Revolution Slider plugin is not installed and/or activated. Please install and activate the Revolution Slider plugin in order to use this element.','ark') );
				echo '</section>';
				echo "\n\n\n\n\n\n-->";
				return;
			}

			if( function_exists('putRevSlider') ) {
				putRevSlider($query->get('slider'));
			}

		echo '</section>';
	}


	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				query.addHeadingLg('slider');

			}
		</script data-type="ffscript">
	<?php
	}


}