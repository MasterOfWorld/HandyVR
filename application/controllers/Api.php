<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include("assets/global/admin.global.php");
header('Access-Control-Allow-Origin: *');

class Api extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('User_model');
		$this->upload_img_thumb_path = "uploads/image/thumbnail/";
		$this->upload_data_path = "uploads/data/";
		$this->AppName = "VideoBook";
	}
	public function ping_Server() {
		echo "1";
	}
	public function getData() {
		global $MYSQL;
		$data['status'] = "fail";
		$data['result'] = "";
		$select = ' a.*, c.category_name, d.title, d.credit, d.description, d.duration, e.price, f.currency';
		$ret = $this->User_model->getVideoDatas($MYSQL['_videoDB'].' a', $select);
		if(!empty($ret)) {
			$data['status'] = "success";
			$data['result'] = $ret;
			/*$retval = array();
			$cnt = count($ret);
			for ($i = 0; $i < $cnt; $i++) {
				$tmp = $ret[$i];
				$retval[$i]	= new stdClass();
				$retval[$i]->Id = $tmp->Id;
				$retval[$i]->type = $tmp->type_id;
				$retval[$i]->marker = $tmp->marker;
				$retval[$i]->marker_path = base_url().$this->upload_img_thumb_path.$tmp->marker;
				$retval[$i]->overlay = $tmp->link;
				$retval[$i]->overlay_path = base_url().$this->upload_data_path.$tmp->link;
				$retval[$i]->duration = $tmp->duration;
				$retval[$i]->filesize = $tmp->filesize;
				$retval[$i]->modified = $tmp->modified;
				$retval[$i]->modifiedStr = $tmp->modifiedStr;
			}
			$data['count'] = $cnt;
			$data['result'] = $retval;*/
		}
		echo json_encode($data);
	}

	public function getCategory(){
		global $MYSQL;
		$data['status'] = "fail";
		$data['result'] = "";
		$ret = $this->User_model->getDatas($MYSQL['_categoriesDB'], array());
		if(!empty($ret)) {
			$data['status'] = "success";
			$data['result'] = $ret;
		}
		echo json_encode($data);
	}

	public function updateVideoViews(){
		$dataId = $this->input->get('Id');
		if($dataId == null || $dataId == ""){
			$dataId = $this->input->post('Id');
		}
		$this->User_model->updateVideoViews($dataId);
		//echo $dataId;
	}
}
