<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/one-page/one-page-business/index_profile_2.html#scrollTo__6086
 * */

class ffElBlogSimple1 extends ffElBlog {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'blog-simple-1');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Blog Simple 1', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'blog');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'blog, loop, post, news, simple 1');
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

					/* TYPE SEPARATOR */
					$s->startRepVariationSection('divider', ark_wp_kses( __('Divider', 'ark' ) ));
						$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('This is a Divider', 'ark' ) ) );
					$s->endRepVariationSection();

					/* TYPE TITLE */
					$s->startRepVariationSection('title', ark_wp_kses( __('Post Title', 'ark' ) ) );
						$this->_injectTitleOptions( $s );
					$s->endRepVariationSection();

					/* TYPE META DATA */
					$s->startRepVariationSection('meta', ark_wp_kses( __('Meta Data', 'ark' ) ))
						->addParam('hide-default', true)
					;
						$this->_getElementMetaOptions( $s );
					$s->endRepVariationSection();

					/* TYPE LINK */
					$s->startRepVariationSection('link', ark_wp_kses( __('Link', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', ark_wp_kses( __('Explore Story', 'ark' ) ) )
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/* TYPE POST CONTENT */
					$s->startRepVariationSection('p-content', ark_wp_kses( __('Post Content', 'ark' ) ) );
						$this->_getBlock( ffThemeBlConst::CONTENT )->injectOptions( $s );
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
					    $this->_getBlock( ffThemeBlConst::FEATUREDIMG )->injectOptions( $s );
						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'show-lightbox-button', ark_wp_kses( __('Show Lightbox Button', 'ark' ) ), 1);

						$s->startHidingBox('show-lightbox-button', 'checked');
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'lightbox-button-color', '', '')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Lightbox Button Color', 'ark' ) ) );
						$s->endHidingBox();

					$s->endAdvancedToggleBox();
				$s->endCssWrapper();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Blog Post Wrapper', 'ark' ) ) );

				$s->startAdvancedToggleBox('post-wrapper', 'Blog Post Wrapper');

					$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'This is the Blog Post Wrapper that you can edit and style');
					$s->addOption(ffOneOption::TYPE_HIDDEN, 'blank', '', 'blank');

				$s->endAdvancedToggleBox();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Layout', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'img-position', '', 'img-left')
					->addSelectValue( esc_attr( __('Featured Area on the Left side & Post Content on the Right side', 'ark' ) ), 'img-left')
					->addSelectValue( esc_attr( __('Featured Area on the Right side & Post Content on the Left side', 'ark' ) ), '')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'alignment', '', 'text-left')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'text-left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'text-center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'text-right')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$this->_injectColumnOptions( $s, array('xs'=>1,'sm'=>1,'md'=>2,'lg'=>2));

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );

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
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Horizontal Divider', 'ark' ) ) );

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

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'read-more-link-text-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Read More Link Text', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'read-more-link-text-hover-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Read More Link Text Hover', 'ark' ) ) );

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

		$cols = $this->_calculateColumnOptions( $query );

		$width = false;
		$height  = false;

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

		echo '<section class="blog-simple-1">';

			echo '<div class="fg-row fg-blog-row-main row">';

				if( $wpQuery->have_posts() ) {

					$postIndex = 1;

					while( $wpQuery->have_posts() ) {

						$wpQuery->the_post();

						if( !$loopBlock->canBePostPrinted() ) {
							continue;
						}

						ark_Featured_Area::setSizes( 1, $width, false );
						$featured_area = ark_Featured_Area::getFeaturedArea();

						$postID = get_the_ID();
						$postURL = esc_url( get_permalink() );
						$imgURL = wp_get_attachment_url( get_post_thumbnail_id( $postID ) );

						echo '<div class="fg-col fg-blog-col-main '. $cols .'">';
							$this->_advancedToggleBoxStart( $query, 'post-wrapper' );
							echo '<div id="post-'. $postID .'" class="'. implode(' ', get_post_class('post-wrapper')) .'" >';
								echo '<div class="row">';

									if( $query->get('img-position') ) {
										echo '<div class="col-sm-6">';
									} else {
										echo ' <div class="col-sm-6 col-md-push-6">';
									}


										$this->_advancedToggleBoxStart( $query, 'one-featured-area');
										if ( empty( $featured_area ) ){

											if ( has_post_thumbnail($postID) ){
												echo '<div class="theme-image-popup-v1">';

														$this->_getBlock( ffThemeBlConst::FEATUREDIMG )
														    ->setParam('post-id', $postID)
														    ->setParam('css-class', 'blog-simple-1-featured-image')
														    ->setParam('width', $width)
														    ->setParam('height', $height)
														    ->imgIsResponsive()
														    ->render( $query->getMustBeQueryNotEmpty('one-featured-area') );

													if( $query->get('one-featured-area show-lightbox-button') ) {
														echo '<a class="image-popup-vertical-fit theme-image-popup-v1-child" href="'. esc_url($imgURL) .'">';
															echo '<span class="theme-image-popup-v1-toggle"></span>';
														echo '</a>';
													}
												echo '</div>';
											}

										} else {
											echo ( $featured_area );
										}
										$this->_advancedToggleBoxEnd( $query, 'one-featured-area');

									echo '</div>';

									if( $query->get('img-position') ) {
										echo '<div class="col-sm-6">';
									} else {
										echo ' <div class="col-sm-6 col-md-pull-6">';
									}

										echo '<div class="news-v4 '. $query->getEscAttr('alignment') .'">';

											foreach( $query->get('content') as $postItem ) {
												switch( $postItem->getVariationType() ) {

													case 'divider':
														echo '<div class="news-v4-divider"></div>';
														break;

													case 'title':
															echo '<h2 class="news-v4-title news-v4-title-element-left">';
																$this->_printPostTitle( $postItem );
															echo '</h2>';

														break;

													case 'link':
														echo '<a href="'. esc_url( get_permalink() ) .'" class="news-v4-read-more-link blog-simple-1-link">'. $postItem->getWpKses('text') .'</a>';
														break;

													case 'meta':
														echo '<div class="blog-grid-supplemental-title">';
															$this->_renderMetaElement( $postItem );
														echo '</div>';
														break;

													case 'p-content':
														echo '<div class="ff-news-v4-post-content">';
														$this->_getBlock( ffThemeBlConst::CONTENT )->render( $postItem );
														echo '</div>';
														break;

													case 'button':
														echo '<div class="ff-news-v4-button">';
														$this->_getBlock(ffThemeBlConst::BUTTON)->setParam('use-custom-url', $postURL )->render($postItem);
														echo '</div>';
														break;

												}
											}

										echo '</div>';
									echo '</div>';

								echo '</div>';
							echo '</div>';
							$this->_advancedToggleBoxEnd( $query, 'post-wrapper' );
						echo '</div>';

						$this->_printClearFixDiv( $query, $postIndex );

						$postIndex++;

					}
				}

			echo '</div>';

		echo '</section>';

		$this->_getBlock( ffThemeBlConst::PAGINATION )->setWpQuery( $wpQuery )->render( $query );


		/* COLORS */

		if( $query->getColor('title-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v4-title a', false)
				->addParamsString('color: '.$query->getColor('title-text-color').';');
		}

		if( $query->getColor('title-text-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v4-title a:hover', false)
				->addParamsString('color: '.$query->getColor('title-text-hover-color').';');
		}

		if( $query->getColor('separator-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v4-divider', false)
				->addParamsString('border-color: '.$query->getColor('separator-color').';');
		}

		if( $query->getColor('content-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v4 .ff-news-v4-post-content', false)
				->addParamsString('color: '.$query->getColor('content-text-color').';');
		}

		if( $query->getColor('content-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v4 .ff-news-v4-post-content p', false)
				->addParamsString('color: '.$query->getColor('content-text-color').';');
		}

		if( $query->getColor('content-link-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v4 .ff-news-v4-post-content a', false)
				->addParamsString('color: '.$query->getColor('content-link-color').';');
		}

		if( $query->getColor('content-link-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v4 .ff-news-v4-post-content a:hover', false)
				->addParamsString('color: '.$query->getColor('content-link-hover-color').';');
		}

		if( $query->getColor('meta-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-grid-supplemental-title .ff-meta-item', false)
				->addParamsString('color: '.$query->getColor('meta-text-color').';');
		}

		if( $query->getColor('meta-link-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-grid-supplemental-title .ff-meta-item a', false)
				->addParamsString('color: '.$query->getColor('meta-link-color').';');
		}

		if( $query->getColor('meta-link-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-grid-supplemental-title .ff-meta-item a:hover', false)
				->addParamsString('color: '.$query->getColor('meta-link-hover-color').';');
		}

		if( $query->getColor('meta-separator-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-grid-supplemental-title .ff-meta-separator', false)
				->addParamsString('color: '.$query->getColor('meta-separator-color').';');
		}

		if( $query->getColor('meta-icon-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-grid-supplemental-title .ff-meta-icon', false)
				->addParamsString('color: '.$query->getColor('meta-icon-color').';');
		}
		
		if( $query->getColor('read-more-link-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-simple-1-link', false)
				->addParamsString('color: '.$query->getColor('read-more-link-text-color').';');
		}

		if( $query->getColor('read-more-link-text-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-simple-1-link:hover', false)
				->addParamsString('color: '.$query->getColor('read-more-link-text-hover-color').';');
		}




		if( $query->getColor('one-featured-area lightbox-button-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .theme-image-popup-v1-toggle', false)
				->addParamsString('border-color: '.$query->getColor('one-featured-area lightbox-button-color').';');
		}

		if( $query->getColor('one-featured-area lightbox-button-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .theme-image-popup-v1-toggle:before', false)
				->addParamsString('background-color: '.$query->getColor('one-featured-area lightbox-button-color').';');
		}

		if( $query->getColor('one-featured-area lightbox-button-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .theme-image-popup-v1-toggle:after', false)
				->addParamsString('background-color: '.$query->getColor('one-featured-area lightbox-button-color').';');
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
							case 'title':
								query.addPlainText('Post Title');
								query.addBreak();
								break;

							case 'link':
								query.addText('text', 'Post link: ');
								query.addBreak();
								break;

							case 'p-content':
								query.addPlainText('Post Content');
								query.addBreak();
								break

							case 'button':
								blocks.render('button', query);
								query.addBreak();
								break;

							case 'meta':
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