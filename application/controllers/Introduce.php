<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include("assets/global/admin.global.php");
class Introduce extends CI_Controller {

	public function index()
	{
		$this->load->view('index');
	}
}
