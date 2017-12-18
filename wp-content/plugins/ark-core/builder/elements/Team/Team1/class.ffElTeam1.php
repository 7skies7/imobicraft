<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_team_members.html#scrollTo__3500
 */

class ffElTeam1 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'team-1');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Team 1', 'ark' ) ) );
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
							->injectOptions( $s );
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE FULL NAME
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('personal-info', ark_wp_kses( __('Full Name', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'David Martin')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE SOCIAL BOX
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('social-box', ark_wp_kses( __('Social Box', 'ark' ) ) );
						$s->startRepVariableSection('repeated-lines');

							$s->startRepVariationSection('one-line', ark_wp_kses( __('Social Link', 'ark' ) ) );

								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Facebook')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
								;
								$this->_getBlock( ffThemeBuilderBlock::LINK )->injectOptions( $s );

								$s->addElement(ffOneElement::TYPE_NEW_LINE);

								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'social-link-color', '', '')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Link Color', 'ark' ) ) )
								;

								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'social-link-hover-color', '', '[1]')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Link Hover Color', 'ark' ) ) )
								;

							$s->endRepVariationSection();

						$s->endRepVariableSection();
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

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'el-shadow', '', '#d8dde6')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Element Hover Box Shadow', 'ark' ) ) )
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		$box_shadow_selectors = array(
			'.team-v1:hover' => 'el-shadow',
		);

		foreach( $box_shadow_selectors as $selector => $c ){
			$color = $query->getColor( $c );
			if( $color ) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(false)
					->addSelector($selector, false)
					->addParamsString('box-shadow: 0 0 40px -6px ' . $color . ';');
			}
		}

		echo '<section class="team-v1 '. $query->getEscAttr('align') .'">';

			$isInContent = false;

			foreach( $query->get('content') as $key => $oneLine ) {
				
				switch( $oneLine->getVariationType() ) {

					case 'image':
						if( $isInContent ){ echo '</div>'; $isInContent = false; }

						$toPrint = $this->_getBlock( ffThemeBlConst::IMAGE )
							->imgIsResponsive()
							->imgIsFullWidth()
							->setParam('width', 738)
							->get( $oneLine );

						$toPrint = $this->_applySystemThingsOnRepeatable( $toPrint, $oneLine );
						// Escacped image block
						echo ( $toPrint );
						break;

					case 'personal-info':
						if( !$isInContent ){ echo '<div class="team-v1-content">'; $isInContent = true; }

						$toPrint = '<h4 class="team-v1-member">'. $oneLine->getWpKses('text') .'</h4>';

						$toPrint = $this->_applySystemThingsOnRepeatable( $toPrint, $oneLine );
						// Escaped description
						echo ( $toPrint );
						break;

					case 'social-box':
						if( $oneLine->exists('repeated-lines') ) {
							if( !$isInContent ){ echo '<div class="team-v1-content">'; $isInContent = true; }

							echo '<ul class="list-inline team-v1-socials">';

								foreach( $oneLine->get('repeated-lines') as $oneLink ) {

									if( $oneLink->getColor('social-link-color') ){
										$this->getAssetsRenderer()->createCssRule()
											->setAddWhiteSpaceBetweenSelectors(false)
											->addSelector(' a.team-v1-socials-link', false)
											->addParamsString('color: ' . $oneLink->getColor('social-link-color') . ';');
									}

									if( $oneLink->getColor('social-link-hover-color') ){
										$this->getAssetsRenderer()->createCssRule()
											->setAddWhiteSpaceBetweenSelectors(false)
											->addSelector(' a.team-v1-socials-link:hover', false)
											->addParamsString('color: ' . $oneLink->getColor('social-link-hover-color') . ';');
									}

									echo '<li>';
										echo '<a ';
											$this->_getBlock( ffThemeBuilderBlock::LINK )->setParam('classes', 'team-v1-socials-link')->render( $oneLink );
										echo '>'. $oneLink->getWpKses('text') .'</a>';
									echo '</li>';
								}

							echo '</ul>';
						}
						break;

				}
			}

			if( $isInContent ){ echo '</div>'; }

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
								query.addHeadingLg('text');
								break;
							case 'social-box':
								var socialLinks = '';
								query.get('repeated-lines').each(function (query, variationType) {
									switch (variationType) {
										case 'one-line':
											socialLinks += query.get('text');
											socialLinks += ' ';
											break;
									}

								});
								query.addText(null, socialLinks, '');
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}

}