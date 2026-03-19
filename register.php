<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Inscription</title>
  <link href="/css/bootstrap.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">
                        
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <link href="css/bootstrap-icons.css" rel="stylesheet">

        <link href="css/templatemo-topic-listing.css" rel="stylesheet">  
  <style>
    body {
      height: 100vh;
      /* Set background image with a doctor theme - Replace 'path/to/your/image.jpg' with your actual image path*/
      background-image: url("./images/registre.jpg"); 
      background-repeat: no-repeat;
      background-position: center;
      background-size: cover;
      display: flex; /* Center boxes horizontally */
      justify-content: center;
      align-items: center;
      background-color: lightblue;
    }

    .box {
      
      width: 190px; /* Adjust width as needed */
      height: 150px; /* Adjust height as needed */
      border-radius: 5px; /* Rectangular box with rounded corners */
      display: flex;
      flex-direction: column; /* Stack content vertically */
      justify-content: center;
      align-items: center;
      margin: 25px;
      background-color:#b8f8f0; /* White background for contrast */
      box-shadow: 0 20px 15px rgba(0, 0, 0, 0.1); /* Optional subtle shadow */
    }

    .box img {
        width: 80px;
        height: 90px;
        border-radius: 0px;
    }  
    

    .box a {
      text-decoration: none;
      color: #212529; /* Text color */
      font-weight: bold;
      
      top: 100%;
      bottom: 100px; /* Place text at the bottom */
      text-align: center; /* Center text horizontally */
    }
  </style>
</head>

<body>


  <div class="box mx-2">

          <a href="./register-medecin.php">
            <!--img src="assets\phar.jpg" alt="Pharmacie" /-->
            
            <img class="style='font-size:24px' " src="./images/pngwing.com.png" alt="Pharmacie" />
            <!--i class="bi bi-hospital-fill"-->
            <p>Pharmacie</p>
            </i>
          </a>
  </div>

        <div class="box mx-2">
          <a href="./register-patient.php" cl>
            
            <img  src="./images/patient.webp" alt="Patient" />
            <p class="style='font-size:24px'">Patient</p>
            
          </a>
        </div>
  <script src="/js/bootstrap.min.js"></script>

</body>

</html>
