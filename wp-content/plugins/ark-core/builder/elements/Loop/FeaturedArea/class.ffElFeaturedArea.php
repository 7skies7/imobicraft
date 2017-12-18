<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/blog_single_post_youtube_video.html
 * */

class ffElFeaturedArea extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'featured-area');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Featured Area', 'ark' ) ));
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'loop');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'featured area');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);

		$this->_setColor('dark');
	}

	/**
	 * @param ffOneStructure|ffThemeBuilderOptionsExtender $s
	 * @return ffOneStructure|ffThemeBuilderOptionsExtender
	 */
	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Featured Area', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('NOTE: The settings below are only for the <strong>Featured Image</strong> case', 'ark' ) ) );
				$s->addElement(ffOneElement::TYPE_NEW_LINE);
				$s->addElement(ffOneElement::TYPE_NEW_LINE);
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
		if( 'image' == get_post_format( $postID ) || !get_post_format( $postID ) ){
			$this->_getBlock( ffThemeBlConst::FEATUREDIMG )
				->setParam('post-id', $postID)
				->imgIsResponsive()
				->render( $query );
		} else {
			if( 'custom' == $query->getWithoutComparationDefault('featured-img img-size', 'default') ) {
				$width = $query->get('featured-img width');
				$height = $query->get('featured-img height');
				ark_Featured_Area::setSizes(1, $width, $height);
			}
			ark_Featured_Area::render();
		}
		echo '</section>';
	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {
				query.addPlainText('Featured Area');
			}
		</script data-type="ffscript">
	<?php
	}

}