<?php
namespace App\Admin\Controller;

class Home extends AbstractController
{
    public function actionIndex()
    {
        $this->view('Home');
    }
}