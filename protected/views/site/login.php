<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Вход';
$this->breadcrumbs=array(
	'Login',
);
?>
<div class="col-md-6 col-md-offset-3">
<?php
$this->showMessages($model);
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
    'htmlOptions' => array(
        'class' => 'form-horizontal black-form',
    )
)); ?>
    <fieldset>
        <legend>Вход</legend>
        <div class="form-group">
            <?php echo $form->labelEx($model,'phone', array('class' => 'col-lg-3 control-label')); ?>
            <div class="col-lg-9">
                <div class="input-group">
                    <span class="input-group-addon">+7</span>
                    <?php echo $form->textField($model,'phone', array('class' => 'form-control')); ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model,'password', array('class' => 'col-lg-3 control-label')); ?>
            <div class="col-lg-9">
                <?php echo $form->passwordField($model,'password', array('class' => 'form-control')); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2 text-center">
                <button type="submit" class="btn btn-primary">Войти</button>
                <!--<a href="<?=$this->createUrl('/site/registration');?>" class="btn btn-primary">Регистрация</a>
                <a href="<?=$this->createUrl('/site/forgot');?>" class="btn btn-warning pull-right">Восстановить пароль</a>-->
            </div>
        </div>
    </fieldset>

<?php $this->endWidget(); ?>
</div><!-- form -->
