<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function insert_payment_method($paymentMethod, $paymentName, $paymentImage, $totalFee)
{
	$CI = &get_instance();

	// Cek apakah data sudah ada di database berdasarkan paymentMethod
	$existingData = $CI->db->get_where(db_prefix() . 'duitku_payment_methods', array('payment_method' => $paymentMethod))->row();

	// Jika data sudah ada, lakukan update
	if ($existingData) {
		$dataToUpdate = array(
			'payment_name' => $paymentName,
			'payment_image' => $paymentImage,
			'total_fee' => $totalFee
		);

		$CI->db->where('payment_method', $paymentMethod);
		$CI->db->update(db_prefix() . 'duitku_payment_methods', $dataToUpdate);
	} else {
		// Jika data belum ada, lakukan insert
		$dataToInsert = array(
			'payment_method' => $paymentMethod,
			'payment_name' => $paymentName,
			'payment_image' => $paymentImage,
			'total_fee' => $totalFee
		);

		$CI->db->insert(db_prefix() . 'duitku_payment_methods', $dataToInsert);
	}
}

/**
 * Insert data into tblduitku_transactions
 */

function insert_transaction($merchantCode, $reference, $paymentUrl, $vaNumber, $amount, $statusCode, $statusMessage)
{
	$CI = &get_instance();

	// Cek apakah data sudah ada di database berdasarkan reference
	$existingData = $CI->db->get_where(db_prefix() . 'duitku_transactions', array('reference' => $reference))->row();

	// Jika data sudah ada, lakukan update
	if ($existingData) {
		$dataToUpdate = array(
			'payment_url' => $paymentUrl,
			'va_number' => $vaNumber,
			'amount' => $amount,
			'status_code' => $statusCode,
			'status_message' => $statusMessage,
		);

		$CI->db->where('reference', $reference);
		$CI->db->update(db_prefix() . 'duitku_transactions', $dataToUpdate);
	} else {
		// Jika data belum ada, lakukan insert
		$dataToInsert = array(
			'merchant_code' => $merchantCode,
			'reference' => $reference,
			'payment_url' => $paymentUrl,
			'va_number' => $vaNumber,
			'amount' => $amount,
			'status_code' => $statusCode,
			'status_message' => $statusMessage,
		);

		$CI->db->insert(db_prefix() . 'duitku_transactions', $dataToInsert);
	}
}
