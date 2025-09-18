<?php
header("Content-Type:application/json");
$conn = mysqli_connect('localhost', 'root', 'P@ssw0rd', 'db_sisp');
mysqli_set_charset($conn, 'utf8');
$method = $_SERVER['REQUEST_METHOD'];
$results = [];

if ($method == 'GET') {
    if (!isset($_GET['table'])) {
        $results['Status']['success'] = false;
        $results['Status']['code'] = 400;
        $results['Status']['description'] = 'Request Invalid';
    } else {
        $table = $_GET['table'];
        $limit = $_GET['limit'];
        if ($limit != '') {
            $query = mysqli_query($conn, 'SELECT * FROM ' . $table . ' LIMIT ' . $limit . '');
        } else {
            $query = mysqli_query($conn, 'SELECT * FROM ' . $table . '');
        }
        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $results['Status']['success'] = true;
                $results['Status']['code'] = 200;
                $results['Status']['description'] = 'Request Valid';
                $results[] = $row;
            }
        } else {
            $results['Status']['code'] = 400;
            $results['Status']['description'] = 'Request Invalid';
        }
    }
    echo json_encode($results);
}
