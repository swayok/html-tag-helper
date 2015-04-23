<?php

namespace Swayok\Html;

use Swayok\Utils\Cookie;

class Security {

    const TOKEN = '_token';
    const TIMESTAMP = '_ts';
    const FORM_NAME = '_name';
    static protected $cookieKey = 'SID';

    static public $tokenLifetime = '2 hour';
    static protected $timestamp;

    static public function getTimestamp() {
        if (!isset(self::$timestamp)) {
            self::$timestamp = time();
        }
        return self::$timestamp;
    }

    /**
     * Generate token using $constantValues for more security
     * @param string $formName
     * @param array $constantValues
     * @param string|null $formAction - where form will be submitted
     * @return string
     */
    static public function generateToken($formName, $constantValues, $formAction = null) {
        $ts = self::getTimestamp();
        $rand = mt_rand(0, $ts) . uniqid($ts, true);
        $prefix = '?';
        $suffix = '!';
        if (!empty($constantValues)) {
            $fieldNames = array_keys($constantValues);
            sort($fieldNames);
            $prefix = implode(',', $fieldNames);
            krsort($constantValues);
            $suffix = implode('&', $constantValues);
        }
        Cookie::set(
            '__' . $formName,
            array($rand, $prefix),
            self::$tokenLifetime,
            array('path' => empty($formAction) ? preg_replace('%(?:(\?)|&)_=\d+%is', '$1', $_SERVER['REQUEST_URI']) : $formAction)
        );
        $mid = $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_HOST'] . $_SERVER['HTTP_USER_AGENT'];
        $token = sha1(Cookie::getEncryptionKey() . $prefix . $rand . $mid . $suffix . $ts);
        return $token;
    }

    /**
     * Validate token from incoming data
     * @param array $data - $_POST data
     * @param bool $isAjax - true: cookie won't be deleted
     * @return bool
     */
    static public function validate($data, $isAjax = false) {
        if (empty($data[self::TIMESTAMP]) || empty($data[self::TOKEN]) || empty($data[self::FORM_NAME])) {
            return false;
        }
        $ts = $data[self::TIMESTAMP];
        $token = $data[self::TOKEN];
        $formName = $data[self::FORM_NAME];
        $cookie = Cookie::get('__' . $formName);
        if (!$cookie || !is_array($cookie) || count($cookie) != 2) {
            return false;
        }
        list($rand, $prefix) = $cookie;
        if (!$isAjax) {
            Cookie::delete('__' . $formName);
        }
        if ($prefix !== '?') {
            if (empty($prefix)) {
                return false;
            }
            $fields = explode(',', $prefix);
            if (empty($fields)) {
                return false;
            }
            $constantValues = array();
            foreach ($fields as $field) {
                if (!isset($data[trim($field)])) {
                    return false;
                }
                $constantValues[trim($field)] = $data[trim($field)];
            }
            krsort($constantValues);
            $suffix = implode('&', $constantValues);
        } else {
            $suffix = '!';
        }
        $mid = $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_HOST'] . $_SERVER['HTTP_USER_AGENT'];
        $hash = sha1(Cookie::getEncryptionKey() . $prefix . $rand . $mid . $suffix . $ts);
        return $hash == $token;
    }
}