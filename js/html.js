function getOrderStatus(status)
{
    switch (status) {
        case 'PENDING': return '<span class="text-info"><i class="fa fa-clock-o"></i>&nbsp;В обработке</span>'; break;
        case 'REPAIRING': return '<span class="text-warning"><i class="fa fa-gear fa-spin"></i>&nbsp;В ремонте</span>'; break;
        case 'READY': return '<span class="text-success"><i class="fa fa-check"></i>&nbsp;Готово</span>'; break;
        case 'CANCELED': return '<span class="text-danger"><i class="fa fa-times"></i>&nbsp;Отменено</span>'; break;
        default: return status;
    }
}