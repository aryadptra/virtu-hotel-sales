<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Whatsapp_model extends CI_Model
{

    public function get($where = null, $limit = null, $order = [], $tipe = 'get')
    {
        $this->db->from(db_prefix() . 'log_wa');
        if (!empty($where)) {
            $this->db->where($where);
        }

        if (!empty($limit)) {
            $this->db->limit($limit);
        }

        if (!empty($order)) {
            $this->db->order_by($order);
        }

        if ($tipe == 'get') {
            return $this->db->get();
        } else {
            return $this->db->count_all_results();
        }
    }

    public function add($data)
    {
        if ($this->db->insert(db_prefix() . 'log_wa', $data)) {
            return true;
        }
        return false;
    }

    public function update($where, $data)
    {
        if ($this->db->update(db_prefix() . 'log_wa', $data, $where)) {
            return true;
        }
        return false;
    }

    public function add_batch($data)
    {
        if (count($data) == 1) {
            if ($this->db->insert(db_prefix() . 'log_wa', $data[0])) {
                return true;
            }
        } else if (count($data) > 1) {
            if ($this->db->insert_batch(db_prefix() . 'log_wa', $data)) {
                return true;
            }
        }
        return false;
    }

    public function update_batch($label, $data)
    {
        if ($this->db->update_batch(db_prefix() . 'log_wa', $data, $label)) {
            return true;
        }
        return false;
    }
}
