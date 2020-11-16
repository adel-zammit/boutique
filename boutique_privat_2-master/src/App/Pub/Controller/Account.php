<?php


namespace App\Pub\Controller;


use Base\BaseApp;

class Account extends AbstractController
{
    public function actionIndex()
    {
        $this->view('account');
    }
    public function actionSave()
    {
        $user = BaseApp::visitor();
        $entityInput = $this->filter([
            'username' => 'str',
            'email' => 'str'
        ]);
        $errors = [];
        if (strlen($entityInput['username']) > 4) {
            $errors[] = $this->BaseApp()->phrase('the_login_must_have_more_than_4_characters');
        }
        if (!filter_var($entityInput['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = $this->BaseApp()->phrase('the_e_mail_address_is_not_valid');
        }
        if(empty($errors))
        {
            $user->username = $entityInput['username'];
            $user->email = $entityInput['email'];
            $user->save();
        }
        return $this->setErrorByFromByJason($errors, $this->app()->buildLink('Pub:account'));
    }
}