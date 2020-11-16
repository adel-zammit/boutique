<?php


namespace App\Admin\Controller;


use App\Entity\User;
use Base\BaseApp;

class Connexion extends AbstractController
{
    public function actionIndex()
    {
        if($this->isPost())
        {
            $entityInput = $this->filter([
                'username' => 'str',
                'password' => 'str',
            ]);

            /** @var User $user */
            $user = $this->finder('App:User')
                ->where('username', $entityInput['username'])
                ->fetchOne();
            $errors = [];
            if(empty($user))
            {
                $errors[] = $this->BaseApp()->phrase('login_incorrect');
            }
            if(!empty($user) && !password_verify($entityInput['password'], $user->password))
            {
                $errors[] = $this->BaseApp()->phrase('incorrect_password');
            }
            if(!empty($user) && !$user->is_admin)
            {
                $errors[] = $this->BaseApp()->phrase('no_privilege_admin');
            }
            if(empty($errors))
            {
                BaseApp::request()->setSession('user_id', $user->user_id);
                BaseApp::request()->setSession('is_admin', 1);
                return $this->redirect($this->app()->buildLink('admin:'));
            }
            else
            {
                $this->setMessages($errors);
            }
        }
        $this->view('connexion');
    }
}