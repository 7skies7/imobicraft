<?php
class ffAdminScreenDocumentationViewDefault extends ffAdminScreenView {


	public function ajaxRequest( ffAdminScreenAjax $ajax ) {

//		var_dump( $ajax );
	}



	public function newAjaxRequest( ffAjaxRequest $ajaxRequest ) {

	}




	protected function _render() {

		echo '<div class="wrap">';
		echo '<h1>Support & Docs</h1>';


		echo '<div style="max-width:560px;">';

		echo '<div style="padding: 30px 40px 30px 40px; background: #feffbf;">';
		echo '<h2 style="font-size: 20px;">Refund – Money Back Guarantee</h2>';
		echo '<p style="font-size: 16px;">If you are not <strong>100%</strong> happy with The Ark we offer a full refund without any questions, at any time. We want everyone to be <strong>100%</strong> satisfied with their purchase so if you are not, simply get a refund by following the link below:<br><br><a target="_blank" style="font-size: 20px;" href="https://themeforest.net/refund_requests/new">Get Refund &#8594;</a></p>';
		echo '</div>';


		echo '<h1 style="padding:15px 40px; background-color:red; color:white; margin-top:15px;">FIRST AID HELP</h1>';
		echo '<div style="background-color:white; padding: 5px 40px 5px 40px; margin-bottom:15px;">';
		echo '<p><strong>1.) Fresh Builder is not loading</strong> - delete backend builder cache in WP Admin -> Ark -> Dashboard -> <a target="_blank" href="'.get_admin_url(null, '/admin.php?page=Dashboard&adminScreenView=Status').'">System Status</a>, then try to refresh your browser in Fresh Builder editor few times (3-5). If this does not help, post a ticket (check links below at this page)</p>';

		echo '<p><strong>2.) Your site CSS looks weird</strong> - Deactivate Fresh Performance Cache plugin </p>';
		echo '</div>';

		echo '<h2>MUST-WATCH VIDEO</h2>';
		echo '<p>Firstly, we strongly recommend you to watch this quick video with english voice-over. It contains everything important that you need to know to get started.</p>';
		echo '<iframe width="560" height="315" src="https://www.youtube.com/embed/6ROQzFyBvvk" frameborder="0" allowfullscreen></iframe>';
		echo '<br>';
		echo '<br>';
		echo '<br>';

		echo '<br>';
//		echo '<p><a target="_blank" href="https://themeforest.net/refund_requests/new">https://themeforest.net/refund_requests/new</a></p>';
		echo '<div class="ark-support-box">';
		echo '<h2 class="ark-support-box-title">Support Resources</h2>';
		echo '<h2><a href="https://www.youtube.com/playlist?list=PLtdsaq239-KDx0hg_FQYb60VpF0E2y_Qm" target="_blank">Video Tutorials »</a></h2>';
		echo '<h2><a href="http://arktheme.com/docs/" target="_blank">Documentation »</a></h2>';
		echo '<h2><a href="http://arktheme.com/open-ticket/" target="_blank">Get Support (Open Ticket) »</a></h2>';
		echo '<h2><a href="https://www.facebook.com/groups/1827105637579063/" target="_blank">The Ark Facebook Group »</a></h2>';
		echo '</div>';
		echo '</div>';
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