<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_team_members.html#scrollTo__6100
 */

class ffElTeam6 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'team-6');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Team 6', 'ark' ) ) );
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

					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'hover-color', '', 'rgba(52, 52, 60, 0.3)')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Image Overlay Background Color', 'ark' ) ) )
						;

					$s->addElement(ffOneElement::TYPE_NEW_LINE);

					$s->startRepVariableSection('social-lines');

						$s->startRepVariationSection('one-line', ark_wp_kses( __('Social Link', 'ark' ) ) );

							$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 icon-facebook')
								->addParam('print-in-content', true)
							;
							$s->addElement(ffOneElement::TYPE_NEW_LINE);
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', '#ffffff')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color', 'ark' ) ) )
							;
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-hover-color', '', '#34343c')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Hover Color', 'ark' ) ) )
							;
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Background Color', 'ark' ) ) )
							;
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-hover-color', '', '#ffffff')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Background Hover Color', 'ark' ) ) )
							;
							$s->addElement(ffOneElement::TYPE_NEW_LINE);
							$this->_getBlock( ffThemeBuilderBlock::LINK )->injectOptions( $s );

						$s->endRepVariationSection();

					$s->endRepVariableSection();

				$s->endAdvancedToggleBox();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Full Name', 'ark' ) ) );
				$s->startAdvancedToggleBox('fullname', esc_attr( __('Full Name', 'ark' ) ) );
					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Sara Glaser')
						->addParam('print-in-content', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
					;
				$s->endAdvancedToggleBox();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$s->addOption(ffOneOption::TYPE_SELECT, 'align', '', 'text-center')
					->addSelectValue('Left','text-left')
					->addSelectValue('Center','text-center')
					->addSelectValue('Right','text-right')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		$s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _renderColor( $query, $cssAttribute, $cssAfterAttribute = null, $selector = null ) {

		if( $query && $selector ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector($selector)
				->addParamsString( $cssAttribute .': '. $query .' '. $cssAfterAttribute .';');;
		} else if( $query ){
			$this->getAssetsRenderer()->createCssRule()
				->addParamsString( $cssAttribute .': '. $query .';');
		}

	}

	protected function _renderColorFail( $query, $key ) {

		if( $query->getColor('icon-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.icon-'.$key.'.theme-icons-white-hover')
				->addParamsString('color: ' . $query->getColor('icon-color') .';');
		}

		if( $query->getColor('icon-hover-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.icon-'.$key.'.theme-icons-white-hover:hover')
				->addParamsString('color: ' . $query->getColor('icon-hover-color') .';');
		}

		if( $query->getColor('bg-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.icon-'.$key.'.theme-icons-white-hover')
				->addParamsString('background-color: ' . $query->getColor('bg-color') .';');
		}

		if( $query->getColor('bg-hover-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.icon-'.$key.'.theme-icons-white-hover:hover')
				->addParamsString('background-color: ' . $query->getColor('bg-hover-color') .';');
		}
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		echo '<section class="team-v6 '. $query->getEscAttr('align') .'">';

			ffElTeam6::_renderColor( $query->getColor('image hover-color'), 'background-color', null, '.team-v6-img-gradient:before' );

			echo '<div class="team-v6-img-gradient">';
				$this->_advancedToggleBoxStart( $query->get('image') );
					$this->_getBlock( ffThemeBlConst::IMAGE )
						->imgIsResponsive()
						->imgIsFullWidth()
						->setParam('width', 738)
						->render( $query->get('image') );
				$this->_advancedToggleBoxEnd( $query->get('image') );
			echo '</div>';

			 echo '<div class="team-v6-info">';

				$this->_advancedToggleBoxStart( $query->get('fullname') );
					echo '<h2 class="team-v6-member">'. $query->getWpKses('fullname text') .'</h2>';
				$this->_advancedToggleBoxEnd( $query->get('fullname') );

				if( $query->exists('image social-lines') ) {
					echo '<ul class="list-inline team-v6-socials ul-li-lr-3">';
						foreach( $query->getWithoutCallbacks('image social-lines') as $key => $oneLink ) {
							echo '<li class="theme-icons-wrap">';
								echo '<a ';
									$this->_getBlock( ffThemeBuilderBlock::LINK )->render( $oneLink );
								echo '>';

									ffElTeam6::_renderColorFail( $oneLink, $key );

									echo '<i class="theme-icons icon-'.$key.' theme-icons-white-hover theme-icons-md radius-circle margin-b-0 '. $oneLink->getEscAttr('icon') .'"></i>';
								echo '</a>';
							echo '</li>';
						}
					echo '</ul>';
				}

			echo '</div>';

		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				blocks.render('image', query.get('image'));

				query.addHeadingLg( 'fullname text' );

				if(query.queryExists('image social-lines')) {
					query.get('image social-lines').each(function (query, variationType) {
						switch (variationType) {
							case 'one-line':
								query.addIcon('icon');
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}