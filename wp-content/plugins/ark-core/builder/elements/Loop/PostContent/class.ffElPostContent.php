<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/blog_single_post_youtube_video.html
 * */

class ffElPostContent extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'post-content');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Post Content', 'ark' ) ));
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);


		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'loop');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'blog, loop, post, page, content');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);

		$this->_setColor('dark');
	}

	/**
	 * @param ffOneStructure|ffThemeBuilderOptionsExtender $s
	 * @return ffOneStructure|ffThemeBuilderOptionsExtender
	 */
	protected function _getElementGeneralOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_START );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Post Content', 'ark' ) ) );
				$this->_getBlock( ffThemeBlConst::CONTENT )->injectOptions( $s );
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

		global $post;
		$postId = $post->ID;

		if( $this->_getStatusHolder()->isInCustomStack('post-content-id', $postId ) ) {
			return false;
		}

		$this->_getStatusHolder()->addValueToCustomStack('post-content-id', $postId );

		$builderManager = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderManager();

		echo '<div class="post-content ff-post-content-element">';

		$usage = get_post_meta( $post->ID, 'ff_builder_status' );
		if( ! empty($usage) ) {
			if ( ! empty($usage[0])) {
				$usage = $usage[0];
				$usage = json_decode( $usage );
				if ( ! empty($usage->usage)) {
					$usage = $usage->usage;
				}
			}
		}

		if( ! post_password_required() ) {
			if ((!empty($usage)) and ('used' == $usage)) {
				global $post;

				$postContent = $this->_doShortcode($post->post_content);
				$postContent = do_shortcode($postContent);

				remove_filter('the_content', 'wpautop');
				remove_filter('the_content', 'wptexturize');

				$postContent = apply_filters('the_content', $postContent);

				add_filter('the_content', 'wpautop');
				add_filter('the_content', 'wptexturize');

				echo $postContent;
			} else {
				$this->_getBlock(ffThemeBlConst::CONTENT)->render($query);
			}
		}else{
			echo '<div class="post-content ff-richtext">';
			the_content();
			echo '</div>';
		}


		echo '</div>';

		$builderManager->addRenderdCssToStack();
		$builderManager->addRenderedJsToStack();

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {
				query.addPlainText('Post Content');
			}
		</script data-type="ffscript">
	<?php
	}

}