<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/blog_single_post_youtube_video.html
 * */

class ffElFeaturedImage extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'featured-image');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Featured Image', 'ark' ) ));
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'loop');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'featured image');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);

		$this->_setColor('dark');
	}

	/**
	 * @param ffOneStructure|ffThemeBuilderOptionsExtender $s
	 * @return ffOneStructure|ffThemeBuilderOptionsExtender
	 */
	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Featured Image', 'ark' ) ) );
				$this->_getBlock( ffThemeBlConst::FEATUREDIMG )->injectOptions( $s );
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

		$postID = get_the_ID();

		echo '<section class="featured-area">';
		$this->_getBlock( ffThemeBlConst::FEATUREDIMG )
			->setParam('post-id', $postID)
			->imgIsResponsive()
			->render( $query );
		echo '</section>';
	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {
				query.addPlainText('Featured Image');
			}
		</script data-type="ffscript">
	<?php
	}

}