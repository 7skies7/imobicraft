<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_team_members.html#scrollTo__1400
 */

class ffElTeam8 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'team-8');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Team 8', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'team');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'team, team member, person, biography');

		$this->_setColor('light');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Image', 'ark' ) ) );
				$s->startAdvancedToggleBox('image', esc_attr( __('Image', 'ark' ) ) );
					$this->_getBlock( ffThemeBlConst::IMAGE )
						->imgIsResponsive()
						->imgIsFullWidth()
						->setParam('width', 738)
						->injectOptions( $s );
				$s->endAdvancedToggleBox();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Personal Info', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE NAME
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('name', ark_wp_kses( __('Full Name', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Sara Glazer')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE POSITION
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('position', ark_wp_kses( __('Position', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Chief Designer')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE SEPARATOR
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('separator', ark_wp_kses( __('Separator', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'separator-color', '', '#ffffff')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Color', 'ark' ) ) )
						;
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Personal Info Alignment', 'ark' ) ) );
				$s->addOption(ffOneOption::TYPE_SELECT, 'align', '', 'text-center')
					->addSelectValue('Left','text-left')
					->addSelectValue('Center','text-center')
					->addSelectValue('Right','text-right')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Box Link', 'ark' ) ) );
				$this->_getBlock( ffThemeBuilderBlock::LINK )->injectOptions( $s );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'overlay-color', '', 'rgba(52, 52, 60, 0.7)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Hover Overlay Background', 'ark' ) ) )
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		$s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		if( $query->getColor('overlay-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.team-v8:hover .team-v8-img:before')
				->addParamsString('background-color:'. $query->getColor('overlay-color') . ';');
		}

		echo '<div>';
		echo '<section class="team-v8">';

			if( $query->exists('image') ) {
				$this->_advancedToggleBoxStart( $query->get('image') );
					echo '<div class="team-v8-img">';
						$this->_getBlock( ffThemeBlConst::IMAGE )
							->imgIsResponsive()
							->imgIsFullWidth()						
							->setParam('width', 738)
							->render( $query->get('image') );
					echo '</div>';
				$this->_advancedToggleBoxEnd( $query->get('image') );
			}


			if( $query->exists('content') ){
				echo '<div class="team-v8-info '. $query->getEscAttr('align') .'">';

					foreach( $query->get('content') as $key=> $oneLine ) {
						switch( $oneLine->getVariationType() ) {

							case 'name':
								echo '<h4 class="team-v8-name">'. $oneLine->getWpKses('text') .'</h4>';
								break;
							case 'position':
								echo '<span class="team-v8-position">'. $oneLine->getWpKses('text') .'</span>';
								break;
							case 'separator':
								if( $oneLine->getColor('separator-color') ){
									$this->getAssetsRenderer()->createCssRule()
										->addParamsString('background-color:'. $oneLine->getColor('separator-color') . ';');
								}

								echo '<div class="team-v8-separator"></div>';
								break;

						}
					}

				echo '</div>';
			}

			if( $this->_getBlock( ffThemeBuilderBlock::LINK )->urlHasBeenFilled( $query ) ) {
				echo '<a ';
					$this->_getBlock( ffThemeBuilderBlock::LINK )->setParam('classes', 'team-v8-link')->render( $query );
				echo '></a>';
			}

		echo '</section>';
		echo '</div>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				blocks.render('image', query.get('image'));

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'name':
								query.addHeadingLg('text');
								break;
							case 'position':
								query.addHeadingSm('text');
								break;
							case 'separator':
								query.addDivider();
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}