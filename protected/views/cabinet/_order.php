<?php
/* @var $data FixOrder */
//CVarDumper::dump($data->orderProblems, 100, true);

$firstRow = true;
$totalPrice = 0;
$discount = 0;
?>

<table class="table">
    <?php if($firstRow) {
        $firstRow = false;
        ?>
    <tr>
        <td rowspan="<?=(count($data->orderProblems)+2)?>">
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
            <?=Html::getProblemStatus($orderProblem->status);?>
        </td>
    </tr>
    <?php
            $counter++;
        }
    ?>
    <tr>
        <td colspan="3">
            <strong>Итого по всем работам со скидкой:</strong>
        </td>
        <td>
            <?=$totalPrice.'р.';?>
        </td>
        <td>
            <?=$data->discount.'%';?>
        </td>
        <td>
            <?=Html::getOrderStatus($data->status);?>
        </td>
    </tr>
</table>