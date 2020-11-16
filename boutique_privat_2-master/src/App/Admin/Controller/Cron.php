<?php

namespace App\Admin\Controller;

use Base\BaseApp;
use Base\Cron\AbstractCron;
use Base\Mvc\ParameterBag;

/**
 * Class Cron
 * @package App\Admin\Controller
 */
class Cron extends AbstractController
{
    /**
     *
     */
    public function actionIndex()
    {
//        foreach (json_decode($raw) as $value)
//        {
//            var_dump($value->name);
//        }
        $cronS = $this->finder('App:Cron')
            ->order('last_exe', 'DESC')
            ->fetch();
        $viewParams = [
            'cronS' => $cronS
        ];
        $this->view('cron_list', $viewParams);
    }

    /**
     * @param \App\Entity\Cron $cron
     * @return array
     */
    protected function AddEditCron(\App\Entity\Cron $cron)
    {
        $params = [
            'namePage' => 'Add category',
            'saveURL' => $this->app()->buildLink('admin:cron/save', $cron),
            'nameButton' => 'Save',
            'logoButton' => 'far fa-save',
            'ajax' => true,
            'Input' => [
                'title' => [
                    'type' => 'textbox',
                    'value' => $cron->title ? $cron->title : '',
                    'title' => 'Title',
                    'description' => ""
                ],
                'description' => [
                    'type' => 'textbox',
                    'value' => $cron->description ? $cron->description : '',
                    'title' => 'Description',
                    'description' => "",
                ],
                'cron_exe' => [
                    'type' => 'textbox',
                    'value' => $cron->cron_exe ? $cron->cron_exe : '',
                    'title' => 'Cron callback',
                    'description' => "",
                ]

            ]
        ];
        return $this->formAjax($params);
    }

    /**
     * @return array
     */
    public function actionAdd()
    {
        /** @var \App\Entity\Cron $cron */
        $cron = $this->create('App:Cron');
        return $this->AddEditCron($cron);
    }

    /**
     * @param ParameterBag $params
     * @return array
     * @throws \Exception
     */
    public function actionEdit(ParameterBag $params)
    {
        /** @var \App\Entity\Cron $cron */
        $cron = $this->assertCronExists($params->cron_id);
        return $this->AddEditCron($cron);
    }

    /**
     * @param \App\Entity\Cron $cron
     * @return array
     * @throws \Exception
     */
    protected function saveCronProcess(\App\Entity\Cron $cron)
    {
        $entityInput = $this->filter([
            'title' => 'str',
            'description' => 'str',
            'cron_exe' => 'str'
        ]);
        $errors = [];
        if(empty($entityInput['title']))
        {
            $errors[] = BaseApp::phrase('please_enter_value_for_required_field_x', ['field' => 'title']);
        }
        if(empty($entityInput['description']))
        {
            $errors[] = BaseApp::phrase('please_enter_value_for_required_field_x', ['field' => 'Description']);
        }
        if(empty($entityInput['cron_exe']))
        {
            $errors[] = BaseApp::phrase('please_enter_value_for_required_field_x', ['field' => 'Cron execute']);
        }
        if(empty($errors))
        {
            $cron->title = $entityInput['title'];
            $cron->description = $entityInput['description'];
            $cron->cron_exe = $entityInput['cron_exe'];
            $cron->save();
        }
        return $this->setErrorByFromByJason($errors, $this->app()->buildLink('admin:cron'));
    }

    /**
     * @param ParameterBag $params
     * @return array
     * @throws \Exception
     */
    public function actionSave(ParameterBag $params)
    {
        if($params->cron_id)
        {
            /** @var \App\Entity\Cron $cron */
            $cron = $this->assertCronExists($params->cron_id);
        }
        else
        {
            /** @var \App\Entity\Cron $cron */
            $cron = $this->create('App:Cron');
        }

        return $this->saveCronProcess($cron);
    }

    /**
     * @param ParameterBag $params
     * @throws \Exception
     */
    public function actionExecute(ParameterBag $params)
    {
        /** @var \App\Entity\Cron $cron */
        $cron = $this->assertCronExists($params->cron_id);
        $executeCron = $this->executeCron($cron->cron_exe);
        $error = $executeCron->run();
        if(is_bool($error) && $error)
        {
            $cron->last_exe = BaseApp::time();
            $cron->save();
        }


        $viewParams = [
            'error' => $error
        ];
        $this->view('cron_exe', $viewParams);
    }

    /**
     * @param $shortName
     * @return AbstractCron
     */
    protected function executeCron($shortName)
    {
        $stringCron = $this->getCronToClass($shortName);
        return new $stringCron($shortName, $stringCron);
    }
    /**
     * @param $shortName
     * @return string
     */
    protected function getCronToClass($shortName)
    {
        return BaseApp::stringToClass($shortName, '%s\Cron\%s');
    }

    /**
     * @param $id
     * @param null $with
     * @param null $phraseKey
     * @return mixed
     * @throws \Exception
     */
    protected function assertCronExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('App:Cron', $id, $with, $phraseKey);
    }
}