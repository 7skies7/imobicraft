<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_team_members.html#scrollTo__3000
 */

class ffElTeam11 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'team-11');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Team 11', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'team');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'team, team member, person, biography');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

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

				$s->startRepVariableSection('personal-items');

					/* FULL NAME */
					$s->startRepVariationSection('full-name', ark_wp_kses( __('Full name', 'ark' ) ) );
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

					/* CONTACT-BOX */
					$s->startRepVariationSection('contact', ark_wp_kses( __('Contact Link', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'label', '', 'email: ')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Label Prefix', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'robert@ark.com')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Link Text', 'ark' ) ) )
						;

						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$this->_getBlock( ffThemeBuilderBlock::LINK )->injectOptions( $s );

						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'use-bot-margin', ark_wp_kses( __('Apply bottom margin', 'ark' ) ), 1);

						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'contact-link-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Link Color', 'ark' ) ) )
						;

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'contact-link-hover-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Link Hover Color', 'ark' ) ) )
						;

					$s->endRepVariationSection();

					/* DESCRIPTION */
					$s->startRepVariationSection('description', ark_wp_kses( __('Paragraph', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'I am an ambitious workaholic and web designer based in New York. I have a passion for web design and love to create for web and mobile devices.')
							->addParam('print-in-content', true);

					$s->endRepVariationSection();

					/* SOCIAL BOX */
					$s->startRepVariationSection('social-box', ark_wp_kses( __('Social Links', 'ark' ) ) );

						$s->startRepVariableSection('social-icons');

							$s->startRepVariationSection('social-icon', ark_wp_kses( __('Social Link', 'ark' ) ) );

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


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Layout', 'ark' ) ) );
				$s->addOption( ffOneOption::TYPE_SELECT, 'items-align', '', 'text-left')
					->addSelectValue( esc_attr( __('Image on the Left side & Content on the Right side', 'ark' ) ), 'img-left')
					->addSelectValue( esc_attr( __('Image on the Right side & Content on the Left side', 'ark' ) ), 'img-right')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$s->addOption( ffOneOption::TYPE_SELECT, 'align', '', 'text-left')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'text-left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'text-center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'text-right')
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

		echo '<section class="team-v11">';
			echo '<div class="row">';

				echo '<div class="col-xs-12 col-sm-5 team-v11-img';
					if( 'img-left' != $query->get('items-align') ) {
						echo ' col-md-push-7';
					}
				echo '">';
					if( $query->exists('image') ) {
						echo '<div class="team-v11-img-wrap">';
							$this->_advancedToggleBoxStart( $query->get('image') );
								$this->_getBlock( ffThemeBlConst::IMAGE )
									->imgIsResponsive()
									->imgIsFullWidth()
									->setParam('width', 738)
									->setParam('css-class', 'team-v11-img center-block')
									->render( $query->get('image') );
							$this->_advancedToggleBoxEnd( $query->get('image') );
						echo '</div>';
					}
				echo '</div>';

				if( $query->exists('personal-items') ){
					if( 'img-left' == $query->get('items-align') ) {
						echo ' <div class="col-xs-12 col-sm-7 ' . $query->getWpKses('align') . '">';
					} else {
						echo ' <div class="col-xs-12 col-sm-7 col-sm-pull-5 ' . $query->getWpKses('align') . '">';
					}

							foreach( $query->get('personal-items') as $oneItem ) {
								switch ($oneItem->getVariationType()) {

									case 'full-name':
										echo '<h4 class="team-v11-name">' . $oneItem->getWpKses('text') . '</h4>';
										break;

									case 'position':
										echo '<div class="team-v11-position">' . $oneItem->getWpKses('text') . '</div>';
										break;

									case 'contact':

										if( $oneItem->getColor('contact-link-color') ){
											$this->getAssetsRenderer()->createCssRule()
												->setAddWhiteSpaceBetweenSelectors(false)
												->addSelector(' a', false)
												->addParamsString('color: ' . $oneItem->getColor('contact-link-color') . ';');
										}

										if( $oneItem->getColor('contact-link-hover-color') ){
											$this->getAssetsRenderer()->createCssRule()
												->setAddWhiteSpaceBetweenSelectors(false)
												->addSelector(' a:hover', false)
												->addParamsString('color: ' . $oneItem->getColor('contact-link-hover-color') . ';');
										}

										$marginBottom = 'class="team-v11-content"';
										if($oneItem->get('use-bot-margin')){
											$marginBottom = '';
										}
											echo '<p '. $marginBottom .'><strong>' . $oneItem->getWpKses('label') . '</strong>';
												echo '<a ';
													$this->_getBlock( ffThemeBuilderBlock::LINK )->render( $oneItem );
												echo '>' . $oneItem->getWpKses('text') . '</a>';
											echo '</p>';
										break;

									case 'description':
										$oneItem->printWpKsesTextarea( 'text', '<p class="team-v11-description">', '</p>', '<div class="team-v11-description ff-richtext">', '</div>' );
										break;

									case 'social-box':
										if( $oneItem->exists('social-icons') ){
											echo '<ul class="list-inline ul-li-lr-2">';

												foreach( $oneItem->get('social-icons') as $key => $oneIcon ) {

													echo '<li class="animate-icon">';

														ffElTeam11::_renderColor( $oneIcon, $key );

														echo '<a ';
															$this->_getBlock(ffThemeBuilderBlock::LINK)->setParam('classes', 'icon-'.$key.' animate-icon-wrap animate-icon-sm')->render($oneIcon);
														echo '>';

															echo '<i class="animate-icon-item ' . $oneIcon->getEscAttr('icon') . '"></i>';
															echo '<i class="animate-icon-item ' . $oneIcon->getEscAttr('icon') . '"></i>';

														echo '</a>';
													echo '</li>';

												}

											echo '</ul>';
										}

										break;

								}
							}

						echo '</div>';
				}

			echo '</div>';
		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				blocks.render('image', query.get('image'));

				if(query.queryExists('personal-items')) {

					query.get('personal-items').each(function (query, variationType) {
						switch (variationType) {
							case 'full-name':
								query.addHeadingLg('text');
								break;
							case 'position':
								query.addHeadingSm('text');
								break;
							case 'contact':
								query.addLink('text');
								query.addPlainText('<br>');
								break;
							case 'description':
								query.addText('text');
								break;
							case 'social-box':
								if (query.queryExists('social-icons')) {
									query.get('social-icons').each(function (query, variationType) {
										switch (variationType) {
											case 'social-icon':
												query.addIcon('icon');
												break;
										}
									});
									query.addPlainText('<br>');
								}
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}