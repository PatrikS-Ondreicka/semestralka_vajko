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
        <!-- Menu -->
        <nav class="navbar navbar-expand-lg navbar-custom-bg menu-bar">  <div class="container-fluid">
                <a class="navbar-brand" href="#">
                     Weather Site
                </a>

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
                    <?php endif; ?>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <?php if ($auth->isLogged()) :?>
                            <li class="nav-item">
                                <a class="nav-link text-danger" href=<?= $logout_link ?>>Logout</a>
                            </li>
                        <?php endif; ?>
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
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Menu -->

        <!-- Content -->
        <div class="site_content container col-12 col-lg-8 mt-2">
            <?= $contentHTML ?>
        </div>
        <!-- End Content -->
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>