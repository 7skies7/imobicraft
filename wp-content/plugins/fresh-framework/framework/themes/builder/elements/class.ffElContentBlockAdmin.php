<?php

/**
 * Class ffElContentBlock
 */
class ffElContentBlockAdmin extends ffThemeBuilderElementBasic {
	protected function _initData() {

		$this->_setData( ffThemeBuilderElement::DATA_ID, 'content-block-admin');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, 'Content Block Admin');

		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, false);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'basic');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'content, reference, block, admin, ff');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);

		$this->_setData( ffThemeBuilderElement::DATA_HAS_SYSTEM_TABS, false );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_WRAPPER, false );
	}

	public function getPreviewImageUrl() {
		return ffContainer()->getWPLayer()->getFrameworkUrl() . '/framework/themes/builder/elements/content-block-admin.jpg';
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'Content Block' );

				$description = 'Content block allows you to insert pre-defined content directly into your template. It can be created in your WP Admin as a "Content Block" post type.';
				$s->addElement(ffOneElement::TYPE_HTML,'', '<div class="ff-content-block-area">');
					$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', $description );

					$s->addOption(ffOneOption::TYPE_POST_SELECTOR,'content-block','Content Block','')
						->addParam('post_type', 'ff-content-block-a')
						->addParam('load-dynamic', true)
						->addSelectValue('None', 'none')
					;

				$s->addElement(ffOneElement::TYPE_HTML,'', '<a class="ff-post-edit-link" target="_blank" href="" data-edit-url="' .esc_attr(admin_url('post.php?post=!!!POST_ID!!!&action=edit')) . '">Edit content block in another window: </a>' );
				$s->addElement(ffOneElement::TYPE_HTML,'', '</div>');

			$s->addElement(ffOneElement::TYPE_TABLE_DATA_END);

		$s->addElement( ffOneElement::TYPE_TABLE_END );
	}


	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		$contentBlockId = $query->getPost('content-block')->id;
		$contentBlock = $this->_getWPLayer()->get_post( $contentBlockId );

		echo $this->_doShortcode( $contentBlock->post_content );
	}

	protected function _renderContentInfo_JS() {
		?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview, elementView, $form ) {
				var value = query.get('content-block');
				var name = '';

				if( 'none' == value ) {
					preview.addHeadingLg('None');
				} else {
					var valueSplitted = value.split('--||--');
					var name = valueSplitted[1];
					if( name ) {
						preview.addHeadingLg(name);

						var imgUrl = name.substring(2);
						imgUrl = 'http://dev.freshface.net/ark-sections/wp-content/plugins/p-fresh-dashboard/scraping/images/' + imgUrl + '.jpeg';
						query.addPlainText('<img class="ffb-preview-image" src="' + imgUrl + '">');
					}
				}

			}
		</script data-type="ffscript">
		<?php
	}
}