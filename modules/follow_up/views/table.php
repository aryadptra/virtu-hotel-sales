<?php
defined('BASEPATH') or exit('No direct script access allowed');

$CI = &get_instance();

$aColumns = [
    'id',
    'name',
];

$sIndexColumn = 'id';
$sTable       = db_prefix() . 'follow_up';

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], []);

$output  = $result['output'];
$rResult = $result['rResult'];

$no = 1;

foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 0; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];

        if ($aColumns[$i] == 'id') {
            $_data = $no;
        }

        $row[] = $_data;
    }
    $output['aaData'][] = $row;
    $no++;
}
