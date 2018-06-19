<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include("assets/global/admin.global.php");
class Cms extends CI_Controller {

	public function __construct()
	{
		 parent::__construct();
		 $this->load->model('User_model');
		 $this->upload_img_thumb_path = "uploads/image/thumbnail/";
		 $this->upload_img_preview_path = "uploads/image/preview/";
		 $this->upload_img_background_path = "uploads/image/background/";
		 $this->upload_data_path = "uploads/data/";
	}
	public function index()
	{
		if($this->logonCheck()) {
			redirect('Cms/dashboard/', 'refresh');
		} 
	}
	public function login(){
		$this->load->view("admin/view_login");	
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect('Cms/', 'refresh');
	}
	public function auth_user() {
		global $MYSQL;
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$conAry = array('email' => $email);
		$ret = $this->User_model->getRow($MYSQL['_adminDB'], $conAry);
		if(!empty($ret)){       
			if (password_verify($password, $ret->password)) {       
				$sess_data = array('user_id'=>$ret->Id, 'is_login'=>true);
				$this->session->set_userdata($sess_data);
				redirect('Cms/dashboard/', 'refresh');
			}
		} 
		redirect( 'Cms/login', 'refresh');
	}
	public function dashboard() {
		if($this->logonCheck()) {
			global $MYSQL;
			$param['uri'] = '';
			$param['kind'] = '';
			$this->load->view("admin/view_header", $param);	
			$data['type_cnt'] = $this->User_model->getCounts($MYSQL['_typeDB'], array());  // count Type
			$data['data_cnt'] = $this->User_model->getCounts($MYSQL['_dataDB'], array());  // count data
			$data['video_cnt'] = $this->User_model->getCounts($MYSQL['_videoDB'], array());  // count Video
			$this->load->view("admin/view_dashboard", $data);
		}
	}
	public function updateAccount() {
		if($this->logonCheck()){
			global $MYSQL;
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$id = $this->session->userdata('user_id');
			$npass = password_hash($password, PASSWORD_DEFAULT);
			$updateAry = array('email'=>$email,
				'password'=>$npass,
				'modified'=>date('Y-m-d'));
			$ret = $this->User_model->updateData($MYSQL['_adminDB'], array('Id'=>$id), $updateAry);
			if($ret > 0) 
				$this->session->set_flashdata('messagePr', 'Update Account Successfully..');
			else
				$this->session->set_flashdata('messagePr', 'Unable to Update Account..');
			redirect('Cms/dashboard/', 'refresh');
		}
	}
	public function type() {
		if($this->logonCheck()) {
			$param['uri'] = 'type';
			$param['kind'] = 'table';
			$this->load->view("admin/view_header", $param);	
			$this->load->view("admin/view_type");
		}	
	}
	public function data() {
		global $MYSQL;
		if($this->logonCheck()) {
			$param['uri'] = 'data';
			$param['kind'] = 'table';
			$data['type'] = $this->User_model->getDatas($MYSQL['_typeDB'], array());  // count Type
			$this->load->view("admin/view_header", $param);	
			$this->load->view("admin/view_data", $data);
		}
	}
	public function add_edit_data() {
		if($this->logonCheck()) {
			global $MYSQL;
			$data['data_Id'] = $this->input->post('data_Id');
			$param['uri'] = 'data';
			$param['kind'] = '';
			$this->load->view("admin/view_header", $param);	
			$data['type'] = $this->User_model->getDatas($MYSQL['_typeDB'], array());
			if($data['data_Id'] !='') {
				$ret = $this->User_model->getDataById($MYSQL['_dataDB'], $data['data_Id']);
				$data['result'] = $ret;
				/*$data['result']->thumbnailURL = $data['result']->thumbnailURL;
				$data['result']->videoPreviewURL = $data['result']->videoPreviewURL;
				$data['result']->video360BackgroundURL = $data['result']->video360BackgroundURL;
				$data['result']->videoTitle = $data['result']->videoTitle;*/
			}
			$this->load->view("admin/view_add_data", $data);
		}
	}
	public function play_video() {
		if($this->logonCheck()) {
			global $MYSQL;
			$id = $this->input->post('data_Id');
			$param['uri'] = 'data';
			$param['kind'] = '';
			$this->load->view("admin/view_header", $param);	
			if($id !='') {
				$data['result'] = $this->User_model->getRow($MYSQL['_dataDB'], array('Id'=>$id));
				$data['result']->link = base_url().$this->upload_data_path.$data['result']->fileName;
			}
			$this->load->view("admin/view_play_video", $data);
		}
	}
	
	public function test(){
		global $MYSQL;
		$ret = $this->User_model->getDataById($MYSQL['_jobDB'], '1');
		print_r($ret);
	}
}
