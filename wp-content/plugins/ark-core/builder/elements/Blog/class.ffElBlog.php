<?php

class ffElBlog extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'blog');

	}

	protected function _getBreakpoints() {
		$breakpoints = array();

		$breakpoints[] = 'xs';
		$breakpoints[] = 'sm';
		$breakpoints[] = 'md';
		$breakpoints[] = 'lg';

		return $breakpoints;
	}

/**********************************************************************************************************************/
/* COLUMNS
/**********************************************************************************************************************/
	/**
	 * @param $select ffOneOption
	 * @param $columns array
	 */
	protected function _fillSelectWithNumberOfColumns( $select, $columns ) {

		foreach( $columns as $oneColumn ) {
			$select->addSelectValue( $oneColumn, $oneColumn );
		}

	}

	/**
	 * @param $loopBlock ffThemeBuilderBlock_Loop
	 */
	protected function _printLoopVarDump( $loopBlock ) {
		$debugDumpContent = $loopBlock->getParam( ffThemeBuilderBlock_Loop::PARAM_DEBUG_DUMP_CONTENT, null );
		if( $debugDumpContent != null ) {
			// Debug function output
			echo ( $debugDumpContent );
		}
	}

	/**
	 * @param $s ffThemeBuilderOptionsExtender
	 */
	protected function _injectTitleOptions( $s, $params = null ) {
		$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'is-link', 'Post Title links to Single Post', 1);
		$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'limit-content-length', ark_wp_kses( __('Limit Post Title Length', 'ark' ) ), 0);

		$s->startHidingBox('limit-content-length', 'checked');
		$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'NOTE: Limiting strips all HTML tags');

		$s->addOptionNL(ffOneOption::TYPE_SELECT, 'limit-content-type', '', 'words')
			->addSelectValue( esc_attr( __('By number of words', 'ark' ) ), 'words')
			->addSelectValue( esc_attr( __('By number of letters', 'ark' ) ), 'letters')
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Limit Type', 'ark' ) ) )
		;

		$s->addOptionNL( ffOneOption::TYPE_TEXT, 'limit-size', '', 20)
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Maximum number of words/letters', 'ark' ) ) )
		;

		$s->addOptionNL( ffOneOption::TYPE_TEXT, 'after-limit-text', '', '&hellip;')
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text after the limitation, for example: <code>...</code>', 'ark' ) ) )
		;
		$s->addElement( ffOneElement::TYPE_NEW_LINE );
		$s->endHidingBox();
	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 * @param $params array
	 *
	 * @return string
	 */
	protected function _getPostTitle( $query, $params = array() ) {
		$titleString = get_the_title();

		if( $query->get('limit-content-length' ) ) {

			$limitType = $query->get('limit-content-type' );
			$limitSize = $query->get('limit-size');
			$afterLimitText = $query->get('after-limit-text');

			if ($limitType == 'letters') {
				$titleString = wp_strip_all_tags($titleString);
				if ( strlen($titleString) > $limitSize ){
					$titleString = substr($titleString, 0, $limitSize);
					$titleString .= $afterLimitText;
				}
			} else if ($limitType == 'words') {
				$titleString = wp_strip_all_tags($titleString);
				$titleString = wp_trim_words($titleString, $limitSize, $afterLimitText);
			}
		}

		$beforeTitle = $this->_getDefaultParam('before-title', '', $params );
		$linkCssClass = $this->_getDefaultParam('link-css-class', '', $params );

		if( $query->get('is-link') ) {
			$titleString = '<a class="'.$linkCssClass.'" href="'. esc_url( get_permalink() ) .'">' . $beforeTitle . $titleString . '</a>';
		}

		return $titleString;
	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 * @param $params array
	 */
	protected function _printPostTitle( $query, $params = array() ) {
		// Escaped post title
		echo ( $this->_getPostTitle( $query, $params ) );
	}

	private function _getDefaultParam( $name, $default, $params ) {
		if( isset( $params[ $name ] ) ) {
			return $params[ $name ];
		} else {
			return $default;
		}
	}

	/**
	 * @param $s ffThemeBuilderOptionsExtender
	 * @param array $defaults
	 * @param array $columns_options
	 */
	protected function _injectColumnOptions( $s, $defaults = null, $columns_options = null ) {

		$xs = isset( $defaults['xs'] ) ? $defaults['xs'] : 1;
		$sm = isset( $defaults['sm'] ) ? $defaults['sm'] : 2;
		$md = isset( $defaults['md'] ) ? $defaults['md'] : 3;
		$lg = isset( $defaults['lg'] ) ? $defaults['lg'] : 3;

		if( empty( $columns_options ) ) {
			$columns_options = array(1, 2, 3, 4, 6);
		}

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Columns Settings', 'ark' ) ) );
			$s->startSection('grid');
				$select = $s->addOptionNL(ffOneOption::TYPE_SELECT, 'xs', 'Phone (XS)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $xs);
				$this->_fillSelectWithNumberOfColumns( $select, $columns_options );
				$select->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Column(s)', 'ark' ) ) );

				$select = $s->addOptionNL(ffOneOption::TYPE_SELECT, 'sm', 'Tablet (SM)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $sm);
				$this->_fillSelectWithNumberOfColumns( $select, $columns_options );
				$select->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Column(s)', 'ark' ) ) );

				$select = $s->addOptionNL(ffOneOption::TYPE_SELECT, 'md', 'Laptop (MD)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $md);
				$this->_fillSelectWithNumberOfColumns( $select, $columns_options );
				$select->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Column(s)', 'ark' ) ) );

				$select = $s->addOptionNL(ffOneOption::TYPE_SELECT, 'lg', 'Desktop (LG)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $lg);
				$this->_fillSelectWithNumberOfColumns( $select, $columns_options );
				$select->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Column(s)', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);
				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'space', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Custom horizontal gap between columns (in px)', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'space-vertical', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Custom vertical gap between columns (in px)', 'ark' ) ) );


			$s->endSection();

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);
	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	protected function _calculateColumnOptions( $query ) {
		if( !$query->exists( 'grid') ) {
			return false;
		}

		$cols = array();
		$query = $query->get('grid');
		foreach( $this->_getBreakpoints() as $oneBreakpoint ) {
			$numberOfColumns = $query->get( $oneBreakpoint );
			$bootstrapNumber = 12 / $numberOfColumns;

			$cols[] = 'col-' . $oneBreakpoint . '-' . $bootstrapNumber;
		}

		$colsString = implode(' ', $cols);

		$spaceBetweenColumns = $query->get('space');

		if( $spaceBetweenColumns !== '' ) {
			$spaceBetweenColumns = floatval($spaceBetweenColumns);
			$oneHalf = $spaceBetweenColumns / 2;

			$rowCss = '';
			$rowCss .= 'margin-left: -' . $oneHalf .'px;' . PHP_EOL;
			$rowCss .= 'margin-right: -' .$oneHalf .'px;';

			$colCss = '';
			$colCss .= 'padding-left:' . $oneHalf .'px;' . PHP_EOL;
			$colCss .= 'padding-right:' .$oneHalf .'px;';


			$this->_getAssetsRenderer()
				->createCssRule()
				->addSelector('.fg-blog-row-main')
				->addParamsString($rowCss );

			$this->_getAssetsRenderer()
				->createCssRule()
				->addSelector('.fg-blog-col-main')
				->addParamsString($colCss );
		}

		$spaceVertical = $query->get('space-vertical');

		if( $spaceVertical != '' ) {
			$spaceVertical = absint( $spaceVertical );

			$this->_getAssetsRenderer()
				->createCssRule()
				->addSelector('.fg-blog-col-main')
				->addParamsString('margin-bottom:' . $spaceVertical . 'px;');
		}

		return $colsString;
	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 * @param $postIndex
	 */
	protected function _printClearFixDiv( $query, $postIndex ) {

		$numberOfColumns = array( 2, 3, 4, 6);
		$grid = $query->get('grid');

		$clearfixClasses = array();

		foreach( $numberOfColumns as $oneColumn ) {
			if( $postIndex % $oneColumn != 0 ) {
				continue;
			}

			foreach( $this->_getBreakpoints() as $oneBreakpoint ) {
				if( $grid->get( $oneBreakpoint ) == $oneColumn ) {
					$clearfixClasses[] = 'visible-' . $oneBreakpoint . '-block';
				}
			}
		}

		if( !empty($clearfixClasses) ) {
			$clearfixString = implode(' ', $clearfixClasses );
			echo '<div class="clearfix ' . $clearfixString .'"></div>';
		}

	}


	/**
	 * @param $s ffThemeBuilderOptionsExtender
	 */
	private function _injectIconOptions( $s ) {
		$s->addElement(ffOneElement::TYPE_NEW_LINE);
		$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'add-icon', 'Use Icon', 0);

		$s->startHidingBox( 'add-icon', 'checked');

			$s->startAdvancedToggleBox('icon', 'Icon');
				$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-et-line icon-clock');

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'position', '', 'before')
					->addSelectValue('Before Meta', 'before')
					->addSelectValue('After Meta', 'after')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Placement', 'ark' ) ) );
			$s->endAdvancedToggleBox();

		$s->endHidingBox();
	}

	/**
	 * @param $s ffThemeBuilderOptionsExtender
	 */
	private function _injectTextBeforeAfter( $s ) {
		$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text-before', '', '')
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Prefix', 'ark' ) ) )
		;
		$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text-after', '', '')
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Suffix', 'ark' ) ) )
		;
	}
	/**
	 * @param $s ffThemeBuilderOptionsExtender
	 * @param bool|false $hasIcon
	 */
	protected function _getElementMetaOptions( $s, $hasIcon = false ) {

		$s->startRepVariableSection('meta-content');

			/*----------------------------------------------------------*/
			/* TYPE AUTHOR
			/*----------------------------------------------------------*/
			$s->startRepVariationSection('author', ark_wp_kses( __('Author', 'ark' ) ) );

				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'is-link', ark_wp_kses( __('Links to Author Archive', 'ark' ) ), 1);

				// image
				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'show-image', ark_wp_kses( __('Show author image', 'ark' ) ), 0);

				$s->startHidingBox('show-image', 'checked');
					$s->startAdvancedToggleBox('author-img', 'Author Image');
						$s->addOptionNL(ffOneOption::TYPE_SELECT, 'image-position', '', 'before')
							->addSelectValue( esc_attr( __('Before Prefix', 'ark' ) ), 'before')
							->addSelectValue( esc_attr( __('After Suffix', 'ark' ) ), 'after')
							->addParam(ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Image Placement', 'ark' ) ));
					$s->endAdvancedToggleBox();
				$s->endHidingBox();

				$this->_injectTextBeforeAfter( $s );
				$this->_injectIconOptions( $s );
			$s->endRepVariationSection();

			/*----------------------------------------------------------*/
			/* TYPE DATE
			/*----------------------------------------------------------*/
			$s->startRepVariationSection('date', ark_wp_kses( __('Date', 'ark' ) ));
				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'is-link', ark_wp_kses( __('Links to Date Archive', 'ark' ) ), 1);
				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'date-format', '', 'm/d/Y')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Date format', 'ark' ) ) )
				;
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('Available date formats: <a href="//php.net/manual/en/function.date.php" target="_blank">Date PHP function manual</a>', 'ark' ) ) );
				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$this->_injectTextBeforeAfter( $s );
				$this->_injectIconOptions( $s );
			$s->endRepVariationSection();

			/*----------------------------------------------------------*/
			/* TYPE CATEGORIES
			/*----------------------------------------------------------*/
			$s->startRepVariationSection('categories', ark_wp_kses( __('Categories', 'ark' ) ));
				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'is-link', ark_wp_kses( __('Links to Category Archive', 'ark' ) ), 1);
				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'get-first', ark_wp_kses( __('Display only the first Category', 'ark' ) ), 0);
				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'separator', '', ' / ')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Separator', 'ark' ) ) )
				;
				$this->_injectTextBeforeAfter( $s );
				$this->_injectIconOptions( $s );
			$s->endRepVariationSection();

			/*----------------------------------------------------------*/
			/* TYPE COMMENTS
			/*----------------------------------------------------------*/
			$s->startRepVariationSection('comments', ark_wp_kses( __('Comments', 'ark' ) ) );
				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'is-link', ark_wp_kses( __('Links to Comments', 'ark' ) ), 1);

				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'zero-comments', '', '0 Comments')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Zero Comments Label', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'one-comment', '', '1 Comment')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('One Comment Label', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'more-comments', '', '%s Comments')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('More Comments Label', 'ark' ) ) );

				$this->_injectTextBeforeAfter( $s );
				$this->_injectIconOptions( $s );
			$s->endRepVariationSection();

			/*----------------------------------------------------------*/
			/* TYPE TAGS
			/*----------------------------------------------------------*/
			$s->startRepVariationSection('tags', ark_wp_kses( __('Tags', 'ark' ) ));
				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'is-link', ark_wp_kses( __('Links to Tag Archive', 'ark' ) ), 1);

				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'get-first', ark_wp_kses( __('Display only the first Tag', 'ark' ) ), 0);

				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'separator', '', ' / ')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Separator', 'ark' ) ) );

				$this->_injectTextBeforeAfter( $s );
				$this->_injectIconOptions( $s );
			$s->endRepVariationSection();

		$s->endRepVariableSection();

		$s->addElement(ffOneElement::TYPE_NEW_LINE);
		// $s->addElement(ffOneElement::TYPE_NEW_LINE);

		$s->addOptionNL(ffOneOption::TYPE_SELECT, 'separator-type', '', 'custom')
			->addSelectValue( esc_attr( __('None', 'ark' ) ), 'none')
			->addSelectValue( esc_attr( __('New Line', 'ark' ) ), 'new-line')
			->addSelectValue( esc_attr( __('Custom', 'ark' ) ), 'custom')
			->addParam(ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Meta Data Separator', 'ark') ) );

		$s->startHidingBox('separator-type', 'custom');
			$s->addElement(ffOneElement::TYPE_NEW_LINE);
			$s->startAdvancedToggleBox('custom-separator', 'Custom Separator');
				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text-before', '', ' - ')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Prefix', 'ark' ) ) )
				;

				$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon' ,ark_wp_kses( __('Icon', 'ark' ) ) ,'');

				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text-after', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Suffix', 'ark' ) ) )
				;
			$s->endAdvancedToggleBox();

		$s->endHidingBox();
	}

	protected function _getElementGeneralOptions( $s ) {

	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	protected function _prepareWPQueryForRendering( $query ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

	}

	protected function _getMetaElement( ffOptionsQueryDynamic $query, $params = null ){

		ob_start();
			$string =  implode ( ' ' , $this->_renderMetaElement( $query, $params ) );
		ob_end_clean();

		return $string;

	}

	protected function _metaElementExists( $query ) {
		return $query->exists('meta-content');
	}

	protected function _countMetaElements( $query ) {
		$postMetaGetter = ffContainer()->getThemeFrameworkFactory()->getPostMetaGetter(false);
		/* Counting META DATA */
		$metaCounter = 0;
		$this->_disableSystemVariationBlocksTakeover();
		foreach ($query->getWithCallbacks('meta-content') as $meta) {
			switch ($meta->getVariationType()) {
				case 'author':
					if( $postMetaGetter->getPostAuthorName() ){
						$metaCounter++;
					}
					break;
				case 'date':
					if( get_the_date($meta->getWithoutComparationDefault('date-format', 'm/d/Y')) ){
						$metaCounter++;
					}
					break;

				case 'categories':
					if( has_category() ){
						$metaCounter++;
					}
					break;
				case 'comments':
					if( $postMetaGetter->getPostCommentsLinkText('0', '1', 'more') ){
						$metaCounter++;
					}
					break;
				case 'tags':
					if( has_tag() ){
						$metaCounter++;
					}
					break;

				case 'html':
					$metaCounter++;
					break;
			}
		}
		$this->_enableSystemVariationBlocksTakeover();

		return $metaCounter;
	}

	/**
	 * @param $meta ffOptionsQueryDynamic
	 * @param $content
	 *
	 * @return string
	 */
	protected function _applyTextBeforeOrAfter( $meta, $content ) {
		$textBefore = $meta->getWithoutComparationDefault('text-before', '');
		$textAfter = $meta->getWithoutComparationDefault('text-after', '');

		return $textBefore . $content . $textAfter;
	}

	/**
	 * @param $meta ffOptionsQueryDynamic
	 * @param $content
	 * @return mixed
	 */
	protected function _applyIcon( $meta, $content ) {
		if( !$meta->getWithoutComparationDefault('add-icon') ) {
			return $content;
		}

		$this->_advancedToggleBoxStart( $meta, 'icon' );
			echo '<i class="ff-meta-icon '. $meta->getWithoutComparationDefault('icon icon', 'ff-font-et-line icon-clock') .'"></i>';
		$icon = $this->_advancedToggleBoxEnd( $meta, 'icon', false);

		if( $meta->get('icon position') == 'before' ) {
			$content = $icon . $content;
		} else {
			$content = $content . $icon;
		}

		return $content;
	}

	protected function _printSeparator( $content, $key ) {
		$separatorType = $this->_query->get('separator-type');

		if( $separatorType == 'none' ) {
			return $content;
		}

		else if( $separatorType == 'new-line' ) {
			$content .= '<br>';
		}

		else if( $separatorType == 'custom' ) {
			$query = $this->_query;
			$temporaryClassHolder = $this->_getAssetsRenderer()->removeSelectorFromCascade();
			$this->_advancedToggleBoxStart( $query, 'custom-separator');
				echo '<'. $this->_elementType.' class="ff-meta-separator">';
					// text before
					echo str_replace(' ', '&nbsp;', $query->getWpKses('custom-separator text-before') );
					// icon
					$icon = $query->get('custom-separator icon');
					if( !empty( $icon) ) {
						echo '<i class="'. $query->get('custom-separator icon') .'"></i>';
					}
					// text after
					echo str_replace(' ', '&nbsp;', $query->getWpKses('custom-separator text-after') );

				echo '</'. $this->_elementType.'>';
			$separator = $this->_advancedToggleBoxEnd( $query, 'custom-separator', false);
			$this->_getAssetsRenderer()->addSelectorToCascade( $temporaryClassHolder );
			$content = $separator . $content;
		}

		return $content;
	}

	protected function _finalize( $content, $meta, $key, $printTextBeforeOrAfter = true  ) {
		$elementType = $this->_elementType;
		$elementClass = $this->_elementClass;

		if( $printTextBeforeOrAfter ) {
			$content = $this->_applyTextBeforeOrAfter( $meta, $content );
		}

		$content = $this->_applyIcon( $meta, $content );
		$content = '<'.$elementType.' class="ff-meta-item '.$elementClass.'">' . $content .'</'.$elementType.'>';
		$content = $this->_applySystemThingsOnRepeatable( $content, $meta );

		return $content;
	}

	protected $_elementClass = null;

	protected $_elementType = null;

	protected $_numberOfMeta = null;

	/**
	 * @var $_query ffOptionsQueryDynamic
	 */
	protected $_query = null;

	protected function _renderMetaElement( ffOptionsQueryDynamic $query, $params = array() ) {
		if( !$query->exists('meta-content') ) {
			return false;
		}

		$postMetaGetter = ffContainer()->getThemeFrameworkFactory()->getPostMetaGetter( false );

		$linkClass = isset( $params['link-class'] ) ? esc_attr($params['link-class']) : '';
		$listClass = isset( $params['list-class'] ) ? esc_attr($params['list-class']) : '';
		$imgClass = isset( $params['img-class'] ) ? esc_attr($params['img-class']) : '';

		$this->_elementType = isset( $params['element-type'] ) ? $params['element-type'] : 'span';
		$this->_elementClass = isset( $params['element-class'] ) ? $params['element-class'] : '';

		$this->_numberOfMeta = $this->_countMetaElements( $query );
		$this->_query = $query;

		$postMetasArray = array();
		$this->_disableSystemVariationBlocksTakeover();
		foreach( $query->get('meta-content') as $key => $meta ) {
			$content = '';

			switch ($meta->getVariationType()) {
				/*----------------------------------------------------------*/
				/* AUTHOR
				/*----------------------------------------------------------*/
				case 'author':
					// author link
					if ($meta->get('is-link', 1)) {
						$content .= '<a class="' . $linkClass . '" href="' . esc_url($postMetaGetter->getPostAuthorUrl()) . '">';
						$content .= $postMetaGetter->getPostAuthorName();
						$content .= '</a>';
					} else {
						$content .= $postMetaGetter->getPostAuthorName();
					}

					$content = $this->_applyTextBeforeOrAfter($meta, $content);

					// author image
					if ($meta->get('show-image')) {
						$authorImagePosition = "author-img-" . $meta->get('author-img image-position');

						$oldTag = "class='";
						$newTag = "class='author-img " . $imgClass . " " . $authorImagePosition . " ";

						$this->_advancedToggleBoxStart($meta, 'author-img');
						echo str_replace($oldTag, $newTag, $postMetaGetter->getPostAuthorImage());
						$authorImage = $this->_advancedToggleBoxEnd($meta, 'author-img', false);

						if ($meta->get('author-img image-position') == 'before') {
							$content = $authorImage . $content;
						} else {
							$content = $content . $authorImage;
						}
					}
					break;

				/*----------------------------------------------------------*/
				/* DATE
				/*----------------------------------------------------------*/
				case 'date':
					// date link
					if ($meta->get('is-link', 1)) {
						$year = $postMetaGetter->getPostDate('Y');
						$month = $postMetaGetter->getPostDate('m');
						$day = $postMetaGetter->getPostDate('d');

						$content .= '<a class="' . $linkClass . '" href="' . get_day_link($year, $month, $day) . '">';
					}

					$content .= get_the_date($meta->get('date-format'));

					if ($meta->get('is-link')) {
						$content .= '</a>';
					}
					break;

				/*----------------------------------------------------------*/
				/* CATEGORIES
				/*----------------------------------------------------------*/
				case 'categories':
					if (has_category()) {
						$isLink = $meta->get('is-link');
						$getFirst = $meta->get('get-first');
						$categoriesData = $postMetaGetter->getPostCategoriesArray();
						$separator = $meta->get('separator');

						$categoriesArray = array();

						foreach ($categoriesData as $oneCat) {
							$oneCatString = '';
							$class = 'ff-term-' . $oneCat->term_id;

							if ($isLink) {
								$oneCatString .= '<a href="' . $oneCat->computed_url . '" class="' . $class . '">';
							} else {
								$oneCatString .= '<span class="' . $class . '">';
							}

							$oneCatString .= $oneCat->name;

							if ($isLink) {
								$oneCatString .= '</a>';
							} else {
								$oneCatString .= '</span>';
							}

							$categoriesArray[] = $oneCatString;

							if ($getFirst) {
								break;
							}
						}

						$content = implode('<span class="separator">' . $separator . '</span>', $categoriesArray);
					}
					break;

				/*----------------------------------------------------------*/
				/* TAGS
				/*----------------------------------------------------------*/
				case 'tags':
					if (has_tag()) {
						$separator = $meta->get('separator');
						$tagsData = $postMetaGetter->getPostTagsArray();
						$tagsArray = array();
						$isLink = $meta->get('is-link');
						$getFirst = $meta->get('get-first');

						foreach ($tagsData as $oneTag) {
							$oneTagString = '';
							$class = 'ff-term-' . $oneTag->term_id;

							if ($isLink) {
								$oneTagString .= '<a href="' . $oneTag->computed_url . '" class="' . $class . '">';
							} else {
								$oneTagString .= '<span class="' . $class . '">';
							}

							$oneTagString .= $oneTag->name;

							if ($isLink) {
								$oneTagString .= '</a>';
							} else {
								$oneTagString .= '</span>';
							}

							$tagsArray[] = $oneTagString;

							if ($getFirst) {
								break;
							}
						}

						$content = implode('<span class="separator">' . $separator . '</span>', $tagsArray);
					}

					break;
				/*----------------------------------------------------------*/
				/* COMMENTS
				/*----------------------------------------------------------*/
				case 'comments':
					$zeroComments = $meta->get('zero-comments');
					$oneComment = $meta->get('one-comment');
					$moreComment = $meta->get('more-comments');

					$commentsOriginal = $postMetaGetter->getPostCommentsLinkText($zeroComments, $oneComment, $moreComment);
					$content = $commentsOriginal;

					if (!$meta->getWithoutComparationDefault('is-link')) {
						$content = strip_tags($content);
					}
					break;

				/*----------------------------------------------------------*/
				/* HTML
				/*----------------------------------------------------------*/
				case 'html':
//					echo '--html--';
//					var_dump( $meta->getOnlyDataPartWithCurrentPath() );
					$content = $this->_getSystemVariationBlocks( $meta );
//					var_dump( $content );
					break;
			}

			if( !empty($content) ) {
				if ('author' == $meta->getVariationType()) {
					$content = $this->_finalize($content, $meta, $key, false);
				} else {
					$content = $this->_finalize($content, $meta, $key);
				}
				if( !empty($postMetasArray) ){
					$content = $this->_printSeparator( $content, $key );
				}

				$postMetasArray[] = $content;
			}
		}
		$this->_enableSystemVariationBlocksTakeover();
		if( $listClass ) {
			echo '<span class="'. $listClass .'">';
			echo implode('</span><span class="'. $listClass .'">', $postMetasArray) ;
			echo '</span>';
		} else {
			echo implode('', $postMetasArray) ;
		}

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

			}
		</script data-type="ffscript">
	<?php
	}


}