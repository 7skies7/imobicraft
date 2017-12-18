<?php
class ffAdminScreenUpdatesViewDefault extends ffAdminScreenView {


	public function ajaxRequest( ffAdminScreenAjax $ajax ) {
	}



	public function newAjaxRequest( ffAjaxRequest $ajaxRequest ) {


	}

	private function _renderDefaultScreen() {
		$updateManager = ffContainer()->getThemeFrameworkFactory()->getPrivateUpdateManager();



		$listOfThingsToUpdate = $updateManager->getListOfThingsWhichNeedsToBeUpdated();


		echo '<div class="wrap">';
		echo '<h1>Updates</h1><br>';

		$licenseStatus = ffContainer()->getLicensing()->getStatus();

		if( $licenseStatus != ffLicensing::STATUS_ACTIVE ) {
			echo '<p>You need to activate your ARK license in order to receive updates. Please do this in the Ark -> Dashboard menu, located on your left side</p>';
		} else {


			echo '<a href="'.$this->_getUrl('force-check').'" class="button ">FORCE CHECK</a> <br>last checked:' . date('Y-m-d H:i', $updateManager->getLastChecked());

			if( $listOfThingsToUpdate['has-updates'] == false ) {
				echo '<p>Currently, there is nothing which needs to be updated</p>';
			} else {
				echo '<h3>These products needs to be updated:</h3>';

				/**
				 * @var $oneTheme WP_Theme
				 */
				foreach( $listOfThingsToUpdate['themes'] as $oneTheme ) {
					if( !$oneTheme['need_update'] ) {
						continue;
					}
					echo '<p class="update-info-line">'.$oneTheme['Name'] . ' (theme)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; from ' . $oneTheme['Version'] . ' to <strong>' . $oneTheme['remote_version'] .'</strong></p>';
				}

				foreach( $listOfThingsToUpdate['plugins'] as $onePlugin ) {
					if( !$onePlugin['need_update'] ) {
						continue;
					}
					echo '<p class="update-info-line">'.$onePlugin['Name'] . ' (plugin)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; from ' . $onePlugin['Version'] . ' to <strong>' . $onePlugin['remote_version'] .'</strong></p>';
				}

				echo '<a href="'.$this->_getUrl('update').'" class="button button-primary ">UPDATE ALL ABOVE</a>';

			}

		}



		echo '</div>';
//		var_Dump( $listOfThingsToUpdate );
	}

	private function _getUrl( $action ) {
		$urlRewriter = ffContainer()->getUrlRewriter();

		$urlRewriter->addQueryParameter('updater_action', $action );

		return $urlRewriter->getNewUrl();
	}

	private function _renderForceCheck() {

//		if( $request->get('force-check-updates') ) {
		ffContainer()->getThemeFrameworkFactory()->getPrivateUpdateManager()->getRemoteUpdateInfo(true);

		echo '<script> window.location="' . $this->_getUrl('default').'";</script>';
//		}
	}


	private function _renderUpdate() {
		$request = ffContainer()->getRequest();
		$url = ffContainer()->getUrlRewriter();

		$step = $request->get('ff-update-step', 1);

		$updateManager = ffContainer()->getThemeFrameworkFactory()->getPrivateUpdateManager();



		$listOfThingsToUpdate = $updateManager->getListOfThingsWhichNeedsToBeUpdated();

		$urlRewriter = ffContainer()->getUrlRewriter();
		$urlRewriter->removeQueryParameter('ff-update-step');

		$message = '';
		$status = true;

		if( $step == 1 ) {
			if( isset( $listOfThingsToUpdate['plugins'] ) && isset($listOfThingsToUpdate['plugins']['fresh-framework'] ) ) {
				$freshFramework = $listOfThingsToUpdate['plugins']['fresh-framework'];

				if( $freshFramework['need_update'] ) {
					$url = $freshFramework['remote_download_url'];

					$result = $updateManager->downloadAndUnzipFile( $url, '');

					if( $result === true ) {
						$urlRewriter->addQueryParameter('ff-update-step', 2);
						$message = 'Fresh Framework plugin has been downloaded, will be updated in next step';
					} else {
						$message = 'Fresh Framework cannot be downloaded, update cannot be processed, reason: ' . $result;
						$status = false;
					}
				} else {
					$urlRewriter->addQueryParameter('ff-update-step', 3);
					$message = 'Fresh Framework does not need update, process will continue';
				}
			}

		}

		else if( $step == 2 ) {
			$result = $updateManager->updateUnzippedPlugin('fresh-framework');

			if( $result === true ) {
				$urlRewriter->addQueryParameter('ff-update-step', 3);
				$message = 'Fresh Framework plugin has been installed. In next step Ark Core plugin will be downloaded';
			} else {
				$message = 'Fresh Framework plugin failed installation. ' . $result;
				$status = false;
			}

		}

		else if( $step == 3 ) {
			if( isset( $listOfThingsToUpdate['plugins'] ) && isset($listOfThingsToUpdate['plugins']['ark-core'] ) ) {
				$plugin = $listOfThingsToUpdate['plugins']['ark-core'];

				if( $plugin['need_update'] ) {
					$url = $plugin['remote_download_url'];
					$result = $updateManager->downloadAndUnzipFile( $url, '');

					if( $result === true ) {
						$urlRewriter->addQueryParameter('ff-update-step', 4);
						$message = 'Ark Core plugin has been downloaded, will be updated in next step';
					} else {
						$message = 'Ark Core cannot be downloaded, update cannot be processed, reason: ' . $result;
						$status = false;
					}
				} else {
					$urlRewriter->addQueryParameter('ff-update-step', 5);
					$message = 'Ark Core does not need update, process will continue';
				}
			}
		}

		else if( $step == 4 ) {
			$result = $updateManager->updateUnzippedPlugin('ark-core');

			if( $result === true ) {
				$urlRewriter->addQueryParameter('ff-update-step', 5);
				$message = 'Ark Core plugin has been installed. In next step Ark theme will be downloaded';
			} else {
				$message = 'Ark Core plugin failed installation. ' . $result;
				$status = false;
			}

		}

		else if( $step == 5 ) {
			if( isset( $listOfThingsToUpdate['themes'] ) && isset($listOfThingsToUpdate['themes']['ark'] ) ) {
				$item = $listOfThingsToUpdate['themes']['ark'];

				if( $item['need_update'] ) {
					$url = $item['remote_download_url'];
					$result = $updateManager->downloadAndUnzipFile( $url, '');

					if( $result === true ) {
						$urlRewriter->addQueryParameter('ff-update-step', 6);
						$message = 'Ark Theme has been downloaded, will be updated in next step';
					} else {
						$message = 'Ark Theme cannot be downloaded, update cannot be processed, reason: ' . $result;
						$status = false;
					}
				} else {
					$urlRewriter->addQueryParameter('ff-update-step', 7);
					$message = 'Ark Theme does not need update, process will continue';
				}
			}
		}

		else if( $step == 6 ) {
			$result = $updateManager->updateUnzippedTheme('ark');

			if( $result === true ) {
				$urlRewriter->addQueryParameter('ff-update-step', 7);
				$message = 'Ark Theme has been installed';
			} else {
				var_dump( $result );
				$message = 'Ark Theme failed installation. ' . $result;
				$status = false;
			}

		}

		else if( $step == 7 ) {
			$message = 'FINISHED, all good';
			$urlRewriter->removeQueryParameter('updater_action');
			$updateManager->removeRemoteUpdateInfo();
		}

		$updateMessageClass = 'ff-update-message';

		if( $status == false ) {
			$updateMessageClass .= ' ff-update-message-error';
		}
		$nextUrl = $urlRewriter->getNewUrl();

		echo '<div class="ff-updater-wrapper">';
		echo '<h2>UPDATING '.$step.' / 7</h2>';
		echo '<div class="'.$updateMessageClass.'">';
		echo $message;
		echo '</div>';
		echo '<div class="ff-updater-info">';
			if( $status ) {
				echo 'next step will automatically start in 3 seconds<br>';
//				echo '<strong style="color:red;">If this exact screen persist for a minute or more, please hit the NEXT STEP button, otherwise not</strong>';
//				echo '<a href="'.$nextUrl.'" class="button button-primary">NEXT STEP</a>';
			} else {
				echo 'something went wrong, please open ticket here and include your WP login <br><a href="http://support.freshface.net/forums/forum/community-forums/ark/">SUPPORT FORUM</a>';
			}
		echo '</div>';
		echo '</div>';

		if( $status ) {
			echo '<script>
				jQuery(document).ready(function(){
					setTimeout(function(){
					
						window.location = "'. $nextUrl .'";
					
					},3000);
				});
			</script>';
		}


	}


	protected function _render() {
		$request = ffContainer()->getRequest();
		$action = $request->get('updater_action', 'default');


		switch( $action ) {
			case 'default':
				$this->_renderDefaultScreen();
				break;

			case 'force-check':
				$this->_renderForceCheck();
				break;
			case 'update':
				$this->_renderUpdate();
				break;
		}




//        echo 'UPDATES TY KURVO';



//		$pluginsForUpdate = $updateManager->getListOfThingsWhichNeedsToBeUpdated();

//		var_dump( $pluginsForUpdate );

//		$result = $updateManager->downloadAndUnzipFile('http://localhost/framework/licensing/?ff_http_action_trigger=1&ff_http_action_name=ff-license-api-hook-get-file&ff_file_name=ark', 'null');

//		var_dump( $result );

		
		//http://localhost/framework/licensing/?ff_http_action_trigger=1
		/**
		 * Jak to fachci
		 *
		 * 1.) Vydame novou verzu
		 * 2.) Verze se nahraje na FTP (automaticky)
		 * 3.) Zmeni se soubor obsahujici aktualni veci
		 *
		 *
		 *
		 * 1.) requestne se soubor ze serveru
		 * 2.) Porovnaji se verze
		 * 3.) Nabidne se update, u Ark, Ark Core a Fresh FRamework to musi byt jako jeden celek
		 *
		 *
		 *
		 *
		 *
		 */
	}



	protected function _requireAssets() {
				$this->_getStyleEnqueuer()
			->addStyleFramework('ff-updates', '/framework/themes/updates/style.css');



	}


	protected function _setDependencies() {

	}

}