<?php
/* @var $data FixOrder */
//CVarDumper::dump($data->orderProblems, 100, true);

$firstRow = true;
$totalPrice = 0;
$discount = 0;
?>

<table class="table" order-id="<?=$data->id;?>">
    <tr colspan="7">
        Клиент: <?=$data->user->id.'  '.$data->user->name;?>
    </tr>
    <?php if($firstRow) {
        $firstRow = false;
        ?>
    <tr>
        <td rowspan="<?=(count($data->orderProblems)+1)?>">
            <p>#<?=$data->id;?></p>
            <p><?=$data->created;?></p>
        </td>
    </tr>
    <? } ?>
    <?php
        $counter = 1;
        foreach($data->orderProblems as $orderProblem)
        {
            $totalPrice += $orderProblem->deviceProblem->price;
    ?>
    <tr>
        <td>
            <?=$counter;?>
        </td>
        <td>
            <?=$orderProblem->deviceProblem->device->name;?>
        </td>
        <td>
            <?=$orderProblem->deviceProblem->problem->name;?>
        </td>
        <td colspan="2">
            <?=$orderProblem->deviceProblem->price;?>
        </td>
        <td>
            <?php
                echo CHtml::dropDownList('problemStatus', $orderProblem->status, Core::problemStatuses(), array('class' => 'form-control input-sm problem-status-select','order-problem-id' => $orderProblem->id));
            ?>
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
            <span class="price"><?=($totalPrice - ($totalPrice/100*$data->discount));?></span>р.
        </td>
        <td class="col-md-1">
            <div class="input-group input-group-sm">
                <input type="text" class="form-control discount" size="2" value="<?=$data->discount;?>"/>
                <span class="input-group-addon">%</span>
            </div>
        </td>
        <td>
            <?php
            echo CHtml::dropDownList('orderStatus', $data->status, Core::orderStatuses(), array('class' => 'form-control input-sm order-status-select', 'order-id' => $data->id));
            ?>
        </td>
    </tr>
</table>