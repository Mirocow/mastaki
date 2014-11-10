<div class="col-md-12 devices-lists">
    <div class="col-md-4">
        <div class="page-header">Разделы</div>
        <ul class="nav nav-pills nav-stacked device-types-list">
            <?php
                foreach($deviceTypes as $deviceType)
                    echo '<li><i class="fa fa-arrow-down"></i><i class="fa fa-arrow-up"></i>'.$deviceType->name.'</li>';
            ?>
        </ul>
        <div class="col-md-12">
            <input type="text" id="device-type-input" class="form-control"/>
        </div>
        <div class="btn-group col-md-12">
            <button type="button" class="btn btn-default dropdown-toggle col-md-12" data-toggle="dropdown">
                Действие <span class="caret"></span>
            </button>
            <ul class="dropdown-menu col-md-12" role="menu">
                <li><a href="#" id="#save-device-type">Сохранить</a></li>
                <li><a href="#" id="#add-device-type">Добавить</a></li>
                <li><a href="#" id="#delete-device-type">Удалить</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <span class="btn btn-success fileinput-button col-md-12">
                <i class="glyphicon glyphicon-plus"></i>
                <span>Выбрать иконку...</span>
                <!-- The file input field used as target for the file upload widget -->
                <input id="fileupload" type="file" name="device-type-icon-file">
            </span>
        </div>
        <div class="col-md-12 device-type-icon-container">
            <div id="files" class="files"></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="page-header">Производители</div>
        <ul class="nav nav-pills nav-stacked manufacturers-list">
            <?php
                foreach($manufacturers as $manufacturer)
                    echo '<li><i class="fa fa-arrow-down"></i><i class="fa fa-arrow-up"></i>'.$manufacturer->name.'</li>';
            ?>
        </ul>
        <input type="text" id="manufacturer-input" class="form-control"/>
        <div class="btn-group col-md-12">
            <button type="button" class="btn btn-default dropdown-toggle col-md-12" data-toggle="dropdown">
                Действие <span class="caret"></span>
            </button>
            <ul class="dropdown-menu col-md-12" role="menu">
                <li><a href="#" id="#save-manufacturer">Сохранить</a></li>
                <li><a href="#" id="#add-manufacturer">Добавить</a></li>
                <li><a href="#" id="#delete-manufacturer">Удалить</a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-4">
        <div class="page-header">Устройства</div>
        <ul class="nav nav-pills nav-stacked devices-list">
            <?php
                foreach($devices as $device)
                    echo '<li><i class="fa fa-arrow-down"></i><i class="fa fa-arrow-up"></i>'.$device->name.'</li>';
            ?>
        </ul>
        <div class="col-md-12">
            <input type="text" id="device-input" class="form-control"/>
        </div>
        <div class="btn-group col-md-12">
            <button type="button" class="btn btn-default dropdown-toggle col-md-12" data-toggle="dropdown">
                Действие <span class="caret"></span>
            </button>
            <ul class="dropdown-menu col-md-12" role="menu">
                <li><a href="#" id="#save-device">Сохранить</a></li>
                <li><a href="#" id="#add-device">Добавить</a></li>
                <li><a href="#" id="#delete-device">Удалить</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <span class="btn btn-success fileinput-button col-md-12">
                <i class="glyphicon glyphicon-plus"></i>
                <span>Выбрать изображение...</span>
                <!-- The file input field used as target for the file upload widget -->
                <input id="fileupload" type="file" name="device-image-file">
            </span>
        </div>
        <div class="col-md-12 device-photo-container">
            <div id="device-image-file" class="files"></div>
        </div>
    </div>
</div>