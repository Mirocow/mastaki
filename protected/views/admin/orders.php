<?php
    $cs = Yii::app()->clientScript;
    $cs->registerScriptFile(Yii::app()->baseUrl.'/js/order.js');
?>
<div class="col-md-12">
    <div class="col-md-3">
        <input type="text" placeholder="Фильтр" class="form-control" id="orders-filter"/>
    </div>
    <div class="col-md-3">
        <button class="btn btn-default" id="do-filter"><i class="fa fa-filter"></i> Фильтр</button>
    </div>
    <div class="col-md-3">
        <?php
            $statuses['ALL'] = 'Все';
            foreach(Core::orderStatuses() as $key=>$value)
                $statuses[$key] = $value;

            echo CHtml::dropDownList('status', 'ALL', $statuses, array('id' => 'select-orders-status', 'class' => 'form-control'));
        ?>
    </div>
    <div class="col-md-3 badges">
        <!--<div class="col-md-12"><a class="btn btn-primary"  href="#">Все <span class="badge">12</span></a></div>-->
        <?php
            foreach(Core::orderStatuses() as $status=>$col)
            {
                echo '<div class="col-md-6"><button disabled class="btn btn-primary col-md-12" href="#">'.$col.' <span class="badge">'.$counters[$status].'</span></button></div>';
            }
        ?>
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
