<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Transaction extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['title'] = _l('transactions');

        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data(module_views_path('duitku_gateway', 'tables/_transactions'));
        }
        $this->load->view('manage', $data);
    }

    public function request()
    {
        $response = $this->duitku_gateway->requestTransaction();

        $response['merchantCode'];
        $response['reference'];
        $response['paymentUrl'];
        $response['vaNumber'];
        $response['amount'];
        $response['statusCode'];
        $response['statusMessage'];
        $insert = insert_transaction($response['merchantCode'], $response['reference'], $response['paymentUrl'], $response['vaNumber'], $response['amount'], $response['statusCode'], $response['statusMessage']);
    }
}
