<?php


namespace App\Admin\Controller;


use App\Entity\Country;
use Base\BaseApp;
use Base\Mvc\ParameterBag;

class SalesTax extends AbstractController
{
    /**
     * @param ParameterBag $params
     * @throws \Exception
     */
    public function actionIndex(ParameterBag $params )
    {
        $perPage = 30;
        $page = $params->page;
        $countries = $this->finder('App:Country')
            ->order('name')
            ->where('sales_tax_rate', '!=', -0.001);

        $countries->limitByPage($page, $perPage);
        $viewParams = [
            'countries' => $countries->fetch(),
            'total' => $countries->total()
        ];
        $this->view('countries_list', $viewParams);
    }

    /**
     *
     */
    public function actionAdd()
    {
        $countries = $this->finder('App:Country')
            ->order('name')
            ->fetch();

        $viewParams = [
            'countries' => $countries
        ];
        $this->view('country_add', $viewParams);
    }

    /**
     * @param ParameterBag $params
     * @throws \Exception
     */
    public function actionEdit(ParameterBag $params)
    {
        /** @var Country $country */
        $country = $this->assertCountryExists($params->country_code);
        $viewParams = [
            'country' => $country
        ];

        $this->view('country_edit', $viewParams);
    }

    /**
     * @param ParameterBag $params
     * @return array
     * @throws \Exception
     */
    public function actionSave(ParameterBag $params)
    {
        if($params->country_code)
        {
            /** @var Country $country */
            $country = $this->assertCountryExists($params->country_code);
            $input = $this->filter('sales_tax_rate', 'float');
            $country->sales_tax_rate = $input;
            $country->save();
        }
        else
        {
            $countryCode = $this->filter('country', 'str');

            /** @var Country $country */
            $country = $this->assertCountryExists($countryCode);
            $country->sales_tax_rate = $this->filter('sales_tax_rate', 'float');
            $country->save();
        }

        return $this->setErrorByFromByJason([], $this->app()->buildLink('admin:sales-tax'));
    }

    /**
     * @param $id
     * @param null $with
     * @param null $phraseKey
     * @return mixed
     * @throws \Exception
     */
    protected function assertCountryExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('App:Country', $id, $with, $phraseKey);
    }
}