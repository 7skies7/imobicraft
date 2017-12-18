<?php

class ffThemeFrameworkFactory extends ffFactoryAbstract {

    private $_themeAssetsIncluder = null;


    public function getThemeAssetsIncluder() {
        if( $this->_getClassloader()->classRegistered('ffThemeAssetsIncluder') ) {
            if( $this->_themeAssetsIncluder == null ) {

                $this->_getClassloader()->loadClass('ffThemeAssetsIncluderAbstract');
                $this->_getClassloader()->loadClass('ffThemeAssetsIncluder');

                $this->_getClassloader()->loadClass('ffThemeAssetsManager');

                $container = ffContainer::getInstance();

                 $this->_themeAssetsIncluder = new ffThemeAssetsIncluder( $container->getStyleEnqueuer(), $container->getScriptEnqueuer(), $container->getLessWPOptionsManager() );
            }
            return $this->_themeAssetsIncluder;
        }
        return null;
    }

	private $_adminConsole = null;

	public function getAdminConsole() {
		if( $this->_adminConsole == null ) {
			$this->_adminConsole = new ffAdminConsole( ffContainer()->getWPLayer() );
		}

		return $this->_adminConsole;
	}

    public function getExternalPluginsTweaker() {
        $this->_getClassloader()->loadClass('ffExternalPluginsTweaker');
        $container = ffContainer();
        $pluginsTweaker = new ffExternalPluginsTweakers( $container->getWPLayer() );

        return $pluginsTweaker;
    }

	public function getThemeAssetsManager() {

		if( $this->_getClassloader()->classRegistered('ffThemeAssetsIncluder') ) {

			$this->_getClassloader()->loadClass('ffThemeAssetsIncluderAbstract');
			$this->_getClassloader()->loadClass('ffThemeAssetsIncluder');

			$this->_getClassloader()->loadClass('ffThemeAssetsManager');

			$container = ffContainer::getInstance();

            $themeAssetsIncluder = $this->getThemeAssetsIncluder();
			$themeAssetsManager = new ffThemeAssetsManager( $themeAssetsIncluder, $container->getWPLayer() );

			return $themeAssetsManager;
		}

		return null;
	}

	private $_systemEnvironment = null;

	public function getSystemEnvironment() {
		if( $this->_systemEnvironment == null ) {
			$this->_systemEnvironment = new ffSystemEnvironment();
		}

		return $this->_systemEnvironment;
	}




    private $_themeOnePageManager = null;

    public function getThemeOnePageManager() {
        if( $this->_themeOnePageManager == null ) {
            $this->_getClassloader()->loadClass('ffThemeOnePageManager');

            $this->_themeOnePageManager = new ffThemeOnePageManager();
        }

        return $this->_themeOnePageManager;
    }


    private $_layoutsNamespaceFactory = null;

    public function getLayoutsNamespaceFactory() {
        if( $this->_layoutsNamespaceFactory == null ) {
            $this->_getClassloader()->loadClass('ffLayoutsNamespaceFactory');

            $this->_layoutsNamespaceFactory = new ffLayoutsNamespaceFactory( $this->_getClassloader() );
        }

        return $this->_layoutsNamespaceFactory;
    }



	public function getVideoIncluder() {
		$this->_getClassloader()->loadClass('ffVideoIncluder');

		$videoIncluder = new ffVideoIncluder();

		return $videoIncluder;
	}

	public function getPaginationComputer() {
		$this->_getClassloader()->loadClass('ffPaginationComputer');

		$pagnationComputer = new ffPaginationComputer();

		return $pagnationComputer;
	}

	public function getPaginationWPLoop() {
		$this->_getClassloader()->loadClass('ffPaginationWPLoop');

		$container = ffContainer::getInstance();

		$paginationWPLoop = new ffPaginationWPLoop( $container->getWPLayer(), $this->getPaginationComputer() );

		return $paginationWPLoop;
	}

	public function getThemeViewIdentificator() {
		$this->_getClassloader()->loadClass('ffThemeViewIdentificator');

		$container = ffContainer::getInstance();

		$themeViewIdentificator = new ffThemeViewIdentificator( $container->getWPLayer() );

		return $themeViewIdentificator;
	}

	public function getSocialFeedCreator( $links = null ) {
		$this->_getClassloader()->loadClass('ffSocialFeedCreator');

		$socialFeedCreator = new ffSocialFeedCreator( $links );

		return $socialFeedCreator;
	}

	public function getSocialSharerFeedCreator( $links = null ) {
		$this->_getClassloader()->loadClass('ffSocialSharerFeedCreator');

		$container = ffContainer::getInstance();

		$socialSharerFeedCreator = new ffSocialSharerFeedCreator( $container->getWPLayer() );

		return $socialSharerFeedCreator;
	}

	private $_postMetaGetter = null;

	public function getPostMetaGetter( $callThePost = true) {
		if( $this->_postMetaGetter == null ) {
			$this->_getClassloader()->loadClass('ffPostMetaGetter');
			$container = ffContainer::getInstance();
			$this->_postMetaGetter = new ffPostMetaGetter( $container->getWPLayer(), $callThePost );
		}
		return $this->_postMetaGetter;

	}

    public function getCommentsFormPrinter() {
        $this->_getClassloader()->loadClass('ffCommentsFormPrinter');

        $commentsFormPrinter = new ffCommentsFormPrinter( ffContainer()->getWPLayer() );

        return $commentsFormPrinter;
    }

    private $_menuOptionsManager = null;

    public function getMenuOptionsManager() {
        if( $this->_menuOptionsManager == null ) {
            $this->_getClassloader()->loadClass('ffMenuOptionsManager');

            $fwc = ffContainer();

            $this->_menuOptionsManager = new ffMenuOptionsManager(
                $fwc->getWPLayer(),
                $fwc->getOptionsFactory(),
                $fwc->getScriptEnqueuer(),
                $fwc->getDataStorageFactory()->createDataStorageOptionsPostType_NamespaceFacade(),
                $fwc->getRequest(),
                $fwc->getModalWindowFactory()
            );
        }

        return $this->_menuOptionsManager;
    }

    private $_menuJavascriptSaver = null;

    public function getMenuJavascriptSaver() {
        if( $this->_menuJavascriptSaver == null ) {
            $fwc = ffContainer();

            $fwc->getClassLoader()->loadClass('ffMenuJavascriptSaver');
            $this->_menuJavascriptSaver = new ffMenuJavascriptSaver($fwc->getScriptEnqueuer(), $fwc->getRequest());
        }

        return $this->_menuJavascriptSaver;

    }


    private $_themeBuilderManager = null;

    public function getThemeBuilderManager() {
        if( $this->_themeBuilderManager == null ) {
            $this->_getClassloader()->loadClass('ffThemeBuilderManager');

            $this->_themeBuilderManager = new ffThemeBuilderManager();
        }

        return $this->_themeBuilderManager;
    }

	private $_themeBuilderCache = null;
	public function getThemeBuilderCache() {
		if( $this->_themeBuilderCache == null ) {
			$this->_themeBuilderCache = new ffThemeBuilderCache( ffContainer()->getWPLayer(), ffContainer()->getDataStorageCache() );
		}

		return $this->_themeBuilderCache;
	}

	private $_themeBuilder = null;

	public function getThemeBuilder() {
		if( $this->_themeBuilder == null ) {
			$this->_themeBuilder = new ffThemeBuilder();
		}

		return $this->_themeBuilder;
	}

	public function getThemeBuilderAssetsRenderer() {
		$cl = $this->_getClassloader();

		$cl->loadClass('ffThemeBuilderCssRule');
		$cl->loadClass('ffThemeBuilderCssRuleFactory');

		$cl->loadClass('ffThemeBuilderJavascriptCode');
		$cl->loadClass('ffThemeBuilderJavascriptCodeFactory');

		$cl->loadClass('ffThemeBuilderAssetsRenderer');

		$assetsRenderer = new ffThemeBuilderAssetsRenderer(
			new ffThemeBuilderCssRuleFactory( $this->_getClassloader() ),
			ffContainer()->createNewCollection(),
			new ffThemeBuilderJavascriptCodeFactory( $cl ),
			ffContainer()->createNewCollection()
		);

		return $assetsRenderer;
	}

	private $_themeBuilderColorLibrary = null;

	public function getThemeBuilderColorLibrary() {
		if( $this->_themeBuilderColorLibrary == null ) {
			$this->_getClassloader()->loadClass('ffThemeBuilderColorLibrary');

			$this->_themeBuilderColorLibrary = new ffThemeBuilderColorLibrary();
		}

		return $this->_themeBuilderColorLibrary;
	}

	private $_themeBuilderGlobalStyles = null;

	public function getThemeBuilderGlobalStyles() {
		if( $this->_themeBuilderGlobalStyles == null ) {
			$this->_themeBuilderGlobalStyles = new ffThemeBuilderGlobalStyles( ffContainer()->getWPLayer(),
				ffContainer()->getEnvironment(),
				ffContainer()->getDataStorageFactory()->createDataStorageWPOptionsNamespace()
			);
		}

		return $this->_themeBuilderGlobalStyles;
	}


    private $_themeBuilderElementManager = null;

    public function getThemeBuilderElementManager() {
        if( $this->_themeBuilderElementManager == null ) {
            $this->_getClassloader()->loadClass('ffThemeBuilderElementManager');
            $this->_getClassloader()->loadClass('ffThemeBuilderElementFactory');

	        $this->_getClassloader()->loadClass('ffThemeBuilderShortcodesStatusHolder');

	        $statusHolder = new ffThemeBuilderShortcodesStatusHolder();

	        $elementFactory = new ffThemeBuilderElementFactory( $this->_getClassloader());
	        $elementFactory->setStatusHolder( $statusHolder );

            $this->_themeBuilderElementManager = new ffThemeBuilderElementManager(
                ffContainer()->createNewCollection(),
                ffContainer()->createNewCollection(),
                $elementFactory,
	            $statusHolder,
	            $this->getThemeBuilderColorLibrary()
            );
        }

        return $this->_themeBuilderElementManager;
    }

	private $_themeBuilderSectionManager = null;

	/**
	 * @return ffThemeBuilderSectionManager
	 */
	public function getThemeBuilderSectionManager() {
		if( $this->_themeBuilderSectionManager == null ) {
			$this->_themeBuilderSectionManager = new ffThemeBuilderSectionManager();
		}

		return $this->_themeBuilderSectionManager;
	}


    private $_themeBuilderShortcodesWalker = null;

    public function getThemeBuilderShortcodesWalker() {
        if( $this->_themeBuilderShortcodesWalker == null ) {
	        $this->_getClassloader()->loadClass('ffThemeBuilderShortcodesWalker');


            $this->_themeBuilderShortcodesWalker = new ffThemeBuilderShortcodesWalker(
                $this->getThemeBuilderElementManager(),
	            ffContainer()->createNewCollection(),
	            ffContainer()->createNewCollection()
            );
        }

        return $this->_themeBuilderShortcodesWalker;
    }


	private $_themeBuilderDeveloperTools = null;
	public function getThemeBuilderDeveloperTools() {
		if( $this->_themeBuilderDeveloperTools == null ) {
			$this->_getClassloader()->loadClass('ffThemeBuilderDeveloperTools');

			$this->_themeBuilderDeveloperTools = new ffThemeBuilderDeveloperTools(

				ffContainer()->getWPLayer()

			);
		}

		return $this->_themeBuilderDeveloperTools;
	}

	/**
	 * @var ffThemeBuilderBlockManager
	 */
	private $_themeBuilderBlockManager = null;

	public function getThemeBuilderBlockManager() {
		if( $this->_themeBuilderBlockManager == null ) {
			$this->_getClassloader()->loadClass('ffThemeBuilderBlockManager');
			$this->_themeBuilderBlockManager = new ffThemeBuilderBlockManager();
		}

		return $this->_themeBuilderBlockManager;
	}

    public function getThemeBuilderBlockFactory() {
	    $this->_getClassloader()->loadClass('ffThemeBuilderBlock');
	    $this->_getClassloader()->loadClass('ffThemeBuilderBlockBasic');
        $this->_getClassloader()->loadClass('ffThemeBuilderBlockFactory');

        return new ffThemeBuilderBlockFactory( $this->_getClassloader() );
    }

	public function getThemeBuilderRegexp() {
		$this->_getClassloader()->loadClass('ffThemeBuilderRegexp');

		return new ffThemeBuilderRegexp();
	}

	/**
	 * @var ffDummyContentManager
	 */
	private $_dummyContentManager = null;
	public function getDummyContentManager() {
		if( $this->_dummyContentManager == null ) {
			$this->_getClassloader()->loadClass('ffDummyContentManager');
			$this->_dummyContentManager = new ffDummyContentManager(
				ffContainer()->getDataStorageFactory()->createDataStorageWPOptionsNamespace(),
				ffContainer()->getWPLayer()
			);
		}

		return $this->_dummyContentManager;
	}


	public function getImportManager() {
		$cl = $this->_getClassloader();
		$cl->loadClass('wordpress-importer');
		$cl->loadClass('ffWPImporter');
		$cl->loadClass('ffImportManager');

		$cl->loadClass('ffImportStepBasic');
		$cl->loadClass('ffImportRuleBasic');
		$cl->loadClass('ffImportRuleFactory');

		$factory = new ffImportRuleFactory( $cl );

		$wpImporter = new ffWPImporter();
		$importManager = new ffImportManager(
			$wpImporter,
			ffContainer()->getFileSystem(),
			$factory,
			$this->getDummyContentManager()
		);

		return $importManager;
	}

	private $_privateUpdateManager = null;

	public function getPrivateUpdateManager() {
		if( $this->_privateUpdateManager == null ) {
			$this->_privateUpdateManager = new ffPrivateUpdateManager();
		}

		return $this->_privateUpdateManager;
	}

	private $_sitePreferencesFactory = null;

	public function getSitePreferencesFactory() {
		if( $this->_sitePreferencesFactory == null ) {
			$this->_sitePreferencesFactory = new ffSitePreferencesFactory( $this->_getClassloader() );
		}

		return $this->_sitePreferencesFactory;
	}
}