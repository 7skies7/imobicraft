<?php

class ffPluginArkCore extends ffPluginAbstract {
	/**
	 *
	 * @var ffPluginArkCoreContainer
	 */
	protected $_container = null;

	protected function _registerAssets() {

	}

	protected function _run() {

		define ('FF_ARK_CORE_PLUGIN_ACTIVE', true);
		define ('FF_ARK_CORE_PLUGIN_DIR', $this->_getContainer()->getPluginDir() );
		define ('FF_ARK_CORE_PLUGIN_URL', $this->_getContainer()->getPluginUrl() );

		require dirname( dirname( __FILE__ ) ).'/components/vc_shortcodes/vc_ark_shortcodes.php';



		$sysEnv = ffContainer()->getThemeFrameworkFactory()->getSystemEnvironment();
		$sysEnv->enableThemeBuilder( array('post', 'page', 'portfolio', 'product'), ffPluginArkCoreContainer::getInstance()->getElementsCollection() );

		add_action('after_setup_theme', array( $this, 'registerCustomPostTypes' ) );

		$shortcodeManager = $this->_getContainer()->getFrameworkContainer()->getShortcodesNamespaceFactory()->getShortcodeManager();
		$shortcodeManager->addShortcodeClassName('ffShortcodeDropcap');
		$shortcodeManager->addShortcodeClassName('ffShortcodeTemplate');

		$this->_handleBuilderForNonArk();
	}

	private function _handleBuilderForNonArk() {
		$fwc = ffContainer();
		$WPLayer = $fwc->getWPLayer();

		if( $WPLayer->isArkTheme() ) {
			return;
		}


		$WPLayer->add_filter('the_content', array($this, 'actContentBuilderNonArk' ), 1 );
	}

	public function actContentBuilderNonArk( $content ) {

		$themeBuilderManager = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderManager();
		$content = $themeBuilderManager->renderButNotPrint( $content );

		return $content;


//		var_dump( func_get_args() );
//		die();
	}


	public function registerCustomPostTypes() {
		$portfolioSlug = 'ff-portfolio';
		$portfolioTagSlug = 'ff-portfolio-tag';
		$portfolioCategorySlug = 'ff-portfolio-category';
		$disablePortfolioArchive = false;

		if( class_exists('ffThemeOptions') ) {

			$portfolioSlug = ffThemeOptions::getQuery('portfolio portfolio_slug' );
			$portfolioTagSlug = ffThemeOptions::getQuery('portfolio portfolio_tag_slug' );
			$portfolioCategorySlug = ffThemeOptions::getQuery('portfolio portfolio_category_slug' );
			$disablePortfolioArchive = ffThemeOptions::getQuery('portfolio disable_portfolio_post_archive' );

		}

		$fwc = $this->_getContainer()->getFrameworkContainer();

		// Portfolio - Custom Post Type
		$ptPortfolio = $fwc->getPostTypeRegistratorManager()
			->addPostTypeRegistrator('portfolio', __('Portfolio', 'ark-core' ));

		$ptPortfolio->getSupports()
			->set('editor', true)
			->set('excerpt', false);

		if( $disablePortfolioArchive ) {
			$ptPortfolio->getArgs()
				->set('has_archive', false);
		}

		// var_dump(ffThemeOptions::getQuery('portfolio portfolio_slug' ));exit;
		$ptPortfolio->getArgs()->set('rewrite', array( 'slug' => $portfolioSlug ));

		// Portfolio Tag - Custom Taxonomy
		$taxPortfolioTag = $fwc->getCustomTaxonomyManager()
			->addCustomTaxonomy('ff-portfolio-tag', __('Portfolio Tag', 'ark-core' ));
		$taxPortfolioTag->connectToPostType( 'portfolio' );

		$taxPortfolioTag->getArgs()->set('rewrite', array( 'slug' => $portfolioTagSlug ));

		// Portfolio Category - Custom Taxonomy
		$taxPortfolioCategory = $fwc->getCustomTaxonomyManager()
			->addCustomTaxonomy('ff-portfolio-category', __('Portfolio Category', 'ark-core' ));
		$taxPortfolioCategory->setCategoryBehaviour();
		$taxPortfolioCategory->connectToPostType('portfolio');

		$taxPortfolioCategory->getArgs()->set('rewrite', array( 'slug' => $portfolioCategorySlug));


		/*----------------------------------------------------------*/
		/* Form Submits
		/*----------------------------------------------------------*/



	}

	protected function _registerActions() {

	}

	protected function _setDependencies() {

	}


	/**
	 * @return ffPluginArkCoreContainer
	 */
	protected function _getContainer() {
		return $this->_container;
	}
}