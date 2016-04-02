<?php

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.2.4 or newer
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst.  It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2013, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 3.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Redis Caching Class
 *
 * @package	   CodeIgniter
 * @subpackage Libraries
 * @category   Core
 * @author	   Anton Lindqvist <anton@qvister.se>
 * @link
 */
class CI_Cache_redis extends CI_Driver {

    private $_config = array();
    private $_redis_master;
    private $_redis_slave;

    public function __construct() {
        $CI = &get_instance();
        $this->_config = $CI->config->item('redis', 'app');
    }

    /**
     * 获取主客户端
     * @return type
     */
    public function master() {
        return $this->_get_client(true);
    }

    public function slave() {
        return $this->_get_client(false);
    }

    /**
     * 取得可用客户端，没有则建立连接，支持主从
     * @param type $master
     * @return type
     */
    private function _get_client($master = true) {
        // 如果主从关闭，则强制主
        $switch = $this->_config['slave_switch'];
        if ($switch == false) {
            $master = true;
        }

        $config = array();
        if ($master === true) {
            if ($this->_redis_master) {
                return $this->_redis_master;
            }
            $config = $this->_config['master'];
        } else {
            if ($this->_redis_slave) {
                return $this->_redis_slave;
            }
            $config = $this->_config['slave'][mt_rand(0, (count($this->_config['slave'])) - 1)];
        }

        // 建立连接
        $redis = new Redis();
        try {
            $timeout = isset($config['timeout']) ? $config['timeout'] : 3;
            $redis->connect($config['host'], $config['port'], $timeout);
        } catch (RedisException $e) {
            show_error('Redis connection refused. ' . $e->getMessage());
        }

        if (isset($config['password']) && !empty($config['password'])) {
            $redis->auth($config['password']);
        }

        if ($master === true) {
            $this->_redis_master = $redis;
        } else {
            $this->_redis_slave = $redis;
        }

        return $redis;
    }

    /**
     * Get cache
     *
     * @param	string	Cache key identifier
     * @return	mixed
     */
    public function get($key) {
        return $this->slave()->get($key);
    }

    /**
     * Save cache
     *
     * @param	string	Cache key identifier
     * @param	mixed	Data to save
     * @param	int	Time to live
     * @return	bool
     */
    public function save($key, $value, $ttl = NULL) {
        // 写完后主动读取一次，以避免主服务不能及时同步的问题
        $result = ($ttl) ? $this->master()->setex($key, $ttl, $value) : $this->master()->set($key, $value);
        $this->get($key);
        return $result;
    }

    /**
     * Delete from cache
     *
     * @param	string	Cache key
     * @return	bool
     */
    public function delete($key) {
        return ($this->master()->delete($key) === 1);
    }

    /**
     * 自增加1
     * @param type $key
     * @return type
     */
    public function incr($key) {
        return $this->master()->incr($key);
    }

    public function incr_by($key, $num) {
        return $this->master()->incrBy($key, $num);
    }

    /**
     * Clean cache
     *
     * @return	bool
     * @see		Redis::flushDB()
     */
    public function clean() {
        return $this->master()->flushDB();
    }

    /**
     * Get cache driver info
     *
     * @param	string	Not supported in Redis.
     * 			Only included in order to offer a
     * 			consistent cache API.
     * @return	array
     * @see		Redis::info()
     */
    public function cache_info($type = NULL) {
        return $this->master()->info();
    }

    /**
     * Get cache metadata
     *
     * @param	string	Cache key
     * @return	array
     */
    public function get_metadata($key) {
        $value = $this->get($key);

        if ($value) {
            return array(
                'expire' => time() + $this->slave()->ttl($key),
                'data' => $value
            );
        }

        return FALSE;
    }

    /**
     * Check if Redis driver is supported
     *
     * @return	bool
     */
    public function is_supported() {
        if (extension_loaded('redis')) {
            return TRUE;
        } else {
            log_message('debug', 'The Redis extension must be loaded to use Redis cache.');
            return FALSE;
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    // Hash 数据结果相关

    /**
     * Hash支持
     */
    public function hget($key, $fields) {
        return $this->slave()->hGet($key, $fields);
    }

    public function hset($key, $fields, $value) {
        return $this->master()->hSet($key, $fields, $value);
    }
    
    public function hgetall($key) {
        return $this->master()->hGetAll($key);
    }

    /**
     * 批量Get
     * @param type $key
     * @param type $fields array('field1', 'field2);
     * @return type
     */
    public function hmget($key, $fields) {
        return $this->slave()->hMGet($key, $fields);
    }

    /**
     * 批量Set
     * @param type $key
     * @param type $fields_value_arr array('key' => 'value', 'key2' => 'value2');
     */
    public function hmset($key, $fields_value_arr) {
        return $this->master()->hMSet($key, $fields_value_arr);
    }

    public function hdel($key, $fields) {
        return $this->master()->hDel($key, $fields);
    }

    public function hlen($key) {
        return $this->slave()->hLen($key);
    }

    public function hexist($key, $fields) {
        return $this->slave()->hExists($key, $fields);
    }

    /**
     * List支持，详细说明可参看官方文档https://github.com/nicolasff/phpredis#blpop-brpop
     */
    public function lpop($key) {
        return $this->master()->lPop($key);
    }

    public function lpush($key, $value) {
        return $this->master()->lPush($key, $value);
    }

    public function rpop($key) {
        return $this->master()->rPop($key);
    }

    public function rpush($key, $value) {
        return $this->master()->rPush($key, $value);
    }

    public function llen($key) {
        return $this->master()->lLen($key);
    }
    
    /**
     * 删除 队列中的某个值
     */
    public function lrem($key,$value,$count = 1) {
        return $this->master()->lRem($key, $value, $count);
    }

    public function scard($key){
        return $this->master()->scard($key);
    }
    
    ////////////////////////////////////////////////////////////////////////////
    /**
     * 其它通用操作
     */
    
    /**
     * Set the string value in argument as value of the key if the key doesn't already exist in the database.
     * @param type $key
     * @param type $value
     * @return Bool TRUE in case of success, FALSE in case of failure.
     */
    public function setnx($key, $value, $ttl = 0) {
        $result = $this->master()->setnx($key, $value);
        if($ttl > 0) {
            $this->master()->expire($key, $ttl);
        }
        return $result;
    }

    /**
     *  Set the string value in argument as value of the key, with a time to live
     * @param type $key
     * @param type $value
     * @param type $ttl
     * @return Bool TRUE if the command is successful.
     */
    public function setex($key, $value, $ttl) {
        return $this->master()->setex($key, $ttl, $value);
    }
    /**
     * 设置过期时间
     * @param unknown $key
     * @param unknown $ttl
     */
    public function expire($key,$ttl) {
        return $this->master()->expire($key,$ttl);
    
    }

    /**
     * Sets a value and returns the previous entry at that key.
     * @param type $key
     * @param type $value
     * @return type
     * @return A string, the previous value located at this key
     */
    public function getset($key, $value) {
        return $this->master()->getSet($key, $value);
    }

    /**
     * Verify if the specified key exists.
     * @param string $key
     * @return bool If the key exists, return TRUE, otherwise return FALSE.
     */
    public function exists($key) {
        return $this->master()->exists($key);
    }

    /** reidis sets
     * @param $key
     * @param $value
     * @return bool
     */
    public function sadd($key,$value) {
        if(empty($key) || empty($value)) {
            return false;
        }
        return $this->master()->sAdd($key,$value);
    }

    /** sets sismember
     * @param $key
     * @param $value
     * @return bool
     */
    public function sismember($key,$value) {
        if(empty($key) || empty($value)) {
            return false;
        }
        return $this->slave()->sIsMember($key,$value);
    }

    /** 删除集合指定元素
     * @param $key
     * @param $value
     * @return bool
     */
    public function srem($key,$value) {
        if(empty($key) || empty($value))
            return false;
        return $this->master()->sRem($key,$value);
    }

    /** 有序集合
     * @param $key
     * @param $member
     * @param int $score
     * @param int $expire
     * @return bool
     */
    public function zincrby($key, $member, $score = 1, $expire = 0) {
        if(empty($key) || empty($member)) {
            return false;
        }
        $result = $this->master()->zIncrBy($key,$score,$member);
        if($expire && $result) {
            $this->master()->expire($key,$expire);
        }
        return $result;
    }

    public function zrevrank($key, $member) {
        if(empty($key) || empty($member)) {
            return false;
        }
        return $this->slave()->zRevRank($key,$member);
    }

    public function zadd($key, $member, $score = 1, $expire = 0) {
        if(empty($key) || empty($member)) {
            return false;
        }
        $result = $this->master()->zAdd($key,$score,$member);
        if($expire && $result) {
            $this->master()->expire($key,$expire);
        }
        return $result;
    }

    public function zrank($key, $member) {
        if(empty($key) || empty($member)) {
            return false;
        }
        return $this->master()->zRank($key,$member);
    }

    public function zrange($key,$start=0,$stop=10,$bool=false) {
        if(empty($key)) {
            return false;
        }
        return $this->master()->zRange($key,$start,$stop,$bool);
    }

    public function zscore($key,$member) {
        if(empty($key) || empty($member)) {
            return false;
        }
        return $this->master()->zScore($key,$member);
    }
    
    
    /**
     * 模糊匹配关键词
     */
    public function keys($match){
        return $this->master()->keys($match);
    }

    public function __destruct() {
        if ($this->_redis_master) {
            $this->_redis_master->close();
        }
        if ($this->_redis_slave) {
            $this->_redis_slave->close();
        }
    }

}

/* End of file Cache_redis.php */
/* Location: ./system/libraries/Cache/drivers/Cache_redis.php */