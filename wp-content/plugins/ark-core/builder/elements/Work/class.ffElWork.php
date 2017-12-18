<?php
/**
 * @link http://prothemes.net/ark/HTML/shortcodes_work.html
 **/

class ffElWork extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'work');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Work', 'ark' ) ));
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'work');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'work, project');

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Image', 'ark' ) ) );

				$this->_getBlock( ffThemeBlConst::IMAGE )
					->imgIsResponsive()
					->imgIsFullWidth()
					->setParam('width', 970)
					->setParam('height', 1100)
					->injectOptions( $s );

				$s->addElement( ffOneElement::TYPE_NEW_LINE);

				$s->startAdvancedToggleBox('link', esc_attr( __('Image Hover Overlay', 'ark' ) ));

					$this->_getBlock( ffThemeBuilderBlock::LINK )->injectOptions( $s );

					$s->addElement( ffOneElement::TYPE_NEW_LINE);

					$s->addOptionNL(ffOneOption::TYPE_CHECKBOX,'show-button',ark_wp_kses( __('Show button on hover', 'ark' ) ),1);
					$s->startHidingBox('show-button', 'checked' );
						$s->addOptionNL(ffOneOption::TYPE_TEXT,'button-title','','View More')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Button title', 'ark' ) ) )
						;

						$s->addElement( ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'link-btn-text-color', '' , '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Button Text Color', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'link-btn-border-color', '' , '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Button Border Color', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'link-btn-bg-color', '' , '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Button Background Color', 'ark' ) ) );

						$s->addElement( ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'link-btn-text-hover-color', '' , '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Button Text Hover Color', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'link-btn-border-hover-color', '' , '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Button Border Hover Color', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'link-btn-bg-hover-color', '' , '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Button Background Hover Color', 'ark' ) ) );

					$s->endHidingBox();

					$s->addElement( ffOneElement::TYPE_NEW_LINE);

					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'overlay-color', '' , 'rgba(52, 52, 60, 0.3)')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Image Hover Overlay Color', 'ark' ) ) );

				$s->endAdvancedToggleBox();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Badge', 'ark' ) ) );

				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX,'show-badge',ark_wp_kses( __('Show Badge above content', 'ark' ) ),1);

				$s->startHidingBox('show-badge', 'checked' );

					$s->addElement(ffOneElement::TYPE_NEW_LINE);

					$s->startAdvancedToggleBox('badge', esc_attr( __('Badge', 'ark' ) ));

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'PSD')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Badge Text', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'badge-text-color', '', '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Badge Text Color', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'badge-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Badge Background Color', 'ark' ) ) )
						;

					$s->endAdvancedToggleBox();

				$s->endHidingBox();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startAdvancedToggleBox('content', esc_attr( __('Content', 'ark' ) ));

					$s->startRepVariableSection('content');

						/*----------------------------------------------------------*/
						/* TYPE TITLE
						/*----------------------------------------------------------*/
						$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ));
							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Ark PSD Template')
								->addParam('print-in-content', true)
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Title', 'ark' ) ) )
							;

							$s->addElement(ffOneElement::TYPE_NEW_LINE);

							$this->_getBlock( ffThemeBuilderBlock::LINK )->injectOptions( $s );
						$s->endRepVariationSection();

						/*----------------------------------------------------------*/
						/* TYPE SUBTITLE
						/*----------------------------------------------------------*/
						$s->startRepVariationSection('subtitle', ark_wp_kses( __('Subtitle', 'ark' ) ));
							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'category', '', 'Templates')
								->addParam('print-in-content', true)
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Category', 'ark' ) ) )
							;

							$s->addElement(ffOneElement::TYPE_NEW_LINE);

							$this->_getBlock( ffThemeBuilderBlock::LINK )->injectOptions( $s );

							$s->addElement(ffOneElement::TYPE_NEW_LINE);

							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'date', '', '23/01/2016')
								->addParam('print-in-content', true)
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Date', 'ark' ) ) )
							;
						$s->endRepVariationSection();

						/*----------------------------------------------------------*/
						/* TYPE CONTENT
						/*----------------------------------------------------------*/
						$s->startRepVariationSection('content', ark_wp_kses( __('Content', 'ark' ) ));
							$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', ark_wp_kses( __('Content', 'ark' ) ), 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.')
								->addParam('print-in-content', true)
							;
						$s->endRepVariationSection();

					$s->endRepVariableSection();

				$s->endAdvancedToggleBox();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'el-bg-color', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Element Background', 'ark' ) ) )
				;

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'el-shadow-color', '', 'rgba(0,0,0,0.07)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Element Box Shadow', 'ark' ) ) )
				;

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );


	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _renderColor( $query, $cssAttribute, $selector = null ) {

		if( $query && $selector ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector($selector)
				->addParamsString( $cssAttribute .': '. $query .';');;
		} else if( $query ){
			$this->getAssetsRenderer()->createCssRule()
				->addParamsString( $cssAttribute .': '. $query .';');
		}

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		echo '<section class="work-v1">';

			$this->_advancedToggleBoxStart( $query->get('link') );
				echo '<a ';
					$this->_getBlock(ffThemeBuilderBlock::LINK)->setParam('classes', 'work-v1-img-gradient')->render($query->get('link'));
				echo ' >';
					
						echo '<div class="work-active-bg"></div>';

						$this->_renderColor( $query->getColor( 'link overlay-color' ), 'background-color', ' .work-active-bg' );
						

						$this->_getBlock( ffThemeBlConst::IMAGE )
							->imgIsResponsive()
							->imgIsFullWidth()
							->setParam('width', 970)
							->setParam('height', 1100)
							->render( $query );

						if($query->get('link')->get('show-button')) {
							echo '<span class="work-v1-view btn-white-brd btn-base-sm radius-3">' . $query->get('link')->getWpKses('button-title') . '</span>';
						}
				echo '</a>';
			$this->_advancedToggleBoxEnd( $query->get('link') );

			if( $query->exists('content') ) {
				echo '<div class="work-v1-wrap">';

					$this->_advancedToggleBoxStart( $query->get('content') );

						echo '<div class="work-v1-content">';

							if ( $query->get('show-badge') ){

								$this->_advancedToggleBoxStart( $query->get('badge') );

									$this->_renderColor( $query->getColor( 'badge badge-text-color' ), 'color' );
									$this->_renderColor( $query->getColor( 'badge badge-color' ), 'background' );

									echo '<span class="work-v1-badge radius-3">';
										$query->printWpKses('badge text');
									echo '</span>';

								$this->_advancedToggleBoxEnd( $query->get('badge') );

							}

							foreach( $query->get('content content') as $oneLine ) {
								switch( $oneLine->getVariationType() ) {

									case 'title':
										echo '<h2 class="work-v1-title">';
											echo '<a ';
											$this->_getBlock(ffThemeBuilderBlock::LINK)->render($oneLine);
											echo '>';
												$oneLine->printWpKses('text');
											echo '</a>';
										echo '</h2>';
										break;

									case 'subtitle':
										echo '<ul class="list-inline work-v1-list">';

											echo '<li class="work-v1-category">';
												echo '<a ';
												$this->_getBlock(ffThemeBuilderBlock::LINK)->setParam('classes', 'work-v1-category-link')->render($oneLine);
												echo '>';
													$oneLine->printWpKses('category');
												echo '</a>';
											echo '</li>';
											echo ' <li class="work-v1-date">';
												$oneLine->printWpKses('date');
											echo '</li>';

										echo '</ul>';
										break;

									case 'content':
										echo '<div class="work-v1-collapse">';
											$oneLine->printWpKsesTextarea( 'text', '<p>', '</p>', '<div class=" ff-richtext">', '</div>' );
										echo '</div>';
										break;

								}
							}
						echo '</div>';

					$this->_advancedToggleBoxEnd( $query->get('content') );

				echo '</div>';
			}


		echo '</section>';

		if( $query->getColor('link link-btn-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .work-v1-view', false)
				->addParamsString('color: '.$query->getColor('link link-btn-text-color').';');
		}

		if( $query->getColor('link link-btn-border-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .work-v1-view', false)
				->addParamsString('border-color: '.$query->getColor('link link-btn-border-color').';');
		}

		if( $query->getColor('link link-btn-bg-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .work-v1-view', false)
				->addParamsString('background-color: '.$query->getColor('link link-btn-bg-color').';');
		}


		if( $query->getColor('link link-btn-text-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .work-v1-view:hover', false)
				->addParamsString('color: '.$query->getColor('link link-btn-text-hover-color').';');
		}

		if( $query->getColor('link link-btn-border-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .work-v1-view:hover', false)
				->addParamsString('border-color: '.$query->getColor('link link-btn-border-hover-color').';');
		}

		if( $query->getColor('link link-btn-bg-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .work-v1-view:hover', false)
				->addParamsString('background-color: '.$query->getColor('link link-btn-bg-hover-color').';');
		}





		if( $query->getColor('el-bg-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .work-v1-content', false)
				->addParamsString('background-color: '.$query->getColor('el-bg-color').';');
		}

		if( $query->getColor('el-shadow-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.work-v1', false)
				->addParamsString('box-shadow: 0 2px 5px 3px '.$query->getColor('el-shadow-color').';');
		}

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				blocks.render( 'image', query );

				query.get('link').addText( 'button-title' );

				if(query.queryExists('content')) {
					query.get('content').get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'title':
								query.addHeadingLg('text');
								break;
							case 'subtitle':
								query.addHeadingSm('category');
								query.addHeadingSm('date');
								break;
							case 'content':
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