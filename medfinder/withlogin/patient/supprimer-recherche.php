<?php
header('Content-Type: application/json');

$con = mysqli_connect('localhost', 'root', '', 'medfinder');
if (!$con) {
    echo json_encode(["success" => false, "message" => "Database connection failed."]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = mysqli_real_escape_string($con, $_POST['id']);

    $sql = "DELETE FROM recherche WHERE id_recherche='$id'";

    if ($con->query($sql) === TRUE) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Error deleting data."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}

mysqli_close($con);
?>
