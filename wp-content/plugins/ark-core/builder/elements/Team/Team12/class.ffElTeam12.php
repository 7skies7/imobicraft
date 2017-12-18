<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_team_members.html#scrollTo__375
 */

class ffElTeam12 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'team-12');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Team 12', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'team');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'team, team member, person, biography');

		$this->_setColor('light');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Image Settings', 'ark' ) ) );
				$s->startAdvancedToggleBox('image', esc_attr( __('Image Settings', 'ark' ) ) );
					$this->_getBlock( ffThemeBlConst::IMAGE )
						->imgIsResponsive()
						->imgIsFullWidth()						
						->setParam('width', 738)
						->injectOptions( $s );
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'image-hover-overlay-bg-color', '', 'rgba(52,52,60,0.5)')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Image Hover Overlay Background Color', 'ark' ) ) )
					;
				$s->endAdvancedToggleBox();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/* FULL NAME */
					$s->startRepVariationSection('full-name', ark_wp_kses( __('Full Name', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Leyla Gomez')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/* POSITION */
					$s->startRepVariationSection('position', ark_wp_kses( __('Position', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Designer')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/* DESCRIPTION */
					$s->startRepVariationSection('description', ark_wp_kses( __('Paragraph', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'I am a web designer based in New York. I have a passion for web design and love to create for web and mobile devices.')
							->addParam('print-in-content', true)
						;
					$s->endRepVariationSection();

					/* SOCIAL BOX */
					$s->startRepVariationSection('social-box', ark_wp_kses( __('Social Links', 'ark' ) ) );

						$s->startRepVariableSection('social-icons');

							$s->startRepVariationSection('social-icon', ark_wp_kses( __('Social Links', 'ark' ) ) );

								$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 icon-facebook')
									->addParam('print-in-content', true)
								;
								$s->addElement(ffOneElement::TYPE_NEW_LINE);

								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', '#ffffff')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color', 'ark' ) ) )
								;
								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-hover-color', '', '#ffffff')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Hover Color', 'ark' ) ) )
								;
								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '#44619d')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Background Color', 'ark' ) ) )
								;
								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-hover-color', '', '#44619d')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Background Hover Color', 'ark' ) ) )
								;
								$s->addElement(ffOneElement::TYPE_NEW_LINE);

								$this->_getBlock( ffThemeBuilderBlock::LINK )->injectOptions( $s );

							$s->endRepVariationSection();

						$s->endRepVariableSection();

					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Horizontal Alignment', 'ark' ) ) );
				$s->addOption( ffOneOption::TYPE_SELECT, 'align', '', 'text-left')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'text-left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'text-center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'text-right')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Vertical Alignment', 'ark' ) ) );
				$s->addOption( ffOneOption::TYPE_SELECT, 'vert-align', '', 'vert-align-top')
					->addSelectValue( esc_attr( __('Top', 'ark' ) ), 'vert-align-top')
					->addSelectValue( esc_attr( __('Middle', 'ark' ) ), 'vert-align-middle')
					->addSelectValue( esc_attr( __('Bottom', 'ark' ) ), 'vert-align-bottom')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _renderColor( $query, $key ) {

		if( $query->getColor('icon-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.icon-'.$key.'.animate-icon-wrap')
				->addParamsString('color: ' . $query->getColor('icon-color') .';');
		}

		if( $query->getColor('icon-hover-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.icon-'.$key.'.animate-icon-wrap:hover')
				->addParamsString('color: ' . $query->getColor('icon-hover-color') .';');
		}

		if( $query->getColor('bg-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.icon-'.$key.'.animate-icon-wrap')
				->addParamsString('background-color: ' . $query->getColor('bg-color') .';');
		}

		if( $query->getColor('bg-hover-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.icon-'.$key.'.animate-icon-wrap:hover')
				->addParamsString('background-color: ' . $query->getColor('bg-hover-color') .';');
		}
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		if( $query->getColor('image image-hover-overlay-bg-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector(' .team-v12-info:before')
				->addParamsString('background-color: ' . $query->getColor('image image-hover-overlay-bg-color') . ';');
		}

		echo '<section class="team-v12">';

			if( $query->exists('image') ) {
				$this->_advancedToggleBoxStart( $query->get('image') );
					$this->_getBlock( ffThemeBlConst::IMAGE )
						->imgIsResponsive()
						->imgIsFullWidth()						
						->setParam('width', 738)
						->setParam('css-class', 'team-v12-img')
						->render( $query->get('image') );
				$this->_advancedToggleBoxEnd( $query->get('image') );
			}

			if( $query->exists('content') ) {
				echo '<div class="team-v12-info '. $query->getEscAttr('align') .'">';

					echo '<div class="team-v12-info-inner '. $query->getEscAttr('vert-align') .'">';

						foreach( $query->get('content') as $oneLine ) {
							switch( $oneLine->getVariationType() ) {
								case 'full-name':
									echo '<h4 class="team-v12-name">'. $oneLine->getWpKses('text') .'</h4>';
									break;

								case 'position':
									echo '<h5 class="team-v12-position">'. $oneLine->getWpKses('text') .'</h5>';
									break;

								case 'description':
									$oneLine->printWpKsesTextarea( 'text', '<p class="team-v12-text">', '</p>', '<div class="team-v12-text ff-richtext">', '</div>' );
									break;

								case 'social-box':
									if( ! $oneLine->exists('social-icons') ) {
										continue;
									}
									echo '<ul class="list-inline team-v12-socials ul-li-lr-2">';

										foreach( $oneLine->get('social-icons') as $key => $oneIcon ) {
											echo '<li class="animate-icon">';

												ffElTeam12::_renderColor( $oneIcon, $key );

												echo '<a ';
													$this->_getBlock( ffThemeBuilderBlock::LINK )->setParam('classes', 'icon-'.$key.' animate-icon-wrap animate-icon-xs')->render( $oneIcon );
												echo '>';

													echo '<i class="animate-icon-item '. $oneIcon->getEscAttr('icon') .'"></i>';
													echo '<i class="animate-icon-item '. $oneIcon->getEscAttr('icon') .'"></i>';

												echo '</a>';

											echo '</li>';
										}

									echo '</ul>';
									break;
							}
						}

					echo '</div>';

				echo '</div>';
			}
		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				blocks.render('image', query);

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'full-name':
								query.addHeadingLg('text');
								break;
							case 'position':
								query.addHeadingSm('text');
								break;
							case 'description':
								query.addText('text');
								break;
							case 'social-box':
								query.get('social-icons').each(function (query, variationType) {
									switch (variationType) {
										case 'social-icon':
											query.addIcon('icon');
											break;
									}
								});
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}