<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/one-page/one-page-business/index_business_1.html
 */

class ffElTeam13 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'team-13');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Team 13', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'team');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'team, team member, person, biography');

		$this->_setColor('light');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startAdvancedToggleBox('personal-info-box', esc_attr( __('Personal Info Box', 'ark' ) ) );

					/*----------------------------------------------------------*/
					/* TYPE IMAGE
					/*----------------------------------------------------------*/
					$this->_getBlock( ffThemeBlConst::IMAGE )
						->imgIsResponsive()
						->imgIsFullWidth()
						->setParam('width', 738)
						->injectOptions( $s );

					$s->addElement(ffOneElement::TYPE_NEW_LINE);

					$s->startRepVariableSection('personal-info');
						$s->startRepVariationSection('name', ark_wp_kses( __('Name', 'ark' ) ));
							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'name', '', 'Artur Raynor')
								->addParam('print-in-content', true)
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
							;
						$s->endRepVariationSection();

						$s->startRepVariationSection('position', ark_wp_kses( __('Position', 'ark' ) ));
							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'position', '', 'Senior Marketer')
								->addParam('print-in-content', true)
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
							;
						$s->endRepVariationSection();

					$s->endRepVariableSection();

				$s->endAdvancedToggleBox();

				$s->startAdvancedToggleBox('social-box', esc_attr( __('Social Links', 'ark' ) ) );

					/*----------------------------------------------------------*/
					/* TYPE SOCIAL BOX
					/*----------------------------------------------------------*/

					$s->startRepVariableSection('social-icons');

						$s->startRepVariationSection('social-icon', ark_wp_kses( __('Social Link', 'ark' ) ) );

							$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 icon-facebook')
								->addParam('print-in-content', true)
							;
							$s->addElement(ffOneElement::TYPE_NEW_LINE);

							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', '')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color', 'ark' ) ) )
							;
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-hover-color', '', '')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Hover Color', 'ark' ) ) )
							;
							$s->addElement(ffOneElement::TYPE_NEW_LINE);

							$this->_getBlock( ffThemeBuilderBlock::LINK )->injectOptions( $s );

						$s->endRepVariationSection();

					$s->endRepVariableSection();


				$s->endAdvancedToggleBox();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$s->addOption(ffOneOption::TYPE_SELECT, 'align', '', 'text-center')
					->addSelectValue('Left','text-left')
					->addSelectValue('Center','text-center')
					->addSelectValue('Right','text-right')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '#34343c')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background and Gradient', 'ark' ) ) )
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _renderColor( $query, $key ) {

		if( $query->getColor('icon-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.icon-'.$key.'.op-b-team-social-link')
				->addParamsString('color: ' . $query->getColor('icon-color') .';');
		}

		if( $query->getColor('icon-hover-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.icon-'.$key.'.op-b-team-social-link:hover')
				->addParamsString('color: ' . $query->getColor('icon-hover-color') .';');
		}
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		if( $query->getColor( 'bg-color' ) ) {

			/* bg */
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.op-b-team .op-b-team-social', false)
				->addParamsString('background-color: ' . $query->getColor( 'bg-color' ) . ';');

			/* gradient */
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.op-b-team .op-b-team-member', false)
				->addParamsString('background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(0, 0, 0, 0)), to('.$query->getColor('bg-color').'));');

			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.op-b-team .op-b-team-member', false)
				->addParamsString('background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), '.$query->getColor('bg-color').');');

			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.op-b-team .op-b-team-member', false)
				->addParamsString('background-image: -moz-linear-gradient(top, rgba(0, 0, 0, 0), '.$query->getColor('bg-color').');');

			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.op-b-team .op-b-team-member', false)
				->addParamsString('background-image: -ms-linear-gradient(top, rgba(0, 0, 0, 0), '.$query->getColor('bg-color').');');

			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.op-b-team .op-b-team-member', false)
				->addParamsString('background-image: -o-linear-gradient(top, rgba(0, 0, 0, 0), '.$query->getColor('bg-color').');');

			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.op-b-team .op-b-team-member', false)
				->addParamsString('background-image: linear-gradient(top, rgba(0, 0, 0, 0), '.$query->getColor('bg-color').');');

		}

		echo '<section class="op-b-team '. $query->getEscAttr('align') .'">';
			echo '<div class="op-b-team-wrap">';


				$this->_advancedToggleBoxStart( $query->get('personal-info-box') );

					echo '<div class="op-b-team-media">';

						// Escaped image block
						echo ( $this->_getBlock( ffThemeBlConst::IMAGE )
							->imgIsResponsive()
							->imgIsFullWidth()
							->setParam('width', 738)
							->get( $query->get('personal-info-box') ) );

						if( $query->exists('personal-info-box personal-info') ) {
								
							echo '<div class="op-b-team-member">';

								foreach( $query->get('personal-info-box personal-info') as $onePerson ) {
									switch($onePerson->getVariationType()){
										case 'name':
											echo '<h4 class="op-b-team-name">'. $onePerson->getWpKses('name') .'</h4>';
											break;
										case 'position':
											echo '<span class="op-b-team-position">'. $onePerson->getWpKses('position') .'</span>';
											break;
									}
								}

							echo '</div>';

						}

					echo '</div>';

				$this->_advancedToggleBoxEnd( $query->get('personal-info-box') );


				if( $query->exists('social-box social-icons') ) {

					$this->_advancedToggleBoxStart( $query->get('social-box') );

						echo '<ul class="list-inline op-b-team-social">';

						foreach( $query->get('social-box social-icons') as $key => $oneIcon ) {
							echo '<li class="op-b-team-social-item">';

							ffElTeam13::_renderColor( $oneIcon, $key );

							echo '<a ';
								$this->_getBlock( ffThemeBuilderBlock::LINK )->setParam('classes', 'icon-'.$key.' op-b-team-social-link')->render( $oneIcon );
							echo '>';

							echo '<i class="'. $oneIcon->getEscAttr('icon') .'"></i>';

							echo '</a>';

							echo '</li>';
						}

						echo '</ul>';

					$this->_advancedToggleBoxEnd( $query->get('social-box') );

				}

			echo '</div>';
		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				blocks.render('image', query.get('personal-info-box'));

				if(query.get('personal-info-box').queryExists('personal-info')) {
					query.get('personal-info-box').get('personal-info').each(function (query, variationType) {
						switch (variationType) {
							case 'name':
								query.addHeadingLg('name');
								break;
							case 'position':
								query.addHeadingSm('position');
								break;
						}
					});
				}
                if( query.get('social-box') != null ) {
                    if (query.get('social-box').queryExists('social-icons')) {
                        query.get('social-box social-icons').each(function (query, variationType) {
                            switch (variationType) {
                                case 'social-icon':
                                    query.addIcon('icon');
                                    break;
                            }
                        });
                    }
                }

			}
		</script data-type="ffscript">
	<?php
	}

}