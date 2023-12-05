<?php

defined('BASEPATH') or exit('No direct script access allowed');

// Jika ada {{ company }} di template invoice, maka akan diganti dengan nama perusahaan
function replace_company_name($template, $company)
{
    return str_replace('{{ company }}', $company, $template);
}
// Jika ada {{ invoice_number }} di template invoice, maka akan diganti dengan nomor invoice
function replace_invoice_number($template, $invoiceNumber)
{
    return str_replace('{{ invoice_number }}', $invoiceNumber, $template);
}
// Jika ada {{ invoice_link }} di template invoice, maka akan diganti dengan link invoice
function replace_invoice_link($template, $invoiceLink)
{
    return str_replace('{{ invoice_link }}', $invoiceLink, $template);
}
// Jika ada {{ invoice_total }} di template invoice, maka akan diganti dengan total invoice
function replace_invoice_total($template, $invoiceTotal)
{
    return str_replace('{{ invoice_total }}', $invoiceTotal, $template);
}
// Jika ada {{ invoice_due_date }} di template invoice, maka akan diganti dengan tanggal jatuh tempo invoice
function replace_invoice_due_date($template, $invoiceDueDate)
{
    return str_replace('{{ invoice_due_date }}', $invoiceDueDate, $template);
}

function send_template_new_invoice($receiver, $invoiceId = '', $companyName = '', $invoiceNumber = '', $invoiceLink = '', $invoiceTotal = '', $invoiceDueDate = '')
{
    $template = get_option('template_new_invoice');
    $template = replace_company_name($template, $companyName);
    $template = replace_invoice_number($template, $invoiceNumber);
    $template = replace_invoice_link($template, $invoiceLink);
    $template = replace_invoice_total($template, $invoiceTotal);
    $template = replace_invoice_due_date($template, $invoiceDueDate);

    $data = [
        'api_key' => get_option('whatsapp_api_key'),
        'sender' => get_option('whatsapp_sender'),
        'number' => $receiver,
        'message' => $template . '' . get_option('whatsapp_footer')
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


function sendWa($receiver, $message)
{
    $data = [
        'api_key' => get_option('whatsapp_api_key'),
        'sender' => get_option('whatsapp_sender'),
        'number' => $receiver,
        'message' => $message . '' . get_option('whatsapp_footer')
    ];
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://wa.ifibernet.id/api/message',
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

function sendTemplatePaymentSuccess($receiver, $invoiceId = '', $companyName = '', $invoiceNumber = '', $invoiceLink = '', $invoiceTotal = '', $invoiceDueDate = '')
{
    $template = get_option('whatsapp_template_payment_success');
    $template = replaceCompanyName($template, $companyName);

    $template = replaceInvoiceNumber($template, $invoiceNumber);
    $template = replaceInvoiceLink($template, $invoiceLink);
    $template = replaceInvoiceTotal($template, $invoiceTotal);
    $template = replaceInvoiceDueDate($template, $invoiceDueDate);

    $data = [
        'api_key' => get_option('whatsapp_api_key'),
        'sender' => get_option('whatsapp_sender'),
        'number' => $receiver,
        'message' => $template . '' . get_option('whatsapp_footer')
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

function cronjobwa($id, $tujuan, $pesan)
{
    $a = &get_instance();
    $endpoint = 'http://wa.ifibernet.id/api/'; // Sesuaikan dengan endpoint wa
    $method = 'message';
    $apiKey = 'AA85B04C91'; // Lihat di halaman edit profil user pojok kanan atas
    $device = '62818596696';

    $data = [
        'api_key' => $apiKey,
        'sender' => $device,
        'number' => $tujuan,
        'message' => $pesan
    ];

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $endpoint . $method,
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

    $o = json_decode(curl_exec($curl));
    curl_close($curl);

    $a->db->update(db_prefix() . 'log_wa', ['status' => $o->msg, 'is_proses' => '1'], ['id' => $id]);
}