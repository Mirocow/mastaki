<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/userResume.js');
?>
<h3 class="page-header">
    Анкета на вакансию инженера технического обслуживания
</h3>
<?php
echo '<div id="messages">'.$this->showMessages($mastak).'</div>';
$form=$this->beginWidget('CActiveForm', array(
    'id'=>'resume-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
    'htmlOptions' => array(
        'class' => 'form-horizontal black-form',
    )
)); ?>
    <div class="col-md-12 fields">
        <div class="col-md-4">
            <div class="form-group">
                <input type="text" class="form-control col-md-12" name="last_name" placeholder="Фамилия" />
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <input type="text" class="form-control col-md-12" name="first_name" placeholder="Имя" />
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <input type="text" class="form-control col-md-12" name="second_name" placeholder="Отчество" />
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <input type="text" class="form-control col-md-12 date-input" name="Mastak[birthdate]" placeholder="Дата рождения" />
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <input type="text" class="form-control col-md-12" name="Mastak[phone]" placeholder="Телефон" />
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <input type="text" class="form-control col-md-12" name="Mastak[address]" placeholder="Адрес" />
            </div>
        </div>
    </div>
    <div class="col-md-8 fields">
        <div class="col-md-12">
            <div class="form-group">
                <textarea class="form-control col-lg-12" name="Mastak[education]" placeholder="Образование"></textarea>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <textarea class="form-control col-lg-12" name="Mastak[experience]" placeholder="Место и опыт работы"></textarea>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <textarea class="form-control col-lg-12" name="Mastak[qualities]" placeholder="Профессиональные навыки и личные качества"></textarea>
            </div>
        </div>
    </div>
    <div class="col-md-4 skills">
        <?php
            foreach($skillCategories as $skillCategory)
            {
        ?>
                <div class="col-md-12">
                    <div class="btn-group btn-block">
                        <button type="button" class="btn btn-default col-md-11">
                            <input type="checkbox" name="SkillCategories[<?=$skillCategory->id;?>]" class="pull-left skill-category-checkbox"/>
                            <?=$skillCategory->name;?>
                        </button>
                        <button type="button" class="btn btn-default dropdown-toggle col-md-1" data-toggle="dropdown" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu col-md-12 noclose" role="menu">
                            <?php
                                foreach($skillCategory->skills as $skill)
                                {
                                    echo '<li><a href="#"><input type="checkbox" class="skill-checkbox" name="Skills['.$skill->id.']"/>&nbsp;'.$skill->name.'</a></li>';
                                }
                            ?>
                        </ul>
                    </div>
                </div>
        <?php
            }
        ?>
    </div>
    <div class="col-md-12 fields">
        <div class="col-md-4">
            <div class="form-group">
                <input type="text" class="form-control col-md-12" name="Mastak[email]" placeholder="Email" />
            </div>
        </div>
        <div class="col-md-4">
            &nbsp;
        </div>
        <div class="col-md-4">
            <button class="btn btn-success col-md-12" id="submit-btn">Отправить</button>
        </div>
    </div>
<?php $this->endWidget(); ?>