<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Category;

use PlanetaDelEste\ApiShopaholic\Classes\Resource\File\IndexCollection as IndexCollectionImages;
use PlanetaDelEste\ApiToolbox\Plugin;
use PlanetaDelEste\ApiToolbox\Classes\Resource\Base;

/**
 * Class ItemResource
 *
 * @mixin \Lovata\Shopaholic\Classes\Item\CategoryItem
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Category
 */
class ItemResource extends Base
{
    /**
     * @return array|void
     */
    public function getData()
    {
        return [
            'preview_image' => $this->preview_image ? $this->preview_image->getPath() : null,
            'images'        => IndexCollectionImages::make(collect($this->images)),
        ];
    }

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
            'parent_id',
            'preview_image',
        ];
    }

    protected function getEvent()
    {
        return Plugin::EVENT_ITEMRESOURCE_DATA;
    }
}
