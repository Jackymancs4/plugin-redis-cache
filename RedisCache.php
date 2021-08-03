<?php

namespace Kanboard\Plugin\RedisCache;

use Kanboard\Core\Cache\BaseCache;
use Kanboard\Core\Cache\CacheInterface;
use Kanboard\Core\Tool;
use LogicException;
use Redis;

/**
 * Class FileCache
 *
 * @package Kanboard\Core\Cache
 */
class RedisCache extends BaseCache
{

    private Redis $redis;

    private bool $is_connected;

    private string $prefix;

    private string $divider = ':';

    /**
     * Undocumented function
     *
     * @param string $address
     * @param int $port
     * @param string $username
     * @param string $password
     * @param int $database
     * @param string $prefix
     */
    public function __construct($address, $port, $username, $password, $database, $prefix)
    {
        $this->redis = new Redis();
        $this->is_connected = $this->redis->connect($address, $port);

        if ($password != null) {
            if ($username != null) {
                $this->is_connected = $this->redis->auth(['user' => $username, 'pass' => $password]);
            } else {
                $this->is_connected = $this->redis->auth(['pass' => $password]);
            }
        }

        if ($database != null) {
            $this->redis->select($database);
        }

        $this->setPrefix($prefix);
        $this->redis->setOption(Redis::OPT_PREFIX, $this->getPrefix());
    }

    public function getPrefix()
    {
        if ($this->prefix != null && $this->prefix != "") {
            $trailingChar = substr($this->prefix, -1);

            if ($trailingChar == $this->divider) {
                return $this->prefix;
            } else {
                return $this->prefix . $this->divider;
            }
        } else {
            return "kanboard:";
        }
    }

    public function setPrefix($string)
    {
        if ($string != null && $string != "") {
            $trailingChar = substr($string, -1);

            if ($trailingChar == $this->divider) {
                $this->prefix = $string;
            } else {
                $this->prefix = $string . $this->divider;
            }
        } else {
            $this->prefix =  "kanboard:";
        }
    }

    /**
     * Retrieve an item from the cache by key
     *
     * @access public
     * @param  string $key
     * @return mixed            Null when not found, cached value otherwise
     */
    public function get($key)
    {

        $keyname = $this->getFilenameFromKey($key);
        $value = $this->redis->get($keyname);

        if ($value) {
            return unserialize($value);
        }

        return null;
    }

    /**
     * Store an item in the cache
     *
     * @access public
     * @param  string $key
     * @param  mixed  $value
     */
    public function set($key, $value)
    {
        $this->redis->set($this->getFilenameFromKey($key), serialize($value));
    }

    /**
     * Remove all items from the cache
     *
     * @access public
     */
    public function flush()
    {
        $this->redis->flushDb();
    }

    /**
     * Remove an item from the cache
     *
     * @access public
     * @param  string $key
     */
    public function remove($key)
    {
        $this->redis->del($this->getFilenameFromKey($key));
    }

    /**
     * Get absolute filename from the key
     *
     * @access protected
     * @param  string $key
     * @return string
     */
    protected function getFilenameFromKey($key)
    {
        return $key;
    }

    /**
     * Create cache folder if missing
     *
     * @access protected
     */
    protected function isConnected()
    {
        return $this->is_connected;
    }
}
