<?php

class ffThemeBuilderBlock_Loop extends ffThemeBuilderBlockBasic {
	const PARAM_TAXONOMY_TYPE = 'taxonomy_type';
	const PARAM_POST_TYPE = 'post_type';
	const PARAM_MUST_HAVE_FEATURED_IMAGE = 'must_have_featured_image';
	const PARAM_DEBUG_DUMP_CONTENT = 'debug_dump_content';
	const PARAM_RETURN_ALL_POSTS = 'return_all_posts';

/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
	private $_postCounter = 0;

	private $_offset = 0;

	private $_numberOfPostsToPrint = -1;

	private $_shouldReset = true;

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
	protected function _init() {
		$this->_setInfo( ffThemeBuilderBlock::INFO_ID, 'loop');
		$this->_setInfo( ffThemeBuilderBlock::INFO_WRAPPING_ID, 'loop');
		$this->_setInfo( ffThemeBuilderBlock::INFO_WRAP_AUTOMATICALLY, true);
		$this->_setInfo( ffThemeBuilderBlock::INFO_IS_REFERENCE_SECTION, true);
		$this->_setInfo( ffThemeBuilderBlock::INFO_SAVE_ONLY_DIFFERENCE, true);
	}
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
	protected function _injectOptions( ffThemeBuilderOptionsExtender $s ) {

		$taxonomyType = $this->getParam( ffThemeBuilderBlock_Loop::PARAM_TAXONOMY_TYPE, 'category');

		$s->startHidingBoxParent();
		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Custom Loop Query');

				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'custom-loop-query-enable', 'Create Custom Loop Query, instead of using default wordpress one', 1);
				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'If enabled, default WP query will be overriden with your custom settings. Should be disabled on "Search" and "Archives"');

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		$s->addElement( ffOneElement::TYPE_TABLE_END );

		$s->startHidingBox('custom-loop-query-enable', 'checked');
		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Loop Settings');

				$s->addOptionNL(ffOneOption::TYPE_TEXT, 'posts_per_page', '', 10)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, __('Posts Per Page') );

				$s->addOptionNL(ffOneOption::TYPE_SELECT, 'order', '', '')
					->addSelectValue('', '')
					->addSelectValue('Asc (1,2,3)', 'asc')
					->addSelectValue('Desc (3,2,1)', 'desc')
				->addParam( ffOneOption::PARAM_TITLE_AFTER, __('Order') );

				$s->addOptionNL(ffOneOption::TYPE_SELECT, 'order-by', '', '')
					->addSelectValue('', '')
					->addSelectValue('ID', 'ID')
					->addSelectValue('Author', 'author')
					->addSelectValue('Title', 'title')
					->addSelectValue('Name', 'name')
					->addSelectValue('Type', 'type')
					->addSelectValue('Date', 'date')
					->addSelectValue('Modified', 'modified')
					->addSelectValue('Parent', 'parent')
					->addSelectValue('Rand', 'rand')
					->addSelectValue('Comment_count', 'comment_count')
				->addParam( ffOneOption::PARAM_TITLE_AFTER, __('Order By') );

				$s->addOptionNL(ffOneOption::TYPE_TAXONOMY, 'taxonomies', '', '')
					->addSelectValue('All', '')
					->addParam('tax_type', $taxonomyType)
					->addParam('load-dynamic', true)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, __('Categories') )
				;

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$mustHaveFeaturedImage = $this->getParam( ffThemeBuilderBlock_Loop::PARAM_MUST_HAVE_FEATURED_IMAGE, 0 );
				$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'has-featured-image', 'Show only Posts that have Featured Image', $mustHaveFeaturedImage);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Pagination');

				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'reacts-to-pagination', 'Change Loop output based on current pagination', 1);
				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'If enabled, the output of the Loop will change depending on current pagination. If disabled, the Loop will ignore any pagination and always show the same output.');

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Offsetting');

				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'NOTE: Offseting will be applied after the Loop has been generated based on the Loop Settings from above.');
				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL(ffOneOption::TYPE_TEXT, 'offset', '', 0)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, __('Offset') );
				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'Set how many Posts you want to skip from the beginning of the Loop output.');
				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'NOTE: Set to <code>0</code> if you don\'t want to skip any Posts.');

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL(ffOneOption::TYPE_TEXT, 'number-of-posts-to-print', '', -1)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, __('Number of Posts to print') );
				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'Set how many Posts you want to print after the Offset. Any other remaining Posts from the Loop will be skipped.');
				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'NOTE: Set to <code>-1</code> if you want to show all of the remaining Posts in the Loop.');


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Advanced Loop Settings');

				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'The PHP input below allows you to modify the <code>$args</code> variable. You can write any PHP code there.');
				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'Example code: <code>$args["posts_per_page"] = 5;</code>');

				$s->addElement(ffOneElement::TYPE_NEW_LINE);
				$s->addOptionNL(ffOneOption::TYPE_TEXTAREA_STRICT, 'php-input', 'PHP Input:', '')
					->addParam( ffOneOption::PARAM_CODE_EDITOR, 'php')
				;
				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'var-dump-args', 'var_dump the <code>$args</code> variable (for debug purposes)', 0);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		$s->addElement( ffOneElement::TYPE_TABLE_END );
		$s->endHidingBox();
		$s->endHidingBoxParent();


	}

	protected  function _reset() {
		$this->_postCounter = 0;
	}

	public function canBePostPrinted() {
		$this->_postCounter++;



		if( $this->_offset >= $this->_postCounter ) {
			return false;
		}
//		var_dump( $this->_postCounter, $this->_offset );

		if( $this->_numberOfPostsToPrint <= 0 ) {
			return true;
		}

		if( ($this->_offset + $this->_numberOfPostsToPrint) < $this->_postCounter )  {
			return false;
		}

		return true;
	}


	protected function _render( $query ) {


		if( !$query->getWithoutComparationDefault('custom-loop-query-enable', 1) ) {
			global $wp_query;
			$this->_shouldReset = false;
			return $wp_query;
		}
		$this->_shouldReset = true;
//		ffStopWatch::addVariableDump( $query->getWithoutComparationDefault('custom-loop-query-enable', 1) );
		$taxonomyType = $this->getParam( ffThemeBuilderBlock_Loop::PARAM_TAXONOMY_TYPE, 'category');
		$postType = $this->getParam( ffThemeBuilderBlock_Loop::PARAM_POST_TYPE, 'post');

		$args = array();
		$args['post_type'] = $postType;

		$args['posts_per_page'] = $query->getWithoutComparationDefault('posts_per_page', 10);


		$order = $query->getWithoutComparationDefault('order', '');
		$orderBy = $query->getWithoutComparationDefault('order-by', '');
		$mustHaveFeaturedImage = $query->getWithoutComparationDefault('has-featured-image', $this->getParam( ffThemeBuilderBlock_Loop::PARAM_MUST_HAVE_FEATURED_IMAGE, 0 ));

		if( !empty( $order ) ) {
			$args['order'] = $order;
		}

		if( !empty( $orderBy ) ) {
			$args['orderby'] = $orderBy;
		}

		if( $mustHaveFeaturedImage == 1 ) {
			$args['meta_key'] = '_thumbnail_id';

		}
		//has-featured-image



		$taxonomies = $query->getTaxonomyWithoutComparation('taxonomies');


		if( !empty( $taxonomies ) ) {

			$terms = array();

			foreach( $taxonomies as $oneTax ) {
				$terms[] = $oneTax->id;
			}

			$args['tax_query'] = array(
				array(
					'taxonomy' => $taxonomyType,
					'field' => 'term_id',
					'terms' => $terms
				)
			);
		}


		$argsPhp = $query->getWithoutComparationDefault('php-input', '');
		if( !empty( $argsPhp ) ) {
			eval( $argsPhp );
		}

		if( $query->getColorWithoutComparationDefault('var-dump-args', 0) ) {
			ob_start();
			echo '<div>';
			var_dump( $args );
			echo '</div>';
			$dump = ob_get_contents();
			ob_end_clean();

			$this->setParam( ffThemeBuilderBlock_Loop::PARAM_DEBUG_DUMP_CONTENT, $dump);
//			die();
		}


		if( $query->getWithoutComparationDefault('reacts-to-pagination', 1) ) {
			global $wp_query;

			if( is_front_page() ) {
				$args['paged'] = $wp_query->get('page');
			} else {
				$args['paged'] = $wp_query->get('paged');
			}
		}

		$this->_offset = $query->getWithoutComparationDefault('offset', 0);
		$this->_numberOfPostsToPrint = $query->getWithoutComparationDefault('number-of-posts-to-print', -1);


		if( $this->getParam( ffThemeBuilderBlock_Loop::PARAM_RETURN_ALL_POSTS, false ) ) {
			unset( $args['paged']);
			$args['posts_per_page'] = -1;
		}


		return new WP_Query( $args );
	}

	public function resetOnTheEnd() {
		if( $this->_shouldReset ) {
			wp_reset_postdata();
		}
	}


/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
}