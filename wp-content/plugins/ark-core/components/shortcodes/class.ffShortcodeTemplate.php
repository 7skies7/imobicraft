<?php

class ffShortcodeTemplate extends ffShortcodeObjectBasic {

	protected function _addNames() {
		$this->_addShortcodeName('ff_template');
	}

	protected function _setRecursive() {
		$this->_setIsRecursive( false );
	}

	protected function _printShortcode($atts = array(), $content = '', $currentShortcodeName = '') {
		if( !isset($atts['id']) || $atts['id'] == null ) {
			return null;
		}
		$id = $atts['id'];
		$post = get_post( $id );

		if( isset( $post->post_content ) ) {
			echo do_shortcode( $post->post_content );
		}
	}

}