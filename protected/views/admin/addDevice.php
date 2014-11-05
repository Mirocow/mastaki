<?php
/* @var $this AdminController */
/* @var $device device */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Добавить устройство';
$this->breadcrumbs=array(
    'Login',
);
?>
<div class="col-md-12">
    <?php
        $this->showMessages($device);

        $manufacturers = CHtml::listData(Manufacturer::model()->findAll(), 'id', 'name');
        $deviceTypes = CHtml::listData(DeviceType::model()->findAll(), 'id', 'name');

        $form=$this->beginWidget('CActiveForm', array(
            'id'=>'device-form',
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
        <legend>Новое устройство</legend>
        <div class="form-group">
            <?php echo $form->labelEx($device,'name', array('class' => 'col-lg-2 control-label')); ?>
            <div class="col-lg-10">
                <?php echo $form->textField($device,'name', array('class' => 'form-control')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($device,'manufacturer_id', array('class' => 'col-lg-2 control-label')); ?>
            <div class="col-lg-10">
                <?php echo $form->dropDownList($device,'manufacturer_id', $manufacturers, array('class' => 'form-control')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($device,'type_id', array('class' => 'col-lg-2 control-label')); ?>
            <div class="col-lg-10">
                <?php echo $form->dropDownList($device,'type_id', $deviceTypes, array('class' => 'form-control')); ?>
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
