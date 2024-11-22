<?php

/** @var string $contentHTML */
/** @var \App\Core\IAuthenticator $auth */
/** @var \App\Core\LinkGenerator $link */
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <title><?= \App\Config\Configuration::APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="public/css/index_style.css" rel="stylesheet">
    <link href="public/css/table_style.css" rel="stylesheet">
    <link href="public/css/form_style.css" rel="stylesheet">
    <script src="public/js/script.js"></script>
</head>
<body>
<div class="site_wrapper container">
    <div class="row">
        <!-- Menu sidebar -->
        <h1>Weather site</h1>
        <div class="menu_sidebar container col-12 col-lg-2 mb-1 mb-lg-0">
            <nav class="site_menu navbar">
                <ul class="navbar-nav">
                    <li class="nav_item">
                        <a class="nav-link" href=<?= $link->url("auth.login") ?>>Login</a>
                    </li>
                    <li class="nav_item">
                        <a class="nav-link" href=<?= $link->url("auth.register") ?>>Registration</a>
                    </li>
                    <li class="nav_item">
                        <a class="nav-link" href=<?= $link->url("data.data") ?>>Table prototype</a>
                    </li>
                    <li class="nav_item">
                        <a class="nav-link" href=<?= $link->url("data.dataform") ?>>Add data form prototype</a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Website content -->
        <div class="site_content col-12 col-lg-8 mb-1">
            <?= $contentHTML ?>
        </div>

        <!-- Right sidebar -->
        <div class="right_sidebar container col-12 col-lg-2">
            <div class="local_weather_block">
                <div class="local_weather_header">
                    <h3>Weather in area</h3>
                </div>
                <div class="local_weather_data">
                    <div class="local_weather_data_pair">
                        <div class="temp_icon_bg value_icon"></div>
                        <div class="local_weather_data_value">5.4 °C</div>
                    </div>
                    <div class="local_weather_data_pair">
                        <div class="hum_icon_bg value_icon"></div>
                        <div class="local_weather_data_value">15 %</div>
                    </div>
                    <div class="local_weather_data_pair">
                        <div class="wind_icon_bg value_icon"></div>
                        <div class="local_weather_data_value">4 km/h</div>
                    </div>
                    <div class="local_weather_data_pair">
                        <div class="wind_arr_icon_bg value_icon"></div>
                        <div class="local_weather_data_value">SW</div>
                    </div>
                    <div class="local_weather_data_pair">
                        <div class="precip_icon_bg value_icon"></div>
                        <div class="local_weather_data_value">0 mm</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>

<!---
<nav class="navbar navbar-expand-sm bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= $link->url("home.index") ?>">
            <img src="public/images/vaiicko_logo.png" title="<?= \App\Config\Configuration::APP_NAME ?>"
                 title="<?= \App\Config\Configuration::APP_NAME ?>">
        </a>
        <ul class="navbar-nav me-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?= $link->url("home.contact") ?>">Kontakt</a>
            </li>
        </ul>
        <?php if ($auth->isLogged()) { ?>
            <span class="navbar-text">Prihlásený používateľ: <b><?= $auth->getLoggedUserName() ?></b></span>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= $link->url("auth.logout") ?>">Odhlásenie</a>
                </li>
            </ul>
        <?php } else { ?>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= \App\Config\Configuration::LOGIN_URL ?>">Prihlásenie</a>
                </li>
            </ul>
        <?php } ?>
    </div>
</nav>
<div class="container-fluid mt-3">
    <div class="web-content">
        <?= $contentHTML ?>
    </div>
</div>
--->