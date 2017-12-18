<?php

class ffElLoopWrapper extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'loop-wrapper');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, 'Loop');
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'loop');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'blog, loop, post, page, single, wrapper, custom post type');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);

		$this->_addDropzoneWhitelistedElement('loop-row');

		$this->_addTab('Pagination', array($this, '_wpPagination'));

//		$this->_addParentWhitelistedElement('canvas');
//		$this->_addParentWhitelistedElement('if');
//		$this->_addParentWhitelistedElement('shortcode-container');
	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _getElementGeneralOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_START );


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Info', 'ark' ) ));
				$s->addElement(ffOneElement::TYPE_HTML, 'TYPE_HTML', '<p class="description">'.
					ark_wp_kses( __('Please watch the <a href="https://www.youtube.com/watch?v=Pjjzw_YbIYI" target="_blank">video tutorial<a> for the Loop element first.', 'ark') )
					.'</p>');
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
			$s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'HTML Tag');
				$s->addOption(ffOneOption::TYPE_TEXT,'html-tag','','div');
			$s->addElement(ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Custom Loop Query');

				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'custom-loop-query-enable', 'Create Custom Loop Query, instead of using default wordpress one', 1);
				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'If enabled, default WP query will be overriden with your custom settings. Should be disabled on "Search" and "Archives"');

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Featured Image');

				$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'has-featured-image', 'Show only Posts that have Featured Image', 0);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'WP_Query Arguments');
				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'The PHP input below allows you to modify the <code>$args</code> variable. You can write any PHP code there.');
				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'Example code: <code>$args["posts_per_page"] = 5;</code>');
				$arguments = [];
				$arguments[] = '$args[\'post_type\']=\'post\';';
				$arguments[] = '$args[\'posts_per_page\']=5;';
				$arguments = implode("\n", $arguments );
				$s->addOption(ffOneOption::TYPE_TEXTAREA_STRICT,'php-input','', $arguments)
					->addParam( ffOneOption::PARAM_CODE_EDITOR, 'php')
				;
			$s->addElement(ffOneElement::TYPE_TABLE_DATA_END);

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



		$s->addElement(ffOneElement::TYPE_TABLE_END);

	}

	protected function _wpPagination( $s ) {
		$this->_getBlock( ffThemeBlConst::PAGINATION )->injectOptions( $s );
	}




	private function _getMatchColBreakpoints() {
		$bp = array();
		$bp['xs'] = '';
		$bp['sm'] = '-sm';
		$bp['md'] = '-md';
		$bp['lg'] = '-lg';

		return $bp;
	}





	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		$statusHolder = $this->_getStatusHolder();

		$args = [];

		$mustHaveFeaturedImage = $query->getWithoutComparationDefault('has-featured-image', 0);

		if( $mustHaveFeaturedImage == 1 ) {
			$args['meta_key'] = '_thumbnail_id';

		}

		$argsPhp = $query->getWithoutComparationDefault('php-input', '');
		if( !empty( $argsPhp ) ) {
			eval( $argsPhp );
		}

		if( $query->getWithoutComparationDefault('reacts-to-pagination', 1) ) {
			global $wp_query;

			if( is_front_page() ) {
				$args['paged'] = $wp_query->get('page');
			} else {
				$args['paged'] = $wp_query->get('paged');
			}
		}

		if( $query->getWithoutComparationDefault('custom-loop-query-enable', 1) ) {
			$wpQuery = new WP_Query( $args );
		} else {
			global $wp_query;
			$wpQuery = $wp_query;
		}



		$wpQueryHelper = ffContainer()->getWPQueryHelper();
		$wpQueryHelper->setWpQuery( $wpQuery );
		$wpQueryHelper->setOffset( $query->getWithoutComparationDefault('offset', 0) );
		$wpQueryHelper->setNumberOfPostsToPrint( $query->getWithoutComparationDefault('number-of-posts-to-print', -1) );
		$this->_getStatusHolder()->addValueToCustomStack('wp_query_helper', $wpQueryHelper );



		echo '<div class="ark-loop-wrapper">';
			while( $wpQueryHelper->havePostsForPrint() ) {
				echo $this->_doShortcode( $content );
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

		wp_reset_postdata();


		echo '</div>';
	}


	protected function _renderContentInfo_JS() {
		?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element ) {

			}
		</script data-type="ffscript">
		<?php
	}

}