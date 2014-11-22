<table class="table table-striped">
    <tr>
        <th>№</th><th>Имя</th><th>Аппарат</th><th>Статус</th>
    </tr>
    <?php
        foreach($orders as $order)
        {
            echo '<tr class="order-short"><td>'.$order->id.'</td><td>'.$order->user->name.'</td><td>'.$order->getDeviceName().'</td><td>'.Html::getOrderStatus($order->status).'</td></tr>';
        }
    ?>
</table>