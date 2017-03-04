<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
This class handle the layouts
 */
class Layout extends MX_Controller {
  public function __construct() {
		parent::__construct();
		$this->load->module("Layout");
	}
	public function adminTheme($data)
	{
		$data['admin_email'] = '';//$this->session->userdata('crm_user_email');
		$data['admin_fname'] = '';//$this->session->userdata('crm_user_fname');
		$data['admin_lname'] = '';//$this->session->userdata('crm_user_lname');
		$data['admin_role'] = '';//$this->session->userdata('crm_user_role');
		$this->load->view('admin/index',$data);
	}
	
	function authorize()
	{	
		
		$data['module'] = 'Layout';
		$data['view'] = 'admin/authorize';
		$this->layout->admin($data);
	}
	
}
