<?php
class ffAdminScreenImprovementsViewDefault extends ffAdminScreenView {


	public function ajaxRequest( ffAdminScreenAjax $ajax ) {

//		var_dump( $ajax );
	}



	public function newAjaxRequest( ffAjaxRequest $ajaxRequest ) {

	}




	protected function _render() {

		echo '<div class="wrap about-wrap">';
		echo '<h1>Improvements</h1>';

		echo '<p class="about-text">You can influence the development of Ark. Let us know, what features we should implement in future updates. Upvote the features of other users and let the Ark sail in the right direction!</p>';

		echo '<h3>How it works?</h3>';
		?>

		<ul>
			<li>1.) You post your suggestion in comments</li>
			<li>2.) We approve it and move to "Ideas" List</li>
			<li>3.) You upvote "Ideas" you like</li>
			<li>4.) We implement upvoted ideas</li>
		</ul>
		<br><br><br>
		<a class="ark-improve-button" href="https://trello.com/b/ypzRDfBC/ark-theme-roadmap" target="_blank"><span>Improve Ark</span></a>

		<style>
			.ark-improve-button {
				padding: 15px 23px;
				background: #32d316;
				color:#fff;
				text-decoration: none;
				font-size:24px;
			}

			.ark-improve-button:hover {
				color:#fff;
			}


		</style>
<?php
		echo '</div>';
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