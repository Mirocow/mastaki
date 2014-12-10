<?php
    $cs = Yii::app()->clientScript;
    $cs->registerScriptFile(Yii::app()->baseUrl.'/js/services.js');
    $cs->registerScriptFile(Yii::app()->baseUrl.'/js/servicesSort.js');
    $cs->registerScriptFile(Yii::app()->baseUrl.'/js/imagePreview.js');
    $cs->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.swap.js');
?>
<div class="col-md-12 devices-lists">
    <div class="col-md-4">
        <div class="page-header">
            Устройства
        </div>
        <ul class="nav nav-pills nav-stacked device-types-list">
            <?php
            $first = true;
            foreach($deviceTypes as $deviceType)
            {
                echo '<li'.(($first) ? ' class="bg-info"' : '').'><span device-type-id="'.$deviceType->id.'" class="device-type-li">'.$deviceType->name.'</span></li>';
                $first = false;
            }

            ?>
        </ul>
    </div>
    <div class="col-md-4">
        <div class="page-header">
            Часть устройства
        </div>
        <ul class="nav nav-pills nav-stacked problem-categories-list">
            <?php
            $first = true;
            foreach($problemCategories as $problemCategory)
            {
                echo '<li'.(($first) ? ' class="bg-info"' : '').'><i class="fa fa-arrow-down move down"></i><i class="fa fa-arrow-up move up"></i><span problem-category-id="'.$problemCategory->id.'" class="problem-category-li" icon="'.$problemCategory->icon.'">'.$problemCategory->name.'</span></li>';
                $first = false;
            }

            ?>
        </ul>
    </div>
    <div class="col-md-4">
        <form id="problem-category-form">
            <div class="col-md-12">
                <input type="text" id="problem-category-input" name="value" class="form-control" value="<?=(isset($problemCategories[0]) ? $problemCategories[0]->name : '');?>"/>
            </div>
            <div class="btn-group col-md-12">
                <button type="button" class="btn btn-default dropdown-toggle col-md-12" data-toggle="dropdown">
                    Действие <span class="caret"></span>
                </button>
                <ul class="dropdown-menu col-md-12" role="menu">
                    <li><a href="#" id="save-problem-category">Сохранить</a></li>
                    <li><a href="#" id="add-problem-category">Добавить</a></li>
                    <li><a href="#" id="delete-problem-category">Удалить</a></li>
                </ul>
            </div>
            <div class="col-md-12">
                <input type="hidden" id="problemCategoryIdHidden" name="id" value="<?=(isset($problemCategories[0]) ? $problemCategories[0]->getPrimaryKey() : '');?>"/>
                <input type="hidden" name="deviceTypeId" value="<?=(isset($deviceTypes[0]) ? $deviceTypes[0]->getPrimaryKey() : '');?>"/>
                <input type="hidden" name="action" value="problemCategory"/>
                <input id="problem-category-icon" name="ProblemCategory[icon]" type="text" class="form-control col-md-12" value="<?=(isset($problemCategories[0]) ? $problemCategories[0]->icon : '');?>">
            </div>
        </form>
    </div>
    <div class="col-md-12">
        <div class="page-header col-md-12">
            Услуги
        </div>
    </div>
    <div class="col-md-4">
        <ul class="nav nav-pills nav-stacked breakdowns-list">
            <?php
            $first = true;
            foreach($breakdowns as $breakdown)
            {
                echo '<li'.(($first) ? ' class="bg-info"' : '').'><i class="fa fa-arrow-down move down"></i><i class="fa fa-arrow-up move up"></i><span breakdown-id="'.$breakdown->id.'" class="breakdown-li" icon="'.$breakdown->icon.'">'.$breakdown->name.'</span></li>';
                $first = false;
            }
            ?>
        </ul>
    </div>
    <form id="breakdown-form">
        <div class="col-md-4">
            <div class="col-md-12">
                <input type="text" id="breakdown-input" name="value" class="form-control" value="<?=(isset($breakdowns[0]) ? $breakdowns[0]->name : '');?>"/>
            </div>
            <div class="col-md-12">
                <textarea type="text" id="breakdown-description-input" name="description" class="form-control"><?=(isset($breakdowns[0]) ? $breakdowns[0]->description : '');?></textarea>
            </div>
        </div>
        <div class="col-md-4">
            <div class="btn-group col-md-12">
                <button type="button" class="btn btn-default dropdown-toggle col-md-12" data-toggle="dropdown">
                    Действие <span class="caret"></span>
                </button>
                <ul class="dropdown-menu col-md-12" role="menu">
                    <li><a href="#" id="save-breakdown">Сохранить</a></li>
                    <li><a href="#" id="add-breakdown">Добавить</a></li>
                    <li><a href="#" id="delete-breakdown">Удалить</a></li>
                </ul>
            </div>
            <div class="col-md-12 text-center breakdown-image-container">
                <img src="#" id="breakdown-image-file-preview" class="img-thumbnail img-responsive hidden"/>
            </div>
            <div class="col-md-12 text-center breakdown-image-container">
                <input type="hidden" id="breakdownIdHidden" name="id" value="<?=(isset($breakdowns[0]) ? $breakdowns[0]->getPrimaryKey() : '');?>"/>
                <input type="hidden" name="deviceTypeId" value="<?=(isset($deviceTypes[0]) ? $deviceTypes[0]->getPrimaryKey() : '');?>"/>
                <input type="hidden" name="problemCategoryId" value="<?=(isset($problemCategories[0]) ? $problemCategories[0]->getPrimaryKey() : '');?>"/>
                <input type="hidden" name="action" value="breakdown"/>
                <input id="breakdown-image-file" name="Problem[image_file]" type="file" class="form-control col-md-12">
                <input id="breakdown-icon" name="Problem[icon]" type="text" class="form-control col-md-12" placeholder="Иконка" value="<?=(isset($breakdowns[0]) ? $breakdowns[0]->icon : '');?>"/>
            </div>
        </div>
    </form>
    <div class="col-md-12">
        <div class="page-header col-md-12">
            Проблемы
        </div>
    </div>
    <div class="col-md-4">
        <ul class="nav nav-pills nav-stacked problems-list">
            <?php
            $first = true;
            foreach($problems as $problem)
            {
                echo '<li'.(($first) ? ' class="bg-info"' : '').'><i class="fa fa-arrow-down move down"></i><i class="fa fa-arrow-up move up"></i><span problem-id="'.$problem->id.'" class="problem-li" icon="'.$problem->icon.'">'.$problem->name.'</span></li>';
                $first = false;
            }
            ?>
        </ul>
    </div>
    <form id="problem-form">
        <div class="col-md-4">
            <div class="col-md-12">
                <input type="text" id="problem-input" name="value" class="form-control" value="<?=(isset($problems[0]) ? $problems[0]->name : '');?>"/>
            </div>
            <div class="col-md-12">
                <textarea type="text" id="problem-description-input" name="description" class="form-control"><?=(isset($problems[0]) ? $problems[0]->description : '');?></textarea>
            </div>
        </div>
        <div class="col-md-4">
            <div class="btn-group col-md-12">
                <button type="button" class="btn btn-default dropdown-toggle col-md-12" data-toggle="dropdown">
                    Действие <span class="caret"></span>
                </button>
                <ul class="dropdown-menu col-md-12" role="menu">
                    <li><a href="#" id="save-problem">Сохранить</a></li>
                    <li><a href="#" id="add-problem">Добавить</a></li>
                    <li><a href="#" id="delete-problem">Удалить</a></li>
                </ul>
            </div>
            <div class="col-md-12 text-center problem-image-container">
                <img src="#" id="problem-image-file-preview" class="img-thumbnail img-responsive hidden"/>
            </div>
            <div class="col-md-12 text-center breakdown-image-container">
                <input type="hidden" id="problemIdHidden" name="id" value="<?=(isset($breakdowns[0]) ? $breakdowns[0]->getPrimaryKey() : '');?>"/>
                <input type="hidden" name="deviceTypeId" value="<?=(isset($deviceTypes[0]) ? $deviceTypes[0]->getPrimaryKey() : '');?>"/>
                <input type="hidden" name="problemCategoryId" value="<?=(isset($problemCategories[0]) ? $problemCategories[0]->getPrimaryKey() : '');?>"/>
                <input type="hidden" name="action" value="problem"/>
                <input id="problem-image-file" name="Problem[image_file]" type="file" class="form-control col-md-12">
                <input id="problem-icon" name="Problem[icon]" type="text" class="form-control col-md-12" placeholder="Иконка" value="<?=(isset($problems[0]) ? $problems[0]->icon : '');?>"/>
            </div>
        </div>
    </form>
</div>
