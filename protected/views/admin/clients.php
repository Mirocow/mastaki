<?php

$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/clients.js');

$clientId = '';
$name = '';
$phone = '';
$email = '';
$address = '';
$discount = 0;
if(count($clients) > 0)
{
    $clientId = $clients[0]->id;
    $name = $clients[0]->name;
    $phone = $clients[0]->phone;
    $email = $clients[0]->email;
    $address = $clients[0]->address;
    $discount = $clients[0]->discount;
}

?>

<div class="col-md-12 search-row">
    <div class="col-md-4">
        <input type="text" class="col-md-12 form-control" id="search-client-input"/>
    </div>
    <div class="col-md-2">
        <button class="btn btn-success col-md-12" id="search">Поиск</button>
    </div>
</div>
<div class="col-md-12">
    <div class="col-md-7">
        <div class="table-responsive clients-container">
            <?php $this->renderPartial('_clients', array('clients' => $clients));?>
        </div>
    </div>
    <div class="col-md-5">
        <div class="well col-md-12">
            <form id="client-form">
                <div class="col-md-12">
                    <input type="text" class="col-md-12 form-control" name="User[name]" id="name-input" placeholder="Имя" value="<?=$name;?>"/>
                </div>
                <div class="col-md-12">
                    <textarea class="col-md-12 form-control" name="User[address]" id="address-input" placeholder="Адрес"><?=$address;?></textarea>
                </div>
                <div class="col-md-6">
                    <input type="text" class="col-md-12 form-control" name="User[phone]" id="phone-input" placeholder="Телефон" value="<?=$phone;?>"/>
                </div>
                <div class="col-md-6">
                    <input type="text" class="col-md-12 form-control" name="User[email]" id="email-input" placeholder="E-mail" value="<?=$email;?>"/>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" name="User[discount]" class="col-md-12 form-control" value="<?=$discount;?>">
                        <span class="input-group-addon">%</span>
                    </div>
                    <input type="hidden" name="clientId" id="clientId" value="<?=$clientId;?>"/>
                </div>
            </form>
            <div class="col-md-6">
                <button class="btn btn-success col-md-12" id="save-client">Сохранить</button>
            </div>
        </div>
        <div class="col-md-12 table-responsive orders-table-container">
            <?php $this->renderPartial('_orders', array('orders' => $orders)); ?>
        </div>
    </div>
</div>