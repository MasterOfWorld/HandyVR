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
			$column_order = array('Id', 'category_name', null, null); 
			$column_search = array('category_name');
			$type_data = $this->User_model->getTableDatas($MYSQL['_categoriesDB'], $conAry, $column_search, $column_order);
			$data = array();
			foreach ($type_data as $item) {
				$row = array();
				$row[] = $item->Id;
                $row[] = $item->category_name;
                $row[] = $item->created;
                $row[] = '<a href="javascript:void(0)" class="on-default edit-row" onclick="EditType('.$item->Id.')" title="Edit" ><i class="fa fa-pencil cus"></i></a>';
				$data[] = $row;
			}

			$output = array(
					"draw" => $_POST['draw'],
					"recordsTotal" => $this->User_model->getCounts($MYSQL['_categoriesDB'], $conAry),
					"recordsFiltered" => $this->User_model->count_filtered($MYSQL['_categoriesDB'], $conAry, 
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
		$typeEnglishName = $this->input->post('type_english_name');
		$typeSimplifiedChineseName = $this->input->post('type_simplified_chinese_name');
		$typeTraditionalChineseName = $this->input->post('type_traditional_chinese_name');
		$typeJapaneseName = $this->input->post('type_japanese_name');
		$typeKoreanName = $this->input->post('type_korean_name');
		$typeSpanishName = $this->input->post('type_spanish_name');
		$typeGermanName = $this->input->post('type_german_name');
		$typeRussianName = $this->input->post('type_russian_name');
		$typeFrenchName = $this->input->post('type_french_name');
		$typeItalianName = $this->input->post('type_italian_name');
		$typePolishName = $this->input->post('type_polish_name');
		$typePortugueseName = $this->input->post('type_portuguese_name');
		$typeThaiName = $this->input->post('type_thai_name');
		$typeHungarianName = $this->input->post('type_hungarian_name');
		$typeArabicName = $this->input->post('type_arabic_name');
		
		if($typeId != '') {
			$ret = $this->User_model->getRow($MYSQL['_categoriesDB'], array('category_name'=>$typeEnglishName,  'Id !='=>$typeId));
			if(empty($ret)) {
				$updateAry = array('category_name'=>$typeEnglishName, 'en'=>$typeEnglishName, 'zh_CN'=>$typeSimplifiedChineseName, 'zh_TW'=>$typeTraditionalChineseName, 'ja'=>$typeJapaneseName, 'ko'=>$typeKoreanName, 'es'=>$typeSpanishName, 'de'=>$typeGermanName, 'ru'=>$typeRussianName, 'fr'=>$typeFrenchName, 'it'=>$typeItalianName, 'pl'=>$typePolishName, 'pt_PT'=>$typePortugueseName, 'th'=>$typeThaiName, 'hu'=>$typeHungarianName, 'ar'=>$typeArabicName ,'modified'=>date('Y-m-d'));
				$ret1 = $this->User_model->updateData($MYSQL['_categoriesDB'], array('Id'=>$typeId), $updateAry);
				if($ret1 > 0) {
					$this->session->set_flashdata('messagePr', 'Update Type Successfully..');
				} else {
					$this->session->set_flashdata('messagePr', 'Unable to Update Type..');
				}
			} else {
				$this->session->set_flashdata('messagePr', 'Unable to Update Type.. Same Type Name is existed!');
			}
		} else {
			$ret2 = $this->User_model->getRow($MYSQL['_categoriesDB'], array('category_name'=>$typeEnglishName));
			if(empty($ret2)) {
				$insertAry  = array('category_name'=>$typeEnglishName, 'en'=>$typeEnglishName, 'zh_CN'=>$typeSimplifiedChineseName, 'zh_TW'=>$typeTraditionalChineseName, 'ja'=>$typeJapaneseName, 'ko'=>$typeKoreanName, 'es'=>$typeSpanishName, 'de'=>$typeGermanName, 'ru'=>$typeRussianName, 'fr'=>$typeFrenchName, 'it'=>$typeItalianName, 'pl'=>$typePolishName, 'pt_PT'=>$typePortugueseName, 'th'=>$typeThaiName, 'hu'=>$typeHungarianName, 'ar'=>$typeArabicName , 'created'=>date('Y-m-d'), 'modified'=>date('Y-m-d'));
				$ret3 = $this->User_model->insertData($MYSQL['_categoriesDB'], $insertAry);
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
			//$select = ' a.*, c.category_name, d.title, d.credit, d.description, d.duration, e.price, f.currency, g.subtitle_content, g.subtitle_show_time, g.subtitle_end_time';
			$select = ' a.*, c.category_name, d.title, d.credit, d.description, d.duration, e.price, f.currency';
			$conAry = array();
			if($type != "-1") {
				$conAry = array('b.category_id'=>$type);
			}
			$column_order = array(null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
			$column_search = array('d.title', 'd.description');
			$travel_cate = $this->User_model->getTableDatas($MYSQL['_videoDB'].' a', $conAry, $column_search, 
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
				$strAction = '<a href="javascript:void(0)" class="on-default edit-row" onclick="EditData('.$item->Id.')" title="Edit" ><i class="fa fa-pencil cus"></i></a> <a href="javascript:void(0)" class="on-default remove-row" onclick="RemoveData('.$item->Id.')" title="Remove" ><i class="fa fa-trash-o cus"></i></a>';	
				/*if($item->type_id == '1') {
					$strAction = '<a href="javascript:void(0)" class="on-default edit-row" onclick="PlayVideo('.$item->Id.')" title="Play" ><i class="fa fa-file-video-o cus"></i></a> <a href="javascript:void(0)" class="on-default edit-row" onclick="EditData('.$item->Id.')" title="Edit" ><i class="fa fa-pencil cus"></i></a> <a href="javascript:void(0)" class="on-default remove-row" onclick="RemoveData('.$item->Id.')" title="Remove" ><i class="fa fa-trash-o cus"></i></a>';	
				}*/
				$row[] = $no;
				$row[] = $item->category_name;
				$row[] = $item->video_type;
				$row[] = $item->video_url;
				$row[] = '<img src="'.$item->video_thumbnail_url.'"class="thumb-md" alt="">';
				$row[] = '<img src="'.$item->video_preview_url.'"class="thumb-md" alt="">';
				$row[] = '<img src="'.$item->video_background_url.'"class="thumb-md" alt="">';
				$row[] = $item->title;
				/*$row[] = $item->subtitle_content;*/
				$row[] = $item->description;
				$row[] = $item->duration;
				$row[] = $item->credit;
				$row[] = $item->file_name;
				$row[] = $item->paid;
				$row[] = $item->price;
				$row[] = $item->currency;
				/*$row[] = $item->video_preview_capture_time;*/
				$row[] = $item->pin_to_top;
				$row[] = $item->allow_download;
				$row[] = $item->video_views;
				/*$row[] = $item->subtitle_show_time;
				$row[] = $item->subtitle_end_time;*/
				$row[] = $strAction;
				$data[] = $row;
			}

			$output = array(
					"draw" => $_POST['draw'],
					"recordsTotal" => $this->User_model->getCounts($MYSQL['_videoDB'].' a', $conAry),
					"recordsFiltered" => $this->User_model->count_filtered($MYSQL['_videoDB'].' a', $conAry, 
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
			$data = $this->User_model->getRow($MYSQL['_videoDB'], array('Id' => $Id));
			if($data->video_type == 'Server'){
				$this->deleteFile($data->video_url);
			}
			$this->deleteFile($data->video_thumbnail_url);
			$this->deleteFile($data->video_preview_url);
			$this->deleteFile($data->video_background_url);

			$this->User_model->deleteByField($MYSQL['_videoDB'], 'Id', $Id);
			$this->User_model->deleteByField($MYSQL['_categoryDB'], 'vr_video_id', $Id);
			$this->User_model->deleteByField($MYSQL['_detailsDB'], 'vr_video_id', $Id);
			$this->User_model->deleteByField($MYSQL['_priceDB'], 'vr_video_id', $Id);
			echo json_encode(array("status" => TRUE));
		}
	}
	private function deleteFile( $path)
	{
		//$removefile = $path.$file_name;
		if( file_exists( $path ) )
			unlink( $path );
	}
	public function add_data(){
		if($this->logonCheck()) {
			global $MYSQL;
			$dataId = $this->input->post('data_Id');
			$type = $this->input->post('type_Id');
			$categoryId = $this->input->post('category_Id');
			$category = $this->input->post('category_Id');
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
			/*$subtitle = $this->input->post('subtitle');*/
			$description = $this->input->post('description');
			$credit = $this->input->post('credit');
			$paidContent = $this->input->post('paid_id');
			$price = "";
			$paidUnit = "";
			/*$captureTime = $this->input->post('captureTime');*/
			$pinToTop = $this->input->post('Pin_id');
			$allowDownload = $this->input->post('AllowDownload');
			$videoViews = 0;
			/*$videoSubtitleShowTime = $this->input->post('subtitleShowTime');
			$videoSubtitleEndTime = $this->input->post('subtitleEndTime');*/
			$fullPath = "";

			if($paidContent == 'Y'){
				$price = $this->input->post('price');
				$paidUnit = $this->input->post('unit_id');
			}
			if($type == '3') 
				$duration = "";
			$filesize = "0 bytes";

			if($dataId !='') {
				$data = $this->User_model->getRow($MYSQL['_videoDB'], array('Id' => $dataId));
				$thumbnail_old = $data->video_thumbnail_url;
				$preview_old = $data->video_preview_url;
				$background_old = $data->video_background_url;
				$fullPath = $data->video_url;
				$link_file = $data->file_name;
				//$duration = $data->duration;
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
				if($type == 'Youtube'){
					$link_file = $this->input->post('url');
					$fullPath = $link_file;
				}
			}

			if($dataId !='') {
				$updateVideoAry = array('video_type'=>$type , 'video_thumbnail_url'=>$thumbnail, 'video_background_url'=>$background, 'video_preview_url'=>$preview, 'video_url'=>$fullPath, 'file_name'=>$link_file, 'paid'=>$paidContent, 'pin_to_top'=>$pinToTop, 'allow_download'=>$allowDownload, 'updated'=>date('Y-m-d H:i:s'));
				$retVideo = $this->User_model->updateData($MYSQL['_videoDB'], array('Id'=>$dataId), $updateVideoAry);

				$updateCategoryAry = array('vr_category_id' => $categoryId);
				$retCategory = $this->User_model->updateData($MYSQL['_categoryDB'], array('vr_video_id'=>$dataId), $updateCategoryAry);

				$updateDetailsAry = array('title' => $title, 'credit' => $credit, 'description' => $description, 'duration' => $duration);
				$retDetails = $this->User_model->updateData($MYSQL['_detailsDB'], array('vr_video_id'=>$dataId), $updateDetailsAry);

				$updatePriceAry = array('currency_id' => $paidUnit, 'price' => $price);
				$retPrice = $this->User_model->updateData($MYSQL['_priceDB'], array('vr_video_id'=>$dataId), $updatePriceAry);

				if($retVideo > 0) {
					echo json_encode(array("status"=>TRUE));
				} else {
					echo json_encode(array("status"=>FALSE));
				}
			}
			else {
				$updateVideoAry = array('video_type'=>$type , 'video_thumbnail_url'=>$thumbnail, 'video_background_url'=>$background, 'video_preview_url'=>$preview, 'video_url'=>$fullPath, 'file_name'=>$link_file, 'paid'=>$paidContent, 'pin_to_top'=>$pinToTop, 'allow_download'=>$allowDownload, 'video_views' => 0, 'created'=>date('Y-m-d H:i:s'));
				$retVideo = $this->User_model->insertData($MYSQL['_videoDB'], $updateVideoAry);

				$updateCategoryAry = array('vr_video_id'=>$retVideo, 'vr_category_id' => $categoryId);
				$retCategory = $this->User_model->insertData($MYSQL['_categoryDB'], $updateCategoryAry);

				$updateDetailsAry = array('vr_video_id'=>$retVideo, 'title' => $title, 'credit' => $credit, 'description' => $description, 'duration' => $duration);
				$retDetails = $this->User_model->insertData($MYSQL['_detailsDB'], $updateDetailsAry);

				$updatePriceAry = array('vr_video_id'=>$retVideo, 'currency_id' => $paidUnit, 'price' => $price);
				$retPrice = $this->User_model->insertData($MYSQL['_priceDB'], $updatePriceAry);

				if($retVideo) {
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