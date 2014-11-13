<div class="col-md-12 devices-lists">
    <div class="col-md-4">
        <div class="page-header">Разделы</div>
        <ul class="nav nav-pills nav-stacked device-types-list">
            <?php
                $first = true;
                foreach($deviceTypes as $deviceType)
                {
                    echo '<li'.(($first) ? ' class="bg-info"' : '').'><i class="fa fa-arrow-down move down"></i><i class="fa fa-arrow-up move up"></i><span device-type-id="'.$deviceType->id.'" class="device-type-li">'.$deviceType->name.'</span></li>';
                    $first = false;
                }

            ?>
        </ul>
        <form id="device-type-form">
            <input type="text" id="device-type-input" name="value" class="form-control" value="<?=(isset($deviceTypes[0]) ? $deviceTypes[0]->name : '');?>"/>
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
                <input id="device-type-icon-file" name="DeviceType[icon_file]" type="file" class="form-control col-md-12">
            </div>
            <input type="hidden" id="deviceTypeIdHidden" name="id" value="<?=(isset($deviceTypes[0]) ? $deviceTypes[0]->getPrimaryKey() : '');?>"/>
            <input type="hidden" name="action" value="deviceType"/>
        </form>
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
                    echo '<li'.(($first) ? ' class="bg-info"' : '').'><i class="fa fa-arrow-down move down"></i><i class="fa fa-arrow-up move up"></i><span manufacturer-id="'.$manufacturer->id.'" class="manufacturer-li">'.$manufacturer->name.'</span></li>';
                    $first = false;
                }
            ?>
        </ul>
        <input type="text" id="manufacturer-input" class="form-control" value="<?=(isset($manufacturers[0]) ? $manufacturers[0]->name : '');?>"/>
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
                    echo '<li'.(($first) ? ' class="bg-info"' : '').'><i class="fa fa-arrow-down move down"></i><i class="fa fa-arrow-up move up"></i><span device-id="'.$device->id.'" class="device-li">'.$device->name.'</span></li>';
                    $first = false;
                }
            ?>
        </ul>
        <form id="device-form">
            <input type="text" id="device-input" class="form-control" name="value" value="<?=(isset($devices[0]) ? $devices[0]->name : '');?>"/>
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
                <input id="device-image-file" name="Device[image_file]" type="file" class="form-control col-md-12">
            </div>
            <input type="hidden" name="action" value="device"/>
            <input type="hidden" name="deviceTypeId" value="<?=(isset($deviceTypes[0]) ? $deviceTypes[0]->getPrimaryKey() : '');?>"/>
            <input type="hidden" name="manufacturerId" value="<?=(isset($manufacturers[0]) ? $manufacturers[0]->getPrimaryKey() : '');?>"/>
            <input type="hidden" id="deviceIdHidden" name="id" value="<?=(isset($devices[0]) ? $devices[0]->getPrimaryKey() : '');?>"/>
        </form>
        <div class="col-md-12 text-center device-photo-container">
            <img src="#" id="device-image-file-preview" class="img-thumbnail img-responsive hidden"/>
        </div>
    </div>
</div>