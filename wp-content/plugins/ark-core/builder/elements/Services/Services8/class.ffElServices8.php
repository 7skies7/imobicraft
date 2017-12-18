<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_services_modern.html#scrollTo__3126
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_services.html#scrollTo__5762
 */

class ffElServices8 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'services-8');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Services 8', 'ark' ) ));
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'services');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'services');

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE Service
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('heading', ark_wp_kses( __('Service', 'ark' ) ));

						$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Basic Settings', 'ark' ) ));

							$this->_getBlock( ffThemeBuilderBlock::LINK )->injectOptions( $s );

							$s->addElement(ffOneElement::TYPE_NEW_LINE);

							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-color', '', '#34343c')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Service Text Color', 'ark' ) ) )
							;

							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'hover-text-color', '', '#ffffff')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Service Text Hover Color', 'ark' ) ) )
							;

							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '#f7f8fa')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Service Background Color', 'ark' ) ) )
							;
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'hover-color', '', '[1]')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Service Background Hover Color', 'ark' ) ) )
							;

						$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);

						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->startAdvancedToggleBox('prefix', esc_attr( __('Prefix', 'ark' ) ));
							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'prefix', '', '01')
								->addParam('print-in-content', true)
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Prefix', 'ark' ) ) )
							;
						$s->endAdvancedToggleBox();

						$s->startAdvancedToggleBox('one-title', esc_attr( __('Title', 'ark' ) ));
							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'title-text', '', 'Connect to Ark with login and password')
								->addParam('print-in-content', true)
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
							;

							$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses( __('Having the Title at exactly 1 line of text on front-end will work best for proper alignment and spacing.', 'ark' ) ) );

						$s->endAdvancedToggleBox();


						$s->startAdvancedToggleBox('suffix', esc_attr( __('Hover Suffix Text', 'ark' ) ));
							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'suffix', '', '28')
								->addParam('print-in-content', true)
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Suffix', 'ark' ) ) )
							;
						$s->endAdvancedToggleBox();


						$s->startAdvancedToggleBox('suffix-icon', esc_attr( __('Hover Suffix Icon', 'ark' ) ));
							$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Suffix Icon', 'ark' ) ), 'ff-font-awesome4 icon-comments-o')
								->addParam('print-in-content', true)
							;
						$s->endAdvancedToggleBox();


					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'content-align', '', 'text-left')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'text-left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'text-center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'text-right')
				;

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		echo '<section class="item ff-services-v8 '.$query->getWpKses('content-align').'">';

			foreach( $query->get('content') as $oneLine ) {
				echo '<div class="overflow-h">';

					if($oneLine->getColor('text-color')) {
						$selectors = array('.services-v8','.services-v8 .services-v8-text','.services-v8 .services-v8-no','.services-v8 .services-v8-like','.services-v8 .services-v8-like-amount','.services-v8 .services-v8-like-icon');
						foreach($selectors as $sel) {
							$this->getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector(' '.$sel)
								->addParamsString('color:' . $oneLine->getColor('text-color'));
						}
					}

					if($oneLine->getColor('hover-text-color')) {
						$selectors = array('.services-v8:hover','.services-v8:hover .services-v8-text','.services-v8:hover .services-v8-no','.services-v8:hover .services-v8-like','.services-v8:hover .services-v8-like-amount','.services-v8:hover .services-v8-like-icon');
						foreach($selectors as $sel) {
							$this->getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector(' '.$sel)
								->addParamsString('color:' . $oneLine->getColor('hover-text-color'));
						}
					}

					if($oneLine->getColor('bg-color')) {
						$this->getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector(' .services-v8')
							->addParamsString('background:' . $oneLine->getColor('bg-color'));
					}

					if($oneLine->getColor('hover-color')) {
						$this->getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector(' .services-v8:hover')
							->addParamsString('background:' . $oneLine->getColor('hover-color'));
					}

					echo '<a ';
						$this->_getBlock(ffThemeBuilderBlock::LINK)->setParam('classes', 'services-v8')->render($oneLine);
					echo '>';
						$this->_advancedToggleBoxStart($oneLine->get('prefix'));
							echo '<span class="services-v8-no">';
								$oneLine->printWpKses('prefix prefix');
							echo '</span>';
						$this->_advancedToggleBoxEnd( $oneLine->get('prefix') );

						$this->_advancedToggleBoxStart($oneLine->get('one-title'));
							echo '<span class="services-v8-text">';
								$oneLine->printWpKses('one-title title-text');
							echo '</span>';
						$this->_advancedToggleBoxEnd( $oneLine->get('one-title') );

						echo '<span class="services-v8-like">';
							$this->_advancedToggleBoxStart($oneLine->get('suffix'));
								echo '<span class="services-v8-like-amount">';
								$oneLine->printWpKses('suffix suffix');
								echo '</span>';
							$this->_advancedToggleBoxEnd( $oneLine->get('suffix') );
							$this->_advancedToggleBoxStart($oneLine->get('suffix-icon'));
								echo '<i class="services-v8-like-icon ' . $oneLine->getWpKses('suffix-icon icon') . '"></i>';
							$this->_advancedToggleBoxEnd( $oneLine->get('suffix-icon') );
						echo '</span>';					

					echo '</a>';
				echo '</div>';
			}

		echo '</section>';

	}


	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						var prefix = query.get('prefix').get('prefix');
						prefix += ' ';
						var title = query.get('one-title').get('title-text');
						query.addHeadingLg(null, prefix, title);
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}