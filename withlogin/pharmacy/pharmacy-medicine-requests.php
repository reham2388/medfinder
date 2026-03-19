<?php
session_start();

if (!isset($_SESSION['email'])) {
    // Redirect to login page
    header('Location: login.php');
    exit();
}
?>
<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $con = mysqli_connect('localhost', 'root', '', 'medfinder');
    if (!$con) {
        die("Erreur de connexion : " . mysqli_connect_error());
    }

    $id_recherche = mysqli_real_escape_string($con, $_POST['id']);
    $id_pharmacie = $_SESSION['id_pharmacie'];

    // Log the data for debugging
    error_log("Updating recherche with id_recherche: $id_recherche, id_pharmacie: $id_pharmacie");

    $sql_update = "UPDATE recherche SET satisfait = 1, id_pharmacie = '$id_pharmacie' WHERE id_recherche = '$id_recherche'";

    if (mysqli_query($con, $sql_update)) {
        echo 'success';
    } else {
        // Output detailed error message
        $error_message = mysqli_error($con);
        echo "error: $error_message";
        error_log("Error updating recherche with id_recherche: $id_recherche, id_pharmacie: $id_pharmacie. MySQL Error: $error_message");
    }
    mysqli_close($con);
    exit;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>Medicine requests page</title>

    <!-- CSS FILES -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-topic-listing.css" rel="stylesheet">
</head>

<body id="top">

<main>
<nav class="navbar navbar-expand-lg">
                <div class="container">
                    <a class="navbar-brand fs-6" href="index.html">
                        <i class="bi bi-heart-pulse" ></i>
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
                                <a class="nav-link click-scroll inactive" href="./pharmacy-index.php">Home</a>
                            </li>
                            

                            <li class="nav-item">
                                <a class="nav-link active" href="./pharmacy-medicine-requests.php">Medecine Requests</a>
                            </li>
    
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="./pharmacy-medicine-offers.php">Medecine Offers</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="./pharmacy-dashboard.php">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./logout.php">logout</a>
                                <a href="./logout.php" class="navbar-icon bi-person smoothscroll"></a>
                            </li>


                            
                    </div>
                </div>
            </nav>
            

    <section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12 mx-auto">
                    <div class="container mt-3">
                        <h1 id="bold-white-text" class="fs-1 text-center">List of searched medications</h1>
                        <form method="POST" id="search-form" class="custom-form mt-4 pt-2 mb-lg-0 mb-5" role="search">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bi-search" id="basic-addon1"></span>
                                <input name="search" type="search" class="form-control" id="search" placeholder="Search a medicine" aria-label="Search">
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
                        <th> Searched quantity </th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
        $con = mysqli_connect('localhost', 'root', '', 'medfinder');
        if (!$con) {
            die("Erreur de connexion : " . mysqli_connect_error());
        }

        $searchKey = "";
        if (isset($_POST['search'])) {
            $searchKey = mysqli_real_escape_string($con, $_POST['search']);
            $sql = "SELECT recherche.id_recherche, recherche.quantite_recherche, medicament.prix, medicament.nom, recherche.satisfait
                    FROM medicament 
                    INNER JOIN recherche ON medicament.id_medicament = recherche.id_medicament 
                    WHERE medicament.nom LIKE '%$searchKey%'";
        } else {
            $sql = "SELECT recherche.id_recherche, recherche.quantite_recherche, medicament.prix, medicament.nom, recherche.satisfait
                    FROM medicament 
                    INNER JOIN recherche ON medicament.id_medicament = recherche.id_medicament";
        }

        $result = mysqli_query($con, $sql);
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>
                            <td>' . $row['nom'] . '</td>
                            <td>' . $row['prix'] . '</td>
                            <td>' . $row['quantite_recherche'] . '</td>
                            <td>
                                <button class="btn btn-primary" onclick="updateStatus(' . $row['id_recherche'] . ')"';
                    if ($row['satisfait'] == 1) {
                        echo ' disabled';
                    }
                    echo '>';
                    echo ($row['satisfait'] == 1) ? 'satisfied' : 'satisfy';
                    echo '</button>
                            </td>
                          </tr>';
                }
            } else {
                echo '<tr><td colspan="4">Aucune donnée trouvée</td></tr>';
            }
        } else {
            echo '<tr><td colspan="4">Erreur de requête : ' . mysqli_error($con) . '</td></tr>';
            error_log("Erreur de requête : " . mysqli_error($con));
        }

        mysqli_close($con);
        ?>
                </tbody>
            </table>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        
        <script>
   function updateStatus(id_recherche) {
    if (confirm('Are you sure you want to satisfy this search?')) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', ' pharmacy-medicine-requests.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                if (xhr.responseText == 'success') {
                    location.reload();
                } else {
                    alert('Erreur lors de la mise à jour de l\'état: ' + xhr.responseText);
                }
            }
        };
        xhr.send('id=' + id_recherche);
    }
}

</script>
</section>
</main>

<!-- JAVASCRIPT FILES -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/jquery.sticky.js"></script>
<script src="js/click-scroll.js"></script>
<script src="js/custom.js"></script>

</body>
</html>
