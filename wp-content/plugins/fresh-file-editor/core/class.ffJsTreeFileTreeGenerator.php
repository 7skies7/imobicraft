<?php

class ffJsTreeFileTreeGenerator extends ffBasicObject {
	
	/**
	 * 
	 * @var ffFileSystem
	 */
	private $_fileSystem = null;
	
	public function __construct( ffFileSystem $fileSystem ) {
		$this->_setFileSystem($fileSystem);
	}
	
	public function getListForDir( $path ) {
		$dirList = $this->_getFileSystem()->dirlist($path);
		
		if( empty( $dirList ) ) {
			return false;
		}
	
		$dirsList = '';
		$filesList = '';
		ksort( $dirList );
		foreach( $dirList as $itemName => $oneItem ) {
			
			
			
			$currentItem = '';
			
			$dataPath = $path.$itemName;
			$dataType = 'folder';
			if( $oneItem['type'] == 'f') {
				
				

				$pathInfo = pathinfo( $itemName );
				if( !isset($pathInfo['extension']) ) {
					$pathInfo['extension'] = 'txt';
				}
				$extension = $pathInfo['extension'];
				$dataType = $extension ;
				$dataUrl = '';
				switch( $extension ) {
					case 'gif':
					case 'jpeg':
					case 'jpg':
					case 'png':
					case 'tiff':
					case 'bmp':
						$dataType = 'img';
						$dataUrl = (str_replace(ABSPATH,get_site_url().'/', $dataPath));
						break;
							
					case 'php':
						break;
						$dataType = 'php';
					case 'css':
					case 'less':
						$dataType = 'css';
						break;
					case 'js':
						$dataType = 'javascript';
						break;
						
					case 'html':
						$dataType = 'html';
						break;
						//gif, jpeg, jpg, png, tiff, bmp
				}
				
				//$currentItem .= '<li data-jstree=\'{"icon":"ff-icon-hidden"}\' data-path="'.$dataPath.'" rel="file">';
				$currentItem .= '<li data-jstree=\'{"type":"file"}\' data-type="'.$dataType.'" data-path="'.$dataPath.'" rel="file" data-url="'.$dataUrl.'">';
			} else {

				
				//$currentItem .='<li data-jstree=\'{"icon": "ff-icon-hidden"}\' class="jstree-closed" data-path="'.$dataPath.'">';
				$currentItem .='<li data-jstree=\'{"type": "folder" }\' class="jstree-closed" data-type="'.$dataType.'" data-path="'.$dataPath.'">';


			}
			$currentItem .= $itemName;
			$currentItem .= '</li>';
			
			if( $oneItem['type'] == 'f') {
				$filesList .= $currentItem;
			} else {
				$dirsList .=$currentItem;			
			}
			
			
		}
		
		$toReturn = $dirsList . $filesList;
		
		return $toReturn;
	}
	
	/**
	 *
	 * @return ffFileSystem
	 */
	protected function _getFileSystem() {
		return $this->_fileSystem;
	}
	
	/**
	 *
	 * @param ffFileSystem $_fileSystem        	
	 */
	protected function _setFileSystem(ffFileSystem $fileSystem) {
		$this->_fileSystem = $fileSystem;
		return $this;
	}
	
	
	
}