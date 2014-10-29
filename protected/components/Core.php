<?php
class Core
{
    public static function generatePassword($length = 6)
    {
        $chars = "qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";

        $size = strlen($chars)-1;

        $password = '';

        while($length--)
            $password .= $chars[rand(0,$size)];

        return $password;
    }

    public static function now($type = 'sql')
    {
        $time = new DateTime();

        switch($type)
        {
            case 'sql': return $time->format('Y-m-d');
            default: return $time->format('d.m.Y');
        }
    }
}