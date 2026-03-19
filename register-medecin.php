[21:14, 23/06/2024] oumaima 🐈: <!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>Medfinder</title>

        <!-- CSS FILES -->        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">
                        
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <link href="css/bootstrap-icons.css" rel="stylesheet">

        <link hr…
[21:14, 23/06/2024] oumaima 🐈: hada f index
[21:14, 23/06/2024] oumaima 🐈: <!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>Register pharmacie Page</title>

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
                                <a class="nav-link click-scroll" href=".\1\index.php">Home</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="./home-medicine-requests.php">Medecine Requests</a>
                            </li>
    
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="./home-medicine-offers.php">Medecine Offers</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="#section_3">About Us</a>
                            </li>
    
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="#section_6">Q&A</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./login.php">login</a>
                                <a href="./login.php" class="navbar-icon bi-person smoothscroll"></a>
                            </li>

                    

                         
                        </ul>

                     
                    </div>
                </div>
            </nav>
            

            <section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-8 col-12 mx-auto">
                            <h1 class="text-white text-center">Register now</h1>


                            
                        </div>

                    </div>
                </div>
            </section>


            

    <section><?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire 
    $email = $_POST['email'];
    $password = $_POST['password'];
    $raison_soc = $_POST['raison_sociale'];
    $adresse = $_POST['address'];
    $telephone = $_POST['telephone'];
  
    

    // Connexion à la base de données
    $conn = new mysqli('localhost', 'root', '', 'medFinder');
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    } else {
        // Préparer et exécuter la requête d'insertion
        $stmt = $conn->prepare("INSERT INTO pharmacie (email, password, raison_soc, adresse , telephone) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $email, $password,$raison_soc,$adresse , $telephone);
        $execval = $stmt->execute();
        echo $execval ? "<div class='alert alert-success'>Successful registration...</div>" : "<div class='alert alert-danger'>Échec de l'inscription...</div>";
        $stmt->close();
        $conn->close();
    }
}
?></section>



       

            <div class="row d-flex justify-content-center">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-5">   </h2>
                    <form method="post" action="">
                        <!-- Email input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label" for="form3Example3"> email</label>
                            <input type="email" name="email" id="form3Example3" class="form-control" required />
                            
                            
                        </div>

                        <!-- Password input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label" for="form3Example4">password </label>
                            <input type="password" name="password" id="form3Example4" class="form-control" required />
                          
                        </div>
                         <!-- Telephone input -->
                         <div data-mdb-input-init class="form-outline mb-4">
                         <label class="form-label" for="form3Example5">Social reason</label>
                            <input type="text" name="raison_sociale" id="form3Example5" class="form-control" required />
                            
                        </div>
                        <!-- Telephone input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label" for="form3Example5">Phone</label>
                            <input type="text" name="telephone" id="form3Example5" class="form-control" required />
                            
                        </div>

                        <!-- Address input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label" for="form3Example6">Adress</label>
                            <input type="text" name="address" id="form3Example6" class="form-control" required />
                            
                        </div>
                         <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <button type="submit" class="btn btn-primary">Sign In</button>
                    </div>
                 </form>
              </div>
        </div>
    </main>




<script src="/js/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

   
        
      
        <!-- JAVASCRIPT FILES -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/jquery.sticky.js"></script>
        <script src="js/click-scroll.js"></script>
        <script src="js/custom.js"></script>

    </body>
</html>
