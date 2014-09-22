<?php

namespace asm\utils;
require_once('PasswordHash.php');

class Security {
    public static $hashtypePhpass = 'phpass';
    public static $hashtypeMd5 = 'md5';
    /**
     * @param $plainPassword password to hash
     * @param $encryptionType md5 or phpasss
     */
    public static function hash($plainPassword, $encryptionType)
    {
        if ($encryptionType === static::$hashtypeMd5)
        {
            return md5($plainPassword);
        }
        else if ($encryptionType === static::$hashtypePhpass)
        {
            $hasher = new \PasswordHash(8, false);
            return $hasher->HashPassword($plainPassword); // TODO check for errors?
        }
        else
        {
         // TODO deal with this more properly
            die("Assert Error: Unknown Encryption Type");
        }
    }
    public static function check($incomingPassword, $databaseHash, $encryptionType)
    {
        if ($encryptionType === static::$hashtypeMd5)
        {
            return md5($incomingPassword) === $databaseHash;
        }
        else if ($encryptionType === static::$hashtypePhpass)
        {
            $hasher = new \PasswordHash(8, false);
            return $hasher->CheckPassword($incomingPassword, $databaseHash);
        }
        else
        {
            // TODO deal with this more properly
            die("Assert Error: Unknown Encryption Type");
        }
    }
} 