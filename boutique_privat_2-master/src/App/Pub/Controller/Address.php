<?php


namespace App\Pub\Controller;


use App\Entity\Country;
use Base\BaseApp;
use Base\Mvc\ParameterBag;

class Address extends AbstractController
{
    /**
     * @throws \Exception
     */
    public function actionIndex()
    {
        $addresses = $this->finder('App:Address')
            ->where('user_id', $_SESSION['user_id'])
            ->fetch();
        $viwParams = [
            'addresses' => $addresses
        ];
        $this->view('address', $viwParams);
    }

    /**
     * @param \App\Entity\Address $address
     * @return array
     */
    protected function AddEditAddress(\App\Entity\Address $address)
    {
        $namePage = $address->isInsert()
            ? BaseApp::phrase('add_type:', ['type' => strtolower(BaseApp::phrase('address'))])
            : BaseApp::phrase('edit_type:', ['type' => strtolower(BaseApp::phrase('address'))]) . ' ' . $address->name;
        $output = [];
        $output[''] = [
            'selected' => $address->isInsert(),
            'label' => BaseApp::phrase('none')
        ];
        $countries = $this->finder('App:Country')
            ->order('name')
            ->fetch();
        /** @var Country $country */
        foreach ($countries as $country)
        {
            $output[$country->country_code] =  [
                'selected' =>  ($address->isUpdate() && $address->country_code == $country->country_code),
                'label' => $country->name
            ];
        }
        $params = [
            'namePage' => $namePage,
            'saveURL' => $this->app()->buildLink('Pub:address/save' , $address),
            'nameButton' => 'Save',
            'logoButton' => 'far fa-save',
            'ajax' => true,
            'Input' => [
                'name' => [
                    'type' => 'textbox',
                    'value' => $address->name ? $address->name : '' ,
                    'required' => true,
                    'title' => 'Titre',
                    'description' => "Un nom convivial utilisé pour identifier l'adresse sur l'écran de paiement. Par exemple, \"Domicile\" ou \"Travail\"."
                ],
                'sex' => [
                    'type' => 'radio',
                    'value' => $address->sex ? $address->sex : "m",
                    'title' => 'Category',
                    'description' => "",
                    'InputValue' => [
                        'm' => [
                            'value' => 'm',
                            'name' => 'M.',
                            'input' => []
                        ],
                        'mme' => [
                            'value' => 'mme',
                            'name' => 'Mme.',
                            'input' => []
                        ]
                    ],
                ],
                'first_name' => [
                    'type' => 'textbox',
                    'value' => $address->first_name ? $address->first_name : '',
                    'title' => 'Prénom',
                    'description' => "",
                ],
                'last_name' => [
                    'type' => 'textbox',
                    'value' => $address->last_name ? $address->last_name : '',
                    'title' => 'Nom',
                    'description' => "",
                ],
                'address' => [
                    'type' => 'textbox',
                    'value' => $address->address ? $address->address : '',
                    'title' => 'Adrésse',
                    'description' => "",
                ],
                'additional_address' => [
                    'type' => 'textbox',
                    'value' => $address->additional_address ? $address->additional_address : '',
                    'title' => 'Complément d\'adresse',
                    'description' => "",
                ],
                'country_code' => [
                    'type' => 'selector',
                    'value' => '',
                    'title' => 'Pays',
                    'description' => "",
                    'options' => $output
                ],
                'zip_code' => [
                    'type' => 'textbox',
                    'value' => $address->zip_code ? $address->zip_code : '',
                    'title' => 'Code postal',
                    'description' => "",
                ],
                'city' => [
                    'type' => 'textbox',
                    'value' => $address->city ? $address->city : '',
                    'title' => 'Ville',
                    'description' => "",
                ],
                'cell_phone' => [
                    'type' => 'textbox',
                    'value' => $address->cell_phone ? $address->cell_phone : '',
                    'title' => 'Téléphone portable',
                    'description' => "",
                ],
                'landline_phone' => [
                    'type' => 'textbox',
                    'value' => $address->landline_phone ? $address->landline_phone : '',
                    'title' => 'Téléphone fixe',
                    'description' => "",
                ],
                'redirect' => [
                    'type' => 'hidden',
                    'value' => $this->filter('redirect', 'str')
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
        $address = $this->create('App:Address');
        return $this->AddEditAddress($address);
    }

    /**
     * @param ParameterBag $params
     * @return array
     * @throws \Exception
     */
    public function actionEdit(ParameterBag $params)
    {
        $address = $this->assertAddressExists($params->address_id);
        return $this->AddEditAddress($address);
    }

    /**
     * @param \App\Entity\Address $address
     * @return array
     * @throws \Exception
     */
    protected function saveAddressProcess(\App\Entity\Address $address)
    {
        $entityInput = $this->filter([
            'name' => 'str',
            'sex' => 'str',
            'first_name' => 'str',
            'last_name' => 'str',
            'address' => 'str',
            'additional_address' => 'str',
            'country_code' => 'str',
            'zip_code' => 'str',
            'city' => 'str',
            'cell_phone' => 'str',
            'landline_phone' => 'str'
        ]);
        $errors = [];
        if(empty($entityInput['name']))
        {
            $errors[] = BaseApp::phrase('please_enter_value_for_required_field_x', ['field' => 'name']);
        }
        if(empty($entityInput['first_name']))
        {
            $errors[] = BaseApp::phrase('please_enter_value_for_required_field_x', ['field' => 'Prénom']);
        }
        if(empty($entityInput['last_name']))
        {
            $errors[] = BaseApp::phrase('please_enter_value_for_required_field_x', ['field' => 'Nom']);
        }
        if(empty($entityInput['address']))
        {
            $errors[] = BaseApp::phrase('please_enter_value_for_required_field_x', ['field' => 'adrésse']);
        }
        if(empty($entityInput['country_code']))
        {
            $errors[] = BaseApp::phrase('please_enter_value_for_required_field_x', ['field' => 'pays']);
        }
        if(empty($entityInput['zip_code']))
        {
            $errors[] = BaseApp::phrase('please_enter_value_for_required_field_x', ['field' => 'code postal']);
        }
        elseif (!preg_match ("~^[0-9]{5}$~",$entityInput['zip_code']))
        {
            $errors[] = 'Le code postal n\'est pas valide !';
        }
        if(empty($entityInput['city']))
        {
            $errors[] = BaseApp::phrase('please_enter_value_for_required_field_x', ['field' => 'Ville']);
        }
        if(empty($entityInput['cell_phone']) && empty($entityInput['landline_phone']))
        {
            $errors[] = BaseApp::phrase('please_enter_value_for_required_field_x', ['field' => 'Téléphone portable ou Téléphone fixe']);
        }
        if(empty($errors))
        {
            $address->user_id = $_SESSION['user_id'];
            $address->name = $entityInput['name'];
            $address->sex = $entityInput['sex'];
            $address->first_name = $entityInput['first_name'];
            $address->last_name = $entityInput['last_name'];
            $address->address = $entityInput['address'];
            $address->additional_address = $entityInput['additional_address'];
            $address->country_code = $entityInput['country_code'];
            $address->zip_code = $entityInput['zip_code'];
            $address->city = $entityInput['city'];
            $address->cell_phone = $entityInput['cell_phone'];
            $address->landline_phone = $entityInput['city'];
            $address->save();
        }
        $redirect = $this->filter('redirect', 'str');
        if(empty($redirect))
        {
            $redirect = 'address';
        }
        return $this->setErrorByFromByJason($errors, $this->app()->buildLink('Pub:' . $redirect));
    }

    /**
     * @param ParameterBag $params
     * @return array|\Base\Reply\Redirect|string[]
     * @throws \Exception
     */
    public function actionDelete(ParameterBag $params)
    {
        /** @var \App\Entity\Address $address */
        $address = $this->assertAddressExists($params->address_id);
        if($this->isPost())
        {
            $address->delete();
            return $this->redirect($this->app()->buildLink('Pub:address'));
        }
        else
        {
            $title = $address->name;
            $linkEdit = $this->app()->buildLink('Pub:address/edit', $address);
            $linkDeleted = $this->app()->buildLink('Pub:address/delete', $address);
            return $this->Delete($linkEdit, $linkDeleted, $title);
        }
    }

    /**
     * @param ParameterBag $params
     * @return array
     * @throws \Exception
     */
    public function actionSave(ParameterBag $params)
    {
        if($params->address_id)
        {
            $address = $this->assertAddressExists($params->address_id);
        }
        else
        {
            $address = $this->create('App:Address');
        }

        return $this->saveAddressProcess($address);
    }

    /**
     * @param $id
     * @param null $with
     * @param null $phraseKey
     * @return mixed
     * @throws \Exception
     */
    protected function assertAddressExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('App:Address', $id, $with, $phraseKey);
    }
}