<div class="col-md-12 devices-lists">
    <div class="col-md-4">
        <div class="page-header">Разделы</div>
        <ul class="nav nav-pills nav-stacked device-types-list">
            <?php
                $first = true;
                foreach($deviceTypes as $deviceType)
                {
                    echo '<li'.(($first) ? ' class="bg-info"' : '').'><i class="fa fa-arrow-down"></i><i class="fa fa-arrow-up"></i><span device-type-id="'.$deviceType->id.'" class="device-type-li">'.$deviceType->name.'</span></li>';
                    $first = false;
                }

            ?>
        </ul>
        <input type="text" id="device-type-input" class="form-control" value="<?=$deviceTypes[0]->name;?>"/>
        <div class="btn-group col-md-12">
            <button type="button" class="btn btn-default dropdown-toggle col-md-12" data-toggle="dropdown">
                Действие <span class="caret"></span>
            </button>
            <ul class="dropdown-menu col-md-12" role="menu">
                <li><a href="#" id="save-device-type">Сохранить</a></li>
                <li><a href="#" id="add-device-type">Добавить</a></li>
                <li><a href="#" id="delete-device-type">Удалить</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <input id="device-type-icon-file" type="file" class="form-control col-md-12" name="device-type-icon-file">
        </div>
        <div class="col-md-12 text-center device-type-icon-container">
            <img src="#" id="device-type-icon-file-preview" class="img-thumbnail img-responsive hidden"/>
        </div>
    </div>
    <div class="col-md-4">
        <div class="page-header">Производители</div>
        <ul class="nav nav-pills nav-stacked manufacturers-list">
            <?php
                $first = true;
                foreach($manufacturers as $manufacturer)
                {
                    echo '<li'.(($first) ? ' class="bg-info"' : '').'><i class="fa fa-arrow-down"></i><i class="fa fa-arrow-up"></i><span manufacturer-id="'.$manufacturer->id.'" class="manufacturer-li">'.$manufacturer->name.'</span></li>';
                    $first = false;
                }
            ?>
        </ul>
        <input type="text" id="manufacturer-input" class="form-control" value="<?=$manufacturers[0]->name;?>"/>
        <div class="btn-group col-md-12">
            <button type="button" class="btn btn-default dropdown-toggle col-md-12" data-toggle="dropdown">
                Действие <span class="caret"></span>
            </button>
            <ul class="dropdown-menu col-md-12" role="menu">
                <li><a href="#" id="save-manufacturer">Сохранить</a></li>
                <li><a href="#" id="add-manufacturer">Добавить</a></li>
                <li><a href="#" id="delete-manufacturer">Удалить</a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-4">
        <div class="page-header">Устройства</div>
        <ul class="nav nav-pills nav-stacked devices-list">
            <?php
                $first = true;
                foreach($devices as $device)
                {
                    echo '<li'.(($first) ? ' class="bg-info"' : '').'><i class="fa fa-arrow-down"></i><i class="fa fa-arrow-up"></i><span device-id="'.$device->id.'" class="device-li">'.$device->name.'</span></li>';
                    $first = false;
                }
            ?>
        </ul>
        <input type="text" id="device-input" class="form-control" value="<?=$devices[0]->name;?>"/>
        <div class="btn-group col-md-12">
            <button type="button" class="btn btn-default dropdown-toggle col-md-12" data-toggle="dropdown">
                Действие <span class="caret"></span>
            </button>
            <ul class="dropdown-menu col-md-12" role="menu">
                <li><a href="#" id="save-device">Сохранить</a></li>
                <li><a href="#" id="add-device">Добавить</a></li>
                <li><a href="#" id="delete-device">Удалить</a></li>
            </ul>
        </div>
        <div class="col-md-12">
            <input id="device-image-file" type="file" class="form-control col-md-12" name="device-image-file">
        </div>
        <div class="col-md-12 text-center device-photo-container">
            <img src="#" id="device-image-file-preview" class="img-thumbnail img-responsive hidden"/>
        </div>
    </div>
</div>