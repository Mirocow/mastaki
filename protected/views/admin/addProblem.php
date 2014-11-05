<?php
/* @var $this AdminController */
/* @var $problem Problem */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Добавить проблему';
$this->breadcrumbs=array(
    'Login',
);
?>
<div class="col-md-12">
    <?php
        $this->showMessages($problem);

        $problemCategories = CHtml::listData(ProblemCategory::model()->findAll(), 'id', 'name');

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
        <legend>Новая проблема</legend>
        <div class="form-group">
            <?php echo $form->labelEx($problem,'name', array('class' => 'col-lg-2 control-label')); ?>
            <div class="col-lg-10">
                <?php echo $form->textField($problem,'name', array('class' => 'form-control')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($problem,'description', array('class' => 'col-lg-2 control-label')); ?>
            <div class="col-lg-10">
                <?php echo $form->textArea($problem,'description', array('class' => 'form-control')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($problem,'problem_category_id', array('class' => 'col-lg-2 control-label')); ?>
            <div class="col-lg-10">
                <?php echo $form->dropDownList($problem,'problem_category_id', $problemCategories, array('class' => 'form-control')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($problem,'type', array('class' => 'col-lg-2 control-label')); ?>
            <div class="col-lg-10">
                <?php echo $form->dropDownList($problem,'type', array('BREAKDOWN' => 'Поломка', 'PROBLEM' => 'Проблема'), array('class' => 'form-control')); ?>
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
