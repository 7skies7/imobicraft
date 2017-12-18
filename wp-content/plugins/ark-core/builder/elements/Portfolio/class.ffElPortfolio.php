<?php
abstract class ffElPortfolio extends ffThemeBuilderElementBasic {

/**********************************************************************************************************************/
/* PORTFOLIO TAGS HANDELING
/**********************************************************************************************************************/
	/**
	 * @param null $postId
	 * @return array|WP_Error
	 */
	protected function _getPortfolioTagsForOnePost( $postId = null ) {
		if( $postId == null ) {
			global $post;
			$postId = $post->ID;
		}

		$ret = wp_get_post_terms($postId, $this->_filterTax);

		return $ret;
	}


	/**
	 * @param $wpQuery WP_Query
	 * @return array
	 */
	protected function _getAllPortfolioTagsFromQuery( $wpQuery ) {

		$uniqueTags = array();
		if( $wpQuery->have_posts() ) {

			while( $wpQuery->have_posts() ) {
				$wpQuery->the_post();

				$tagsForOnePost = $this->_getPortfolioTagsForOnePost();

				foreach( $tagsForOnePost as $oneTag ) {
					$uniqueTags[ $oneTag->slug ] = $oneTag;
				}
			}

		}

		$wpQuery->reset_postdata();

		return $uniqueTags;
	}


/**********************************************************************************************************************/
/* PORTFOLIO POSTS (title, subtitle etc) handling
/**********************************************************************************************************************/
	private $_postQuery = null;

	/**
	 * @return ffOptionsQuery
	 */
	protected function _getPostQuery() {
		return $this->_postQuery;
	}

	protected function _setPost( $postId ) {
		$this->_postQuery = $this->_getPostQueryFromPostId( $postId );
	}

	protected function _getPostTitle() {
		$title = $this->_getPostQuery()->get('general title title');
		if( empty($title) ){
			return get_the_title();
		}else{
			return $title;
		}
	}

	protected function _getButtonUrl() {
		$url = $this->_getPostQuery()->get('general url url');
		if( empty($url) ){
			return get_permalink();
		} else {
			return $url;
		}
	}

	protected function _getButtonTarget() {
		$target = $this->_getPostQuery()->get('general url target');
		if( empty($target) ){
			return '';
		} else {
			return $target;
		}
	}

	protected function _getSlugByTitle( $title ){
		$term = get_term_by('name', $title);
		if( FALSE === $term ){
			return sanitize_title($title);
		}else{
			return $term->slug;
		}
	}

	protected function _getOrderInSlugs($order){
		$order = explode("\n", $order);
		$ret = array();
		foreach( $order as $t ){
			$t = trim( $t );
			if( empty($t) ){
				continue;
			}
			if( '*' == $t ){
				$ret[] = '*';
			}else{
				$ret[] = $this->_getSlugByTitle( $t );
			}
		}
		return $ret;
	}

	protected function _getPortfolioSortableClasses( $filterOrder = null, $postID ) {
		$portfolioTags = $this->_getPortfolioTagsForOnePost($postID);
		$portfolioTags = $this->_censurePortfolioTagsForPost( $filterOrder, $portfolioTags );
		$sortableClasses = '';
		if( !empty( $portfolioTags ) ) {
			foreach( $portfolioTags as $oneTag ) {
				$sortableClasses .= ' '.$oneTag->slug;
			}
		}

		return $sortableClasses;
	}

	protected function _getImageDefaultWidthInColumns( $numberOfColumns ) {

		switch( $numberOfColumns ) {
			case 1:
				$width = 1440;
				break;
			case 2:
				$width = 768;
				break;
			case 3:
				$width = 768;
				break;
			default:
				$width = 768;
				break;
		}

		return $width;
	}

	private function _censurePortfolioTagsForPost( $filterOrder, $tagsForPost ) {

		if( empty( $filterOrder ) ) {
			return $tagsForPost;
		}

		$tagsToReturn = array();

		foreach( $tagsForPost as $oneTag ) {
			$tagName = $this->_getSlugByTitle( trim($oneTag->name) );

			if( in_array( $tagName, $filterOrder ) ) {
				$tagsToReturn[] = $oneTag;
			}
		}

		return $tagsToReturn;
	}

	protected function _getSubtitle( $wrapTagsWithLink = true, $tagsDivider = ', ', $filterOrder = null ) {
		$subtitle = $this->_getPostQuery()->get('general subtitle subtitle');
		if( ! empty($subtitle) ){
			return '<span class="ff-portfolio-diff-subtitle">' . $subtitle . '</span>';
		}

		$tags = $this->_getPortfolioTagsForOnePost();
		$tags = $this->_censurePortfolioTagsForPost( $filterOrder, $tags );

		$tagsString = '';
		if( !empty( $tags ) ) {
			$tagsArray = array();
			foreach( $tags as $key => $oneTag ) {
				$tag = '';
				if( $wrapTagsWithLink ) {
					$tag .= '<a class="ff-portfolio-item-filter" data-filter="'.$oneTag->slug.'" href="'. esc_url(get_term_link($oneTag, $oneTag->slug))  .'">';
				} else {
					$tag .= '<span class="ff-portfolio-item-filter" data-filter="'.$oneTag->slug.'">';
				}

				$tag .= $oneTag->name;

				if( $wrapTagsWithLink ) {
					$tag .= '</a>';
				} else {
					$tag .= '</span>';
				}

				$tagsArray[] = $tag;
			}

			$tagsString = implode( $tagsDivider, $tagsArray );
		}

		return $tagsString;

	}

	protected function _getPostQueryFromPostId( $postId ) {
		$fwc = ffContainer();

		$postMeta = $fwc->getDataStorageFactory()->createDataStorageWPPostMetas();
		$data = $postMeta->getOptionCodedJSON( $postId, 'portfolio_category_options');

//		$data = $fwc->getDataStorageFactory()->createDataStorageWPPostMetas_NamespaceFacade(  $post->ID )->getOptionCodedJSON('portfolio_category_options');
		$postQuery = $fwc->getOptionsFactory()->createQuery( $data,'ffComponent_Theme_MetaboxPortfolioView');

		return $postQuery;
	}

/**********************************************************************************************************************/
/* PORTFOLIO SORTABLE PANEL HANDELING
/**********************************************************************************************************************/
	/**
	 * @param $s ffThemeBuilderOptionsExtender
	 */
	protected function _injectFilterablePanelOptions( $s ) {
		$s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Filters', 'ark' ) ));

			$s->startHidingBox('grid-variant', array('grid-variant-1', 'grid-variant-2'));

				$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'show-filter-panel', ark_wp_kses( __('Show Filters', 'ark' ) ), 1);
				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->startHidingBox('show-filter-panel', 'checked');
					// filter custom-filter-taxonomy
					// filter custom-filter-taxonomy-name
					$s->startAdvancedToggleBox('filter', 'Filters');

						$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'enable-all-filters', ark_wp_kses( __('Show really all filters (even they who do not have any posts inside)', 'ark' ) ), 0);

						$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'enable-deep-linking', ark_wp_kses( __('Enable deep linking (# in url)', 'ark' ) ), 0);

						$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'show-filter-all', ark_wp_kses( __('Show the \'All\' filter', 'ark' ) ), 1);

						$s->startHidingBox('show-filter-all', 'checked');
							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'filter-button-all', '', 'All')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('\'All\' filter text', 'ark' ) ) )
							;
						$s->endHidingBox();

						$s->startHidingBox('show-filter-all', 'unchecked');
							$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses( __('If you are not using the \'All\' filter then you <strong>must</strong> set a custom <strong>Default Filter</strong> in the options below.', 'ark' ) ) );
						$s->endHidingBox();


						$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'custom-filter-taxonomy', ark_wp_kses( __('Use Custom Filter Taxonomy', 'ark' ) ), 0);
						$s->startHidingBox('custom-filter-taxonomy', 'checked');
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'custom-filter-taxonomy-name', '', 'ff-portfolio-tag')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Custom Filter Taxonomy Name', 'ark' ) ) )
						;
						$s->endHidingBox();


						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$optType = $s->addOptionNL( ffOneOption::TYPE_SELECT, 'filter-animation', '', 'rotateSides')
							->addSelectValue( '', '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Filtering animation', 'ark' ) ) )
						;

						$possibleAnimations = array(
							'fadeOut',
							'quicksand',
							'bounceLeft',
							'bounceTop',
							'bounceBottom',
							'moveLeft',
							'slideLeft',
							'fadeOutTop',
							'sequentially',
							'skew',
							'slideDelay',
							'3d Flip',
							'rotateSides',
							'flipOutDelay',
							'flipOut',
							'unfold',
							'foldLeft',
							'scaleDown',
							'scaleSides',
							'frontRow',
							'flipBottom',
							'rotateRoom',
						);

						foreach ($possibleAnimations as $possibleValue) {
							$possibleValueTitle = str_replace('-', ' ', $possibleValue);
							$possibleValueTitle = ucfirst( $possibleValueTitle );
							$optType->addSelectValue( $possibleValueTitle, $possibleValue );
						}

						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL( ffOneOption::TYPE_SELECT, 'filters-pos', '', 'top')
							->addSelectValue( esc_attr( __('Top', 'ark' ) ), 'top')
							->addSelectValue( esc_attr( __('Side', 'ark' ) ), 'side')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Filters Position', 'ark' ) ) )
							;

						$s->startHidingBox('filters-pos', 'top');
							$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'show-filter-counter', ark_wp_kses( __('Show counter when hovering over a filter', 'ark' ) ), 1);
						$s->endHidingBox();

						$s->startHidingBox('filters-pos', 'side');

							$s->addOptionNL( ffOneOption::TYPE_SELECT, 'align-filter-panel', '', 'left')
								->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'left')
								->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'right')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Filters Column Position', 'ark' ) ) )
								;

							$s->addElement(ffOneElement::TYPE_NEW_LINE);

							$s->startAdvancedToggleBox('main-filters-col',esc_attr( __('Filters Column', 'ark' ) ) );
								$this->_getBlock( ffThemeBuilderBlock::BOOTSTRAP_COLUMNS )->setParam('default', array('md'=>2))->injectOptions( $s );
							$s->endAdvancedToggleBox();

							$s->addElement(ffOneElement::TYPE_NEW_LINE);

							$s->startAdvancedToggleBox('main-content-col',esc_attr( __('Main Content Column', 'ark' ) ) );
								$this->_getBlock( ffThemeBuilderBlock::BOOTSTRAP_COLUMNS )->setParam('default', array('md'=>10))->injectOptions( $s );
							$s->endAdvancedToggleBox();

						$s->endHidingBox();

						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Default Filter', 'ark' ) ) );
							$s->addOption( ffOneOption::TYPE_TEXT, 'default-filter', '', '*');
							$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses( __('Choose which filter will be active on load. Write it\'s exact name, case-sensitive. Write <code>*</code> for <code>All</code>. Example:', 'ark' ) ) );
							$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses( __('If you want to a tag <code>My Music</code> to be your default, then write <code>My Music</code> into the text input.', 'ark' ) ) );
						$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);

						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Filters Order', 'ark' ) ) );
							$s->addOption( ffOneOption::TYPE_TEXTAREA, 'filter-order', '', '');
							$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses( __('Write one tag per line. Must be it\'s exact name and is case-sensitive. Write <code>*</code> for <code>All</code>. Example:', 'ark' ) ) );
							$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses( __('<code>My Music</code>', 'ark' ) ) );
							$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses( __('<code>*</code>', 'ark' ) ) );
							$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses( __('Will be ordered as: <code>My Music, All</code>', 'ark' ) ) );
						$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);

					$s->endAdvancedToggleBox();

				$s->endHidingBox();

			$s->endHidingBox();

			$s->startHidingBox('grid-variant', array('grid-variant-3'));

				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses( __('Filters are not available for "Slider" Portfolio Type.', 'ark' ) ) );

			$s->endHidingBox();

		$s->addElement(ffOneElement::TYPE_TABLE_DATA_END);
	}

	private $_filterTax = 'ff-portfolio-tag';

	protected function _getWpLoop() {

	}

	/**
	 * @param $query ffOptionsQuery
	 */
	protected function _printFilterablePanel( $query, $wpQuery ) {

		if ( 'grid-variant-1' == $query->get('grid-variant') || 'grid-variant-2' == $query->get('grid-variant') ){

			if( !$query->get('show-filter-panel') ) {
				return;
			}


			if( $query->getWithoutComparationDefault('filter enable-all-filters', 0) ) {

				$loopBlock = $this->_getWpLoop();
				$loopBlock->setParam( ffThemeBuilderBlock_Loop::PARAM_RETURN_ALL_POSTS, true );
				$wpQueryAll = $loopBlock->get($query);
				$loopBlock->setParam( ffThemeBuilderBlock_Loop::PARAM_RETURN_ALL_POSTS, false );

				$wpQueryToSet = $wpQueryAll;
			} else {
				$wpQueryToSet = $wpQuery;
			}
			// filter custom-filter-taxonomy
			// filter custom-filter-taxonomy-name

			$query = $query->get('filter');




			if( $query->getWithoutComparationDefault('custom-filter-taxonomy', false) ) {
				$this->_filterTax = $query->getWithoutComparationDefault('custom-filter-taxonomy-name', 'ff-portfolio-tag');
			}

			$this->_advancedToggleBoxStart( $query );

				$this->_printPortfolioTags( $query, $wpQueryToSet );

			$this->_advancedToggleBoxEnd( $query );

		}

	}

	/**
	 * @param $query ffOptionsQuery
	 */

	private function _findTagByName( $allTags, $tagName ) {
		foreach( $allTags as $oneTag ) {
			if( $oneTag->name == $tagName ) {
				return $oneTag;
			}
			if( $oneTag->name == sanitize_title( $tagName ) ) {
				return $oneTag;
			}
		}

		return null;
	}
	/**
	 * @param $query ffOptionsQuery
	 */
	private function _printPortfolioTags( $query, $wpQuery ) {

		$tags = $this->_getAllPortfolioTagsFromQuery( $wpQuery );

		$filterOrder = $query->get('filter-order');

		if ( $query->get('show-filter-counter') && 'top' == $query->get('filters-pos') ){
			$filterCounter = ' <div class="cbp-filter-counter"></div> ';
		} else {
			$filterCounter = '';
		}

		$filtersCssPos = 'cbp-l-filters-alignCenter';
		if ( 'side' == $query->get('filters-pos') ){
			if ( 'left' == $query->get('align-filter-panel') ){
				$filtersCssPos .= ' ff-portfolio-filters-text-align-right';
			} else if ( 'right' == $query->get('align-filter-panel') ){
				$filtersCssPos .= ' ff-portfolio-filters-text-align-left';
			}
		} else {
			$filtersCssPos .= ' ff-portfolio-filters-on-top';
		}

		echo '<div class="ff-portfolio-filter cbp-l-filters-alignCenter '.$filtersCssPos.' ">';

		if( !empty( $filterOrder ) ) {
			$order = explode("\n", $filterOrder );

			foreach( $order as $oneTagName ) {
				$oneTagName = trim($oneTagName);
				if( '*' == $oneTagName && $query->get('show-filter-all') ) {
					echo '<div data-filter="*" class="cbp-filter-item">'
						. $query->get('filter-button-all')
						. $filterCounter
						. '</div>';
				} else {
					$oneTag = $this->_findTagByName( $tags, $oneTagName );

					if( $oneTag != null ) {
						echo '<div data-filter=".'.$oneTag->slug.'" class="cbp-filter-item">'
							. $oneTag->name
							. $filterCounter
							. '</div>';
					}
				}
			}

		} else {
			if ( $query->get('show-filter-all') ){
				echo '<div data-filter="*" class="cbp-filter-item">'
					. $query->get('filter-button-all')
					. $filterCounter
					. '</div>';
			}

			foreach( $tags as $oneTag ) {
				echo '<div data-filter=".'.$oneTag->slug.'" class="cbp-filter-item">'
					. $oneTag->name
					. $filterCounter
					. '</div>';
			}

		}
		echo '</div>';

	}
/**********************************************************************************************************************/
/* LIGHTBOX ICON AND IMAGE
/**********************************************************************************************************************/
	/**
	 * @param $s ffThemeBuilderOptionsExtender
	 */
	protected function _injectLightboxOptions( $s ) {

		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'lightbox-icon-color', '', '')
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Popup Button Icon', 'ark' ) ) )
		;

		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'lightbox-icon-color-hover', '', '')
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Popup Button Icon Hover', 'ark' ) ) )
		;

		$s->addElement(ffOneElement::TYPE_NEW_LINE);

		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'lightbox-icon-background', '', '#ffffff')
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Popup Button Background', 'ark' ) ) )
		;

		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'lightbox-icon-background-hover', '', '[1]')
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Popup Button Background Hover', 'ark' ) ) )
		;
	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	protected function _printLightboxImageColors( $query ) {

		$lightboxIconColor = $query->getColor('lightbox-icon-color');
		$lightboxIconBackground = $query->getColor('lightbox-icon-background');
		$lightboxIconColorHover = $query->getColor('lightbox-icon-color-hover');
		$lightboxIconBackgroundHover = $query->getColor('lightbox-icon-background-hover');

		$ar = $this->_getAssetsRenderer();

		if( $lightboxIconColor ) {
			$ar->createCssRule()
				->addSelector('.ff-lightbox-icon')
				->addParamsString('color: ' . $lightboxIconColor . ' !important;');
		}

		if( $lightboxIconBackground ) {
			$ar->createCssRule()
				->addSelector('.ff-lightbox-icon')
				->addParamsString('background-color: ' . $lightboxIconBackground . ' !important;');
		}


		if( $lightboxIconColorHover ) {
			$ar->createCssRule()
				->addSelector('.ff-lightbox-icon:hover')
				->addParamsString('color: ' . $lightboxIconColorHover . ' !important;');
		}

		if( $lightboxIconBackgroundHover ) {
			$ar->createCssRule()
				->addSelector('.ff-lightbox-icon:hover')
				->addParamsString('background-color: ' . $lightboxIconBackgroundHover . ' !important;');
		}

	}
}