<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/index_vertical_menu_one_page.html#scrollTo__4800
 * */

class ffElBlogClassic2 extends ffElBlog {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'blog-classic-2');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Blog Classic 2', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'blog');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'blog, loop, post, news, classic 2');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_addTab('Loop', array($this, '_wpLoopSettings'));
		$this->_addTab('Pagination', array($this, '_wpPagination'));

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Blog Post', 'ark' ) ) );
				$s->startCssWrapper('ffb-post-wrapper');
					$s->startRepVariableSection('content');

						/* TYPE FEATURED AREA */
						$s->startRepVariationSection('featured-area', ark_wp_kses( __('Featured Area', 'ark' ) ) );
							$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('NOTE: The settings below are only for the <strong>Featured Image</strong> case', 'ark' ) ) );
							$s->addElement(ffOneElement::TYPE_NEW_LINE);
							$this->_getBlock( ffThemeBlConst::FEATUREDIMG )->injectOptions( $s );
						$s->endRepVariationSection();

						/* TYPE POST TITLE */
						$s->startRepVariationSection('title', ark_wp_kses( __('Post Title', 'ark' ) ) );
							$this->_injectTitleOptions( $s );
						$s->endRepVariationSection();

						/* TYPE SEPARATOR */
						$s->startRepVariationSection('separator', ark_wp_kses( __('Divider', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 icon-circle')
							;
						$s->endRepVariationSection();

						/* TYPE POST CONTENT */
						$s->startRepVariationSection('p-content', ark_wp_kses( __('Post Content', 'ark' ) ) );
							$this->_getBlock( ffThemeBlConst::CONTENT )->injectOptions( $s );
						$s->endRepVariationSection();

						/* TYPE META-DATA */
						$s->startRepVariationSection('meta-data', ark_wp_kses( __('Meta Data', 'ark' ) ));
							$this->_getElementMetaOptions( $s );
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

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'content-align', '', 'text-center')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'text-left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'text-center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'text-right')
				;

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$this->_injectColumnOptions( $s, array('xs'=>1,'sm'=>2,'md'=>3,'lg'=>3));

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Blog Colors', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-bg-color', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Blog Post Background', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'title-text-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Post Title Link', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'title-text-hover-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Post Title Link Hover', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-text-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Post Content Text', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-link-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Post Content Inner Links', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-link-hover-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Post Content Inner Links Hover', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'divider-lines-color', '', '[1]')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Divider Lines Color', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'divider-icon-color', '', '[1]')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Divider Icon Color', 'ark' ) ) );

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


			$s->addElement( ffOneElement::TYPE_TABLE_END );

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
	protected function _prepareWPQueryForRendering( $query ) {

	}


	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$loopBlock = $this->_getBlock( ffThemeBuilderBlock::LOOP );
		/**
		 * @var $wpQuery WP_Query
		 */
		$wpQuery = $loopBlock->get( $query );

		$this->_printLoopVarDump( $loopBlock );

		$cols = $this->_calculateColumnOptions( $query );

		$width = false;
		$height  = false;

		switch( $query->getEscAttr('grid lg') ) {
			case 1:
				$width = 1440;
				$height = false;
				break;
			case 2:
				$width = 768;
				$height =  false;
				break;
			case 3:
				$width = 768;
				$height =  false;
				break;
			default:
				$width = 768;
				$height =  false;
				break;
		}

		echo '<section class="blog-classic-v2">';

			echo '<div class="row fg-blog-row-main blog-content">';

			if( $wpQuery->have_posts() ) {

				$postIndex = 1;

				while( $wpQuery->have_posts() ) {

					$wpQuery->the_post();


					if( !$loopBlock->canBePostPrinted() ) {
						continue;
					}

					ark_Featured_Area::setSizes( 1, $width, $height );
					$featured_area = ark_Featured_Area::getFeaturedArea();

					$postID = get_the_ID();
					$postURL = esc_url( get_permalink() );

					echo '<div class="fg-col fg-blog-col-main '. $cols .' ">';
						$this->_advancedToggleBoxStart( $query, 'post-wrapper' );
						echo '<div id="post-'. $postID .'" class="news-v3 '. implode(' ', get_post_class('post-wrapper')) .' '.$query->getWpKses('content-align').'" >';
								$isInContentClass = false;

								foreach( $query->get('content') as $postItem ) {
									switch( $postItem->getVariationType() ) {

										case 'featured-area':
											if( $isInContentClass){ echo '</div>'; $isInContentClass = false; }

											$this->_applySystemTabsOnRepeatableStart( $postItem );
											if ( empty( $featured_area ) ){
												$this->_getBlock( ffThemeBlConst::FEATUREDIMG )
													->setParam('post-id', $postID)
													->setParam('width', $width)
													->setParam('height', $height)
													->imgIsResponsive()
													->render( $postItem );
											} else {
												echo ( $featured_area );
											}
											$this->_applySystemTabsOnRepeatableEnd( $postItem );

											break;

										case 'title':
											if( ! $isInContentClass){ echo '<div class="news-v3-content">'; $isInContentClass = true; }

											$this->_applySystemTabsOnRepeatableStart( $postItem );
											echo '<h2 class="news-v3-title">'. $this->_getPostTitle( $postItem ) .'</h2>';
											$this->_applySystemTabsOnRepeatableEnd( $postItem );
											break;

										case 'separator':
											if( ! $isInContentClass){ echo '<div class="news-v3-content">'; $isInContentClass = true; }

											$this->_applySystemTabsOnRepeatableStart( $postItem );
											echo '<div class="ff-news-v3-divider">';
												echo '<div class="news-v3-element"><i class="news-v3-element-icon '. $postItem->getEscAttr('icon') .'"></i></div>';
											echo '</div>';
											$this->_applySystemTabsOnRepeatableEnd( $postItem );
											break;

										case 'p-content':
											if( ! $isInContentClass){ echo '<div class="news-v3-content">'; $isInContentClass = true; }


											$this->_applySystemTabsOnRepeatableStart( $postItem );
											echo '<div class="ff-news-v3-post-content">';
												$this->_getBlock( ffThemeBlConst::CONTENT )->render( $postItem );
											echo '</div>';

											$this->_applySystemTabsOnRepeatableEnd( $postItem );
											break;

										case 'button':
											if( ! $isInContentClass){ echo '<div class="news-v3-content">'; $isInContentClass = true; }


											$this->_applySystemTabsOnRepeatableStart( $postItem );
											echo '<div class="ff-news-v3-space">';
												$this->_getBlock(ffThemeBlConst::BUTTON)->setParam('use-custom-url', $postURL )->render($postItem);
											echo '</div>';

											$this->_applySystemTabsOnRepeatableEnd( $postItem );
											break;

										case 'meta-data':
											if( ! $isInContentClass){ echo '<div class="news-v3-content">'; $isInContentClass = true; }

											$this->_applySystemTabsOnRepeatableStart( $postItem );
												echo '<div class="ff-news-v3-meta-data">';
													$this->_renderMetaElement( $postItem );
												echo '</div>';

											$this->_applySystemTabsOnRepeatableEnd( $postItem );

											break;

									}
								}

								if( $isInContentClass){ echo '</div>'; }

						echo '</div>';
						$this->_advancedToggleBoxEnd( $query, 'post-wrapper' );
					echo '</div>';


					$this->_printClearFixDiv( $query, $postIndex );

					$postIndex++;
				}
			}
			echo '</div>';


		$paginationBlock = $this->_getBlock( ffThemeBlConst::PAGINATION )->setParam(ffBlPagination::PARAM_POST_GRID_UNIQUE_ID, $uniqueId)->setWpQuery( $wpQuery );

		if( $paginationBlock->showPagination( $query ) ) {
			echo '<div class="blog-pagination row">';
				echo '<div class="col-xs-12">';
					$paginationBlock->render($query);
				echo '</div>';
			echo '</div>';
		}

		echo '</section>';

		/* COLORS */

		if( $query->getColor('content-bg-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v3', false)
				->addParamsString('background-color: '.$query->getColor('content-bg-color').';');
		}

		if( $query->getColor('title-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v3-content .news-v3-title a', false)
				->addParamsString('color: '.$query->getColor('title-text-color').';');
		}

		if( $query->getColor('title-text-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v3-content .news-v3-title a:hover', false)
				->addParamsString('color: '.$query->getColor('title-text-hover-color').';');
		}

		if( $query->getColor('divider-lines-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v3-content .news-v3-element:before', false)
				->addParamsString('border-bottom: 1px solid '.$query->getColor('divider-lines-color').';');
		}

		if( $query->getColor('divider-lines-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v3-content .news-v3-element:after', false)
				->addParamsString('border-bottom: 1px solid '.$query->getColor('divider-lines-color').';');
		}

		if( $query->getColor('divider-icon-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v3-content .news-v3-element .news-v3-element-icon', false)
				->addParamsString('color: '.$query->getColor('divider-icon-color').';');
		}

		if( $query->getColor('content-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v3-content .ff-news-v3-post-content', false)
				->addParamsString('color: '.$query->getColor('content-text-color').';');
		}

		if( $query->getColor('content-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v3-content .ff-news-v3-post-content p', false)
				->addParamsString('color: '.$query->getColor('content-text-color').';');
		}

		if( $query->getColor('content-link-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v3-content .ff-news-v3-post-content a', false)
				->addParamsString('color: '.$query->getColor('content-link-color').';');
		}

		if( $query->getColor('content-link-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v3-content .ff-news-v3-post-content a:hover', false)
				->addParamsString('color: '.$query->getColor('content-link-hover-color').';');
		}

		if( $query->getColor('meta-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v3-content .ff-meta-item', false)
				->addParamsString('color: '.$query->getColor('meta-text-color').';');
		}

		if( $query->getColor('meta-link-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v3-content .ff-meta-item a', false)
				->addParamsString('color: '.$query->getColor('meta-link-color').';');
		}

		if( $query->getColor('meta-link-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v3-content .ff-meta-item a:hover', false)
				->addParamsString('color: '.$query->getColor('meta-link-hover-color').';');
		}

		if( $query->getColor('meta-separator-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v3-content .ff-meta-separator', false)
				->addParamsString('color: '.$query->getColor('meta-separator-color').';');
		}

		if( $query->getColor('meta-icon-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v3-content .ff-meta-icon', false)
				->addParamsString('color: '.$query->getColor('meta-icon-color').';');
		}
		$loopBlock->resetOnTheEnd();
	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				query.addHeadingSm( 'grid md', 'Blog columns: ' );
				query.addBreak();

				if( query.exists('content') ) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'featured-area':
								query.addPlainText('Featured Area');
								query.addBreak();
								break;
							case 'title':
								query.addPlainText('Post Title');
								query.addBreak();
								break;
							case 'separator':
								query.addIcon('icon', 'Separator icon : ');
								query.addBreak();
								break;
							case 'p-content':
								query.addPlainText('Post Content');
								query.addBreak();
								break;
							case 'button':
								blocks.render('button', query);
								query.addBreak();
								break;
							case 'meta-data':
								query.addPlainText('Post Meta');
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