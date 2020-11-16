<?php
namespace App\Pub\Controller;


use App\Entity\User;

class Home extends AbstractController
{
    public function actionIndex()
    {
        $reviews = $this->finder('App:Review')
        ->order('review_date', 'DESC')->limit(5)->fetch();
        $viewParams = [
            'reviews' => $reviews,
            'ttetete' => 'tetee'
        ];
        $this->view('Home', $viewParams);
    }

}