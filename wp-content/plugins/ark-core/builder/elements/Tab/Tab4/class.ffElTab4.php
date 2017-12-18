<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_tab.html#scrollTo__2590
 */

class ffElTab4 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'tab-4');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Vertical Tabs 1', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'tab');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'tabs, tab, vertical tab, vertical tabs');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('dark');

	}

	protected function _getDefaultColor($name){
		switch($name){
			case 'acc-header-bg-color':               return '#ffffff';
			case 'acc-header-bg-color-hover':         return '#ffffff';
			case 'acc-header-text-color':             return '#34343c';
			case 'acc-header-text-color-hover':       return '[1]';
			case 'acc-header-handle-color':           return '#34343c';
			case 'acc-header-handle-color-hover':     return '[1]';
			case 'acc-content-bg-color':              return '#f7f8fa';
			case 'acc-content-text-color':            return '#5d5d5d';
			case 'acc-content-link-text-color':       return '[1]';
			case 'acc-content-link-text-color-hover': return '[1]';
		}
		return '';
	}

	protected function _getTextColorSelectors(){
		return array(
			'.nav-tabs.nav-tabs-left > li > a' => 'tab-header-text-color',
			'.nav-tabs.nav-tabs-left > li.active > a' => 'tab-header-text-color-hover',
			'.nav-tabs.nav-tabs-left > li:hover > a' => 'tab-header-text-color-hover',

			'.panel-title > a' => 'acc-header-text-color',
			'.panel-title > a:after' => 'acc-header-handle-color',

			'.panel-title > a:hover' => 'acc-header-text-color-hover',
			'.panel-title > a[aria-expanded="true"]' => 'acc-header-text-color-hover',

			'.panel-title > a:hover:after' => 'acc-header-handle-color-hover',
			'.panel-title > a[aria-expanded="true"]:after' => 'acc-header-handle-color-hover',

			'.panel-body' => 'acc-content-text-color',
			'.panel-body a' => 'acc-content-link-text-color',
			'.panel-body a:hover' => 'acc-content-link-text-color-hover',
		);
	}

	protected function _getBGColorSelectors(){
		return array(
			'nav' => 'tab-header-bg-color',
			'.nav-tabs.nav-tabs-left > li.active > a' => 'tab-header-bg-color-hover',
			'.nav-tabs.nav-tabs-left > li:hover > a' => 'tab-header-bg-color-hover',

			'.panel-title > a' => 'acc-header-bg-color',
			'.panel-title > a:hover' => 'acc-header-bg-color-hover',
			'.panel-title > a[aria-expanded="true"]' => 'acc-header-bg-color-hover',

			'.panel-body' => 'acc-content-bg-color',
		);
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Tabs', 'ark' ) ) );

				$s->startRepVariableSection('tabs');

					/*----------------------------------------------------------*/
					/* TYPE TABS
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('tab', ark_wp_kses( __('Tab', 'ark' ) ) );

						$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'is-active', ark_wp_kses( __('Is opened by default', 'ark' ) ), 0);
						$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('You can only activate this option on one of the tabs.', 'ark' ) ) ) ;
						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'title', '', 'Section')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Title', 'ark' ) ) );
						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->startRepVariableSection('toggle-tabs');

							/* TYPE TOGGLE */
							$s->startRepVariationSection('toggle', ark_wp_kses( __('Toggle', 'ark' ) ) );

								$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'is-active', ark_wp_kses( __('Is opened by default', 'ark' ) ), 0);
								$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('You can only activate this option on one of the toggles insde the same tab.', 'ark' ) ) ) ;
								$s->addElement(ffOneElement::TYPE_NEW_LINE);

								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'title', '', 'Collapsible Group Item #1')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Title', 'ark' ) ) );

								$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'description', ark_wp_kses( __('Description', 'ark' ) ), 'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch.')
									->addParam('print-in-content', true);

							$s->endRepVariationSection();

						$s->endRepVariableSection();

					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Tabs Colors', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'tab-header-bg-color', '', '[1]')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'tab-header-bg-color-hover', '', '#0098ab')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background - Active', 'ark' ) ) )
				;

				$s->addElement( ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'tab-header-text-color', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'tab-header-text-color-hover', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text - Active', 'ark' ) ) )
				;

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Toggle Header Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'acc-header-bg-color', '' , $this->_getDefaultColor('acc-header-bg-color') )
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background - Collapsed', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'acc-header-bg-color-hover', '' , $this->_getDefaultColor('acc-header-bg-color-hover') )
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background - Active', 'ark' ) ) );

				$s->addElement( ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'acc-header-text-color', '' , $this->_getDefaultColor('acc-header-text-color') )
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text - Collapsed', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'acc-header-text-color-hover', '' , $this->_getDefaultColor('acc-header-text-color-hover') )
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text - Active', 'ark' ) ) );

				$s->addElement( ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'acc-header-handle-color', '' , $this->_getDefaultColor('acc-header-handle-color') )
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Toggle Handle - Collapsed', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'acc-header-handle-color-hover', '' , $this->_getDefaultColor('acc-header-handle-color-hover') )
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Toggle Handle - Active', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Toggle Content Colors', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'acc-content-bg-color', '' , $this->_getDefaultColor('acc-content-bg-color') )
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background', 'ark' ) ) );

				$s->addElement( ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'acc-content-text-color', '' , $this->_getDefaultColor('acc-content-text-color') )
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );

				$s->addElement( ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'acc-content-link-text-color', '' , $this->_getDefaultColor('acc-content-link-text-color') )
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Link', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'acc-content-link-text-color-hover', '' , $this->_getDefaultColor('acc-content-link-text-color-hover') )
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Link Hover', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

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

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('tabs') ) {
			return;
		}

		static $staticId = 0;
		$staticId++;

		$activeCounter = 0;

		foreach( $query->getWithoutCallbacks('tabs') as $key => $oneLine ) {
			if( $oneLine->get('is-active',0)){
				$activeCounter = $key;
				break;
			}
		}

		$this->_renderCSS($query);

		echo '<section class="tab-v4">';

			echo '<ul class="nav nav-tabs nav-tabs-left" role="tablist">';

				foreach( $query->get('tabs') as $key => $oneLine ) {

					$activeClass = '';
					if( $key == $activeCounter ){
						$activeClass = 'class="active"';
					}

					echo '<li role="presentation" '. $activeClass .'>';
						echo '<a href="#tab-v4-'.$uniqueId.'-'.$key.'"
								aria-controls="tab-v4-'.$uniqueId.'-'. $key .'"
								role="tab"
								data-toggle="tab">'. $oneLine->getWpKses('title') .'</a>';
					echo '</li>';

				}

			echo '</ul>';

			echo '<div class="tab-content">';

				foreach( $query->get('tabs') as $key => $oneLine ) {

					$active = '';
					if( $key == $activeCounter ){
						$active = 'in active';
					}

					if( ! $oneLine->exists('toggle-tabs') ) {
						continue;
					}

					echo '<div role="tabpanel" class="tab-pane fade '. $active .'" id="tab-v4-'.$uniqueId.'-'. $key .'">';
						echo '<div class="accordion-v5">';
							echo '<div class="panel-group">';
								foreach( $oneLine->get('toggle-tabs') as $oneToggle ) {

									$staticId ++;

									$activeToggle = 'false';
									$activeToggleClass = '';
									if( $oneToggle->get('is-active') ){
										$activeToggle = 'true';
										$activeToggleClass = 'in';
									}

									echo '<div class="panel panel-default">';

										echo '<div class="panel-heading" role="tab" id="heading'. $staticId .'">';
											echo '<h4 class="panel-title">';
												echo '<a role="button"
														data-toggle="collapse"
														data-parent="#accordion-v5"
														href="#accordionV5Collapse'. $staticId .'"
														aria-expanded="'. $activeToggle .'"
														aria-controls="accordionV5Collapse'. $staticId .'">'. $oneToggle->getWpKses('title');
												echo '</a>';
											echo '</h4>';
										echo '</div>';

										echo '<div id="accordionV5Collapse'. $staticId .'" class="panel-collapse collapse '. $activeToggleClass .'" role="tabpanel" aria-labelledby="heading'. $staticId .'">';
											echo '<div class="panel-body">'. $oneToggle->get('description') .'</div>';
										echo '</div>';

									echo '</div>';

								}

							echo '</div>';
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

				if(query.queryExists('tabs')) {
					query.get('tabs').each(function (query, variationType) {
						query.addHeadingLg('title');
						if(query.queryExists('toggle-tabs')) {
							query.get('toggle-tabs').each(function (query, variationType) {
								query.addHeadingSm('title');
								query.addText('description');
							});
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}