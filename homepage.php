<?php
require_once("../db_connect_mahjong.php");
session_start();

if (isset($_SESSION["user"])) {
    print_r($_SESSION["user"]);
}
