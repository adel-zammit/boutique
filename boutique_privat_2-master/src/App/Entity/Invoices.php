<?php
namespace App\Entity;

use App\Repository\Cart;
use Base\App;
use Base\BaseApp;
use Base\Mvc\Entity\ArrayCollection;
use Base\Mvc\Entity\Entity;
use Base\Mvc\Entity\Structure;
use Base\Repository;

/**
 * @property int invoice_id
 * @property int user_id
 * @property float price
 * @property float total_price
 * @property int invoice_state
 * @property float sales_tax_rate
 * @property int address_id
 * @property string request_key
 * @property int invoice_date
 * @property int coupon_id
 *
 * Class Invoices
 * @package App\Entity
 *
 * RELATION
 * @property User User
 * @property ArrayCollection|ItemsPurchased[] ItemsPurchased
 * @property ArrayCollection|Carts[] Carts
 * @property CouponLog CouponLog
 * @property Coupon Coupon
 * @property Address Address
 * @property AddressInvoiceLog AddressLog
 */
class Invoices extends Entity
{
    /**
     * @throws \Exception
     */
    public function finalize()
    {
        if($this->invoice_state == 0)
        {
            $carts = $this->finder('App:Carts')
                ->where('invoice_id', $this->invoice_id)
                ->fetch();

            /** @var \App\Entity\Carts $cart */
            foreach ($carts as $cart)
            {
                /** @var ItemsPurchased $item */
                $item = BaseApp::create('App:ItemsPurchased');
                $item->product_id = $cart->product_id;
                $item->quantity = $cart->quantity;
                $item->invoice_id = $this->invoice_id;
                $item->user_id = $cart->user_id;
                $item->save();
                /** @var Products $product */
                $product = $cart->Product;
                $stock = $product->stock;
                $stock -= $cart->quantity;
                $product->stock = $stock;
                $product->save();

                $cart->delete();
            }
            /** @var User $user */
            $user = BaseApp::find('App:User', $this->user_id);
            /** @var Coupon $coupon */
            $coupon = BaseApp::find('App:Coupon', $this->coupon_id);
            /** @var CouponLog $couponLog */
            $couponLog = BaseApp::create('App:CouponLog');
            $couponLog->coupon_id = $coupon->coupon_id;
            $couponLog->coupon_name = $coupon->title;
            $couponLog->coupon_code = $coupon->code;
            $couponLog->coupon_type = $coupon->coupon_type;
            $couponLog->coupon_value = $coupon->value;
            $couponLog->user_id = $user->user_id;
            $couponLog->username = $user->username;
            $couponLog->invoice_id = $this->invoice_id;
            $couponLog->total_price = $this->price;
            $couponLog->price = $this->total_price;
            $couponLog->coupon_min = $coupon->coupon_min;
            $couponLog->save();
            /** @var Address $address */
            $address = $this->Address;
            /** @var AddressInvoiceLog $addressLog */
            $addressLog = BaseApp::create('App:AddressInvoiceLog');
            $addressLog->address_id = $address->address_id;
            $addressLog->invoice_id = $this->invoice_id;
            $addressLog->user_id = $this->user_id;
            $addressLog->address_name = $address->name;
            $addressLog->sex = $address->sex;
            $addressLog->first_name = $address->first_name;
            $addressLog->last_name = $address->last_name;
            $addressLog->address = $address->address;
            $addressLog->additional_address = $address->additional_address;
            $addressLog->country_code = $address->country_code;
            $addressLog->zip_code = $address->zip_code;
            $addressLog->city = $address->city;
            $addressLog->cell_phone = $address->cell_phone;
            $addressLog->landline_phone = $address->landline_phone;
            $addressLog->save();
        }
    }
    /**
     * @return array
     */
    public function getProductList()
    {
        $products = [];
        /** @var Categories  $item */
        foreach ($this->Carts as $item)
        {
            $products[] = $item->Product->title;
        }

        return $products;
    }

    /**
     * @return mixed|string
     */
    public function getBaseUrl()
    {
        return BaseApp::request()->getServerNameUrl() . BaseApp::newApp('Pub')->buildLink('Pub:carts/finalize', null, ['invoice_id' => $this->invoice_id]);
    }

    /**
     * @return string|string[]
     */
    public function getState()
    {
        switch ($this->invoice_state)
        {
            case 1 :
                return '<span class="state-in-progress"><i class="fas fa-sync-alt"></i> ' . BaseApp::phrase('in_progress') . '</span>';
                break;
            case 2 :
                return '<span class="state-in-validate"><i class="fas fa-check"></i> ' . BaseApp::phrase('validate') . '</span>';
                break;
            case 10 :
                return '<span class="state-in-cancel"><i class="fas fa-times"></i> ' . BaseApp::phrase('cancel') . '</span>';
                break;
            default : return '<span class="state-in-no-state state-in-cancel"><i class="fas fa-times"></i> ' . BaseApp::phrase('no_state') . '</span>';
        }
    }

    /**
     * @return string
     */
    public function getSateLite()
    {
        switch ($this->invoice_state)
        {
            case 0 :
                return BaseApp::phrase('wait');
                break;
            case 1 :
                return BaseApp::phrase('in_progress');
                break;
            case 2 :
                return BaseApp::phrase('validate');
                break;
            case 10 :
                return BaseApp::phrase('cancel');
                break;
            default : return '<span class="state-in-no-state state-in-cancel"><i class="fas fa-times"></i> ' . BaseApp::phrase('no_state') . '</span>';
        }
    }

    /**
     * @return string
     */
    public function getTotalPrice()
    {
        return $this->getCartsRepo()->priceFormat($this->getCartsRepo()->getTwoPartPrice($this->total_price));
    }

    /**
     * @return string
     */
    public function getPrice()
    {
        return $this->getCartsRepo()->priceFormat($this->getCartsRepo()->getTwoPartPrice($this->price));
    }

    /**
     * @return string
     */
    public function getSaleDiscount()
    {
        if($this->coupon_id)
        {
            if($this->CouponLog)
            {
                $couponLog = $this->CouponLog;
                return '-' . $this->formatPrice($couponLog->getDiscount());
            }
            else if($this->Coupon)
            {
                return '-' . $this->formatPrice($this->Coupon->getDiscount($this->price));
            }
        }
        return '-' . $this->formatPrice(0.00);
    }
    public function getSalesTax($tax)
    {
        return ($tax / 100) * $this->price;
    }
    /**
     * @param null $urlAddress
     * @return string
     */
    public function getAddress($urlAddress = null)
    {
        if($this->invoice_state == 0)
        {
            if($this->Address)
            {
                /** @var Address $address */
                $address = $this->Address;
                $return = "<ul class=\"listPlain\">";
                if($urlAddress != null)
                {
                    $return .= '<li><a href="' . $urlAddress . '" >' . $address->name . '</a>';
                }

                $return .= '<li>' . $address->first_name . ' ' . $address->last_name . '</li>';
                $return .= '<li>' . $address->address . '</li>';
                $return .= '<li>' . $address->zip_code . '</li>';
                return $return . '</ul>';
            }
        }
        else
        {
            if($this->AddressLog)
            {
                /** @var AddressInvoiceLog $AddressInvoiceLog */
                $AddressInvoiceLog = $this->AddressLog;
                $return = "<ul class=\"listPlain\">";
                if($urlAddress != null)
                {
                    $return .= '<li><a href="' . $urlAddress . '" >' . $AddressInvoiceLog->address_name . '</a>';
                }

                $return .= '<li>' . $AddressInvoiceLog->first_name . ' ' . $AddressInvoiceLog->last_name . '</li>';
                $return .= '<li>' . $AddressInvoiceLog->address . '</li>';
                $return .= '<li>' . $AddressInvoiceLog->zip_code . '</li>';
                return $return . '</ul>';
            }
        }
        return BaseApp::phrase('unknown_address');
    }
    /**
     * @param $price
     * @return string
     */
    public function formatPrice($price)
    {
        return $this->getCartsRepo()->priceFormat($this->getCartsRepo()->getTwoPartPrice($price));
    }

    /**
     * @param Structure $structure
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'invoices';
        $structure->shortName = "App:Invoices";
        $structure->primaryKey = 'invoice_id';
        $structure->columns = [
            'invoice_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'user_id' => ['type' => self::UINT],
            'price' => ['type' => self::FLOAT],
            'total_price' => ['type' => self::FLOAT],
            'invoice_state' => ['type' => self::UINT, 'default' => 0],
            'sales_tax_rate' => ['type' => self::FLOAT, 'default' => 0],
            'address_id' => ['type' => self::UINT, 'default' => 0],
            'request_key' => ['type' => self::STR, 'default' => ''],
            'invoice_date' => ['type' => self::UINT, 'default' => BaseApp::time()],
            'coupon_id'  => ['type' => self::UINT, 'default' => 0],
        ];
        $structure->relations = [
            'User' => [
                'type' => self::TO_ONE,
                'entity' => 'App:User',
                'conditions' => 'user_id',
                'primary' => true
            ],
            'ItemsPurchased' => [
                'type' => self::TO_MANY,
                'entity' => 'App:ItemsPurchased',
                'conditions' => 'invoice_id',
                'order' => 'purchased_id'
            ],
            'Carts' => [
                'type' => self::TO_MANY,
                'entity' => 'App:Carts',
                'conditions' => 'invoice_id',
            ],
            'CouponLog' => [
                'type' => self::TO_ONE,
                'entity' => 'App:CouponLog',
                'conditions' => 'invoice_id',
            ],
            'Coupon' => [
                'type' => self::TO_ONE,
                'entity' => 'App:Coupon',
                'conditions' => 'coupon_id',
                'primary' => true
            ],
            'Address' => [
                'type' => self::TO_ONE,
                'entity' => 'App:Address',
                'conditions' => 'address_id',
            ],
            'AddressLog' => [
                'type' => self::TO_ONE,
                'entity' => 'App:AddressInvoiceLog',
                'conditions' => ['address_id', 'invoice_id'],
            ]
        ];
        return $structure;
    }

    /**
     * @return string|Repository|Cart
     */
    protected function getCartsRepo()
    {
        return BaseApp::repository('App:Cart');
    }
}