<?php

class Html {
    public static function getProblemStatus($status)
    {
        switch($status)
        {
            case 'PENDING': return '<span class="text-info"><i class="fa fa-clock-o"></i>&nbsp;На согласовании</span>'; break;
            default: return $status;
        }
    }
    public static function getOrderStatus($status)
    {
        switch($status)
        {
            case 'PENDING': return '<span class="text-info"><i class="fa fa-clock-o"></i>&nbsp;На согласовании</span>'; break;
            default: return $status;
        }
    }
}