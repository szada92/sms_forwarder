<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Plugin Name: SMS forwarder
 * Plugin URI: https://github.com/szada92/sms_forwarder
 * Version: 0.1
 * Description: SMS forwarder based on configurable rules
 * Author: Dániel Szabó
 * Author URI: https://github.com/szada92
 */

require_once (APPPATH . 'plugins/Plugin_controller.php');

// Add hook for incoming message
add_action('message.incoming.after', 'sms_forwarder', 11);

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
	$config = Plugin_helper::get_plugin_config('sms_forwarder');
	
	$CI = &get_instance();
	$CI->load->library('session');
	$CI->load->model('Message_model');
	$CI->load->model('Phonebook_model');

	if ($config['enabled'] !== TRUE) {
		return;
	}

	if ($config['trigger_sms_contains'] !== NULL) {
		if (strpos($sms->TextDecoded, $config['trigger_sms_contains']) === FALSE) {
			return;
		}
	}

	// Check if sender is in the list of configurable phone numbers
	if (in_array($sms->SenderNumber, $config['trigger_sender_phone_number'])) {
		// Get the members of the phonebook group
		$group_id = $config['phonebook_group_id'];

		$get_phonebook_params = array(
			'id_user' => 1,
			'option' => 'bygroup',
			'group_id' => $group_id
		);
		$group_members = $CI->Phonebook_model->get_phonebook($get_phonebook_params)->result();

		$error = null;

		if (isset($group_members) && isset($sms->TextDecoded)) {
			// Forward the SMS to each member of the group
			foreach ($group_members as $member) {
				try {
					$data['class'] = '1';
					$data['dest'] = $member->Number;
					$data['SenderID'] = NULL;
					$data['CreatorID'] = '';
					$data['date'] = date('Y-m-d H:i:s');
					$data['message'] = $sms->TextDecoded;
					$data['uid'] = 1;
					$data['delivery_report'] = 'default';

					// var_dump($data);

					$CI->Message_model->send_messages($data);
				} catch (Exception $e) {
					// var_dump($e);
					$error = $e;
				}
			}
		}

		if ($error !== null) {
			throw $error;
		}
	}
}
