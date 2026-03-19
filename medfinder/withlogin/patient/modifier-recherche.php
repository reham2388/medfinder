<?php
header('Content-Type: application/json');
$response = array('success' => false, 'message' => '');

// Connexion à la base de données
$con = mysqli_connect('localhost', 'root', '', 'medfinder');
if (!$con) {
    error_log("Connection failed: " . mysqli_connect_error());
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

// Récupération des données du formulaire
$id = intval($_POST['id']);
$nom = mysqli_real_escape_string($con, $_POST['nom']);
$prix = floatval($_POST['prix']);
 $quantite_recherche = intval($_POST['quantite_recherche']);
    // Début de la transaction
mysqli_begin_transaction($con);
     
        try {
           
                // Mettre à jour la table recherche
                $sql_medicament = "UPDATE medicament SET nom = '$nom', prix = '$prix' WHERE id_medicament = (
                    SELECT id_medicament FROM recherche WHERE id_recherche = '$id'
                )";
                if (mysqli_query($con, $sql_medicament)) {

                $sql_recherche = "UPDATE recherche SET quantite_recherche ='$quantite_recherche'  WHERE id_recherche = '$id'";
                if (mysqli_query($con, $sql_recherche)) {
                    // Validation de la transaction
                    mysqli_commit($con);
                    $response['success'] = true;
                    $response['message'] = 'Modification réussie';
                } else { 
                    // Annulation de la transaction en cas d'erreur
                    mysqli_rollback($con);
                    error_log("Error in recherche update: " . mysqli_error($con));
                    $response['message'] = 'Erreur lors de la mise à jour de la recherche';
                }
            } else {
                // Annulation de la transaction en cas d'erreur
                mysqli_rollback($con);
                error_log("Error in medicament update: " . mysqli_error($con));
                $response['message'] = 'Erreur lors de la mise à jour du médicament';
            }
        } catch (Exception $e) {
            // Annulation de la transaction en cas d'exception
            mysqli_rollback($con);
            error_log("Exception: " . $e->getMessage());
            $response['message'] = 'Transaction échouée';
        }
        
        // Fermeture de la connexion à la base de données
        mysqli_close($con);
        
        echo json_encode($response);
        ?>
        
               