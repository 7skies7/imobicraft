<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_team_members.html#scrollTo__5350
 */

class ffElTeam5 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'team-5');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Team 5', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'team');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'team, team member, person, biography');

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE PERSONAL INFO & IMAGE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('image', ark_wp_kses( __('Image and Personal Info', 'ark' ) ) );

						$this->_getBlock( ffThemeBlConst::IMAGE )
							->imgIsResponsive()
							->imgIsFullWidth()							
							->setParam('width', 738)
							->injectOptions( $s );

						$s->addElement( ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'hover-color', '', 'rgba(52, 52, 60, 0.3)')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Image Overlay Background Color', 'ark' ) ) )
						;

						$s->addElement( ffOneElement::TYPE_NEW_LINE);

						$s->startAdvancedToggleBox('full-name', esc_attr( __('Full Name', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'David Martin')
								->addParam('print-in-content', true)
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
							;
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-color', '', '#ffffff')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text color', 'ark' ) ) )
							;
						$s->endAdvancedToggleBox();

						$s->startAdvancedToggleBox('position', esc_attr( __('Position', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Developer')
								->addParam('print-in-content', true)
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
							;
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-color', '', '#ffffff')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text color', 'ark' ) ) )
							;
						$s->endAdvancedToggleBox();

					$s->endRepVariationSection();

					/* PROGRESS BAR */
					$s->startRepVariationSection('one-line', ark_wp_kses( __('Progress Bar', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Graphic Design')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_SELECT, 'font', '', 'font-style-inherit')
							->addSelectValue( esc_attr( __('Normal', 'ark' ) ), 'font-style-inherit')
							->addSelectValue( esc_attr( __('Cursive', 'ark' ) ), '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Style of Text', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'value', '', '83')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Value (0-100)', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'unit', '', '%')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Unit', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_SELECT, 'style', '', 'sm')
							->addSelectValue( esc_attr( __('Large', 'ark' ) ), 'lg')
							->addSelectValue( esc_attr( __('Medium', 'ark' ) ), 'md')
							->addSelectValue( esc_attr( __('Small', 'ark' ) ), 'sm')
							->addSelectValue( esc_attr( __('Extra small', 'ark' ) ), 'xs')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Height of Line', 'ark' ) ) );

						$s->addElement( ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'use-radius', ark_wp_kses( __('Apply border radius', 'ark' ) ), 0);

						$s->addElement( ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '#f5f5f5')
							->addParam( ffOneOption::PARAM_TITLE_AFTER,  ark_wp_kses( __('Bar Background Color', 'ark' ) ) )
							->addParam('print-in-content', true);

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'fg-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER,  ark_wp_kses( __('Bar Foreground Color', 'ark' ) ) )
							->addParam('print-in-content', true);

					$s->endRepVariationSection();

					/* CONTACT */
					$s->startRepVariationSection('one-contact', ark_wp_kses( __('Contact', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'contact-text', '', 'Contact')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
						$this->_getBlock( ffThemeBuilderBlock::LINK )->injectOptions( $s );

						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'contact-link-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Link Color', 'ark' ) ) )
						;

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'contact-link-hover-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Link Hover Color', 'ark' ) ) )
						;

					$s->endRepVariationSection();

				$s->endRepVariableSection();

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

	protected function _renderColor( $query, $cssAttribute, $cssAfterAttribute = null, $selector = null, $spaces = true ) {

		if( $query && $selector ){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors($spaces)
				->addSelector($selector)
				->addParamsString( $cssAttribute .': '. $query .' '. $cssAfterAttribute .';');;
		} else if( $query ){
			$this->getAssetsRenderer()->createCssRule()
				->addParamsString( $cssAttribute .': '. $query .';');
		}

	}

	protected function _enqueueScriptsAndStyles( $query ) {
		wp_enqueue_script( 'ark-progress-bar' );
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		echo '<section class="team-v5">';

			$isInContent = false;

			foreach( $query->get('content') as $oneLine ) {
				switch( $oneLine->getVariationType() ) {
					case 'image':

						if( $isInContent){ echo '</div>'; $isInContent = false; }

						ffElTeam5::_renderColor( $oneLine->getColor('hover-color'), 'background-color', null, '.team-v5-header:before' );

						$this->_applySystemTabsOnRepeatableStart( $oneLine );
							echo '<div>';
								echo '<div class="team-v5-header">';

									// Escaped image block
									echo ( $this->_getBlock( ffThemeBlConst::IMAGE )
										->imgIsResponsive()
										->imgIsFullWidth()
										->setParam('width', 738)
										->get( $oneLine ) );

									echo '<div class="team-v5-gradient '. $query->getEscAttr('align') .'">';

										$this->_advancedToggleBoxStart( $oneLine->get('full-name') );
											ffElTeam5::_renderColor( $oneLine->getColor('full-name text-color'), 'color', null, '.team-v5-member', false );

											echo '<h4 class="team-v5-member">'. $oneLine->getWpKses('full-name text') .'</h4>';
										$this->_advancedToggleBoxEnd( $oneLine->get('full-name') );

										$this->_advancedToggleBoxStart( $oneLine->get('position') );
											ffElTeam5::_renderColor( $oneLine->getColor('position text-color'), 'color', null, '.team-v5-member-position', false );

											echo '<span class="team-v5-member-position">'. $oneLine->getWpKses('position text') .'</span>';
										$this->_advancedToggleBoxEnd( $oneLine->get('position') );

									echo '</div>';

								echo '</div>';
							echo '</div>';
						$this->_applySystemTabsOnRepeatableEnd( $oneLine );
						break;

					case 'one-contact':

						if( $oneLine->getColor('contact-link-color') ){
							$this->getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.team-v5-author-contact', false)
								->addParamsString('color: ' . $oneLine->getColor('contact-link-color') . ';');
						}

						if( $oneLine->getColor('contact-link-hover-color') ){
							$this->getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.team-v5-author-contact:hover', false)
								->addParamsString('color: ' . $oneLine->getColor('contact-link-hover-color') . ';');
						}

						if( ! $isInContent){ echo '<div class="team-v5-content '. $query->getEscAttr('align') .'">'; $isInContent = true; }

						$this->_applySystemTabsOnRepeatableStart( $oneLine );
							echo '<a ' . $this->_getBlock( ffThemeBuilderBlock::LINK )->setParam('classes', 'team-v5-author-contact')->get( $oneLine ) . '>'
								. $oneLine->getWpKses('contact-text')
								. '</a>';
						$this->_applySystemTabsOnRepeatableEnd( $oneLine );

						break;

					case 'one-line':

						if( ! $isInContent){ echo '<div class="team-v5-content '. $query->getEscAttr('align') .'">'; $isInContent = true; }

						$this->_applySystemTabsOnRepeatableStart( $oneLine );

						echo '<div class="progress-box team-v5-progress-box">';
							echo '<h4 class="progress-title '. $oneLine->get('font', 'font-style-inherit') .'">'
								. $oneLine->get('text', 'Graphic Design')
								. '&nbsp;<span class="pull-right">'
								. $oneLine->get('value', 83)
								. $oneLine->get('unit', '%')
								. '</span>'
								. '</h4>';
							
							echo ' <div class="progress radius-none-'. $oneLine->get('use-radius') .' progress-'. $oneLine->get('style', 'sm') .'">';

								$this->_getAssetsRenderer()->createCssRule()
									->addSelector( '.progress' )
									->addParamsString( 'background-color: '. $oneLine->getColorWithoutComparationDefault('bg-color', '#f5f5f5') .';' );

								$this->_getAssetsRenderer()->createCssRule()
									->addSelector( '.progress-bar' )
									->addParamsString( 'background-color: '. $oneLine->getColorWithoutComparationDefault('fg-color', '[1]') .';' );

								echo '<div class="progress-bar" role="progressbar" data-width="'. $oneLine->get('value', 83) .'"></div>';
							echo '</div>';
						echo '</div>';

						$this->_applySystemTabsOnRepeatableEnd( $oneLine );

						break;

				}
			}

			if( $isInContent){ echo '</div>'; }

		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'image':
								blocks.render('image', query);
								query.addHeadingLg('full-name text');
								query.addHeadingSm('position text');
								break;
							case 'one-line':
								var text = query.get('text');
								var status = query.get('value');
								var unit = query.get('unit');

								query.addHeadingSm(null, text + ': ' + status + unit );
								break;
							case 'one-contact':
								query.addLink('contact-text');
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}