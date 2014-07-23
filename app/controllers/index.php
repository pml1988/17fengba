<?php
    class index extends CI_Controller {
      function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('func',array('url'=>base_url()));
	}
	public function index()
	{
		echo base_url();
        }
        
    }
?>