<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['app']['default_repay'] = '您的输入暂时无法处理。';
$config['app']['default_shortcut_ids'] = '5,6,7,10,11,15';

// redis 配置,支持主从
$config['app']['redis'] = array(
    'master' => array(
        'host' => '127.0.0.1',
        'port' => '6379',
    ),
    'slave' => array(
        array(
            'host' => '127.0.0.1',
            'port' => '6379',
        ),
    ),
    'slave_switch' => false,
);


// 分支简称，多分支唯一,例如: 主干:tk 东莞:dg 杭州:hz 绍兴:sx 金华:jh 4G实验室:lab 北京终端公司:zdgs
$config['app']['branch_uuid'] = 'tk';

//////////////////// 微力自有模块设置 ////////////////
// 短信发送服务提供者 Aspire：卓望的短彩平台
$config['app']['module_sms'] = 'ZXT';
// 对接的 boss 系统 GD : 广东
$config['app']['module_boss'] = 'GD';

// rsa pem文件地址
$config['app']['login_rsa'] = 'rsa_login_pem';
$config['app']['login_captcha_times'] = 3;

// 绑定手机总开关 1: 开 0 关
$config['app']['mobi_bind_switch'] = 1;
//绑定是否限定城市或省份或运营商,(临时放在这里，后续放到后台绑定设置里关联数据库)
$config['app']['mobi_bind_limit_11'] = array('province_code'=>'200', 'company_code'=>'CM');

// 用户参加活动的编号从多少开始起编
$config['app']['user_activity_join_num_start'] = 10000;

// 缓存过期时间设置
$config['app']['cache_status_timeout'] = 86400;
$config['app']['cache_activity_timeout'] = 86400;

// session 配置
$config['app']['session_timeout'] = 1800;

// cookie 配置
// 用户身份识别的cookie,默认保存30天
$config['app']['cookie_auth_timeout'] = 2592000;
// auth在redis中保存的过期时间: 默认保存30天
$config['app']['auth_user_info_expire'] = 2592000;

// ticket有效期设置: 默认365天,单位秒
$config['app']['ticket_expire_time'] = 31536000;



// 图片上传路径
$config['app']['upload_path'] = 'uploads/';
$config['app']['tmp_upload_path'] = 'uploads/tmp/';

// 图片下载路径
$config['app']['download_path'] = 'downloads/';

// 实时消息配置
$config['app']['message_imageurl_prefix'] = '';
$config['app']['message_image_path'] = 'uploads/message/';
$config['app']['message_file_path'] = 'uploads/message/';

// 统计日志相关
// 可用的统计实现类：Mysql_Logger, File_Logger
$config['app']['logger'] = 'Mysql_Logger';
$config['app']['logger_file_path'] ='uploads/';
//BI日志
$config['app']['bi_log_path'] = '../logs';
$config['app']['bi_log_branch'] = 1;//1:trunk; 2:dg 3;杭州 4:台州 5:佛山 6:4G实验室 7:创新联盟
