<?php
/* @var $devices array */
/* @var $problemCategories array */
/* @var $currentDevice Device */
/* @var $manufacturers array */
/* @var $manufacturer_id int */
/* @var $device_id int */
/* @var $type_id int */
/* @var $problem_type string */

$newProblemType = ($problem_type == 'BREAKDOWN') ? 'PROBLEM' : 'BREAKDOWN';
?>
<div class="col-md-2">
    <div id="leftMenu">
        <div class="list-group panel">
            <?php
                foreach($manufacturers as $manufacturer)
                {
                    echo '<a href="#man'.$manufacturer->id.'" class="list-group-item list-group-item-info" data-toggle="collapse" data-parent="#leftMenu">'.$manufacturer->name.'</a>';
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
    <div class="row deviceInfo">
        <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12 text-center"><strong><?=$currentDevice->manufacturer->name.' '.$currentDevice->name;?></strong></div>
        <div class="col-lg-8 col-md-4  col-sm-4 col-xs-12 text-center hidden">
            <div class="row col-md-12 text-center">
                <div class="col-md-6">
                    <input type="text" name="phone" class="form-control col-md-4" placeholder="Телефон"/>
                </div>
                <div class="col-md-6">
                    <input type="text" name="name" class="form-control col-md-4" placeholder="Имя"/>
                </div>
                <div class="col-md-12 text-center">
                    <button type="submit" href="#" id="order-btn" class="btn btn-success">Заказать</button>
                </div>
            </div>
        </div>
        <div class="pull-right col-lg-2 col-md-4 col-sm-4 col-xs-12 text-center">Тип: <a href="<?=$this->createUrl('/site/deviceType', array('type_id' => $type_id, 'manufacturer_id' => $manufacturer_id, 'device_id' => $device_id, 'problem_type' => $newProblemType));?>"><i class="fa fa-refresh"></i></a></div>
    </div>
    <?php
    if(count($problemCategories) > 0)
     {
         echo '<div class="problems">';
         foreach($problemCategories as $problemCategory)
         {
             echo '<div class="panel panel-default col-md-4">';
             echo '<div class="panel-heading">'.$problemCategory->name.'</div>';
             if(count($problemCategory->problems) > 0)
             {
                 echo '<ul class="list-group">';

                 foreach($problemCategory->problems as $problem)
                 {
                     $price = ($problem->type == 'BREAKDOWN') ? $problem->devicesProblem[0]->price.'р.' : 'от '.$problem->devicesProblem[0]->price.'р.';
                     echo '<li class="list-group-item"><i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="'.$problem->description.'"></i> <span class="problem-item" problem-id="'.$problem->id.'">'.$problem->name.'</span><span class="pull-right">'.$price.'</span></li>';
                 }

                 echo '</ul>';
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