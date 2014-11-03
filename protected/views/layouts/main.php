<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="ru" />
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Roboto:300&subset=latin,cyrillic-ext,cyrillic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/spacelab.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/fa/css/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" />
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>-->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.js" type="application/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui.js" type="application/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/js/bootstrap.js" type="application/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/common.js" type="application/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/addToCart.js" type="application/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/mask.js" type="application/javascript"></script>
</head>
<body>
<div class="navbar navbar-default">
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
                    <?php if(Yii::app()->user->isGuest) { ?>
                        <a href="<?=$this->createUrl('/site/login')?>"><i class="fa fa-user"></i> Войти</a>
                    <?php } else { ?>
                        <a href="<?=$this->createUrl('/site/logout')?>"><i class="fa fa-user"></i> Выйти</a>
                    <?php } ?>
                </li>
            </ul>
        </div>
    </div>
</div>

    <?php echo $content; ?>
</body>
</html>