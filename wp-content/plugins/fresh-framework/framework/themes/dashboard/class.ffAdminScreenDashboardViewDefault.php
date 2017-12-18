<?php
class ffAdminScreenDashboardViewDefault extends ffAdminScreenView {


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
		$licenseKey = $ajaxRequest->getData('licenseKey');
		$email = $ajaxRequest->getData('email');

		$licensing = ffContainer()->getLicensing();

		$infoArray = $licensing->getInformationsForLicenseKey($licenseKey);

		$info = new ffDataHolder( $infoArray );

		$ad = ffContainer()->getAjaxDispatcher();

		if( $info->status == 'ok' ) {
			ob_start();
//			var_Dump( $info );
			// echo '<p> Contact with server has been successful</p>';
			if( !$info->valid ) {
				echo '<p>License key is not valid</p>';
			} else {
				if( $info->is_current_domain_active ) {
					echo '<p>This License Key is active on this domain ('. $licensing->getThisSite() .').</p>';
					$licensing->setStatus( ffLicensing::STATUS_ACTIVE );

					$licensing->setLicenseKey( $licenseKey);
					$licensing->setEmail( $email );
				} else {
					echo '<p>This License Key is not active on this domain. Press the Activate License button below to attach this License Key to this domain.</p>';
					$licensing->setStatus( ffLicensing::STATUS_DEACTIVATED );
				}

				if( null != $info->get('history', null) ){

					echo '<p> Number of domain transfers left: <strong>' . $info['number-of-changes-left'] . '</strong></p>';

					echo '<h3>Registration History</h3>';
					echo '<table>';
					echo '<thead>';
					echo '<tr><td>Domain</td><td>Activation Date</td><td>Status</td></tr>';
					echo '</thead>';
					echo '<tbody>';
					foreach( $info->get('history', array() ) as $oneHistory ) {
						echo '<tr>';
						echo '<td>';
						echo $oneHistory['domain_name'];
						echo '</td>';

						echo '<td>';
						echo $oneHistory['date_added'] . ' GMT';
						echo '</td>';

						echo '<td>';
						echo $oneHistory['is_active'] ? 'Active': 'Disabled';
						echo '</td>';
						echo '</tr>';
					}
					echo '</tbody>';
					echo '</table>';

				}

				if( !$info->is_current_domain_active ) {
					echo '<input type="hidden" class="ff-input-hidden-key" value="' . esc_attr($licenseKey) . '">';
					echo '<input type="hidden" class="ff-input-hidden-email" value="' . esc_attr($email) . '">';
					echo '<input type="submit" class="ff-button-action-register" value="Activate License for this domain">';
				}
//				echo '<input type="submit" '
			}


			$content = ob_get_contents();
			ob_end_clean();

			$ad->addResponse('can-be-registered', 1);
		} else {
			$ad->addResponse('can-be-registered', 0);
			$content = '<p>Contact with the License Server has failed. Make sure you are connected to the Internet. If the License Server is offline, please try again later.</p>';
		}

		$ad->addResponse('original_response', $infoArray );
		$ad->addResponse('status', 1);
		$ad->addResponse('html', $content);

	}

	protected function _render() {
		$arkVersion = wp_get_theme();
		$arkVersion = $arkVersion->get('Version');

		$urlRewriter = ffContainer()->getUrlRewriter();

		$defaultUrl = $urlRewriter->addQueryParameter('adminScreenView', 'Default')->getNewUrl();
		$statusURl = $urlRewriter->addQueryParameter('adminScreenView', 'Status')->getNewUrl();

		echo '
		<div class="wrap about-wrap about-ark">
		<h1>Welcome to Ark!</h1>

		<p class="about-text">Thank you for updating to the latest version. Before using the theme, please activate your License to fully unlock the power of Ark.</p>
		<div class="wp-badge"><div class="ff-logo"></div><span>Version '.$arkVersion.'</span></div>
	
		<h2 style="text-align:left;">Watch this video:  </h2>
		<iframe width="560" height="320" src="https://www.youtube.com/embed/6ROQzFyBvvk" frameborder="0" allowfullscreen></iframe>';
        echo '<br><br><br>';

        echo '<div style="float:left;" ><a style="background-color: #3b5998; color:white;padding:20px; font-size:25px; margin-top:20px; text-decoration:none; border:1px solid red;" target="_blank" href="https://www.facebook.com/ark.wordpress.theme/"><img style="margin-top:-5px; padding-right:5px;" src="'.ffContainer()->getWPLayer()->getFrameworkUrl().'/framework/themes/dashboard/facebook.png"/> ARK - official fb page (daily info)</a></div>';
        echo '<div style="float:left; margin-left:50px;""><a style="background-color: #3b5998; color:white;padding:20px; font-size:25px; margin-top:20px; text-decoration:none;" target="_blank" href="https://www.facebook.com/groups/1827105637579063/"><img style="margin-top:-5px; padding-right:5px;" src="'.ffContainer()->getWPLayer()->getFrameworkUrl().'/framework/themes/dashboard/facebook.png"/> ARK - facebook group</a></div>';

        echo '
		<br>
		<br>
		<br>
		<br>
		<div style="color: red; font-size:25px;  text-decoration:none;">Scroll Down &#8595;</div>
		<br>
		<br>
		<h2 class="nav-tab-wrapper wp-clearfix">
			<a href="'.$defaultUrl.'" class="nav-tab nav-tab-active">License Activation</a>
			
			<a href="'.$statusURl.'" class="nav-tab">System Status</a>
			<!--
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
		</div> -->';

		$this->_printDashboardTabRegister();

		echo '
<p>
		<strong>How does the License activation works?</strong>:
		</p>
		<p>
		One License can be active only on one site at any given moment, not more. But the License can be activated on upto 5 other sites. Each new activation will automatically deactivate the previous activation. Localhost, different subdomains and TLDs count towards your activation limit as well.
		</p>
		<p>
		Example: You start developing on localhost and activate your License there - now you have 4 activations left. Then you transfer your website to a production server and activate your License there - now you have 3 activations left. Note that the License activated on localhost has been automatically deactivated thanks to License activation on the new production server.
		</p>
		<p>
		Should you need more than 5 activations, please contact us and we will be more than happy to change the limit for you manually.
		</p>

		<br><br>

		<hr>
		<p style="font-size:11px; color:#aaa">*By activating your license you agree to receive occasional email from FRESHFACE</p>
	';

//		echo '<h2 style="text-align:left;">Ark Facebook Group</h2>';

//        echo '<br><br><br>';


		echo '<h2 style="text-align:left;">Online Documentation</h2>';
		echo '<a href="http://arktheme.com/docs/" target="_blank"> Click here to visit online documentation </a>';
		echo '</div>';
	}

	protected function _printDashboardTabRegister() {
		$licensing = ffContainer()->getLicensing();

		$licenseKey = $licensing->getLicenseKey();
		$email = $licensing->getEmail();


		$status = $licensing->getStatus();

		echo '<div class="ff-dashboard-tab ff-dashboard-tab__register">';
//		if( $licenseKey == null ) {
			echo '<div class="ff-register__license-key">';
				echo '<div class="ff-register__status-msg">';
					if( $status == ffLicensing::STATUS_NOT_REGISTERED ) {
						echo '<h3><i class="dashicons dashicons-no-alt"></i><span> Your License has yet to be activated. The full version of Ark is disabled until you activate your License for this domain. Please press the Verify button below for more information.</span></h3>';
					} else if ( $status == ffLicensing::STATUS_DEACTIVATED ) {
						echo '<h3><i class="dashicons dashicons-warning"></i><span> Your License is not active on this domain. The full version of Ark is disabled until you activate your License for this domain. Please press the Show License button below for more information.</span></h3>';
					} else if( $status == ffLicensing::STATUS_ACTIVE ) {
						echo '<h3><i class="dashicons dashicons-yes"></i><span> Your License has been succesfully activated for this domain. You are now enjoying the full version of Ark!</span></h3>';
					}
				echo '</div><br>';
//				echo '<p>For automatic updates, please register your site</p>';
				echo '<form>';
					echo '<label class="ff-register-form-label"><input type="text" class="ff-input-license-key" value="'.$licenseKey.'"> License Key</label><br>';
					echo '<label class="ff-register-form-label"><input type="text" class="ff-input-email" value="'.$email.'"> E-mail Address<span style="color:#aaa">*</span></label><br>';
					echo '<input type="submit" class="ff-button-action-verify" value="Show License">';
				echo '</form>';
				echo '<div class="ff-ajax-output-holder">';
				echo '</div>';
			echo '</div>';
//		}

		echo '</div>';
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