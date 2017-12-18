<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_news.html#scrollTo__5849
 * */

class ffElBlogSimple4 extends ffElBlog {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'blog-simple-4');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Blog Simple 4', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'blog');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'blog, loop, post, news, simple 4');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_addTab('Loop', array($this, '_wpLoopSettings'));
		$this->_addTab('Pagination', array($this, '_wpPagination'));

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Info', 'ark' ) ) );
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('- No support for multimedia <strong>Featured Area</strong>, only <strong>Featured Images</strong>', 'ark' ) ) );
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('- No support for <strong>Grid Columns</strong> customization, all blog posts are rendered in one column', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Blog Post', 'ark' ) ) );

				$s->startRepVariableSection('content');

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

					/* TYPE POST CONTENT */
					$contentSection = $s->startRepVariationSection('p-content', ark_wp_kses( __('Post Content', 'ark' ) ));
					$contentSection->addParam('hide-default', true);

						$this->_getBlock( ffThemeBlConst::CONTENT )->injectOptions( $s );
					$s->endRepVariationSection();

					/* TYPE BUTTON */
					$s->startRepVariationSection('button', ark_wp_kses( __('Button', 'ark' ) ) );
						$this->_getBlock( ffThemeBlConst::BUTTON )->setParam('no-link-options', true)->injectOptions( $s );
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Featured Image', 'ark' ) ) );

				$s->startCssWrapper('ffb-post-wrapper');
					$s->startAdvancedToggleBox('one-featured-image', 'Featured Image');
						$this->_getBlock( ffThemeBlConst::FEATUREDIMG )->injectOptions( $s );
					$s->endAdvancedToggleBox();
				$s->endCssWrapper();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);
		
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Blog Post Wrapper', 'ark' ) ) );

				$s->startAdvancedToggleBox('post-wrapper', 'Blog Post Wrapper');

					$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'This is the Blog Post Wrapper that you can edit and style');
					$s->addOption(ffOneOption::TYPE_HIDDEN, 'blank', '', 'blank');

				$s->endAdvancedToggleBox();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Columns Settings', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);
				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'space-vertical', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Custom vertical gap between columns (in px)', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);



			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'alignment', '', 'text-center')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'text-left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'text-center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'text-right')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '', '#c0c0c8')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border Gradient Color', 'ark' ) ) );

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

		$width = 768;
		$height = false;

		echo '<section class="blog-simple-4">';

			if( $wpQuery->have_posts() ) {

				$blogPost = 0;

				while( $wpQuery->have_posts() ) {

					$wpQuery->the_post();

					if( !$loopBlock->canBePostPrinted() ) {
						continue;
					}

					$blogPost++;
					$wrapperClass = '';
					if( $blogPost % 2 == 0 ){
						$wrapperClass = 'news-v5-content-sm-pull';
						$postImgOrientation = 'news-v5-col-sm-push news-v5-col-p-right';
						$postContentOrientation = 'left';
					} else {
						$postImgOrientation = 'news-v5-col-p-left';
						$postContentOrientation = 'right';
					}

					$postID = get_the_ID();
					$postURL = esc_url( get_permalink() );

					echo '<div class="news-v5">';
						$this->_advancedToggleBoxStart( $query, 'post-wrapper' );
						echo '<div id="post-'. $postID .'" class="'. implode(' ', get_post_class('post-wrapper')) .' clearfix" >';

							echo '<div class="news-v5-col '. $postImgOrientation .'" style="background-image: url('
								// 2x image for SM & XS
								. $this->_getBlock( ffThemeBlConst::FEATUREDIMG )
									->setParam('post-id', $postID)
									->setParam('width', $width)
									->setParam('height', $height)
									->setParam('get-url', true)
									->render( $query->getMustBeQueryNotEmpty('one-featured-image') )
								. ');">';

								echo '<div class="news-v5-img-wrapper">';

									$this->_advancedToggleBoxStart( $query, 'one-featured-image');
										// 2x image for SM & XS
										$this->_getBlock( ffThemeBlConst::FEATUREDIMG )
											->setParam('post-id', $postID)
											->setParam('width', $width)
											->setParam('height', $height)
											->setParam('css-class', 'sm-display-initial')
											->imgIsResponsive()
											->imgIsFullWidth()
											->render( $query->getMustBeQueryNotEmpty('one-featured-image'));
									$this->_advancedToggleBoxEnd( $query, 'one-featured-image');

								echo '</div>';

							echo '</div>';

							echo '<div class="news-v5-content '. $wrapperClass .'">';

								echo '<div class="news-v5-border-'. $postContentOrientation .'"></div>';

								echo '<div class="news-v5-inner '. $query->getEscAttr('alignment') .'">';
									echo '<div class="news-v5-inner-body">';

										foreach( $query->get('content') as $postItem ) {
											switch( $postItem->getVariationType() ) {

												case 'title':
													echo '<h3 class="news-v5-order-name">';
														$this->_printPostTitle( $postItem );
													echo '</h3>';
													break;

												case 'meta':
													echo '<div class="blog-simple-4-subtitle">';
														$this->_renderMetaElement( $postItem );
													echo '</div>';
													break;

												case 'p-content':
													echo '<div class="news-v5-post-content">';
														$this->_getBlock( ffThemeBlConst::CONTENT )->render( $postItem );
													echo '</div>';
													break;

												case 'button':
													echo '<div class="blog-simple-4-button">';
														$this->_getBlock(ffThemeBlConst::BUTTON)->setParam('use-custom-url', $postURL )->render($postItem);
													echo '</div>';
													break;

											}
										}

									echo '</div>';
								echo '</div>';

							echo '</div>';
							$this->_advancedToggleBoxEnd( $query, 'post-wrapper' );
						echo '</div>';
					echo '</div>';

				}
			}

		echo '</section>';

		$this->_getBlock( ffThemeBlConst::PAGINATION )->setWpQuery( $wpQuery )->render( $query );

		$spaceVertical = $query->get('space-vertical');

		if( $spaceVertical != '' ) {
			$spaceVertical = absint( $spaceVertical);
			$this->_getAssetsRenderer()
				->createCssRule()
				->addSelector('.news-v5')
				->addParamsString('margin-bottom:'. $spaceVertical .'px;');
		}

		/* BORDER GRADIENT COLOR */

		if( $query->get('border-color') ) {

			$this->getAssetsRenderer()->createCssRule()
				->addSelector('news-v5-border-left')
				->addParamsString('border-left: 1px solid '. $query->get('border-color'));

			$this->getAssetsRenderer()->createCssRule()
				->addSelector('news-v5-border-right')
				->addParamsString('border-right: 1px solid '. $query->get('border-color'));


			$this->getAssetsRenderer()->createCssRule()
				->addSelector('news-v5-border-left:before')
				->addParamsString('background-image: -webkit-linear-gradient(right, rgba(255, 255, 255, 0) 25%, '. $query->get('border-color') .' 100%)');
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('news-v5-border-left:before')
				->addParamsString('background-image: linear-gradient(to left, rgba(255, 255, 255, 0) 25%, '. $query->get('border-color') .' 100%)');
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('news-v5-border-right:before')
				->addParamsString('background-image: -webkit-linear-gradient(left, rgba(255, 255, 255, 0) 25%, '. $query->get('border-color') .' 100%) ;');
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('news-v5-border-right:before')
				->addParamsString('background-image: linear-gradient(to right, rgba(255, 255, 255, 0) 25%, '. $query->get('border-color') .' 100%) ;');


			$this->getAssetsRenderer()->createCssRule()
				->addSelector('news-v5-border-left:after')
				->addParamsString('background-image: -webkit-linear-gradient(right, rgba(255, 255, 255, 0) 25%, '. $query->get('border-color') .' 100%)');
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('news-v5-border-left:after')
				->addParamsString('background-image: linear-gradient(to left, rgba(255, 255, 255, 0) 25%, '. $query->get('border-color') .' 100%)');
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('news-v5-border-right:after')
				->addParamsString('background-image: -webkit-linear-gradient(left, rgba(255, 255, 255, 0) 25%, '. $query->get('border-color') .' 100%) ;');
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('news-v5-border-right:after')
				->addParamsString('background-image: linear-gradient(to right, rgba(255, 255, 255, 0) 25%, '. $query->get('border-color') .' 100%) ;');
		}

		/* COLORS */

		if( $query->getColor('title-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v5 .news-v5-order-name a', false)
				->addParamsString('color: '.$query->getColor('title-text-color').';');
		}

		if( $query->getColor('title-text-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v5 .news-v5-order-name a:hover', false)
				->addParamsString('color: '.$query->getColor('title-text-hover-color').';');
		}

		if( $query->getColor('content-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v5 .news-v5-post-content', false)
				->addParamsString('color: '.$query->getColor('content-text-color').';');
		}

		if( $query->getColor('content-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v5 .news-v5-post-content p', false)
				->addParamsString('color: '.$query->getColor('content-text-color').';');
		}

		if( $query->getColor('content-link-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v5 .news-v5-post-content a', false)
				->addParamsString('color: '.$query->getColor('content-link-color').';');
		}

		if( $query->getColor('content-link-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .news-v5 .news-v5-post-content a:hover', false)
				->addParamsString('color: '.$query->getColor('content-link-hover-color').';');
		}

		if( $query->getColor('meta-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-simple-4-subtitle .ff-meta-item', false)
				->addParamsString('color: '.$query->getColor('meta-text-color').';');
		}

		if( $query->getColor('meta-link-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-simple-4-subtitle .ff-meta-item a', false)
				->addParamsString('color: '.$query->getColor('meta-link-color').';');
		}

		if( $query->getColor('meta-link-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-simple-4-subtitle .ff-meta-item a:hover', false)
				->addParamsString('color: '.$query->getColor('meta-link-hover-color').';');
		}

		if( $query->getColor('meta-separator-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-simple-4-subtitle .ff-meta-separator', false)
				->addParamsString('color: '.$query->getColor('meta-separator-color').';');
		}

		if( $query->getColor('meta-icon-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-simple-4-subtitle .ff-meta-icon', false)
				->addParamsString('color: '.$query->getColor('meta-icon-color').';');
		}

		$loopBlock->resetOnTheEnd();
	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				query.get('content').each(function(query, variationType ){
					switch(variationType){
						case 'title':
							query.addPlainText( 'Post Title' );
							query.addBreak();
							break;
						case 'p-content':
							query.addPlainText( 'Post Content' );
							query.addBreak();
							break;
						case 'meta':
							query.addPlainText( 'Post Meta' );
							query.addBreak();
							break;
						case 'button':
							blocks.render('button', query);
							break;
					}

				});

			}
		</script data-type="ffscript">
	<?php
	}


}