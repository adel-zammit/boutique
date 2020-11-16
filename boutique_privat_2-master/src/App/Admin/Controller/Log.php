<?php


namespace App\Admin\Controller;


use App\Entity\AddressInvoiceLog;
use App\Entity\Carts;
use App\Entity\CouponLog;
use App\Entity\Invoices;
use App\Entity\ItemsPurchased;
use Base\BaseApp;
use Base\Entity\PaymentProviderLog;
use Base\Entity\PurchaseRequest;
use Base\Mvc\ParameterBag;

/**
 * Class Log
 * @package App\Admin\Controller
 */
class Log extends AbstractController
{
    /**
     *
     */
    public function actionIndex()
    {

    }

    /**
     * @param ParameterBag $params
     * @return mixed
     */
    public function actionCoupon(ParameterBag $params)
    {
        if($params->coupon_log_id)
        {
            return $this->rerouteController(__CLASS__, 'CouponView', $params);
        }
        $couponsLogs = $this->finder('App:CouponLog')
            ->order('coupon_date');

        $page = $params->page;
        $perPage = 20;
        $couponsLogs->limitByPage($page, $perPage);

        $viewParams = [
            'couponsLogs' => $couponsLogs->fetch(),
            'total' => $couponsLogs->total(),

            'page' => $page,
            'perPage' => $perPage
        ];
        $this->view('coupon_log_list', $viewParams);
    }

    /**
     * @param ParameterBag $params
     * @return array
     * @throws \Exception
     */
    public function actionCouponView(ParameterBag $params)
    {
        /** @var CouponLog $couponLog */
        $couponLog = $this->assertCouponLogExists($params->coupon_log_id);
        $params = [
            'namePage' => BaseApp::phrase('Coupon_log') . ' #' . $couponLog->coupon_log_id,
            'contents' => [
                'block1' => [
                    'user' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('user'),
                        'value' => $couponLog->username
                    ],
                    'date' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('date'),
                        'value' => BaseApp::renderHtmlDate($couponLog->coupon_date)
                    ],
                    'hr1' => [
                        'type' => 'hr',
                    ],
                    'coupon' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('coupon'),
                        'value' => $couponLog->coupon_code
                    ],
                    'title' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('coupon_title'),
                        'value' => $couponLog->coupon_name
                    ],
                    'hr2' => [
                        'type' => 'hr',
                    ],
                    'discount_type' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('discount_type'),
                        'value' => BaseApp::phrase('coupon_' . $couponLog->coupon_type)
                    ],
                    'price_total_hor_coupon' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('price_total_x', ['value' => 'sans coupon']),
                        'value' => $couponLog->total_price
                    ],
                    'price_total_coupon' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('price_total_x', ['value' => 'avec coupon']),
                        'value' => $couponLog->price
                    ],
                    'invoice' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('invoice'),
                        'value' => '#' . $couponLog->Invoice->invoice_id
                    ],
                ]
            ]
        ];
        return $this->displayInfo($params);
    }

    /**
     * @param ParameterBag $params
     * @return mixed
     */
    public function actionOrder(ParameterBag $params)
    {
        if($params->invoice_id)
        {
            return $this->rerouteController(__CLASS__, 'OrderView', $params);
        }
        $invoice = $this->finder('App:Invoices')
            ->order('invoice_date');

        $page = $params->page;
        $perPage = 20;
        $invoice->limitByPage($page, $perPage);

        $viewParams = [
            'invoices' => $invoice->fetch(),
            'total' => $invoice->total(),

            'page' => $page,
            'perPage' => $perPage
        ];
        $this->view('invoices_list', $viewParams);
    }

    /**
     * @param ParameterBag $params
     * @return array
     * @throws \Exception
     */
    public function actionOrderView(ParameterBag $params)
    {
        /** @var Invoices $invoice */
        $invoice = $this->assertInvoicesExists($params->invoice_id);
        $output = [];
        if($invoice->invoice_state == 0)
        {
            /** @var Carts $cart */
            foreach ($invoice->Carts as $cart)
            {
                $output[$cart->cart_id] = [
                    'type' => 'value',
                    'label' => '',
                    'value' => $cart->Product->title . '<div class="u-muted">' . $invoice->formatPrice($cart->getPrice()) . '</div>'
                ];
            }
        }
        else
        {
            /** @var ItemsPurchased $item */
            foreach ($invoice->ItemsPurchased as $item)
            {
                $output[$item->purchased_id] = [
                    'type' => 'value',
                    'label' => '',
                    'value' => $item->Product->title . '<div class="u-muted">' . $invoice->formatPrice($item->getPrice()) . '</div>'
                ];
            }
        }
        $params = [
            'namePage' => BaseApp::phrase('order') . ' #' . $invoice->invoice_id,
            'contents' => [
                'block1' => [
                    'user' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('user'),
                        'value' => $invoice->User->username
                    ],
                    'date' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('date'),
                        'value' => BaseApp::renderHtmlDate($invoice->invoice_date)
                    ],
                    'purchase_request_key' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('purchase_request_key'),
                        'value' => $invoice->request_key ? $invoice->request_key : $this->BaseApp()->phrase('n_a')
                    ],
                    'order_state' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('order_state'),
                        'value' => $invoice->getSateLite()
                    ],
                    'order_total' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('order_total'),
                        'value' => $invoice->getTotalPrice()
                    ],
                    'address' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('address'),
                        'value' => $invoice->getAddress($this->app()->buildLink('admin:address/edit', $invoice->Address))
                    ],
                    'h3simple1' => [
                        'type' => 'h3simple',
                        'value' => BaseApp::phrase('items')
                    ],
                    'array1' => [
                        'type' => 'array',
                        'value' => $output
                    ],
                    'h3simple2' => [
                        'type' => 'h3simple',
                        'value' => BaseApp::phrase('payment_info')
                    ],
                    'sub_total' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('sub_total'),
                        'value' => $invoice->getPrice()
                    ],
                    'hr2' => [
                        'type' => 'hr',
                    ],
                    'sale_discount' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('sale_discount'),
                        'value' => $invoice->getSaleDiscount()
                    ],
                    'sales_tax' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('sales_tax'),
                        'value' => '+' . $invoice->formatPrice($invoice->sales_tax_rate)
                    ],
                    'hr3' => [
                        'type' => 'hr',
                    ],
                    'order_total2' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('order_total'),
                        'value' => $invoice->getTotalPrice()
                    ],
                ]
            ]
        ];
        return $this->displayInfo($params);
    }

    /**
     * @param ParameterBag $params
     * @return mixed
     */
    public function actionPayment(ParameterBag $params)
    {
        if($params->provider_log_id)
        {
            return $this->rerouteController(__CLASS__, 'PaymentView', $params);
        }
        $payments = $this->finder('Base:PaymentProviderLog')
            ->order('log_date');

        $page = $params->page;
        $perPage = 20;
        $payments->limitByPage($page, $perPage);

        $viewParams = [
            'payments' => $payments->fetch(),
            'total' => $payments->total(),

            'page' => $page,
            'perPage' => $perPage
        ];
        $this->view('payment_list', $viewParams);
    }

    /**
     * @param ParameterBag $params
     * @return array
     * @throws \Exception
     */
    public function actionPaymentView(ParameterBag $params)
    {
        /** @var PaymentProviderLog $payment */
        $payment = $this->assertPaymentExists($params->provider_log_id);
        /** @var PurchaseRequest $PurchaseRequest */
        $PurchaseRequest = $payment->PurchaseRequest;
        $purchasableItem = $PurchaseRequest->getHandler()->getPurchasableFromExtraData($PurchaseRequest->extra_data);
        $params = [
            'namePage' => BaseApp::phrase('payment_provider_log') . ' #' . $payment->provider_log_id,
            'contents' => [
                'block1' => [
                    'action' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('action'),
                        'value' => $payment->log_message
                    ],
                    'user' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('user'),
                        'value' => $PurchaseRequest->User->username,
                    ],
                    'date' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('date'),
                        'value' => BaseApp::renderHtmlDate($payment->log_date),
                    ],
                    'purchase_request_key' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('purchase_request_key'),
                        'value' => $payment->purchase_request_key,
                    ],
                    'transaction_id' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('transaction_id'),
                        'value' => $payment->transaction_id,
                    ],
                    'payment_profile' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('payment_profile'),
                        'value' => $payment->provider_id,
                    ]
                ],
                'block2' => [
                    'purchasable_details' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('purchasable_details'),
                        'value' => BaseApp::phrase('payment_type_' . $PurchaseRequest->purchasable_type_id)
                    ],
                    'purchasable_item' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('purchasable_item'),
                        'link' => $purchasableItem['link'],
                        'value' => $purchasableItem['title'],
                    ],
                ],
                'block3' => [
                    'log_details' => [
                        'type' => 'h2',
                        'h2' => BaseApp::phrase('log_details'),
                        'value' => BaseApp::dumpSimple($payment->log_details, false)
                    ],
                ]
            ]
        ];
        return $this->displayInfo($params);
    }

    /**
     * @param ParameterBag $params
     * @return mixed
     */
    public function actionAddresses(ParameterBag $params)
    {
        if($params->address_id && $params->invoice_id)
        {
            return $this->rerouteController(__CLASS__, 'AddressesView', $params);
        }
        $addresses = $this->finder('App:AddressInvoiceLog')
            ->order('log_date');

        $page = $params->page;
        $perPage = 20;
        $addresses->limitByPage($page, $perPage);

        $viewParams = [
            'addressesLog' => $addresses->fetch(),
            'total' => $addresses->total(),

            'page' => $page,
            'perPage' => $perPage
        ];
        $this->view('addresses_log_list', $viewParams);
    }
    public function actionAddressesView(ParameterBag $params)
    {
        /** @var AddressInvoiceLog $addressesLog */
        $addressesLog = $this->assertAddressesLogExists([$params->address_id, $params->invoice_id]);
        $params = [
            'namePage' => BaseApp::phrase('addresses_log'),
            'contents' => [
                'block1' => [
                    'address_name' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('address_name'),
                        'value' => $addressesLog->address_name
                    ],
                    'user' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('user'),
                        'value' => $addressesLog->User->username,
                    ],
                    'invoice_id' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('invoice'),
                        'link' => $this->app()->buildLink('admin:log/order', $addressesLog->Invoice),
                        'value' => BaseApp::phrase('n_0') . $addressesLog->invoice_id
                    ],
                    'log_date' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('date'),
                        'value' => BaseApp::renderHtmlDate($addressesLog->log_date)
                    ],
                    'h3simple1' => [
                        'type' => 'h3simple',
                        'value' => BaseApp::phrase('Address')
                    ],
                    'first_name' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('first_name'),
                        'value' => $addressesLog->first_name,
                    ],
                    'last_name' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('last_name'),
                        'value' =>  $addressesLog->last_name
                    ],
                    'sex' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('sex'),
                        'value' => BaseApp::phrase('sex_' . $addressesLog->sex)
                    ],
                    'address' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('address'),
                        'value' => $addressesLog->address
                    ],
                    'additional_address' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('additional_address'),
                        'value' => ($addressesLog->additional_address ? $addressesLog->additional_address : BaseApp::phrase('n_a'))
                    ],
                    'zip_code' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('zip_code'),
                        'value' => $addressesLog->zip_code
                    ],
                    'city' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('city'),
                        'value' => $addressesLog->city
                    ],
                    'cell_phone' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('cell_phone'),
                        'value' => $addressesLog->cell_phone
                    ],
                    'landline_phone' => [
                        'type' => 'value',
                        'label' => BaseApp::phrase('landline_phone'),
                        'value' => $addressesLog->landline_phone
                    ],
                ],
            ]
        ];
        return $this->displayInfo($params);
    }
    /**
     * @param $id
     * @param null $with
     * @param null $phraseKey
     * @return mixed
     * @throws \Exception
     */
    protected function assertCouponLogExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('App:CouponLog', $id, $with, $phraseKey);
    }

    /**
     * @param $id
     * @param null $with
     * @param null $phraseKey
     * @return mixed
     * @throws \Exception
     */
    protected function assertInvoicesExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('App:Invoices', $id, $with, $phraseKey);
    }

    /**
     * @param $id
     * @param null $with
     * @param null $phraseKey
     * @return mixed
     * @throws \Exception
     */
    protected function assertPaymentExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('Base:PaymentProviderLog', $id, $with, $phraseKey);
    }

    /**
     * @param $id
     * @param null $with
     * @param null $phraseKey
     * @return mixed
     * @throws \Exception
     */
    protected function assertAddressesLogExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('App:AddressInvoiceLog', $id, $with, $phraseKey);
    }
}