<table class="table table-striped">
    <tr>
        <th>№</th><th>Дата</th><th>Статус</th>
    </tr>
    <?php
    foreach($orders as $order)
    {
        echo '<tr class="order-short"><td>'.$order->id.'</td><td>'.$order->created.'</td><td>'.Html::getOrderStatus($order->status).'</td></tr>';
    }
    ?>
</table>