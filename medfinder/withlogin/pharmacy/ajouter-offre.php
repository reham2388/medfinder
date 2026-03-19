<?php
header('Content-Type: application/json');

// Connexion à la base de données
$con = mysqli_connect('localhost', 'root', '', 'medfinder');

if (!$con) {
    error_log("Connection failed: " . mysqli_connect_error());
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

// Démarrer la session
session_start();

// Récupération de l'ID du pharmacie connecté à partir de la session
$id_pharmacie = $_SESSION['id_pharmacie'];
// Récupération des données du formulaire
$nom = mysqli_real_escape_string($con, $_POST['nom']);
$prix = floatval($_POST['prix']);
$quantite_disponible = intval($_POST['quantite_disponible']);

mysqli_begin_transaction($con);

try {
    // Vérifier si le médicament existe dans la table medicament
    $sql_check_medicament = "SELECT id_medicament FROM medicament WHERE nom = '$nom'";
    $result_check_medicament = mysqli_query($con, $sql_check_medicament);

    if ($result_check_medicament && mysqli_num_rows($result_check_medicament) > 0) {
        $row_medicament = mysqli_fetch_assoc($result_check_medicament);
        $id_medicament = $row_medicament['id_medicament'];

        // Insertion dans la table recherche
        $sql_insert_recherche = "INSERT INTO proposer (id_medicament, quantite_disponible, id_pharmacie) VALUES ('$id_medicament',  '$quantite_disponible', '$id_pharmacie')";
        if (mysqli_query($con, $sql_insert_recherche)) {
            mysqli_commit($con);
            echo json_encode(['success' => true]);
        } else {
            mysqli_rollback($con);
            error_log("Error inserting into recherche: " . mysqli_error($con));
            echo json_encode(['success' => false, 'message' => 'Error inserting into recherche']);
        }
    } else {
        mysqli_rollback($con);
        echo json_encode(['success' => false, 'message' => 'Medicament not found']);
    }
} catch (Exception $e) {
    mysqli_rollback($con);
    error_log("Exception: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Transaction failed']);
}

mysqli_close($con);
?>
