<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_news.html
 * */

class ffElBlogClassic3 extends ffElBlog {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'blog-classic-3');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Blog Classic 3', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'blog');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'blog, loop, post, news, classic 3');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_addTab('Loop', array($this, '_wpLoopSettings'));
		$this->_addTab('Pagination', array($this, '_wpPagination'));

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );
		
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Info', 'ark' ) ) );
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('- No support for multimedia <strong>Featured Area</strong>, only <strong>Featured Images</strong>', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Blog Post', 'ark' ) ) );
				$s->startCssWrapper('ffb-post-wrapper');
					$s->startRepVariableSection('content');

						/* TYPE FEATURED IMAGE */

						$s->startRepVariationSection('featured-image', ark_wp_kses( __('Featured Image', 'ark' ) ) );
							$this->_getBlock(ffThemeBlConst::FEATUREDIMG)->injectOptions($s);
						$s->endRepVariationSection();

						/* TYPE POST TITLE & META DATA */
						$s->startRepVariationSection('title-meta', ark_wp_kses( __('Post Title and Meta Data', 'ark' ) ) );
							$s->startRepVariableSection('content');

								/* TYPE POST TITLE */
								$s->startRepVariationSection('title', ark_wp_kses( __('Post Title', 'ark' ) ) );
									$this->_injectTitleOptions( $s );
								$s->endRepVariationSection();

								/* TYPE META-DATA */
								$s->startRepVariationSection('meta-data', ark_wp_kses( __('Meta Data', 'ark' ) ) );
									$this->_getElementMetaOptions( $s, true );
								$s->endRepVariationSection();

							$s->endRepVariableSection();
						$s->endRepVariationSection();

						/* TYPE BUTTON */
						$s->startRepVariationSection('button', ark_wp_kses( __('Button', 'ark' ) ) );
							$this->_getBlock( ffThemeBlConst::BUTTON )->setParam('no-link-options', true)->injectOptions( $s );
						$s->endRepVariationSection();

					$s->endRepVariableSection();
				$s->endCssWrapper();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Blog Post Wrapper', 'ark' ) ) );

				$s->startAdvancedToggleBox('post-wrapper', 'Blog Post Wrapper');

					$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'This is the Blog Post Wrapper that you can edit and style');
					$s->addOption(ffOneOption::TYPE_HIDDEN, 'blank', '', 'blank');

				$s->endAdvancedToggleBox();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Columns settings', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'space-vertical', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Custom vertical gap between columns (in px)', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-bg-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Element Background', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-bottom-color', '', '#ebeef6')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Horizontal Divider', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'title-text-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Post Title Link', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'title-text-hover-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Post Title Link Hover', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'meta-text-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Meta Data Text', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'meta-link-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Meta Data Inner Links', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'meta-link-hover-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Meta Data Inner Links Hover', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'meta-separator-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Meta Data Separator', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'meta-icon-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Meta Data Icon', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	/**
	 * @param $s ffThemeBuilderOptionsExtender
	 */
	protected function _wpLoopSettings( $s ) {
		$this->_getBlock( ffThemeBuilderBlock::LOOP )->injectOptions( $s );
	}

	protected function _wpPagination( $s ) {
		$this->_getBlock( ffThemeBlConst::PAGINATION )->injectOptions( $s );
	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$loopBlock = $this->_getBlock( ffThemeBuilderBlock::LOOP );
		/**
		 * @var $wpQuery WP_Query
		 */
		$wpQuery = $loopBlock->get( $query );

		$this->_printLoopVarDump( $loopBlock );

		echo '<section class="blog-classic-3">';

			if( $wpQuery->have_posts() ) {
				while( $wpQuery->have_posts() ) {

					$wpQuery->the_post();

					if( !$loopBlock->canBePostPrinted() ) {
						continue;
					}

					ark_Featured_Area::setSizes( 1, 150, false );
					$featured_area = ark_Featured_Area::getFeaturedArea();

					$postID = get_the_ID();
					$postURL = esc_url( get_permalink() );

					$this->_advancedToggleBoxStart( $query, 'post-wrapper' );
					echo '<article class="news-v10">';
						echo '<div id="post-'. $postID .'" class="'. implode(' ', get_post_class('post-wrapper')) .'">';
							echo '<div class="center-content-hor-wrap-sm">';

								$isContent = false;

								foreach( $query->get('content') as $oneContent ) {
									switch( $oneContent->getVariationType() ) {

										case 'featured-image':
											if( !$isContent ){ echo '<div class="center-content-hor-align-sm">'; $isContent = true; }

											echo '<div class="news-v10-media">';
												$this->_applySystemTabsOnRepeatableStart( $oneContent );
													$this->_getBlock( ffThemeBlConst::FEATUREDIMG )
														->setParam('post-id', $postID)
														->setParam('width', 100)
														->setParam('height', false)
														->setParam('css-class', 'news-v10-featured-image')
														->imgIsResponsive()
														->render( $oneContent );
												$this->_applySystemTabsOnRepeatableEnd( $oneContent );
											echo '</div>';

											break;

										case 'title-meta':
											if( !$isContent ){ echo '<div class="center-content-hor-align-sm">'; $isContent = true; }

											echo '<div class="news-v10-content">';
												foreach( $oneContent->get('content') as $oneItem ) {
													switch( $oneItem->getVariationType() ) {

														case 'title':
															echo '<h2 class="news-v10-title">';
																$this->_printPostTitle( $oneItem );
															echo '</h2>';
															break;

														case 'meta-data':
															echo '<div class="list-inline news-v10-lists">';
																$this->_renderMetaElement( $oneItem,
																	array(
																		'link-class' => 'news-v10-lists-link',
																		'icon-class' => 'news-v10-lists-icon',
																		'list-class' => 'news-v10-lists-item',
																	)
																);
															echo '</div>';
															break;

													}
												}
											echo '</div>';
											break;

										case 'button':
											if( $isContent ){ echo '</div>'; $isContent = false; }

											echo '<div class="center-content-hor-align-sm text-right sm-text-center">';
												$this->_applySystemTabsOnRepeatableStart( $oneContent );
													echo '<div class="news-v10-button-wrapper">';
													$this->_getBlock(ffThemeBlConst::BUTTON)->setParam('use-custom-url', $postURL )->render($oneContent);
													echo '</div>';
												$this->_applySystemTabsOnRepeatableEnd( $oneContent );
											echo '</div>';
											break;

									}
								}

								if( $isContent ){ echo '</div>'; }

							echo '</div>';
						echo '</div>';
					echo '</article>';
					$this->_advancedToggleBoxEnd( $query, 'post-wrapper' );
				}
			}

		echo '</section>';

		$this->_getBlock( ffThemeBlConst::PAGINATION )->setWpQuery( $wpQuery )->render( $query );

		$spaceVertical = $query->get('space-vertical');

		if( $spaceVertical != '' ) {
			$spaceVertical = absint( $spaceVertical )/2;

			$this->_getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v10', false)
				->addParamsString('padding-bottom:' . $spaceVertical . 'px;');

			$this->_getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v10', false)
				->addParamsString('padding-top:' . $spaceVertical . 'px;');
		}

		/* COLORS */

		if( $query->getColor('content-bg-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector('.blog-classic-3', false)
				->addParamsString('background-color: '.$query->getColor('content-bg-color').';');
		}

		if( $query->getColor('border-bottom-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v10:not(:last-child)', false)
				->addParamsString('border-bottom: 1px solid '.$query->getColor('border-bottom-color').';');
		}

		if( $query->getColor('title-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v10-title a', false)
				->addParamsString('color: '.$query->getColor('title-text-color').';');
		}

		if( $query->getColor('title-text-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v10-title a:hover', false)
				->addParamsString('color: '.$query->getColor('title-text-hover-color').';');
		}

		if( $query->getColor('meta-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v10-lists .news-v10-lists-item .ff-meta-item', false)
				->addParamsString('color: '.$query->getColor('meta-text-color').';');
		}

		if( $query->getColor('meta-link-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v10-lists .news-v10-lists-item .ff-meta-item a', false)
				->addParamsString('color: '.$query->getColor('meta-link-color').';');
		}

		if( $query->getColor('meta-link-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v10-lists .news-v10-lists-item .ff-meta-item a:hover', false)
				->addParamsString('color: '.$query->getColor('meta-link-hover-color').';');
		}

		if( $query->getColor('meta-separator-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v10-lists .news-v10-lists-item .ff-meta-separator', false)
				->addParamsString('color: '.$query->getColor('meta-separator-color').';');
		}

		if( $query->getColor('meta-icon-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v10-lists .news-v10-lists-item .ff-meta-icon', false)
				->addParamsString('color: '.$query->getColor('meta-icon-color').';');
		}

		$loopBlock->resetOnTheEnd();
	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				if( query.exists('content') ) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {

							case 'featured-image':
								query.addPlainText('Featured Image');
								query.addBreak();
								break;

							case 'title-meta':
								query.get('content').each(function (query, variationType) {
									switch (variationType) {
										case 'title':
											query.addPlainText('Post Title');
											query.addBreak();
											break;

										case 'meta-data':
											query.addPlainText('Post Meta');
											query.addBreak();
											break;
									}
								});
								break;

							case 'button':
								blocks.render('button', query);
								query.addBreak();
								break;

						}
					});
				}
			}
		</script data-type="ffscript">
	<?php
	}


}