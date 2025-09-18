<?php
// $servername = "";
$servername = "19.0.2.244";
$database = $_SESSION['client'];
$username = "root";
$password = "P@ssw0rd";

$conn = mysqli_connect($servername, $username, $password, $database);
$plant = $_SESSION['plant'];
$unitcode = $_SESSION['unitcode'];


$sql = mysqli_query($conn, "SELECT * FROM mapping_timbangan WHERE Plant='$plant' AND UnitCode='$unitcode'");
while ($r = mysqli_fetch_array($sql)) {
    $ip = $r['AddressOf'];
    $port = $r['PortOf'];
    $return = false;

    // Start
    $response = '';
    $ping_modbus = exec('ping -n 1 -w 1 ' . $ip);
    $result_ping = strpos($ping_modbus, 'Packets');
    if ($result_ping != 4) {
        $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die('ERROR');
        $socket_bind = socket_bind($sock, $ip, $port);
        $socket_listen = socket_listen($sock, 1);
        $socket_accept = socket_accept($sock);
        $sock_konek = socket_connect($sock, $ip, $port) or die('ERROR');
        if ($sock_konek === true) {
            socket_set_option($sock, SOL_SOCKET, SO_RCVTIMEO, array("sec" => 1, "usec" => 0));
            $response = socket_read($sock, 2048, MSG_PEEK);
            if ($response === FALSE || strcmp($response, '') == 0) {
                $code = socket_last_error($sock);
                socket_clear_error($sock);
            } else {
                $response_min = $replaced = preg_replace('/\s\s+/', ' ', $response);
                $net = explode(" ", $response_min);
                if ($weight == 'gross') {
                    $jenisberat = $net[0];
                    $berat = $net[1];
                    $satuanberat = $net[2];
                }
                if ($weight == 'tare') {
                    $jenisberat = $net[3];
                    $berat = $net[4];
                    $satuanberat = $net[5];
                }
                if ($weight == 'net') {
                    $jenisberat = $net[6];
                    $berat = $net[7];
                    $satuanberat = $net[8];
                }
                $return = true;
            }
        }
        socket_close($sock);
    }
    mysqli_query($conn, "INSERT INTO tb_temp_timbangan (Plant,UnitCode,AddressOf,Port,Berat) VALUES('$plant','$unitcode','$ip','$port','$berat')");
}
