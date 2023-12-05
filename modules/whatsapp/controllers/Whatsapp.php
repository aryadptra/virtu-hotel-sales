<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Whatsapp extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('invoices_model');
        $this->load->model('clients_model');
        $this->load->model('leads_model');
        $this->load->helper('sales');
        $this->load->model('Whatsapp_model', 'lm');
    }

    /**
     * Fungsi di Halaman Template
     */

    //  Return view template
    public function template()
    {
        // Get all client name
        $data['clients'] = $this->clients_model->get();
        // Get all invoice
        $data['invoices'] = $this->invoices_model->get();
        // Get all leads
        $data['leads'] = $this->leads_model->get();
        // $data['title'] = _l('template_whatsapp');
        $data['title'] = "Template Whatsapp";
        $this->load->view('template', $data);
    }

    public function save_template_new_invoice()
    {
        $template = $this->input->post("template_new_invoice", FALSE);
        update_option('template_new_invoice', $template);
    }

    public function test_template_new_invoice()
    {
        $receiver = $this->input->post("to", FALSE);

        // Jika di receiver ada +, maka dihapus
        if (strpos($receiver, '+') !== false) {
            $receiver = str_replace("+", "", $receiver);
        }

        send_template_new_invoice($receiver, $invoiceId = '', $companyName = '', $invoiceNumber = '', $invoiceLink = '', $invoiceTotal = '', $invoiceDueDate = '');
    }

    /**
     * Fungsi di Halaman Settings
     */

    // Return view settings

    public function settings()
    {
        $data['title'] = _l('setting_whatsapp');
        $this->load->view('settings', $data);
    }

    // Menyimpan settings
    public function save_settings()
    {
        $whatsapp_url = $this->input->post("whatsapp_url", FALSE);
        $whatsapp_api_key = $this->input->post("whatsapp_api_key", FALSE);
        $whatsapp_sender = $this->input->post("whatsapp_sender", FALSE);
        $whatsapp_footer = $this->input->post("whatsapp_footer", FALSE);
        update_option('whatsapp_url', $whatsapp_url);
        update_option('whatsapp_api_key', $whatsapp_api_key);
        update_option('whatsapp_sender', $whatsapp_sender);
        update_option('whatsapp_footer', $whatsapp_footer);
        set_alert('success', "Change has been saved");
    }

    // Fungsi untuk test kirim pesan
    public function test_message()
    {
        $to = $this->input->post("to", FALSE);
        $msg = $this->input->post("msg", FALSE);

        $data = [
            'api_key' => get_option('whatsapp_api_key'),
            'sender' => get_option('whatsapp_sender'),
            'number' => $to,
            'message' => $msg . '' . get_option('whatsapp_footer')
        ];
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => get_option('whatsapp_url'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
    }
}
