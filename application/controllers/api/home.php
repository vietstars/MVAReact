<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class home extends MY_Controller {
	public function __construct()
    {
        parent::__construct();	
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_patch']['limit'] = 100; // 50 requests per hour per user/key  
        $this->methods['users_put']['limit'] = 100; // 50 requests per hour per user/key  
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key	
	}
    public function users_get()
    {       
        $users = $this->db->select(array('id','fullname','email','avatar'))->get_where('user',array('ctl'=>0))->result_object();
        foreach ($users as $k => $v) {
            if($v->avatar){
                $v1=explode("_",$v->avatar);
                $folder=date('d-m-Y',current($v1));
                $users[$k]->avatar=$folder._S.$v->avatar;
            }else{
                $users[$k]->avatar='../no_photo1.svg';
            }
        }
        if (isset($users))
        {
            $this->response($users, 200);
        }
        else
        {
            $this->response([
                'status' => FALSE,
                'message' => 'No users were found'
            ], 404);
        }
    }
    public function users_post()
    {       
        $users = [
            ['id' => 1, 'name' => 'John', 'email' => 'john@example.com', 'fact' => 'Loves coding'],
            ['id' => 2, 'name' => 'Jim', 'email' => 'jim@example.com', 'fact' => 'Developed on CodeIgniter'],
            ['id' => 3, 'name' => 'Jane', 'email' => 'jane@example.com', 'fact' => 'Lives in the USA', ['hobbies' => ['guitar', 'cycling']]],
        ];
        $id = $this->post();
        var_dump($id);exit;
        if ($id !== NULL)
        {
            // Check if the users data store contains users (in case the database result returns NULL)
            if (isset($users))
            {
                // Set the response and exit
                $this->response($users, $this::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No users were found'
                ], $this::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'No users were found'
            ], $this::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }
    public function users_put()
    { 
        $email = $this->put('email');
        if (filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $put=$this->db->insert('user',array('fullname'=>$this->put('fullname'),'email'=>$this->put('email'),'created'=>_DATE));
            if($put)
            {
                $this->users_get();
            }
            else
            {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Can\'t add new member'
                ], 404); 
            }
        }else{
            $this->response([
                'status' => FALSE,
                'message' => $email.' is not a valid email address'
            ], 404);
        }
    }
    public function users_patch()
    {       
        $id = $this->patch('id');
        if (ctype_digit($id))
        {
            $patch = $this->db->set(array('fullname'=>$this->patch('fullname'),'email'=>$this->patch('email')))
            ->where_in('id',$id)
            ->update('user');
            if ($patch)
            {
                $this->users_get();
            }
            else
            {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Can\'t update this member'
                ], 404);
            }
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'Account id is number only'
            ], 404);
        }
    }
	public function users_delete()
	{	
        $id = $this->delete('id');
        if (ctype_digit($id))
        {
            $deleted = $this->db->set(array('ctl'=>2))
            ->where_in('id',$id)
            ->update('user');
            if($deleted){
                $this->users_get();
            }else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'Can\'t delete this member'
                ], 404);
            }
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'Account id is number only'
            ], 404);
        }
	}

}
