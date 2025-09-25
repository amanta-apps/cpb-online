<?php
header('Content-Type: application/json');
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
session_start();
$plant = $_SESSION['plant'] ?? 'Uknown';
$unitcode = $_SESSION['unitcode'] ?? 'Unknown';
include_once 'koneksi.php';
// global $conn;
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
} elseif ($proses == "manajemen_stok") {
    $totalQuery = $conn->query("SELECT COUNT(*) as T FROM $table");
    $totalData  = $totalQuery->fetch_assoc()['T'];

    if (!empty($searchValue)) {
        $searchValue = $conn->real_escape_string($searchValue);
        $where = "AND (A.BatchNumber LIKE '%$searchValue%' OR A.PlanningNumber LIKE '%$searchValue%')";
    }
    $filterQuery = $conn->query("SELECT COUNT(*) AS F FROM $table WHERE Plant='$plant' AND 
                                        UnitCode='$unitcode'");
    $totalFiltered = $filterQuery->fetch_assoc()['F'];

    $totalQuantity = 0;
    $result = $conn->query("SELECT A.*,B.ProductDescriptions FROM $table A LEFT JOIN mara_product B ON A.ProductID = B.ProductID WHERE A.Plant='$plant' AND 
                                        A.UnitCode='$unitcode' $where LIMIT $start, $length");
    while ($row = $result->fetch_assoc()) {
        $totalQuantity += $row['Quantity'];
        $data[] = $row;
    }
} elseif ($proses == "stock_house") {
    $totalQuery = $conn->query("SELECT COUNT(*) as T FROM $table");
    $totalData  = $totalQuery->fetch_assoc()['T'];

    if (!empty($searchValue)) {
        $searchValue = $conn->real_escape_string($searchValue);
        $where = "AND (A.BatchNumber LIKE '%$searchValue%' OR A.UnitType LIKE '%$searchValue%')";
    }
    $filterQuery = $conn->query("SELECT COUNT(*) AS F FROM $table WHERE Plant='$plant' AND 
                                        UnitCode='$unitcode'");
    $totalFiltered = $filterQuery->fetch_assoc()['F'];

    $totalQuantity = 0;
    $result = $conn->query("SELECT A.*,B.ProductDescriptions FROM $table A LEFT JOIN mara_product B ON A.ProductID = B.ProductID WHERE A.Plant='$plant' AND 
                                        A.UnitCode='$unitcode' $where LIMIT $start, $length");
    while ($row = $result->fetch_assoc()) {
        $totalQuantity += $row['Quantity'];
        $data[] = $row;
    }
} elseif ($proses == "approval_kaunit") {
    $totalQuery = $conn->query("SELECT COUNT(*) as T FROM $table WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND 
                                                                            (ReviewMG ='' OR ReviewMG is null) AND
                                                                            RekonPillow='X' AND SttsX='REL'");
    $totalData  = $totalQuery->fetch_assoc()['T'];

    if (!empty($searchValue)) {
        $searchValue = $conn->real_escape_string($searchValue);
        $where = "AND (A.PlanningNumber LIKE '%$searchValue%' OR A.BatchNumber LIKE '%$searchValue%' OR A.ProductID LIKE '%$searchValue%')";
    }
    $filterQuery = $conn->query("SELECT COUNT(*) AS F FROM $table WHERE Plant='$plant' AND 
                                                                            UnitCode='$unitcode' AND 
                                                                            (ReviewMG ='' OR ReviewMG is null) AND
                                                                            RekonPillow='X' AND SttsX='REL'
                                                                            ORDER BY CreatedOn ASC");
    $totalFiltered = $filterQuery->fetch_assoc()['F'];

    $result = $conn->query("SELECT A.PlanningNumber,
                                    A.Years,
                                    A.ProductID,
                                    A.BatchNumber,
                                    A.CreatedFor,
                                    A.CreatedOn,
                                    B.EmployeeName FROM $table A LEFT JOIN pa001 B ON A.CreatedFor = B.PersonnelNumber WHERE A.Plant='$plant' AND 
                                                                            A.UnitCode='$unitcode' AND 
                                                                            (A.ReviewMG ='' OR A.ReviewMG is null) AND
                                                                            A.RekonPillow='X' AND A.SttsX='REL'
                                                                            $where  ORDER BY A.CreatedOn DESC LIMIT $start, $length");
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
