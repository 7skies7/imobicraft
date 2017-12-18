<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_team_members.html#scrollTo__4800
 */

class ffElTeam4 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'team-4');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Team 4', 'ark' ) ) );
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

					/* NAME */
					$s->startRepVariationSection('name', ark_wp_kses( __('Full name', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'David Martin')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );

					$s->endRepVariationSection();

					/* POSITION */
					$s->startRepVariationSection('position', ark_wp_kses( __('Position', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Director')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );

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

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		echo '<section class="team-v4 '. $query->getEscAttr('align') .'">';

			$isInContent = false;

			foreach( $query->get('content') as $oneLine ) {
				switch( $oneLine->getVariationType() ) {

					case 'image':
						if( $isInContent){ echo '</div>'; $isInContent = false; }

						$this->_applySystemTabsOnRepeatableStart( $oneLine );

						echo '<div class="team-v4-img-wrap">';

							// Escaped image block
							echo ( $this->_getBlock( ffThemeBlConst::IMAGE )
								->imgIsResponsive()
								->imgIsFullWidth()
								->setParam('width', 698)
								->get( $oneLine ) );

							if( $oneLine->exists('social-lines') ) {
								echo '<ul class="list-inline team-v4-overlay-content ul-li-lr-2 '. $oneLine->getEscAttr('icons-align') .'">';
									foreach( $oneLine->getWithoutCallbacks('social-lines') as $key => $oneLink ) {
										echo '<li class="theme-icons-wrap">';
											echo '<a ' . $this->_getBlock( ffThemeBuilderBlock::LINK )->get( $oneLink ) . '>';

												ffElTeam4::_renderColor( $oneLink, $key );

												echo '<i class="theme-icons icon-'.$key.' theme-icons-white-bg theme-icons-sm '. $oneLink->getEscAttr('icon') .'"></i>';
											echo '</a>';
										echo '</li>';
									}
								echo '</ul>';
							}

						echo '</div>';

						$this->_applySystemTabsOnRepeatableEnd( $oneLine );

						break;

					case 'name':
						if( ! $isInContent){ echo '<div class="team-v4-content">'; $isInContent = true; }

						$toPrint = '<h4 class="team-v4-member">'. $oneLine->getWpKses('text') .'</h4>';

						$toPrint = $this->_applySystemThingsOnRepeatable( $toPrint, $oneLine );
						// Escaped person name
						echo ( $toPrint );
						break;

					case 'position':
						if( ! $isInContent){ echo '<div class="team-v4-content">'; $isInContent = true; }

						$toPrint = '<span class="team-v4-member-position">'. $oneLine->getWpKses('text') .'</span>';

						$toPrint = $this->_applySystemThingsOnRepeatable( $toPrint, $oneLine );
						// Escaped position
						echo ( $toPrint );
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
								if( query.exists('social-lines') ) {
									query.get('social-lines').each(function (query, variationType) {
										switch (variationType) {
											case 'one-line':
												query.addIcon('icon');
												break;
										}
									});
								}

								break;
							case 'name':
								query.addHeadingLg('text');
								break;
							case 'position':
								query.addHeadingSm('text');
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}