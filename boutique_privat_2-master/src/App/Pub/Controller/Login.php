<?php


namespace App\Pub\Controller;


use App\Entity\Carts;
use App\Entity\User;
use Base\BaseApp;
use Base\Mvc\ParameterBag;

class Login extends AbstractController
{
    public function getContext()
    {
        return ['actionRegister' => 'register'];
    }

    public function actionIndex()
    {
        if (isset($_SESSION['user_id'])) {
            return $this->redirect($this->app()->buildLink('Pub:'));
        }

        $this->view('connexion', [], $this->BaseApp()->phrase('connexion'));
    }

    public function actionLogin()
    {
        $entityInput = $this->filter([
            'login' => 'str',
            'password' => 'str'
        ]);
        $errors = [];
        $redirect = $this->filter('redirect', 'str');
        if ($entityInput['login'] && $entityInput['password']) {
            $user = $this->finder('App:User')->where('username', $entityInput['login'])->fetchOne();
            if (empty($user)) {
                $errors[] = $this->BaseApp()->phrase('incorrect_login_or_password');
            } else {
                if (!password_verify($entityInput['password'], $user->password)) {
                    $errors[] = $this->BaseApp()->phrase('incorrect_login_or_password');
                }
                if (empty($errors)) {
                    $this->setCarts($user->user_id);
                    $_SESSION['user_id'] = $user->user_id;
                }
            }
        } else {
            $errors[] = $this->BaseApp()->phrase('please_enter_all_fields');
        }

        if (!empty($redirect)) {
            $link = $this->app()->buildLink('Pub:' . $redirect);
        } else {
            $link = $this->app()->buildLink('Pub:');
        }

        return $this->setErrorByFromByJason($errors, $link);
    }

    public function actionRegister()
    {
        if (isset($_SESSION['user_id'])) {
            return $this->redirect($this->app()->buildLink('Pub:'));
        }
        if ($this->isPost()) {
            $entityInput = $this->filter([
                'username' => 'str',
                'password' => 'str',
                'confPassword' => 'str',
                'email' => 'str'
            ]);
            $errors = [];
            $testUser = $this->finder('App:User')
                ->where('username', $entityInput['username'])
                ->total();
            if ($testUser) {
                $errors[] = $this->BaseApp()->phrase('login_is_already_taken');
            }
            if ($entityInput['confPassword'] != $entityInput['password']) {
                $errors[] = $this->BaseApp()->phrase('The_passwords_don_t_match');
            }
            if (!filter_var($entityInput['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = $this->BaseApp()->phrase('the_e_mail_address_is_not_valid');
            }
            if (strlen($entityInput['username']) < 4) {
                $errors[] = $this->BaseApp()->phrase('the_login_must_have_more_than_4_characters');
            }
            if (empty($errors)) {
                /** @var User $user */
                $user = $this->create('App:User');
                $user->username = $entityInput['username'];
                $user->password = password_hash($entityInput['password'], PASSWORD_BCRYPT, ['cost' => 15]);
                $user->email = $entityInput['email'];
                $user->save();
                return $this->redirect($this->app()->buildLink('Pub:login'));
            } else {
                $this->setMessages($errors);
            }
        }
        $this->view('register', [], $this->BaseApp()->phrase('registration'));
    }

    protected function setCarts($userId)
    {
        $carts = $_SESSION['cart_product_id'];
        foreach ($carts as $cart) {
            /** @var Carts $createCart */
            $createCart = $this->create('App:Carts');
            $createCart->user_id = $userId;
            $createCart->product_id = $cart[0];
            $createCart->quantity = $cart[1];
            $createCart->save();
        }
        $_SESSION['cart_product_id'] = [];
    }

    public function actionLogout()
    {
        if (isset($_SESSION['user_id'])) {
            session_destroy();
            return $this->redirect($this->app()->buildLink('Pub:'));
        }
        return $this->redirect($this->app()->buildLink('Pub:login'));
    }
}