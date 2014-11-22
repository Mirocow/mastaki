<table class="table table-striped orders-table">
    <tr>
        <th>№</th><th>Дата</th><th>Статус</th><th>Аппарат</th>
    </tr>
    <?php
    foreach($orders as $order)
    {
        echo '<tr><td><a href="'.$this->createUrl('/admin/orders', array('id' => $order->getPrimaryKey())).'" target="_blank"><span class="badge">'.$order->id.'</span></a></td><td>'.$order->created.'</td><td>'.$order->getDeviceName().'</td><td>'.Html::getOrderStatus($order->status).'</td></tr>';
    }
    ?>
</table>