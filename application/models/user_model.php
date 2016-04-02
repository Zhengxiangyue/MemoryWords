<?php
/**
 * Created by PhpStorm.
 * User: Cancel
 * Date: 24/3/16
 * Time: 11:05 AM
 */
class user_model extends CI_Model{

    private $table_name = 'user';

    public function __construct()
    {
        parent:: __construct();
    }

    public function get_login_result($user_name,$password){

        $password = $this->enCode($password);

        $this->db->select('user_password');
        $this->db->from($this->table_name);
        $this->db->where(array('user_name' => $user_name));
        $res = $this->db->get();

        if($res->num_rows() == 0){
            return 0;
        }
        if($password == $res->row()->user_password){
            return 1;
        }
        return 2;
    }

    public function add_new_user($user_name,$password){

        $password = $this->enCode($password);

        $array = array(
            'user_name' => $user_name,
            'user_password' => $password
        );

        return $this->db->insert($this->table_name,$array);
    }

    public function if_user_avaliable($user_name){
        $this->db->select('user_name');
        $this->db->from($this->table_name);
        $this->db->where(array('user_name'=>$user_name));

        $res = $this->db->get();
        if($res->num_rows() > 0){
            return false;
        }
        return true;
    }


    /**
     * 通用加密
     * @param String $string 需要加密的字串
     * @param String $skey 加密EKY
     * @return String
     */
    private function enCode($string = '', $skey = 'fb') {
        $skey = array_reverse(str_split($skey));
        $strArr = str_split(base64_encode($string));
        $strCount = count($strArr);
        foreach ($skey as $key => $value) {
            $key < $strCount && $strArr[$key].=$value;
        }
        return str_replace('=', 'O0O0O', join('', $strArr));
    }



}