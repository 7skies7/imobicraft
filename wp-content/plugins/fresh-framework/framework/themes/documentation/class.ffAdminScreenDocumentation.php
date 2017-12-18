<?php
class ffAdminScreenDocumentation extends ffAdminScreen implements ffIAdminScreen {
	public function getMenu() {
		$menu = $this->_getMenuObject();
		//add_menu_page($page_title, $menu_title, $capability, $menu_slug)
		$menu->pageTitle = 'Support & Docs';
		$menu->menuTitle = 'Support & Docs';
		$menu->type = ffMenu::TYPE_SUB_LEVEL;
		$menu->capability = 'manage_options';
//        $menu->menuSlug = 'site-preferences';
		$menu->parentSlug='ThemeDashboard';
		return $menu;
	}
}