<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'medfinder');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();

// Vérifier si la clé 'email' existe dans $_POST
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT email, password FROM patient WHERE email = ? AND password = ? UNION SELECT email, password FROM pharmacie WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Prepare failed: " . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("ssss", $email, $password, $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result !== false && $result->num_rows > 0) {
        $data = $result->fetch_assoc();

        $sql_patient = "SELECT id_patient FROM patient WHERE email = ?";
        $stmt_patient = $conn->prepare($sql_patient);

        if ($stmt_patient === false) {
            die("Prepare failed: " . htmlspecialchars($conn->error));
        }

        $stmt_patient->bind_param("s", $email);
        $stmt_patient->execute();
        $result_patient = $stmt_patient->get_result();

        if ($result_patient !== false && $result_patient->num_rows > 0) {
            $res = $result_patient->fetch_assoc();
            $_SESSION["id_patient"] = $res['id_patient'];
            $_SESSION["loggedin"] = true;
            $_SESSION["email"] = $email; // Ajout pour stocker l'email dans la session
            header("Location: ./withlogin/patient/patient-index.php");
            exit();
        }

        $sql_pharmacie = "SELECT id_pharmacie FROM pharmacie WHERE email = ?";
        $stmt_pharmacie = $conn->prepare($sql_pharmacie);

        if ($stmt_pharmacie === false) {
            die("Prepare failed: " . htmlspecialchars($conn->error));
        }

        $stmt_pharmacie->bind_param("s", $email);
        $stmt_pharmacie->execute();
        $result_pharmacie = $stmt_pharmacie->get_result();

        if ($result_pharmacie !== false && $result_pharmacie->num_rows > 0) {
            $data = $result_pharmacie->fetch_assoc();
            $_SESSION["id_pharmacie"] = $data['id_pharmacie'];
            $_SESSION["loggedin"] = true;
            $_SESSION["email"] = $email; // Ajout pour stocker l'email dans la session
            header("Location: ./withlogin/pharmacy/pharmacy-index.php");
            exit();
        }
    } 

    echo '<script>
            document.getElementById("errorMsg").classList.remove("d-none");
          </script>';

    $conn->close();
}
?>
