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

    <script src="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/js/bootstrap.js" type="application/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/bootstrap/js/dropdowns-enhancement.js" type="application/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/common.js" type="application/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/addToCart.js" type="application/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/html.js" type="application/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/mask.js" type="application/javascript"></script>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
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
</body>
</html>