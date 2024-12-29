<?php
/** @var \App\Core\LinkGenerator $link */

    use App\Models\Data;
    use App\Models\User;

    $weatherData = Data::getAll();
?>
<div class="container col-md-9 col-sm-12">
    <button class="btn" id="tempChangeButton">°C</button>
    <button class="btn" id="speedChangeButton">km/h</button>
    <button class="btn" id="precipChangeButton">mm</button>
</div>
<?php foreach  ($weatherData as $data):?>
<div class="data_grid container col-md-9 col-sm-12">
    <div class="data_block container">
        <div class="data_block_header">
            <div class="user_data_block">
                <div class="value_icon user_icon_bg"></div>
                <div class="value_block_value"><?= (!is_null(User::getOne($data->getUser()))) ? User::getOne($data->getUser())->getUsername() : "unknown"?></div>
            </div>

            <div class="date_time_info_block">
                <div class="date_data"><?= (new DateTime($data->getDate()))->format('d M Y'); ?></div>
                <div class="time_data"><?= (new DateTime($data->getDate()))->format('H:i:s'); ?></div>
            </div>
        </div>
        <div class="user_values">
            <div class="value_block">
                <div class="value_icon temp_icon_bg"></div>
                <div class="value_block_value temp_val_block">
                    <span class="temp_val">
                        <?= number_format($data->getTemperature(), 2) ?>
                    </span>
                    <span class="temp_unit">
                        °C
                    </span>
                </div>
            </div>
            <div class="value_block">
                <div class="value_icon hum_icon_bg"></div>
                <div class="value_block_value"><?= $data->getHumidity() ?></div>
            </div>
            <div class="value_block">
                <div class="value_icon wind_icon_bg"></div>
                <div class="value_block_value speed_val_block">
                    <span class="ws_val">
                        <?= number_format($data->getWindSpeed(), 2) ?>
                    </span>
                    <span class="ws_unit">
                        km/h
                    </span>
                </div>
            </div>
            <div class="value_block">
                <div class="value_icon wind_arr_icon_bg"></div>
                <div class="value_block_value"><?= $data->getWindDirection() ?></div>
            </div>
            <div class="value_block">
                <div class="value_icon precip_icon_bg"></div>
                <div class="value_block_value precip_val_block">
                    <span class="precip_val">
                        <?= number_format($data->getPrecipitation(), 2) ?>
                    </span>
                    <span class="precip_unit">
                        mm
                    </span>
                </div>
            </div>
        </div>
        <div>
            <a href="<?= $link->url('data.deleteData', ['dataId' => $data->getId()]) ?>"  class="btn">Delete</a>
            <a href="<?= $link->url('data.dataedit', ['dataId' => $data->getId()]) ?>"  class="btn">Edit</a>
        </div>
    </div>
</div>
<?php endforeach;?>

<script src="../../../public/js/unitConversions.js"></script>
