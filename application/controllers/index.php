<?php
Class index extends CI_Controller{
    function __construct(){
        parent::__construct();
        //load some models
        $this->load->model('my_database');
        $this->load->database();
    }
    
    function index(){
        if(!isset($_COOKIE["user_id"]) ){
           $this->load->view('user_login');
        }
        else{
            echo $_COOKIE['user_id'];
            echo $_COOKIE['user_cookie'];
             if($this->my_database->maching('zx_cookie',
                                            'user_id',
                                            $_COOKIE["user_id"],
                                            'cookie_id',
                                            $_COOKIE["user_cookie"]))
             {
                 $this->load->view('welcome_user');
             }
             else{
                 echo "用户登陆过期，请从新登陆";
                 $this->load->view('user_login');
             }
        }
    }
    
    function login(){
        $inputUsername = $this->input->post('username');
        $inputPassword = $this->input->post('password');
        
        //echo "inputusername:".$inputUsername;
        //echo "</br>inputpassword:".$inputPassword."<br/>";
        
        $data['username'] = $inputUsername;
        $data['passowrd'] = $inputPassword;
        
        if($this->my_database->maching(
            'user',
            'user_name',
            $inputUsername,
            'user_password',
            md5($inputPassword)
        )){
            setcookie('user_id',$this->my_database->getUserID($inputUsername),time()+60);
            setcookie('user_cookie',$this->my_database->generateCookieID($this->my_database->getUserID($inputUsername)),time()+60);
            
            Header("Location:http://ci.form.com/index");
         
        }
        else{
          Header("Location:http://ci.form.com/index");
          exit();
        }
    }
    
    function signup(){
        $suUsername = $this->input->post('su-username');
        $suPassword = $this->input->post('su-password');
        
        if($this->my_database->exist('user',$suUsername)){
            $data['msg'] = "用户名已经注册过";
            $this->load->view("user_login",$data);
        }
    }

/*------------------convient for funtion test------------------*/
    function test(){
         $rand = md5(time()," ".mt_rand(0,100));
         echo $rand;
    }
    
    function deletecookie(){
        setcookie("user_id", "", time()-3600);
        setcookie("user_cookie", "", time()-3600);
        
        echo "done";
    }
    
    function showcookie(){
       echo $_COOKIE['user_id'];
       echo $_COOKIE['user_cookie'];
    }
}


?>