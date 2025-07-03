<?php

namespace Dothcom\FrontReader\Services;

class MenuService extends BaseService
{
    public function getMenu(string $identifier)
    {
        $endpoint = '/menus/identifier/'.$identifier;

        return $this->tryRequest($endpoint, [], true, 10);
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

        foreach ($menu->data->pages as $page) {
            if (isset($page->link_external) && ! isset($page->link)) {
                $page->link = $page->link_external;
            }

            if (isset($page->permalink)) {
                $page->link = $page->permalink;
            }
        }

        return $this->organizeMenu($menu->data->pages);
    }
}
