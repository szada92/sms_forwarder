<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Plugin Name: SMS forwarder
 * Plugin URI: https://github.com/szada92/sms-forwarder
 * Version: 0.1
 * Description: SMS forwarder based on configurable rules
 * Author: Dániel Szabó
 * Author URI: https://github.com/szada92
 */

require_once (APPPATH . 'plugins/Plugin_controller.php');

// Add hook for incoming message
add_action('message.incoming.before', 'sms_forwarder', 11);

/**
 * Function called when plugin first activated
 * Utility function must be prefixed with the plugin name
 * followed by an underscore.
 *
 * Format: pluginname_activate
 *
 */
function sms_forwarder_activate()
{
	return TRUE;
}

/**
 * Function called when plugin deactivated
 * Utility function must be prefixed with the plugin name
 * followed by an underscore.
 *
 * Format: pluginname_deactivate
 *
 */
function sms_forwarder_deactivate()
{
	return TRUE;
}

/**
 * Function called when plugin first installed into the database
 * Utility function must be prefixed with the plugin name
 * followed by an underscore.
 *
 * Format: pluginname_install
 *
 */
function sms_forwarder_install()
{
	return TRUE;
}

function sms_forwarder($sms)
{
	// $config = Plugin_helper::get_plugin_config('sms_forwarder');
	$CI = &get_instance();
	$CI->load->model('Message_model');
	$CI->load->model('Phonebook_model');

	$group_id = 1;
	$phone_numbers = ['+1234567890', '+0987654321'];

	// Check if sender is in the list of configurable phone numbers

	// if (in_array($sms->SenderNumber, $config['phone_numbers'])) {
	if (in_array($sms->SenderNumber, $phone_numbers)) {
		// Get the members of the phonebook group
		$group_members = $CI->Phonebook_model->get_group_members($group_id);

		// Forward the SMS to each member of the group
		foreach ($group_members as $member) {
			try {
				$data['class'] = '1';
				$data['dest'] = $member->Number;
				$data['date'] = date('Y-m-d H:i:s');
				$data['message'] = $sms->TextDecoded;
				$data['delivery_report'] = 'default';
				$CI->Message_model->send_messages($data);
			} catch (Exception $e) {
				throw $e;
			}
		}
	}



	// $config = Plugin_helper::get_plugin_config('simple_autoreply');
	// $CI = &get_instance();
	// $CI->load->model('Message_model');
	// $data['class'] = '1';
	// $data['dest'] = $sms->SenderNumber;
	// $data['date'] = date('Y-m-d H:i:s');
	// $data['message'] = $config['message'];
	// $data['delivery_report'] = 'default';
	// $data['uid'] = $config['uid'];
	// $CI->Message_model->send_messages($data);
}
