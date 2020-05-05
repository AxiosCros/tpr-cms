<?php

declare (strict_types = 1);

namespace admin\common;

use Minphp\Session\Session;
use tpr\Container;
use tpr\Path;

class User
{
    /**
     * @var User
     */
    private static $instance;

    private $session;

    public function instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct()
    {
        if (!Container::has('session')) {
            Container::bind('session', new Session());
        }
        $this->session = Container::get('session');
    }

    public function isLogin()
    {
        return !empty($this->getInfo());
    }

    public function getInfo($field = null)
    {
        $user = $this->session->read('user');
        if (null === $field) {
            return $user;
        }
        $data = [];
        if (is_string($field)) {
            if (strpos($field, ',')) {
                $keys = explode(',', $field);
                foreach ($keys as $k) {
                    $data[$k] = data($user, $k);
                }
            } else {
                return data($user, $field);
            }
        } elseif (is_array($field)) {
            foreach ($field as $k) {
                $data[$k] = data($user, $k);
            }
        }
        return $data;
    }

    public function clearInfo()
    {
        $this->session->clear('user');
    }

    public function refreshInfo($user_info)
    {
        $this->session->write('user', $user_info);
    }

    public function getUserAvatar()
    {
        $avatar = $this->getInfo('avatar');
        return !empty($avatar) && file_exists(Path::root() . 'public/' . $avatar) ? $avatar : '/src/images/avatar.png';
    }
}