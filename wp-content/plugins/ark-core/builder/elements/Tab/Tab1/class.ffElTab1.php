<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_services_modern.html#scrollTo__1250
 */

class ffElTab1 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'tab-1');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Tabs 1', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'tab');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'tabs, tab');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('dark');
	}

	protected function _getDefaultColor($name){
		switch($name){
			case 'header-bg-color': return '#ffffff';
			case 'tab-bg-color': return '#ffffff';
			case 'tab-bg-color-hover': return '#ffffff';

			case 'tab-text-color': return '#34343c';
			case 'tab-text-color-hover': return '[1]';

			case 'content-bg-color': return '#ffffff';
			case 'content-text-color': return '#606060';
			case 'content-link-text-color': return '[1]';
			case 'content-link-text-color-hover': return '[1]';
		}
		return '';
	}

	protected function _getTextColorSelectors(){
		return array(
			'.nav.nav-tabs > li > a' => 'tab-text-color',

			'.nav.nav-tabs > li > a:hover' => 'tab-text-color-hover',
			'.nav.nav-tabs > li.active > a' => 'tab-text-color-hover',

			'.tab-content .tab-pane' => 'content-text-color',
			'.tab-content .tab-pane p' => 'content-text-color',
			'.tab-content .tab-pane a' => 'content-link-text-color',
			'.tab-content .tab-pane a:hover' => 'content-link-text-color-hover',
		);
	}

	protected function _getBGColorSelectors(){
		return array(
			'.nav-wrapper' => 'header-bg-color',

			'.nav.nav-tabs > li > a' => 'tab-bg-color',
			'.nav.nav-tabs > li a:hover' => 'tab-bg-color-hover',
			'.nav.nav-tabs > li.active a' => 'tab-bg-color-hover',

			'.tab-content .tab-pane' => 'content-bg-color',
		);
	}

	protected function _getElementColorOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Title Colors', 'ark' ) ) );

			$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'header-bg-color', '' , $this->_getDefaultColor('header-bg-color'))
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background - Tab Wrapper', 'ark' ) ) );

			$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'tab-bg-color', '' , $this->_getDefaultColor('tab-bg-color'))
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background - Inactive Tab', 'ark' ) ) );

			$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'tab-bg-color-hover', '' , $this->_getDefaultColor('tab-bg-color-hover'))
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background - Active Tab', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_NEW_LINE);

			$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'tab-text-color', '' , $this->_getDefaultColor('tab-text-color'))
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text - Inactive Tab', 'ark' ) ) );

			$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'tab-text-color-hover', '' , $this->_getDefaultColor('tab-text-color-hover'))
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text - Active Tab', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_NEW_LINE);

			$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'header-shadow', '' , 'rgba(0,0,0,0.07)')
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Box Shadow', 'ark' ) ) );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Colors', 'ark' ) ) );

			$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-bg-color', '' , $this->_getDefaultColor('content-bg-color'))
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_NEW_LINE);

			$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-text-color', '' , $this->_getDefaultColor('content-text-color'))
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_NEW_LINE);

			$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-link-text-color', '' , $this->_getDefaultColor('content-link-text-color'))
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Link', 'ark' ) ) );

			$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-link-text-color-hover', '' , $this->_getDefaultColor('content-link-text-color-hover'))
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Link Hover', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_NEW_LINE);

			$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-shadow', '' , 'rgba(0,0,0,0.07)')
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Box Shadow', 'ark' ) ) );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Tabs', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE TAB
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('accordion', ark_wp_kses( __('Tab', 'ark' ) ) );

						$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'is-active', ark_wp_kses( __('Is opened by default', 'ark' ) ), 0);
						$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('You can only activate this option on one of the tabs.', 'ark' ) ) ) ;
						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->startAdvancedToggleBox('title', esc_attr( __('Title', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'title', '', 'Section 1')
								->addParam('print-in-content', true);
						$s->endAdvancedToggleBox();

						$s->startAdvancedToggleBox('content', esc_attr( __('Content', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'content', '', ark_wp_kses( __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus maximus gravida efficitur. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Mauris lacinia tristique sapien, sed ornare arcu rhoncus in.', 'ark' ) ) )
								->addParam('print-in-content', true);
						$s->endAdvancedToggleBox();

					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$s->addOption( ffOneOption::TYPE_SELECT, 'text-alignment', '', 'text-left')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'text-left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'text-center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'text-right');
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Space Gap', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'mb', '', '')
					->addParam('print-in-content', true)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Space gap between the tabs and their content (in px)', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('Leave blank for default spacing', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$this->_getElementColorOptions($s);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		$this->_renderBasicElement($query, $content, $data, $uniqueId, 'nav nav-tabs', 'tab-pane fade', 1);
	}


	protected function _getActiveTabIndex(ffOptionsQueryDynamic $query){
		$active_key = 0;

		foreach( $query->getWithoutCallbacks('content') as $key => $oneLine ) {
			if( $oneLine->get('is-active')){
				$active_key = $key;
				break;
			}
		}

		return $active_key;
	}

	protected function _createCssColorsRules(ffOptionsQueryDynamic $query) {

		foreach( $this->_getTextColorSelectors() as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->addSelector($selector)
					->addParamsString('color:' . $color . ';');
			}
		}

		foreach( $this->_getBGColorSelectors() as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->addSelector($selector)
					->addParamsString('background-color:' . $color . ';');
			}
		}
	}

	protected function _renderBasicElement( ffOptionsQueryDynamic $query, $content, $data, $uniqueId, $tabClass, $contentClass, $tabNumber ) {
		if( ! $query->exists('content') ) {
			return;
		}

		if ( 1 == $tabNumber ){

			$box_shadow_selectors = array(
				' .tab-v1 .nav-wrapper' => 'header-shadow',
				' .tab-v1 .tab-pane' => 'content-shadow',
			);

			foreach( $box_shadow_selectors as $selector => $c ){
				$color = $query->getColor( $c );
				if( $color ) {
					$this->getAssetsRenderer()->createCssRule()
						->setAddWhiteSpaceBetweenSelectors(false)
						->addSelector($selector, false)
						->addParamsString('box-shadow: 1px 2px 7px 0 ' . $color . ';');
				}
			}

		}

		if ( 2 == $tabNumber ){

			$border_selectors = array(
				' .tab-v2 .nav-tabs > li > a' => 'tab-border-color',
				' .tab-v2 .nav-tabs > li:hover > a' => 'tab-border-hover-color',
				' .tab-v2 .nav-tabs > li.active > a' => 'tab-border-active-color',
			);

			foreach( $border_selectors as $selector => $c ){
				$color = $query->getColor( $c );
				if( $color ) {
					$this->getAssetsRenderer()->createCssRule()
						->setAddWhiteSpaceBetweenSelectors(false)
						->addSelector($selector, false)
						->addParamsString('border-bottom: 1px solid ' . $color . ';');
				}
			}

		}

		if ( 5 == $tabNumber ){

			$bg_selectors = array(
				' .tab-v5' => 'wrapper-bg-color',
			);

			foreach( $bg_selectors as $selector => $c ){
				$color = $query->getColor( $c );
				if( $color ) {
					$this->getAssetsRenderer()->createCssRule()
						->setAddWhiteSpaceBetweenSelectors(false)
						->addSelector($selector, false)
						->addParamsString('background-color: ' . $color . ';');
				}
			}

			$border_selectors = array(
				' .tab-v5' => 'wrapper-border-color',
			);

			foreach( $border_selectors as $selector => $c ){
				$color = $query->getColor( $c );
				if( $color ) {
					$this->getAssetsRenderer()->createCssRule()
						->setAddWhiteSpaceBetweenSelectors(false)
						->addSelector($selector, false)
						->addParamsString('border: 1px solid ' . $color . ';');
				}
			}

		}

		if ( 6 == $tabNumber ){

			$bg_selectors = array(
				' .tab-v6' => 'wrapper-bg-color',
			);

			foreach( $bg_selectors as $selector => $c ){
				$color = $query->getColor( $c );
				if( $color ) {
					$this->getAssetsRenderer()->createCssRule()
						->setAddWhiteSpaceBetweenSelectors(false)
						->addSelector($selector, false)
						->addParamsString('background-color: ' . $color . ';');
				}
			}

			$border_selectors = array(
				' .tab-v6' => 'wrapper-border-color',
			);

			foreach( $border_selectors as $selector => $c ){
				$color = $query->getColor( $c );
				if( $color ) {
					$this->getAssetsRenderer()->createCssRule()
						->setAddWhiteSpaceBetweenSelectors(false)
						->addSelector($selector, false)
						->addParamsString('border: 1px solid ' . $color . ';');
				}
			}

		}

		$tab = $tabNumber;
		$tClass = $tabClass;
		$cClass = $contentClass;

		$active_key = $this->_getActiveTabIndex($query);

		$this->_createCssColorsRules($query);

		if ( 7 != $tabNumber ){

			$mb = $query->get('mb');
			if (!empty($mb) or (0 === $mb) or ('0' === $mb)) {
				if( in_array( $tab, array(5) ) ){
					$this->getAssetsRenderer()->createCssRule()
						->addSelector('.tab-content>.tab-pane')
						->addParamsString('margin-left:' . $mb . 'px;');
				} else if ( in_array( $tab, array(6) ) ){
					$this->getAssetsRenderer()->createCssRule()
						->addSelector('.tab-content>.tab-pane')
						->addParamsString('margin-right:' . $mb . 'px;');					
				} else {
					$this->getAssetsRenderer()->createCssRule()
						->addSelector('.nav-wrapper')
						->addParamsString('margin-bottom:' . $mb . 'px;');
				}
			}

		}

		echo '<section class="'. $query->getEscAttr('text-alignment') .'">';
			echo '<div class="tab-v'.$tab.'">';

				echo '<div class="nav-wrapper">';
					echo '<ul class="'.$tClass.'" role="tablist">';
						foreach( $query->get('content') as $key => $oneLine ) {

							$activeClass = '';
							if( $key == $active_key ){
								$activeClass = 'class="active"';
							}

							echo '<li role="presentation" '. $activeClass .'>';
								$this->_advancedToggleBoxStart( $oneLine->get('title') );
									echo '<a href="#tab-v'.$tab.'-'.$uniqueId.'-'.$key.'"
											aria-controls="tab-v'.$tab.'-'.$uniqueId.'-'. $key .'"
											role="tab"
											data-toggle="tab">'. $oneLine->getWpKses('title title') .'</a>';
								$this->_advancedToggleBoxEnd( $oneLine->get('title') );
							echo '</li>';

						}
					echo '</ul>';
				echo '</div>';

				echo '<div class="tab-content">';
					foreach( $query->get('content') as $key => $oneLine ) {

						$active = '';
						if( $key == $active_key ){
							$active = 'in active';
						}

						echo '<div role="tabpanel" class="'. $cClass .' '. $active .'" id="tab-v'.$tab.'-'.$uniqueId.'-'. $key .'">';

							$this->_advancedToggleBoxStart( $oneLine->get('content') );
								echo '<div class="tab-pane-content">';
									$oneLine->printWpKsesTextarea( 'content content', '<p>', '</p>', '<div class=" ff-richtext">', '</div>' );
								echo '</div>';
							$this->_advancedToggleBoxEnd( $oneLine->get('content') );

						echo '</div>';
					}
				echo '</div>';
			echo '</div>';
		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
		?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, preview ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						query.get('title').addHeadingLg('title');
						query.get('content').addText('content');
						query.addPlainText('<br>');
					});
				}

			}
		</script data-type="ffscript">
		<?php
	}


}