<?php
/* @var $user User */
/* @var $review Review */
/* @var $form CActiveForm */
?>


<div class="col-md-6">

    <?php
    $this->showMessages($user);
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'profile-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions' => array(
            'class' => 'form-horizontal black-form',
        )
    )); ?>
        <fieldset>
            <legend>Личные данные</legend>
            <div class="form-group">
                <?php echo $form->labelEx($user,'name', array('class' => 'col-lg-3 control-label')); ?>
                <div class="col-lg-9">
                    <?php echo $form->textField($user,'name', array('class' => 'form-control')); ?>
                </div>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($user,'phone', array('class' => 'col-lg-3 control-label')); ?>
                <div class="col-lg-9">
                    <div class="input-group">
                        <span class="input-group-addon">+7</span>
                        <?php echo $form->textField($user,'phone', array('class' => 'form-control')); ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($user,'email', array('class' => 'col-lg-3 control-label')); ?>
                <div class="col-lg-9">
                    <?php echo $form->textField($user,'email', array('class' => 'form-control')); ?>
                </div>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($user,'address', array('class' => 'col-lg-3 control-label')); ?>
                <div class="col-lg-9">
                    <?php echo $form->textField($user,'address', array('class' => 'form-control')); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2 text-center">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </fieldset>
    <?php $this->endWidget(); ?>
</div>
<div class="col-md-6">

    <?php
    $this->showMessages($review);
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'review-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions' => array(
            'class' => 'form-horizontal black-form',
        )
    )); ?>
        <fieldset>
            <legend>Отзыв</legend>
            <div class="form-group">
                <div class="col-lg-12">
                    <?php echo $form->textArea($review,'content', array('class' => 'form-control', 'style' => 'height: 197px;')); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2 text-center">
                    <button type="submit" class="btn btn-primary">Отправить</button>
                </div>
            </div>
        </fieldset>
    <?php $this->endWidget(); ?>
</div>