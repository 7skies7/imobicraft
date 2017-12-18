<?php

/**
 * @link
 */

class ffElScrollTo extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'scrollto');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Scroll To Button', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'basic');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'scroll, down, scrollto, to, arrow, jump');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Info', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('We recommend placing this element as a direct child of a Column element in order to work properly. If that is not an option for you then please keep in mind that this element will be positioned relative to the closest wrapper that has it\'s position set to relative/absolute.', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					$s->startRepVariationSection('one-icon', ark_wp_kses( __('Icon', 'ark' ) ) );

						$s->addOptionNL(ffOneOption::TYPE_ICON,'icon',ark_wp_kses( __('Icon', 'ark' ) ),'ff-font-awesome4 icon-angle-double-down');

					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Link', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'link','', '#')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('ID of the Element that you want to scroll to', 'ark' ) ) );
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('Do not forget the <code>#</code> symbol before the ID string, for example <code>#services</code>', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Animation', 'ark' ) ) );

				$s->addOptionNL(ffOneOption::TYPE_SELECT,'scrollto-anim','','ffb-scrollto-anim-bounce')
					->addSelectValue('Bounce','ffb-scrollto-anim-bounce')
					->addSelectValue('No Animation','ffb-scrollto-anim-none')
				;

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		$s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		echo '<a href="'.$query->get('link').'" class="ffb-scrollto-link ffb-scrollto '.$query->get('scrollto-anim').'">';

			if( $query->exists('content') ) {

				foreach( $query->get('content') as $oneItem ) {
					switch( $oneItem->getVariationType() ) {

						case 'one-icon':
							echo '<i class="ffb-scrollto-icon '.$oneItem->get('icon').'"></i>';
							break;

					}
					
				}
			}

		echo '</a>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $slementPreview, $slement ) {

				if(query.queryExists('content')) {
					query.get('content').each(function(query, variationType ){
						switch(variationType){
							case 'one-icon':
								query.addIcon( 'icon' );
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}