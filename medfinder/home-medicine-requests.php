<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $con = mysqli_connect('localhost', 'root', '', 'medfinder');
    if (!$con) {
        die("Erreur de connexion : " . mysqli_connect_error());
    }

    $id_recherche = mysqli_real_escape_string($con, $_POST['id']);
    $sql_update = "UPDATE recherche SET satisfait = 1 WHERE id_recherche = '$id_recherche'";

    if (mysqli_query($con, $sql_update)) {
        echo 'success';
    } else {
        echo 'error';
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

        <title>Medicine requests page </title>

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
                                <a class="nav-link click-scroll inactive" href="index.php">Home</a>
                            </li>
                            

                            <li class="nav-item">
                                <a class="nav-link active" href="home-medicine-requests.php">Medecine Requests</a>
                            </li>
    
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="home-medicine-offers.php">Medecine Offers</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="index.php">About Us</a>
                            </li>
    
                            
                            <li class="nav-item">
                                <a class="nav-link" href="./login.php">login</a>
                                <a href="./login.php" class="navbar-icon bi-person smoothscroll"></a>
                            </li>


                            <!--li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Pages</a>

                                <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                                    <li><a class="dropdown-item" href="topics-listing.html">Topics Listing</a></li>

                                    <li><a class="dropdown-item" href="contact.html">Contact Form</a></li>
                                </ul>
                            </li>
                        </ul>

                        <div class="d-none d-lg-block">
                            <a href="#top" class="navbar-icon bi-person smoothscroll"></a>
                        </div-->
                    </div>
                </div>
            </nav>
            

            <section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-12 mx-auto">
                            <div class="container mt-3">
                                <h1 id="bold-white-text" class="fs-1 text-center">List of searched medications</h1>   
                                <form method="POST" id="search-form "class="custom-form mt-4 pt-2 mb-lg-0 mb-5" role="search">
                                    <div class="input-group input-group-lg">
                                                    <span class="input-group-text bi-search" id="basic-addon1">
                                                        
                                                    </span>

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
                <th> Searched quantity</th>
            
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
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['nom']) . "</td>";
                    echo "<td>" . $row['prix'] . "</td>";
                    echo "<td>" . $row['quantite_recherche'] . "</td>";
                    echo "<td>";
                   
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='text-center text-danger'>Aucun résultat trouvé</td></tr>";
            }
        } else {
            echo "<tr><td colspan='4' class='text-center text-danger'>Erreur de requête : " . mysqli_error($con) . "</td></tr>";
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
$(document).ready(function() {
    $('.satis-button').click(function() {
        var id_recherche = $(this).data('id');
        $.ajax({
            url: '', // Same page
            type: 'POST',
            data: {id: id_recherche},
            success: function(response) {
                if(response == 'success') {
                    alert('Médicament marqué comme satisfait');
                    location.reload(); // Reload the page to update the table
                } else {
                    alert('Erreur lors de la mise à jour');
                }
            }
        });
    });
});
</script>
            </section>

           

        <!-- JAVASCRIPT FILES -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/jquery.sticky.js"></script>
        <script src="js/click-scroll.js"></script>
        <script src="js/custom.js"></script>

    </body>
</html>
