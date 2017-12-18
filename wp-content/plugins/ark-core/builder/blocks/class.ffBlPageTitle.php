<?php

class ffBlPageTitle extends ffThemeBuilderBlockBasic {
	/**********************************************************************************************************************/
	/* OBJECTS
	/**********************************************************************************************************************/

	/**********************************************************************************************************************/
	/* PRIVATE VARIABLES
	/**********************************************************************************************************************/

	/**********************************************************************************************************************/
	/* CONSTRUCT
	/**********************************************************************************************************************/
	protected function _init() {
		$this->_setInfo( ffThemeBuilderBlock::INFO_ID, 'pagetitle');
		$this->_setInfo( ffThemeBuilderBlock::INFO_WRAPPING_ID, 'pagetitle');
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

	protected function _render( $query ) {
		if( is_404() ){
			$query->printText('title-404');
		}else if( is_page() ){
			the_title();
		}else if( is_single() ){
			the_title();
		}else if( is_category() ){
			printf( $query->get('title-category'), single_cat_title('', false) );
		}else if( is_tag() ){
			printf( $query->get('title-tag'), single_cat_title('', false) );
		}else if( is_tax() ){
			echo single_term_title('', false);
		}else if( is_author() ){
			if( ! in_the_loop() ){
				the_post();
				rewind_posts();
			}
			printf( $query->get('title-author'), get_the_author() );
		}else if( is_search() ){
			printf( $query->get('title-search'), get_search_query() );
		}else if( is_home() ){
			echo ark_wp_kses( $query->get('title-posts-page') );
		}else if(is_date()){
			if( ! in_the_loop() ){
				the_post();
				rewind_posts();
			}
			if( is_day() ){
				printf( $query->get('title-day'), get_the_time( $query->get('title-day-format') ) );
			}else if( is_month() ){
				printf( $query->get('title-month'), get_the_time( $query->get('title-month-format') ) );
			}else if( is_year() ){
				printf( $query->get('title-year'), get_the_time( $query->get('title-year-format') ) );
			}
		} else if( function_exists('is_shop') ){
			if ( is_shop() ){
				woocommerce_page_title();
			}
		}else if( is_post_type_archive() ) {
			post_type_archive_title();
		}else{
			wp_title('');
		}
	}

	protected function _injectOptions( ffThemeBuilderOptionsExtender $s ) {

		$s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Title Translations', 'ark' ) ) );
			$s->addOption( ffOneOption::TYPE_TEXT, 'title-front-page', '', get_bloginfo('name') )
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Front Page', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_NEW_LINE );

			$s->addOption( ffOneOption::TYPE_TEXT, 'title-posts-page', '', 'Blog' )
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Posts Page', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_NEW_LINE );

			$s->addOption( ffOneOption::TYPE_TEXT, 'title-404', '', '404 Not Found' )
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('404', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_NEW_LINE );

			$s->addOption( ffOneOption::TYPE_TEXT, 'title-category', '', '%s' )
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Category', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_NEW_LINE );

			$s->addOption( ffOneOption::TYPE_TEXT, 'title-tag', '', '%s' )
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Tag', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_NEW_LINE );

			$s->addOption( ffOneOption::TYPE_TEXT, 'title-author', '', '%s' )
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Author', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_NEW_LINE );

			$s->addOption( ffOneOption::TYPE_TEXT, 'title-search', '', '%s' )
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Search', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_NEW_LINE );

			$s->addOption( ffOneOption::TYPE_TEXT, 'title-day', '', '%s' )
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Day', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_NEW_LINE );
			$s->addOption( ffOneOption::TYPE_TEXT, 'title-day-format', '', 'F j, Y' )
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Day Format', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_NEW_LINE );

			$s->addOption( ffOneOption::TYPE_TEXT, 'title-month','' , '%s' )
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Month', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_NEW_LINE );
			$s->addOption( ffOneOption::TYPE_TEXT, 'title-month-format', '', 'F Y' )
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Month Format', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_NEW_LINE );

			$s->addOption( ffOneOption::TYPE_TEXT, 'title-year', '', '%s' )
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Year', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_NEW_LINE );
			$s->addOption( ffOneOption::TYPE_TEXT, 'title-year-format', '', 'Y' )
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Year Format', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('Available date formats: <a href="//php.net/manual/en/function.date.php" target="_blank">Date PHP function manual</a>.', 'ark' ) ));
		$s->addElement(ffOneElement::TYPE_TABLE_DATA_END);
	}

	protected function _renderContentInfo_JS() {
		?>
		<script data-type="ffscript">
			function ( query, params ) {
				var toReturn = '';

				return toReturn;
			}
		</script data-type="ffscript">
		<?php
	}

	/**********************************************************************************************************************/
	/* PRIVATE GETTERS & SETTERS
	/**********************************************************************************************************************/
}