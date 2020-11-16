<?php


namespace App\Admin\Controller;


use App\Repository\categoryTree;
use Base\BaseApp;
use Base\Mvc\ParameterBag;
use Base\Repository;

class Coupon extends AbstractController
{
    public function actionIndex()
    {
        $coupons = $this->finder('App:Coupon')->fetch();
        $viewParams = [
            'coupons' => $coupons
        ];
        $this->view('coupon_list', $viewParams);
    }
    protected function AddEditCoupon(\App\Entity\Coupon $coupon)
    {
        $viewParams = [
            'coupon' => $coupon,
        ];
        $this->view('coupon_edit', $viewParams);
    }
    public function actionAdd()
    {
        $coupon = $this->create('App:Coupon');
        $this->AddEditCoupon($coupon);
    }
    public function actionEdit(ParameterBag $params)
    {
        $coupon = $this->assertCouponExists($params->coupon_id);
        $this->AddEditCoupon($coupon);
    }
    protected function SaveCouponProcess(\App\Entity\Coupon $coupon)
    {
        $entityInput = $this->filter([
            'title' => 'str',
            'code' => 'str',

            'coupon_type' => 'str',
            'percent_value' => 'float',
            'flat_value' => 'float',

            'start_date' => 'datetime',
            'start_time' => 'str',

            'length_amount' => 'uint',
            'length_unit' => 'str',

            'coupon_min' => 'float'
        ]);
        $errors = [];
        if(empty($entityInput['title']))
        {
            $errors[] = BaseApp::phrase('please_enter_value_for_required_field_x', ['field' => 'title']);
        }
        if(empty($entityInput['code']))
        {
            $errors[] = BaseApp::phrase('please_enter_value_for_required_field_x', ['field' => 'code']);
        }
        if($entityInput['coupon_type'] == 'percent')
        {
            if(empty($entityInput['percent_value']))
            {
                $errors[] = BaseApp::phrase('please_enter_value_for_required_field_x', ['field' => 'pourcentage']);
            }
            else
            {
                $coupon->value = $entityInput['percent_value'];
            }
        }
        else
        {
            if(empty($entityInput['flat_value']))
            {
                $errors[] = BaseApp::phrase('please_enter_value_for_required_field_x', ['field' => 'valeur']);
            }
            else
            {
                $coupon->value = $entityInput['flat_value'];
            }
        }
        if($coupon->isInsert())
        {
            if(empty($entityInput['length_amount']))
            {
                $errors[] = BaseApp::phrase('please_enter_value_for_required_field_x', ['field' => 'longeur']);
            }
        }

        if(empty($errors))
        {
            $coupon->title = $entityInput['title'];
            $coupon->code = $entityInput['code'];
            $coupon->coupon_type = $entityInput['coupon_type'];
            $coupon->content_type = 'coupon_all';
            $coupon->start_date = $this->setStartDate($entityInput['start_date'], $entityInput['start_time']);
            if($coupon->isInsert())
            {
                $coupon->end_date = $this->setDuration($entityInput['length_amount'], $entityInput['length_unit'], $coupon);
            }
            else
            {
                $length = $this->filter([
                    'length_amount_update' => 'datetime',
                    'length_unit_update' => 'str',
                ]);
                $coupon->end_date = $this->setStartDate($length['length_amount_update'], $length['length_unit_update']);
            }
            $coupon->coupon_min = $entityInput['coupon_min'];
            $coupon->save();

        }
        return $this->setErrorByFromByJason($errors, $this->app()->buildLink('admin:coupon'));
    }

    /**
     * @param $date
     * @param $time
     * @return int
     * @throws \Exception
     */
    protected function setStartDate($date, $time)
    {
        $language = BaseApp::date();

        $dateTime = new \DateTime('@' . $date);
        $dateTime->setTimezone($language->getTimeZone());

        if (!$time || strpos($time, ':') === false)
        {
            $hours = $language->date(BaseApp::time(), 'H');
            $minutes = $language->date(BaseApp::time(), 'i');
        }
        else
        {
            list($hours, $minutes) = explode(':', $time);
            $hours = min((int)$hours, 23);
            $minutes = min((int)$minutes, 59);
        }
 
        $dateTime->setTime($hours, $minutes);

        return $dateTime->getTimestamp();
    }

    /**
     * @param $amount
     * @param $unit
     * @param \App\Entity\Coupon $coupon
     * @return false|int
     */
    public function setDuration($amount, $unit, \App\Entity\Coupon $coupon)
    {
        return strtotime('+' . $amount . ' ' . $unit, $coupon->start_date);
    }

    /**
     * @param ParameterBag $params
     * @return array
     * @throws \Exception
     */
    public function actionSave(ParameterBag $params)
    {
        if($params->coupon_id)
        {
            $coupon = $this->assertCouponExists($params->coupon_id);
        }
        else
        {
            $coupon = $this->create('App:Coupon');
        }
        return $this->SaveCouponProcess($coupon);
    }
    /**
     * @return categoryTree|Repository
     */
    protected function getRepoCategoryTree()
    {
        return $this->repository('App:categoryTree');
    }

    /**
     * @param $id
     * @param null $with
     * @param null $phraseKey
     * @return mixed
     * @throws \Exception
     */
    protected function assertCouponExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('App:Coupon', $id, $with, $phraseKey);
    }
}