<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_news.html#scrollTo__9475
 * */

class ffElBlogClassic5 extends ffElBlog {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'blog-classic-5');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Blog Classic 5', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'blog');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'blog, loop, post, news, classic 5');
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

						/* TYPE CATEGORY */
						$s->startRepVariationSection('category', ark_wp_kses( __('Featured Category', 'ark' ) ) );

							$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'is-link', ark_wp_kses( __('Links to Category Archive', 'ark' ) ), 1);

							$s->addOptionNL( ffOneOption::TYPE_SELECT, 'count', '', '1')
								->addSelectValue( esc_attr( __('Only the first Category', 'ark' ) ), '1')
								->addSelectValue( esc_attr( __('All Categories', 'ark' ) ), '2')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Number of Categories', 'ark' ) ) )
							;

							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'separator', '', ' / ')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Separator', 'ark' ) ) )
							;
						$s->endRepVariationSection();

						/* TYPE POST TITLE */
						$s->startRepVariationSection('title', ark_wp_kses( __('Post Title', 'ark' ) ) );
							$this->_injectTitleOptions( $s );
						$s->endRepVariationSection();

						/* TYPE POST CONTENT */
						$s->startRepVariationSection('content', ark_wp_kses( __('Post Content', 'ark' ) ))
							->addParam('hide-default', true);
						$this->_getBlock( ffThemeBlConst::CONTENT )->injectOptions( $s );
						$s->endRepVariationSection();

						/* TYPE SEPARATOR */
						$s->startRepVariationSection('separator', ark_wp_kses( __('Divider', 'ark' ) ) );
							$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('This is a Divider', 'ark' ) ) );
						$s->endRepVariationSection();

						/* TYPE META-DATA */
						$s->startRepVariationSection('meta-data', ark_wp_kses( __('Meta Data', 'ark' ) ));
							$this->_getElementMetaOptions( $s, true );
						$s->endRepVariationSection();

						/* TYPE BUTTON */
						$s->startRepVariationSection('button', ark_wp_kses( __('Button', 'ark' ) ) );
							$this->_getBlock( ffThemeBlConst::BUTTON )->setParam('no-link-options', true)->injectOptions( $s );
						$s->endRepVariationSection();


					$s->endRepVariableSection();
				$s->endCssWrapper();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Featured Area', 'ark' ) ) );
				$s->startCssWrapper('ffb-post-wrapper');
					 $s->startAdvancedToggleBox('one-featured-area', 'Featured Area');
					    $s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('NOTE: The settings below are only for the <strong>Featured Image</strong> case', 'ark' ) ) );
					    $s->addElement(ffOneElement::TYPE_NEW_LINE);
						$s->addOption( ffOneOption::TYPE_HIDDEN, 'blank','', 'blank');
					    $this->_getBlock( ffThemeBlConst::FEATUREDIMG )->injectOptions( $s );
					 $s->endAdvancedToggleBox();
				$s->endCssWrapper();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Featured Area Overlay', 'ark' ) ) );
				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'use-overlay', ark_wp_kses( __('Show Featured Area Overlay', 'ark' ) ), 1);

				$s->startHidingBox('use-overlay', 'checked');
					$s->addElement(ffOneElement::TYPE_NEW_LINE);
					$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Lightbox Icon', 'ark' ) ), 'ff-font-et-line icon-focus')
						->addParam('print-in-content', true)
					;
					$s->addElement(ffOneElement::TYPE_NEW_LINE);

					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', '#3a3a44')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color', 'ark' ) ) )
					;
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-bg-color', '', '#ffffff')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Background Color', 'ark' ) ) )
					;
					$s->addElement(ffOneElement::TYPE_NEW_LINE);
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-hover-color', '', '#ffffff')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Hover Color', 'ark' ) ) )
					;
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-bg-hover-color', '', '[1]')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Background Hover Color', 'ark' ) ) )
					;
					$s->addElement(ffOneElement::TYPE_NEW_LINE);
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'gradient-color', '', 'rgba(0, 188, 212, 0.5)')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Overlay Background Color', 'ark' ) ) )
					;
				$s->endHidingBox();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Quick Info', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'show-quick-info', _('Show Quick Info'), 1 );

				$s->startHidingBox('show-quick-info', 'checked');
					$s->addElement(ffOneElement::TYPE_NEW_LINE);
					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'quick-text', '', 'Quick Info')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Button Text', 'ark' ) ) )
					;
					$s->addElement(ffOneElement::TYPE_NEW_LINE);

					$this->_getBlock( ffThemeBlConst::CONTENT )->injectOptions( $s );
					
					$s->addElement(ffOneElement::TYPE_NEW_LINE);

					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'quick-color', '', '#ffffff')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Button Text Color', 'ark' ) ) )
					;
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'quick-bg-color', '', '[1]')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Button Background Color', 'ark' ) ) )
					;
					$s->addElement(ffOneElement::TYPE_NEW_LINE);
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'quick-hover-color', '', '#ffffff')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Button Text Hover Color', 'ark' ) ) )
					;
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'quick-bg-hover-color', '', '[1]')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Button Background Hover Color', 'ark' ) ) )
					;
					$s->addElement(ffOneElement::TYPE_NEW_LINE);
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-color', '', '#c4c4c4')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Overlay Text Color', 'ark' ) ) )
					;
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-bg-color', '', '#34343c')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Overlay Background Color', 'ark' ) ) )
					;
				$s->endHidingBox();
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

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );
				
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'post-box-shadow', '', '#eff1f8')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Blog Post Shadow', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'post-content-bg-color', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Post Content Background', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'featured-cat-text-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Featured Category Text', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'featured-cat-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Featured Category Link', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'featured-cat-hover-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Featured Category Link Hover', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'featured-cat-separator-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Featured Category Separator', 'ark' ) ) );

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

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'separator-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Horizontal Divider Color', 'ark' ) ) );

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

		$overlayClass = 'news-v8-img-effect';
		if( !$query->get('use-overlay') ){
			$overlayClass = '';
		}

		switch( $query->get('grid lg') ) {
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

		echo '<section class="blog-classic-v5 '.$query->getWpKses('content-align').'">';
			echo '<div class="row fg-row fg-blog-row-main ">';

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

					echo '<div class="fg-col fg-blog-col-main col-xs-12 news-v8-column '. $cols .'">';
						$this->_advancedToggleBoxStart( $query, 'post-wrapper' );
						echo '<article id="post-'. $postID .'" class="'. implode(' ', get_post_class('post-wrapper news-v8')) .'" >';

							echo '<div class="'. $overlayClass .'">';
								$this->_advancedToggleBoxStart( $query, 'one-featured-area');
								if ( empty( $featured_area ) ){
										$this->_getBlock( ffThemeBlConst::FEATUREDIMG )
											->setParam('post-id', $postID)
											->setParam('width', $width)
											->setParam('height', $height)
											->imgIsResponsive()
											->render( $query->getMustBeQueryNotEmpty('one-featured-area') );

									if( $query->get('use-overlay') && has_post_thumbnail($postID) ){
										echo '<div class="news-v8-img-effect-center-align">';
											echo '<div class="theme-icons-wrap">';

												echo '<a class="image-popup-vertical-fit" href="'
													. $this->_getBlock( ffThemeBlConst::FEATUREDIMG )->setParam('post-id', $postID)->setParam('get-url', true)->render( $query->getMustBeQueryNotEmpty('one-featured-area') )
													. '" title="">';

													echo '<i class="theme-icons theme-icons-white-bg theme-icons-md radius-3 '. $query->getEscAttr('icon') .'"></i>';

												echo '</a>';

											echo '</div>';
										echo '</div>';
									}

								} else {
									echo ( $featured_area );
								}
								$this->_advancedToggleBoxEnd( $query, 'one-featured-area');

							echo '</div>';


							echo '<div class="news-v8-wrap">';

								foreach( $query->get('content') as $postItem ) {
									switch( $postItem->getVariationType() ) {

										case 'category':
											if( has_category() ) {

												$postMetaGetter = ffContainer()->getThemeFrameworkFactory()->getPostMetaGetter(false);
												$categoriesData = $postMetaGetter->getPostCategoriesArray();

												$separator = $postItem->get('separator');

												$categoriesArray = array();
												foreach( $categoriesData as $oneCategory ) {

													$oneCategoryString = '';

													if( $postItem->get('is-link') ) {
														$oneCategoryString .= '<a href="' . $oneCategory->computed_url .'">';
													} else {
														$oneCategoryString .= '<span>';
													}

													$oneCategoryString .= $oneCategory->name;

													if( $postItem->get('is-link') ) {
														$oneCategoryString .= '</a>';
													} else {
														$oneCategoryString .= '</span>';
													}

													$categoriesArray[] = $oneCategoryString;
												}

												if( 1 == $postItem->get('count') ){
													$categories = reset($categoriesArray);
												} else {
													$categories = implode('<span class="separator">' . $separator . '</span>' , $categoriesArray );
												}

												$this->_applySystemTabsOnRepeatableStart( $postItem );
													echo '<span class="news-v8-category ff-meta-item ff-category-meta">'. $categories .'</span>';
												$this->_applySystemTabsOnRepeatableEnd( $postItem );

											}
											break;

										case 'title':
											$this->_applySystemTabsOnRepeatableStart( $postItem );
												echo '<h2 class="news-v8-title">';
													$this->_printPostTitle( $postItem );
												echo '</h2>';
											$this->_applySystemTabsOnRepeatableEnd( $postItem );
											break;

										case 'separator':

											$this->_applySystemTabsOnRepeatableStart( $postItem );
												echo '<div class="news-v8-separator"></div>';
											$this->_applySystemTabsOnRepeatableEnd( $postItem );
											break;

										case 'meta-data':

											echo '<div class="list-inline news-v8-footer-list news-v8-meta-data">';
												$this->_renderMetaElement( $postItem,
													array(
														'link-class' => 'news-v8-footer-list-link',
														'icon-class' => 'news-v8-footer-list-icon',
														'list-class' => 'news-v8-footer-list-item',
													)
												);
											echo '</div>';

											break;

										case 'content':
											echo '<div class="news-v8-paragraph">';
											$this->_getBlock( ffThemeBlConst::CONTENT )->render( $postItem );
											echo '</div>';
											break;

										case 'button':
											echo '<div class="news-v8-button">';
											$this->_getBlock(ffThemeBlConst::BUTTON)->setParam('use-custom-url', $postURL )->render($postItem);
											echo '</div>';
											break;

									}
								}

							echo '</div>';

							if( $query->get('show-quick-info') == 1 ) {
								echo '<div class="news-v8-more">';
									echo '<h3 class="news-v8-more-link">'. $query->getWpKses('quick-text') .'</h3>';

									echo '<div class="news-v8-more-info">';
										echo '<div class="news-v8-more-info-body">';

											$this->_applySystemTabsOnRepeatableStart( $query );
												$this->_getBlock( ffThemeBlConst::CONTENT )->render( $query );
											$this->_applySystemTabsOnRepeatableEnd( $query );

										echo '</div>';
									echo '</div>';
								echo '</div>';
							}

						echo '</article>';
						$this->_advancedToggleBoxEnd( $query, 'post-wrapper' );
					echo '</div>';

					$this->_printClearFixDiv( $query, $postIndex );

					$postIndex++;
					
				}
			}

			echo '</div>';
		echo '</section>';

		$this->_getBlock( ffThemeBlConst::PAGINATION )->setWpQuery( $wpQuery )->render( $query );



		/* QUICK INFO COLORS */

		if( $query->getColor('quick-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8 .news-v8-more .news-v8-more-link', false)
				->addParamsString('color: '.$query->getColor('quick-color').';');
		}

		if( $query->getColor('quick-bg-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8 .news-v8-more .news-v8-more-link', false)
				->addParamsString('background-color: '.$query->getColor('quick-bg-color').';');
		}

		if( $query->getColor('quick-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8 .news-v8-more .news-v8-more-link:hover', false)
				->addParamsString('color: '.$query->getColor('quick-hover-color').';');
		}

		if( $query->getColor('quick-bg-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8 .news-v8-more .news-v8-more-link:hover', false)
				->addParamsString('background-color: '.$query->getColor('quick-bg-hover-color').';');
		}

		if( $query->getColor('content-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8 .news-v8-more .news-v8-more-info-body', false)
				->addParamsString('color: '.$query->getColor('content-color').';');
		}

		if( $query->getColor('content-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8 .news-v8-more .news-v8-more-info-body p', false)
				->addParamsString('color: '.$query->getColor('content-color').';');
		}

		if( $query->getColor('content-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8 .news-v8-more .news-v8-more-info-body a', false)
				->addParamsString('color: '.$query->getColor('content-color').';');
		}

		if( $query->getColor('content-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8 .news-v8-more .news-v8-more-info-body a:hover', false)
				->addParamsString('color: '.$query->getColor('content-color').';');
		}

		if( $query->getColor('content-bg-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8 .news-v8-more .news-v8-more-info', false)
				->addParamsString('background-color: '.$query->getColor('content-bg-color').';');
		}

		/* FEATURED AREA OVERLAY COLORS */

		if( $query->getColor('icon-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8-img-effect .theme-icons.theme-icons-white-bg', false)
				->addParamsString('color: '.$query->getColor('icon-color').';');
		}

		if( $query->getColor('icon-bg-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8-img-effect .theme-icons.theme-icons-white-bg', false)
				->addParamsString('background-color: '.$query->getColor('icon-bg-color').';');
		}

		if( $query->getColor('icon-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8-img-effect .theme-icons.theme-icons-white-bg:hover', false)
				->addParamsString('color: '.$query->getColor('icon-hover-color').';');
		}

		if( $query->getColor('icon-bg-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8-img-effect .theme-icons.theme-icons-white-bg:hover', false)
				->addParamsString('background-color: '.$query->getColor('icon-bg-hover-color').';');
		}

		if( $query->getColor('gradient-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8:hover .news-v8-img-effect:before', false)
				->addParamsString('background-color: '.$query->getColor('gradient-color').';');
		}

		/* COLORS */

		if( $query->getColor('post-box-shadow') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8', false)
				->addParamsString('box-shadow: 0 2px 5px 3px '.$query->getColor('post-box-shadow').';');
		}

		if( $query->getColor('post-content-bg-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8-wrap', false)
				->addParamsString('background-color: '.$query->getColor('post-content-bg-color').';');
		}

		if( $query->getColor('featured-cat-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8-category', false)
				->addParamsString('color: '.$query->getColor('featured-cat-text-color').';');
		}

		if( $query->getColor('featured-cat-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8-category a', false)
				->addParamsString('color: '.$query->getColor('featured-cat-color').';');
		}

		if( $query->getColor('featured-cat-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8-category a:hover', false)
				->addParamsString('color: '.$query->getColor('featured-cat-hover-color').';');
		}

		if( $query->getColor('featured-cat-separator-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8-category .separator', false)
				->addParamsString('color: '.$query->getColor('featured-cat-separator-color').';');
		}

		if( $query->getColor('title-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8-title a', false)
				->addParamsString('color: '.$query->getColor('title-text-color').';');
		}

		if( $query->getColor('title-text-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8-title a:hover', false)
				->addParamsString('color: '.$query->getColor('title-text-hover-color').';');
		}

		if( $query->getColor('content-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8-paragraph', false)
				->addParamsString('color: '.$query->getColor('content-text-color').';');
		}

		if( $query->getColor('content-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8-paragraph *', false)
				->addParamsString('color: '.$query->getColor('content-text-color').';');
		}

		if( $query->getColor('content-link-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8-paragraph a', false)
				->addParamsString('color: '.$query->getColor('content-link-color').';');
		}

		if( $query->getColor('content-link-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8-paragraph a:hover', false)
				->addParamsString('color: '.$query->getColor('content-link-hover-color').';');
		}

		if( $query->getColor('separator-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8-separator', false)
				->addParamsString('background-color: '.$query->getColor('separator-color').';');
		}

		if( $query->getColor('meta-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8 .news-v8-meta-data .ff-meta-item', false)
				->addParamsString('color: '.$query->getColor('meta-text-color').';');
		}

		if( $query->getColor('meta-link-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8 .news-v8-meta-data .ff-meta-item a', false)
				->addParamsString('color: '.$query->getColor('meta-link-color').';');
		}

		if( $query->getColor('meta-link-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8 .news-v8-meta-data .ff-meta-item a:hover', false)
				->addParamsString('color: '.$query->getColor('meta-link-hover-color').';');
		}

		if( $query->getColor('meta-separator-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8 .news-v8-meta-data .ff-meta-separator', false)
				->addParamsString('color: '.$query->getColor('meta-separator-color').';');
		}

		if( $query->getColor('meta-icon-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v8 .news-v8-meta-data .ff-meta-icon', false)
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
								query.addPlainText('Post Separator');
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
							case 'category':
								switch (query.get('count')) {
									case '1':
										query.addPlainText('Just the first Category');
										query.addBreak();
										break;
									case '2':
										query.addPlainText('All Categories');
										query.addBreak();
										break;
								}
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