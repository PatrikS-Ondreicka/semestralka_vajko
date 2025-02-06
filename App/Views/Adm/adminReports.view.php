<?php
/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */

$reports = $data["reports"];
$types = $data["types"];
$usernames = $data["usernames"];

?>

<h3>Reports</h3>

<table class="table admin_table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Data</th>
        <th>User</th>
        <th>Report Type</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($reports as $report): ?>
    <tr>
        <td><?= $report->getId(); ?></td>
        <td><?= $report->getData(); ?></td>
        <td><?= $usernames[$report->getUser()]; ?></td>
        <td><?= $types[$report->getReportsType()]; ?></td>
        <td class="buttons_col">
            <a href="<?= $link->url("data.detail", ["dataId" => $report->getData()]) ?>" class="btn btn-primary btn-sm"><i class="bi bi-eye-fill"></i>View</a>
            <a href="<?= $link->url("report.delete", ["report_id" => $report->getId()]) ?>" class="btn btn-danger btn-sm"><i class="bi bi-trash3-fill"></i>Delete</a>
        </td>
    <tr>
    <?php endforeach; ?>
    </tbody>
</table>