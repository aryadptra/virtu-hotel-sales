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
     * Request to get payment method
     *
     * @return void
     */
    public function getPaymentMethods()
    {
        // Set kode merchant anda 
        $merchantCode = $this->decryptSetting('merchant_code');

        // Set merchant key anda 
        $apiKey = $this->getApiKey();

        $datetime = date('Y-m-d H:i:s');
        $paymentAmount = 10000;
        $signature = hash('sha256', $merchantCode . $paymentAmount . $datetime . $apiKey);

        $params = array(
            'merchantcode' => $merchantCode,
            'amount' => $paymentAmount,
            'datetime' => $datetime,
            'signature' => $signature
        );

        $params_string = json_encode($params);

        $url = 'https://sandbox.duitku.com/webapi/api/merchant/paymentmethod/getpaymentmethod';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($params_string)
            )
        );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        //execute post
        $request = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode == 200) {
            $results = json_decode($request, true);
            print_r($results, false);
        } else {
            $request = json_decode($request);
            $error_message = "Server Error " . $httpCode . " " . $request->Message;
            echo $error_message;
        }
    }

    /**
     * Request transactions
     */
    public function requestTransaction()
    {
        $merchantCode = $this->decryptSetting('merchant_code');
        $apiKey = $this->getApiKey();
        $paymentAmount = 40000;
        $paymentMethod = 'BT'; // VC = Credit Card
        $merchantOrderId = time() . ''; // dari merchant, unik
        $productDetails = 'Tes pembayaran menggunakan Duitku';
        $email = 'test@test.com'; // email pelanggan anda
        $phoneNumber = '08123456789'; // nomor telepon pelanggan anda (opsional)
        $additionalParam = ''; // opsional
        $merchantUserInfo = ''; // opsional
        $customerVaName = 'John Doe'; // tampilan nama pada tampilan konfirmasi bank
        $callbackUrl = 'http://example.com/callback'; // url untuk callback
        $returnUrl = 'http://example.com/return'; // url untuk redirect
        $expiryPeriod = 10; // atur waktu kadaluarsa dalam hitungan menit
        $signature = md5($merchantCode . $merchantOrderId . $paymentAmount . $apiKey);

        // Customer Detail
        $firstName = "John";
        $lastName = "Doe";

        // Address
        $alamat = "Jl. Kembangan Raya";
        $city = "Jakarta";
        $postalCode = "11530";
        $countryCode = "ID";

        $address = array(
            'firstName' => $firstName,
            'lastName' => $lastName,
            'address' => $alamat,
            'city' => $city,
            'postalCode' => $postalCode,
            'phone' => $phoneNumber,
            'countryCode' => $countryCode
        );

        $customerDetail = array(
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'phoneNumber' => $phoneNumber,
            'billingAddress' => $address,
            'shippingAddress' => $address
        );

        $item1 = array(
            'name' => 'Test Item 1',
            'price' => 10000,
            'quantity' => 1
        );

        $item2 = array(
            'name' => 'Test Item 2',
            'price' => 30000,
            'quantity' => 3
        );

        $itemDetails = array(
            $item1, $item2
        );

        /*Khusus untuk metode pembayaran OL dan SL
    $accountLink = array (
        'credentialCode' => '7cXXXXX-XXXX-XXXX-9XXX-944XXXXXXX8',
        'ovo' => array (
            'paymentDetails' => array ( 
                0 => array (
                    'paymentType' => 'CASH',
                    'amount' => 40000,
                ),
            ),
        ),
        'shopee' => array (
            'useCoin' => false,
            'promoId' => '',
        ),
    );*/

        /*Khusus untuk metode pembayaran Kartu Kredit
    $creditCardDetail = array (
        'acquirer' => '014',
        'binWhitelist' => array (
            '014',
            '400000'
        )
    );*/

        $params = array(
            'merchantCode' => $merchantCode,
            'paymentAmount' => $paymentAmount,
            'paymentMethod' => $paymentMethod,
            'merchantOrderId' => $merchantOrderId,
            'productDetails' => $productDetails,
            'additionalParam' => $additionalParam,
            'merchantUserInfo' => $merchantUserInfo,
            'customerVaName' => $customerVaName,
            'email' => $email,
            'phoneNumber' => $phoneNumber,
            //'accountLink' => $accountLink,
            //'creditCardDetail' => $creditCardDetail,
            'itemDetails' => $itemDetails,
            'customerDetail' => $customerDetail,
            'callbackUrl' => $callbackUrl,
            'returnUrl' => $returnUrl,
            'signature' => $signature,
            'expiryPeriod' => $expiryPeriod
        );

        $params_string = json_encode($params);
        //echo $params_string;
        $url = 'https://sandbox.duitku.com/webapi/api/merchant/v2/inquiry'; // Sandbox
        // $url = 'https://passport.duitku.com/webapi/api/merchant/v2/inquiry'; // Production
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($params_string)
            )
        );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        //execute post
        $request = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode == 200) {
            $result = json_decode($request, true);
            //header('location: '. $result['paymentUrl']);
            echo "paymentUrl :" . $result['paymentUrl'] . "<br />";
            echo "merchantCode :" . $result['merchantCode'] . "<br />";
            echo "reference :" . $result['reference'] . "<br />";
            echo "vaNumber :" . $result['vaNumber'] . "<br />";
            echo "amount :" . $result['amount'] . "<br />";
            echo "statusCode :" . $result['statusCode'] . "<br />";
            echo "statusMessage :" . $result['statusMessage'] . "<br />";
        } else {
            $request = json_decode($request);
            $error_message = "Server Error " . $httpCode . " " . $request->Message;
            echo $error_message;
        }
    }


    /**
     * Each time a customer click PAY NOW button on the invoice HTML area, the script will process the payment via this function.
     * You can show forms here, redirect to gateway website, redirect to Codeigniter controller etc..
     * @param array $data - Contains the total amount to pay and the invoice information
     * @return mixed
     */
    public function process_payment($data)
    {
        var_dump($data);
        die;
    }
}
