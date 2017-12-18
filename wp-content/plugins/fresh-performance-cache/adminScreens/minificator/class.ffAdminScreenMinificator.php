<?php

class ffAdminScreenMinificator extends ffAdminScreen implements ffIAdminScreen {
	public function getMenu() {
		$menu = $this->_getMenuObject();
		//add_menu_page($page_title, $menu_title, $capability, $menu_slug)
		$menu->pageTitle = 'Performance Cache';
		$menu->menuTitle = 'Performance Cache';
		$menu->type = ffMenu::TYPE_SUB_LEVEL;
		$menu->capability = 'manage_options';
		$menu->parentSlug='options-general.php';
		return $menu;
	}
}