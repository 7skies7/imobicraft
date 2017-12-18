<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_services_modern.html#scrollTo__1106
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_accordion.html#scrollTo__397
 */

class ffElAccordion2 extends ffThemeBuilderElementBasic {

	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'accordion-2');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Accordion 2', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);


		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'accordion');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'accordion, accordeon, faq');

		$this->_setColor('dark');
	}

	protected function _getDefaultColor($name){
		switch($name){
			case 'header-bg-color':               return '#ffffff';
			case 'header-bg-color-hover':         return '#ffffff';
			case 'header-text-color':             return '#34343c';
			case 'header-text-color-hover':       return '[1]';
			case 'header-handle-color':           return '#34343c';
			case 'header-handle-color-hover':     return '[1]';
			case 'content-bg-color':              return '#ffffff';
			case 'content-text-color':            return '#606060';
			case 'content-link-text-color':       return '[1]';
			case 'content-link-text-color-hover': return '[1]';
		}
		return '';
	}

	protected function _getTextColorSelectors(){
		return array(
			'.panel-title > a' => 'header-text-color',
			'.panel-title > a:after' => 'header-handle-color',

			'.panel-title > a:hover' => 'header-text-color-hover',
			'.panel-title > a[aria-expanded="true"]' => 'header-text-color-hover',

			'.panel-title > a:hover:after' => 'header-handle-color-hover',
			'.panel-title > a[aria-expanded="true"]:after' => 'header-handle-color-hover',

			'.panel-body' => 'content-text-color',
			'.panel-body a' => 'content-link-text-color',
			'.panel-body a:hover' => 'content-link-text-color-hover',
		);
	}

	protected function _getBGColorSelectors(){
		return array(
			'.panel-title > a' => 'header-bg-color',
			'.panel-title > a:hover' => 'header-bg-color-hover',
			'.panel-title > a[aria-expanded="true"]' => 'header-bg-color-hover',
			'.panel-body' => 'content-bg-color',
		);
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Accordions', 'ark' ) ) );

		$s->startRepVariableSection('content');

		/*----------------------------------------------------------*/
		/* TYPE ACCORDION
		/*----------------------------------------------------------*/
		$s->startRepVariationSection('accordion', ark_wp_kses( __('Accordion', 'ark' ) ));

		$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'is-active', ark_wp_kses( __('Is active', 'ark' ) ), 0);
		$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('Please note that this option will be used only on one Accordion', 'ark' ) ) );
		$s->addElement(ffOneElement::TYPE_NEW_LINE);

		$s->startAdvancedToggleBox('title', esc_attr( __('Title', 'ark' ) ));
		$s->addOptionNL( ffOneOption::TYPE_TEXT, 'title', '', 'Collapsible Group Item #1')
			->addParam('print-in-content', true);
		$s->endAdvancedToggleBox();

		$s->startAdvancedToggleBox('content', esc_attr( __('Content', 'ark' ) ));
		$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'content', '', 'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo.')
			->addParam('print-in-content', true);
		$s->endAdvancedToggleBox();

		$s->endRepVariationSection();

		$s->endRepVariableSection();

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('General Settings', 'ark' ) ) );

		$s->addOptionNL( ffOneOption::TYPE_TEXT, 'mb', '', '')
			->addParam('print-in-content', true)
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Space between Header and Content (in px)', 'ark' ) ) );

		$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('Leave blank for default spacing', 'ark' ) ) );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Header Colors', 'ark' ) ) );
		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'header-bg-color', '' , $this->_getDefaultColor('header-bg-color') )
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background - Collapsed', 'ark' ) ) );

		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'header-bg-color-hover', '' , $this->_getDefaultColor('header-bg-color-hover') )
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background - Active', 'ark' ) ) );

		$s->addElement( ffOneElement::TYPE_NEW_LINE);

		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'header-text-color', '' , $this->_getDefaultColor('header-text-color') )
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text - Collapsed', 'ark' ) ) );

		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'header-text-color-hover', '' , $this->_getDefaultColor('header-text-color-hover') )
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text - Active', 'ark' ) ) );

		$s->addElement( ffOneElement::TYPE_NEW_LINE);

		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'header-handle-color', '' , $this->_getDefaultColor('header-handle-color') )
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Toggle Handle - Collapsed', 'ark' ) ) );

		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'header-handle-color-hover', '' , $this->_getDefaultColor('header-handle-color-hover') )
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Toggle Handle - Active', 'ark' ) ) );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Colors', 'ark' ) ) );

		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-bg-color', '' , $this->_getDefaultColor('content-bg-color') )
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background', 'ark' ) ) );

		$s->addElement( ffOneElement::TYPE_NEW_LINE);

		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-text-color', '' , $this->_getDefaultColor('content-text-color') )
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );

		$s->addElement( ffOneElement::TYPE_NEW_LINE);

		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-link-text-color', '' , $this->_getDefaultColor('content-link-text-color') )
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Link', 'ark' ) ) );

		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-link-text-color-hover', '' , $this->_getDefaultColor('content-link-text-color-hover') )
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Link Hover', 'ark' ) ) );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		$s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		$this->_renderBasicElement($query, $content, $data, $uniqueId, 2);
	}

	protected function _getActiveTabIndex(ffOptionsQueryDynamic $query){
		$active_key = -1;

		foreach( $query->getWithoutCallbacks('content') as $key => $oneLine ) {
			if( $oneLine->get('is-active')){
				$active_key = $key;
				break;
			}
		}

		return $active_key;
	}

	protected function _renderCSS( ffOptionsQueryDynamic $query ){
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

		$mb = $query->get( 'mb' );
		if( ! empty($mb) or ( 0 === $mb ) or ( '0' === $mb ) ) {
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.panel-heading')
				->addParamsString('margin-bottom:' . $mb . 'px;');
		}
	}

	protected function _renderBasicElement( ffOptionsQueryDynamic $query, $content, $data, $uniqueId, $accordeon_type ) {
		if( ! $query->exists('content') ) {
			return;
		}
		$active_key = $this->_getActiveTabIndex($query);

		$accordeon = $accordeon_type;

		$class = '';
		if(6 == $accordeon) {
			$class = ' accordion-v6 accordion-v5-active-left';
			$accordeon = 5;
		}

		echo '<section class="accordion-v'. $accordeon .' '. $class .'">';

		echo '<div class="panel-group accordion-2-'.$uniqueId.'" role="tablist" aria-multiselectable="true">';

		foreach( $query->get('content') as $key => $oneLine ) {

			$collapsedClass = ' class="collapsed" ';
			$active = 'false';
			$activeClass = '';
			if( $key == $active_key ){
				$collapsedClass = '';
				$active = 'true';
				$activeClass = 'in';
			}

			echo '<div class="panel panel-default">';

			echo '<div class="panel-heading" role="tab" id="heading'. $key .'">';

			$this->_renderCSS($query);

			echo '<h4 class="panel-title">';
			$this->_advancedToggleBoxStart( $oneLine->get('title') );
			echo '<a role="button" '.$collapsedClass.'
											data-toggle="collapse"
											data-parent=".accordion-2-'.$uniqueId.'"
											href="#'.$uniqueId. $accordeon .'Collapse'. $key .'"
											aria-expanded="'. $active .'"
											aria-controls="accordionV'. $accordeon .'Collapse'. $key .'">'. $oneLine->getWpKses('title title');

			echo '</a>';
			$this->_advancedToggleBoxEnd( $oneLine->get('title') );
			echo '</h4>';
			echo '</div>';


			echo '<div id="'.$uniqueId. $accordeon .'Collapse'. $key .'" class="panel-collapse collapse '. $activeClass .'" role="tabpanel" aria-labelledby="heading'. $key .'">';
			$this->_advancedToggleBoxStart( $oneLine->get('content') );
			echo '<div class="panel-body">'. $oneLine->getWpKses('content content') .'</div>';
			$this->_advancedToggleBoxEnd( $oneLine->get('content') );
			echo '</div>';

			echo '</div>';

		}

		echo '</div>';
		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
		?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, preview ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						if( query.get('title') != null ) {
							query.get('title').addHeadingLg('title');
						}

						if( query.get('content') != null ) {
							query.get('content').addText('content');
						}
					});
				}


			}
		</script data-type="ffscript">
		<?php
	}

}