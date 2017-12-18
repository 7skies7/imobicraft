<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/index_landing_2.html#scrollTo__450
 */

class ffElCallToAction4 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'call-to-action-4');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Call To Action 4', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'cta');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'call to action, sales');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE TITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Ark Studio')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'title-color', '', '#ffffff')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Title Color', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'title-bg-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Title Background Color', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE DESCRIPTION
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('description', ark_wp_kses( __('Paragraph	', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Learn how to improve your customer service with')
							->addParam('print-in-content', true)
						;

						$s->startAdvancedToggleBox('b-text', esc_attr( __('Bold Text', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Ark')
								->addParam('print-in-content', true)
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
							;
						$s->endAdvancedToggleBox();

					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE LINK
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('link', ark_wp_kses( __('Link', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Register Now')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );

						$this->_getBlock( ffThemeBuilderBlock::LINK)->injectOptions( $s );

						$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 icon-angle-double-right')
							->addParam('print-in-content', true)
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'link-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Link Color', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'link-icon-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Link Icon Color', 'ark' ) ) )
						;
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$this->_getElementGeneralOptionsTextAlignClasses( $s, 'items-alignment', 'text-center' );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _renderColor( $query, $cssAttribute, $selector = null, $useDot = null ) {

		if( $query && $selector ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector($selector, $useDot)
				->addParamsString( $cssAttribute .': '. $query .';');
		} else if( $query ){
			$this->getAssetsRenderer()->createCssRule()
				->addParamsString( $cssAttribute .': '. $query .';');
		}

	}


	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}
		echo '<section class="call-to-action-v3 '
			. esc_attr( $this->_getGeneralTextAlignClasses( $query, 'items-alignment', 'text-center' ) )
			. '">';
			echo '<div class="center-content-hor-wrap-sm">';

			foreach( $query->get('content') as $oneLine ) {
				switch( $oneLine->getVariationType() ) {

					case 'title':

						ffElCallToAction4::_renderColor( $oneLine->getColor('title-bg-color'), 'background-color' );
						ffElCallToAction4::_renderColor( $oneLine->getColor('title-color'), 'color' );

						echo '<label class="badge call-to-action-badge radius-3">'. $oneLine->getWpKses('text') .'</label>';
						break;

					case 'description':
						echo '<span class="call-to-action-v3-text">'. $oneLine->getWpKses('text') . '&nbsp;';

							$this->_advancedToggleBoxStart( $oneLine->get('b-text') );
								echo '<span class="call-to-action-text-bold">'. $oneLine->getWpKses('b-text text') .'</span>';
							$this->_advancedToggleBoxEnd( $oneLine->get('b-text') );

						echo '</span>';
						break;

					case 'link':

						ffElCallToAction4::_renderColor( $oneLine->getColor('link-color'), 'color' );
						ffElCallToAction4::_renderColor( $oneLine->getColor('link-icon-color'), 'color', 'i' );
						echo '<a ';
							$this->_getBlock( ffThemeBuilderBlock::LINK )->setParam('classes', 'call-to-action-v3-link')->render( $oneLine );
						echo '>'. $oneLine->getWpKses('text') .'&nbsp;<i class="'. $oneLine->getEscAttr('icon') .'"></i></a>';

						break;

				}
			}

			echo '</div>';
		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, preview ) {

				if(query.queryExists('content')) {
					query.get('content').each(function(query, variationType ){
						switch(variationType){
							case 'title':
								query.addHeadingLg( 'text' );
								break;
							case 'description':
								var text = query.get('text');
								text += ' ';
								var bText = query.get('b-text text');
								query.addText(null, text, bText);
								break;
							case 'link':
								query.addLink( 'text' );
								break;
						}
					});
				}
				

			}
		</script data-type="ffscript">
	<?php
	}


}