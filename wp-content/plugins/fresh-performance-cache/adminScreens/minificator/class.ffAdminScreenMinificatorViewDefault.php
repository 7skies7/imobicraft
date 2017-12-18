<?php
class ffAdminScreenMinificatorViewDefault extends ffAdminScreenView {
	const HTACCESS_OPTION_NAME = 'FRESH-MINIFICATOR';
	
	
	public function ajaxRequest( ffAdminScreenAjax $ajax ) {
		if( $ajax->data['action'] == 'delete_cache' ) {
			ffContainer::getInstance()->getDataStorageCache()->deleteNamespace('assetsmin');
		} else if( $ajax->data['action'] == 'flush_data' ) {
			$dataStorage = ffContainer::getInstance()->getDataStorageFactory()->createDataStorageWPOptionsNamespace('minificator');
			$dataStorage->deleteOption('watched_scripts_header');
			$dataStorage->deleteOption('watched_scripts_footer');
			$dataStorage->deleteOption('watched_styles_header');
		} else if( $ajax->data['action'] == 'refresh_data' ) {
			$dataStorage = ffContainer::getInstance()->getDataStorageFactory()->createDataStorageWPOptionsNamespace('minificator');
			$watchedScriptsHeader = $dataStorage->getOption('watched_scripts_header');
			$watchedScriptsFooter = $dataStorage->getOption('watched_scripts_footer');
			$watchedStylesHeader = $dataStorage->getOption('watched_styles_header');
			
			$bannedHandlesScripts = $dataStorage->getOption('banned_handles_scripts');
			$bannedHandlesStyles = $dataStorage->getOption('banned_handles_styles');
			
			
			
			$printerHeaderScripts = $this->_getWatchedItemsPrinter('header_scripts', $watchedScriptsHeader, $bannedHandlesScripts, 'Exclude these Header Scripts');
			$printerFooterScripts=  $this->_getWatchedItemsPrinter('footer_scripts', $watchedScriptsFooter, $bannedHandlesScripts, 'Exclude these Footer Scripts');
			$printerHeaderStyles =  $this->_getWatchedItemsPrinter('header_styles', $watchedStylesHeader, $bannedHandlesStyles , 'Exclude these Header Styles');
			
			$printerHeaderStyles->walk();
			$printerHeaderScripts->walk();
			$printerFooterScripts->walk();
		}
		
		
	}
	
	
	private function _selectExcludingScripts() {
		
		$c = ffContainer::getInstance();
		$dataStorage = $c->getDataStorageFactory()->createDataStorageWPOptionsNamespace('minificator');
		
		if( !isset( $_POST['minificator_exclude']['header_scripts'] ) ) {
			return;
		}

		$excludedScriptsHeader = array();
		foreach( $_POST['minificator_exclude']['header_scripts'] as $scriptName => $hasBeenExcluded ) {
			$scriptNameClean = str_replace('exclude_script_','', $scriptName );
			
			if( $hasBeenExcluded ) {

				if( !is_array( $excludedScriptsHeader ) ) {
					$excludedScriptsHeader = array();
				} 
				
				if( !in_array( $scriptNameClean, $excludedScriptsHeader) ) {
					$excludedScriptsHeader[] = $scriptNameClean;
					
				}
				
				
			}
		}
		
		$dataStorage->setOption('excluded_scripts_header', $excludedScriptsHeader);
	}
	
	private function _getWatchedItemsPrinter( $name, $watchedItems, $itemsDisabled, $description ) {
		
		if( $itemsDisabled == null ) {
			$itemsDisabled = array();
		}
		
		$wpLayer = ffContainer::getInstance()->getWPLayer();
		
		$s = ffContainer::getInstance()->getOptionsFactory()->createStructure($name);
		
		$s->startSection( $name );
			$s->addElement( ffOneElement::TYPE_TABLE_START )->addParam('class', 'ff-exclusion');
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START,'', $description);
				if( !empty( $watchedItems ) ) {		
				foreach( $watchedItems as $itemHandle => $itemUrl ) {
					$value = 0;
					
					
					if( in_array( $itemHandle, $itemsDisabled ) ) {
						
						$value = 1;
					}
					$itemUrlRelative = str_replace( $wpLayer->get_site_url(), '', $itemUrl );
					
					$title = '';
					if( !empty( $itemUrlRelative ) ) {
						$title .= '<code>'.$itemUrlRelative.'</code>&nbsp;&nbsp;';
					}
					$title .= '<span class="description">'.$itemHandle.'</span>';
					
					$s->addOption(ffOneOption::TYPE_CHECKBOX, 'exclude_item_'.$itemHandle, $title, $value, '');//$itemHandle .' => ' .$itemUrlRelative, $value, '');
					$s->addElement( ffOneElement::TYPE_NEW_LINE );
				}
				}
		
			
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
		
			$s->addElement(ffOneElement::TYPE_TABLE_END);
		
		$s->endSection();
		
		$printer = ffContainer::getInstance()->getOptionsFactory()->createOptionsPrinter( array(), $s );
		$printer->setNameprefix($name);
		return $printer;
	}
	
	
	
	protected function _saveForm( $data, $optionName ) {
		$c = ffContainer::getInstance();
		$dataStorage = $c->getDataStorageFactory()->createDataStorageWPOptionsNamespace('minificator');
		
		foreach( $data as $name => $value ) {
			$nameClean = str_replace('exclude_item_','', $name );
			
			if( $value == 1 ) {
				//echo $nameClean;
				//$dataNew[] = $name;
				$dataStorage->addToOption($optionName, $nameClean );
			}
		}
		
		
	}
	
	private function _createFlushDataPrinter() {
		$name = 'flush_data';
		$s = ffContainer::getInstance()->getOptionsFactory()->createStructure($name);
		$dataStorage = ffContainer::getInstance()->getDataStorageFactory()->createDataStorageWPOptionsNamespace('minificator');
	
		
		$s->startSection( $name );
		$s->addElement( ffOneElement::TYPE_HEADING,'','Exclude Assets');
		$s->addElement( ffOneElement::TYPE_PARAGRAPH,'','Here you can exclude some of the styles and scripts from being processed. Start by enabling the Exclusion feature below.');
		
		
		
		
		
		$s->addElement( ffOneElement::TYPE_TABLE_START );
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START,'', 'General');
		$s->addOption(ffOneOption::TYPE_CHECKBOX, 'enable_exclusion', 'Enable Exclusion', $dataStorage->getOption('enable_exclusion'), '')->addParam('class', 'ff-enable-exclusion');
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
		
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START,'', 'Assets List')->addParam('class', 'ff-exclusion');
	

			$s->addElement( ffOneElement::TYPE_BUTTON, 'ff_flush_data', 'Clear Assets List' );
			$s->addElement( ffOneElement::TYPE_HTML, '', ' ' );
			$s->addElement( ffOneElement::TYPE_BUTTON, 'ff_refresh_data', 'Refresh Assets List' );
			$s->addElement( ffOneElement::TYPE_NEW_LINE );
			$s->addElement( ffOneElement::TYPE_NEW_LINE );
			$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'Below is a list of assets. If your list is short or empty, you need to visit your website and browse around so we can pick up what styles and scripts are being loaded. When you are done browsing, press the &lsquo;Refresh Assets List&rsquo; button above.' );
		
			
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
		
		$s->addElement(ffOneElement::TYPE_TABLE_END);
		
		$s->endSection();
		
		$printer = ffContainer::getInstance()->getOptionsFactory()->createOptionsPrinter( array(), $s );
		$printer->setNameprefix($name);
		return $printer;
	}
	
	private function _getHtaccessSectionContent() {
		$content = '';
		$content .= '### Headers gzip, expires'."\n";
		$content .= '<IfModule mod_headers.c>'."\n";
		$content .= '<filesMatch .*\.(jpg|jpeg|png|gif|ico|js|css)(\.gz)?$>'."\n";
		$content .= 'Header append Cache-Control "public"'."\n";
		$content .= 'Header append Expires "A604800"'."\n";
		$content .= '</filesMatch>'."\n";
		
		$content .= 'Header unset Accept-Ranges'."\n";
		$content .= 'Header unset ETag'."\n";
		$content .= 'Header unset Link'."\n";
		$content .= 'Header unset Pragma'."\n";
		$content .= 'Header unset Transfer-Encoding'."\n";
		$content .= 'Header unset X-Pingback'."\n";
		$content .= 'Header append Vary Accept-Encoding'."\n";
		
		$content .= 'RewriteCond %{HTTP:Accept-encoding} gzip'."\n";
		$content .= 'RewriteCond %{REQUEST_FILENAME}.gz -f'."\n";
		$content .= 'RewriteRule ^(.*)$ $1.gz [L]'."\n";
		
		$content .= '<FilesMatch .*\.gz$>'."\n";
		$content .= 'Header set Content-Encoding: gzip'."\n";
		$content .= '</FilesMatch>'."\n";
		$content .= '<FilesMatch .*\.css.gz$>'."\n";
		$content .= 'ForceType text/css'."\n";
		$content .= '</FilesMatch>'."\n";
		$content .= '<FilesMatch .*\.html?.gz$>'."\n";
		$content .= 'ForceType text/html'."\n";
		$content .= 'Header unset Expires'."\n";
		$content .= '</FilesMatch>'."\n";
		$content .= '<FilesMatch .*\.js.gz$>'."\n";
		$content .= '# Works in IE8 and older but obsolete - today standart = application/javascript'."\n";
		$content .= 'ForceType text/javascript'."\n";
		$content .= '</FilesMatch>'."\n";
		$content .= '<FilesMatch .*\.xml.gz$>'."\n";
		$content .= 'ForceType text/xml'."\n";
		$content .= '</FilesMatch>'."\n";
		$content .= '<FilesMatch .*\.txt.gz$>'."\n";
		$content .= 'ForceType text/plain'."\n";
		$content .= '</FilesMatch>'."\n";
		$content .= '</IfModule>'."\n";
		
		return $content;
	}
	
	private function _createEnableGzip( $value ) {
		$name = 'enable_gzip';
		
		$cache = ffContainer::getInstance()->getDataStorageCache();
		
		$numberOfCachedItems = $cache->getNumberOfOptionsInNamespace('assetsmin');
		
		$s = ffContainer::getInstance()->getOptionsFactory()->createStructure($name);
		
		$s->startSection( $name );
		$s->addElement( ffOneElement::TYPE_TABLE_START );
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START,'', 'Enable gzip');
		
		$s->addOption(ffOneOption::TYPE_CHECKBOX, 'enable_gzip', 'Enable gzip', $value, '');
		$s->addElement( ffOneElement::TYPE_NEW_LINE );
		
		
			
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START,'', 'Number of files in cache');
		
		$s->addElement(ffOneElement::TYPE_HTML,'', '<span class="cache_number_of_files">'.$numberOfCachedItems.'</span>');
		
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
		
		
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START,'', 'Clear Cache');
		
		$s->addElement( ffOneElement::TYPE_BUTTON, 'ff_delete_cache', 'Clear Cache' );
		
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
		$s->addElement(ffOneElement::TYPE_TABLE_END);
		
		$s->endSection();
		
		$printer = ffContainer::getInstance()->getOptionsFactory()->createOptionsPrinter( array(), $s );
		$printer->setNameprefix($name);
		return $printer;
	}
	
	
	protected function _render() {
		$c = ffContainer::getInstance();
		$dataStorage = $c->getDataStorageFactory()->createDataStorageWPOptionsNamespace('minificator');
		$optionsHolder = $c->getOptionsFactory()->createOptionsHolder('ffMinificatorOptionsHolder');
		$htaccess = $c->getHtaccess();
		
		
		$cache = ffContainer::getInstance()->getDataStorageCache();
		//$cache->deleteNamespace('assetsmin');
		
		
		if( isset( $_POST['header_scripts'] ) ) {
			$dataStorage->deleteOption('banned_handles_scripts');
			$dataStorage->deleteOption('banned_handles_styles');
		}
		
		if( isset( $_POST['flush_data']['flush_data']['flush_data'] ) && $_POST['flush_data']['flush_data']['flush_data'] == 1 ) {
			//$dataStorage->deleteOption('watched_scripts_header');
			//$dataStorage->deleteOption('watched_scripts_footer');
			//$dataStorage->deleteOption('watched_styles_header');
		}
		
		if( isset(  $_POST['flush_data']['flush_data']['enable_exclusion']) ) {
			
			$value = $_POST['flush_data']['flush_data']['enable_exclusion'];
			$dataStorage->setOption('enable_exclusion', $value);
		}
		
		if( isset( $_POST['header_scripts'] ) ) {
			$data = $_POST['header_scripts']['header_scripts'];
			$this->_saveForm($data, 'banned_handles_scripts');
		}
		
		if( isset( $_POST['footer_scripts'] ) ) {
			$data = $_POST['footer_scripts']['footer_scripts'];
			$this->_saveForm($data, 'banned_handles_scripts');
		}
		
		if( isset( $_POST['header_styles'] ) ) {
			$data = $_POST['header_styles']['header_styles'];
			$this->_saveForm($data, 'banned_handles_styles');
		}
		
		if( isset( $_POST['settings'] ) ) {
			$data = $_POST['settings'];
			
			$dataStorage->setOption('options', $data);
		}
		
		if( isset( $_POST['enable_gzip']['enable_gzip']['enable_gzip'] ) ) {
			$enableGzip = $_POST['enable_gzip']['enable_gzip']['enable_gzip'];
			
			if( $enableGzip == 1 ) {
				$htaccessCode = $this->_getHtaccessSectionContent();
				$htaccess->setSection( ffAdminScreenMinificatorViewDefault::HTACCESS_OPTION_NAME, $htaccessCode);
			} else {
				$htaccess->deleteSection( ffAdminScreenMinificatorViewDefault::HTACCESS_OPTION_NAME );
			}
		}
		
		
		$watchedScriptsHeader = $dataStorage->getOption('watched_scripts_header');
		$watchedScriptsFooter = $dataStorage->getOption('watched_scripts_footer');
		$watchedStylesHeader = $dataStorage->getOption('watched_styles_header');
		
		$bannedHandlesScripts = $dataStorage->getOption('banned_handles_scripts');
		$bannedHandlesStyles = $dataStorage->getOption('banned_handles_styles');

	
		
		$printerHeaderScripts = $this->_getWatchedItemsPrinter('header_scripts', $watchedScriptsHeader, $bannedHandlesScripts, 'Exclude these Header Scripts');
		$printerFooterScripts=  $this->_getWatchedItemsPrinter('footer_scripts', $watchedScriptsFooter, $bannedHandlesScripts, 'Exclude these Footer Scripts');
		$printerHeaderStyles =  $this->_getWatchedItemsPrinter('header_styles', $watchedStylesHeader, $bannedHandlesStyles , 'Exclude these Header Styles');
		$printerFlushData = $this->_createFlushDataPrinter();
		
		
		
		
		
		if($htaccess->getSection( ffAdminScreenMinificatorViewDefault::HTACCESS_OPTION_NAME ) == false ) {
			$printerEnableGzip = $this->_createEnableGzip(0);
		} else {
			$printerEnableGzip = $this->_createEnableGzip(1);
		}
		
		
		
		
		
		$options = $dataStorage->getOption('options');
		if( empty( $options ) ) {
			$options = array();
		}
		$printer = $c->getOptionsFactory()->createOptionsPrinter($options , $optionsHolder->getOptions() );
		$printer->setNameprefix('settings');
		
		
		if( $dataStorage->getOption('enable_exclusion') == 0 ) {
			echo '<style> .ff-exclusion { display:none; }</style>';
		}
		
		echo '<div class="wrap">';
		echo '<h2>Performance Cache</h2>';
		echo '<form method="POST" class="ff-options">';
		$printer->walk();
		$printerEnableGzip->walk();
		$printerFlushData->walk();
		$printerHeaderStyles->walk();
		$printerHeaderScripts->walk();
		$printerFooterScripts->walk();
		echo '<p class="submit">';
		echo '<input type="submit" value="Save Changes" class="button button-primary" id="submit" name="submit">';
		echo '</p>';
		echo '</form>';
		echo '</div>';
	}
	
	private function _printActivePluginsTable() {
		
	}
	
	protected function _requireAssets() {
		$pluginUrl = ffPluginFreshMinificatorContainer::getInstance()->getPluginUrl();
		$this->_getScriptEnqueuer()->addScript('ffAdminScreenMinificatorViewDefault', $pluginUrl .'/adminScreens/minificator/assets/adminScreen.js', array('jquery') );
	}
	
	protected function _setDependencies() {
		
	}
	
}