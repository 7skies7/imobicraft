<?php
class ffAdminScreenDashboardViewStatus extends ffAdminScreenView {


	public function ajaxRequest( ffAdminScreenAjax $ajax ) {
	}



	public function newAjaxRequest( ffAjaxRequest $ajaxRequest ) {
		if( $ajaxRequest->getData('action') == 'verify' ) {
			$this->_ajaxActionVerify( $ajaxRequest );
		}

		else if( $ajaxRequest->getData('action') == 'register' ) {
			$this->_ajaxActionRegister( $ajaxRequest );
		}

	}

	protected function _ajaxActionRegister( $ajaxRequest ) {
		$licenseKey = $ajaxRequest->getData('licenseKey');
		$email = $ajaxRequest->getData('email');

		$licensing = ffContainer()->getLicensing();

		$licensing->setLicenseKey($licenseKey);
		$licensing->setEmail($email);
		$result = $licensing->registerThisSite();

		$info = new ffDataHolder( $result );

		if( $info->status == 'success' ) {
			echo '<p>' . $info->message . '</p>';
		}
	}

	/**
	 * @param ffAjaxRequest $ajaxRequest\
	 */
	protected function _ajaxActionVerify( $ajaxRequest ) {

	}

	protected function _render() {


		$arkVersion = wp_get_theme();
		$arkVersion = $arkVersion->get('Version');

		$urlRewriter = ffContainer()->getUrlRewriter();

		$defaultUrl = $urlRewriter->addQueryParameter('adminScreenView', 'Default')->getNewUrl();
		$statusURl = $urlRewriter->addQueryParameter('adminScreenView', 'Status')->getNewUrl();

		$request = ffContainer()->getRequest();

		$action = $request->get('action');
		if( $action == 'deleteBuilderBackendCache' ) {
			$themeBuilderCache = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderCache();
			$themeBuilderCache->deleteBackendCache();

		} else if ( $action == 'deleteBuilderFrontendCache') {
			$themeBuilderCache = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderCache();
			$themeBuilderCache->deleteFrontendCache();

		} else if ( $action == 'disableWpDebug' ) {
			$wpConfig= ffContainer()->getWPConfigEditor();
			$wpConfig->disableWPDebug();
		} else if( $action == 'enableWpDebug' ) {
			$wpConfig= ffContainer()->getWPConfigEditor();
			$wpConfig->enableWPDebug();
		}

		if( $action != null ) {
			$urlRewriter->removeQueryParameter('action');
			echo '<script>window.location="' . $urlRewriter->getNewUrl().'";</script>';
		}

		echo '
		<div class="wrap about-wrap about-ark">
		<h1>Welcome to Ark!</h1>

		<p class="about-text">Thank you for updating to the latest version. Before using the theme, please activate your License to fully unlock the power of Ark.</p>
		<div class="wp-badge"><div class="ff-logo"></div><span>Version '.$arkVersion.'</span></div>

		<h2 class="nav-tab-wrapper wp-clearfix">
			<a href="'.$defaultUrl.'" class="nav-tab">License Activation</a>
			
			<a href="'.$statusURl.'" class="nav-tab nav-tab-active">System Status</a>
			
		</h2>
		
		';

		$this->_printDashboardTabStatus();


		echo '</div>';
	}

	protected function _printDashboardTabStatus() {
		$urlRewriter = ffContainer()->getUrlRewriter();


		echo '<h2 style="text-align:left;">Cache</h2>';





		$urlRewriter->addQueryParameter('action', 'deleteBuilderBackendCache');

		$themeBuilderCache = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderCache();
		$backendCacheFiles = $themeBuilderCache->numberOfFilesInBackendCache();
		echo '<p>If you have problem with loading the Fresh Builder, please try to delete the Backend cache</p>';
		echo '<p>Clean Fresh Builder Backend cache ('.$backendCacheFiles.' files) &nbsp;&nbsp;&nbsp;<a class="ffb-clean-backend-cache button button-primary" href="'.$urlRewriter->getNewUrl().'">CLEAN</a></p>';

		$urlRewriter->addQueryParameter('action', 'deleteBuilderFrontendCache');
		$frontendCacheFiles = $themeBuilderCache->numberOfFilesInFrontedCache();
		echo '<br><br>';
		echo '<p>For 99.99% you not need this. Hit only if you experience missleading behavior with rendering CSS</p>';
		echo '<p>Clean Fresh Builder Frontend cache ('.$frontendCacheFiles.' files) &nbsp;&nbsp;&nbsp;<a class="button button-primary" href="'.$urlRewriter->getNewUrl().'">CLEAN</a></p>';

		echo '<h2 style="text-align:left;">Status</h2>';

		$sysEnv = ffContainer()->getThemeFrameworkFactory()->getSystemEnvironment();
		$serverReport = $sysEnv->generateServerReport();

		$notCompatible = $sysEnv->getNonValidServerReportLines();
		if( !empty( $notCompatible ) ) {
			echo '<table class="ff-system-status-table" style="padding:40px; background-color:#dcdcdc;">';
			echo '<thead>';
			echo '<tr>';
			echo '<td>Name</td>';
			echo '<td>Status</td>';
			echo '<td>Value</td>';
			echo '<td>Recommended</td>';
			echo '</tr>';
			echo '</thead>';
			foreach ($notCompatible as $key => $values) {
				$values = ffDataHolder($values);
				echo '<tr>';
				echo '<td>' . $values->name . '</td>';

				echo '<td>';
				if ($values->valid) {
					echo '<span style="color:green;">OK</span>';
				} else {
					echo '<span style="color:red;">WRONG</span>';
				}
				echo '</td>';

				echo '<td style="width:50%;">';
				if ($key == 'active_plugins') {
					$lines = explode("\n", $values->value);
					echo '<table>';
					foreach ($lines as $oneLine) {
						$data = explode(' -- ', $oneLine);
						echo '<tr>';
						foreach ($data as $key => $oneCol) {
							if ($key == 2) break;

							echo '<td>' . $oneCol . '</td>';
						}
						echo '</tr>';
					}
					echo '</table>';
				} else {
					echo $values->value;
				}
				echo '</td>';

				echo '<td>';
				echo $values->recommended;
				echo '</td>';

				echo '</tr>';
			}
			echo '</table>';
		}

		echo '<table class="ff-system-status-table">';
			echo '<thead>';
				echo '<tr>';
					echo '<td>Name</td>';
					echo '<td>Status</td>';
					echo '<td>Value</td>';
					echo '<td>Recommended</td>';
				echo '</tr>';
			echo '</thead>';
			foreach( $serverReport as $key => $values ) {
				$values = ffDataHolder( $values );
				echo '<tr>';
					echo '<td>' . $values->name . '</td>';

					echo '<td>';
						if( $values->valid ) {
							echo '<span style="color:green;">OK</span>';
						} else {
							echo '<span style="color:red;">WRONG</span>';
						}
					echo '</td>';

					echo '<td style="width:50%;">';
						if( $key == 'active_plugins' ) {
							$lines = explode("\n", $values->value);
							echo '<table>';
							foreach( $lines as $oneLine ) {
								$data = explode(' -- ', $oneLine );
								echo '<tr>';
								foreach( $data as $key => $oneCol ) {
									if( $key == 2 ) break;

									echo '<td>' . $oneCol . '</td>';
								}
								echo '</tr>';
							}
							echo '</table>';
						} else {
							echo $values->value;
						}
					echo '</td>';

					echo '<td>';
						echo $values->recommended;
					echo '</td>';

				echo '</tr>';
			}
		echo '</table>';

		echo '<style> .ff-system-status-table td{padding:0 10px 0 10px;} .ff-system-status-table td td {padding:0 20px 0 0;}</style>';

		$report = array();
		foreach( $serverReport as $key => $values ) {
			$values = ffDataHolder( $values );

			if( $key == 'active_plugins' ) {
				$oneLine = "\n". $values->id . ' -> ' . "\n\n" . $values->value ;
			} else {
				$oneLine = $values->valid . ' -> ' . $values->id . ' -> ||' . $values->value .'||';
			}


			$report[] = $oneLine;
		}

		if( !empty($notCompatible) ) {
			$report[] ='NOT COMPATIBLE';
			foreach( $notCompatible as $key => $values ) {
				$values = ffDataHolder( $values );

				if( $key == 'active_plugins' ) {
					$oneLine = "\n". $values->id . ' -> ' . "\n\n" . $values->value ;
				} else {
					$oneLine = $values->valid . ' -> ' . $values->id . ' -> ||' . $values->value .'||';
				}


				$report[] = $oneLine;
			}
		}



		echo '<h2 style="text-align:left;">Text Report</h2>';
		echo '<p>Please copy & paste this to your support requests</p>';
		echo '<textarea cols="100" rows="5">'.implode("\n", $report) .'</textarea>';

		echo '<h2 style="text-align:left;">WP Debug</h2>';
		$wpConfig= ffContainer()->getWPConfigEditor();

		if( $wpConfig->getWPDebugValue() == true) {
			$urlRewriter->addQueryParameter('action', 'disableWpDebug');
			echo '<p>Is enabled <a class="button button-primary" href="'.$urlRewriter->getNewUrl().'">DISABLE</a></p>';
		} else {
			$urlRewriter->addQueryParameter('action', 'enableWpDebug');
			echo '<p>Is disabled <a class="button button-primary" href="'.$urlRewriter->getNewUrl().'">ENABLE</a></p>';
		}

	}





	protected function _requireAssets() {
		$themeBuilder = ffContainer()->getThemeFrameworkFactory()->getThemeBuilder();

		$themeBuilder->requireBuilderScriptsAndStyles();

//		$pluginUrl = ffPluginFreshMinificatorContainer::getInstance()->getPluginUrl();
//		$this->_getScriptEnqueuer()->addScript('ffAdminScreenMinificatorViewDefault', $pluginUrl .'/adminScreens/minificator/assets/adminScreen.js', array('jquery') );
		$this->_getStyleEnqueuer()
			->addStyleFramework('ff-site-preferences', '/framework/themes/sitePreferences/style.css');
		$this->_getStyleEnqueuer()
			->addStyleFramework('ff-frslib-options2-css', '/framework/frslib/new/frslib-options2.css');


		$this->_getScriptEnqueuer()
			->addScriptFramework('ff-site-preferences', '/framework/themes/dashboard/script.js');

	}


	protected function _setDependencies() {

	}

}