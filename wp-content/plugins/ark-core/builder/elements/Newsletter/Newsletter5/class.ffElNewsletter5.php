<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_newsletter.html#scrollTo__397
 * */


class ffElNewsletter5 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'newsletter-5');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Newsletter 5', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'newsletter');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'newsletter, socials, social media');

		$this->_setColor('light');

	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE TITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Newsletter')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
						$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'show-border', ark_wp_kses( __('Show column border', 'ark' ) ), 0);
						$s->addElement(ffOneElement::TYPE_NEW_LINE);
						$this->_getBlock( ffThemeBuilderBlock::BOOTSTRAP_COLUMNS )->setParam('default', array('xs'=>12,'sm'=>2))->injectOptions( $s );
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE SUBSCRIBE BOX
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('subscribe', ark_wp_kses( __('Subscribe Form', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'placeholder', '', 'Email Address')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Input placeholder text', 'ark' ) ) )
						;
						$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'show-border', ark_wp_kses( __('Show column border', 'ark' ) ), 0);
						$this->_getBlock( ffThemeBuilderBlock::BOOTSTRAP_COLUMNS )->setParam('default', array('xs'=>12,'sm'=>3))->injectOptions( $s );
						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-color', '', '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Placeholder text color', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Input background color', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '', '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Input border color', 'ark' ) ) )
						;
						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL(ffOneOption::TYPE_ICON,'icon','Button icon','ff-font-awesome4 icon-send');
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon color', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'hover-color', '', '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon hover color', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-bg-color', '', '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Button background color', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE SOCIAL MEDIA
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('social-box', ark_wp_kses( __('Social Media', 'ark' ) ) );
						$this->_getBlock( ffThemeBuilderBlock::BOOTSTRAP_COLUMNS )->setParam('default', array('xs'=>12,'sm'=>3))->injectOptions( $s );
						$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'show-border', ark_wp_kses( __('Show column border', 'ark' ) ), 0);

						$s->startRepVariableSection('repeated-lines');

							$s->startRepVariationSection('social-icon', ark_wp_kses( __('Social Icon', 'ark' ) ) );

								$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 icon-send')
									->addParam('print-in-content', true)
								;
								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', '')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon color', 'ark' ) ) )
								;
								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'hover-color', '', '')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon hover color', 'ark' ) ) )
								;
								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-bg-color', '', '')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background color', 'ark' ) ) )
								;
								$s->addElement(ffOneElement::TYPE_NEW_LINE);

								$this->_getBlock( ffThemeBuilderBlock::LINK)->injectOptions( $s );

							$s->endRepVariationSection();

						$s->endRepVariableSection();

					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected  function  _placeholderColor($plColor, $bgColor, $borderColor){

		if($plColor) {
			$selectors = array('input::-webkit-input-placeholder', 'input:-moz-placeholder', 'input::-moz-placeholder', 'input:-ms-input-placeholder');

			foreach ($selectors as $sel) {
				$this->getAssetsRenderer()->createCssRule()
					->setAddWhiteSpaceBetweenSelectors(true)
					->addSelector($sel, false)
					->addParamsString('color:' . $plColor .';');
			}
		}

		if($bgColor){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(true)
				->addSelector('.newsletter-v5-form')
				->addParamsString('background:' . $bgColor .';');
		}

		if($borderColor){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(true)
				->addSelector('.newsletter-v5-form')
				->addParamsString('border-color:' . $borderColor .';');
		}

	}

	protected  function  _buttonColor($iconColor, $hoverColor, $bgColor){

		if($iconColor) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(true)
				->addSelector('.newsletter-v5-btn')
				->addParamsString('color:' . $iconColor .';');
		}

		if($hoverColor){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(true)
				->addSelector('.newsletter-v5-btn:hover')
				->addParamsString('color:' . $hoverColor .';');
		}

		if($bgColor){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(true)
				->addSelector('.newsletter-v5-btn')
				->addParamsString('background:' . $bgColor .';');
		}

	}

	protected  function  _iconColor($iconColor, $hoverColor, $bgColor){

		if($iconColor) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(true)
				->addSelector('.theme-icons')
				->addParamsString('color:' . $iconColor .';');
		}

		if($hoverColor){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(true)
				->addSelector('.theme-icons:hover')
				->addParamsString('color:' . $hoverColor .';');
		}

		if($bgColor){
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(true)
				->addSelector('.theme-icons')
				->addParamsString('background:' . $bgColor .';');
		}

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		echo '<section class="newsletter-v5">';
			echo '<div class="content">';
				echo '<div class="row">';

					foreach( $query->get('content') as $oneLine ) {
						switch( $oneLine->getVariationType() ) {

							case 'title':
								echo '<div class="'.$this->_getBlock( ffThemeBuilderBlock::BOOTSTRAP_COLUMNS )->render( $oneLine ) .' ' .(($oneLine->get('show-border'))?'newsletter-v5-border':''). ' newsletter-v5-cols text-right sm-text-center">';
									$toPrint = '<h3 class="newsletter-v5-title">';
										$toPrint .= $oneLine->getWpKses('text');
									$toPrint .= '</h3>';
									echo ( $this->_applySystemThingsOnRepeatable($toPrint, $oneLine) );
								echo '</div>';
								break;

							case 'subscribe':
								echo '<div class="'.$this->_getBlock( ffThemeBuilderBlock::BOOTSTRAP_COLUMNS )->render( $oneLine ) .' ' .(($oneLine->get('show-border'))?'newsletter-v5-border':''). ' newsletter-v5-cols">';
									echo '<div class="input-group">';
										$this->_placeholderColor($oneLine->getColor('text-color'),$oneLine->getColor('bg-color'),$oneLine->getColor('border-color'));
										echo '<input type="text" class="form-control newsletter-v5-form radius-0" placeholder="' . $oneLine->getWpKses('placeholder') . '">';

										echo '<span class="input-group-btn">';
											$this->_buttonColor($oneLine->getColor('icon-color'),$oneLine->getColor('hover-color'),$oneLine->getColor('icon-bg-color'));
											echo '<button class="btn-dark-bg btn-base-md newsletter-v5-btn" type="button"><i class="'.$oneLine->getWpKses('icon').'"></i></button>';
										echo '</span>';
									echo '</div>';
								echo '</div>';
								break;

							case 'social-box':
								echo '<div class="'.$this->_getBlock( ffThemeBuilderBlock::BOOTSTRAP_COLUMNS )->render( $oneLine ) .' ' .(($oneLine->get('show-border'))?'newsletter-v5-border':''). ' newsletter-v5-cols text-right sm-text-center">';
									echo '<ul class="list-inline ul-li-lr-2">';

										foreach( $oneLine->get('repeated-lines') as $oneIcon ) {

											echo '<li class="theme-icons-wrap">';
												$this->_iconColor($oneIcon->getColor('icon-color'),$oneIcon->getColor('hover-color'),$oneIcon->getColor('icon-bg-color'));
												$toPrint = '<a ';
												$toPrint .= $this->_getBlock( ffThemeBuilderBlock::LINK )->get( $oneIcon );
												$toPrint .= '>';
												$toPrint .= '<i class="theme-icons theme-icons-dark-bg theme-icons-md '. $oneIcon->getEscAttr('icon') .'"></i></a>';
												echo ( $this->_applySystemThingsOnRepeatable($toPrint,$oneIcon) );
											echo '</li>';

										}

									echo '</ul>';
								echo '</div>';
								break;
						}
					}

				echo '</div>';
			echo '</div>';
		echo '</section>';

	}


	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks ) {

				query.get('content').each(function(query, variationType){
					switch(variationType){
						case 'title':
							query.addHeadingLg('text');
							break;
						case 'subscribe':
							query.addText('placeholder', 'Input: ');
							query.addIcon('icon', 'Button icon: ');
							break;
						case 'social-box':
							query.get('repeated-lines').each(function(query, variationType ){
								switch(variationType){
									case 'social-icon':
										query.addIcon( 'icon' );
										break;
								}
							});
							break;
					}
				});

			}
		</script data-type="ffscript">
	<?php
	}


}