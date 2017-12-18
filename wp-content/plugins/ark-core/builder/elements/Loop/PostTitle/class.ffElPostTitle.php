<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/blog_single_post_youtube_video.html
 * */

class ffElPostTitle extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'post-title');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Post Title', 'ark' ) ));
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'loop');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'blog, loop, post, page, single, title');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);

		$this->_setColor('dark');
	}

	/**
	 * @param ffOneStructure|ffThemeBuilderOptionsExtender $s
	 * @return ffOneStructure|ffThemeBuilderOptionsExtender
	 */
	protected function _getElementGeneralOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_START );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Post Title', 'ark' ) ) );

				$s->addOptionNL(ffOneOption::TYPE_SELECT, 'tag', '', 'h2')
					->addSelectValue('h1', 'h1')
					->addSelectValue('h2', 'h2')
					->addSelectValue('h3', 'h3')
					->addSelectValue('h4', 'h4')
					->addSelectValue('div', 'div')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('HTML tag', 'ark' ) ) );

				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'is-link', 'Post Title links to Single Post', 1);
				$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'limit-content-length', ark_wp_kses( __('Limit Post Title Length', 'ark' ) ), 0);

				$s->startHidingBox('limit-content-length', 'checked');
					$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'NOTE: Limiting strips all HTML tags');

					$s->addOptionNL(ffOneOption::TYPE_SELECT, 'limit-content-type', '', 'words')
						->addSelectValue( esc_attr( __('By number of words', 'ark' ) ), 'words')
						->addSelectValue( esc_attr( __('By number of letters', 'ark' ) ), 'letters')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Limit Type', 'ark' ) ) )
					;

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'limit-size', '', 20)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Maximum number of words/letters', 'ark' ) ) )
					;

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'after-limit-text', '', '&hellip;')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text after the limitation, for example: <code>...</code>', 'ark' ) ) )
					;
					$s->addElement( ffOneElement::TYPE_NEW_LINE );
				$s->endHidingBox();

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

		$tag = $query->get('tag');

		$titleString = get_the_title();

		if( $query->get('limit-content-length' ) ) {

			$limitType = $query->get('limit-content-type' );
			$limitSize = $query->get('limit-size');
			$afterLimitText = $query->get('after-limit-text');

			if ($limitType == 'letters') {
				$titleString = wp_strip_all_tags($titleString);
				if ( strlen($titleString) > $limitSize ){
					$titleString = substr($titleString, 0, $limitSize);
					$titleString .= $afterLimitText;
				}
			} else if ($limitType == 'words') {
				$titleString = wp_strip_all_tags($titleString);
				$titleString = wp_trim_words($titleString, $limitSize, $afterLimitText);
			}
		}

		if( $query->get('is-link') ) {
			$titleString = '<a href="'. esc_url( get_permalink() ) .'">' . $titleString . '</a>';
		}

		echo '<'.$tag.' class="blog-grid-title-lg">';
		echo ark_wp_kses( $titleString );
		echo '</'.$tag.'>';
	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {
				query.addPlainText('Post Title');
			}
		</script data-type="ffscript">
	<?php
	}

}