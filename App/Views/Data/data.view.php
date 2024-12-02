<?php
/** @var \App\Core\LinkGenerator $link */

    use App\Models\Data;

    $weatherData = Data::getAll();
?>
<div class="container col-md-9 col-sm-12">
    <button class="btn" id="speedChangeButton">km/h</button>
    <button class="btn" id="tempChangeButton">°C</button>
    <button class="btn" id="precipChangeButton">mm</button>
</div>
<?php foreach  ($weatherData as $data):?>
<div class="data_grid container col-md-9 col-sm-12">
    <div class="data_block container">
        <div class="data_block_header">
            <div class="user_data_block">
                <div class="value_icon user_icon_bg"></div>
                <div class="value_block_value"><?= $data->getUser() ?></div>
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
            <a href="<?= $link->url('data.editData', ['dataId' => $data->getId()]) ?>"  class="btn">Edit</a>
        </div>
    </div>
</div>
<?php endforeach;?>

<script>
    speedButton = document.getElementById("speedChangeButton");
    tempButton = document.getElementById("tempChangeButton");
    precipButton = document.getElementById("precipChangeButton");

    function conversion(button, unit1, unit2, unit1Conversion, unit2Conversion, vb_class, val_class, unit_class) {
        let conversionFormula = unit1Conversion;
        let unitText = unit1;


        if (button.innerHTML == unit1) {
            conversionFormula = unit2Conversion;
            unitText = unit2;
            button.innerHTML = unit2;
        } else {
            button.innerHTML = unit1;
        }
        const speedValBlocks = document.getElementsByClassName(vb_class);
        for (let i = 0; i < speedValBlocks.length; i++) {
            let tempValBlock = speedValBlocks[i];
            let value = tempValBlock.getElementsByClassName(val_class)[0];
            let unit = tempValBlock.getElementsByClassName(unit_class)[0];
            value.innerText = conversionFormula(value.innerText).toFixed(2);
            unit.innerText = unitText
        }
    }

    speedButton.onclick = () => {conversion(speedButton, 'mph', 'km/h',
        (value) => {return value / 1.609;}, (value) => {return value * 1.609;},
        'speed_val_block', 'ws_val', 'ws_unit')};

    tempButton.onclick = () => {conversion(tempButton, '°F', '°C',
        (value) => {return ((value) * 9/5) + 32;}, (value) => {return (value - 32) * (5/9);},
        'temp_val_block', 'temp_val', 'temp_unit')};

    precipButton.onclick = () => {conversion(precipButton, 'in', 'mm',
        (value) => {return value / 25.4;}, (value) => {return value * 25.4;},
        'precip_val_block', 'precip_val', 'precip_unit')};

</script>
