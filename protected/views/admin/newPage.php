<?php
/* @var $form CActiveForm */
/* @var $page Page */
$this->pageTitle=Yii::app()->name . ' - Новость';
$cs=Yii::app()->getClientScript();
$cs->registerScriptFile(Yii::app()->request->baseUrl.'/tinymce/js/tinymce/tinymce.min.js');
$cs->registerScript('#Article_text_ru','tinymce.init({
    selector: "textarea",
    plugins: [
        "advlist autolink lists link charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    language : "ru",
 });');
?>
<h3 class="col-md-12 page-header">
    Новая страница
</h3>
<div class="row">
    <div class="col-md-12">
        <?php

        $this->showMessages($page);
        $form=$this->beginWidget('CActiveForm', array(
            'id'=>'newpage-form',
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
            'htmlOptions' => array(
                'class' => 'form-horizontal',
            )
        )); ?>
            <div class="form-group">
                <?php echo $form->labelEx($page,'title', array('class' => 'col-lg-2 control-label')); ?>
                <div class="col-lg-10">
                    <?php echo $form->textField($page,'title', array('class' => 'form-control')); ?>
                </div>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($page,'content', array('class' => 'col-lg-2 control-label')); ?>
                <div class="col-lg-10">
                    <?php echo $form->textArea($page,'content', array('class' => 'form-control', 'rows' => '20')); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                        <label>
                            <?= $form->checkBox($page, 'footer'); ?> Показывать в футере
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-success">Создать</button>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>