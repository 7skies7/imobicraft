<?php
class ffAdminScreenMigrationViewDefault extends ffAdminScreenView {


	public function ajaxRequest( ffAdminScreenAjax $ajax ) {

//		var_dump( $ajax );
	}



	public function newAjaxRequest( ffAjaxRequest $ajaxRequest ) {

	}

	protected function _actionReplaceImages() {

		echo '<h1>Migrating images</h1>';

        $somethingReplaced = false;

		$posts = ffContainer()->getPostLayer()->getPostGetter()
			->setNumberOfPosts(-1)
//			->setOffset(45)
			->getPostsByType('any');

		$tbr = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderRegexp();
//
		foreach( $posts as $onePost ) {
			$postContent = $onePost->getContent();

			$newContent = $tbr->imageFind( $postContent, array($this,'imageFound'));

			if( $tbr->getFoundImageInPost() ) {

				echo 'Replaced images here: ' . get_post_permalink($onePost->getID()) . '<br>';
                $somethingReplaced = true;

				$postUpdater = ffContainer()->getPostLayer()->getPostUpdater();
				$data = array();
				$data['ID'] = $onePost->getID();
				$data['post_content'] = $newContent;

				$postUpdater->updatePost($data);
				echo '<br><br><br>';
			}
		}


		$optionsCollection = ffContainer()->getDataStorageFactory()->createOptionsCollection();

		$optionsCollection->setNamespace('footer');
		$optionsCollection->addDefaultItemCallbacksFromThemeFolder();

		foreach( $optionsCollection as $oneItem ) {

			$postContent = $oneItem->get('builder');

			$newContent = $tbr->imageFind( $postContent, array($this,'imageFound'));

			if( $tbr->getFoundImageInPost() ) {
				echo 'Replaced images in footer ' . $oneItem->get('name');
                $somethingReplaced = true;
				$oneItem->set('builder', $newContent);
			}

		}

		$optionsCollection->save();

        $optionsCollection = ffContainer()->getDataStorageFactory()->createOptionsCollection();

        $optionsCollection->setNamespace('titlebar');
        $optionsCollection->addDefaultItemCallbacksFromThemeFolder();

        foreach( $optionsCollection as $oneItem ) {

            $postContent = $oneItem->get('builder');

            $newContent = $tbr->imageFind( $postContent, array($this,'imageFound'));

            if( $tbr->getFoundImageInPost() ) {
                echo 'Replaced images in titlebar ' . $oneItem->get('name');
                $somethingReplaced = true;
                $oneItem->set('builder', $newContent);
            }

        }

        $optionsCollection->save();

        if( $somethingReplaced == false ) {
            echo 'Nothing found';
        }

	}

	private $_replacedImages = array();

	public function imageFound( $image ) {




		$imageData = ffDataHolder( $image );

		$imageNewUrl = wp_get_attachment_url( $imageData->id );

		if( $imageData->url != $imageNewUrl ) {
			echo 'Image Replaced' . '<br>';
			echo 'Old URL : ' . $imageData->url . '<br>';
			echo 'New URL : ' .$imageNewUrl . '<br>';
			$image['url'] = $imageNewUrl;

			$imageData->new_url = $imageNewUrl;
			$this->_replacedImages[] = $imageData;

			return $image;
		}

		return null;
	}

	private function _actionReplaceUrl() {
        $somethingReplaced = false;

		echo '<h1>Replacing STRING</h1>';

		$reqeust = ffContainer()->getRequest();

		$oldUrl = $reqeust->post('ff-old-url');
		$newUrl = $reqeust->post('ff-new-url');

		$oldUrlEncoded = rawurlencode( $oldUrl );
		$newUrlEncoded = rawurlencode( $newUrl );

		$posts = ffContainer()->getPostLayer()->getPostGetter()
			->setNumberOfPosts(-1)
//			->setOffset(45)
			->getPostsByType('any');
//
//		$tbr = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderRegexp();
////
		foreach( $posts as $onePost ) {
			$postContent = $onePost->getContent();

			$count = 0;
			$newContent = str_replace( $oldUrlEncoded, $newUrlEncoded, $postContent, $count);

			if( $count > 0 ) {
				echo 'Replaced string here: ' . get_post_permalink($onePost->getID()) . '<br>';
                $somethingReplaced = true;

				$postUpdater = ffContainer()->getPostLayer()->getPostUpdater();
				$data = array();
				$data['ID'] = $onePost->getID();
				$data['post_content'] = $newContent;
//
				$postUpdater->updatePost($data);
				echo '<br><br><br>';
			}

		}

		$optionsCollection = ffContainer()->getDataStorageFactory()->createOptionsCollection();

		$optionsCollection->setNamespace('footer');
		$optionsCollection->addDefaultItemCallbacksFromThemeFolder();

		foreach( $optionsCollection as $oneItem ) {

			$postContent = $oneItem->get('builder');

			$count = 0;
			$newContent = str_replace( $oldUrlEncoded, $newUrlEncoded, $postContent, $count);

			if( $count > 0 ) {
				echo 'Replaced images in footer ' . $oneItem->get('name');
                $somethingReplaced = true;
				$oneItem->set('builder', $newContent);
			}

		}

		$optionsCollection->save();

        $optionsCollection = ffContainer()->getDataStorageFactory()->createOptionsCollection();

        $optionsCollection->setNamespace('titlebar');
        $optionsCollection->addDefaultItemCallbacksFromThemeFolder();

        foreach( $optionsCollection as $oneItem ) {

            $postContent = $oneItem->get('builder');

            $count = 0;
            $newContent = str_replace( $oldUrlEncoded, $newUrlEncoded, $postContent, $count);

            if( $count > 0 ) {
                echo 'Replaced images in titlebar ' . $oneItem->get('name');
                $somethingReplaced = true;
                $oneItem->set('builder', $newContent);
            }

        }

        $optionsCollection->save();

        if( $somethingReplaced == false ) {
            echo 'Nothing found';
        }
	}


	protected function _render() {

		$request = ffContainer()->getRequest();


		echo '<div class="wrap">';
		echo '<h1>Migration</h1>';
		echo '<p>When you are migrating your site from staging environment to your production server, this is the last step. It runs query in Ark data and replaces the old URLs with a new URLs. <strong style="color:red;">You still need to do a standard migration process and replace URL in your database. This is only for Ark data, which cannot be replaced with the standard migration process</strong></strong></p>';
		echo '<p><strong style="color:red;">if you dont know what it is, you dont need it, dont use it</strong></p>';
		echo '<p><strong style="color:red;">!! backup your DB, lot of things could go wrong !!</strong></p>';
		echo '<p><strong style="color:red;">Currently nothing in header is searched and replaced (this is mainly for logos), so you need to do this manually!</strong></p>';
		switch( $request->get('action', 'default') ) {
			case 'replace-images':
				$this->_actionReplaceImages();
				break;

			case 'replace-url':
				$this->_actionReplaceUrl();
				break;
		}

		$urlRewriter = ffContainer()->getUrlRewriter();


			echo '<h2>Replace Images</h2>';
			echo '<p><a class="button button-primary" href="'. $urlRewriter->addQueryParameter('action', 'replace-images')->getNewUrl().'">Replace Images</a> - finds every image and replace it with correct url (good for http -> https or huge server migration)</p>';

			echo '<br><br><br>';
			echo '<h2>Replace String</h2>';
			echo '<p>This is also great for replacing old URL to new URL</p>';
			echo '<form action="'. $urlRewriter->addQueryParameter('action', 'replace-url')->getNewUrl().'" method="POST">';
				echo '<p><input type="text" name="ff-old-url" class="ff-old-url"> - Old string (find)</p>';
//				echo '';
				echo '<p><input type="text" name="ff-new-url" class="ff-new-url"> - New string (replace with)</p>';
//				echo '';
//				echo '<br>';
				echo '<br>';
				echo '<input type="submit" class="button button-primary ff-replace-url-button" value="Replace URL">';
			echo '</form>';
//			echo '<p><a class="button" href="'. $urlRewriter->addQueryParameter('action', 'replace')->getNewUrl().'">Replace URL</a> - the actual replacing process</p>';
//		echo '<h1>Migration</h1>';
//			echo '<'
		echo '</div>';

		// search for image strings across website


	}



	protected function _requireAssets() {
		$themeBuilder = ffContainer()->getThemeFrameworkFactory()->getThemeBuilder();

		$themeBuilder->requireBuilderScriptsAndStyles();

//		$pluginUrl = ffPluginFreshMinificatorContainer::getInstance()->getPluginUrl();
//		$this->_getScriptEnqueuer()->addScript('ffAdminScreenMinificatorViewDefault', $pluginUrl .'/adminScreens/minificator/assets/adminScreen.js', array('jquery') );
//		$this->_getStyleEnqueuer()
//			->addStyleFramework('ff-dummy-content', '/framework/themes/dummy/adminScreen/style.css');

		$this->_getScriptEnqueuer()
			->addScriptFramework('ff-migration', '/framework/themes/migration/script.js');
	}


	protected function _setDependencies() {

	}

}