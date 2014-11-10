<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="ru" />
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Roboto:300&subset=latin,cyrillic-ext,cyrillic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/jFU/css/jquery.fileupload.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/jFU/css/jquery.fileupload-ui.css" />
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
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/html.js" type="application/javascript"></script>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/jFU/js/vendor/jquery.ui.widget.js"></script>
    <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
    <script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
    <!-- The Canvas to Blob plugin is included for image resizing functionality -->
    <script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
    <!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/jFU/js/jquery.iframe-transport.js"></script>
    <!-- The basic File Upload plugin -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/jFU/js/jquery.fileupload.js"></script>
    <!-- The File Upload processing plugin -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/jFU/js/jquery.fileupload-process.js"></script>
    <!-- The File Upload image preview & resize plugin -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/jFU/js/jquery.fileupload-image.js"></script>
    <!-- The File Upload audio preview plugin -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/jFU/js/jquery.fileupload-audio.js"></script>
    <!-- The File Upload video preview plugin -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/jFU/js/jquery.fileupload-video.js"></script>
    <!-- The File Upload validation plugin -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/jFU/js/jquery.fileupload-validate.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/order.js" type="application/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/mask.js" type="application/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.upload.init.js" type="application/javascript"></script>
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
<div class="body">
    <?php echo $content; ?>
</div>
</body>
</html>