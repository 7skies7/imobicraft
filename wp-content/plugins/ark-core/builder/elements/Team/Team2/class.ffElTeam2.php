<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_team_members.html#scrollTo__4000
 */

class ffElTeam2 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'team-2');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Team 2', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'team');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'team, team member, person, biography');

		$this->_setColor('dark');
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


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/* NAME */
					$s->startRepVariationSection('name', ark_wp_kses( __('Full Name', 'ark' ) ));

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'David Martin')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;

					$s->endRepVariationSection();

					/* POSITION */
					$s->startRepVariationSection('position', ark_wp_kses( __('Position', 'ark' ) ));

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Director')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text color', 'ark' ) ) )
						;

					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Hover Overlay', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'overlay-color', '', 'rgba(255, 255, 255, 0.9)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Color', 'ark' ) ) )
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$s->addOption(ffOneOption::TYPE_SELECT, 'align', '', 'text-center')
					->addSelectValue('Left','text-left')
					->addSelectValue('Center','text-center')
					->addSelectValue('Right','text-right')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Box Link', 'ark' ) ) );
				$this->_getBlock( ffThemeBuilderBlock::LINK )->injectOptions( $s );
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

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		ffElTeam2::_renderColor( $query->getColor('overlay-color'), 'background-color', '.team-v2:hover .team-v2-img-gradient:after' );

//		echo '<div>';
		echo '<section class="team-v2">';

			if( $query->exists('image') ) {
				echo '<div class="team-v2-img-gradient">';
					$this->_advancedToggleBoxStart( $query->get('image') );
						$this->_getBlock( ffThemeBlConst::IMAGE )
							->imgIsResponsive()
							->imgIsFullWidth()
							->setParam('width', 738)
							->render( $query->get('image')  );
					$this->_advancedToggleBoxEnd( $query->get('image') );
				echo '</div>';
			}

			if( $query->exists('content') ) {
				echo '<div class="team-v2-content '. $query->getEscAttr('align') .'">';
					echo '<div class="team-v2-center-align">';

						foreach( $query->get('content') as $key => $oneLine ) {
							switch( $oneLine->getVariationType() ) {

								case 'name':
									echo '<h4 class="team-v2-member">'. $oneLine->getWpKses('text') .'</h4>';
									break;

								case 'position':
									if( $oneLine->getColor('text-color') ){
										$this->getAssetsRenderer()->createCssRule()
											->addParamsString('color:'. $oneLine->getColor('text-color') . ';');
									}

									echo '<span class="team-v2-member-position">'. $oneLine->getWpKses('text') .'</span>';
									break;

							}
						}

					echo '</div>';
				echo '</div>';
			}

			echo '<a ';
				$this->_getBlock( ffThemeBuilderBlock::LINK )->setParam('classes', 'team-v2-link')->render( $query );
			echo '></a>';

		echo '</section>';
//		echo '</div>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				blocks.render('image', query.get('image'));

				query.get('content').each(function(query, variationType ){
					switch(variationType){
						case 'name':
							query.addHeadingLg( 'text' );
							break;

						case 'position':
							query.addHeadingSm( 'text' );
							break;
					}
				});

			}
		</script data-type="ffscript">
	<?php
	}


}