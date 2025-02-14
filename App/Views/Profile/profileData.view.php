<?php
/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */
/** @var \App\Core\IAuthenticator $auth */
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
session_start();
use App\Models\User;
use App\Models\InFolder;
use App\Models\Folder;

$user_id = $data['user_id'];
$user_data = $data['user_data'];
$folders = $data['folders'];
$errors = $data['errors'];

?>
<div>
    <?php if ($auth->getLoggedUserId() == $user_id): ?>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-center">Create New Folder</h4>
            </div>
            <div class="card-body">
                <form action="<?= $link->url("Folder.create")?>" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description:</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="color" class="form-label">Color:</label>
                        <select class="form-select" id="color" name="color">
                            <option value="#FF6666" style="background-color: #FF6666;"></option>
                            <option value="#66FF66" style="background-color: #66FF66;"></option>
                            <option value="#6666FF" style="background-color: #6666FF;"></option>
                            <option value="#FFFF99" style="background-color: #FFFF99;"></option>
                            <option value="#FF66FF" style="background-color: #FF66FF;"></option>
                            <option value="#66FFFF" style="background-color: #66FFFF;"></option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-plus-circle-fill"></i>Create Folder</button>
                </form>
            </div>
            <div class="card-footer">
                <?php foreach($errors as $error):?>
                <p class="error_message"><?= $error; ?></p>
                <?php endforeach;?>
            </div>
        </div>
    </div>

    <?php endif ?>
    <div class="mt-2">
        <?php foreach  ($folders as $folder):?>
            <div class="col-md-4 mb-4">
                <div class="folder shadow-sm" style="background-color: <?= $folder->getColor(); ?>">
                    <a href="<?= $link->url("profile.profileFolder", ['folder' => $folder->getId()]) ?>">
                        <div class="folder_header">
                            <h5 class="card-title"><?= $folder->getName(); ?></h5>
                        </div>
                        <div class="folder_content">
                            <p class="card-text"><?= $folder->getDescription(); ?></p>
                        </div>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="content-list">
    <h3>Data</h3>
    <?php foreach  ($user_data as $weather_data):?>
        <div class="data_grid container col-md-9 col-sm-12">
            <div class="data_block container">
                <div class="data_block_header">
                    <div class="user_data_block">
                        <div class="value_icon user_icon_bg"></div>
                        <div class="value_block_value"><?= (!is_null(User::getOne($weather_data->getUser()))) ? User::getOne($weather_data->getUser())->getUsername() : "unknown"?></div>
                    </div>

                    <div class="date_time_info_block">
                        <div class="date_data"><?= (new DateTime($weather_data->getDate()))->format('d M Y'); ?></div>
                        <div class="time_data"><?= (new DateTime($weather_data->getDate()))->format('H:i:s'); ?></div>
                    </div>
                </div>
                <div class="user_values">
                    <div class="value_block">
                        <div class="value_icon temp_icon_bg"></div>
                        <div class="value_block_value temp_val_block">
                                        <span class="temp_val">
                                            <?= number_format($weather_data->getTemperature(), 2) ?>
                                        </span>
                            <span class="temp_unit">°C</span>
                        </div>
                    </div>
                    <div class="value_block">
                        <div class="value_icon hum_icon_bg"></div>
                        <div class="value_block_value"><?= $weather_data->getHumidity() ?></div>
                    </div>
                    <div class="value_block">
                        <div class="value_icon wind_icon_bg"></div>
                        <div class="value_block_value speed_val_block">
                                    <span class="ws_val">
                                         <?= number_format($weather_data->getWindSpeed(), 2) ?>
                                    </span>
                            <span class="ws_unit">km/h</span>
                        </div>
                    </div>
                    <div class="value_block">
                        <div class="value_icon wind_arr_icon_bg"></div>
                        <div class="value_block_value"><?= $weather_data->getWindDirection() ?></div>
                    </div>
                    <div class="value_block">
                        <div class="value_icon precip_icon_bg"></div>
                        <div class="value_block_value precip_val_block">
                                        <span class="precip_val">
                                            <?= number_format($weather_data->getPrecipitation(), 2) ?>
                                        </span>
                            <span class="precip_unit">mm</span>
                        </div>
                    </div>
                </div>
                <div>
                    <a href="<?= $link->url('data.detail', ['dataId' => $weather_data->getId()]) ?>"  class="btn"><i class="bi bi-eye-fill"></i>Detail</a>
                    <?php if ($auth->getLoggedUserId() == $weather_data->getUser()): ?>
                    <a href="<?= $link->url('data.deleteData', ['dataId' => $weather_data->getId()]) ?>"  class="btn"><i class="bi bi-trash3-fill"></i>Delete</a>
                    <a href="<?= $link->url('data.dataedit', ['dataId' => $weather_data->getId()]) ?>"  class="btn"><i class="bi bi-pencil-fill"></i>Edit</a>
                    <?php endif; ?>
                </div>
                <div>
                    <?php if ($auth->getLoggedUserId() == $weather_data->getUser() &&
                        count(Folder::getAll("owner = ?", [$auth->getLoggedUserId()])) > count(InFolder::getAll("data = ?", [$weather_data->getId()]))): ?>
                    <form action="<?= $link->url("folder.place", ['data_id' => $weather_data->getId()])?>" method="post" class="d-flex align-items-center">
                        <label for="folder" class="form-label me-2 mb-0">Folder:</label>
                        <select class="form-select form-select-sm" id="folder" name="folder">
                            <?php foreach  ($folders as $folder):?>
                                <?php if (!InFolder::exists($folder->getId(), $weather_data->getId())):?>
                                    <option value="<?= $folder->getId(); ?>"><?= $folder->getName(); ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm ms-2"><i class="bi bi-folder-plus"></i></button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
    let colorSelect = document.getElementById("color");

    colorSelect.onchange = function () {
        colorSelect.style.backgroundColor = colorSelect.value;
    }
</script>