<?php
/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */
/** @var \App\Core\IAuthenticator $auth */

use App\Models\User;
use App\Models\Folder;

$user_data = $data['user_data'];
$folders = $data['folders'];

?>
<div>
    <div class="container mt-5">
        <form action="<?= $link->url("Folder.create")?>" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>

            <div class="mb-3">
                <label for="color" class="form-label">Color:</label>
                <select class="form-select" id="color" name="color">
                    <option value="#FF0000">Red</option>
                    <option value="#00FF00">Green</option>
                    <option value="#0000FF">Blue</option>
                    <option value="#FFFF00">Yellow</option>
                    <option value="#FF00FF">Magenta</option>
                    <option value="#00FFFF">Cyan</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Create Folder</button>
        </form>
    </div>

    <?php foreach  ($folders as $folder):?>
        <div class="folder-card" style="background-color: <?= $folder->getColor(); ?>">
            <div class="folder-header">
                <h2 class="folder-name"><?= $folder->getName(); ?></h2>
            </div>
            <div class="folder-body">
                <p class="folder-description"><?= $folder->getDescription(); ?></p>
            </div>
        </div>
    <?php endforeach; ?>
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
                    <a href="<?= $link->url('data.deleteData', ['dataId' => $weather_data->getId()]) ?>"  class="btn">Delete</a>
                    <a href="<?= $link->url('data.dataedit', ['dataId' => $weather_data->getId()]) ?>"  class="btn">Edit</a>
                    <a href="<?= $link->url('data.detail', ['dataId' => $weather_data->getId()]) ?>"  class="btn">Detail</a>
                </div>
                <div>
                    <form action="<?= $link->url("Folder.place", ['folder_id' => $folder->getId(), 'data_id' => $weather_data->getId()])?>" method="post">
                        <div class="mb-3">
                            <label for="color" class="form-label">Color:</label>
                            <select class="form-select" id="color" name="color">
                                <?php foreach  ($folders as $folder):?>
                                    <option value="<?= $folder->getId(); ?>"><?= $folder->getName(); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Add to folder</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <p>No content has been created yet.</p>
</div>