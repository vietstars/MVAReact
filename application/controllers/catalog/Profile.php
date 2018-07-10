<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class profile extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->database();
	}
	public function index()
	{
		$this->load->_ci_title='User\'s profile';
		$data['banner']=_IMG."system/mva_about_us_hero_wide.jpg";
		$data['bg_class']="aboutus-page";
		$data['bg_content']='<div class="gradient-bg">'.
			'<div class="container">'.
				'<div class="banner-text aboutus-text">'.
					'<h1>USER\'S PROFILE</h1>'.
					'<span>We do not simply build motorcycles, we craft emotions. We look to the future, and build machines that are always one step ahead.</span>'.
				'</div>'.
			'</div>'.
		'</div>';
		$this->_render('template/default/profile',$data);
	}
}
