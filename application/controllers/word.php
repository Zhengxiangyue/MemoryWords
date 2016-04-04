<?php

/**
 * Created by PhpStorm.
 * User: Cancel
 * Date: 21/3/16
 * Time: 4:31 PM
 *
 * INTRODUCTION:
 * 基本的数据结构是对象array,用户背单词时根据推荐算法从后台取回今天要背的单词
 *
 * 用户缓存:
 *  用户背了多少天单词: user_days_of_memory_word_USERID_REPERTORY int
 *  被禁止单词列表: user_ban_list_USERID hset('user_id') word_id
 *  收藏单词列表: user_collect_list_USERID hset('user_id') word_id
 *  用户学习记录: user_study_history_list_USERID word_id
 *
 *
 * 推荐指数 = (上次见到这个单词的时间指数 + 收藏指数) * 禁止指数
 *
 *  被用户禁掉的单词不会出现
 *
 *
 */
class Word extends CI_Controller{

    /**
     * 各种cache的键
     * @var string
     */
    private $user_study_history_list_key = 'CACHE_USER_STUTY_HISTORY_'; // .USERID

    private $user_ban_list_key = 'CACHE_USER_BAN_LIST_'; //.USERID

    private $user_collect_list_key = 'CACHE_USER_COLLECT_LIST_'; //.USERID

    private $user_words_repertory_key = 'CACHE_USER_WORDS_REPERTORY_'; //USERID


    //储存用户背单词天数,顺序模式时背到哪个词,
    private $user_info_key = 'CACHE_USER_INFO_KEY_';//.USERID

    /**
     * 各种cookie的键
     * @var string
     */

    //用户登录状态
    private $user_status_cookie_key = 'COOKIE_KEY_MEMORY_WORD_USER_STATUS';

    private $user_cookie_name = 'COOKIE_USER_NAME';

    /**
     * 各种时间
     * @var string
     */
    private function cookie_expire_time($days_num = 15){
        return 3600*24*$days_num;
    }

    private function cache_expire_time($month_num = 3){
        return 3600*24*30*$month_num;
    }

    private $ALL_WORDS_NUM = 15328;

    private $youdao_api_url ='http://fanyi.youdao.com/openapi.do';

    /**
     * Word constructor.
     */
    public function __construct(){
        parent::__construct();
        date_default_timezone_set('PRC');
        $this->load->model('word_model');
        $this->load->model('user_model');
        $this->load->driver('cache', array('adapter' => 'redis'));
        //$this->load->library('Cache');
        //$this->load->library('cache');
        //$this->load->driver('cache');
    }

/*视图 index list */
    /**
     *
     */
    public function index(){

        //检查用户登录状态 false是游客
        $user_id = $this->check_login();
        //已经登陆跳转到word_ini
        if($user_id !== false){
           return $this->redirect(base_url('word/word_ini'));
        }

        //未登陆加载index页面
        $word_list = $this->word_model->get_random_word(10);

        //推荐算法

        /*
         * 传给视图的值
         *  浏览器头:MW_title
         *  标题:MW_site_head
         *  副标题:MW_site_subhead
         *  用户id user_id
         *  用户名:user_name
         *
         *  推荐单词列表 对象数组(word_obj)array()
         * */

        $data = array(
            'user_id' => $user_id,
            'word_list' => $word_list,
        );

        $this->load->view('word/index',$data);
    }

    /**
     *
     */
    public function word_list(){

        //检查用户登录状态

        //获取参数

        //从cache里面取出用户用户列表

        //传值给视图
    }


    /**
     *处理登陆用户
     */
    public function word_ini(){
        $user = $this->check_login();
        if($user === 0){
            $this->redirect(base_url('word/index'));
        }

        //上次学习记录未完成,把历史记录给前端,问用户是否接着上回的单词背
        $last_list = $this->get_last_word_list($user);

        $user_info_list = $this->cache->get($this->user_info_key.$user);
        $user_info_array = unserialize($user_info_list);

        if(empty($user_info_array)){
            $user_info_array = array(
                'days' => 0,
                'last_accomplish_date' => '1970-01-01 00:00:00',
                'cards_num' => 0,
            );
        }

        $ban_list = $this->cache->get($this->user_ban_list_key.$user);
        $ban_array = $this->word_model->get_words_by_id_array(unserialize($ban_list));

        $days = $user_info_array['days'];
        $cards_num = $user_info_array['cards_num'];

        $if_accomplish_today = date('Y-m-d') > date('Y-m-d',strtotime($user_info_array['last_accomplish_date'])) ? false:true;

        //组装数据给前端
        $data = array(
            'last_list' => $last_list,
            'user_id' => $user,
            'days' => $days,
            'if_accomplish_today' => $if_accomplish_today,
            'cards_num' => $cards_num,
            'ban_list' => $ban_array,
        );
        $this->load->view('word/word_ini',$data);
    }

    /**
     *
     */
    public function text(){

        //检查用户登录状态 0是游客
        $user_id = $this->check_login();

        $word_list = $this->word_model->get_random_word(7);

        //推荐算法

        /*
         * 传给视图的值
         *  浏览器头:MW_title
         *  标题:MW_site_head
         *  副标题:MW_site_subhead
         *  用户id user_id
         *  用户名:user_name
         *
         *  推荐单词列表 对象数组(word_obj)array()
         * */

        $data = array(
            'user_id' => $user_id,
            'now_display' => 0,
            'word_list' => $word_list,
        );

        $this->load->view('word/index',$data);
    }

    /**
     *
     */
    public function random_25(){
        $user_id = $this->check_login();
        $word_list = $this->word_model->get_random_word(25);
        //生成session id

        $data = array(
            'word_list' => $word_list,
        );
        $this->load->view('word/random_25',$data);
    }


    /**
     *
     */
    public function word(){
        $user_id = $this->check_login();

        if(!$user_id){
            return $this->redirect('word/index');
        }

        $word_num = $this->input->post('words_num');

        if(empty($word_num)){
            return $this->redirect('word/index');
        }

        $word_list = $this->word_model->get_words_by_id_array($this->recommend_id_array($user_id,$word_num));

        $ban_list = $this->cache->get($this->user_ban_list_key.$user_id);
        //var_dump($ban_list);
            //exit();
        $ban_array = $this->word_model->get_words_by_id_array(unserialize($ban_list));
        $data = array(
            'user_id'=>$user_id,
            'word_list' => $word_list,
            'ban_list' => $ban_array,
            'word_num' => $word_num,
        );

        $this->load->view('word/word',$data);
    }


/*公有接口*/
/**/


/*异步接口*/
    /**
     * 验证通过后,设置登录cookie后从新加载页面
     * @param string $user_name
     * @param string $password
     */
    public function login(){

        $user_name = $this->input->post('username');
        $password = $this->input->post('password');

        if(empty($user_name) || empty($password)){
            return $this->send_json(false,'请输入用户名和密码');
        }

        //在数据库中查询用户,以后用户多了增加缓存
        $result = $this->user_model->get_login_result($user_name,$password);

        //result 0:用户不存在 1:成功登录 2:密码错误
        if($result === 0) return $this->send_json(false,'用户名不存在');
        if($result === 2) return $this->send_json(false,'密码错误');
        if($result === 1) {
            //设置用户cookie
            $this->set_user_status_cookie($user_name);
            return $this->send_json(true, '登录成功', array('url' => base_url('/word/index')));
        }
    }

    /**
     *
     */
    public function logout(){
        $this->clear_user_status_cookie();
        return $this->send_json(true,'',array('url'=>base_url('word/index')));
    }

    /**
     * @param $user_name
     * @param $password
     */
    public function signup(){

        $password = $this->input->post('password');
        $user_name = $this->input->post('username');

        $name_avaliable = $this->user_model->if_user_avaliable($user_name);

        if(!$name_avaliable){
            return $this->send_json(false,'The username is invalid');
        }
        $this->user_model->add_new_user($user_name,$password);
        return $this->send_json(true,'注册成功');
    }

    public function ban_word(){
    //以后版本检查请求来源

        $user_id = $this->input->post('username');
        $banword_id = $this->input->post('ban_word_id');

    //从用户repertory中去掉该单词的id
        $word_id_list = $this->cache->get($this->user_words_repertory_key.$user_id);       

        if(empty($word_id_list)){
            return $this->send_json(false,'不存在该用户的word_repertory');
        }
        $word_id_array = unserialize($word_id_list);
        $ban_key = array_search(intval($banword_id),$word_id_array);
        array_splice($word_id_array,$ban_key,1);


        $word_id_list = serialize($word_id_array);
        $this->cache->save($this->user_words_repertory_key.$user_id,$word_id_list,$this->cache_expire_time());

    //把ban掉的单词加入banlist中
        $ban_list = $this->cache->get($this->user_ban_list_key.$user_id);
        $ban_array = unserialize($ban_list);
        if(empty($ban_array)){
            $ban_array = array();
        }

        array_push($ban_array,$banword_id);
        $ban_list = serialize($ban_array);
        $this->cache->save($this->user_ban_list_key.$user_id,$ban_list,$this->cache_expire_time());

        return $this->send_json(true,'当前我的词库中剩余:');
    }

    public function add_collection(){
        $user_id = $this->input->post('user_id');

        $collect_list = $this->cache->get($this->user_collect_list_key.$user_id);

        $collect_array = $this->word_model->get_words_by_array(unserialize($collect_list));

        return $this->send_json(true);
    }

    /**
     *返回banlist的html内容
     */
    public function  ban_list_innerhtml(){

        $user_id = $this->input->post('username');

        $ban_list = $this->cache->get($this->user_ban_list_key.$user_id);
        $ban_array = $this->word_model->get_words_by_id_array(unserialize($ban_list));

        $text = '';

        foreach($ban_array as $num => $word){
            $text .= "<tr><td>".$word->Word.
                        "</td><td>".$word->meaning."</td>".
                "<td>".
                "<a style='margin-right:2px' href='#'>撤回</a>".
                "<a style='margin-right:2px' href='#'>有多远滚多远</a>".
                "</td>".
                "</tr>";
        }

        return $this->send_json(true,$text);
    }

    public function withdraw_banlist(){
        $user_id = $this->input->post('username');
    }

    public function toady_accomplish_add_days(){
        $user_id = $this->input->post('username');
        $cards_num_plus = $this->input->post('cards_num');

        if(empty($user_id)){
            exit('用户超时,请重新登陆');
        }

        $user_info_list = $this->cache->get($this->user_info_key.$user_id);
        $user_info_array = unserialize($user_info_list);
        if(empty($user_info_list)){
            $user_info_array = array(
                'days'=>0,
                'cards_num'=>0,
                'last_accomplish_date' => '1970-01-01 00:00:00',
            );
        }

        if(date('Y-m-d') > date('Y-m-d',strtotime($user_info_array['last_accomplish_date']))){

            $user_info_array['last_accomplish_date'] = date('Y-m-d');

            $user_info_array['days'] += 1;
        }

        $user_info_array['cards_num'] += $cards_num_plus;

        $this->cache->save($this->user_info_key.$user_id,serialize($user_info_array),$this->cache_expire_time());
        return $this->send_json(true,$user_info_array['last_accomplish_date']);
    }

/*私有接口*/

    /**
     * 返回该用户的推荐单词列表 从user_id的repertory中选取num个数
     *
     * @param string $user_id 数据库中用户的id
     * @param int $word_repertory 单词所在的词库
     * @param int $num 需要推荐的单词数量
     * @return array 单词id
     */
    private function recommend_id_array($user_id,$num,$word_package = 1){

        $word_id_list = $this->cache->get($this->user_words_repertory_key.$user_id);

        //如果没有推荐过,初始化用户单词库cache,推荐该用户的所有单词的id都在这里面
        if(empty($word_id_list)){

            $word_id_array = range(0,$this->ALL_WORDS_NUM-1);
            shuffle($word_id_array);

            $word_id_list = serialize($word_id_array);

            $this->cache->save($this->user_words_repertory_key.$user_id,$word_id_list);
        }

        $wordtest = $this->cache->get($this->user_words_repertory_key.$user_id);

        $word_id_array = unserialize($word_id_list);

        shuffle($word_id_array);

        $recommend_id_array = array_slice($word_id_array,0,$num);

        return $recommend_id_array;
    }



    /**
     * 读取cookie信息,返回用户的user_id或false(无cookie)
     * @return mixed bool | string
     */
    private function check_login(){
        //验证cookie,成功后返回id
        $check_key = '';
        $cookie_user = '';

        if(empty($_COOKIE[$this->user_status_cookie_key]) || empty($_COOKIE[$this->user_cookie_name])){
            return false;
        }

        $check_key = $_COOKIE[$this->user_status_cookie_key];
        $cookie_user = $_COOKIE[$this->user_cookie_name];

        $de_check_key = strtotime($this->deCode($check_key));

        if(!empty($de_check_key) && !empty($cookie_user) && strtotime(date('Y-m-d')) - $de_check_key  < $this->cookie_expire_time() ){
            return $cookie_user;
        }
        return false;
    }

    /**
     * 返回用户上一次残留的学习记录,如果上次学习完了,返回false
     * @param string $user
     * @return bool| array
     */
    private function get_last_word_list($user_id){
        $last_list = $this->cache->get($this->user_study_history_list_key);
        if(empty($last_list)){
            return false;
        }
        return json_decode($last_list);
    }

    /**
     *  以 json 的形式输出结果
     * @param string $success
     * @param string $msg
     * @param array $data
     * @param int $code 错误码(需要用到成功失败处的其它码时需要定义)
     */
    protected function send_json($success = true, $msg = '', $data = array(), $code = 1) {
        $code = $success === true ? 0 : $code;
        $json_arr = array(
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        );

        $this->output->set_content_type('application/json')->set_output(json_encode($json_arr));
    }

    /**
     * @param $user_name
     */
    private function set_user_status_cookie($user_name){
        setcookie($this->user_cookie_name,$user_name,time()+$this->cookie_expire_time(),'/','',false,true);
        setcookie($this->user_status_cookie_key,$this->enCode(date('Y-m-d')),time()+$this->cookie_expire_time(),'/','',false,true);
    }

    /**
     *
     */
    private function clear_user_status_cookie(){
        setcookie($this->user_cookie_name,'',time()-1,'/','',false,true);
        setcookie($this->user_status_cookie_key,$this->enCode(date('Y-m-d')),time()-1,'/','',false,true);

    }

    //不需要安全检查
    /**
     * @return bool
     */
    private function get_user_name_cookie(){
        if(!empty($_COOKIE[$this->user_cookie_name])){
            return false;
        }
        return $_COOKIE[$this->user_cookie_name];
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

    /**
     * 通用解密
     * @param String $string 需要解密的字串
     * @param String $skey 解密KEY
     * @return String
     */
    private function deCode($string = '', $skey = 'fb') {
        $skey = array_reverse(str_split($skey));
        $strArr = str_split(str_replace('O0O0O', '=', $string), 2);
        $strCount = count($strArr);
        foreach ($skey as $key => $value) {
            $key < $strCount && $strArr[$key] = rtrim($strArr[$key], $value);
        }
        return base64_decode(join('', $strArr));
    }


    /**
     * 跳转页面
     * @param string $uri
     * @param string $method
     * @param int $http_response_code
     */
    private function redirect($uri = '', $method = 'location', $http_response_code = 302)
    {
        if ( ! preg_match('#^https?://#i', $uri))
        {
            $uri = site_url($uri);
        }

        switch($method)
        {
            case 'refresh'	: header("Refresh:0;url=".$uri);
                break;
            default			: header("Location: ".$uri, TRUE, $http_response_code);
                break;
        }
        exit;
    }

    private function replace_backspace($str){
        return str_replace('/r/n','<br>',$str);
    }

/* 测试方法 */
    /**
     *
     */
    public function test($user_id)
    {
//        echo strtotime('2016-08-06')-strtotime('2016-08-05');
//        echo 3600*24;
//        var_dump(strtotime('sdfafsda'));

       // var_dump($this->user_model->if_user_avaliable('zhengxiangyue'));

//        $this->user_model->add_new_user('zhuxinqian','jiaduobao');
//        $RESULT_LIST = $this->word_model->get_random_word(15);
//
//        foreach($result_list as $num => $word){
//            foreach($word as $field => $value){
//                var_dump($word);
//                echo "<br>";
//            }
//            echo "<br>";
//        }
//        $this->cache->save('test_redis','123');
//        echo $this->cache->get('test_redis');
//        $word_list = $this->word_model->get_random_word(3);
//        $json_list = json_encode($word_list);
//        var_dump($json_list);
//
//        $this->cache->save('haha',$json_list);
//        $list =  $this->cache->get('haha');
//        var_dump(json_decode($list));
//        $user = $this->cache->get('llg');
//        var_dump($user);
//        if(strtotime(date('Y-m-d h:i:s')) > strtotime('2016-03-31 23:59:59')) {
//           $this->_send_amount($user->wx_user_open_id, $mobi, $user->user_id);
//            echo "ok";
//        }
//        else{
//            echo "not ok";
//        }
//        $arr = array('haha','xixi','hehe');
//        $text = serialize($arr);
//        var_dump($text);
//        $arr = array();
//            array_push($arr,'active','12');
//        var_dump($arr);

//        $begin = 0;
//        $end = 15000;
//        $num = 12;
//
//        $range = range($begin,$end);
//
//        shuffle($range);
//
//        $result = array_slice($range,0,$num);
//        var_dump($result);
        //如果没有推荐过,初始化用户单词库cache,推荐该用户的所有单词的id都在这里面
//        $word_id_list = $this->cache->get($this->user_words_repertory_key.'test2');
        //var_dump(unserialize($this->cache->get($this->user_words_repertory_key.'testca')));
 //       $this->recommend_id_array('test2',14);

        //var_dump(unserialize($this->cache->get($this->user_words_repertory_key.$user_id)));
        //var_dump(unserialize($this->cache->get($this->user_ban_list_key.$user_id)));
        $num = '100*50';
        echo (int)$num;
    }

    public function show_ban_list($user){
        //var_dump( $this->recommend_id_array('zhengxiangyue',14));
        $ban_list = $this->cache->get($this->user_ban_list_key.$user);
        var_dump(unserialize($ban_list));
    }

    public function show_repertory_list($user){
        var_dump(unserialize($this->cache->get($this->user_words_repertory_key.$user)));

    }

    public function test2($user){
        //var_dump( $this->recommend_id_array('zhengxiangyue',14));
        $ban_list = $this->cache->get($this->user_ban_list_key.$user);
        var_dump(unserialize($ban_list));
    }

    public function clear_cache($user){
        $this->cache->delete($this->user_ban_list_key.$user);
        var_dump($this->user_ban_list_key.$user);
    }
}

/*对象*/

/**
 * Class word_obj
 */
class word_obj {
    /**
     * @var
     */
    public $word;
    /**
     * @var
     */
    public $meaning;

    //上次背该单词时间
    /**
     * @var
     */
    public $last_see_time;

    //强调次数
    /**
     * @var
     */
    public $iterate_time;

}

/**
 * Class recomend
 */
class recomend {
    /**
     * @var
     */
    private $user_name;
    /**
     * @var
     */
    private $word_array;

    //单词推荐指数
    /**
     * @var string
     */
    private $recomend_index_key = 'RECOMEND_INDEX_'; //RECOMEND_INDEX_<USER_NAME>_<WORD>

}