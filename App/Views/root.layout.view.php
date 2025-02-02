<?php

/** @var string $contentHTML */
/** @var \App\Core\IAuthenticator $auth */
/** @var \App\Core\LinkGenerator $link */

use App\Models\Profile;
use App\Models\User;

?>
<!DOCTYPE html>
<html lang="sk">

<head>
    <title><?= \App\Config\Configuration::APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <link href="../../public/css/index_style.css" rel="stylesheet">
    <link href="../../public/css/data.css" rel="stylesheet">
    <link href="../../public/css/form_style.css" rel="stylesheet">
    <link href="../../public/css/profile.css" rel="stylesheet">
    <link href="../../public/css/table.css" rel="stylesheet">
    <script src="../../public/js/script.js"></script>
    <script src="https://cdn.plot.ly/plotly-2.35.2.min.js" charset="utf-8"></script>
</head>

<body>
<div class="site_wrapper container">
    <div class="row">
        <h1>Weather site</h1>
        <div class="menu_sidebar container col-12 col-lg-2 mb-1 mb-lg-0">
            <div id="user_info">
                    <?php if ($auth->isLogged()) :
                        $username = $auth->getLoggedUserName();
                        $profile_link = $link->url("profile.profile", ['id' => $auth->getLoggedUserId()]);
                        $logout_link = $link->url("auth.logout"); ?>
                        <a id="profile_link" href=<?= $profile_link ?>>
                            <div id="profile_link_content" class="d-flex align-items-center justify-content-center mt-2">
                                <img class="rounded-circle prof_pic_sm me-2" src="<?= Profile::getAll("`user` = ?", [$auth->getLoggedUserId()])[0]->getProfilePic(); ?>" alt="Profile Picture" width="30" height="30">
                                <span><?= $username ?></span>
                            </div>
                        </a>
                        <a class="text-danger align-content-center" href=<?= $logout_link ?>>Logout</a>
                    <?php endif; ?>
            </div>
            <nav class="site_menu navbar">
                <ul class="navbar-nav">
                    <?php if (!$auth->isLogged()) :
                        $log_link = $link->url("auth.login");
                        $rag_link = $link->url("auth.register"); ?>
                        <li class="nav_item">
                            <a class="nav-link" href=<?= $log_link ?>>Login</a>
                        </li>
                        <li class="nav_item">
                            <a class="nav-link" href=<?= $rag_link ?>>Registration</a>
                        </li>
                    <?php endif; ?>

                    <?php if ($auth->isLogged()) :
                        $dataform_link = $link->url("data.dataform"); ?>
                        <li class="nav_item">
                            <a class="nav-link" href=<?= $dataform_link ?>>Add data</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav_item">
                        <a class="nav-link" href=<?= $link->url("data.data") ?>>View data</a>
                    </li>
                    <li class="nav_item">
                        <a class="nav-link" href=<?= $link->url("data.statistics") ?>>Statistics</a>
                    </li>
                </ul>
            </nav>
                    <?php if ($auth->isLogged() && User::getOne($auth->getLoggedUserId())->getRole() != 0) :
                        $admin_loc_link = $link->url("adm.adminLocations");
                        $admin_data_link = $link->url("adm.adminData");
                        $admin_reports_link = $link->url("adm.adminReports"); ?>
                        <li class="nav_item">
                            <a class="nav-link" href=<?= $admin_loc_link ?>>Admin Locations</a>
                        </li>
                        <li class="nav_item">
                            <a class="nav-link" href=<?= $admin_data_link ?>>Admin Data</a>
                        </li>
                        <li class="nav_item">
                            <a class="nav-link" href=<?= $admin_reports_link ?>>Admin Reports</a>
                        </li>
                    <?php endif; ?>
        </div>

        <div class="site_content col-12 col-lg-8 mb-1">
            <?= $contentHTML ?>
        </div>

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