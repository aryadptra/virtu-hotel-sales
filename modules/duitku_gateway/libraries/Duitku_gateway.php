<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Duitku_gateway extends App_gateway
{
    public function __construct()
    {
        /**
         * Call App_gateway __construct function
         */
        parent::__construct();

        /**
         * Gateway unique id - REQUIRED
         * 
         * * The ID must be alphanumeric
         * * The filename (Duitku_gateway.php) and the class name must contain the id as ID_gateway
         * * In this case our id is "example"
         * * Filename will be Example_gateway.php (first letter is uppercase)
         * * Class name will be Example_gateway (first letter is uppercase)
         */
        $this->setId('duitku');

        /**
         * REQUIRED
         * Gateway name
         */
        $this->setName('Duitku');

        /**
         * Add gateway settings
         * You can add other settings here 
         * to fit for your gateway requirements
         *
         * Currently only 3 field types are accepted for gateway
         *
         * 'type'=>'yes_no'
         * 'type'=>'input'
         * 'type'=>'textarea'
         *
         */
        $this->setSettings(array(

            array(
                'name' => 'merchant_code',
                'encrypted' => true,
                'label' => 'Merchant Code',
                'type' => 'input',
            ),
            array(
                'name' => 'api_key_developmnent',
                'encrypted' => true,
                'label' => 'Development API Key',
                'type' => 'input',
            ),
            array(
                'name' => 'token_developmnent',
                'label' => 'Development Callback Token',
                'type' => 'input',
                'field_attributes' => ['disabled' => 'disabled'],
            ),
            array(
                'name' => 'api_key_production',
                'encrypted' => true,
                'label' => 'Production API Key',
                'type' => 'input',
            ),
            array(
                'name' => 'token_production',
                'label' => 'Production Callback Token',
                'type' => 'input',
                'field_attributes' => ['disabled' => 'disabled'],
                'after'            => '<hr>',
            ),
            array(
                'name' => 'currencies',
                'label' => 'settings_paymentmethod_currencies',
                'default_value' => 'IDR'
            ),
            array(
                'name'          => 'is_development',
                'type'          => 'yes_no',
                'default_value' => 1,
                'label'         => 'settings_paymentmethod_testing_mode',
                'after'            => '<hr>',

            ),
        ));
    }
    /**
     * Get token from duitku
     * @return booelan
     */
    private function getApiKey()
    {
        if ($this->getSetting('is_development')) {
            return $this->decryptSetting('api_key_developmnent');
        } else {
            return $this->decryptSetting('api_key_production');
        }
    }

    /**
     * Each time a customer click PAY NOW button on the invoice HTML area, the script will process the payment via this function.
     * You can show forms here, redirect to gateway website, redirect to Codeigniter controller etc..
     * @param  array $data - Contains the total amount to pay and the invoice information
     * @return mixed
     */
    public function process_payment($data)
    {
        var_dump($data);
        die;
    }
}
