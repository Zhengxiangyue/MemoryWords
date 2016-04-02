<?php
/**
 * Created by PhpStorm.
 * User: Cancel
 * Date: 21/3/16
 * Time: 4:42 PM
 */
class Word_Model extends CI_Model{

    /**
     * @var string
     */
    private $table_name = 'Words';

    /**
     * Word_Model constructor.
     */
    public function __construct(){
        parent:: __construct();
    }


    /**
     * 从数据库中取出NUM个单词
     * @param array $word_id_list 要推荐的单词的id的数组 array('3','4','54');
     * @return array
     */
    public function get_user_word_list($word_id_list){
        $word_repertory = 1;

        $this->db->select("*");
        $this->db->from($this->table_name);

        $this->db->where(array('id' => $word_id_list[0]));
        $num = count($word_id_list);
        for($i = 1;$i<$num;++$i){
            $this->db->or_where(array('id' => $word_id_list[$i]));
        }

        $res = $this->db->get();
        if($res->num_rows()>0){
            return $res->result();
        }
        return false;
    }



    public function get_words_by_id_array($words_array){

        $this->db->select("*");
        $this->db->from($this->table_name);
        $this->db->where(array('id' => $words_array[0]));

        $num = count($words_array);

        for($i = 1;$i<$num;++$i){
            $this->db->or_where(array('id' => $words_array[$i]));
        }

        $res = $this->db->get();
        if($res->num_rows()>0){
            return $res->result();
        }
        return false;
    }


    /**
     * @param $word
     * @param $property
     * @param $meaning
     * @return int
     */
    public function add_word($word, $property, $meaning){
        if(empty($word)){
            return 1;
        }
        if(empty($property)){
            return 2;
        }
        $data = array(
            'word' => $word,
            'property' => $property,
            'meaning' => $meaning,
        );

        $this->db->select('Word');
        $this->db->from($this->table_name);
        $this->db->where($data);
        $res = $this->db->get();
        if($res->num_rows()>0){
            return 3;
        }
        $this->db->insert($this->table_name,$data);
        return 0;
    }

    /**
     * @param $word
     * @return bool
     */
    public function get_word($word){
        $this->db->select('Word');
        $this->db->from($this->table_name);
        $this->db->where(array('Word'=>$word));

        $res = $this->db->get();
        if($res->num_rows()>0){
            return $res->row();
        }
        return false;
    }

    //随机抽取

    /**
     * @param $num
     * @return bool
     */
    public function get_random_word($num){
        $num_list = $this->random_num_array(1,15328,$num);
        $this->db->select("*");
        $this->db->from($this->table_name);
        $this->db->where(array('id' => $num_list[0]));

        for($i = 1;$i<$num;++$i){
            $this->db->or_where(array('id' => $num_list[$i]));
        }

        $res = $this->db->get();
        if($res->num_rows()>0){
            return $res->result();
        }
        return false;
    }

    /**
     * 返回从begin到end的num个不相同的随机数,并且保证这些数字都不在ban_array中
     * @param $begin
     * @param $end
     * @param $num
     * @return array
     */
    private function random_num_array($begin, $end, $num){

        $range = range($begin,$end);
        shuffle($range);
        $result = array_slice($range,0,$num);
        return $result;

    }

    /**
     * @param $min
     * @param $max
     * @param $num
     */
    function unique_rand($min, $max, $num) {

    }
}