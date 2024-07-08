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
 * Sms_forwarder Class
 *
 * @package		Kalkun
 * @subpackage	Plugin
 * @category	Controllers
 */
include_once (APPPATH . 'plugins/Plugin_controller.php');

class Sms_forwarder extends Plugin_controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('sms_forwarder_model');
	}

	function index()
	{
		$this->load->helper('form');
		$data['title'] = 'SMS forwarder Settings';
		$data['main'] = 'index';
		$data['settings'] = $this->sms_forwarder_model->get_all_setting();

		if ($data['settings']->num_rows() === 1) {
			$data['mode'] = 'edit';
		} else {
			$data['mode'] = 'add';
		}

		$this->load->view('main/layout', $data);
	}

	function save()
	{
		if ($_POST) {
			$this->sms_forwarder_model->save_setting();
			redirect('plugin/sms_forwarder');
		}
	}
}
