<?php
$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "member";


$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("連線失敗" . $conn->connect_error);
}else {

}
?>