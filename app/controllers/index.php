<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 17fengba System
 *
 * 基于Codeigniter的驴友旅游系统
 * 
 * 17fengba is an open source  System built on the 
 * well-known PHP framework Codeigniter.
 *
 * @package		17FENGBA
 * @author		Jane <pml1988.ok@163.com>
 * @copyright	Copyright (c) 2014 - 2015, 17fengba.com.
 * @license		GNU General Public License 2.0
 * @link		https://github.com/pml1988/17fengba
 * @version		0.1
 */
 
// ------------------------------------------------------------------------
/**
 * 17fengba 内容控制器
 *
 *	主要用于控制首页显示相关内容的功能表现
 */
    class index extends CI_Controller {
      function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('func',array('url'=>base_url()));	
                $this->load->model('mconfig');
                $this->load->model('muser');
	}
	public function index()
	{
	  $data=$this->mconfig->get_cfg();
          $this->load->view('home',$data);
        }
        
    }
?>