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

    public static function problemStatuses()
    {
        return array(
            'DISCUSS' => 'На согласовании',
            'DIAGNOSTICS' => 'Диагностика',
            'PENDING' => 'В обработке',
            'AWAITING_PART' => 'Ожидание запчасти',
            'REPAIRING' => 'В ремонте',
            'READY' => 'Готово',
            'NO_REPAIRS' => 'Без ремонта',
            'CANCELED' => 'Отменено',
        );
    }
    public static function orderStatuses()
    {
        return array(
            'PENDING' => 'В обработке',
            'REPAIRING' => 'В ремонте',
            'READY' => 'Готово',
            'CANCELED' => 'Отменено',
        );
    }
    public static function mastakStatuses()
    {
        return array(
            'NOT_VERIFIED' => 'Не проверен',
            'VERIFIED' => 'Проверен',
            'SUCCESS' => 'Подходит',
            'DENIED' => 'Не подходит',
            'WORKING' => 'Работает',
        );
    }
}