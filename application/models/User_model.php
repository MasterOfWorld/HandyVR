<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_model extends CI_Model {

	var $order = array('id' => 'asc'); // default order 
	public function __construct()
	{
		 parent::__construct();
	}

	public function doChangePwd($Id, $userPWD, $newPWD)
	{
		global $MYSQL;
		$strsql = sprintf("select * from %s where Id='$Id' ", $MYSQL['_adminDB']);
		$ret = $this->db->query($strsql)->row();
		if($ret){
			$salt = $ret->userPWDKey;
			$genPWD = crypt($userPWD, $salt);
			if($genPWD == $ret->userPWD){
				$salt = md5(date("YmdHis"));
				$genPWD = crypt($newPWD, $salt);
				$strsql = sprintf("UPDATE %s SET userPWD='$genPWD', userPWDKey='$salt' WHERE Id= '$Id' ", 
					$MYSQL['_adminDB']);
				$this->db->query($strsql);
				return TRUE;
			}
		}
		return FALSE;
	}
	public function getVideo($cate_id='', $video_id='') {
		global $MYSQL;
		$this->db->select(' a.*, b.cate_id, b.title as sub_title');
		$this->db->from($MYSQL['_videoDB'].' a');
		$this->db->join($MYSQL['_subcateDB'].' b', 'a.subcate_id = b.Id', 'left');
		if($video_id !='') {
			$this->db->where('a.Id', $video_id);
		}
		if($cate_id !='') {			 
			$this->db->where('b.cate_id', $cate_id);
		}
		return $this->db->get()->result();
	}

	private function _get_datatables_query($tbl_name, $conAry, $srchAry, $orderAry, $kind='', $select='') {
		global $MYSQL;
		if($select !='') {
			$this->db->select($select);
		}
        $this->db->from($tbl_name);
		if($kind =='data') {
			$this->db->join($MYSQL['_categoryDB'].' b', 'a.Id = b.vr_video_id', 'left');
			$this->db->join($MYSQL['_categoriesDB'].' c', 'b.vr_category_id = c.Id', 'left');
			$this->db->join($MYSQL['_detailsDB'].' d', 'a.Id = d.vr_video_id', 'left');
			$this->db->join($MYSQL['_priceDB'].' e', 'a.Id = e.vr_video_id', 'left');
			$this->db->join($MYSQL['_currencyDB'].' f', 'e.currency_id = f.Id', 'left');
			//$this->db->join($MYSQL['_subtitleDB'].' g', 'a.Id = g.video_id', 'left');
		}
		if(!empty($conAry))
			$this->db->where( $conAry );
        $i = 0;
        foreach ($srchAry as $item) // loop column
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($srchAry) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($orderAry[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function count_filtered($tbl_name, $conAry, $srchAry, $orderAry, $kind='', $select='') {
        $this->_get_datatables_query($tbl_name, $conAry, $srchAry, $orderAry, $kind, $select);
        $query = $this->db->get();
        return $query->num_rows();
    }

	public function getDatas( $tbl_name, $conAry, $orderBy='' ) {
		$this->db->from($tbl_name);
		if(!empty($conAry))
			$this->db->where( $conAry );
		if($orderBy !='') {
			$this->db->order_by($orderBy, 'ASC');
		}
		$ret = $this->db->get()->result();
		return $ret;
	}
	public function updateData($tbl_name, $conAry, $updateAry) {
		if(!empty($updateAry)) {
			$this->db->update($tbl_name, $updateAry, $conAry);
		}
		return $this->db->affected_rows();
	}
	public function updateOnOff($tbl_name, $Id, $field)
    {
		global $MYSQL;
		$this->db->from($tbl_name);
		$this->db->set($field, '1-'.$field, FALSE);
		$this->db->where('Id', $Id);
		$this->db->update();
    }
	public function deleteByField( $tbl_name, $field, $value ) {
		$this->db->where($field, $value);
        $this->db->delete($tbl_name);
	}

	public function getTableDatas($tbl_name, $conAry, $srchAry, $orderAry, $kind='', $select='') {
		$this->_get_datatables_query($tbl_name, $conAry, $srchAry, $orderAry, $kind, $select);
        if($_POST['length'] != -1)
        	$this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
	}
	public function getCounts($tbl_name, $conAry) {
    	$this->db->from($tbl_name);
		if(!empty($conAry))
			$this->db->where( $conAry );
		return $this->db->count_all_results();
    }
    
    public function insertData($tbl_name, $data)
    {
        $this->db->insert($tbl_name, $data);
        return $this->db->insert_id();
    }
    public function getDataById($tbl_name, $Id)
    {
        $this->db->from($tbl_name);
        $this->db->where('Id',$Id);
        $query = $this->db->get();
        return $query->row();
    }
    public function getDataByVideoId($tbl_name, $Id)
    {
        $this->db->from($tbl_name);
        $this->db->where('vr_video_id',$Id);
        $query = $this->db->get();
        return $query->row();
    }

    public function appInstall($phone) {
    	global $MYSQL;
    	$ret = $this->getRow($MYSQL['_customeDB'], array('phone' => $phone));
    	if($ret) {
    		return TRUE;
    	}
    	$this->db->from($MYSQL['_customeDB']);
		$this->db->set('isInstall', '1', FALSE);
		$this->db->where('phone',$phone);
		$this->db->update();
		if($this->db->affected_rows() > 0)
			return TRUE;
		else 
			return FALSE;
    }
    public function getRow($tbl_name, $conAry) {
    	$this->db->from($tbl_name);
    	$this->db->where($conAry);
        $query = $this->db->get();
        return $query->row();
    }
    public function setField($tbl_name, $field, $value, $conAry) {
    	$this->db->from($tbl_name);
		$this->db->set($field, $value, FALSE);
		$this->db->where($conAry);
		$this->db->update();
    }
    public function getSumCost($cate_id=''){
    	global $MYSQL;
    	$this->db->select_sum('price');
		$this->db->from($MYSQL['_paymentDB'].' a');
		$this->db->join($MYSQL['_subcateDB'].' b', 'a.subcate_id = b.Id', 'left');
		if($cate_id !='') {			 
			$this->db->where('b.cate_id', $cate_id);
		}
		return $this->db->get()->row();
    }
    public function getUserPaymentHistory($user_id) {
    	global $MYSQL;
    	$this->db->select('a.price, a.created, b.title');
		$this->db->from($MYSQL['_paymentDB'].' a');
		$this->db->join($MYSQL['_subcateDB'].' b', 'a.subcate_id = b.Id', 'left');
		if($user_id !='') {			 
			$this->db->where('a.user_id', $user_id);
		}
		$this->db->order_by('a.created', 'DESC');
		return $this->db->get()->result();
    }

    ////////////////////////////////////////////// API  /////////////////////////////////////////////////
    public function auth_user($email, $password) {
		global $MYSQL;
		$this->db->select('a.*, b.name as company, b.domain');
		$this->db->from($MYSQL['_userDB'].' a');
		$this->db->join($MYSQL['_companyDB'].' b', 'a.company_id = b.Id', 'left');
		$conAry = array('a.email'=>$email, 'a.isdeleted'=>'0');
		$this->db->where($conAry);
		$ret = $this->db->get()->result();
		if(!empty($ret)){
			if (password_verify($password, $ret[0]->password)) {       
				if($ret[0]->isactive == '0') {
					return 'not_active';
				}
				return $ret[0];
			} else {
				return 'not password';
			}
		}
		return FALSE;
	}
	public function auth_id($user_id) {
		global $MYSQL;
		$this->db->select('a.*, b.name as company, b.domain');
		$this->db->from($MYSQL['_userDB'].' a');
		$this->db->join($MYSQL['_companyDB'].' b', 'a.company_id = b.Id', 'left');
		$conAry = array('a.Id'=>$user_id, 'a.isdeleted'=>'0');
		$this->db->where($conAry);
		$ret = $this->db->get()->result();
		if(!empty($ret)){
			return $ret[0];
		}
		return FALSE;
	}

	public function getSubCateList($cate_id) {
		global $MYSQL;
    	$this->db->select('a.*, b.name, b.cost');
		$this->db->from($MYSQL['_subcateDB'].' a');
		$this->db->join($MYSQL['_costDB'].' b', 'a.cost_id = b.Id', 'left');
		$this->db->where(array('a.cate_id'=>$cate_id ,'a.isactive'=>'1', 'a.isdeleted'=>'0'));
		$this->db->order_by('a.created', 'DESC');
		return $this->db->get()->result();
	}

	// JHS
	public function getVideoDatas($tbl_name, $select){
		global $MYSQL;
		if($select !='') {
			$this->db->select($select);
		}
        $this->db->from($tbl_name);
		$this->db->join($MYSQL['_categoryDB'].' b', 'a.Id = b.vr_video_id', 'left');
		$this->db->join($MYSQL['_categoriesDB'].' c', 'b.vr_category_id = c.Id', 'left');
		$this->db->join($MYSQL['_detailsDB'].' d', 'a.Id = d.vr_video_id', 'left');
		$this->db->join($MYSQL['_priceDB'].' e', 'a.Id = e.vr_video_id', 'left');
		$this->db->join($MYSQL['_currencyDB'].' f', 'e.currency_id = f.Id', 'left');
		//$where = "b.userMail = $email OR a.user_id='0'";
		//$Id = $this->getUsersIdByMail($email);
		//$this->db->where('user_id','0');
		//$this->db->or_where('b.userMail', $email);
		$query = $this->db->get();
        return $query->result();
        /*$str = "SELECT tbl_data.*, tbl_user.userMail as user_mail FROM tbl_data LEFT JOIN tbl_user ON tbl_data.user_id = tbl_user.Id WHERE tbl_user.userMail = '" . $email . "'";
        return $this->db->query($str)->result();*/
	}

	public function updateVideoViews($dataId){
		global $MYSQL;
		//$this->db->from($MYSQL['_dataDB']);
		$this->db->where('Id', $dataId);
		$this->db->set('video_views', 'video_views+1', false);
		$this->db->update($MYSQL['_videoDB']);

		/*$str = "UPDATE tbl_data SET VideoViews = VideoViews + 1 WHERE Id = '63'";
		$this->db->query($str);*/
	}
	//
}


