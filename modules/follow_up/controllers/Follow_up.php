<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Follow_up extends AdminController
{
    public function __construct()
    {
        parent::__construct();

        if (!is_admin()) {
            access_denied('Follow Up');
        }
    }

    public function index()
    {
        $this->load->view('leads_manage');
    }

    public function leads()
    {
        $data['title'] = _l('follow_up');

        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data(module_views_path('follow_up', 'table'));
        }
        $this->load->view('leads_manage', $data);
    }
}
