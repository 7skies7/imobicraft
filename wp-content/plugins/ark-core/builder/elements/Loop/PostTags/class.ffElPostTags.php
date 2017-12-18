<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/blog_single_post_youtube_video.html
 * */

class ffElPostTags extends ffElBlog {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'post-tags');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Post Tags', 'ark' ) ));
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'loop');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'blog, post, tags');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);

		$this->_setColor('dark');
	}

	/**
	 * @param ffOneStructure|ffThemeBuilderOptionsExtender $s
	 * @return ffOneStructure|ffThemeBuilderOptionsExtender
	 */
	protected function _getElementGeneralOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_START );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Post Tags', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Text', 'ark')) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Border', 'ark')) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Background', 'ark')) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color-hover', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Text Hover', 'ark')) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color-hover', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Border Hover', 'ark')) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color-hover', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Background Hover', 'ark')) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);
		$s->addElement( ffOneElement::TYPE_TABLE_END );
		return $s;
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( $this->_getStatusHolder()->isElementInStack('loop-post') ){
			// do nothing
		}else if( $this->_getStatusHolder()->isElementInStack('post-wrapper') ){
			// do nothing
		}else if( have_posts() ){
			the_post();
		}

		echo '<section class="post-tags">';
			the_tags('<ul class="list-inline blog-sidebar-tags"><li>', '</li><li>', '</li></ul>');
		echo '</section>';

		$this->_renderCSSRule( 'color', $query->getColor('color'), ' ul li a');
		$this->_renderCSSRule( 'color', $query->getColor('color-hover'), ' ul li a:hover');
		$this->_renderCSSRule( 'border-color', $query->getColor('border-color'), ' ul li a');
		$this->_renderCSSRule( 'border-color', $query->getColor('border-color-hover'), ' ul li a:hover');
		$this->_renderCSSRule( 'background-color', $query->getColor('bg-color'), ' ul li a');
		$this->_renderCSSRule( 'background-color', $query->getColor('bg-color-hover'), ' ul li a:hover');

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {
				query.addPlainText('Post Tags');
			}
		</script data-type="ffscript">
	<?php
	}

}