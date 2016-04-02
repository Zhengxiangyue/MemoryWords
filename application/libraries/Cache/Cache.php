<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2006 - 2012 EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 2.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * CodeIgniter Caching Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Core
 * @author		ExpressionEngine Dev Team
 * @link
 */
class CI_Cache extends CI_Driver_Library {

    protected $valid_drivers = array(
        'cache_apc', 'cache_file', 'cache_memcached', 'cache_dummy', 'cache_redis'
    );
    protected $_cache_path = NULL;  // Path of cache files (if file-based cache)
    protected $_adapter = 'dummy';
    protected $_backup_driver;

    // ------------------------------------------------------------------------

    /**
     * Constructor
     *
     * @param array
     */
    public function __construct($config = array()) {
        if (!empty($config)) {
            $this->_initialize($config);
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Get
     *
     * Look for a value in the cache.  If it exists, return the data
     * if not, return FALSE
     *
     * @param 	string
     * @return 	mixed		value that is stored/FALSE on failure
     */
    public function get($id) {
        return $this->{$this->_adapter}->get($id);
    }

    // ------------------------------------------------------------------------

    /**
     * Cache Save
     *
     * @param 	string		Unique Key
     * @param 	mixed		Data to store
     * @param 	int			Length of time (in seconds) to cache the data
     *
     * @return 	boolean		true on success/false on failure
     */
    public function save($id, $data, $ttl = 60) {
        return $this->{$this->_adapter}->save($id, $data, $ttl);
    }

    // ------------------------------------------------------------------------

    /**
     * Delete from Cache
     *
     * @param 	mixed		unique identifier of the item in the cache
     * @return 	boolean		true on success/false on failure
     */
    public function delete($id) {
        return $this->{$this->_adapter}->delete($id);
    }

    /**
     * 自增加1
     * @param type $key
     * @return type
     */
    public function incr($key) {
        return $this->{$this->_adapter}->incr($key);
    }

    public function incr_by($key, $num) {
        return $this->{$this->_adapter}->incr_by($key, $num);
    }

    // ------------------------------------------------------------------------

    /**
     * Clean the cache
     *
     * @return 	boolean		false on failure/true on success
     */
    public function clean() {
        return $this->{$this->_adapter}->clean();
    }

    // ------------------------------------------------------------------------

    /**
     * Cache Info
     *
     * @param 	string		user/filehits
     * @return 	mixed		array on success, false on failure
     */
    public function cache_info($type = 'user') {
        return $this->{$this->_adapter}->cache_info($type);
    }

    // ------------------------------------------------------------------------

    /**
     * Get Cache Metadata
     *
     * @param 	mixed		key to get cache metadata on
     * @return 	mixed		return value from child method
     */
    public function get_metadata($id) {
        return $this->{$this->_adapter}->get_metadata($id);
    }

    // ------------------------------------------------------------------------

    /**
     * Initialize
     *
     * Initialize class properties based on the configuration array.
     *
     * @param	array
     * @return 	void
     */
    private function _initialize($config) {
        $default_config = array(
            'adapter',
            'memcached'
        );

        foreach ($default_config as $key) {
            if (isset($config[$key])) {
                $param = '_' . $key;

                $this->{$param} = $config[$key];
            }
        }

        if (isset($config['backup'])) {
            if (in_array('cache_' . $config['backup'], $this->valid_drivers)) {
                $this->_backup_driver = $config['backup'];
            }
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Is the requested driver supported in this environment?
     *
     * @param 	string	The driver to test.
     * @return 	array
     */
    public function is_supported($driver) {
        static $support = array();

        if (!isset($support[$driver])) {
            $support[$driver] = $this->{$driver}->is_supported();
        }

        return $support[$driver];
    }

    ////////////////////////////////////////////////////////////////////////////
    // Hash 数据结果相关

    /**
     * Hash支持
     */
    public function hget($key, $fields) {
        return $this->{$this->_adapter}->hget($key, $fields);
    }

    public function hset($key, $fields, $value) {
        return $this->{$this->_adapter}->hset($key, $fields, $value);
    }

    public function hgetall($key) {
        return $this->{$this->_adapter}->hgetall($key);
    }

    /**
     * 批量Get
     * @param type $key
     * @param type $fields array('field1', 'field2);
     * @return type
     */
    public function hmget($key, $fields) {
        return $this->{$this->_adapter}->hmget($key, $fields);
    }

    /**
     * 批量Set
     * @param type $key
     * @param type $fields_value_arr array('key' => 'value', 'key2' => 'value2');
     */
    public function hmset($key, $fields_value_arr) {
        return $this->{$this->_adapter}->hmset($key, $fields_value_arr);
    }

    public function hdel($key, $fields) {
        return $this->{$this->_adapter}->hdel($key, $fields);
    }

    public function hlen($key) {
        return $this->{$this->_adapter}->hlen($key);
    }

    public function hexist($key, $fields) {
        return $this->{$this->_adapter}->hexist($key, $fields);
    }

    /**
     * List支持
     */
    public function lpop($key) {
        return $this->{$this->_adapter}->lpop($key);
    }

    public function lpush($key, $value) {
        return $this->{$this->_adapter}->lpush($key, $value);
    }

    public function rpop($key) {
        return $this->{$this->_adapter}->rpop($key);
    }

    public function rpush($key, $value) {
        return $this->{$this->_adapter}->rpush($key, $value);
    }

    public function llen($key) {
        return $this->{$this->_adapter}->llen($key);
    }

    public function lrem($key, $value, $count = 1) {
        return $this->{$this->_adapter}->lrem($key, $value, $count);
    }

    public  function scard($key){
        return $this->{$this->_adapter}->scard($key);
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
        return $this->{$this->_adapter}->setnx($key, $value, $ttl);
    }

    /**
     *
     */
    public function expire($key,$ttl) {
        return $this->{$this->_adapter}->expire($key,$ttl);

    }

    /**
     *  Set the string value in argument as value of the key, with a time to live
     * @param type $key
     * @param type $value
     * @param type $ttl
     * @return Bool TRUE if the command is successful.
     */
    public function setex($key, $value, $ttl) {
        return $this->{$this->_adapter}->setex($key, $ttl, $value);
    }

    /**
     * Sets a value and returns the previous entry at that key.
     * @param type $key
     * @param type $value
     * @return type
     * @return A string, the previous value located at this key
     */
    public function getset($key, $value) {
        return $this->{$this->_adapter}->getSet($key, $value);
    }

    /**
     * Verify if the specified key exists.
     * @param string $key
     * @return bool If the key exists, return TRUE, otherwise return FALSE.
     */
    public function exists($key) {
        return $this->{$this->_adapter}->exists($key);
    }

    /** reidis sets
     * @param $key
     * @param $value
     * @return bool
     */
    public function sadd($key,$value) {
        return $this->{$this->_adapter}->sadd($key,$value);
    }

    /** sets sismember
     * @param $key
     * @param $value
     * @return bool
     */
    public function sismember($key,$value) {
        return $this->{$this->_adapter}->sismember($key,$value);
    }

    /** 删除集合指定元素
     * @param $key
     * @param $value
     * @return bool
     */
    public function srem($key,$value) {
        return $this->{$this->_adapter}->srem($key,$value);
    }

    /** 有序集
     * @param $key
     * @param $member
     * @param int $score
     * @param int $expire
     * @return mixed
     */
    public function zincrby($key, $member, $score = 1, $expire = 0) {
        return $this->{$this->_adapter}->zincrby($key,$member,$score,$expire);
    }

    public function zrevrank($key, $member) {
        return $this->{$this->_adapter}->zrevrank($key,$member);
    }

    public function zadd($key, $member, $score = 1, $expire = 0) {
        return $this->{$this->_adapter}->zadd($key,$member,$score, $expire);
    }

    public function zrank($key, $member) {
        return $this->{$this->_adapter}->zrank($key,$member);
    }

    public function zrange($key,$start=0,$stop=10,$bool=false) {
        return $this->{$this->_adapter}->zrange($key,$start,$stop,$bool);
    }

    public function zscore($key,$member) {
        return $this->{$this->_adapter}->zscore($key,$member);
    }

    /**
     * 模糊匹配关键词
     */
    public function keys($match) {
        return $this->{$this->_adapter}->keys($match);
    }

    // ------------------------------------------------------------------------

    /**
     * __get()
     *
     * @param 	child
     * @return 	object
     */
    public function __get($child) {
        $obj = parent::__get($child);

        if (!$this->is_supported($child)) {
            $this->_adapter = $this->_backup_driver;
        }

        return $obj;
    }

    // ------------------------------------------------------------------------
}

// End Class

/* End of file Cache.php */
/* Location: ./system/libraries/Cache/Cache.php */