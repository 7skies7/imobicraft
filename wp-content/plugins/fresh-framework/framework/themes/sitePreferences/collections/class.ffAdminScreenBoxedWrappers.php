<?php
class ffAdminScreenBoxedWrappers extends ffAdminScreen implements ffIAdminScreen {
	public function getMenu() {
		$menu = $this->_getMenuObject();
		//add_menu_page($page_title, $menu_title, $capability, $menu_slug)
		$menu->pageTitle = 'Boxed Wrappers';
		$menu->menuTitle = 'Boxed Wrappers';
		$menu->type = ffMenu::TYPE_SUB_LEVEL;
		$menu->capability = 'manage_options';
//        $menu->menuSlug = 'get-sales';
		$menu->parentSlug='ThemeDashboard';
		return $menu;
	}
}