<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include("assets/global/admin.global.php");
// require_once 'HTTP/Request2.php';
// require_once 'SignatureBuilder.php';
class Cms_api extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
		$this->upload_img_thumb_path = "uploads/image/thumbnail/";
		$this->upload_img_preview_path = "uploads/image/preview/";
		$this->upload_img_background_path = "uploads/image/background/";
		$this->upload_data_path = "uploads/data/";
		$this->AppName = "HandyVR";
	}
	public function ajaxDel() {
		if($this->logonCheck()) {
			global $MYSQL;
			$Id = $this->input->post('Id');
			$tbl_Name = $this->input->post('tbl_Name');
			if($tbl_Name !='') {
				$conAry = array('Id' => $Id);
				$updateAry = array('isdeleted'=>'1');
				$this->User_model->updateData($tbl_Name, $conAry, $updateAry);
				echo json_encode(array("status" => TRUE));	
			} else {
				echo json_encode(array("status" => FALSE));	
			}
		}
	}
	public function getDataById() {
		$Id = $this->input->post("Id");
		$tableName = $this->input->post("tbl_Name");
		$ret = $this->User_model->getRow($tableName, array('Id'=>$Id));
		echo json_encode($ret);
	}
	
	public function getType() {
		if($this->logonCheck()) {
			global $MYSQL;
			$conAry = array();
			$column_order = array('Id', 'name', null, null); 
			$column_search = array('name');
			$type_data = $this->User_model->getTableDatas($MYSQL['_typeDB'], $conAry, $column_search, $column_order);
			$data = array();
			foreach ($type_data as $item) {
				$row = array();
				$row[] = $item->Id;
                $row[] = $item->name;
                $row[] = $item->created;
                $row[] = '<a href="javascript:void(0)" class="on-default edit-row" onclick="EditType('.$item->Id.')" title="Edit" ><i class="fa fa-pencil cus"></i></a>';
				$data[] = $row;
			}

			$output = array(
					"draw" => $_POST['draw'],
					"recordsTotal" => $this->User_model->getCounts($MYSQL['_typeDB'], $conAry),
					"recordsFiltered" => $this->User_model->count_filtered($MYSQL['_typeDB'], $conAry, 
						$column_search, $column_order),
					"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
	}
	public function addEditType() {
		global $MYSQL;
		$typeId = $this->input->post('type_id');
		$typeName = $this->input->post('typename');
		
		if($typeId != '') {
			$ret = $this->User_model->getRow($MYSQL['_typeDB'], array('name'=>$typeName,  'Id !='=>$typeId));
			if(empty($ret)) {
				$updateAry = array('name'=>$typeName, 'modified'=>date('Y-m-d'));
				$ret1 = $this->User_model->updateData($MYSQL['_typeDB'], array('Id'=>$typeId), $updateAry);
				if($ret1 > 0) {
					$this->session->set_flashdata('messagePr', 'Update Type Successfully..');
				} else {
					$this->session->set_flashdata('messagePr', 'Unable to Update Type..');
				}
			} else {
				$this->session->set_flashdata('messagePr', 'Unable to Update Type.. Same Type Name is existed!');
			}
		} else {
			$ret2 = $this->User_model->getRow($MYSQL['_typeDB'], array('name'=>$typeName));
			if(empty($ret2)) {
				$insertAry  = array('name'=>$typeName, 'created'=>date('Y-m-d'), 'modified'=>date('Y-m-d'));
				$ret3 = $this->User_model->insertData($MYSQL['_typeDB'], $insertAry);
				if($ret3) {
					$this->session->set_flashdata('messagePr', 'Insert Type Successfully..');
				} else {
					$this->session->set_flashdata('messagePr', 'Unable to Insert Type..');
				}
			} else {
				$this->session->set_flashdata('messagePr', 'Unable to Insert Subject.. Same Type Name is existed!');
			}
		}
		redirect('Cms/type/', 'refresh');
	}
	public function delSubject() {
		if($this->logonCheck()) {
			global $MYSQL;
			$Id = $this->input->post('Id');
			$conAry = array('Id' => $Id);
			$updateAry = array('isdeleted'=>'1');
			$this->User_model->updateData($MYSQL['_subjectDB'], $conAry, $updateAry);
			$conAry1 = array('subject_id'=>$Id);
			$this->User_model->updateData($MYSQL['_jobDB'], $conAry1, $updateAry);
			echo json_encode(array("status" => TRUE));
		}
	}
	
	public function resetUserPWD() {
		if($this->logonCheck()) {
			global $MYSQL;
			$Id = $this->input->post('Id');
			$conAry = array('Id' => $Id);		
			$ret = $this->User_model->getRow($MYSQL['_userDB'], $conAry);
			$newPWD = password_hash($ret->email, PASSWORD_DEFAULT);
			$updateAry = array('password'=>$newPWD);
			$this->User_model->updateData($MYSQL['_userDB'], $conAry, $updateAry);
			echo json_encode(array("status" => TRUE));
		}
	}
	
	public function getData($type) {
		if($this->logonCheck()) {
			global $MYSQL;
			$select = ' a.*, b.name as type_name';
			$conAry = array();
			if($type != "-1") {
				$conAry = array('a.videoCategory'=>$type);
			}
			$column_order = array(null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null); 
			$column_search = array('a.videoTitle', 'a.videoDescription');
			$travel_cate = $this->User_model->getTableDatas($MYSQL['_dataDB'].' a', $conAry, $column_search, 
				$column_order, 'data', $select);
			$data = array();
			$no = $_POST['start'];
			foreach ($travel_cate as $item) {
				$row = array();
				$no++;
				$strAvaiable = '<a href="javascript:void(0)" class="on-default edit-row" onclick="UpdateAvaiable('.$item->Id.')" title="Avaiable" ><i class="fa fa-check danger cus"></i></a>';
				/*if($item->isactive == '1' ) {
					$strAvaiable = '<a href="javascript:void(0)" class="on-default edit-row" onclick="UpdateAvaiable('.$item->Id.')" title="Unavaiable" ><i class="fa fa-check cus" ></i></a>';
				}*/
				/*$strAction = '<a href="javascript:void(0)" class="on-default edit-row" onclick="EditData('.$item->Id.')" title="Edit" ><i class="fa fa-pencil cus"></i></a> <a href="javascript:void(0)" class="on-default remove-row" onclick="RemoveData('.$item->Id.')" title="Remove" ><i class="fa fa-trash-o cus"></i></a>';	
				if($item->type_id == '1') {*/
					$strAction = '<a href="javascript:void(0)" class="on-default edit-row" onclick="PlayVideo('.$item->Id.')" title="Play" ><i class="fa fa-file-video-o cus"></i></a> <a href="javascript:void(0)" class="on-default edit-row" onclick="EditData('.$item->Id.')" title="Edit" ><i class="fa fa-pencil cus"></i></a> <a href="javascript:void(0)" class="on-default remove-row" onclick="RemoveData('.$item->Id.')" title="Remove" ><i class="fa fa-trash-o cus"></i></a>';	
				/*}*/
				$row[] = $no;
				$row[] = $item->type_name;
				$row[] = $item->videoType;
				$row[] = $item->videoURL;
				$row[] = '<img src="'.$item->thumbnailURL.'"class="thumb-md" alt="">';
				$row[] = '<img src="'.$item->videoPreviewURL.'"class="thumb-md" alt="">';
				$row[] = '<img src="'.$item->video360BackgroundURL.'"class="thumb-md" alt="">';
				$row[] = $item->videoTitle;
				$row[] = $item->videoSubTitle;
				$row[] = $item->videoDescription;
				$row[] = $item->videoDuration;
				$row[] = $item->videoCredit;
				$row[] = $item->fileName;
				$row[] = $item->isPaid;
				$row[] = $item->price;
				$row[] = $item->PaidUnit;
				$row[] = $item->captureTime;
				$row[] = $item->PinToTop;
				$row[] = $item->VideoViews;
				$row[] = $item->videoSubtitleShowTime;
				$row[] = $item->videoSubtitleEndTime;
				$row[] = $strAction;
				$data[] = $row;
			}

			$output = array(
					"draw" => $_POST['draw'],
					"recordsTotal" => $this->User_model->getCounts($MYSQL['_dataDB'].' a', $conAry),
					"recordsFiltered" => $this->User_model->count_filtered($MYSQL['_dataDB'].' a', $conAry, 
						$column_search, $column_order,'data', $select),
					"data" => $data,
			);
			//output to json format
			echo json_encode($output);
		}
	}
	public function ajaxOnOff() {
		if($this->logonCheck()) {
			$Id = $this->input->post('Id');
			$field = $this->input->post('field');
			$tbl_Name = $this->input->post('tbl_Name');
			$this->User_model->updateOnOff($tbl_Name, $Id, $field);
			echo json_encode(array("status" => TRUE));
		}
	}
	public function delData() {
		if($this->logonCheck()) {
			global $MYSQL;
			$Id = $this->input->post('Id');
			$data = $this->User_model->getRow($MYSQL['_dataDB'], array('Id' => $Id));
			$this->deleteFile($this->upload_img_thumb_path, $data->marker);
			$this->deleteFile($this->upload_data_path, $data->link);
			$this->User_model->deleteByField($MYSQL['_dataDB'], 'Id', $Id);
			echo json_encode(array("status" => TRUE));
		}
	}
	private function deleteFile( $path, $file_name)
	{
		$removefile = $path.$file_name;
		if( file_exists( $removefile ) )
			unlink( $removefile );
	}
	public function add_data(){
		if($this->logonCheck()) {
			global $MYSQL;
			$p = $this->input->post();
			$dataId = $this->input->post('data_Id');
			$typeId = $this->input->post('type_Id');
			$type = $p['type_Id'];
			$categoryId = $this->input->post('category_Id');
			$category = $p['category_Id'];
			$thumbnail = "";
			$thumbnail_old = "";
			$preview = "";
			$preview_old = "";
			$background = "";
			$background_old = "";
			$link_file = "";
			$duration = "0:00";
			$modifiedStr = "";
			$title = $this->input->post('title');
			$subtitle = $this->input->post('subtitle');
			$description = $this->input->post('description');
			$credit = $this->input->post('credit');
			$isPaid = $this->input->post('paid_id');
			$paidContent = $p['paid_id'];
			$price = "";
			$paidUnit = "";
			$captureTime = $this->input->post('captureTime');
			$pinToTop = $p['Pin_id'];
			$videoViews = 0;
			$videoSubtitleShowTime = $this->input->post('subtitleShowTime');
			$videoSubtitleEndTime = $this->input->post('subtitleEndTime');
			$fullPath = "";

			if($isPaid == 'Y'){
				$price = $this->input->post('price');
				$paidUnit = $p['unit_id'];
			}
			if($typeId == '3') 
				$duration = "";
			$filesize = "0 bytes";

			if($dataId !='') {
				$data = $this->User_model->getRow($MYSQL['_dataDB'], array('Id' => $dataId));
				$thumbnail_old = $data->thumbnailURL;
				$preview_old = $data->videoPreviewURL;
				$background_old = $data->video360BackgroundURL;
				$fullPath = $data->videoURL;
				$duration = $data->videoDuration;
				
			}

			if(isset($_FILES["thumbnail"])) {
				$tmpPicName = $_FILES["thumbnail"]["name"]; // The file name
				$tmpPic = $_FILES["thumbnail"]["tmp_name"]; // File in the PHP tmp folder
				$picExt = pathinfo($tmpPicName, PATHINFO_EXTENSION);
				$tmpPicNewName = time().".".$picExt; 
				$modifiedStr = time();
				if ($tmpPic) { // if file not chosen
					if(move_uploaded_file($tmpPic, $this->upload_img_thumb_path.$tmpPicNewName)){
						$thumbnail = base_url().$this->upload_img_thumb_path. $tmpPicNewName;
						if($thumbnail_old !="") {
							$this->deleteFile($this->upload_img_thumb_path, $thumbnail_old);
						}
					}
				}
			} else {
				$thumbnail = $thumbnail_old;
			}

			if(isset($_FILES["preview"])) {
				$tmpPicName = $_FILES["preview"]["name"]; // The file name
				$tmpPic = $_FILES["preview"]["tmp_name"]; // File in the PHP tmp folder
				$picExt = pathinfo($tmpPicName, PATHINFO_EXTENSION);
				$tmpPicNewName = time().".".$picExt; 
				$modifiedStr = time();
				if ($tmpPic) { // if file not chosen
					if(move_uploaded_file($tmpPic, $this->upload_img_preview_path.$tmpPicNewName)){
						$preview = base_url().$this->upload_img_preview_path.$tmpPicNewName;
						if($preview_old !="") {
							$this->deleteFile($this->upload_img_preview_path, $preview_old);
						}
					}
				}
			} else {
				$preview = $preview_old;
			}

			if(isset($_FILES["background"])) {
				$tmpPicName = $_FILES["background"]["name"]; // The file name
				$tmpPic = $_FILES["background"]["tmp_name"]; // File in the PHP tmp folder
				$picExt = pathinfo($tmpPicName, PATHINFO_EXTENSION);
				$tmpPicNewName = time().".".$picExt; 
				$modifiedStr = time();
				if ($tmpPic) { // if file not chosen
					if(move_uploaded_file($tmpPic, $this->upload_img_background_path.$tmpPicNewName)){
						$background = base_url().$this->upload_img_background_path.$tmpPicNewName;
						if($background_old !="") {
							$this->deleteFile($this->upload_img_background_path, $background_old);
						}
					}
				}
			} else {
				$background = $background_old;
			}

			if(isset($_FILES["link_file"])) {
				$tmpLinkName = $_FILES["link_file"]["name"]; // The file name
				$tmpLink = $_FILES["link_file"]["tmp_name"]; // File in the PHP tmp folder
				$tmpSize = $_FILES['link_file']['size']; // File size
				$filesize = $this->formatSizeUnits($tmpSize);
				$linkExt = pathinfo($tmpLinkName, PATHINFO_EXTENSION);
				$tmpLinkNewName = time().".".$linkExt; 
				$modifiedStr = time();
				if ($tmpLink) { // if file not chosen
					if(move_uploaded_file($tmpLink, $this->upload_data_path.$tmpLinkNewName)){
						if($link_file !="") {
							$this->deleteFile($this->upload_data_path, $link_file);
						}
						$link_file = $tmpLinkNewName;
						$fullPath = base_url().$this->upload_data_path.$link_file;
						
							include_once("assets/global/getid3/getid3.php");
							$getID3 = new getID3;
							$fileInfo = $getID3->analyze($this->upload_data_path.$tmpLinkNewName);
							$duration = $fileInfo['playtime_string'];
						
					}
				}
			} else {
				$link_file = $this->input->post('url');
				$fullPath = $link_file;
			}

			if($dataId !='') {
				$updateAry = array('videoCategory'=>$categoryId, 'videoType'=>$type , 'thumbnailURL'=>$thumbnail, 'video360BackgroundURL'=>$background, 'videoPreviewURL'=>$preview, 'videoURL'=>$fullPath, 'videoDuration'=>$duration, 'videoTitle'=>$title, 'videoSubTitle'=>$subtitle, 'videoDescription'=>$description, 'videoCredit'=>$credit, 'fileName'=>$link_file, 'isPaid'=>$paidContent, 'price'=>$price, 'PaidUnit'=>$paidUnit, 'captureTime'=>$captureTime, 'PinToTop'=>$pinToTop, 'videoSubtitleShowTime'=>$videoSubtitleShowTime, 'videoSubtitleEndTime'=>$videoSubtitleEndTime);
				$ret = $this->User_model->updateData($MYSQL['_dataDB'], array('Id'=>$dataId), $updateAry);
				if($ret > 0) {
					echo json_encode(array("status"=>TRUE));
				} else {
					echo json_encode(array("status"=>FALSE));
				}
			} 
			else {
				$updateAry = array('videoCategory'=>$categoryId, 'videoType'=>$type , 'thumbnailURL'=>$thumbnail, 'video360BackgroundURL'=>$background, 'videoPreviewURL'=>$preview, 'videoURL'=>$fullPath, 'videoDuration'=>$duration, 'videoTitle'=>$title,  'videoSubTitle'=>$subtitle, 'videoDescription'=>$description, 'videoCredit'=>$credit, 'fileName'=>$link_file, 'isPaid'=>$paidContent, 'price'=>$price, 'PaidUnit'=>$paidUnit, 'captureTime'=>$captureTime, 'PinToTop'=>$pinToTop, 'videoSubtitleShowTime'=>$videoSubtitleShowTime, 'videoSubtitleEndTime'=>$videoSubtitleEndTime, 'VideoViews'=>$videoViews);
				$ret = $this->User_model->insertData($MYSQL['_dataDB'], $updateAry);
				if($ret) {
					// $this->session->set_flashdata('messagePr', 'Insert Video Successfully..');
					echo json_encode(array("status"=>TRUE));
				} else {
					// $this->session->set_flashdata('messagePr', 'Unable Video Traveling Category..');
					echo json_encode(array("status"=>FALSE));
				}
			}
			// redirect('Cms/data/', 'refresh');
		}
	}
	public function formatSizeUnits($bytes){
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }
        return $bytes;
	}

	public function NotifyEmail($email, $fname, $lname,  $phone, $pass) {
		$this->load->library('email'); 
		$this->email->from($this->admin_email, $this->AppName);
		$this->email->to($email);
		$this->email->subject('Notification'); 
		$this->email->message("Hi ".$fname." ".$lname."\r\nPlease Confirm your information. \r\nEmail Address:".$email."\r\nPassword: ".$pass."\r\n".date("Y-m-d H:i:s")); 
		$ret = $this->email->send();
		if($ret) {
			return TRUE;
		} 
		return FALSE;
	}
}