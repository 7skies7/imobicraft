<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/blog_classic_fullwidth.html
 * @link http://demo.freshface.net/html/h-ark/HTML/blog_classic_2_col.html
 * @link http://demo.freshface.net/html/h-ark/HTML/blog_classic_3_col.html
 * @link http://demo.freshface.net/html/h-ark/HTML/blog_classic_4_col.html
 * */

class ffElBlogClassic1 extends ffElBlog {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'blog-classic-1');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Blog Classic 1', 'ark' ) ));
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'blog');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'blog, loop, post, news, classic 1');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_addTab('Overlay', array( $this, '_wpOverlay' ) );
		$this->_addTab('Loop', array($this, '_wpLoopSettings'));
		$this->_addTab('Pagination', array($this, '_wpPagination'));

		$this->_setColor('dark');
	}

	/**
	 * @param ffOneStructure|ffThemeBuilderOptionsExtender $s
	 */
	protected function _injectContentVariations( $s, $isOverlay = false ) {
		/* TYPE FEATURED IMAGE */

		if( !$isOverlay ) {
			$s->startRepVariationSection('featured-image', ark_wp_kses( __('Featured Image', 'ark' ) ));
			$this->_getBlock(ffThemeBlConst::FEATUREDIMG)->injectOptions($s);
			$s->endRepVariationSection();
		}
		/* TYPE POST TITLE */
		$s->startRepVariationSection('title', ark_wp_kses( __('Post Title', 'ark' ) ));
			$this->_injectTitleOptions( $s );
		$s->endRepVariationSection();

		/* TYPE POST CONTENT */
		$contentSection = $s->startRepVariationSection('p-content', ark_wp_kses( __('Post Content', 'ark' ) ));
		if( $isOverlay ) {
			$contentSection->addParam('hide-default', true);
		}

			$this->_getBlock( ffThemeBlConst::CONTENT )->injectOptions( $s );
		$s->endRepVariationSection();

		/* TYPE DIVIDER */
		$s->startRepVariationSection('divider', ark_wp_kses( __('Divider', 'ark' ) ));
			$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('This is a Divider', 'ark' ) ) );
		$s->endRepVariationSection();

		/* TYPE META-DATA */
		$s->startRepVariationSection('meta-data', ark_wp_kses( __('Meta Data', 'ark' ) ));
			$this->_getElementMetaOptions( $s );
		$s->endRepVariationSection();

		if( !$isOverlay ) {
			/* TYPE BUTTON */
			$s->startRepVariationSection('button', ark_wp_kses( __('Button', 'ark' ) ));
				$this->_getBlock(ffThemeBlConst::BUTTON)->setParam('no-link-options', true)->injectOptions($s);
			$s->endRepVariationSection();
		}

	}

	/**
	 * @param ffOneStructure|ffThemeBuilderOptionsExtender $s
	 */
	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );
		

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Info', 'ark' ) ) );
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('No support for multimedia <strong>Featured Area</strong>, only <strong>Featured Images</strong>', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Blog Post', 'ark' ) ) );

				 $s->startCssWrapper('ffb-post-wrapper');
					 $s->startCssWrapper('blog-classic-body-part');
						$s->startRepVariableSection('content');

							$this->_injectContentVariations( $s );

						$s->endRepVariableSection();
					 $s->endCssWrapper();
				 $s->endCssWrapper();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('New Post Label', 'ark' ) ) );
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('New Post Label is a little label positioned slightly above the Post Content. This label will be displayed only on new posts. It is required for the post to have both Featured Image and Post Content in order to display the label', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);
				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'use-label', ark_wp_kses( __('Use the New Post Label', 'ark' ) ), 1);
				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->startHidingBox('use-label', 'checked');
					$s->startCssWrapper('ffb-post-wrapper');
					$s->startAdvancedToggleBox('label', 'Label');

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'label-text', '', 'NEW')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'days', '', '7')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Days old (maximum)', 'ark' ) ) )
						;

						$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('Set a maximum limit for how old a post can be and still display the "New Post Label"', 'ark' ) ) );

					$s->endAdvancedToggleBox();
					$s->endCssWrapper();
				$s->endHidingBox();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Blog Post Wrapper', 'ark' ) ) );

				$s->startAdvancedToggleBox('post-wrapper', 'Blog Post Wrapper');

					$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'This is the Blog Post Wrapper that you can edit and style');
					$s->addOption(ffOneOption::TYPE_HIDDEN, 'blank', '', 'blank');

				$s->endAdvancedToggleBox();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'content-align', '', 'text-left')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'text-left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'text-center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'text-right')
				;

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$this->_injectColumnOptions( $s, array('xs'=>1,'sm'=>2,'md'=>3,'lg'=>3));

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-bg-color', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Post Content Background', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'label-text-color', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('New Post Label Text', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'label-bg-color', '', '#34343c')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('New Post Label Background', 'ark' ) ) );

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

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'divider-color', '', '')
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

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}


	/**
	 * @param $s ffThemeBuilderOptionsExtender
	 */
	protected function _wpOverlay( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Info', 'ark' ) ) );
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('- No support for links inside the Overlay. Please ignore any link related options below because the Overlay itself is one big link.', 'ark' ) ) );
				// $s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('- No support for links inside <strong>Meta Data</strong> when <strong>Hover Overlay</strong> is active', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Hover Overlay', 'ark' ) ) );

				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'show-hover-overlay', ark_wp_kses( __('Show overlay on hover', 'ark' ) ), 1);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Featured Image', 'ark' ) ) );
				$s->startSection('featured-image-overlay');
					$this->_getBlock(ffThemeBlConst::FEATUREDIMG)->withoutImgLink()->injectOptions($s);
				$s->endSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Blog Post Overlay', 'ark' ) ) );
				$s->startCssWrapper('ffb-post-wrapper');
					$s->startCssWrapper('blog-classic-overlay');
						$s->startRepVariableSection('overlay');

							$this->_injectContentVariations( $s, true );

						$s->endRepVariableSection();
					$s->endCssWrapper();
				$s->endCssWrapper();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'overlay-content-align', '', 'text-left')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'text-left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'text-center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'text-right')
				;

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Overlay Colors', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-hover-overlay-color', '', 'rgba(52, 52, 60, 0.3)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Overlay Background Color', 'ark' ) ) )
				;

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-hover-overlay-color', '' ,'#ffffff' )
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Overlay Border Color', 'ark' ) ) )
				;

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'overlay-title-text-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Post Title', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'overlay-content-text-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Post Content Text', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'overlay-content-link-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Post Content Inner Links', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'overlay-divider-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Horizontal Divider', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'overlay-meta-text-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Meta Data Text', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'overlay-meta-link-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Meta Data Inner Links', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'overlay-meta-separator-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Meta Data Separator', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'overlay-meta-icon-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Meta Data Icon', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		$s->addElement( ffOneElement::TYPE_TABLE_END );
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


	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$loopBlock = $this->_getBlock( ffThemeBuilderBlock::LOOP );

		/**
		 * @var $wpQuery WP_Query
		 */
		$wpQuery = $loopBlock->get( $query );

		$this->_printLoopVarDump( $loopBlock );

		$cols = $this->_calculateColumnOptions( $query );

		$width = false;
		$height = false;

		$widthOverlayImg = false;
		$heightOverlayImg  = false;

		switch( $query->get('grid lg') ) {
			case 1:
				$widthOverlayImg = false;
				$heightOverlayImg = 800;

				$width = 1440;
				$height =  false;
				break;
			case 2:
				$widthOverlayImg = false;
				$heightOverlayImg = 800;

				$width = 768;
				$height =  false;
				break;
			default:
				$widthOverlayImg = false;
				$heightOverlayImg = 800;

				$width = 768;
				$height =  false;
				break;
		}

		$labelHasBeenPrinted = false;

		echo '<section class="blog-classic-v1">';
			echo '<div class="fg-row fg-blog-row-main row blog-content">';

			if( $wpQuery->have_posts() ) {

				$postIndex = 1;

				while( $wpQuery->have_posts() ) {

					$wpQuery->the_post();

					if( !$loopBlock->canBePostPrinted() ) {
						continue;
					}

					$postID = get_the_ID();
					$imgURL = wp_get_attachment_url( get_post_thumbnail_id( $postID ) );

					$postURL = esc_url( get_permalink() );

					echo '<div class="fg-col fg-blog-col-main '. $cols .'">';

						$this->_advancedToggleBoxStart( $query, 'post-wrapper' );
						echo '<div id="post-'. $postID .'" class="blog-classic '. implode(' ', get_post_class('post-wrapper')) .'" >';
							echo '<div class="blog-classic-body-part '.$query->getWpKses('content-align').'">';
									$this->getAssetsRenderer()->addSelectorToCascade('blog-classic-body-part');
								$isInClassicBody = false;

								if( $query->exists('content') ) {
									foreach( $query->get('content') as $postItem ) {
										switch( $postItem->getVariationType() ) {

											case 'featured-image':
												if( $isInClassicBody){ echo '</div>'; $isInClassicBody = false; }

												$this->_getBlock( ffThemeBlConst::FEATUREDIMG )
													->setParam('post-id', $postID)
													->setParam('width', $width)
													->setParam('height', $height)
													->setParam('css-class', 'blog-classic-featured-image')
													->imgIsResponsive()
													->render( $postItem );

												/* Post label NEW */
												if( $imgURL && $query->get('use-label') && get_the_date('Y-m-d') > date('Y-m-d', strtotime('-'. $query->get('label days') .' days')) ) {
													if( ! $isInClassicBody){ echo '<div class="blog-classic-body">'; $isInClassicBody = true; }

													
													$featuredImageSelector = $this->_getAssetsRenderer()->removeSelectorFromCascade();
													$this->_advancedToggleBoxStart( $query, 'label');
													echo '<span class="blog-classic-label">'. $query->getWpKses('label label-text') .'</span>';
													$this->_advancedToggleBoxEnd( $query, 'label');
													$this->_getAssetsRenderer()->addSelectorToCascade( $featuredImageSelector );

													$labelHasBeenPrinted = true;
												}
												break;

											case 'title':

												if( ! $isInClassicBody){ echo '<div class="blog-classic-body">'; $isInClassicBody = true; }

												$this->_applySystemTabsOnRepeatableStart( $postItem );
												echo '<h2 class="blog-classic-title">'. $this->_getPostTitle( $postItem ) .'</h2>';
												$this->_applySystemTabsOnRepeatableEnd( $postItem );
												break;

											case 'p-content':
												if( ! $isInClassicBody){ echo '<div class="blog-classic-body">'; $isInClassicBody = true; }

												$this->_applySystemTabsOnRepeatableStart( $postItem );
												echo '<div class="blog-classic-subtitle">';
													$this->_getBlock( ffThemeBlConst::CONTENT )->render( $postItem );
												echo '</div>';
												$this->_applySystemTabsOnRepeatableEnd( $postItem );
												break;

											case 'divider':
												if( ! $isInClassicBody){ echo '<div class="blog-classic-body">'; $isInClassicBody = true; }
												echo '<div class="blog-classic-divider"></div>';
												break;

											case 'meta-data':
												if( ! $isInClassicBody){ echo '<div class="blog-classic-body">'; $isInClassicBody = true; }

												$this->_applySystemTabsOnRepeatableStart( $postItem );

												echo '<p class="blog-classic-paragraph">';
													$this->_renderMetaElement( $postItem );
												echo '</p>';
												$this->_applySystemTabsOnRepeatableEnd( $postItem );
												break;

											case 'button':
												if( ! $isInClassicBody){ echo '<div class="blog-classic-body">'; $isInClassicBody = true; }

												$this->_applySystemTabsOnRepeatableStart( $postItem );
												
												echo '<div class="blog-button-holder">';
												$this->_getBlock(ffThemeBlConst::BUTTON)->setParam('use-custom-url', $postURL )->render($postItem);
												echo '</div>';
												$this->_applySystemTabsOnRepeatableEnd( $postItem );
												break;

										}
									}
								}
								if( $isInClassicBody){ echo '</div>'; }
								$this->_getAssetsRenderer()->removeSelectorFromCascade();
								echo '</div>';

								if( $query->get('show-hover-overlay') ) {
									$this->getAssetsRenderer()->addSelectorToCascade('blog-classic-overlay');

									$borderHoverColor = $query->getColor('border-hover-overlay-color');

									if( !empty($borderHoverColor) ) {
										$this->_getAssetsRenderer()
											->createCssRule()
											->setState('before')
											->addParamsString('border-top: 1px solid '.$borderHoverColor.' !important;');

										$this->_getAssetsRenderer()
											->createCssRule()
											->setState('before')
											->addParamsString('border-bottom: 1px solid '.$borderHoverColor.' !important;');

										$this->_getAssetsRenderer()
											->createCssRule()
											->setState('after')
											->addParamsString('border-left: 1px solid '.$borderHoverColor.' !important;');

										$this->_getAssetsRenderer()
											->createCssRule()
											->setState('after')
											->addParamsString('border-right: 1px solid '.$borderHoverColor.' !important;');
									}

									if( $query->getColor('bg-hover-overlay-color') ) {
										$this->getAssetsRenderer()->createCssRule()
											->setAddWhiteSpaceBetweenSelectors(false)
											->addSelector(' .blog-classic-hover:before', false)
											->addParamsString('background-color: '.$query->getColor('bg-hover-overlay-color').';');
									}

									echo '<div class="blog-classic-overlay '.$query->getWpKses('overlay-content-align').'">';
										$featuredImageQuery = $query->getMustBeQueryNotEmpty('featured-image-overlay');

										$img = $this->_getBlock( ffThemeBlConst::FEATUREDIMG )
											->setParam('post-id', $postID)
											->setParam('get-url', true)
											->setParam('width', $widthOverlayImg)
											->setParam('height', $heightOverlayImg)
											->setParam('css-class', 'blog-classic-overlay-featured-image')
											->imgIsResponsive()
											->render( $featuredImageQuery );

										echo '<div class="blog-classic-hover" style="background-image: url('. $img .')">';
										echo '</div>';

										echo '<div class="blog-classic-overlay-body">';
										$this->_getStatusHolder()->addTextColorToStack('fg-text-light');
										if( $query->exists('overlay') ) {
											foreach( $query->get('overlay') as $postItem ) {
												switch( $postItem->getVariationType() ) {

													case 'title':
														echo '<h2 class="blog-classic-title">'. $this->_getPostTitle( $postItem ) .'</h2>';
														break;

													case 'p-content':
														echo '<div class="blog-classic-subtitle">';
														$this->_getBlock( ffThemeBlConst::CONTENT )->render( $postItem );
														echo '</div>';
														break;

													case 'divider':
														echo '<div class="blog-classic-divider"></div>';
														break;

													case 'meta-data':
														echo '<p class="blog-classic-paragraph">';
															$this->_renderMetaElement( $postItem );
														echo '</p>';
														break;

												}
											}
										}
										$this->_getStatusHolder()->removeTextColorFromStack();
										echo '</div>';
									echo '</div>';

									echo '<a href="'. esc_url( get_permalink() ) .'" class="blog-classic-link"></a>';
									$this->_getAssetsRenderer()->removeSelectorFromCascade();
								}
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
				->addSelector(' .blog-classic-body-part .blog-classic-body', false)
				->addParamsString('background-color: '.$query->getColor('content-bg-color').';');
		}

		if( $query->getColor('label-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-classic-body-part .blog-classic-body .blog-classic-label', false)
				->addParamsString('color: '.$query->getColor('label-text-color').';');
		}

		if( $query->getColor('label-bg-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-classic-body-part .blog-classic-body .blog-classic-label', false)
				->addParamsString('background-color: '.$query->getColor('label-bg-color').';');
		}

		if( $query->getColor('title-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-classic-body-part .blog-classic-body .blog-classic-title a', false)
				->addParamsString('color: '.$query->getColor('title-text-color').';');
		}

		if( $query->getColor('title-text-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-classic-body-part .blog-classic-body .blog-classic-title a:hover', false)
				->addParamsString('color: '.$query->getColor('title-text-hover-color').';');
		}

		if( $query->getColor('divider-color', '#c0c0c8') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-classic-body .blog-classic-divider', false)
				->addParamsString('background-color: '.$query->getColor('divider-color', '#c0c0c8').';');
		}

		if( $query->getColor('content-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-classic-body .blog-classic-subtitle', false)
				->addParamsString('color: '.$query->getColor('content-text-color').';');
		}

		if( $query->getColor('content-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-classic-body .blog-classic-subtitle p', false)
				->addParamsString('color: '.$query->getColor('content-text-color').';');
		}

		if( $query->getColor('content-link-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-classic-body .blog-classic-subtitle a', false)
				->addParamsString('color: '.$query->getColor('content-link-color').';');
		}

		if( $query->getColor('content-link-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-classic-body .blog-classic-subtitle a:hover', false)
				->addParamsString('color: '.$query->getColor('content-link-hover-color').';');
		}

		if( $query->getColor('meta-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-classic-body .ff-meta-item', false)
				->addParamsString('color: '.$query->getColor('meta-text-color').';');
		}

		if( $query->getColor('meta-link-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-classic-body .ff-meta-item a', false)
				->addParamsString('color: '.$query->getColor('meta-link-color').';');
		}

		if( $query->getColor('meta-link-hover-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-classic-body .ff-meta-item a:hover', false)
				->addParamsString('color: '.$query->getColor('meta-link-hover-color').';');
		}

		if( $query->getColor('meta-separator-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-classic-body .ff-meta-separator', false)
				->addParamsString('color: '.$query->getColor('meta-separator-color').';');
		}

		if( $query->getColor('meta-icon-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-classic-body .ff-meta-icon', false)
				->addParamsString('color: '.$query->getColor('meta-icon-color').';');
		}

		/* OVERLAY COLORS */

		if( $query->getColor('overlay-title-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-classic-overlay-body .blog-classic-title', false)
				->addParamsString('color: '.$query->getColor('overlay-title-text-color').';');
		}

		if( $query->getColor('overlay-title-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-classic-overlay-body .blog-classic-title a', false)
				->addParamsString('color: '.$query->getColor('overlay-title-text-color').';');
		}

		if( $query->getColor('overlay-divider-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-classic-overlay-body .blog-classic-divider', false)
				->addParamsString('background-color: '.$query->getColor('overlay-divider-color').';');
		}

		if( $query->getColor('overlay-content-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-classic-overlay-body .blog-classic-subtitle', false)
				->addParamsString('color: '.$query->getColor('overlay-content-text-color').';');
		}

		if( $query->getColor('overlay-content-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-classic-overlay-body .blog-classic-subtitle p', false)
				->addParamsString('color: '.$query->getColor('overlay-content-text-color').';');
		}

		if( $query->getColor('overlay-content-link-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-classic-overlay-body .blog-classic-subtitle a', false)
				->addParamsString('color: '.$query->getColor('overlay-content-link-color').';');
		}

		if( $query->getColor('overlay-meta-text-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-classic-overlay-body .ff-meta-item', false)
				->addParamsString('color: '.$query->getColor('overlay-meta-text-color').';');
		}

		if( $query->getColor('overlay-meta-link-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-classic-overlay-body .ff-meta-item a', false)
				->addParamsString('color: '.$query->getColor('overlay-meta-link-color').';');
		}

		if( $query->getColor('overlay-meta-separator-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-classic-overlay-body .ff-meta-separator', false)
				->addParamsString('color: '.$query->getColor('overlay-meta-separator-color').';');
		}

		if( $query->getColor('overlay-meta-icon-color') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .blog-classic-overlay-body .ff-meta-icon', false)
				->addParamsString('color: '.$query->getColor('overlay-meta-icon-color').';');
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
							case 'featured-image':
								query.addPlainText('Featured Image');
								query.addBreak();
								break;
							case 'title':
								query.addPlainText('Post Title');
								query.addBreak();
								break;
							case 'p-content':
								query.addPlainText('Post Content');
								query.addBreak();
								break;
							case 'divider':
								query.addPlainText('-');
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