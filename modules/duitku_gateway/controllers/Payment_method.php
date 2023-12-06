<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Payment_method extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['title'] = _l('Manage');

        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data(module_views_path('duitku_gateway', 'tables/_payment_method'));
        }
        $this->load->view('manage', $data);
    }

    public function syncronize()
    {
        $response = $this->duitku_gateway->getPaymentMethods();

        // Memastikan bahwa $response memiliki struktur yang diharapkan
        if (isset($response['paymentFee']) && is_array($response['paymentFee'])) {
            foreach ($response['paymentFee'] as $payment) {
                insert_payment_method(
                    $payment['paymentMethod'],
                    $payment['paymentName'],
                    $payment['paymentImage'],
                    $payment['totalFee']
                );
            }
        }

        // Redirect back to the previous page
        redirect($this->input->server('HTTP_REFERER'));
        return;
    }
}
