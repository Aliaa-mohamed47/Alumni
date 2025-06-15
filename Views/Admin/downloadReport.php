<?php
session_start();
require_once '../../Controlers/DBControler.php';
require_once '../../Controlers/AdminControler.php';

$dbControler = new DBControler();
$dbControler->openConnection();

$adminControler = new AdminControler($dbControler);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reportType = $_POST['reportType'];
    $format = $_POST['format'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    $adminControler->generateReports($reportType, $startDate, $endDate, $format);
}
exit();
