<?php
class ffPluginFreshMenuItemLimitFixContainer extends ffPluginContainerAbstract {
	/**
	 * @var ffPluginFreshMenuItemLimitFixContainer
	 */
	private static $_instance = null;

	const STRUCTURE_NAME = 'ff_fresh_favicon';

	/**
	 * @param ffContainer $container
	 * @param string $pluginDir
	 * @return ffPluginFreshMenuItemLimitFixContainer
	 */
	public static function getInstance( ffContainer $container = null, $pluginDir = null ) {
		if( self::$_instance == null ) {
			self::$_instance = new ffPluginFreshMenuItemLimitFixContainer($container, $pluginDir);
		}

		return self::$_instance;
	}
	
	protected function _registerFiles() {

	}

}










