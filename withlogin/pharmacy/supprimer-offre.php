<?php
header('Content-Type: application/json');

$con = mysqli_connect('localhost', 'root', '', 'medfinder');
if (!$con) {
    echo json_encode(["success" => false, "message" => "Database connection failed."]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'])) {
        $id = mysqli_real_escape_string($con, $_POST['id']);

        $sql = "DELETE FROM proposer WHERE id_proposer='$id'";

        if ($con->query($sql) === TRUE) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Error deleting data: " . $con->error]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "ID not provided."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}

mysqli_close($con);
?>
