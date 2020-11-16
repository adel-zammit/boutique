<?php


namespace App\Pub\Controller;


use App\Repository\Cart;
use Base\Mvc\ParameterBag;
use Base\Repository;

class Invoices extends AbstractController
{
    /**
     * @param ParameterBag $params
     * @return mixed
     * @throws \Exception
     */
    public function actionIndex(ParameterBag $params)
    {
        if($params->invoice_id)
        {
            return $this->rerouteController(__CLASS__,'View',$params);
        }
        $invoice = $this->finder('App:Invoices')
            ->where([
                'user_id' => $_SESSION['user_id'],
                ['invoice_state', '!=', 0 ]
            ])->fetch();
        $viewParams = [
            'invoices' => $invoice,
            'cartRepo' => $this->getCartsRepo()
        ];
        $this->view('invoices_list', $viewParams);
    }

    /**
     * @param ParameterBag $params
     * @throws \Exception
     */
    public function actionView(ParameterBag $params)
    {
        $invoice = $this->assertInvoiceExists($params->invoice_id);
        $viewParams = [
            'invoice' => $invoice,
            'cartRepo' => $this->getCartsRepo()
        ];
        $this->view('invoice_view', $viewParams);
    }

    /**
     * @param $id
     * @param null $with
     * @param null $phraseKey
     * @return mixed
     * @throws \Exception
     */
    protected function assertInvoiceExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('App:Invoices', $id, $with, $phraseKey);
    }

    /**
     * @return string|Repository|Cart
     */
    protected function getCartsRepo()
    {
        return $this->repository('App:Cart');
    }
}

