<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_team_members.html#scrollTo__800
 */

class ffElTeam7 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'team-7');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Team 7', 'ark' ) ) );
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
						->setParam('width', 698)
						->injectOptions( $s );
				$s->endAdvancedToggleBox();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Personal Info', 'ark' ) ) );

				$s->startRepVariableSection('personal-info');

					/*----------------------------------------------------------*/
					/* TYPE NAME
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('name', ark_wp_kses( __('Full Name', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Robert Smith')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );

					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE POSITION
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('position', ark_wp_kses( __('Position', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Designer')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );

					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Hidden Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE DESCRIPTION
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('description', ark_wp_kses( __('Paragraph', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'I am a web designer based in New York. I have a passion for web design and love to create for web and mobile devices. I am an ambitious workaholic, but apart from that, pretty simple person.')
							->addParam('print-in-content', true);

					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE SOCIAL BOX
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('social-box', ark_wp_kses( __('Social box', 'ark' ) ) );

						$s->startRepVariableSection('repeated-lines');

							$s->startRepVariationSection('one-line', ark_wp_kses( __('Social link', 'ark' ) ) );

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
								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '#34343c')
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


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$s->addOption(ffOneOption::TYPE_SELECT, 'align', '', 'text-left')
					->addSelectValue('Left','text-left')
					->addSelectValue('Center','text-center')
					->addSelectValue('Right','text-right')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'expand-color', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Expand Button Icon Color', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'expand-bg-color', '', '#34343c')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Expand Button Background', 'ark' ) ) )
				;
				$s->addElement(ffOneElement::TYPE_NEW_LINE);
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'collapse-color', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Collapse Button Icon Color', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'collapse-bg-color', '', '#34343c')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Collapse Button Background', 'ark' ) ) )
				;
				$s->addElement(ffOneElement::TYPE_NEW_LINE);
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'element-bg-color', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Element Background', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'element-box-color', '', '#f2f4f9')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Element Box Shadow', 'ark' ) ) )
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

		if( $query->getColor('expand-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.team-v7-btn .team-v7-trigger:before')
				->addParamsString('background-color: ' . $query->getColor('expand-color') . ';');
		}

		if( $query->getColor('expand-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.team-v7-btn .team-v7-trigger:after')
				->addParamsString('background-color: ' . $query->getColor('expand-color') . ';');
		}

		if( $query->getColor('expand-bg-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.team-v7-btn .team-v7-trigger')
				->addParamsString('background-color: ' . $query->getColor('expand-bg-color') . ';');
		}

		if( $query->getColor('collapse-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.team-v7-btn .team-v7-trigger.is-clicked:after')
				->addParamsString('background-color: ' . $query->getColor('collapse-color') . ';');
		}

		if( $query->getColor('collapse-bg-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.team-v7-btn .team-v7-trigger.is-clicked')
				->addParamsString('background-color: ' . $query->getColor('collapse-bg-color') . ';');
		}



		if( $query->getColor('element-bg-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addParamsString('background-color: ' . $query->getColor('element-bg-color') . ';');
		}

		if( $query->getColor('element-box-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addParamsString('box-shadow: 0 2px 5px 2px ' . $query->getColor('element-box-color') . ';');
		}

		echo '<section class="team-v7 '. $query->getEscAttr('align') .'">';

			if( $query->exists('image') ) {
				$this->_advancedToggleBoxStart($query->get('image'));
				$this->_getBlock(ffThemeBlConst::IMAGE)
					->imgIsResponsive()
					->imgIsFullWidth()
					->setParam('width', 698)
					->setParam('css-class', 'team-v7-img')
					->render($query->get('image'));
				$this->_advancedToggleBoxEnd($query->get('image'));
			}

			if( $query->exists('personal-info') ) {

				echo '<div class="row">';
					echo '<div class="col-xs-12 team-v7-info">';

							foreach( $query->get('personal-info') as $oneItem ) {
								switch ($oneItem->getVariationType()) {

									case 'name':
										echo '<h4 class="team-v7-name">'. $oneItem->getWpKses('text') .'</h4>';
										break;

									case 'position':
										echo '<span class="team-v7-position">'. $oneItem->getWpKses('text') .'</span>';
										break;

								}
							}

						echo '<div class="text-right team-v7-btn">';
								echo '<span class="team-v7-trigger radius-circle"></span>';
						echo '</div>';

					echo '</div>';

				echo '</div>';

				if( $query->exists('content') ){
					echo '<div class="team-v7-collapse">';

						foreach( $query->get('content') as $oneItem ) {
							switch( $oneItem->getVariationType() ) {
								case 'description':
									$oneItem->printWpKsesTextarea( 'text', '<p class="team-v7-text">', '</p>', '<div class="team-v7-text ff-richtext">', '</div>' );
									break;

								case 'social-box':

									echo '<ul class="list-inline ul-li-lr-2">';

										foreach( $oneItem->get('repeated-lines') as $key => $oneIcon ){
											echo '<li class="animate-icon">';

												ffElTeam7::_renderColor( $oneIcon, $key );

												echo '<a ';
													$this->_getBlock( ffThemeBuilderBlock::LINK )->setParam('classes', 'animate-icon-wrap icon-'.$key.' animate-icon-xs')->render( $oneIcon );
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
				}
			}

		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				blocks.render('image', query.get('image'));

				if(query.queryExists('personal-info')) {
					query.get('personal-info').each(function (query, variationType) {
						switch (variationType) {
							case 'name':
								query.addHeadingLg('text');
								break;
							case 'position':
								query.addHeadingSm('text');
								break;
						}
					});
				}

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'description':
								query.addText('text');
								break;
							case 'social-box':
								query.get('repeated-lines').each(function (query, variationType) {
									switch (variationType) {
										case 'one-line':
											query.addIcon('icon');
											break;
									}
								});
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}