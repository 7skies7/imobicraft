<?php

class ffMetaBoxThemeBuilderView extends ffMetaBoxView {
    /**
     * Handle ajax request - junction
     * @param ffAjaxRequest $ajaxRequest
     */
    public function ajaxRequest( ffAjaxRequest $ajaxRequest ) {

    }
    /**
     * Render just the post id, the rest of the options will be loaded trough ajax call
     * @param $post
     */
    protected function _render( $post ) {

		$this->_printIsBuilderEnabled( $post );
	    $themeBuilder = ffContainer()->getThemeFrameworkFactory()->getThemeBuilder();


	    $postMeta = ffContainer()->getDataStorageFactory()->createDataStorageWPPostMetas();
	    $settings = new ffDataHolder();

	    $settings->setDataJSON( $postMeta->getOption( $post->ID, 'ff_builder_status'));

	    $postContent = $post->post_content;

	    $wrapContentByParagraphBlock = false;
	    if( $settings->get('usage', 'never') == 'never' ) {
//		    $postContent = '';
		    $wrapContentByParagraphBlock = true;
	    }

//	    $settings->setDataJSON( $postMeta->getOption( $post->ID, 'ff_builder_status', null) );
//	    $settings->setIfNotExists('usage', 'never');

	    $themeBuilder->renderBuilderArea( $postContent, $wrapContentByParagraphBlock );
    }

	private function _printIsBuilderEnabled( $post ) {

//		var_dump( $post->ID );
		$postMeta = ffContainer()->getDataStorageFactory()->createDataStorageWPPostMetas();

		$settings = new ffDataHolder();


		$settings->setDataJSON( $postMeta->getOption( $post->ID, 'ff_builder_status', null) );
		
		$settings->setIfNotExists('usage', 'never');

		echo '<input type="hidden" name="ff-builder-post-settings" class="ff-builder-post-settings" value="'.esc_attr( $settings->getDataJSON() ).'">';

//		echo '<div class="ff-builder-post-settings" data-settings="'.esc_attr( $settingsJson ).'"></div>';
	}


	protected function _requireAssets() {
		$themeBuilder = ffContainer()->getThemeFrameworkFactory()->getThemeBuilder();
		$themeBuilder->requireBuilderScriptsAndStyles();

	}

	protected function _save( $postId ) {
		$request = ffContainer()->getRequest();

		$builderStatus = new ffDataHolder();

		$builderStatus->setDataJSON( $request->post('ff-builder-post-settings') );

		$postMeta = ffContainer()->getDataStorageFactory()->createDataStorageWPPostMetas();
		$postMeta->setOption( $postId, 'ff_builder_status', $builderStatus->getDataJSON() );


	}
}