<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_tab.html#scrollTo__1030
 */

class ffElTab3 extends ffElTab1 {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'tab-3');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Tabs 3', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'tab');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'tabs, tab');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('dark');
	}

	protected function _getDefaultColor($name){
		switch($name){
			case 'header-bg-color': return 'rgba(255, 255, 255, 0.4)';
			case 'tab-bg-color': return '#ffffff';
			case 'tab-bg-color-hover': return '[1]';

			case 'tab-text-color': return '#34343c';
			case 'tab-text-color-hover': return '#ffffff';

			case 'content-bg-color': return '#ffffff';
			case 'content-text-color': return '#606060';
			case 'content-link-text-color': return '[1]';
			case 'content-link-text-color-hover': return '[1]';
		}
		return '';
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

						$s->startAdvancedToggleBox('title', esc_attr( __('Tab Title', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'title', '', 'Section 1')
								->addParam('print-in-content', true);
						$s->endAdvancedToggleBox();

						$s->startAdvancedToggleBox('content', esc_attr( __('Content', 'ark' ) ) );
							$s->startRepVariableSection('text-content');

								$s->startRepVariationSection('one-image', ark_wp_kses( __('Image', 'ark' ) ) );
									$s->addElement( ffOneElement::TYPE_HTML,'','<div class="hidden">');
									$s->addOptionNL(ffOneOption::TYPE_TEXT,'t','','t');
									$s->addElement( ffOneElement::TYPE_HTML,'','</div>');
									$this->_getBlock( ffThemeBlConst::IMAGE )->imgIsResponsive()->imgIsFullWidth()->setParam('width', 800)->injectOptions( $s );
								$s->endRepVariationSection();

								$s->startRepVariationSection('one-title', ark_wp_kses( __('Title', 'ark' ) ));
									$s->addOptionNL(ffOneOption::TYPE_TEXT,'title','','Content Title')
										->addParam('print-in-content', true)
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Content Title', 'ark' ) ) )
									;
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'title-color', '', '[1]')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Title color', 'ark' ) ) )
									;
								$s->endRepVariationSection();

								$s->startRepVariationSection('one-desc', ark_wp_kses( __('Description', 'ark' ) ) );
									$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'description', ark_wp_kses( __('Description', 'ark' ) ), 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus maximus gravida efficitur. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Mauris lacinia tristique sapien, sed ornare arcu rhoncus in.')
										->addParam('print-in-content', true)
									;
								$s->endRepVariationSection();

							$s->endRepVariableSection();

						$s->endAdvancedToggleBox();

					$s->endRepVariationSection();

				$s->endRepVariableSection();

				$this->_getElementColorOptions($s);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		$s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

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

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		$active_key = $this->_getActiveTabIndex($query);
		$this->_createCssColorsRules($query);


		echo '<section class="tab-v3">';

			echo '<div class="nav-tabs-wrap nav-wrapper">';
				echo '<ul class="nav nav-tabs" role="tablist">';

					foreach( $query->get('content') as $key => $oneLine ) {
						echo '<li role="presentation"';
						if( $key == $active_key ){
							echo ' class="active"';
						}
						echo '>';
							$this->_advancedToggleBoxStart( $oneLine->get('title') );
								echo '<a href="#tab-v3-'.$uniqueId.'-'.$key.'"
										aria-controls="tab-v3-'.$uniqueId.'-'. $key .'"
										role="tab"
										data-toggle="tab">'. $oneLine->getWpKses('title title') .'</a>';
							$this->_advancedToggleBoxEnd( $oneLine->get('title') );
						echo '</li>';

					}

				echo '</ul>';
			echo '</div>';

			echo '<div class="tab-content">';

				foreach( $query->get('content') as $key => $oneLine ) {

					echo '<div role="tabpanel" class="tab-pane';
					if( $key == $active_key ){
						echo ' active';
					}
					echo '" id="tab-v3-'.$uniqueId.'-'. $key .'">';

						$this->_advancedToggleBoxStart( $oneLine->get('content') );

						echo '<div>';

							$img_state = true;
							if( $oneLine->exists('content text-content') ) {
								foreach( $oneLine->get('content text-content') as $oneItem ) {
									switch($oneItem->getVariationType()){
										case 'one-image':
											if( ! $img_state ){ echo '</div>'; }
											$img_state = true;
											$this->_getBlock( ffThemeBlConst::IMAGE )
												->imgIsResponsive()
												->imgIsFullWidth()
												->setParam('width', 1140)
												->render( $oneItem );
											break;
										case 'one-title':
											if($img_state){ echo '<div class="tab-pane-content">'; }
											$img_state = false;
											$this->getAssetsRenderer()->createCssRule()
												->addParamsString('color:'. $oneItem->getColor('title-color').';');
											$toPrint = '<h2 class="tab-v3-content-title">';
												$toPrint .= $oneItem->getWpKses('title');
											$toPrint .= '</h2>';
											// Escaped title
											echo ( $this->_applySystemThingsOnRepeatable($toPrint,$oneItem) );

											break;
										case 'one-desc':
											if($img_state){ echo '<div class="tab-pane-content">'; }
											$img_state = false;
											$toPrint = '<div>' . $oneItem->getWpKsesTextarea( 'description', '<p>', '</p>', '<div class=" ff-richtext">', '</div>' ) . '</div>';
											// Escaped description
											echo ($this->_applySystemThingsOnRepeatable( $toPrint, $oneItem));

											break;
									}
								}
							}
							if( ! $img_state ){ echo '</div>'; }

						echo '</div>';

						$this->_advancedToggleBoxEnd( $oneLine->get('content') );

					echo '</div>';

				}

			echo '</div>';

		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						if( query.get('title') ) {
							query.get('title').addHeadingLg('title');
						}

						if( query.get('content text-content') ) {
							query.get('content text-content').each(function (query, variationType) {
								switch (variationType) {
									case 'one-image':
										blocks.render('image', query);
										break;
									case 'one-title':
										query.addHeadingSm('title');
										break;
									case 'one-desc':
										query.addText('description');
										break;
								}
							});
							query.addPlainText('<br>');
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}

}