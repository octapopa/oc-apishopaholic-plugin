<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Kharanenka\Helper\Result;
use Lovata\Buddies\Models\User;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\User\ItemResource as ItemResourceUser;
use PlanetaDelEste\ApiToolbox\Classes\Api\Base;
use PlanetaDelEste\ApiToolbox\Plugin;

/**
 * Class Profile
 *
 * @package PlanetaDelEste\ApiShopaholic\Controllers\Api
 *
 * @property User $obModel
 */
class Profile extends Base
{
    protected $arFileList = ['attachOne' => 'avatar'];

    public function init()
    {
        $this->bindEvent(
            Plugin::EVENT_LOCAL_BEFORE_SAVE,
            function(User $obModel, array &$arData) {
                $obModel->rules['password'] = 'required:create|between:8,255|confirmed';
                $obModel->rules['password_confirmation'] = 'required_with:password|between:8,255';
                array_forget($obModel->rules, 'avatar');
                array_forget($arData, 'phone_list');
            }
        );
    }

    public function getModelClass(): string
    {
        return User::class;
    }

    /**
     * @return \PlanetaDelEste\ApiShopaholic\Classes\Resource\User\ItemResource
     * @throws \Exception
     */
    public function index(): ItemResourceUser
    {
        return ItemResourceUser::make($this->currentUser());
    }

    /**
     * @throws \Exception
     */
    public function avatar(): array
    {
        $this->currentUser();
        $sPath = $this->user->avatar ? $this->user->avatar->path : null;

        return Result::setData(['avatar' => $sPath])->get();
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function addAddress(): array
    {
        if (!$this->hasPlugin('Lovata.OrdersShopaholic')) {
            return Result::setFalse()->setMessage('Plugin Lovata.OrdersShopaholic not installed')->get();
        }

        return $this->component(\Lovata\OrdersShopaholic\Components\UserAddress::class)->onAdd();
    }

    /**
     * @return array
     * @throws \SystemException
     */
    public function updateAddress(): array
    {
        if (!$this->hasPlugin('Lovata.OrdersShopaholic')) {
            return Result::setFalse()->setMessage('Plugin Lovata.OrdersShopaholic not installed')->get();
        }
        return $this->component(\Lovata\OrdersShopaholic\Components\UserAddress::class)->onUpdate();
    }

    /**
     * @return array
     * @throws \SystemException
     * @throws \Exception
     */
    public function removeAddress(): array
    {
        if (!$this->hasPlugin('Lovata.OrdersShopaholic')) {
            return Result::setFalse()->setMessage('Plugin Lovata.OrdersShopaholic not installed')->get();
        }
        return $this->component(\Lovata\OrdersShopaholic\Components\UserAddress::class)->onRemove();
    }
}
