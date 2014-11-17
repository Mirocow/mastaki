<?php

$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/'.'catalog.js');
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/'.'catalogToggle.js');
?>

<div class="col-md-12 devices-lists">
    <div class="col-md-4">
        <div class="page-header">Разделы</div>
        <ul class="nav nav-pills nav-stacked device-types-list">
            <?php
            $first = true;
            foreach($deviceTypes as $deviceType)
            {
                echo '<li'.(($first) ? ' class="bg-info"' : '').'><span device-type-id="'.$deviceType->id.'" class="device-type-li">'.$deviceType->name.'</span><i class="fa pull-right fa-toggle-'.(($deviceType->active == 1) ? 'on text-success' : 'off text-mute').'"></i></li>';
                $first = false;
            }

            ?>
        </ul>
    </div>
    <div class="col-md-4">
        <div class="page-header">Производители</div>
        <ul class="nav nav-pills nav-stacked manufacturers-list">
            <?php
            $first = true;
            foreach($manufacturers as $manufacturer)
            {
                echo '<li'.(($first) ? ' class="bg-info"' : '').'><span manufacturer-id="'.$manufacturer->id.'" class="manufacturer-li">'.$manufacturer->name.'</span><i class="fa pull-right fa-toggle-'.(($manufacturer->active == 1) ? 'on text-success' : 'off text-mute').'"></i></li>';
                $first = false;
            }
            ?>
        </ul>
    </div>
    <div class="col-md-4">
        <div class="page-header">Устройства</div>
        <ul class="nav nav-pills nav-stacked devices-list">
            <?php
            $first = true;
            foreach($devices as $device)
            {
                echo '<li'.(($first) ? ' class="bg-info"' : '').'><span device-id="'.$device->id.'" class="device-li">'.$device->name.'</span><i class="fa pull-right fa-toggle-'.(($device->active == 1) ? 'on text-success' : 'off text-mute').'"></i></li>';
                $first = false;
            }
            ?>
        </ul>
    </div>
</div>
<div class="col-md-12 devices-lists">
    <div class="col-md-4">
        <div class="page-header">
            Часть устройства
        </div>
        <ul class="nav nav-pills nav-stacked problem-categories-list">
            <?php
            $first = true;
            foreach($problemCategories as $problemCategory)
            {
                echo '<li'.(($first) ? ' class="bg-info"' : '').'><span problem-category-id="'.$problemCategory->id.'" class="problem-category-li">'.$problemCategory->name.'</span><i class="fa pull-right fa-toggle-'.(($problemCategory->active == 1) ? 'on text-success' : 'off text-mute').'"></i></li>';
                $first = false;
            }

            ?>
        </ul>
    </div>
    <div class="col-md-4">
        <div class="page-header">
            Услуги
        </div>
        <ul class="nav nav-pills nav-stacked breakdowns-list">
            <?php
            $first = true;
            foreach($breakdowns as $breakdown)
            {
                echo '<li'.(($first) ? ' class="bg-info"' : '').'><span breakdown-id="'.$breakdown->id.'" class="breakdown-li">'.$breakdown->name.'</span><i class="fa pull-right fa-toggle-'.(($breakdown->active == 1) ? 'on text-success' : 'off text-mute').'"></i></li>';
                $first = false;
            }
            ?>
        </ul>
        <div class="col-md-12">Цена запчастей</div>
        <div class="col-md-12"><input type="text" id="breakdown-part-price" class="form-control" value="<?php echo ($deviceBreakdown) ? $deviceBreakdown->part_price : '';?>"/></div>
        <div class="col-md-12">Цена работы</div>
        <div class="col-md-12"><input type="text" id="breakdown-work-price" class="form-control" value="<?php echo ($deviceBreakdown) ? $deviceBreakdown->price : '';?>"/></div>
        <div class="col-md-12 text-center"><button id="breakdown-price-save" class="btn btn-success">Сохранить</button></div>
    </div>
    <div class="col-md-4">
        <div class="page-header">
            Проблемы
        </div>
        <ul class="nav nav-pills nav-stacked problems-list">
            <?php
            $first = true;
            foreach($problems as $problem)
            {
                echo '<li'.(($first) ? ' class="bg-info"' : '').'><span problem-id="'.$problem->id.'" class="problem-li">'.$problem->name.'</span><i class="fa pull-right fa-toggle-'.(($problem->active == 1) ? 'on text-success' : 'off text-mute').'"></i></li>';
                $first = false;
            }
            ?>
        </ul>
        <div class="col-md-12">Цена запчастей</div>
        <div class="col-md-12"><input type="text" id="problem-part-price" class="form-control" value="<?php echo ($deviceProblem) ? $deviceProblem->part_price : '';?>"/></div>
        <div class="col-md-12">Цена работы</div>
        <div class="col-md-12"><input type="text" id="problem-work-price" class="form-control" value="<?php echo ($deviceProblem) ? $deviceProblem->price : '';?>"/></div>
        <div class="col-md-12 text-center"><button id="problem-price-save" class="btn btn-success">Сохранить</button></div>
    </div>
</div>