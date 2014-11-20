<?php

$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/resume.js');
?>
<div class="col-md-12">
    <div class="col-md-5">
        <input type="text" class="form-control col-md-12" id="search-input"/>
    </div>
    <div class="col-md-2">
        <button class="btn btn-success" id="search-btn">Поиск</button>
    </div>
</div>
<div class="col-md-12 table-responsive mastaki-table-container">
    <?=$this->renderPartial('_mastaki', array('mastaki' => $mastaki)); ?>
</div>
<?php
    if(count($mastaki) > 0)
        $this->renderPartial('_mastakInfo', array('mastak' => $mastaki[0]));
?>