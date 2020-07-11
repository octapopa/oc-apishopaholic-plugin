<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Category;

use PlanetaDelEste\ApiToolbox\Plugin;

/**
 * Class ShowResource
 *
 * @mixin \Lovata\Shopaholic\Classes\Item\CategoryItem
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Category
 */
class ShowResource extends ItemResource
{
    public function getDataKeys()
    {
        return [
            'id',
            'active',
            'name',
            'slug',
            'code',
            'external_id',
            'preview_text',
            'description',
            'parent_id',
            'nest_left',
            'nest_right',
            'nest_depth',
            'images',
            'preview_image'
        ];
    }

    protected function getEvent()
    {
        return Plugin::EVENT_SHOWRESOURCE_DATA;
    }
}

