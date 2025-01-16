<?php

namespace Dothcom\FrontReader\Services;

class MenuService extends BaseService
{
    public function getMenu(string $identifier)
    {
        $url = config('front-reader.api_url').'/menus/identifier/'.$identifier;

        return $this->makeRequest($url);
    }

    /**
     * Organizes a list of pages into a hierarchical structure
     *
     * @param  array  $pages  - An array of page objects to be organized
     * @return array
     */
    protected function organizeMenu($pages)
    {
        $pagesById = [];
        foreach ($pages as $page) {
            $page->pages = [];
            $pagesById[$page->id] = $page;
        }

        $organizedMenu = [];
        foreach ($pages as $page) {
            if ($page->parent_id && isset($pagesById[$page->parent_id])) {
                $pagesById[$page->parent_id]->pages[] = $page;
            } else {
                $organizedMenu[] = $page;
            }
        }

        return $organizedMenu;
    }

    public function getOrganizedMenu(string $identifier)
    {
        $menu = $this->getMenu($identifier);
        if (! isset($menu->data->pages)) {
            return [];
        }

        return $this->organizeMenu($menu->data->pages);
    }
}
