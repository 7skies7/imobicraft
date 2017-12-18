<?php

class ffItemPartCollection_Header extends ffItemPartCollection {

	protected $_itemPartName = 'header';

	protected function _getDefaultItem() {
		$defaultItem = array();

		$defaultItem['name'] = $this->_itemPartName . ' Default';
		$defaultItem['options'] = array();
		$defaultItem['builder'] = '[ffb_section_0][/ffb_section_0]';

		return $defaultItem;
	}
}