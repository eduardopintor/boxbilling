<?php
/**
 * BoxBilling
 *
 * @copyright BoxBilling, Inc (http://www.boxbilling.com)
 * @license   Apache-2.0
 *
 * Copyright BoxBilling, Inc
 * This source file is subject to the Apache-2.0 License that is bundled
 * with this source code in the file LICENSE
 */


class Box_Validate
{

    protected $di = null;

    /**
     * @param null $di
     */
    public function setDi($di)
    {
        $this->di = $di;
    }

    /**
     * @return null
     */
    public function getDi()
    {
        return $this->di;
    }


    public function isSldValid($sld)
    {
        // allow punnycode
        if(substr($sld, 0, 4) == 'xn--') {
            return true;
        }

        if(preg_match('/^[a-z0-9]+[a-z0-9\-]*[a-z0-9]+$/i', $sld) && strlen($sld) < 64 && substr($sld, 2, 2) != '--') {
            return true;
        } else {
            return false;
        }
    }

    public function isEmailValid($email, $throw = true)
    {
        $valid = (preg_match("/[-a-zA-Z0-9_.+]+@[a-zA-Z0-9-]{2,}\.[a-zA-Z]{2,}/", $email) > 0) ? true : false;
        if(!$valid && $throw) {
            throw new \Box_Exception('Email is not valid');
        }
        return $valid;
    }
    
    public function isPasswordStrong($pwd)
    {
        if( strlen($pwd) < 7 ) {
            throw new \Box_Exception("Password too short!");
        }

        if( !preg_match("#[0-9]+#", $pwd) ) {
            throw new \Box_Exception("Password must include at least one number!");
        }

        if( !preg_match("#[a-z]+#", $pwd) ) {
            throw new \Box_Exception("Password must include at least one letter!");
        }

        /*
        if( !preg_match("#[A-Z]+#", $pwd) ) {
            throw new \Box_Exception("Password must include at least one CAPS!");
        }

        if( !preg_match("#\W+#", $pwd) ) {
            throw new \Box_Exception("Password must include at least one symbol!");
        }
        */
        return true;
    }

    public function checkRequiredParamsForArray($required, $data)
    {
        foreach ($required as $key => $msg) {
            if (!isset($data[$key]) || empty($data[$key])) {
                throw new \Box_Exception($msg);
            }
        }
    }
}
