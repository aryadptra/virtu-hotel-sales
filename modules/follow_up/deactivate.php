<?php
defined('BASEPATH') or exit('No direct script access allowed');

$CI = &get_instance();

if ($CI->db->table_exists(db_prefix() . 'follow_up')) {
    $q = 'DROP TABLE `' . db_prefix() . 'follow_up`;';
    $CI->db->query($q);
}
