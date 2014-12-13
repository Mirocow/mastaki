<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="ru" />
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Roboto:300&subset=latin,cyrillic-ext,cyrillic' rel='stylesheet' type='text/css'>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.js" type="application/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui.js" type="application/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/spacelab.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/css/dropdowns-enhancement.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/fa/css/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/new.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/datetimepicker.css" />

    <script src="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/js/bootstrap.js" type="application/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/js/dropdowns-enhancement.js" type="application/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/common.js" type="application/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/addToCart.js" type="application/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/html.js" type="application/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/mask.js" type="application/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/datetimepicker.js" type="application/javascript"></script>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
<div id="wrapper">
    <div class="header row">
        <div class="title-container col-md-3">
            <div class="up col-md-12">
                +7 495 000 00 00
            </div>
            <div class="title">
                МАСТАКИ
            </div>
            <div class="down col-md-12">
                Ремонт цифровой техники
            </div>
        </div>
        <div class="col-md-6 menu">
            <?php
                foreach(DeviceType::model()->findAllByAttributes(array('active' => '1'), array('order' => 'pos ASC')) as $deviceType)
                {
            ?>
                <div class="menu-item">
                    <div class="col-md-12 icon">
                        <a href="<?=$this->createUrl('/site/deviceType', array('type_id' => $deviceType->id));?>"><i class="<?=$deviceType->icon;?>"></i></a>
                    </div>
                    <div class="col-md-12 link">
                        <a href="<?=$this->createUrl('/site/deviceType', array('type_id' => $deviceType->id));?>"><?=$deviceType->name;?></a>
                    </div>
                </div>
            <?
                }
            ?>
        </div>
    </div>
    <div class="navbar navbar-default" style="display: none;">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">MASTAKI</a>
            </div>
            <div class="navbar-collapse collapse navbar-responsive-collapse">
                <?php $this->getNavBar(); ?>
                <ul class="pull-right nav navbar-nav">
                    <li>
                        <a href="<?=$this->createUrl('/site/resume')?>"><i class="fa fa-file-text"></i> Анкета</a>
                    </li>
                    <?php if(Yii::app()->user->isGuest) { ?>
                        <li>
                            <a href="<?=$this->createUrl('/site/login')?>"><i class="fa fa-sign-in"></i> Войти</a>
                        </li>
                    <?php } else { ?>
                        <?php if(isset(Yii::app()->user->role)) { if(Yii::app()->user->role == 'ADMIN') { ?>
                            <li>
                                <a href="<?=$this->createUrl('/admin/index')?>"><i class="fa fa-wrench"></i> Админка</a>
                            </li>
                        <?php }} ?>
                        <li>
                            <a href="<?=$this->createUrl('/cabinet/index')?>"><i class="fa fa-user"></i> Личный кабинет</a>
                        </li>
                        <li>
                            <a href="<?=$this->createUrl('/site/logout')?>"><i class="fa fa-sign-out"></i> Выйти</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="body">
        <?php echo $content; ?>
    </div>
</div>
<footer>
    <div class="col-md-12 footer-links text-center">
        <?php $this->getFooterBar(); ?>
    </div>
    <div id="popoverExampleTwoHiddenContent" style="display: none; width: 200px;">
        <div class="col-md-12">
            <?php
            $model = new LoginForm();
            $this->showMessages($model);
            $form=$this->beginWidget('CActiveForm', array(
                'id'=>'login-form',
                'action' => array('/site/login'),
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
                'htmlOptions' => array(
                    'class' => 'form-horizontal',
                )
            )); ?>
            <fieldset>
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">+7</span>
                            <?php echo $form->textField($model,'phone', array('class' => 'form-control')); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <?php echo $form->passwordField($model,'password', array('class' => 'form-control', 'placeholder' => 'Пароль')); ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-6 text-center">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i>&nbsp;Войти</button>
                    </div>
                    <div class="col-lg-6 text-center">
                        <a href="<?=$this->createUrl('/site/forgot');?>" class="btn btn-warning">Забыли?</a>
                    </div>
                </div>
            </fieldset>

            <?php $this->endWidget(); ?>
        </div><!-- form -->
    </div>
</footer>
</body>
</html>