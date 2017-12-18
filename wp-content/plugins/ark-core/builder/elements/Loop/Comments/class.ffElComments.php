<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/blog_single_post_youtube_video.html
 * */

class ffElComments extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'post-comments');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Comment Form and Comments', 'ark' ) ));
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'loop');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'comments, form');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);

		$this->_setColor('dark');
	}

	protected function _injectColorsCommentFields($s){
		$s->addElement( ffOneElement::TYPE_NEW_LINE);

		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '' )
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Comment Field - Background', 'ark' ) ) );
		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-focus-color', '', '' )
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Comment Field - Background - Focus', 'ark' ) ) );

		$s->addElement( ffOneElement::TYPE_NEW_LINE);

		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '', '' )
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Comment Field - Border', 'ark' ) ) );
		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-focus-color', '', '' )
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Comment Field - Border - Focus', 'ark' ) ) );

		$s->addElement( ffOneElement::TYPE_NEW_LINE);

		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'placeholder-color', '', '' )
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Comment Field - Placeholder', 'ark' ) ) );
		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'placeholder-focus-color', '', '')
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Comment Field - Placeholder - Focus', 'ark' ) ) );

		$s->addElement( ffOneElement::TYPE_NEW_LINE);

		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-color', '', '' )
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Comment Field - Text', 'ark' ) ) );
		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-focus-color', '', '')
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Comment Field - Text - Focus', 'ark' ) ) );
	}

	protected function _injectColorsCommentButton($s){
		$s->addElement( ffOneElement::TYPE_NEW_LINE);

		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '' )
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Comment Button - Background', 'ark' ) ) );
		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-hover-color', '', '' )
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Comment Button - Background - Hover', 'ark' ) ) );

		$s->addElement( ffOneElement::TYPE_NEW_LINE);

		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '', '' )
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Comment Button - Border', 'ark' ) ) );
		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-hover-color', '', '' )
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Comment Button - Border - Hover', 'ark' ) ) );

		$s->addElement( ffOneElement::TYPE_NEW_LINE);

		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-color', '', '' )
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Comment Button - Text', 'ark' ) ) );
		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-hover-color', '', '')
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Comment Button - Text - Hover', 'ark' ) ) );
	}

	protected function _injectColorsCommentPagination($s){
		$s->addElement( ffOneElement::TYPE_NEW_LINE);

		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '' )
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Pagination - Background', 'ark' ) ) );
		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-hover-color', '', '' )
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Pagination - Background - Hover', 'ark' ) ) );

		$s->addElement( ffOneElement::TYPE_NEW_LINE);

		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '', '' )
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Pagination - Border', 'ark' ) ) );
		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-hover-color', '', '' )
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Pagination - Border - Hover', 'ark' ) ) );

		$s->addElement( ffOneElement::TYPE_NEW_LINE);

		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-color', '', '' )
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Pagination - Text', 'ark' ) ) );
		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-hover-color', '', '')
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Pagination - Text - Hover', 'ark' ) ) );
	}

	/**
	 * @param ffOneStructure|ffThemeBuilderOptionsExtender $s
	 * @return ffOneStructure|ffThemeBuilderOptionsExtender
	 */
	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Comments Settings', 'ark' ) ) );

				$this->_getBlock(ffThemeBlConst::COMMENTS)->injectOptions($s);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'content-bg-color', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Content background', 'ark' ) ) );
				$s->startSection('comment-fields-colors');
					$this->_injectColorsCommentFields($s);
				$s->endSection();
				$s->startSection('comment-button-colors');
					$this->_injectColorsCommentButton($s);
				$s->endSection();
				$s->startSection('comment-pagination-colors');
					$this->_injectColorsCommentPagination($s);
				$s->endSection();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		$s->addElement( ffOneElement::TYPE_TABLE_END );

		return $s;

	}


	/**
	 * @param $query ffOptionsQuery
	 */
	protected function _renderColorsCommentField( $id, $query ) {
		if( empty( $query ) ){
			return;
		}

		$bg_color_selectors = array(
			$id.'' => 'bg-color',
			$id.':focus' => 'bg-focus-color',
		);

		foreach( $bg_color_selectors as $selector => $c ){
			$color = $query->getColorWithoutComparationDefault( $c , '');
			if( $color ) {
				$this->_getAssetsRenderer()->createCssRule()
					->addSelector($selector, false)
					->addParamsString('background-color:' . $color . ';');
			}
		}

		$border_color_selectors = array(
			$id.'' => 'border-color',
			$id.':focus' => 'border-focus-color',
		);

		foreach( $border_color_selectors as $selector => $c ){
			$color = $query->getColorWithoutComparationDefault( $c, '' );
			if( $color ) {
				$this->_getAssetsRenderer()->createCssRule()
					->addSelector($selector, false)
					->addParamsString('border-color:' . $color . ';');
			}
		}

		$placeholder_color_selectors = array(
			$id.'::-moz-placeholder' => 'placeholder-color',
			$id.':-ms-input-placeholder' => 'placeholder-color',
			$id.'::-webkit-input-placeholder' => 'placeholder-color',
			$id.':focus::-moz-placeholder' => 'placeholder-focus-color',
			$id.':focus:-ms-input-placeholder' => 'placeholder-focus-color',
			$id.':focus::-webkit-input-placeholder' => 'placeholder-focus-color',
		);

		foreach( $placeholder_color_selectors as $selector => $c ){
			$color = $query->getColorWithoutComparationDefault( $c, '' );
			if( $color ) {
				$this->_getAssetsRenderer()->createCssRule()
					->addSelector($selector, false)
					->addParamsString('color:' . $color . ';');
			}
		}

		$text_color_selectors = array(
			$id.'' => 'text-color',
			$id.':focus' => 'text-focus-color',
		);

		foreach( $text_color_selectors as $selector => $c ){
			$color = $query->getColorWithoutComparationDefault( $c, '' );
			if( $color ) {
				$this->_getAssetsRenderer()->createCssRule()
					->addSelector($selector, false)
					->addParamsString('color:' . $color . ';');
			}
		}
	}

	/**
	 * @param $query ffOptionsQuery
	 */
	protected function _renderColorsCommentSubmit( $id, $query ) {
		if( empty( $query ) ){
			return;
		}

		$bg_color_selectors = array(
			$id.'' => 'bg-color',
			$id.':hover' => 'bg-hover-color',
		);

		foreach( $bg_color_selectors as $selector => $c ){
			$color = $query->getColorWithoutComparationDefault( $c, '' );
			if( $color ) {
				$this->_getAssetsRenderer()->createCssRule()
					->addSelector($selector, false)
					->addParamsString('background-color:' . $color . ';');
			}
		}

		$border_color_selectors = array(
			$id.'' => 'border-color',
			$id.':hover' => 'border-hover-color',
		);

		foreach( $border_color_selectors as $selector => $c ){
			$color = $query->getColorWithoutComparationDefault( $c, '' );
			if( $color ) {
				$this->_getAssetsRenderer()->createCssRule()
					->addSelector($selector, false)
					->addParamsString('border-color:' . $color . ';');
			}
		}

		$text_color_selectors = array(
			$id.'' => 'text-color',
			$id.':hover' => 'text-hover-color',
		);

		foreach( $text_color_selectors as $selector => $c ){
			$color = $query->getColorWithoutComparationDefault( $c, '' );
			if( $color ) {
				$this->_getAssetsRenderer()->createCssRule()
					->addSelector($selector, false)
					->addParamsString('color:' . $color . ';');
			}
		}
	}

	/**
	 * @param $query ffOptionsQuery
	 */
	protected function _renderColorsCommentPagination( $query ) {
		if( empty( $query ) ){
			return;
		}

		$bg_color_selectors = array(
			'.ark-comment-pagination li a' => 'bg-color',
			'.ark-comment-pagination li.active a' => 'bg-hover-color',
			'.ark-comment-pagination li a:hover' => 'bg-hover-color',
		);

		foreach( $bg_color_selectors as $selector => $c ){
			$color = $query->getColorWithoutComparationDefault( $c, '' );
			if( $color ) {
				$this->_getAssetsRenderer()->createCssRule()
					->addSelector($selector, false)
					->addParamsString('background-color:' . $color . ';');
			}
		}

		$border_color_selectors = array(
			'.ark-comment-pagination li a' => 'border-color',
			'.ark-comment-pagination li.active a' => 'border-hover-color',
			'.ark-comment-pagination li a:hover' => 'border-hover-color',
		);

		foreach( $border_color_selectors as $selector => $c ){
			$color = $query->getColorWithoutComparationDefault( $c, '' );
			if( $color ) {
				$this->_getAssetsRenderer()->createCssRule()
					->addSelector($selector, false)
					->addParamsString('border-color:' . $color . ';');
			}
		}

		$text_color_selectors = array(
			'.ark-comment-pagination li a' => 'text-color',
			'.ark-comment-pagination li.active a' => 'text-hover-color',
			'.ark-comment-pagination li a:hover' => 'text-hover-color',
		);

		foreach( $text_color_selectors as $selector => $c ){
			$color = $query->getColorWithoutComparationDefault( $c, '' );
			if( $color ) {
				$this->_getAssetsRenderer()->createCssRule()
					->addSelector($selector, false)
					->addParamsString('color:' . $color . ';');
			}
		}
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		if( $this->_getStatusHolder()->isElementInStack('loop-post') ){
			// do nothing
		}else if( $this->_getStatusHolder()->isElementInStack('post-wrapper') ){
			// do nothing
		}else if( have_posts() ){
			the_post();
		}

		echo '<section class="comments">';
		$this->_getBlock( ffThemeBlConst::COMMENTS )->render( $query );
		echo '</section>';

		$color = $query->getWithoutComparation( 'content-bg-color' );
		if( $color ) {
			$this->_getAssetsRenderer()->createCssRule()
				->addParamsString('background-color:' . $color . ';');
		}




		$this->_renderColorsCommentField('.form-control', $query->get('comment-fields-colors') );
		$this->_renderColorsCommentSubmit('#submit', $query->get('comment-button-colors') );
		$this->_renderColorsCommentPagination($query->get('comment-pagination-colors') );
	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {
				blocks.render('comments', query);
			}
		</script data-type="ffscript">
	<?php
	}

}