<?php
/**
 * This class automatically loads all necessary files. It will be also used
* across the whole template, when you need to load something dynamically
* @author freshface
* @since 1.1.2
*/
class ffAjaxDispatcher extends ffBasicObject {
/******************************************************************************/
/* VARIABLES AND CONSTANTS
/******************************************************************************/
	/**
	 * 
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;
	
	/**
	 * 
	 * @var ffAjaxRequestFactory
	 */
	private $ajaxRequestFactory = null;

	private $_response = array();

/******************************************************************************/
/* CONSTRUCT AND PUBLIC FUNCTIONS
/******************************************************************************/
	public function __construct( ffWPLayer $WPLayer, ffAjaxRequestFactory $ajaxRequestFactory) {
		$this->_setWPLayer($WPLayer);
		$this->_setAjaxRequestFactory($ajaxRequestFactory);
	}
	
	public function ajaxRequest() {
		$request = $this->_getAjaxRequestFactory()->createAjaxRequest();

		$this->_getWPLayer()->getHookManager()->doAjaxRequest($request);
		$this->_getWPLayer()->getHookManager()->doActionAjaxShutdown();

		$this->_printResponse();
		die();
	}

	protected function _printResponse() {
		if( empty( $this->_response ) ) {
			return;
		}

		echo 'ff_ajax_dispatcher_response';
		echo json_encode( $this->_response );
	}
/******************************************************************************/
/* PRIVATE FUNCTIONS
/******************************************************************************/
	public function hookActions() {
		$WPLayer = $this->_getWPLayer();
		if( $WPLayer->is_admin() ) {
			$WPLayer->getHookManager()->addActionAjax( array( $this, 'ajaxRequest') );

			$WPLayer->add_action('ff_broadcast_fake_ajax', array( $this, 'broadcastFakeAjaxRequest') );

            if( $WPLayer->isDebugMode() ) {
	            $WPLayer->showAllErrors();
            }


		}
	}

	public function broadcastFakeAjaxRequest( $requestData ) {

		$owner = ( isset( $requestData['owner'] ) ) ? $requestData['owner'] : null;
		$data = ( isset( $requestData['data'] ) ) ? $requestData['data'] : null;
		$specification = ( isset( $requestData['specification'] ) ) ? $requestData['specification'] : null;


		$request = $this->_getAjaxRequestFactory()->createFakeAjaxRequest( $owner, $data, $specification );

		$this->_getWPLayer()->getHookManager()->doAjaxRequest( $request );
		$this->_getWPLayer()->getHookManager()->doActionAjaxShutdown();
	}
	
	
/******************************************************************************/
/* SETTERS AND GETTERS
/******************************************************************************/
	
	/**
	 * @return ffWPLayer
	 */
	protected function _getWPLayer() {
		return $this->_WPLayer;
	}
	
	/**
	 * @param ffWPLayer $WPLayer
	 */
	protected function _setWPLayer(ffWPLayer $WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}

	/**
	 * @return ffAjaxRequestFactory
	 */
	protected function _getAjaxRequestFactory() {
		return $this->_ajaxRequestFactory;
	}
	
	/**
	 * @param ffAjaxRequestFactory $ajaxRequestFactory
	 */
	protected function _setAjaxRequestFactory(ffAjaxRequestFactory $ajaxRequestFactory) {
		$this->_ajaxRequestFactory = $ajaxRequestFactory;
		return $this;
	}

	public function addResponse( $name, $value ) {

		$this->_response[ $name ] = $value;

	}
	
	
}