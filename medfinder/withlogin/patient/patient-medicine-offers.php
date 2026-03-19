<?php
// Connexion à la base de données
$con = mysqli_connect('localhost', 'root', '', 'medfinder');
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
session_start();

// Fonction pour récupérer l'ID du patient à partir de l'email
function getPatientIdByEmail($con, $email) {
    $sql = "SELECT id_patient FROM patient WHERE email = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row['id_patient'];
    } else {
        return null;
    }
}

// Traitement de la réservation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reserver'])) {
    $id_medicament = $_POST['id_medicament'];
    $quantite_reservation = $_POST['quantite_reservation'];

    // Récupérer l'email du patient depuis la session
    $email_patient = $_SESSION['email'];
    // Récupérer l'ID du patient
    $id_patient = getPatientIdByEmail($con, $email_patient);

    if ($id_patient !== null) {
        $sql = "SELECT quantite_disponible FROM proposer WHERE id_medicament = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $id_medicament);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            $quantite_actuelle = $row['quantite_disponible'];
            $nouvelle_quantite = intval($quantite_actuelle) - intval($quantite_reservation);

            if ($nouvelle_quantite >= 0) {
                $update_sql = "UPDATE proposer SET quantite_disponible = ? WHERE id_medicament = ?";
                $stmt = mysqli_prepare($con, $update_sql);
                mysqli_stmt_bind_param($stmt, 'ii', $nouvelle_quantite, $id_medicament);
                if (mysqli_stmt_execute($stmt)) {
                    $sql_reservation = "INSERT INTO reservation (id_patient, id_medicament, quantite_reservation, date_reservation) VALUES (?, ?, ?, NOW())";
                    $stmt_reservation = mysqli_prepare($con, $sql_reservation);
                    mysqli_stmt_bind_param($stmt_reservation, 'iii', $id_patient, $id_medicament, $quantite_reservation);
                    if (mysqli_stmt_execute($stmt_reservation)) {
                        $_SESSION['message'] = "Reservation successful";
                    } else {
                        $_SESSION['message'] = "Error occurred during reservation: " . mysqli_error($con);
                    }
                } else {
                    $_SESSION['message'] = "Error occurred during updating quantity: " . mysqli_error($con);
                }
            } else {
                $_SESSION['message'] = "Insufficient quantity available";
            }
        } else {
            $_SESSION['message'] = "Medicine not found";
        }
    } else {
        $_SESSION['message'] = "Patient not found";
    }
    header("Location: patient-medicine-offers.php"); // Redirect to the same page to show the message
    exit;
}

// Requête de sélection des médicaments proposés
$sql = "SELECT proposer.id_medicament, proposer.quantite_disponible, medicament.prix, medicament.nom
        FROM medicament
        INNER JOIN proposer ON medicament.id_medicament = proposer.id_medicament";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search']) && !empty($_POST['search'])) {
    $search = $_POST['search'];
    $sql .= " WHERE medicament.nom LIKE '%$search%'";
}

$result = mysqli_query($con, $sql);
?>

<!-- Le reste de votre code HTML reste inchangé -->


<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>Medicine offers page </title>

        <!-- CSS FILES -->        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">
                        
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <link href="css/bootstrap-icons.css" rel="stylesheet">

        <link href="css/templatemo-topic-listing.css" rel="stylesheet">      
<!--

TemplateMo 590 topic listing

https://templatemo.com/tm-590-topic-listing

-->
    </head>
    
    <body id="top">
        <main>
            <nav class="navbar navbar-expand-lg">
                <div class="container">
                    <a class="navbar-brand fs-6" href="index.html">
                        <i class="bi bi-heart-pulse"></i>
                        <span>MEDFINDER</span>
                    </a>

                    <div class="d-lg-none ms-auto me-4">
                        <a href="#top" class="navbar-icon bi-person smoothscroll"></a>
                    </div>
    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
    
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-lg-5 me-lg-auto">
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="#section_4"></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link click-scroll inactive" href="./patient-index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link click-scroll " href="./patient-medicine-requests.php">Medecine Requests</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="./patient-medicine-offers.php">Medecine Offers</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="./patient-dashboard.php">dashboard</a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" href="./logout.php">logout</a>
                                <a href="./logout.php" class="navbar-icon bi-person smoothscroll"></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-12 mx-auto">
                            <div class="container mt-3">
                                <h1 id="bold-white-text" class="fs-1 text-center">search the medications</h1>   
                                <form method="POST" id="search-form" class="custom-form mt-4 pt-2 mb-lg-0 mb-5" role="search">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bi-search" id="basic-addon1"></span>
                                        <input name="search" type="search" class="form-control" id="search" placeholder="search a medecine" aria-label="Search">
                                        <button type="submit" class="form-control">Search</button>
                                    </div>
                                </form> 
                            </div>    
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="container my-5">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Available quantity</th>
                                <th>Reservation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<tr>
                                            <td>' . $row['nom'] . '</td>
                                            <td>' . $row['prix'] . '</td>
                                            <td>' . $row['quantite_disponible'] . '</td>
                                            <td>
                                                <form method="POST" action="">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input type="hidden" name="id_medicament" value="' . $row['id_medicament'] . '">
                                                            <input type="number" class="form-control" step="1" name="quantite_reservation" min="0" max="' . $row['quantite_disponible'] . '">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <button type="submit" class="btn btn-primary float-end" name="reserver">reserve</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </td>
                                          </tr>';
                                }
                            } else {
                                echo '<tr><td colspan="4" class="text-danger">Données non trouvées</td></tr>';
                            }
                            mysqli_close($con);
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Modal HTML -->
                <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="messageModalLabel">Reservation Status</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <?php
                                if (isset($_SESSION['message'])) {
                                    echo $_SESSION['message'];
                                    unset($_SESSION['message']);
                                }
                                ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

                <script>
                    $(document).ready(function() {
                        <?php if (isset($_SESSION['message'])) { ?>
                            $('#messageModal').modal('show');
                        <?php } ?>
                    });
                </script>

                <!-- JAVASCRIPT FILES -->
                <script src="js/jquery.min.js"></script>
                <script src="js/bootstrap.bundle.min.js"></script>
                <script src="js/jquery.sticky.js"></script>
                <script src="js/click-scroll.js"></script>
                <script src="js/custom.js"></script>
            </section>
        </main>
    </body>
</html>
