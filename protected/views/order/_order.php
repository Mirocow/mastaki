<?php
/* @var $data FixOrder */
//CVarDumper::dump($data->orderProblems, 100, true);

$firstRow = true;
$totalPrice = 0;
$discount = 0;
$freeMastaks = CHtml::listData(Mastak::model()->findAllByAttributes(array('status' => 'WORKING')), 'id', 'name');
array_unshift($freeMastaks, '--Выберите исполнителя--');
?>

<table class="table order-details-table" order-id="<?=$data->id;?>">
    <tr>
        <td colspan="2">Клиент: <?=$data->user->id.'  '.$data->user->name;?></td>
        <td colspan="2"><?=$data->to;?></td>
        <td colspan="4"><?=CHtml::dropDownList('mastak_id', $data->mastak_id, $freeMastaks, array('id' => 'mastak-id', 'class' => 'form-control'));?></td>
    </tr>
    <?php if($firstRow) {
        $firstRow = false;
        ?>
    <tr>
        <td rowspan="<?=(count($data->orderProblems)+1)?>" class="main-td">
            <p>#<?=$data->id;?></p>
            <p><?=$data->created;?></p>
        </td>
    </tr>
    <? } ?>
    <?php
        $counter = 1;
        foreach($data->orderProblems as $orderProblem)
        {
    ?>
    <tr class="problem-row" order-problem-id="<?=$orderProblem->id;?>">
        <td>
            <?=$counter;?>
        </td>
        <td>
            <?=$orderProblem->deviceProblem->device->name;?>
        </td>
        <td>
            <?=$orderProblem->deviceProblem->problem->name;?>
        </td>
        <td>
            <?=$orderProblem->deviceProblem->getTotalPrice();?>
        </td>
        <td class="col-md-1">
            <div class="input-group input-group-sm">
                <input type="text" class="form-control discount" size="2" value="<?=$orderProblem->discount;?>"/>
                <span class="input-group-addon">%</span>
            </div>
        </td>
        <td>
            <?php
                echo CHtml::dropDownList('problemStatus', $orderProblem->status, Core::problemStatuses(), array('class' => 'form-control input-sm problem-status-select','order-problem-id' => $orderProblem->id));
            ?>
        </td>
        <td>
            <i class="fa fa-close text-danger delete-order-problem" order-problem-id="<?=$orderProblem->id;?>"></i>
        </td>
    </tr>
    <?php
            $counter++;
        }
    ?>
    <tr>
        <td>
            <a href="#" class="btn btn-default save-order" order-id="<?=$data->id;?>" disabled="disabled">Сохранить</a>
        </td>
        <td colspan="3">
            <strong>Итого по всем работам со скидкой:</strong>
        </td>
        <td>
            <span class="price"><?=$data->getTotalPrice();?></span>р.
        </td>
        <td class="col-md-1">
            <span class="total-discount"><?=$data->getTotalDiscount();?></span> %
        </td>
        <td colspan="2">
            <?php
            echo CHtml::dropDownList('orderStatus', $data->status, Core::orderStatuses(), array('class' => 'form-control input-sm order-status-select', 'order-id' => $data->id));
            ?>
        </td>
    </tr>
</table>