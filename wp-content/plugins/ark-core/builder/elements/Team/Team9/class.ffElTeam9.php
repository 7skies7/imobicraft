<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_team_members.html#scrollTo__1900
 */

class ffElTeam9 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'team-9');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Team 9', 'ark' ) ) );
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
						->setParam('width', 185)
						->setParam('height', 185)
						->injectOptions( $s );

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'image-border-size', '', '12')
						->addParam('print-in-content', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Image Border Size (in px)', 'ark' ) ) )
					;
					$s->addElement(ffOneElement::TYPE_NEW_LINE);
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'image-border-color', '', '#ffffff')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Image Border Color', 'ark' ) ) )
					;
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'image-box-shadow', '', '#f2f4f9')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Image Box Shadow Color', 'ark' ) ) )
					;
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'image-hover-overlay-bg-color', '', 'rgba(52,52,60,0.5)')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Image Hover Overlay Background Color', 'ark' ) ) )
					;

				$s->endAdvancedToggleBox();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Image Overlay', 'ark' ) ) );

				$s->startRepVariableSection('repeated-lines');

					$s->startRepVariationSection('one-line', ark_wp_kses( __('Social Link', 'ark' ) ));

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

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Personal Info', 'ark' ) ) );

				$s->startRepVariableSection('content');

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
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
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

	protected function _renderColor( $query, $key ) {

		if( $query->getColor('icon-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.icon-'.$key.'.theme-icons')
				->addParamsString('color: ' . $query->getColor('icon-color') .';');
		}

		if( $query->getColor('icon-hover-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.icon-'.$key.'.theme-icons:hover')
				->addParamsString('color: ' . $query->getColor('icon-hover-color') .';');
		}

		if( $query->getColor('bg-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.icon-'.$key.'.theme-icons')
				->addParamsString('background-color: ' . $query->getColor('bg-color') .';');
		}

		if( $query->getColor('bg-hover-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.icon-'.$key.'.theme-icons:hover')
				->addParamsString('background-color: ' . $query->getColor('bg-hover-color') .';');
		}
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		if( $query->getColor('image image-border-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector(' .team-v9-img-wrap')
				->addParamsString('background-color: ' . $query->getColor('image image-border-color') . ';');
		}

		if( $query->getColor('image image-box-shadow') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector(' .team-v9-img-wrap')
				->addParamsString('box-shadow: 0 2px 5px 2px ' . $query->getColor('image image-box-shadow') . ';');
		}

		if( $query->get('image image-border-size') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector(' .team-v9-img-wrap')
				->addParamsString('padding: ' . $query->get('image image-border-size') . 'px;');
		}

		if( $query->get('image image-border-size') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector(' .team-v9-socials')
				->addParamsString('padding: ' . $query->get('image image-border-size') . 'px;');
		}

		if( $query->getColor('image image-hover-overlay-bg-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector(' .team-v9-img-wrap:hover .team-v9-img-effect:before')
				->addParamsString('background-color: ' . $query->getColor('image image-hover-overlay-bg-color') . ';');
		}

		echo '<section class="team-v9 '. $query->getEscAttr('align') .'">';

			echo '<div class="team-v9-img-wrap radius-circle">';

				if( $query->exists('image') ) {
					echo '<div class="team-v9-img-effect radius-b-circle">';
						$this->_advancedToggleBoxStart( $query->get('image') );
							$this->_getBlock( ffThemeBlConst::IMAGE )
								->imgIsResponsive()
								->setParam('width', 185)
								->setParam('height', 185)
								->setParam('css-class', 'team-v9-img radius-circle')
								->render( $query->get('image') );
						$this->_advancedToggleBoxEnd( $query->get('image') );
					echo '</div>';
				}


				if( $query->exists('repeated-lines') ){
					echo '<ul class="list-inline team-v9-socials ul-li-lr-1">';
						foreach( $query->get('repeated-lines') as $key => $oneLink ) {
							echo '<li class="theme-icons-wrap">';
								echo '<a ';
									$this->_getBlock( ffThemeBuilderBlock::LINK )->render( $oneLink );
								echo '>';
									ffElTeam9::_renderColor( $oneLink, $key );
								echo '<i class="theme-icons icon-'.$key.' theme-icons-xs radius-circle margin-b-0 '. $oneLink->getEscAttr('icon') .'"></i></a>';
							echo '</li>';
						}
					echo '</ul>';
				}

			echo '</div>';

			if( $query->exists('content') ) {
				foreach ($query->get('content') as $key => $oneLine) {
					switch ($oneLine->getVariationType()) {
						case 'name':
							echo '<h4 class="team-v9-name">' . $oneLine->getWpKses('text') . '</h4>';
							break;
						case 'position':
							echo '<span class="team-v9-position">' . $oneLine->getWpKses('text') . '</span>';
							break;
					}
				}
			}

		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				blocks.render('image', query.get('image'));

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
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

				if(query.queryExists('repeated-lines')) {
					query.get('repeated-lines').each(function (query, variationType) {
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