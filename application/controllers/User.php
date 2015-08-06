<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	public function index()
	{
		if($this->session->id){
			redirect('act');
		}else{
			$this->load->view('welcome');
		}
	}
	public function login()
	{
		if($this->session->id){
			redirect('act');
		}else{
			$data['login_error']='';
			if($this->input->method()=='get'){
				$this->load->view('login',$data);
			}else{
				$this->load->model('user_model');
				if($res=$this->user_model->login()){
					$this->session->set_userdata($res);
					redirect('act');
				}else{
					$data['login_error']='Error Username or Password';
						$this->load->view('login',$data);
				}
			}
		}
	}

	public function signup()
	{
//		if($this->session->id){
//			echo $this->session->email;
//		}else{
			if($this->input->method()=='get'){
				$this->load->view('signup');
			}else{
				$this->load->model('user_model');
				if($this->user_model->signup()){
					echo '<script>alert(/success/);window.location="login";</script>';
				}else{
					$this->load->view('signup');
				}
			}
//		}
	}
	public function logout()
	{
		session_destroy();
		redirect('');
	}

	public function register(){
		if($this->session->id){
			$this->load->model('user_model');
			if($this->user_model->register()){
				echo "success";
			}
			else{
				echo "err:".$this->db->error()['code'];
			}
		}
		else{
			redirect('');
		}
	}

	public function myinfo($user_id=1){
		if($this->session->id){
			$this->load->model('user_model');
			if($data['row'] = $this->user_model->myinfo_get($user_id)){
				if($this->session->id == $user_id){
					$data['authority'] = true;
				}
				else{
					$data['authority'] = false;
				}
				//var_dump($data);
				$this->load->view('user_info/user_info',$data);
			}
			else{
				echo "data error";
			}
		}
		else{
			redirect('');
		}
	}

	public function home(){
		if($this->session->id){
			$this->load->model('user_model');
			$this->load->view('home/home');
		}
		else{
			redirect('');
		}
	}

	public function inv_classify(){
		if($this->session->id){
			$this->load->model('user_model');
			$this->load->view('classify/inv_classify');
		}
		else{
			redirect('');
		}
	}

	public function myinfo1(){
		if($this->session->id){
			$this->load->model('user_model');
			$this->load->view('user_info/user_info1');
		}
		else{
			redirect('');
		}
	}

	public function myinfo_edit(){
		if($this->session->id){
			if($this->input->method()=='get'){
				$this->load->model('user_model');
				$data = $this->user_model->myinfo_edit_get();
				$this->load->view('personal_info_edit',$data);
			}
			else{
				$this->load->model('user_model');
				if($this->user_model->myinfo_edit()){
					echo '<script>alert(/success/);window.location="login";</script>';
				}	
				else{
					$this->load->view('personal_info_edit');
				}
			}	
		}
		else{
			redirect('welcome');
		}
	}

//	public function info_post(){
//		$this->load->model('user_model');
//		if($this->session->id){
//			if($this->input->method()=='get'){
//				$this->load->view('personal_info');
//			}else{
//				if($this->user_model->myinfo_edit()){
//					echo '<script>alert(/success/);window.location="myinfo";</script>';
//				}else{
//					echo 'failed';
//				}
//			}
//		}
//	}

	public function account_info(){
		if($this->session->id){
			$this->load->model('user_model');
			$this->load->view('user_info/account_info');
		}
		else{
			redirect('');
		}
	}

	public function message($type=0){
		//$this->load->model('Msg_model');
		/*
		$data['type']=$type;
		if($type==0)
		{

			$this->load->view('message');
		}
		else 
			$this->load->view('message_line_top',$data);
		*/
		$this->load->view('header');
		$this->load->view('message_line_top');
		$this->load->view('message_detail_list',$type);//it's not the page display after you click the particular message;
		$this->load->view('footer');
	}

	public function follow($user_id=1){
		//建议在model里面加入表单验证，以及 session->id!=$user_id也在表单验证中完成
		if($this->session->id){
			if($this->session->id != $user_id){			//A cannot follow A
				$this->load->model('user_model');
				if($this->user_model->follow($user_id)){
					echo '<script>alert(/follow success/);</script>';
					return true;
				}
			}
		}
		else{
			redirect('');
		}
	}

	public function unfollow($user_id=1){
		//建议在model里面加入表单验证，以及 session->id!=$user_id也在表单验证中完成
		if($this->session->id){
			if($this->session->id != $user_id){			//A cannot unfollow A
				$this->load->model('user_model');
				if($this->user_model->unfollow($user_id)){
					echo '<script>alert(/unfollow success/);</script>';
					return true;
				}
			}
		}
		else{
			redirect('');
		}
	}

	
}
