<?php

class ffAdminScreenFileEditor extends ffAdminScreen implements ffIAdminScreen {
	public function getMenu() {
		$menu = $this->_getMenuObject();
		$menu->pageTitle = 'File Editor';
		$menu->menuTitle = 'File Editor';
		$menu->type = ffMenu::TYPE_SUB_LEVEL;
		$menu->capability = 'manage_options';
		$menu->parentSlug='tools.php';
		return $menu;
	}
}
