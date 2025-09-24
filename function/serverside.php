<?php
header('Content-Type: application/json');
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
session_start();
$plant = $_SESSION['plant'];
$unitcode = $_SESSION['unitcode'];
include_once 'koneksi.php';
// include_once 'getvalue.php';

$where = "";
$data = [];
$draw   = isset($_POST['draw']) ? intval($_POST['draw']) : 0;
$start  = isset($_POST['start']) ? intval($_POST['start']) : 0;
$length = isset($_POST['length']) ? intval($_POST['length']) : 0;
$searchValue = $_POST['search']['value'] ?? '';
$table = $_POST['prosessimpandataproject'][0] ?? '';
$proses = $_POST['prosessimpandataproject'][1] ?? '';

if ($proses == "reportpengemasan") {
    $totalQuery = $conn->query("SELECT COUNT(*) as T FROM $table");
    $totalData  = $totalQuery->fetch_assoc()['T'];

    if (!empty($searchValue)) {
        $searchValue = $conn->real_escape_string($searchValue);
        $where = "WHERE PlanningNumber LIKE '%$searchValue%' OR Years LIKE '%$searchValue%'";
    }

    $filterQuery = $conn->query("SELECT COUNT(*) AS F FROM $table");
    $totalFiltered = $filterQuery->fetch_assoc()['F'];

    $result = $conn->query("SELECT * FROM $table $where LIMIT $start, $length");
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} elseif ($proses == "reportpengolahan") {
    $totalQuery = $conn->query("SELECT COUNT(*) as T FROM $table");
    $totalData  = $totalQuery->fetch_assoc()['T'];

    if (!empty($searchValue)) {
        $searchValue = $conn->real_escape_string($searchValue);
        $where = "WHERE PlanningNumber LIKE '%$searchValue%' OR Years LIKE '%$searchValue%'";
    }

    $filterQuery = $conn->query("SELECT COUNT(*) AS F FROM $table");
    $totalFiltered = $filterQuery->fetch_assoc()['F'];

    $result = $conn->query("SELECT A.PlanningNumber,
                                    A.Years,
                                    A.ProductID,
                                    A.BatchNumber,
                                    A.CreatedOn,
                                    -- A.CreatedBy,
                                    B.ProductDescriptions FROM $table AS A
                                    INNER JOIN mara_product AS B
                                    ON A.ProductID = B.ProductID $where LIMIT $start, $length");
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} elseif ($proses == "printlabelsample") {
    $totalQuery = $conn->query("SELECT COUNT(*) as T FROM $table");
    $totalData  = $totalQuery->fetch_assoc()['T'];

    if (!empty($searchValue)) {
        $searchValue = $conn->real_escape_string($searchValue);
        $where = "WHERE PlanningNumber LIKE '%$searchValue%' OR Years LIKE '%$searchValue%'";
    }

    $filterQuery = $conn->query("SELECT COUNT(*) AS F FROM $table");
    $totalFiltered = $filterQuery->fetch_assoc()['F'];

    $result = $conn->query("SELECT A.InspectionLot,
                                    A.Lotyears,
                                    A.ProductID,
                                    A.BatchNumber,
                                    A.CreatedOn,
                                    A.PlanningNumber,
                                    A.Years,
                                    A.StatsY,
                                    -- A.CreatedBy,
                                    B.ProductDescriptions FROM $table AS A
                                    INNER JOIN mara_product AS B
                                    ON A.ProductID = B.ProductID $where LIMIT $start, $length");
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} elseif ($proses == "configmenu") {
    $totalQuery = $conn->query("SELECT COUNT(*) as T FROM $table");
    $totalData  = $totalQuery->fetch_assoc()['T'];

    if (!empty($searchValue)) {
        $searchValue = $conn->real_escape_string($searchValue);
        $where = "WHERE Menus LIKE '%$searchValue%' OR Descriptions LIKE '%$searchValue%'";
    }

    $filterQuery = $conn->query("SELECT COUNT(*) AS F FROM $table");
    $totalFiltered = $filterQuery->fetch_assoc()['F'];

    $result = $conn->query("SELECT * FROM $table $where LIMIT $start, $length");
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} elseif ($proses == "prepare_hopper") {
    $totalQuery = $conn->query("SELECT COUNT(*) as T FROM $table");
    $totalData  = $totalQuery->fetch_assoc()['T'];

    if (!empty($searchValue)) {
        $searchValue = $conn->real_escape_string($searchValue);
        $where = "AND (BatchNumber LIKE '%$searchValue%' OR PlanningNumber LIKE '%$searchValue%')";
    }
    $filterQuery = $conn->query("SELECT COUNT(*) AS F FROM $table WHERE Plant='$plant' AND 
                                        UnitCode='$unitcode' AND 
                                        PrepareHoper IS NULL AND 
                                        Approval='X'");
    $totalFiltered = $filterQuery->fetch_assoc()['F'];

    $result = $conn->query("SELECT * FROM $table WHERE Plant='$plant' AND 
                                        UnitCode='$unitcode' AND 
                                        PrepareHoper IS NULL AND 
                                        Approval='X' $where LIMIT $start, $length");
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
echo json_encode([
    "draw" => $draw,
    "recordsTotal" => $totalData,
    "recordsFiltered" => $totalFiltered,
    "data" => $data,
]);
exit;
