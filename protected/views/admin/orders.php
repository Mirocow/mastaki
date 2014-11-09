<div class="col-md-12">
    <div class="col-md-3">
        <input type="text" placeholder="Фильтр" class="form-control" id="orders-filter"/>
    </div>
    <div class="col-md-3">
        <button class="btn btn-default" id="do-filter"><i class="fa fa-filter"></i> Фильтр</button>
    </div>
</div>
<div class="col-md-12">
    <div class="table-responsive orders-table-container">
        <table class="table">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Имя</td>
                    <td>Статус</td>
                </tr>
            </thead>
            <tbody id="orders-tbody">
                <?php
                    foreach($orders as $order)
                    {
                        echo
                        '<tr order-id="'.$order->id.'" class="order-short">
                            <td>'.$order->id.'</td><td>'.$order->user->name.'</td><td>'.Html::getOrderStatus($order->status).'</td>
                        </tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
<div class="col-md-12">
    <div class="table-responsive order-table-container">
    </div>
</div>
<div class="col-md-12" id="problems-dropdown-container">

</div>
<div class="col-md-12">

</div>
<?php
/*$this->widget('zii.widgets.CListView', array(
    'dataProvider'=> $orders,
    'template' => '{items}',
    'itemView'=>'_order',
    'itemsCssClass' => 'table-responsive'
));*/
?>
