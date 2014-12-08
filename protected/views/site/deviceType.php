<?php
/* @var $devices array */
/* @var $problemCategories array */
/* @var $currentDevice Device */
/* @var $manufacturers array */
/* @var $manufacturer_id int */
/* @var $device_id int */
/* @var $type_id int */
/* @var $problem_type string */
//<!--<div class="col-lg-2 col-md-4 col-sm-4 col-xs-12 text-center"><strong><?=$currentDevice->name;</strong></div>-->

$newProblemType = ($problem_type == 'BREAKDOWN') ? 'PROBLEM' : 'BREAKDOWN';
$date = new DateTime();
$date->add(new DateInterval('PT4H'));
?>
<div class="deviceInfo">
    <div class="col-lg-12 text-center order-form">
        <div class="col-lg-12 text-center" id="form-div">
            <div class="col-lg-12" id="phone-input">
                <div class="input-group">
                    <span class="input-group-addon">+7</span>
                    <input type="text" name="phone" class="form-control col-md-4" placeholder="Телефон"/>
                </div>
            </div>
            <div class="col-md-12" id="name-input">
                <input type="text" name="name" class="form-control col-md-4" placeholder="Имя"/>
            </div>
            <div class="col-md-6 text-center padding">
                <button type="button" id="order-btn" class="btn btn-success col-md-12" disabled="disabled">Заказать услугу</button>
            </div>
            <div class="col-md-6 text-center padding">
                <input type="text" name="date" class="form-control col-md-4" id="dateTime" value="<?=$date->format('Y-m-d H:i:s');?>"/>
            </div>
        </div>
        <div class="row col-md-12 text-ceter" id="form-message">
            <div class="alert alert-dismissable alert-success">
                <button type="button" class="close" id="form-message-close">×</button>
                <strong>Заказ успешно создан!</strong>
            </div>
        </div>
    </div>
</div>
<div class="col-md-2">
    <div id="leftMenu">
        <div class="list-group panel">
            <?php
                foreach($manufacturers as $manufacturer)
                {
                    echo '<a href="#man'.$manufacturer->id.'" class="list-group-item list-group-item-info" data-toggle="collapse" data-parent="#leftMenu"><i class="'.$manufacturer->icon.'"></i>&nbsp;'.$manufacturer->name.'</a>';
                    if(count($manufacturer->devices) > 0)
                    {
                        $collapseClass = ($manufacturer->id == $manufacturer_id) ? 'collapse in' : 'collapse';
                        echo '<div class="'.$collapseClass.' text-center" id="man'.$manufacturer->id.'">';

                        foreach($manufacturer->devices as $device)
                        {
                            $deviceClass = ($device->id == $device_id) ? 'list-group-item disabled' : 'list-group-item';
                            echo '<a href="'.$this->createUrl('/site/deviceType', array('type_id' => $type_id, 'manufacturer_id' => $manufacturer->id, 'device_id' => $device->id, 'problem_type' => $problem_type)).'" class="'.$deviceClass.'">' . $device->name . '</a>';
                        }

                        echo '</div>';
                    }
                }
            ?>
        </div>
    </div>
</div>
<div class="col-md-10">
    <div class="col-md-12 problem-type">
        <div class="pull-left col-md-6">
            <a href="<?=$this->createUrl('/site/deviceType', array('type_id' => $type_id, 'manufacturer_id' => $manufacturer_id, 'device_id' => $device_id, 'problem_type' => 'BREAKDOWN'));?>">
                <i class="fa fa-cogs"></i>
            </a>
            <span>Выбрать определенную услугу</span>
            <a href="<?=$this->createUrl('/site/deviceType', array('type_id' => $type_id, 'manufacturer_id' => $manufacturer_id, 'device_id' => $device_id, 'problem_type' => 'PROBLEM'));?>" style="padding-left: 20px;">
                <i class="fa fa-search"></i>
            </a>
            <span>Выбрать определенную услугу</span>
        </div>
    </div>
    <?php
    if(count($problemCategories[0]) > 0)
     {
         echo '<div id="problems-columns" class="problems" role="tablist" aria-multiselectable="true">';
         foreach($problemCategories as $column)
         {
             echo '<div class="col-md-4">';
             foreach($column as $problemCategory)
             {
                 echo '<div class="panel panel-default col-md-12">';
                 echo '<div class="panel-heading"><i class="'.$problemCategory->icon.'"></i> <span>'.$problemCategory->name.'</span></div>';
                 if(count($problemCategory->problems) > 0)
                 {
                     echo '<ul class="list-group">';

                     foreach($problemCategory->problems as $problem)
                     {
                         $price = ($problem->type == 'BREAKDOWN') ? $problem->devicesProblem[0]->getTotalPrice() .'р.' : 'от '.$problem->devicesProblem[0]->getTotalPrice().'р.';
                         echo '<li class="list-group-item">';
                         echo '<a aria-expanded="true" aria-controls="p'.$problem->devicesProblem[0]->id.'" data-toggle="collapse" class="collapsed" data-parent="#problems-columns" href="#p'.$problem->devicesProblem[0]->id.'"><i class="fa fa-angle-right details-arrow" problem-id="'.$problem->devicesProblem[0]->id.'"></i></a>&nbsp;<span class="problem-item" problem-id="'.$problem->devicesProblem[0]->id.'"><i class="'.$problem->icon.'"></i> <span>'.$problem->name.'</span></span><span class="pull-right price">'.$price.'</span>';
                         echo '<p role="tabpanel" aria-labelledby="p'.$problem->devicesProblem[0]->id.'" class="problem-details row panel-collapse collapse" id="p'.$problem->devicesProblem[0]->id.'" problem-id="'.$problem->devicesProblem[0]->id.'">';
                         if($problem->image)
                             echo '<img src="'.Yii::app()->request->baseUrl.'/images/images/'.$problem->image.'" class="desc-img img-responsive"/>';
                         else
                             echo '<img src="'.Yii::app()->request->baseUrl.'/images/no-image-150-100.png" class="desc-img img-responsive"/>';

                         echo '<span>'.$problem->description.'</span>';
                         echo '</p>';
                         echo '</li>';
                     }

                     echo '</ul>';
                 }
                 echo '</div>';
             }
             echo '</div>';
         }
         echo '</div>';
    }
    else
    {
    ?>
        <div class="alert alert-danger">
            По данному устройтсву отсутствуют услуги ремонта
        </div>
    <?php
    }
    ?>
</div>