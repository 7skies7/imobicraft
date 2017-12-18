<?php
class ffPluginFreshMinificatorContainer extends ffPluginContainerAbstract {
	/**
	 * 
	 * @var ffPluginPluginDeployerContainer
	 */
	private static $_instance = null;
	
	private $_scriptMinificatorBox = null;
	
	/**
	 * 
	 * @param ffContainer $container
	 * @param string $pluginDir
	 * @return ffPluginFreshMinificatorContainer
	 */
	public static function getInstance( ffContainer $container = null, $pluginDir = null ) {
		if( self::$_instance == null ) {
			self::$_instance = new ffPluginFreshMinificatorContainer($container, $pluginDir);
		}
		
		
		
		return self::$_instance;
	}
	
	public function getWPScriptsAdapter() {
		$c = $this->getFrameworkContainer();
		$c->getClassLoader()->loadClass('ffWPScriptsAdapter');
		
	}
	
	protected function _registerFiles() {
		$pluginDir = $this->_getPluginDir();
		$classLoader =$this->getFrameworkContainer()->getClassLoader(); 
		
	
		$classLoader->addClass('ffStyleMinificator', $pluginDir.'/core/class.ffStyleMinificator.php');
		$classLoader->addClass('ffStyleMinificatorBox', $pluginDir.'/core/class.ffStyleMinificatorBox.php');
		$classLoader->addClass('ffStyleWatcher', $pluginDir.'/core/class.ffStyleWatcher.php');
		
		$classLoader->addClass('ffDependencySolver', $pluginDir.'/core/class.ffDependencySolver.php');
		$classLoader->addClass('ffDependencySolverForScripts', $pluginDir.'/core/class.ffDependencySolverForScripts.php');
		
		$classLoader->addClass('ffScriptMinificator', $pluginDir.'/core/class.ffScriptMinificator.php');
		$classLoader->addClass('ffScriptMinificatorBox', $pluginDir.'/core/class.ffScriptMinificatorBox.php');
		$classLoader->addClass('ffScriptWatcher', $pluginDir.'/core/class.ffScriptWatcher.php');
		
		
		$classLoader->addClass('ffAdminScreenMinificator', $pluginDir.'/adminScreens/minificator/class.ffAdminScreenMinificator.php');
		$classLoader->addClass('ffAdminScreenMinificatorViewDefault', $pluginDir.'/adminScreens/minificator/class.ffAdminScreenMinificatorViewDefault.php');
		
		$classLoader->addClass('ffMinificatorOptionsHolder', $pluginDir.'/core/class.ffMinificatorOptionsHolder.php');
		
	}
	
	public function getDependencySolverForScripts() {
		$this->_getClassLoader()->loadClass('ffDependencySolver');
		$this->_getClassLoader()->loadClass('ffDependencySolverForScripts');
		
		$dependencySolverForScripts = new ffDependencySolverForScripts();
		return $dependencySolverForScripts;
	}
	
	
	public function getScriptMinificatorBox() {
		if( $this->_scriptMinificatorBox == null ) {
			$this->_getClassLoader()->loadClass('ffScriptMinificatorBox');
		
		
			$this->_scriptMinificatorBox = new ffScriptMinificatorBox( $this->getFrameworkContainer()->getMinificator() );
		}
		return $this->_scriptMinificatorBox;
	}
	
	/**
	 * 
	 * @return ffScriptMinificator
	 */
	public function getScriptMinificator() {
		$this->_getClassLoader()->loadClass('ffScriptMinificator');
		
		$scriptMinificator = new ffScriptMinificator( $this->getFrameworkContainer()->getWPLayer(), $this->getScriptMinificatorBox(), $this->getDependencySolverForScripts() );
		
		return $scriptMinificator;
	}
	
	public function getStyleMinificatorBox() {
		$this->_getClassLoader()->loadClass('ffStyleMinificatorBox');
		
		$styleMinificatorBox = new ffStyleMinificatorBox( $this->getFrameworkContainer()->getMinificator() );
		return $styleMinificatorBox;
	}
	
	public function getStyleMinificator() {
		$this->_getClassLoader()->loadClass('ffStyleMinificator');
		$styleMinificator = new ffStyleMinificator( $this->getFrameworkContainer()->getWPLayer(), $this->getDependencySolver(), $this->getStyleMinificatorBox() );
		
		return $styleMinificator;
	}
	
	public function getDependencySolver() {
		$this->_getClassLoader()->loadClass('ffDependencySolver');
		$dependencySolver = new ffDependencySolver();
		
		return $dependencySolver;
	}
	
	public function getScriptWatcher() {
		$this->_getClassLoader()->loadClass('ffScriptWatcher');
		$scriptWatcher = new ffScriptWatcher( $this->getFrameworkContainer()->getWPLayer(), $this->getDependencySolverForScripts());
		return $scriptWatcher;
	}
	
	public function getStyleWatcher() {
		$this->_getClassLoader()->loadClass('ffStyleWatcher');
		$styleWatcher = new ffStyleWatcher( $this->getFrameworkContainer()->getWPLayer(), $this->getDependencySolver());
		return $styleWatcher;
	}
}