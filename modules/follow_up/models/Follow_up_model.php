<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Follow_up_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param  integer (optional)
     * @return object
     * Get follow up
     */
    public function get($id = '')
    {
        if (is_numeric($id)) {
            $this->db->where('id', $id);

            return $this->db->get(db_prefix() . 'follow_up')->row();
        }

        return $this->db->get(db_prefix() . 'follow_up')->result_array();
    }

    /**
     * @param  integer (required)
     * @return object
     * Get all follow up by lead id
     */
    public function get_lead($lead_id)
    {
        if (is_numeric($lead_id)) {
            $this->db->where('type', 'Leads');
            $this->db->where('reference_id', $lead_id);

            return $this->db->get(db_prefix() . 'follow_up')->result_array();
        }

        return null;
    }
}
