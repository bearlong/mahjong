<?php
require_once("../db_connect.php");

$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    switch ($action) {
        case 'updateRoom':
            if (isset($_POST['room_id']) && isset($_POST['name']) && isset($_POST['tele']) && isset($_POST['address'])) {
                $room_id = $_POST['room_id'];
                $name = $_POST['name'];
                $tele = $_POST['tele'];
                $address = $_POST['address'];

                $sql = "UPDATE mahjong_room SET name=?, tele=?, address=? WHERE room_id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssi", $name, $tele, $address, $room_id);

                if ($stmt->execute()) {
                    $response['status'] = 'success';
                    $response['message'] = 'Room information updated successfully';
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'Error updating room information: ' . $stmt->error;
                }
                $stmt->close();
            }
            break;

        case 'createTable':
            if (isset($_POST['name']) && isset($_POST['price']) && isset($_POST['table_type']) && isset($_POST['status']) && isset($_POST['room_id'])) {
                $name = $_POST['name'];
                $price = $_POST['price'];
                $table_type = $_POST['table_type'];
                $status = $_POST['status'];
                $room_id = $_POST['room_id'];

                $sql = "INSERT INTO mahjong_table (name, price, table_type, status, room_id) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("siiii", $name, $price, $table_type, $status, $room_id);

                if ($stmt->execute()) {
                    $response['status'] = 'success';
                    $response['message'] = 'Table created successfully';
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'Error creating table: ' . $stmt->error;
                }
                $stmt->close();
            }
            break;

        case 'updateTime':
            if (isset($_POST['room_id']) && isset($_POST['new_time'])) {
                $room_id = $_POST['room_id'];
                $new_time = $_POST['new_time'];

                $sql = "UPDATE mahjong_room SET updated_time=? WHERE room_id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $new_time, $room_id);

                if ($stmt->execute()) {
                    $response['status'] = 'success';
                    $response['message'] = 'Time updated successfully';
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'Error updating time: ' . $stmt->error;
                }
                $stmt->close();
            }
            break;

        default:
            $response['status'] = 'error';
            $response['message'] = 'Invalid action';
            break;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'getRoomInfo':
            if (isset($_GET['room_id'])) {
                $room_id = $_GET['room_id'];

                $sql = "SELECT * FROM mahjong_room WHERE room_id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $room_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $response = $result->fetch_assoc();
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'No room found';
                }
                $stmt->close();
            }
            break;

        case 'getTableInfo':
            if (isset($_GET['room_id'])) {
                $room_id = $_GET['room_id'];

                $sql = "SELECT * FROM mahjong_table WHERE room_id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $room_id);
                $stmt->execute();
                $result = $stmt->get_result();

                $tables = [];
                while ($row = $result->fetch_assoc()) {
                    $tables[] = $row;
                }
                $response['status'] = 'success';
                $response['data'] = $tables;
                $stmt->close();
            }
            break;

        default:
            $response['status'] = 'error';
            $response['message'] = 'Invalid action';
            break;
    }
}

$conn->close();
echo json_encode($response);
?>
