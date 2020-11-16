<?php


namespace App\Repository;


use App\Entity\Products;
use Base\App;
use Base\BaseApp;
use Base\Repository;
use Base\Util\Img;

class Cart extends Repository
{
    protected $totalPrice = 0;

    /**
     * @param $quantity
     * @param Products $product
     * @param App $app
     * @param array $options
     * @return string
     */
    public function getHtmlCarts($quantity, Products $product, App $app, array $options = [])
    {
        $options = array_merge([
            'tab' => [
                'designation',
                'price',
                'subtotal',
                'remove',
                'quantity',
                'stock',
            ],
            'displaySock' => true
        ], $options);
        $price = $this->getTwoPartPrice($product->price);
        $total = $this->getTotal($quantity, $product->price);
        $addClassWarning = '';
        $this->setTotalPrice($product->price, $quantity);
        if($quantity > $product->stock && $options['displaySock'])
        {
            $addClassWarning .= 'item-exceeds-stock';
        }
        $html = "<div class=\"type-table item piece $addClassWarning\" data-product-id='" . $product->product_id . "'>";
        if(in_array('designation', $options['tab']))
        {
            $html .= " <div class=\"type-cell cell-designation\">";
            $html .= "    <div class=\"type-content-flex\">";
            $html .= '        <div class="type-cell-pic">';
            $html .=            Img::getImg($product, 'icon_date', 'defaultProduct', 'default_img_product', 'm');
            $html .= "        </div>";
            $html .= '        <div class="type-cell-txt">';
            $html .= '            <div class="title">';
            $html .= '                  <a href="' . $app->buildLink('Pub:product', $product) . '" >' . $product->title . '</a>';
            $html .= "            </div>";
            if(in_array('stock', $options['tab']))
            {
                if($quantity <= $product->stock)
                {
                    $html .= '            <div class="stocks in-stock">';
                    $html .= '                <strong>Stock:</strong>';
                    $html .= '                <span>En <em>stock</em></span>';
                    $html .= "            </div>";
                }
                else
                {
                    $html .= '            <div class="stocks hor-stock">';
                    $html .= '                <strong>Stock:</strong>';
                    $html .= '                <span><em>Rupture</em></span>';
                    $html .= "            </div>";
                }
            }

            $html .= "        </div>";
            $html .= "        </div>";
            $html .= "    </div>";
        }
        if(in_array('price', $options['tab']))
        {
            $html .= "    <div class=\"type-cell cell-price type-cell-s\">";
            $html .= '        <span class="price" data-price="' . $product->price . '"> ' . $this->priceFormat($price) . '</span>';
            $html .= "    </div>";
        }

        if(in_array('quantity', $options['tab']))
        {
            $html .= '    <div class="type-cell cell-quantity type-cell-s">';
            $html .=        $this->getInputSelect($quantity, $product->stock);
            $html .= "    </div>";
        }

        if(in_array('infQuantity', $options['tab']))
        {
            $html .= '    <div class="type-cell cell-quantity type-cell-s">';
            $html .=        $quantity;
            $html .= "    </div>";
        }
        if(in_array('subtotal', $options['tab']))
        {
            $html .= '    <div class="type-cell cell-subtotal type-cell-s">';
            $html .=        '        <span class="price"> ' . $this->priceFormat($total) . '</span>';
            $html .= "    </div>";
        }

        if(in_array('remove', $options['tab']))
        {
            $html .= '    <div class="type-cell cell-remove">';
            $html .= '      <a href="' . $app->buildLink('Pub:carts/remove', null, ['product_id' => $product->product_id] ) . '" class="remove-action">';
            $html .=        '        <i class="fas fa-trash-alt"></i>';
            $html .= '      </a>';
            $html .= "    </div>";
        }
        $html .= "</div>";
        return $html;
    }

    /**
     * @param $price
     * @return false|string[]
     */
    public function getTwoPartPrice($price)
    {
        return explode('.', $price);
    }

    /**
     * @param $quantity
     * @param $stocks
     * @return string
     */
    protected function getInputSelect($quantity, $stocks)
    {
        $form = $this->getForm();
        $output = [];
        for ($i = 1; $i <= $stocks; ++$i)
        {
            $output[$i] = [
                'label' => $i,
                'selected' => $quantity == $i
            ];
        }
        if($quantity >= $stocks)
        {
            $output[$quantity] = [
                'label' => $quantity,
                'selected' => true
            ];
        }
        return $form->getSelector('quantity',
            ['options' => $output],
            [
                'input',
                'quantity-input'
            ]);
    }

    /**
     * @param $quantity
     * @param $price
     * @return false|string[]
     */
    protected function getTotal($quantity, $price)
    {
        return $this->getTwoPartPrice($price * $quantity);
    }

    /**
     * @return \Base\Reply\Form
     */
    protected function getForm()
    {
        return BaseApp::setNewClass('Base\Reply\Form');
    }

    /**
     * @param $price
     * @param $quantity
     */
    protected function setTotalPrice($price, $quantity)
    {
        $this->totalPrice += $price * $quantity;
    }

    /**
     * @throws \Exception
     */
    public function setTotalPriceByAllProduct()
    {
        if(isset($_SESSION['user_id']))
        {
            $carts = $this->finder('App:Carts')
                ->where('user_id', $_SESSION['user_id'])
                ->fetch();
            foreach ($carts as $cart)
            {
                $this->setTotalPrice($cart->Product->price, $cart->quantity);
            }
        }
        else
        {
            $cartProductId = $_SESSION['cart_product_id'];
            foreach ($cartProductId as $key => $cart)
            {
                /** @var Products $product */
                $product = BaseApp::find('App:Products', $cart[0]);
                $this->setTotalPrice($product->price, $cart[1]);
            }
        }
    }

    /**
     * @param array $price
     * @return string
     */
    public function priceFormat(array $price = [])
    {
        return $price[0] .  '€'  . (isset($price[1]) ? '<sup>' . str_pad($price[1], 2, "0", STR_PAD_RIGHT) .  '</sup>' : '<sup>00</sup>');
    }

    /**F
     * @return string
     */
    public function getPriceForm()
    {
        $price = $this->getTwoPartPrice($this->totalPrice);
        return $this->priceFormat($price);
    }

    /**
     * @return int
     */
    public function getCalculatesTotal()
    {
        return $this->totalPrice;
    }
}