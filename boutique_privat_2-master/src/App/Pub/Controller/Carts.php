<?php


namespace App\Pub\Controller;

use App\Entity\Coupon;
use App\Entity\Invoices;
use App\Entity\ItemsPurchased;
use App\Entity\Products;
use App\Repository\Cart;
use Base\BaseApp;
use Base\Mvc\ParameterBag;
use Base\Repository;
use Base\Util\Arr;

class Carts extends AbstractController
{
    /**
     * @param $action
     * @param ParameterBag $params
     * @return \Base\Reply\Redirect|bool
     * @throws \Exception
     */
    protected function preDispatchController($action, ParameterBag $params)
    {
        if(!in_array($action, ['actionIndex', 'actionUpdate', 'actionRemove', 'actionInvoice']))
        {
            $userId = BaseApp::visitor()->user_id;
            if(empty($userId))
            {
                return $this->redirect($this->app()->buildLink('Pub:login'));
            }

            /** @var Invoices $invoice */
            $invoice = $this->finder('App:Invoices')
                ->where('invoice_state', 0)
                ->total();
            if(empty($invoice))
            {
                return $this->redirect($this->app()->buildLink('Pub:carts'));
            }

            /** @var \App\Entity\Carts $carts */
            $carts = $this->finder('App:Carts')
                ->where('user_id', $_SESSION['user_id'])
                ->fetchOne();
            if(empty($carts))
            {
                return $this->redirect($this->app()->buildLink('Pub:carts'));
            }
        }
    }

    /**
     * @param ParameterBag $params
     * @throws \Exception
     */
    public function actionIndex(ParameterBag $params)
    {
        $carts = [];
        if(isset($_SESSION['user_id']))
        {
            $carts = $this->finder('App:Carts')
                ->where('user_id', $_SESSION['user_id'])
                ->fetch();
            $emptyCarts = $carts->count();
        }
        else
        {
            $emptyCarts = 0;
            if(isset($_SESSION['cart_product_id']))
            {
                $sessionCarts = $_SESSION['cart_product_id'];
                $emptyCarts = count($sessionCarts);
                foreach ($sessionCarts as $sessionCart)
                {
                    $carts[] = Arr::ArrayToObject([
                        'quantity' => $sessionCart[1],
                        'Product' => $this->finder('App:Products')
                            ->where('product_id', $sessionCart[0])
                            ->fetchOne()
                    ]);
                }
            }
        }
        $viewParams = [
            'carts' => $carts,
            'cartRepo' => $this->getCartsRepo(),
            'emptyCarts' => $emptyCarts
        ];
        $this->view('cart_view', $viewParams);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function actionUpdate()
    {
        $entityInput = $this->filter([
            'productId' => 'int',
            'quantity' => 'int'
        ]);
        /** @var Products $product */
        $product = BaseApp::find('App:Products', $entityInput['productId']);
        if(isset($_SESSION['user_id']))
        {
            /** @var \App\Entity\Carts $carts */
            $carts = $this->finder('App:Carts')
                ->where([
                    'product_id' => $product->product_id,
                    'user_id' => $_SESSION['user_id']
                ])->fetchOne();
            $carts->quantity = $entityInput['quantity'];
            $carts->save();
        }
        else
        {
            $cartProductId = $_SESSION['cart_product_id'];
            foreach ($cartProductId as $key => $cart)
            {
                if($cart[0] == $product->product_id)
                {
                    $cartProductId[$key] = [
                        $product->product_id,
                        $entityInput['quantity']
                    ];
                }
            }
            $_SESSION['cart_product_id'] = $cartProductId;
        }
        $cartsRepo = $this->getCartsRepo();
        $cartsRepo->setTotalPriceByAllProduct();
        return $this->setViewAjax([
            'productId' => $product,
            'stocks' => $product->stock,
            'totalPrice' => $cartsRepo->getCalculatesTotal(),
        ]);
    }
    /**
     * @return array
     * @throws \Exception
     */
    public function actionRemove()
    {
        $entityInput = $this->filter('product_id', 'int');
        /** @var Products $product */
        $product = BaseApp::find('App:Products', $entityInput);
        if(isset($_SESSION['user_id']))
        {
            /** @var \App\Entity\Carts $carts */
            $carts = $this->finder('App:Carts')
                ->where([
                    'product_id' => $product->product_id,
                    'user_id' => $_SESSION['user_id']
                ])->fetchOne();
            $carts->delete();
            if(!$carts->Invoice->Carts->count())
            {
                $carts->Invoice->delete();
            }
            $emptyCarts = $this->finder('App:Carts')
                ->where( 'user_id', $_SESSION['user_id'])
                ->total();
        }
        else
        {
            $cartProductId = $_SESSION['cart_product_id'];
            foreach ($cartProductId as $key => $cart)
            {
                if($cart[0] == $product->product_id)
                {
                    unset($cartProductId[$key]);
                }
            }
            $_SESSION['cart_product_id'] = $cartProductId;
            $emptyCarts = count($_SESSION['cart_product_id']);
        }
        $cartsRepo = $this->getCartsRepo();
        $cartsRepo->setTotalPriceByAllProduct();
        return $this->setViewAjax([
            'productId' => $product,
            'totalPrice' => $cartsRepo->getCalculatesTotal(),
            'emptyCarts' => $emptyCarts
        ]);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function actionInvoice()
    {
        $carts = $this->finder('App:Carts')
            ->where('user_id', $_SESSION['user_id'])
            ->fetch();
        $invoiceId = 0;
        $priceTotal = 0;
        /** @var \App\Entity\Carts $cart */
        foreach ($carts as $cart)
        {
            if($cart->Invoice)
            {
                $invoiceId = $cart->Invoice->invoice_id;
            }
            $priceTotal += $cart->Product->price * $cart->quantity;
        }
        if($invoiceId)
        {
            /** @var Invoices $invoice */
            $invoice = BaseApp::find('App:Invoices', $invoiceId);
        }
        else
        {
            /** @var Invoices $invoice */
            $invoice = $this->create('App:Invoices');
        }
        $invoice->user_id = $_SESSION['user_id'];
        $invoice->total_price = $priceTotal;
        $invoice->price = $priceTotal;
        $invoice->coupon_id = 0;
        $invoice->save();
        foreach ($carts as $cart)
        {
            $cart->invoice_id = $invoice->invoice_id;
            $cart->save();
        }
        return $this->setViewAjax([
            'url' => $this->app()->buildLink('Pub:carts/address')
        ]);
    }

    /**
     *
     */
    public function actionAddress()
    {
        $addresses = $this->finder('App:Address')
            ->where('user_id', $_SESSION['user_id'])
            ->fetch();
        $viewParams = [
            'addresses' => $addresses
        ];
        $this->view('carts_address', $viewParams);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function actionAddressSave()
    {
        $address = $this->filter('address', 'int');
        $errors = [];
        if(empty($address))
        {
            $errors[] = BaseApp::phrase('please_enter_value_for_required_field_x', ['field' => 'address']);
        }
        else
        {
            /** @var Invoices $invoice */
            $invoice = $this->finder('App:Invoices')
                ->where([
                    'invoice_state' => 0,
                    'user_id' => $_SESSION['user_id']
                ])
                ->fetchOne();
            /** @var \App\Entity\Address $a */
            $a = BaseApp::find('App:Address', $address);
            $invoice->sales_tax_rate = $invoice->getSalesTax($a->Country->sales_tax_rate);
            $invoice->price = $a->Country->getPrice($invoice->price);
            $invoice->total_price = $a->Country->getPrice($invoice->total_price);
            $invoice->address_id = $address;
            $invoice->save();
        }
        return $this->setErrorByFromByJason($errors, $this->app()->buildLink('Pub:carts/buy'));
    }

    /**
     *
     */
    public function actionBuy()
    {

        /** @var Invoices $invoice */
        $invoice = $this->finder('App:Invoices')
            ->where([
                'invoice_state' => 0,
                'user_id' => $_SESSION['user_id']
            ])
            ->fetchOne();
        $viewParams = [
            'invoice' => $invoice,
            'cartRepo' => $this->getCartsRepo()
        ];
        $this->view('cart_buy', $viewParams);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function actionBuyUpdate()
    {
        $code = $this->filter('code', 'str');
        if(empty($code))
        {
            return $this->setViewAjax([
                'error' =>  'Veuillez saisir un coupon avant d\'appliquer !',
                'type' => 'error'
            ]);
        }
        /** @var Invoices $invoice */
        $invoice = $this->finder('App:Invoices')
            ->where([
                'invoice_state' => 0,
                'user_id' => $_SESSION['user_id']
            ])
            ->fetchOne();

        /** @var Coupon $coupon */
        $coupon = $this->finder('App:Coupon')
            ->where('code', $code)
            ->fetchOne();
        if(empty($coupon))
        {
            return $this->setViewAjax([
                'error' => 'Le coupon ' . $code . ' n\'est pas valide !',
                'type' => 'error'
            ]);
        }
        $time = BaseApp::time();
        if($coupon->start_date <= $time && $coupon->end_date >= $time)
        {
            if($coupon->coupon_min >= $invoice->price)
            {
                return $this->setViewAjax([
                    'error' => 'Le coupon ' . $code . ' ne peux pas être appliqué sur ce panier !',
                    'type' => 'error'
                ]);
            }
            $invoice->coupon_id = $coupon->coupon_id;
            $invoice->total_price = $coupon->getPrice($invoice->price);
            $invoice->save();
            if($coupon->coupon_type == 'percent')
            {
                return $this->setViewAjax([
                    'error' => 'Le coupon ' . $code . ' à été appliquer à votre panier ! Vous avez droit à ' . $coupon->value . '% sur le la Totaliter du panier.',
                    'type' => 'success',
                    'price' => $invoice->total_price,
                    'total_price' => $invoice->price,
                    'value' => $coupon->value . '%'
                ]);
            }
            else
            {
                return $this->setViewAjax([
                    'error' => 'Le coupon ' . $code . ' à été appliquer à votre panier ! vous avez droit à -' . $coupon->value . ' Euro sur le la Totaliter du panier.',
                    'type' => 'success',
                    'price' => $invoice->total_price,
                    'total_price' => $invoice->price,
                    'value' => $coupon->value . ' Euro'
                ]);
            }
        }
        return  $this->setViewAjax([
            'error' => 'Le coupon ' . $code . ' n\'est plus valide',
            'type' => 'error'
        ]);
    }

    /**
     * @throws \Exception
     */
    public function actionFinalize()
    {
        $invoiceId = $this->filter('invoice_id', 'int');
        /** @var Invoices $invoice */
        $invoice = BaseApp::find('App:Invoices', $invoiceId);

        if(!empty($invoice) && $invoice->invoice_state == 0)
        {
            $invoice->finalize();
            $invoice->invoice_state = 1;
            $invoice->invoice_date = BaseApp::time();
            $invoice->save();
        }
        $items = $this->finder('App:ItemsPurchased')
            ->where('invoice_id', $invoiceId)
            ->fetch();

        $viewParams = [
            'items' => $items,
            'cartRepo' => $this->getCartsRepo(),
            'invoice' => $invoice
        ];
        $this->view('carts_finalize', $viewParams);
    }

    /**
     * @return string|Repository|Cart
     */
    protected function getCartsRepo()
    {
        return $this->repository('App:Cart');
    }
}