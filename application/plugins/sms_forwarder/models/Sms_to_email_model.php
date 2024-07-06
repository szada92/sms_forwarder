<?php
/**
 * Kalkun
 * An open source web based SMS Management
 *
 * @package		Kalkun
 * @author		Kalkun Dev Team
 * @license		https://spdx.org/licenses/GPL-2.0-or-later.html
 * @link		https://kalkun.sourceforge.io/
 */

// ------------------------------------------------------------------------

/**
 * Sms_forwarder_model Class
 *
 * @package		Kalkun
 * @subpackage	Plugin
 * @category	Models
 */
class Sms_forwarder_model extends CI_Model {

	function get_setting($id)
	{
		$this->db->from('plugin_sms_forwarder');
		$this->db->where('id', $id);

		return $this->db->get();
	}

	function save_setting()
	{
		$this->db->set('enabled', $this->input->post('enabled'));
		$this->db->set('trigger_sender_phone_number', $this->input->post('trigger_sender_phone_number'));
		$this->db->set('trigger_sms_contains', $this->input->post('trigger_sms_contains'));
		$this->db->set('phonebook_group_id', $this->input->post('phonebook_group_id'));

		if ($this->input->post('mode') === 'edit')
		{
			$this->db->update('plugin_sms_forwarder');
		}
		else {
			$this->db->set('reg_date', date('Y-m-d H:i:s'));
			$this->db->insert('plugin_sms_forwarder');
		}
	}
}
