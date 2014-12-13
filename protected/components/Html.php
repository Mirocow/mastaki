<?php

class Html {
    public static function getProblemStatus($status)
    {
        switch($status)
        {
            case 'PENDING': return '<span class="text-info"><i class="fa fa-clock-o"></i>&nbsp;В обработке</span>'; break;
            case 'REPAIRING': return '<span class="text-warning"><i class="fa fa-gear fa-spin"></i>&nbsp;В ремонте</span>'; break;
            case 'READY': return '<span class="text-success"><i class="fa fa-check"></i>&nbsp;Готово</span>'; break;
            case 'CANCELED': return '<span class="text-danger"><i class="fa fa-times"></i>&nbsp;Отменено</span>'; break;
            case 'NO_REPAIRS': return '<span class="text-success"><i class="fa fa-thumbs-o-up"></i>&nbsp;Без ремонта</span>'; break;
            case 'AWAITING_PART': return '<span class="text-muted"><i class="fa fa-refresh fa-spin"></i>&nbsp;Ожидание запчасти</span>'; break;
            case 'DIAGNOSTICS': return '<span class="text-info"><i class="fa fa-search"></i>&nbsp;На диагностике</span>'; break;
            case 'DISCUSS': return '<span class="text-info"><i class="fa fa-phone"></i>&nbsp;На обсуждении</span>'; break;
            default: return $status;
        }
    }
    public static function getOrderStatus($status)
    {
        switch($status)
        {
            case 'PENDING': return '<span class="text-info"><i class="fa fa-clock-o"></i>&nbsp;В обработке</span>'; break;
            case 'REPAIRING': return '<span class="text-warning"><i class="fa fa-gear fa-spin"></i>&nbsp;В ремонте</span>'; break;
            case 'READY': return '<span class="text-success"><i class="fa fa-check"></i>&nbsp;Готово</span>'; break;
            case 'CANCELED': return '<span class="text-danger"><i class="fa fa-times"></i>&nbsp;Отменено</span>'; break;
            default: return $status;
        }
    }
    public static function getMastakStatus($status)
    {
        switch($status)
        {
            case 'NOT_VERIFIED': return '<span class="text-muted">&nbsp;Не проверен</span>'; break;
            case 'SUCCESS': return '<span class="text-success"><i class="fa fa-check"></i>&nbsp;Подходит</span>'; break;
            case 'DENIED': return '<span class="text-danger">&nbsp;Не подходит</span>'; break;
            case 'WORKING': return '<span class="text-warning"><i class="fa fa-gear fa-spin"></i>&nbsp;Работает</span>'; break;
            default: return $status;
        }
    }
    public static function pageEditButton($id)
    {
        return CHtml::link('Изменить', array('/admin/page', 'id' => $id), array('class' => 'btn btn-primary pull-right'));
    }
    public static function formatDateTime($date)
    {
        $monthNames = [ 1 => "янв.", "фев.", "мар.", "апр.", "мая", "июн.", "июл.", "авг.", "сен.", "окт.", "ноя.", "дек." ];
        return $date->format('d').' '.$monthNames[$date->format('m')].' '.$date->format('G').'ч.';
    }
}