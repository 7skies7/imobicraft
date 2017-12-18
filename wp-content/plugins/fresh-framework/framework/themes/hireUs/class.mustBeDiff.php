<?php
class ffAdminScreenHireUsViewDefault extends ffAdminScreenView {


	public function ajaxRequest( ffAdminScreenAjax $ajax ) {

	}



	public function newAjaxRequest( ffAjaxRequest $ajaxRequest ) {

	}



	protected function _render() {

		echo '<div class="wrap about-wrap">';
			echo '<h1>The Ark Studio</h1>';
			// echo '<p class="about-text">Let the creators of The Ark help you with your project too.</p>';
			// echo '<p class="about-text">We offer professional webdesign services to our customers.</p>';
			echo '<p class="about-text">Gain access to the same team that has created one of the best WordPress themes – The Ark.<br> We can help you with your projects to achieve anything you need.</p>';
			echo '<p class="about-text">Are you struggling with something? Need an extra pair of hands to meet the deadline? Overloaded with client work? Now you have a choice!</p>';
			echo '<p class="about-text">Follow the link and fill the short form. We will then get back to you and discuss how best we can help you:</p>';
			echo '<a class="ark-hire-us-button" href="http://arktheme.com/hire-us/?utm_source=arkadmin" target="_blank"><span>Hire Us!</span></a>';
			echo '<div class="wp-badge"><span>The Ark Studio</span></div>';
			echo '<h1>Benefits for you</h1>';
			// echo '<hr>';
			echo '<div class="ark-hire-us-list-wrapper two-col">';
				echo '<div class="col">';
					echo '<div class="ark-hire-us-list-item">';
						echo '<p>We can work much faster than anyone else because The Ark is made and maintained by the same team of nice individuals.</p>';
					echo '</div>';
				echo '</div>';
				echo '<div class="col">';
					echo '<div class="ark-hire-us-list-item">';
						echo '<p>You will save tons of time (and money) by not having to search for a quality 3rd party contractor.</p>';
					echo '</div>';
				echo '</div>';
				echo '<div class="col">';
					echo '<div class="ark-hire-us-list-item">';
						echo '<p>You can rest assured that there is a team of skilled professionals at hand that can take care of almost anything you might not have the time or skills for.</p>';
					echo '</div>';
				echo '</div>';
				echo '<div class="col">';
					echo '<div class="ark-hire-us-list-item">';
						echo '<p>We have a decade worth of experience in broad range of disciplines, ranging from design to development and server administration.</p>';
					echo '</div>';
				echo '</div>';
				echo '<div class="col">';
					echo '<div class="ark-hire-us-list-item">';
						echo '<p>Nothing is too small or too big for us. We can help you with little customizations or even create full websites from start to finish.</p>';
					echo '</div>';
				echo '</div>';
				echo '<div class="col">';
					echo '<div class="ark-hire-us-list-item">';
						echo '<p>We are very reliable and meticulously organized team of highly-skilled professionals.</p>';
					echo '</div>';
				echo '</div>';
				echo '<div class="col">';
					echo '<div class="ark-hire-us-list-item">';
						echo '<p>Affordable pricing and fast turnarounds.</p>';
					echo '</div>';
				echo '</div>';
			echo '</div>';


			// echo '<p>- We can work much faster compared to anyone else because The Ark is made and maintained by the same team of nice people</p>';
			// echo '<p>- You will save time looking for quality 3rd party contractor</p>';
			// echo '<p>- You can rest assured that there is a team of skilled professionals at hand that can take care of almost anything if you do not have the time or skills to solve them</p>';
			// echo '<p>- We offer broad range of services, ranging from design to development and even server administration</p>';
			// echo '<p>- We can help you with small customizations or even create a full website</p>';
			// echo '<p>- Spolehliv</p>';
			// echo '<p>- Donbra cena</p>';

			echo '<h1>What can we do for you?</h1>';
			echo '<div class="ark-studio-services-list">';
				echo '<div class="feature-section two-col">';
					echo '<div class="col">';
						echo ' <h3><i class="ark-studio-icon ff-font-simple-line-icons icon-pencil"></i> Customizations</h3>';
						echo '<p>We can help you with both small and large customizations. Every project is unique and sometimes requires professional custom work that you might not have the time or skills for.</p>';
					echo '</div>';
					echo '<div class="col">';
						echo ' <h3><i class="ark-studio-icon ff-font-simple-line-icons icon-cloud-upload"></i> Installation & Setup</h3>';
						echo '<p>We will install and set up The Ark theme directly on your web server. This way you can focus on content creation and leave the server side of things to professionals.</p>';
					echo '</div>';
					echo '<div class="col">';
						echo ' <h3><i class="ark-studio-icon ff-font-simple-line-icons icon-home"></i> Complete Websites</h3>';
						echo '<p>We will create a complete website for you, from start to finish, based on your requirements.</p>';
					echo '</div>';
					echo '<div class="col">';
						echo ' <h3><i class="ark-studio-icon ff-font-simple-line-icons icon-globe"></i> CDN Setup</h3>';
						echo '<p>We will set up CDN (Global Content Delivery) for your website to speed up loading times for your visitors from all geographical locations.</p>';
					echo '</div>';
					echo '<div class="col">';
						echo ' <h3><i class="ark-studio-icon ff-font-simple-line-icons icon-rocket"></i> Performance Optimization</h3>';
						echo '<p>We will set up caching and optimize your images to speed up loading times for your visitors.</p>';
					echo '</div>';
					echo '<div class="col">';
						echo ' <h3><i class="ark-studio-icon ff-font-simple-line-icons icon-plane"></i> Site Migration</h3>';
						echo '<p>We will take your old website and move it to a different domain/server.</p>';
					echo '</div>';
					echo '<div class="col">';
						echo ' <h3><i class="ark-studio-icon ff-font-simple-line-icons icon-equalizer"></i> Custom Features/Plugins</h3>';
						echo '<p>We can create new plugins/features that can be tailored to your needs.</p>';
					echo '</div>';
					echo '<div class="col">';
						echo ' <h3><i class="ark-studio-icon ff-font-simple-line-icons icon-question"></i> Special Requests</h3>';
						echo '<p>Had something else in mind? Feel free to get in touch and we will let you know how we can help.</p>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}



	protected function _requireAssets() {
		$themeBuilder = ffContainer()->getThemeFrameworkFactory()->getThemeBuilder();
		$themeBuilder->requireBuilderScriptsAndStyles();

//		$pluginUrl = ffPluginFreshMinificatorContainer::getInstance()->getPluginUrl();
//		$this->_getScriptEnqueuer()->addScript('ffAdminScreenMinificatorViewDefault', $pluginUrl .'/adminScreens/minificator/assets/adminScreen.js', array('jquery') );
		$this->_getStyleEnqueuer()->addStyleFramework('ff-hire-us', '/framework/themes/hireUs/style.css');
		$this->_getStyleEnqueuer()->addStyleFramework('ff-font-simple-line-icons-us', '/framework/extern/iconfonts/ff-font-simple-line-icons/ff-font-simple-line-icons.css');


       $this->_getStyleEnqueuer()->addStyleFramework('freshframework-font-awesome4-css', '/framework/extern/iconfonts/ff-font-awesome4/ff-font-awesome4.css');

//		$this->_getScriptEnqueuer()->addScriptFramework('ff-global-styles', '/framework/themes/globalStyles/script.js');
	}


	protected function _setDependencies() {

	}

}