<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_team_members.html#scrollTo__2350
 */

class ffElTeam10 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'team-10');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Team 10', 'ark' ) ) );
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
					/* TYPE IMAGE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('image', ark_wp_kses( __('Image', 'ark' ) ) );
						$this->_getBlock( ffThemeBlConst::IMAGE )
							->imgIsResponsive()
							->imgIsFullWidth()						
							->setParam('width', 738)
							->injectOptions( $s )
						;

						$s->addOptionNL( ffOneOption::TYPE_SELECT, 'design', '', 'one')
							->addSelectValue( esc_attr( __('Full color into B&W', 'ark' ) ), 'one')
							->addSelectValue( esc_attr( __('B&W into full color', 'ark' ) ), 'two')
							->addSelectValue( esc_attr( __('Partially B&W into full color', 'ark' ) ), 'three')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Image hover style', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE PERSONAL BOX
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('personal-info', ark_wp_kses( __('Personal Info', 'ark' ) ) );

						$s->startAdvancedToggleBox('name', esc_attr( __('Full Name', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Leyla Gomez')
								->addParam('print-in-content', true)
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
							;
						$s->endAdvancedToggleBox();

						$s->startAdvancedToggleBox('position', esc_attr( __('Position', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Designer')
								->addParam('print-in-content', true)
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
							;
						$s->endAdvancedToggleBox();

						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->startRepVariableSection('social-links');

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

					/*----------------------------------------------------------*/
					/* TYPE DESCRIPTION
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('description', ark_wp_kses( __('Paragraph', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'I am an ambitious workaholic and web designer based in New York. I have a passion for web design and love to create for web and mobile devices.')
							->addParam('print-in-content', true)
						;
						$s->addOption(ffOneOption::TYPE_SELECT, 'align', '', 'text-left')
							->addSelectValue('Left','text-left')
							->addSelectValue('Center','text-center')
							->addSelectValue('Right','text-right')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text align', 'ark' ) ) )
						;

					$s->endRepVariationSection();

				$s->endRepVariableSection();

				// Do not delete, any Element needs to have at least one (hidden) option
				$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="hidden">' );
					$s->addOption( ffOneOption::TYPE_TEXT, 'blank', 'blank');
				$s->addElement( ffOneElement::TYPE_HTML, '', '</div>' );


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
		if( ! $query->exists('content') ) {
			return;
		}

		echo '<section class="team-v10">';

			foreach( $query->get('content') as $oneLine ) {
				switch( $oneLine->getVariationType() ) {
					case 'image':
						$this->_getBlock(ffThemeBlConst::IMAGE)
							->imgIsResponsive()
							->imgIsFullWidth()						
							->setParam('width', 738)
							->setParam('css-class', 'team-v10-img-effect team-v10-img-effect-' . $oneLine->getEscAttr('design') . ' sm-full-width')
							->render($oneLine);
						break;

					case 'description':
						$oneLine->printWpKsesTextarea( 'text', '<p class="'. $oneLine->getEscAttr('align') .'">', '</p>', '<div class="'. $oneLine->getEscAttr('align') .' ff-richtext">', '</div>' );
						break;

					case 'personal-info':

						echo '<div class="team-v10-title clearfix">';

							if( $oneLine->exists('social-links') ){
								echo '<div class="team-v10-social-area text-right md-text-left">';
									echo '<ul class="list-inline ul-li-lr-2">';
										foreach( $oneLine->get('social-links') as $key => $oneIcon ) {
											ffElTeam10::_renderColor( $oneIcon, $key );
											echo '<li class="animate-icon">';
												echo '<a ';
													$this->_getBlock( ffThemeBuilderBlock::LINK )->setParam('classes', 'icon-'.$key.' animate-icon-wrap animate-icon-sm')->render( $oneIcon );
												echo '>';
													echo '<i class="animate-icon-item '. $oneIcon->getEscAttr('icon') .'"></i>';
													echo '<i class="animate-icon-item '. $oneIcon->getEscAttr('icon') .'"></i>';
												echo '</a>';
											echo '</li>';
										}
									echo '</ul>';
								echo '</div>';
							}

							echo '<div class="team-v10-personalities">';

								$this->_advancedToggleBoxStart( $oneLine->get('name') );
									echo '<h4 class="team-v10-name">'. $oneLine->getWpKses('name text') .'</h4>';
								$this->_advancedToggleBoxEnd( $oneLine->get('name') );

								$this->_advancedToggleBoxStart( $oneLine->get('position') );
									echo '<span class="team-v10-position">'. $oneLine->getWpKses('position text') .'</span>';
								$this->_advancedToggleBoxEnd( $oneLine->get('position') );

							echo '</div>';

						echo '</div>';
						break;
				}
			}

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
								break;
							case 'personal-info':
								query.addHeadingLg('name text');
								query.addHeadingSm('position text');

								if(query.queryExists('social-links')) {
									query.get('social-links').each(function (query, variationType) {
										switch (variationType) {
											case 'social-icon':
												query.addIcon('icon');
												break;
										}
									});
								}
								break;
							case 'description':
								query.addText('text');
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}