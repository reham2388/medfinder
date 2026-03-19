<?php
session_start();

if (!isset($_SESSION['email'])) {
    // Redirect to login page
    header('Location: login.php');
    exit();
}
?>
<?php
// Connexion à la base de données
$con = mysqli_connect('localhost', 'root', '', 'medfinder');
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}


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


    // Récupérer l'email du patient depuis la session
    $email_patient = $_SESSION['email'];
   // Requête de sélection des médicaments proposés
$sql = "SELECT recherche.id_medicament, recherche.quantite_recherche, medicament.prix, medicament.nom
        FROM medicament
        INNER JOIN recherche ON medicament.id_medicament = recherche.id_medicament";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search']) && !empty($_POST['search'])) {
    $search = $_POST['search'];
    $sql .= " WHERE medicament.nom LIKE '%$search%'";
}

$result = mysqli_query($con, $sql);
?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="description" content="">
  <meta name="author" content="">

  <title>Patient dashboard </title>

  <!-- CSS FILES -->
  <link rel="preconnect" href="https://fonts.googleapis.com">

  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap"
    rel="stylesheet">

  <link href="css/bootstrap.min.css" rel="stylesheet">

  <link href="css/bootstrap-icons.css" rel="stylesheet">

  <link href="css/templatemo-topic-listing.css" rel="stylesheet"> 
  
    <!-- Bootstrap  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

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

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
              <a class="nav-link click-scroll" href="./patient-medicine-offers.php">Medecine Offers</a>
            </li>

            <li class="nav-item">
              <a class="nav-link active" href="./patient-dashboard.php">Dashboard</a>
            </li>



            <li class="nav-item">
              <a class="nav-link" href="./logout.php">logout</a>
              <a href="./logout.php" class="navbar-icon bi-person smoothscroll"></a>
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
                        </div!-->
        </div>
      </div>
    </nav>


    <section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-12 mx-auto">
            <div class="container mt-3">
              <h2 class="text-center mb-4">Patient Dashboard</h2>
              <div class="mb-4">
                <h4>Add a search </h4>
                <button class="btn btn-success" data-bs-toggle="modal" id="submit" data-bs-target="#addOfferModal">Add
                  a search</button>
              </div>
            </div>
            </form>
          </div>
        </div>
      </div>
      </div>



    </section>

    <section>

      <body>



      <section class="d-flex text-center justify-content-center align-items-center">
                <div class="container mt-3">
                <h4>List of my searches</h4>
              </section>


      <table class="table table-striped">
        <thead>
          <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Search quantity</th>
            <th>Operations</th>
          </tr>
        </thead>
        <tbody>
        <?php
    // Connexion à la base de données
    $con = mysqli_connect('localhost', 'root', '', 'medfinder');
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $result = mysqli_query($con, "SELECT recherche.id_recherche, recherche.quantite_recherche, medicament.prix, medicament.nom 
                                  FROM medicament
                                  INNER JOIN recherche ON medicament.id_medicament = recherche.id_medicament");
    while ($row = mysqli_fetch_array($result)) {

        echo '<tr>
                <td>'. $row['nom']. '</td>
                <td>'. $row['prix']. '</td>
                <td>'. $row['quantite_recherche']. '</td>
                <td>
                    <button class="btn btn-primary edit-offer" data-bs-toggle="modal" data-bs-target="#editOfferModal" 
                        data-id="'. $row['id_recherche']. '" data-name="'. $row['nom']. '" 
                        data-price="'. $row['prix']. '" data-quantity="'. $row['quantite_recherche']. '">
                        Edit
                    </button>
                    <button class="btn btn-danger delete-order" data-id="'. $row['id_recherche']. '">delete</button>
                </td>
              </tr>';
    }
?>

        </tbody>
      </table>
    </div>
  </div>
</div>


                
        <?php
        $stmt = mysqli_prepare($con, "SELECT nom, prix FROM medicament");
        if ($stmt) {
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
          $medicament = array();
          while ($row = mysqli_fetch_array($result)) {
            $medicament[] = $row;
          }
        } else {
          echo "Error preparing statement: " . mysqli_error($con);
        }
        ?>
        <!-- Modal Ajouter Offre -->
        <div class="modal" id="addOfferModal" tabindex="-1" aria-labelledby="addOfferModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="addOfferModalLabel">Add a search</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form id="addOfferFormModal">
                  <div class="form-group">
                    <label for="productNameModal">Name</label>
                    <select class="form-control" id="productNameModal" name="productNameModal">
                      <?php
                      foreach ($medicament as $med) {
                        echo '<option value="' . $med['nom'] . '" data-price="' . $med['prix'] . '">' . $med['nom'] . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="productPriceModal">Price</label>
                    <input type="text" class="form-control" id="productPriceModal" name="productPriceModal" required readonly>
                  </div>
                  <div class="form-group">
                    <label for="productQuantityModal">Quantity</label>
                    <input type="number" class="form-control" id="productQuantityModal" name="productQuantityModal"
                      required>
                  </div>
                  <button type="submit" class="btn btn-primary">Add</button>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              </div>
            </div>
          </div>
        </div>


        <!-- Modal Modifier Offre -->
        <div class="modal" id="editOfferModal" tabindex="-1" aria-labelledby="editOfferModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editOfferModalLabel">Edit a search</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form id="editOfferFormModal">
                  <div class="form-group">
                    <label for="editProductNameModal">Name</label>
                    <input type="text" class="form-control" id="editProductNameModal" name="editProductNameModal"
                      required>
                  </div>
                  <div class="form-group">
                    <label for="editProductPriceModal">Price</label>
                    <input type="number" step="any" class="form-control" id="editProductPriceModal"
                      name="editProductPriceModal" required>
                  </div>
                  <div class="form-group">
                    <label for="editProductQuantityModal">Quantity</label>
                    <input type="number" class="form-control" id="editProductQuantityModal"
                      name="editProductQuantityModal" required>
                  </div>
                  <input type="hidden" id="editProductIdModal" name="editProductIdModal">
                  <button type="submit" class="btn btn-primary">Edit</button>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              </div>
            </div>
          </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>


        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

        <!-- JAVASCRIPT FILES -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/jquery.sticky.js"></script>
        <script src="js/click-scroll.js"></script>
        <script src="js/custom.js"></script>

        <script type="module">
          $(document).ready(function () {
            $('#productNameModal').change(function () {
              var selectedOption = $(this).find('option:selected');
              var price = selectedOption.data('price');
              $('#productPriceModal').val(price);
            });

            $('#productNameModal').trigger('change');
            // Écoutez la soumission du formulaire d'ajout
            $("#addOfferFormModal").submit(function (event) {
              event.preventDefault(); // Prevent the form from submitting normally

              // Get form values
              var productName = $("#productNameModal").val();
              var productPrice = $("#productPriceModal").val();
              var productQuantity = $("#productQuantityModal").val();

              // Send data to the server via AJAX
              $.ajax({
                url: "ajouter-recherche.php",
                method: "POST",
                dataType: "json",
                data: {
                  nom: productName,
                  prix: productPrice,
                  quantite_recherche: productQuantity
                },
                success: function (data) {
                  if (data.success) {
                    alert("search added successfully.");
                    location.reload(); // Reload the page to show new data
                  } else {
                    alert("Error adding search. Try Again.");
                  }
                },
                error: function (error) {
                  console.error("Error adding search:", error);
                  alert("Error adding search. Try Again.");
                }
              });
            });

            // Charger les données dans le formulaire de modification
            $(".edit-offer").click(function () {
              var id = $(this).data('id');
              var name = $(this).data('name');
              var price = $(this).data('price');
              var quantity = $(this).data('quantity');

              $("#editProductIdModal").val(id);
              $("#editProductNameModal").val(name);
              $("#editProductPriceModal").val(price);
              $("#editProductQuantityModal").val(quantity);

              // Affichez la modale de modification
              $('#editOfferModal').modal('show');
            });

            // Écoutez la soumission du formulaire de modification
            $("#editOfferFormModal").submit(function (event) {
              event.preventDefault(); // Empêche le formulaire d'être soumis normalement

              // Récupérez les valeurs des champs
              var id = $("#editProductIdModal").val();
              var name = $("#editProductNameModal").val();
              var price = $("#editProductPriceModal").val();
              var quantity = $("#editProductQuantityModal").val();

              // Envoyez les données au serveur via AJAX
              $.ajax({
                url: "modifier-recherche.php",
                method: "POST",
                dataType: "json",
                data: {
                  id: id,
                  nom: name,
                  prix: price,
                  quantite_recherche: quantity
                },
                success: function (data) {
                  if (data.success) {
                    alert("search modified successfully.");
                    location.reload(); // Rechargez la page pour afficher les nouvelles données
                  } else {
                    alert("Error modifying search. Try Again.");
                  }
                },
                error: function (error) {
                  console.error("Error modifying search:", error);
                  alert("Error modifying search. Try Again.");
                }
              });
            });

            $('.delete-order').click(function () {
              var id = $(this).data('id');

              if (confirm("Are you sure you want to delete this order?")) {
                $.ajax({
                  url: 'supprimer-recherche.php',  // Change this to the actual path of your PHP file
                  type: 'POST',
                  data: { id: id },
                  dataType: 'json',
                  success: function (response) {
                    if (response.success) {
                      alert("Order deleted successfully.");
                      location.reload(); // Reload the page or remove the row from the DOM
                    } else {
                      alert("Error: " + response.message);
                    }
                  },
                  error: function (xhr, status, error) {
                    alert("An error occurred: " + xhr.responseText);
                  }
                });
              }
            });
          });

        </script>
      </body>

</html>