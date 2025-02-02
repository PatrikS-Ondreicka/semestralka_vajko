<?php
/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */
/** @var \App\Core\IAuthenticator $auth */
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
session_start();
use App\Models\User;

$user_data = $data['user_data'];
$folders = $data['folders'];

?>
<div>
    <?php if ($auth->getLoggedUserId() == $user_data[0]->getUser()): ?>
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
                            <option value="#FF0000" style="background-color: #FF0000;"></option>
                            <option value="#00FF00" style="background-color: #00FF00;"></option>
                            <option value="#0000FF" style="background-color: #0000FF;"></option>
                            <option value="#FFFF00" style="background-color: #FFFF00;"></option>
                            <option value="#FF00FF" style="background-color: #FF00FF;"></option>
                            <option value="#00FFFF" style="background-color: #00FFFF;"></option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Create Folder</button>
                </form>
            </div>
        </div>
    </div>

    <?php endif ?>
    <div class="mt-2">
        <?php foreach  ($folders as $folder):?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm" style="background-color: <?= $folder->getColor(); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $folder->getName(); ?></h5>
                        <p class="card-text"><?= $folder->getDescription(); ?></p>
                        <a href="<?= $link->url("profile.profileFolder", ['folder' => $folder->getId()]) ?>" class="btn btn-primary">View</a>
                    </div>
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
                    <a href="<?= $link->url('data.detail', ['dataId' => $weather_data->getId()]) ?>"  class="btn">Detail</a>
                    <?php if ($auth->getLoggedUserId() == $weather_data->getUser()): ?>
                    <a href="<?= $link->url('data.deleteData', ['dataId' => $weather_data->getId()]) ?>"  class="btn">Delete</a>
                    <a href="<?= $link->url('data.dataedit', ['dataId' => $weather_data->getId()]) ?>"  class="btn">Edit</a>
                    <?php endif; ?>
                </div>
                <div>
                    <?php if ($auth->getLoggedUserId() == $weather_data->getUser()): ?>
                    <form action="<?= $link->url("folder.place", ['data_id' => $weather_data->getId()])?>" method="post" class="d-flex align-items-center">
                        <label for="folder" class="form-label me-2 mb-0">Folder:</label>
                        <select class="form-select form-select-sm" id="folder" name="folder">
                            <?php foreach  ($folders as $folder):?>
                                <option value="<?= $folder->getId(); ?>"><?= $folder->getName(); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm ms-2">Add</button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>