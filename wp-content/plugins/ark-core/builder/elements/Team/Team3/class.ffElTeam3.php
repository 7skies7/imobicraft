<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_team_members.html#scrollTo__4450
 */

class ffElTeam3 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'team-3');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Team 3', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'team');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'team, team member, person, biography');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE IMAGE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('image', ark_wp_kses( __('Image', 'ark' ) ) );

						$this->_getBlock( ffThemeBlConst::IMAGE )
							->imgIsResponsive()
							->imgIsFullWidth()
							->setParam('width', 698)
							->injectOptions( $s );

						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL(ffOneOption::TYPE_SELECT, 'icons-align', '', 'text-center')
							->addSelectValue('Left','text-left')
							->addSelectValue('Center','text-center')
							->addSelectValue('Right','text-right')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Social Links Alignment', 'ark' ) ) )
						;

						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->startRepVariableSection('social-lines');

							$s->startRepVariationSection('one-line', ark_wp_kses( __('Social Link', 'ark' ) ) );

								$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 icon-facebook')
									->addParam('print-in-content', true)
								;
								$s->addElement(ffOneElement::TYPE_NEW_LINE);
								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', '#3a3a44')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color', 'ark' ) ) )
								;
								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-hover-color', '', '#ffffff')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Hover Color', 'ark' ) ) )
								;
								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '#ffffff')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Background Color', 'ark' ) ) )
								;
								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-hover-color', '', '[1]')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Background Hover Color', 'ark' ) ) )
								;
								$s->addElement(ffOneElement::TYPE_NEW_LINE);
								$this->_getBlock( ffThemeBuilderBlock::LINK )->injectOptions( $s );

							$s->endRepVariationSection();

						$s->endRepVariableSection();

					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE PERSONAL INFO
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('personal-info', ark_wp_kses( __('Personal Info', 'ark' ) ) );

						$s->startRepVariableSection('personal-items');

							$s->startRepVariationSection('one-info', ark_wp_kses( __('Full Name', 'ark' ) ) );
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'name', '', 'David Martin')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Full Name', 'ark' ) ) )
								;
							$s->endRepVariationSection();

							/* POSITION */
							$s->startRepVariationSection('position', ark_wp_kses( __('Position', 'ark' ) ) );
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Marketing')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
								;
								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'position-color', '', '[1]')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Position Color', 'ark' ) ) )
								;
							$s->endRepVariationSection();

							/* SEPARATOR */
							$s->startRepVariationSection('separator', ark_wp_kses( __('Separator', 'ark' ) ) );
								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bb-color', '', '#f1f1f1')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Separator Color', 'ark' ) ) )
								;
							$s->endRepVariationSection();

							/* DESCRIPTION */
							$s->startRepVariationSection('one-description', ark_wp_kses( __('Paragraph', 'ark' ) ) );
								$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'description', '', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry')
									->addParam('print-in-content', true)
								;
							$s->endRepVariationSection();

							/* PROGRESS BAR */
							$s->startRepVariationSection('skill', ark_wp_kses( __('Progress Bar', 'ark' ) ) );
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
							$s->startRepVariationSection('contact', ark_wp_kses( __('Contact Link', 'ark' ) ) );

								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Contact David')
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

					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$s->addOption(ffOneOption::TYPE_SELECT, 'align', '', 'text-left')
					->addSelectValue('Left','text-left')
					->addSelectValue('Center','text-center')
					->addSelectValue('Right','text-right')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );
				$s->addElement(ffOneElement::TYPE_NEW_LINE);
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'element-bg-color', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Element Background', 'ark' ) ) )
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _enqueueScriptsAndStyles( $query ) {
		wp_enqueue_script( 'ark-progress-bar' );
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		if( $query->getColor('element-bg-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addParamsString('background-color: ' . $query->getColor('element-bg-color') . ';');
		}

		echo '<section class="team-v3">';
			echo '<div class="row">';

				foreach( $query->get('content') as $oneLine ) {
					switch( $oneLine->getVariationType() ) {

						case 'image':
							echo '<div class="col-sm-5 sm-margin-b-20">';
								echo '<div class="team-v3-img-wrap">';

									// Escaped image block
									echo ( $this->_getBlock( ffThemeBlConst::IMAGE )
										->imgIsResponsive()
										->imgIsFullWidth()
										->setParam('width', 698)
										->get( $oneLine ) );

									if ( $oneLine->exists('social-lines') ){
									
										echo '<ul class="list-inline team-v3-overlay-content ul-li-lr-3 '. $oneLine->getEscAttr('icons-align') .'">';

											foreach( $oneLine->getWithoutCallbacks('social-lines') as $key => $oneLink ) {

												echo '<li class="theme-icons-wrap">';
													echo '<a ' . $this->_getBlock( ffThemeBuilderBlock::LINK )->get( $oneLink ) . '>';

														ffElTeam3::_renderColor( $oneLink, $key );

														echo '<i class="theme-icons icon-'.$key.' theme-icons-white-bg theme-icons-xs '. $oneLink->getEscAttr('icon') .'"></i>';
													echo '</a>';
												echo '</li>';
											}

										echo '</ul>';

									}

								echo '</div>';
							echo '</div>';
							break;

						case 'personal-info':
							if( ! $oneLine->exists('personal-items') ) {
								break;
							}
							echo '<div class="col-sm-7 '. $query->getEscAttr('align') .'">';

							foreach( $oneLine->get('personal-items') as $oneItem ) {
								switch( $oneItem->getVariationType() ) {

									case 'one-info':
										echo '<h4 class="team-v3-member">'. $oneItem->getWpKses('name') .'</h4>';
										break;

									case 'position':
										if( $oneItem->getColor('position-color') ){
											$this->getAssetsRenderer()->createCssRule()
												->addParamsString('color: '. $oneItem->getColor('position-color') .';');
										}

										echo '<span class="team-v3-member-position">'. $oneItem->getWpKses('text') .'</span>';
										break;

									case 'separator':
										if( $oneItem->getColor('bb-color') ){
											$this->getAssetsRenderer()->createCssRule()
												->addParamsString('border-bottom-color: '. $oneItem->getColor('bb-color') .';');
										}

										echo '<div class="team-v3-separator"></div>';
										break;

									case 'one-description':
										$oneItem->printWpKsesTextarea( 'description', '<p class="team-v3-paragraph">', '</p>', '<div class="team-v3-paragraph ff-richtext">', '</div>' );
										break;

									case 'skill':


										echo '<div class="progress-box">';
											echo '<h4 class="progress-title '. $oneItem->get('font', 'font-style-inherit') .'">'
												. $oneItem->get('text', 'Graphic Design')
												. '&nbsp;<span class="pull-right">'
													. $oneItem->get('value', 83)
													. $oneItem->get('unit', '%')
												. '</span>'
												. '</h4>';

											echo ' <div class="progress radius-none-'. $oneItem->get('use-radius') .' progress-'. $oneItem->get('style', 'sm') .'">';

												$this->_getAssetsRenderer()->createCssRule()
													->addSelector( '.progress' )
													->addParamsString( 'background-color: '. $oneItem->getColorWithoutComparationDefault('bg-color', '#f5f5f5') .';' );

												$this->_getAssetsRenderer()->createCssRule()
													->addSelector( '.progress-bar' )
													->addParamsString( 'background-color: '. $oneItem->getColorWithoutComparationDefault('fg-color', '[1]') .';' );

												echo '<div class="progress-bar" role="progressbar" data-width="'. $oneItem->get('value', 83) .'"></div>';
											echo '</div>';
										echo '</div>';
										break;

									case 'contact':

										if( $oneItem->getColor('contact-link-color') ){
											$this->getAssetsRenderer()->createCssRule()
												->setAddWhiteSpaceBetweenSelectors(false)
												->addSelector('.team-v8-link', false)
												->addParamsString('color: ' . $oneItem->getColor('contact-link-color') . ';');
										}

										if( $oneItem->getColor('contact-link-hover-color') ){
											$this->getAssetsRenderer()->createCssRule()
												->setAddWhiteSpaceBetweenSelectors(false)
												->addSelector('.team-v8-link:hover', false)
												->addParamsString('color: ' . $oneItem->getColor('contact-link-hover-color') . ';');
										}

										echo '<a ';
											$this->_getBlock( ffThemeBuilderBlock::LINK )->setParam('classes', 'team-v8-link')->render( $oneItem );
										echo '><i>';
											$oneItem->printWpKses('text');
										echo '</i></a>';
										break;

								}
							}

							echo '</div>';
							break;
					}
				}

			echo '</div>';
		echo '</section>';

	}

	protected function _renderColor( $query, $key ) {
		if( $query->getColor('icon-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.icon-'.$key.'.theme-icons-white-bg')
				->addParamsString('color: '. $query->getColor('icon-color') .';');
		}

		if( $query->getColor('icon-hover-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.icon-'.$key.'.theme-icons-white-bg:hover')
				->addParamsString('color: '. $query->getColor('icon-hover-color') .';');
		}

		if( $query->getColor('bg-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.icon-'.$key.'.theme-icons-white-bg')
				->addParamsString('background-color: '. $query->getColor('bg-color') .';');
		}

		if( $query->getColor('bg-hover-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.icon-'.$key.'.theme-icons-white-bg:hover')
				->addParamsString('background-color: '. $query->getColor('bg-hover-color') .';');
		}
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
								if(query.queryExists('social-lines')) {
									query.get('social-lines').each(function (query, variationType) {
										switch (variationType) {
											case 'one-line':
												query.addIcon('icon');
												break;
										}
									});
								}
								break;
							case 'personal-info':
								if (query.queryExists('personal-items')) {
									query.get('personal-items').each(function (query, variationType) {
										switch (variationType) {
											case 'one-info':
												query.addHeadingLg('name');
												break;
											case 'position':
												query.addHeadingSm('text');
												break;
											case 'separator':
												query.addPlainText('Separator');
												break;
											case 'one-description':
												query.addText('description');
												break;
											case 'skill':												
												var text = query.get('text');
												var status = query.get('value');
												var unit = query.get('unit');

												query.addHeadingSm(null, text + ': ' + status + unit );
												break;
											case 'contact':
												query.addLink('text');
												break;
										}
									});
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