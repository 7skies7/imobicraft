<?php

class ffBlBlogContent extends ffThemeBuilderBlockBasic {
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
		$this->_setInfo( ffThemeBuilderBlock::INFO_ID, 'blog-content');
		$this->_setInfo( ffThemeBuilderBlock::INFO_WRAPPING_ID, 'blog-content');
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

	protected static $wp_kses_allowed_html = null;
	protected static $wp_kses_arr = array();

	protected function _filterByTags( $content, $tags ){

		$tags = trim($tags);
		if(empty($tags)){
			return wp_kses($content, array());
		}

		if( empty(ffBlBlogContent::$wp_kses_allowed_html) ){
			ffBlBlogContent::$wp_kses_allowed_html = wp_kses_allowed_html('post');
		}

		$tags = str_replace('<','-',$tags);
		$tags = str_replace('>','-',$tags);
		$tags = sanitize_title($tags);

		if ( ! isSet( ffBlBlogContent::$wp_kses_arr[$tags] ) ) {
			ffBlBlogContent::$wp_kses_arr[$tags] = array();
			$tags_arr = explode('-',$tags);
			foreach( $tags_arr as $tag ){
				if( isSet( ffBlBlogContent::$wp_kses_allowed_html[$tag] ) ){
					ffBlBlogContent::$wp_kses_arr[$tags][$tag] = ffBlBlogContent::$wp_kses_allowed_html[$tag];
				}
			}
		}

		return wp_kses($content, ffBlBlogContent::$wp_kses_arr[$tags]);
	}


	protected function _injectPostContentSelectValues( $option ) {
		$option
			->addSelectValue( esc_attr( __('Excerpt', 'ark' ) ), 'excerpt')
			->addSelectValue( esc_attr( __('Post Content - Full with Builder', 'ark' ) ), 'content-full')
			->addSelectValue( esc_attr( __('Post Content - Full without Builder', 'ark' ) ), 'content-full-no-builder')
			->addSelectValue( esc_attr( __('Post Content - Before <!-- more --> Tag', 'ark' ) ), 'content-read-more')
			->addSelectValue( esc_attr( __('Post Content - After <!-- more --> Tag', 'ark' ) ), 'content-read-more-after')
			->addSelectValue( esc_attr( __('None', 'ark' ) ), 'none')
		;
	}


	protected function _injectOptions( ffThemeBuilderOptionsExtender $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );
			$s->startHidingBoxParent();

			$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'Choose exactly what type of content you want to print as your Post Content. If <strong>Priority 1</strong> content type does not exist then the content type from <strong>Priority 2</strong> will be printed and so on.');
			$s->addElement( ffOneElement::TYPE_NEW_LINE );

			$opt = $s->addOptionNL(ffOneOption::TYPE_SELECT, 'content-priority-1', '', 'excerpt')
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Post Content - Priority 1 (Highest)', 'ark' ) ) )
			;
			$this->_injectPostContentSelectValues( $opt );

			$s->startHidingBox('content-priority-1', array('none'), true);

				$opt = $s->addOptionNL(ffOneOption::TYPE_SELECT, 'content-priority-2', '', 'content-read-more')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Post Content - Priority 2', 'ark' ) ) )
				;
				$this->_injectPostContentSelectValues( $opt );


				$s->startHidingBox('content-priority-2', array('none'), true);
					$opt = $s->addOptionNL(ffOneOption::TYPE_SELECT, 'content-priority-3', '', 'content-full')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Post Content - Priority 3', 'ark' ) ) )
					;
					$this->_injectPostContentSelectValues( $opt );
				$s->endHidingBox();

			$s->endHidingBox();

			$s->addElement( ffOneElement::TYPE_NEW_LINE );

			$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', '<code>Excerpt</code> prints only the <a href="//www.wpbeginner.com/glossary/excerpt/" target="_blank">Excerpt</a>');
			$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', '<code>Post Content - Before &lt;!-- more --&gt; Tag</code> prints only the content before <a href="//www.wpbeginner.com/beginners-guide/how-to-properly-use-the-more-tag-in-wordpress/" target="_blank">More Tag</a>');
			$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', '<code>Post Content - After &lt;!-- more --&gt; Tag</code> prints only the content after <a href="//www.wpbeginner.com/beginners-guide/how-to-properly-use-the-more-tag-in-wordpress/" target="_blank">More Tag</a>');
			$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', '<code>Post Content - Full</code> prints the whole content of a post, excluding <a href="//www.wpbeginner.com/glossary/excerpt/" target="_blank">Excerpt</a>.');
			$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', '<code>None</code> does not print anything and stops the printing process');

			$s->addElement( ffOneElement::TYPE_NEW_LINE );

			$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'limit-content-length', ark_wp_kses( __('Limit Post Content Length', 'ark' ) ), 0);

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

			$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'content-strip-html-tags', ark_wp_kses( __('Strip HTML tags', 'ark' ) ), 0);

			$s->startHidingBox('content-strip-html-tags', 'checked');
				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'allowed-tags', '', '<a><p>')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Allowed HTML Tags', 'ark' ) ) );
			$s->endHidingBox();

			$s->endHidingBoxParent();
		$s->addElement( ffOneElement::TYPE_TABLE_END );
	}

	protected function  _renderBuilder( $content ){
		$themebuildermanager = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderManager();

		$builderManager = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderManager();
		echo '<script>' . $builderManager->getRenderedJs() . '</script>';
		echo '<style>' . $builderManager->getRenderedCss() .'</style>';

		$final = $themebuildermanager->renderButNotPrint($content);
		echo '<div class="post-content">';
		echo do_shortcode( $final );
		echo '</div>';

		echo '<script>' . $builderManager->getRenderedJs() . '</script>';
		echo '<style>' . $builderManager->getRenderedCss() .'</style>';
	}

	protected function _render( $query ) {
		global $post;



		if( post_password_required() ) {
			echo '<div class="post-content ff-richtext">';
			the_content();
			echo '</div>';
			return;
		}

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

		$enable_builder = false;
		if( ( !empty( $usage ) ) and ( 'used' == $usage ) ){
			$enable_builder = true;
		}

		$defaultValues = array();
		$defaultValues[1] = 'excerpt';
		$defaultValues[2] = 'content-read-more';
		$defaultValues[3] = 'content-full';

		$contentValue = null;

		$content = null;


		for( $i = 1; $i <= 3; $i ++ ) {
			$contentType = $query->getWithoutComparationDefault( 'content-priority-' . $i, $defaultValues[ $i ] );

			if( $contentType == 'none' ) {
				break;
			}

			switch( $contentType ) {
				case 'excerpt':
					$contentValue = $post->post_excerpt;//get_the_excerpt();
					break;

				case 'content-read-more':
					$content = $post->post_content;

					if( !empty( $content ) ) {
						$readMorePosition = strpos($content, '<!--more-->');
						if ($readMorePosition !== false) {
							$contentValue = substr($content, 0, $readMorePosition);
						}
					}
					break;

				case 'content-read-more-after':
					$content = $post->post_content;

					if($enable_builder){
						$this->_renderBuilder($post);
						return;
					}

					if( !empty( $content ) ) {
						$readMorePosition = strpos($content, '<!--more-->');
						if ($readMorePosition !== false) {
							$contentValue = substr($content, $readMorePosition);
						}
					}
					break;

				case 'content-full':
//					$contentValue = $post->post_content;
					$contentValue = get_the_content('');

					if($enable_builder){
						$this->_renderBuilder($contentValue);
						return;
					}

					break;

				case 'content-full-no-builder':
					$builderManager = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderManager();
					echo '<script>' . $builderManager->getRenderedJs() . '</script>';
					echo '<style>' . $builderManager->getRenderedCss() .'</style>';

					$contentValue = get_the_content();
					$themebuildermanager = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderManager();
					$contentValue = $themebuildermanager->renderButNotPrint($contentValue);
					break;
			}

			if( !empty( $contentValue ) ) {
				break;
			}

		}

		if( empty( $contentValue ) ) {
			return null;
		}




		$content = ark_Featured_Area::get_the_content_without_featured_area( $contentValue );

		if( $query->getWithoutComparationDefault('limit-content-length', 0 ) ) {

			$limitType = $query->getWithoutComparationDefault('limit-content-type', 'words');
			$limitSize = $query->getWithoutComparationDefault('limit-size', 20);
			$afterLimitText = $query->getWithoutComparationDefault('after-limit-text', '&hellip;');

			if ($limitType == 'letters') {
				$content = wp_strip_all_tags($content);
				if ( strlen($content) > $limitSize ){
					$content = substr($content, 0, $limitSize);
					$content .= $afterLimitText;
				}
			} else if ($limitType == 'words') {
				$content = wp_strip_all_tags($content);
				$content = wp_trim_words($content, $limitSize, $afterLimitText);
			}
		}

		if( $query->getWithoutComparationDefault('content-strip-html-tags', 0 ) ) {
			$allowedTags = $query->getWithoutComparationDefault('allowed-tags', '<a><p>');
			$content = $this->_filterByTags($content, $allowedTags);
		}

		echo '<div class="post-content ff-richtext">';
		// Updated and escaped content / excerpt
		add_filter('embed_oembed_html', array('ark_Featured_Area', 'wrapEmbeded' ) );
		$content = apply_filters('embed_oembed_html', $content);
		remove_filter('embed_oembed_html', array('ark_Featured_Area', 'wrapEmbeded' ) );


		echo ( $content );

		wp_link_pages();
		echo '</div>';
	}


	protected function _renderContentInfo_JS() {
		?>
		<script data-type="ffscript">
			function ( query, params ) {

			}
		</script data-type="ffscript">
		<?php
	}

/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
}