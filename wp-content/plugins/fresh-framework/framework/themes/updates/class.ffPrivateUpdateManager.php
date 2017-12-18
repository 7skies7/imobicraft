<?php

class ffPrivateUpdateManager extends ffBasicObject {

/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
	/**
	 * @var ffPluginIdentificator
	 */
	private $_pluginIdentificator = null;

	/**
	 * @var ffThemeIdentificator
	 */
	private $_themeIdentificator = null;

	/**
	 * @var ffLicensing
	 */
	private $_licensing = null;

	/**
	 * @var ffFileSystem
	 */
	private $_fileSystem = null;

	/**
	 * @var ffHttp
	 */
	private $_http = null;

	/**
	 * @var ffUrlRewriter
	 */
	private $_urlRewriter = null;

	/**
	 * @var ffHttpAction
	 */
	private $_httpAction = null;

	/**
	 * @var ffDataStorage_WPOptions
	 */
	private $_wpOptions = null;

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/

//	private $_remoteUpdateInfoUrl = 'http://localhost/framework/licensing/?ff_http_action_trigger=1&ff_http_action_name=ff-license-api-hook-get-update-info';

	private $_remoteUpdateInfoUrl = 'http://update.freshcdn.net/?ff_http_action_trigger=1&ff_http_action_name=ff-license-api-hook-get-update-info';


	private $_timeUpdateInfoIsValidFor = null;

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
	public function __construct() {
		$this->_setPluginIdentificator( ffContainer()->getPluginIdentificator() );
		$this->_setThemeIdentificator( ffContainer()->getThemeIdentificator() );
		$this->_setLicensing( ffContainer()->getLicensing() );
		$this->_setFileSystem( ffContainer()->getFileSystem() );
		$this->_setHttp( ffContainer()->getHttp() );
		$this->_setUrlRewriter( ffContainer()->getUrlRewriter() );
		$this->_setHttpAction( ffContainer()->getHttpAction() );
		$this->_setWpOptions( ffContainer()->getDataStorageFactory()->createDataStorageWPOptions() );

		// 1 day
		$this->_setTimeUpdateInfoIsValidFor( 60 * 60 * 24 );
	}





/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
	public function areThereAnyUpdates() {
		$thingsNeedsToBeUpdated = $this->getListOfThingsWhichNeedsToBeUpdated();

		if( isset( $thingsNeedsToBeUpdated['has-updates']) ) {
			return $thingsNeedsToBeUpdated['has-updates'];
		} else {
			return false;
		}
	}

	public function getCacheTimeout() {
		$info = $this->_getUpdateInfoFromDatabase();


		if( isset( $info['cache_timeout'] ) ) {
			return $info['cache_timeout'];
		} else {
			return null;
		}
	}

	public function removeRemoteUpdateInfo() {
		$this->_deleteUpdateInfoInDatabase();
	}


	private function _generateInfo() {
		$info = array();
		$info['license'] = $this->_getLicensing()->getLicenseKey();
		$info['framework_version'] = ffContainer()->getWPLayer()->getFrameworkVersion();
		$info['url'] = $this->_getUrlRewriter()->reset()->getCurrentUrl();

		return $info;
	}

	public function getRemoteUpdateInfo( $forceCheck = false ) {
		$remoteInfo = ($forceCheck == true) ? null : $this->_getUpdateInfoFromDatabase();

		if( $remoteInfo == null ) {
			$remoteInfoJSON = $this->_getHttp()->getOnlyContentOfUrl( $this->_getRemoteUpdateInfoUrl(), $this->_generateInfo() );

			if( $remoteInfoJSON != null ) {
				$remoteInfoJSONDecoded = json_decode( $remoteInfoJSON, true );

				if( isset($remoteInfoJSONDecoded['status']) && $remoteInfoJSONDecoded['status'] == 'success') {
					$remoteInfo = $remoteInfoJSONDecoded;
					$remoteInfo['last-checked'] = time();

					$this->_setUpdateInfoToDatabase( $remoteInfo );
				}
			} else {
				$remoteInfo = $this->_getUpdateInfoFromDatabase();
				$remoteInfo['last-checked'] = time();

				$this->_setUpdateInfoToDatabase( $remoteInfo );
			}
		}

		return $remoteInfo;
	}

	public function updateCoreThings() {
//		$licensing = ffContainer()->getLicensing();
	}

	public function getLastChecked() {
		$remoteInfo = $this->getRemoteUpdateInfo();
		return $remoteInfo['last-checked'];
	}

	public function getListOfThingsWhichNeedsToBeUpdated() {
		$remoteUpdateInfo = $this->getRemoteUpdateInfo();

		if( !isset( $remoteUpdateInfo['needs-update'] ) ) {
			$foundPlugins = $this->_getUpdateableLocalPlugins();
			$foundThemes = $this->_getUpdateableLocalThemes();

			$toReturn = array();
			$toReturn['themes'] = $foundThemes;
			$toReturn['plugins'] = $foundPlugins;

			$hasUpdate = false;

			foreach( $toReturn['themes'] as $oneItem ) {
				if( isset($oneItem['need_update']) && $oneItem['need_update'] == true ) {
					$hasUpdate = true;
				}
			}

			foreach( $toReturn['plugins'] as $oneItem ) {
				if( isset($oneItem['need_update']) && $oneItem['need_update'] == true ) {
					$hasUpdate = true;
				}
			}

			$toReturn['has-updates'] = $hasUpdate;

			$remoteUpdateInfo['needs-update'] = $toReturn;

			$this->_setUpdateInfoToDatabase( $remoteUpdateInfo );
		} else {
			$toReturn = $remoteUpdateInfo['needs-update'];
		}

		return $toReturn;
	}

	public function downloadAndUnzipFile( $url, $license ) {
		@set_time_limit(999);
		$downloadUrlWithLicense = $this->_generateNewUrlWithLicense( $url, $license);
		$file = $this->_getHttp()->download( $downloadUrlWithLicense );


		if( $file instanceof WP_Error ) {
			var_dump( $file );
			return 'file cannot be downloaded';
		}

		if( $this->_getFileSystem()->getFilesize( $file ) < 1024) {
			$content = $this->_getFileSystem()->getContents( $file );

			$status = 'problem with downloading';
			if( strpos( $content, 'license-not-valid' ) !== false ) {
				$status = 'license not valid';
			}

			unlink( $file );
			return $status;
		}

		$upgradeDir = $this->_getFileSystem()->getDirUpgradeAndMakeSurItsWritable();

		$unzip = $this->_getFileSystem()->unzipFile( $file, $upgradeDir);

		if( $unzip == false ) {
			return 'file was downloaded, but cannot be unzipped';
		}

		return true;
	}

	public function updateUnzippedPlugin( $pluginName ) {
		@set_time_limit(999);
		$fs = $this->_getFileSystem();
		$pluginNewPath = $fs->getDirUpgrade($pluginName);

		if( !$fs->fileExists($pluginNewPath ) ) {
			return 'plugin does not exists in the path';
		}

		$pluginOldPath = $fs->getDirPlugins() . '/' . $pluginName;

		$fs->delete( $pluginOldPath, true);
		$result = $fs->move( $pluginNewPath,  $pluginOldPath);

		if ( $result ) {
			return true;
		} else {
			return false;
		}
	}

	public function updateUnzippedTheme( $themeName ) {
		@set_time_limit(999);
		$fs = $this->_getFileSystem();
		$themeNewPath = $fs->getDirUpgrade($themeName);
		echo 'Theme New Path is - ' . $themeNewPath;


		if( !$fs->fileExists($themeNewPath ) ) {
			return 'theme does not exists in the path';
		}
		echo 'File Exists';


		$themeOldPath = $fs->getDirThemes() . '/' . $themeName;
		echo 'Theme Old Path = ' . $themeOldPath;


		$result = $fs->delete( $themeOldPath, true);
		echo 'Deleting Old theme - result:';
		var_dump( $result );

		$result = $fs->move( $themeNewPath,  $themeOldPath);
		echo 'Moving new theme - result:';
		var_dump( $result );
		if ( $result ) {
			return true;
		} else {
			return false;
		}

	}



/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/
/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
	private function _setUpdateInfoToDatabase( $updateInfo ) {
		$this->_getWpOptions()->setOptionJSON( 'ff_framework', 'updateInfo', $updateInfo );
	}

	private function _deleteUpdateInfoInDatabase() {
		$this->_getWpOptions()->deleteOption('ff_framework', 'updateInfo');
	}

	private function _getUpdateInfoFromDatabase() {
		$updateInfo = $this->_getWpOptions()->getOptionJSON('ff_framework', 'updateInfo', array('last-checked'=>0) );

		// not valid info anymore
		if( !isset( $updateInfo['last-checked'] ) || ($updateInfo['last-checked'] + $this->_getTimeUpdateInfoIsValidFor() )  < time() ) {
			$this->_getWpOptions()->deleteOption( 'ff_framework', 'updateInfo' );
			return null;
		}

		return $updateInfo;
	}


	private function _generateNewUrlWithLicense( $urlWithoutLicense, $license ) {
		$params = array( 'license'=> $license );

		return $this->_getUrlRewriter()->reset()->setUrl( $urlWithoutLicense)->addQueryParameter('license', $license)->getNewUrl();

//		return $this->_getHttpAction()->generateActionUrl($urlWithoutLicense, $params, '');
	}


	private function _getUpdateableLocalThemes() {
		$remoteThemeInfo = $this->getRemoteUpdateInfo();
		$localThemeInfo = $this->_getThemeIdentificator()->getAllThemesInfo();

		$foundThemes = array();

		if( !isset( $remoteThemeInfo['files'] )  || !is_array( $remoteThemeInfo['files'] ) ) {
			$remoteThemeInfo['files'] = array();
		}


		foreach( $remoteThemeInfo['files'] as $remoteOneThemeName => $remoteOneThemeInfo ) {
			if( $remoteOneThemeInfo['type'] == 'plugin' ) {
				continue;
			}

			$remoteOneNameWithPrefix = 't-' . $remoteOneThemeName;

			if( isset( $localThemeInfo[ $remoteOneThemeName ] )  ) {
				$newThemeInfo = $localThemeInfo[ $remoteOneThemeName ];
			} else if( isset( $localThemeInfo[ $remoteOneNameWithPrefix ] ) ) {
				$newThemeInfo = $localThemeInfo[ $remoteOneNameWithPrefix ];
			} else {
				continue;
			}

			/**
			 * @var $newThemeInfo WP_Theme
			 */

			
			$newThemeArray['Name'] = $newThemeInfo->get('Name');
			$newThemeArray['Version'] = $newThemeInfo->get('Version');

			$newThemeArray['remote_name'] = $remoteOneThemeName;
			$newThemeArray['remote_version'] = $remoteOneThemeInfo['version'];
			$newThemeArray['remote_download_url'] = $remoteOneThemeInfo['downloadUrl'];

			$newThemeArray['need_update']= version_compare( $newThemeInfo->get('Version'), $newThemeArray['remote_version'], '<' );
//
			$foundThemes[ $newThemeArray['remote_name'] ] = $newThemeArray;
		}

		return $foundThemes;
	}

	private function _getUpdateableLocalPlugins() {
		$localPluginInfo = $this->_getPluginIdentificator()->getAllPluginInfo();
		$remotePluginInfo = $this->getRemoteUpdateInfo();

		$foundPlugins = array();

		foreach( $localPluginInfo as $oneLocalPluginName => $oneLocalPluginInfo ) {

			if( !isset( $remotePluginInfo['files'] )  || !is_array( $remotePluginInfo['files'] ) ) {
				$remotePluginInfo['files'] = array();
			}

			foreach( $remotePluginInfo['files'] as $oneRemotePluginName => $oneRemotePluginInfo ) {

				if( $oneRemotePluginInfo['type'] == 'theme' ) {
					continue;
				}

				if( strpos( $oneLocalPluginName, $oneRemotePluginName ) !== false ) {
					$newPluginInfo = $oneLocalPluginInfo;
					$newPluginInfo['remote_name'] = $oneRemotePluginName;
					$newPluginInfo['remote_version'] = $oneRemotePluginInfo['version'];
					$newPluginInfo['remote_download_url'] = $oneRemotePluginInfo['downloadUrl'];

					$newPluginInfo['need_update'] = version_compare( $newPluginInfo['Version'], $newPluginInfo['remote_version'], '<' );

					$foundPlugins[ $newPluginInfo['remote_name'] ] = $newPluginInfo;
				}
			}
		}

		return $foundPlugins;
	}

/**********************************************************************************************************************/
/* ABSTRACT FUNCTIONS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
	/**
	 * @return ffPluginIdentificator
	 */
	private function _getPluginIdentificator() {
		return $this->_pluginIdentificator;
	}

	/**
	 * @param ffPluginIdentificator $pluginIdentificator
	 */
	private function _setPluginIdentificator($pluginIdentificator) {
		$this->_pluginIdentificator = $pluginIdentificator;
	}

	/**
	 * @return ffThemeIdentificator
	 */
	private function _getThemeIdentificator() {
		return $this->_themeIdentificator;
	}

	/**
	 * @param ffThemeIdentificator $themeIdentificator
	 */
	private function _setThemeIdentificator($themeIdentificator) {
		$this->_themeIdentificator = $themeIdentificator;
	}

	/**
	 * @return ffLicensing
	 */
	private function _getLicensing() {
		return $this->_licensing;
	}

	/**
	 * @param ffLicensing $licensing
	 */
	private function _setLicensing($licensing) {
		$this->_licensing = $licensing;
	}

	/**
	 * @return ffFileSystem
	 */
	private function _getFileSystem() {
		return $this->_fileSystem;
	}

	/**
	 * @param ffFileSystem $fileSystem
	 */
	private function _setFileSystem($fileSystem) {
		$this->_fileSystem = $fileSystem;
	}

	/**
	 * @return ffHttp
	 */
	private function _getHttp() {
		return $this->_http;
	}

	/**
	 * @param ffHttp $http
	 */
	private function _setHttp($http) {
		$this->_http = $http;
	}

	/**
	 * @return ffUrlRewriter
	 */
	private function _getUrlRewriter() {
		return $this->_urlRewriter;
	}

	/**
	 * @param ffUrlRewriter $urlRewriter
	 */
	private function _setUrlRewriter($urlRewriter) {
		$this->_urlRewriter = $urlRewriter;
	}

	/**
	 * @return ffHttpAction
	 */
	private function _getHttpAction() {
		return $this->_httpAction;
	}

	/**
	 * @param ffHttpAction $httpAction
	 */
	private function _setHttpAction($httpAction) {
		$this->_httpAction = $httpAction;
	}

	/**
	 * @return ffDataStorage_WPOptions
	 */
	private function _getWpOptions() {
		return $this->_wpOptions;
	}

	/**
	 * @param ffDataStorage_WPOptions $wpOptions
	 */
	private function _setWpOptions($wpOptions) {
		$this->_wpOptions = $wpOptions;
	}

	/**
	 * @return null
	 */
	private function _getTimeUpdateInfoIsValidFor() {
		return $this->_timeUpdateInfoIsValidFor;
	}

	/**
	 * @param null $timeUpdateInfoIsValidFor
	 */
	private function _setTimeUpdateInfoIsValidFor($timeUpdateInfoIsValidFor) {
		$this->_timeUpdateInfoIsValidFor = $timeUpdateInfoIsValidFor;
	}

	/**
	 * @return string
	 */
	private function _getRemoteUpdateInfoUrl() {
		return $this->_remoteUpdateInfoUrl;
	}

	/**
	 * @param string $remoteUpdateInfoUrl
	 */
	private function _setRemoteUpdateInfoUrl($remoteUpdateInfoUrl) {
		$this->_remoteUpdateInfoUrl = $remoteUpdateInfoUrl;
	}




}