<?php
/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */
/** @var \App\Core\IAuthenticator $auth */
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
session_start();

use App\Models\User;
use App\Models\Folder;

$user_data = $data['folder_data'];
$folder = $data['folder'];

?>

    <div class="row">
        <div class="col-12 mb-3">
            <h2><?= $folder->getName() ?></h2>
            <p><?= $folder->getDescription() ?></p>
            <?php if ($auth->getLoggedUserId() == $folder->getOwner()): ?>
                <a href="<?= $link->url('folder.folderEdit', ['folder' => $folder->getId()])?>" class="btn btn-primary">Edit Folder</a>
                <a href="<?= $link->url('folder.delete', ['folder' => $folder->getId()])?>" class="btn btn-danger">Delete Folder</a>
            <?php endif; ?>
                <a href="<?= $link->url('folder.exportAsCSV', ['folder' => $folder->getId()])?>" class="btn btn-light">Export as CSV</a>
        </div>
    </div>

<?php foreach  ($user_data as $weather_data):?>
    <div class="data_grid container col-md-9 col-sm-12">
        <div class="data_block container" style="background-color:<?= $folder->getColor(); ?>;">
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
                <?php if ($auth->getLoggedUserId() == $folder->getOwner()): ?>
                <a href="<?= $link->url('folder.remove', ['folder' => $folder->getId(), 'data' => $weather_data->getId()]) ?>"  class="btn">Remove</a>
                <?php endif ?>
                <a href="<?= $link->url('data.detail', ['dataId' => $weather_data->getId()]) ?>"  class="btn">Detail</a>
            </div>
        </div>
    </div>
<?php endforeach;?>