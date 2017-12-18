<?php
class ffAdminScreenDummyViewDefault extends ffAdminScreenView {


	public function ajaxRequest( ffAdminScreenAjax $ajax ) {

//		var_dump( $ajax );
	}



	public function newAjaxRequest( ffAjaxRequest $ajaxRequest ) {

	}

	protected function _getAllDemos() {
		$fs = ffContainer()->getFileSystem();
		$demos = $fs->dirlist( FF_ARK_CORE_PLUGIN_DIR .'/dummy', false);


		$demoList = array();

		foreach( $demos as $oneDemo ) {
			$name = $oneDemo['name'];

			$configFilePath = FF_ARK_CORE_PLUGIN_DIR . '/dummy/' . $name . '/config.json';

			if( !$fs->fileExists($configFilePath) ) {
				continue;
			}


			$configFileJSON = $fs->getContents( $configFilePath );
			$configFile = new ffDataHolder();
			$configFile->setDataJSON( $configFileJSON );

			$configFile->setMeta('image-url', FF_ARK_CORE_PLUGIN_URL .'/dummy/' . $name. '/preview.jpg');
			$configFile->setMeta('folder-name', $name );


			$demoList[] = $configFile;
		}

		return $demoList;
	}

	protected function _renderAllDemos() {
		$demos = $this->_getAllDemos();

		$urlRewriter = ffContainer()->getUrlRewriter();

		echo '<div class="ff-demo-wrapper clearfix">';
		foreach( $demos as $oneDemo ) {
			echo '<div class="ff-demo-holder">';
			echo '<div class="ff-demo-holder-inner">';
			echo '<h3 class="ff-demo-name">' . $oneDemo->get('name') .'</h3>';
			echo '<p><span class="ff-demo-preview-img-wrapper"><img class="ff-demo-image" src="' . $oneDemo->getMeta('image-url') .'"/></span></p>';
			echo '<p class="ff-demo-description">' . $oneDemo->get('description') .'</p>';
			$url = $urlRewriter->reset()->addQueryParameter('import-demo-name', $oneDemo->getMeta('folder-name') )->getNewUrl();
			echo '<p class="ff-demo-install-holder"><a href="'.$url.'" class="button button-primary">Install Now</a></p>';
			echo '</div>';
			echo '</div>';
		}
		echo '</div>';


	}

	protected function _importOneDemo( $demoName ) {
		$importManager = ffContainer()->getThemeFrameworkFactory()->getImportManager();

		if( !$importManager->importFileInSteps( FF_ARK_CORE_PLUGIN_DIR.'/dummy/'.$demoName.'/config.json') ) {
			$status = new ffDataHolder( $importManager->getStatusMessage() );
			echo '<div class="ff-demo-status-holder">';
			echo '<div class="ff-demo-message ff-demo-heading">Importing demo</div>';
			echo '<div class="ff-demo-message ff-demo-main-step">Step: ' . $status->get('step') . '/' . $status->get('step_max') .'</div>';
			echo '<div class="ff-demo-message ff-demo-current-step-name">Current part: ' . $status->get('message') . '</div>';
			echo '<div class="ff-demo-message ff-demo-sub-step">'.$status->get('progress_current') . '/' . $status->get('progress_max') . '</div>';

			echo '<script> setTimeout(function(){ window.location.reload(); }, 1000 )</script>';
			echo '</div>';
//			var_Dump( $importManager->getStatusMessage());
			//echo '<script> setTimeout(function(){ window.location.reload(); }, 1000 )</script>';
		} else {
			echo '<div class="ff-demo-status-holder">';
			echo 'The Demo Installation has finished succesfully. Enjoy :-)';
			echo '</div>';
		}
	}

	protected function _render() {
		add_thickbox();
		$request = ffContainer()->getRequest();






		echo '
		<div class="wrap about-wrap about-ark">
		<h1>Demo Install</h1>

		<p class="about-text">
		We don\'t recommend installing Demos on your final production server due to a large amount of content. We recommend creating new WordPress installation with clean database separately for every demo you want to try. <br><br><strong>WARNING:</strong> Do not install Demos on an already existing WordPress website to avoid irreversible chaos. Demo Install should be performed only on a new and clean MySQL database.
		 <br><br><strong>IMAGES ARE PIXELATED</strong> because they cannot be distributed in original form due to license agreements. Competitors are replacing images with black square and "PLACEHOLDER" text. But we went the extra step and pixelated them, to make it look nicely.
		 <br><br><strong>IF YOU CANNOT SEE THE DESIRED DEMO PAGE</strong> on this list, please install the <strong>"MAIN"</strong> demo because what you are looking for is part of the <strong>"MAIN"</strong> installation package below (to save space).
		</p>

		<h2 class="nav-tab-wrapper wp-clearfix">
			<a href="./admin.php?page=Dummy" class="nav-tab nav-tab-active">Available Demos</a>
			<!--
			<a href="./admin.php?page=Dashboard" class="nav-tab">Support</a>
			<a href="./admin.php?page=Dashboard" class="nav-tab">Extensions</a>
			<a href="./admin.php?page=Dashboard" class="nav-tab">System Status</a>
			-->
		</h2>
<!--
		<p class="about-description">WordPress is Free and open source software, built by a distributed community of mostly volunteer developers from around the world. WordPress comes with some awesome, worldview-changing rights courtesy of its <a href="https://wordpress.org/about/license/">license</a>, the GPL.</p>

		<div class="changelog">
			<div class="under-the-hood three-col">
				<div class="col">
					<h3>Step 1</h3>
					<p>WordPress is Free and open source software, built by a distributed community of mostly volunteer developers from around the world. WordPress comes with some awesome, worldview-changing rights courtesy of its <a href="https://wordpress.org/about/license/">license</a>, the GPL.</p>
				</div>
				<div class="col">
					<h3>Step 2</h3>
					<p>WordPress is Free and open source software, built by a distributed community of mostly volunteer developers from around the world. WordPress comes with some awesome, worldview-changing rights courtesy of its <a href="https://wordpress.org/about/license/">license</a>, the GPL.</p>
				</div>
				<div class="col">
					<h3>Step 3</h3>
					<p>WordPress is Free and open source software, built by a distributed community of mostly volunteer developers from around the world. WordPress comes with some awesome, worldview-changing rights courtesy of its <a href="https://wordpress.org/about/license/">license</a>, the GPL.</p>
				</div>
			</div>
		</div>

		<hr>
-->
	</div>';






		if( $request->get('import-demo-name') == null ) {
			$this->_renderAllDemos();
		} else {
			$this->_importOneDemo( $request->get('import-demo-name') );
		}

//

//		$importManager = ffContainer()->getThemeFrameworkFactory()->getImportManager();
//

//		$themeOptionsUrl = admin_url('admin.php?page=ThemeOptions');


//		}
//		var_dump($importManager->getStatusMessage());
//		echo '<script> setTimeout(function(){ window.location.reload(); }, 1000 )</script>';
//		return;


	}



	protected function _requireAssets() {
		$themeBuilder = ffContainer()->getThemeFrameworkFactory()->getThemeBuilder();

		$themeBuilder->requireBuilderScriptsAndStyles();

//		$pluginUrl = ffPluginFreshMinificatorContainer::getInstance()->getPluginUrl();
//		$this->_getScriptEnqueuer()->addScript('ffAdminScreenMinificatorViewDefault', $pluginUrl .'/adminScreens/minificator/assets/adminScreen.js', array('jquery') );
		$this->_getStyleEnqueuer()
			->addStyleFramework('ff-dummy-content', '/framework/themes/dummy/adminScreen/style.css');

//		$this->_getScriptEnqueuer()
//			->addScriptFramework('ff-site-preferences', '/framework/themes/sitePreferences/script.js');
	}


	protected function _setDependencies() {

	}

}