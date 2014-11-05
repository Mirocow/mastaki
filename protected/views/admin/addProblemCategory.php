<?php
/* @var $this AdminController */
/* @var $problemCategory ProblemCategory */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Добавить категорию проблемы';
$this->breadcrumbs=array(
    'Login',
);
?>
<div class="col-md-12">
    <?php
        $this->showMessages($problemCategory);
        $form=$this->beginWidget('CActiveForm', array(
            'id'=>'problemcategory-form',
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
            'htmlOptions' => array(
                'class' => 'form-horizontal black-form',
            )
        ));
    ?>
    <fieldset>
        <legend>Новая категория проблем</legend>
        <div class="form-group">
            <?php echo $form->labelEx($problemCategory,'name', array('class' => 'col-lg-3 control-label')); ?>
            <div class="col-lg-9">
                <?php echo $form->textField($problemCategory,'name', array('class' => 'form-control')); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2 text-center">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
</div><!-- form -->
