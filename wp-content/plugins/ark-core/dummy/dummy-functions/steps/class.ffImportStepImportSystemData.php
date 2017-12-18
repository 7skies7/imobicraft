<?php
class ffImportStepImportSystemData extends ffImportStepBasic {

	/**
	 * How many posts we want to replace in one batch
	 * @var int
	 */
	private $_numberOfPostsInOneBatch = 10;

	private $_foundCBInThisPost = false;

	private function _getSystemPath( $path = '') {
		$dir = FF_ARK_CORE_PLUGIN_DIR .'/dummy/'.$this->_getConfigValue('folder').'/system';
		$path = $dir . $path;

		return $path;
	}

	private function _getSystemFile( $path ) {
		$path = $this->_getSystemPath( $path );

		$fs = ffContainer()->getFileSystem();

		if( $fs->fileExists( $path ) ) {
			return $fs->getContents( $path );
		} else {
			return null;
		}
	}

	private function _importGeneral() {
		// global styles
		$globalStyleJSON = $this->_getSystemFile('/globalstyles.json');
		if( $globalStyleJSON != null ) {
			$globalStyle = json_decode( $globalStyleJSON, true );
			ffContainer()->getThemeFrameworkFactory()->getThemeBuilderGlobalStyles()->setElementGlobalStyles( $globalStyle );
		}

		// color library
		$colorlibJSON = $this->_getSystemFile('/colorlibrary.json');
		if( $colorlibJSON != null ) {
			$colorlib = json_decode( $colorlibJSON, true );

			ffContainer()->getThemeFrameworkFactory()->getThemeBuilderColorLibrary()->setLibrary( $colorlib)->saveLibrary();
		}

		// color library
		$themeOptiopnsJSON = $this->_getSystemFile('/themeOptions.json');
		if( $themeOptiopnsJSON != null ) {
			$themeOptions = json_decode( $themeOptiopnsJSON, true );

			ffThemeOptions::getInstance()->getInstance()->setData( $themeOptions );
		}

		$this->_importNamespace( 'templates' );
		$this->_importNamespace( 'header' );
		$this->_importNamespace( 'titlebar' );
		$this->_importNamespace( 'footer' );
		$this->_importNamespace( 'views_map' );
	}

	protected function _replaceMatchedImage( $match ) {

		$originalString = $match[0];
		$originalId = $match[1];
		$url = $match[2];
		$width = $match[3];
		$height = $match[4];

		// is our demo content image
		if( $originalId == -1 ) {
			return $originalString;
		}

		$newId = $this->_getWPImporter()->processedPostId( $originalId );

		// post does not exists
		if( $newId == null ) {
			return $originalString;
		}

		$newUrl = wp_get_attachment_url( $newId );

		$newImage = array();
		$newImage['id'] = $newId;
		$newImage['url'] = $newUrl;
		$newImage['width'] = $width;
		$newImage['height'] = $height;

		$imageJson = json_encode( $newImage, JSON_UNESCAPED_SLASHES);
		$imageJsonWithSlashes = addslashes( $imageJson );
		$imageJsonEncoded = rawurlencode( $imageJsonWithSlashes );

		$this->_foundImageInThisPost = true;

		return $imageJsonEncoded;
	}

	private function _importNamespace( $namespace ) {
		$path = $this->_getSystemPath( '/'. $namespace );

		$fs = ffContainer()->getFileSystem();

		if( !$fs->fileExists( $path ) ) {
			return false;
		}

		$optionsCollection = ffContainer()->getDataStorageFactory()->createOptionsCollection();

		$optionsCollection->setNamespace($namespace);
		$optionsCollection->addDefaultItemCallbacksFromThemeFolder();

		$items = $fs->dirlist( $path );

		foreach( $items as $oneItem ) {
//			var_Dump( $oneItem );
			$id = str_replace( '.json', '', $oneItem['name'] );

			$filePath = $path .'/' . $oneItem['name'];
			$contentJSON = $fs->getContents( $filePath );
			$content = json_decode( $contentJSON, true );

			if( isset( $content['builder'] ) ) {
				$regexp = '/%7B%5C%22id%5C%22%3A([0-9]*)%2C%5C%22url%5C%22%3A%5C%22(.+?)%5C%22%2C%5C%22width%5C%22%3A([0-9]+)%2C%5C%22height%5C%22%3A([0-9]+)%7D/';

				$content['builder'] = preg_replace_callback( $regexp, array($this, '_replaceMatchedImage'), $content['builder'] );
			}


//			$content = new ffArrayQuery( $content);
			$optionsCollection->setItemToDb( $id, $content );
		}

//		$optionsCollection->save();


	}

	protected function _importNavMenu() {
		$locations = get_nav_menu_locations();

		$mainNavId = $this->_getConfigValue('nav_menu');

		if( $mainNavId != null ) {
			$locations['main-nav'] = $this->_getWPImporter()->processed_terms[  $mainNavId ];
		}


		set_theme_mod('nav_menu_locations', $locations);

	}

	protected function _setHomeAndPostsPage(){

		$frontPageId = $this->_getConfigValue('front_page_id');
		if( $frontPageId != null ) {
			$frontPageIdNew = $this->_getWPImporter()->processed_posts[$frontPageId];

			update_option('page_on_front', $frontPageIdNew);
			update_option('show_on_front', 'page');
		}

		$postsPageId = $this->_getConfigValue('posts_page_id');

		if( $postsPageId != null ) {
			$postsPageIdNew = $this->_getWPImporter()->processed_posts[$postsPageId];
			update_option('page_for_posts', $postsPageIdNew);
		}
	}

	protected function _runStep() {
		$this->_importGeneral();
		$this->_importNavMenu();
		$this->_setHomeAndPostsPage();

		$this->_message = 'Finalising';
	}

}