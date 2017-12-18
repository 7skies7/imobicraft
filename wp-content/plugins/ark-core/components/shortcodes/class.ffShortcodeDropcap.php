<?php

class ffShortcodeDropcap extends ffShortcodeObjectBasic {

	protected function _addNames() {
		$this->_addShortcodeName('dropcap');
	}

	protected function _setRecursive() {
		$this->_setIsRecursive( false );
	}

	protected function _printShortcode($atts = array(), $content = '', $currentShortcodeName = '') {
		$type = isset( $atts['type'] ) ? $atts['type'] : 1;
		switch( $type ) {
			case 1:
				echo '<span class="dropcap-dark">'. do_shortcode( $content ) . '</span>';
				break;
			case 2:
				echo '<span class="dropcap-dark-bg">'. do_shortcode( $content ) . '</span>';
				break;
			case 3:
				echo '<span class="dropcap-dark-bg radius-6">'. do_shortcode( $content ) . '</span>';
				break;
			case 4:
				echo '<span class="dropcap-dark-bordered radius-circle">'. do_shortcode( $content ) . '</span>';
				break;
		}

	}

}