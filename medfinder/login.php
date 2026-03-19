<!DOCTYPE html>
<html>
<head>
<head>
            <meta charset="UTF-8">
            <title>Login Page</title>
            <link href="./css/bootstrap.min-copy.css" rel="stylesheet">
            <link href="./css/login.css" rel="stylesheet">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
            <style>
                 
                 .tiledBackground {
                    background-repeat: no-repeat;
                    background-image: url(./images/login.jpg);
                    background-size: cover;
                    width: -webkit-fill-available;
                    height: max-content;
}

            </style>

</head>
<div class="tiledBackground">
    <body class="img-fluid">


    
           
    
        <section class="vh-100">
            <div class="container-fluid h-custom">
                <div style="padding-top:40px;" class="row d-flex justify-content-center align-items-center">
                <div class="col-md-9 col-lg-6 col-xl-5">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                   
                        <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                            <p class="lead fw-normal mb-0 me-3">Se connecter avec</p>
                            <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-floating mx-1">
                            <i class="bi bi-facebook"></i>
                            </button>
    
                            <button type="button" data-mdb-button-init data-mdb-ripple-init class="tw-btn btn btn-primary btn-floating mx-1">
                            <i class="bi bi-twitter"></i>
                            </button>
    
                            <button type="button" data-mdb-button-init data-mdb-ripple-init class="google-btn btn btn-primary btn-floating mx-1">
                            <i class="bi bi-google"></i>
                            </button>
                        </div>
    
                        <div class="divider d-flex align-items-center my-4">
                            <p class="text-center fw-bold mx-3 mb-0">Ou</p>
                        </div>
                        <form id="loginForm" action="log.php" method="post">
        <!-- Email input -->
        <div data-mdb-input-init class="form-outline mb-4">
            <input type="email" id="email" name="email" class="form-control form-control-lg"
                placeholder="Entrer un email valide" />
            <label class="form-label" for="email">Email</label>
        </div>
    
        <!-- Password input -->
        <div data-mdb-input-init class="form-outline mb-3">
            <input type="password" id="password" name="password" class="form-control form-control-lg"
                placeholder="Entrer mot de passe" />
            <label class="form-label" for="password">Mot de passe</label>
        </div>
    
        <div id="loading" class="mt-3 d-none text-center">
            <p>Loading...</p>
        </div>
        <div id="errorMsg" class="mt-3 alert alert-danger d-none text-center">
            <p>Erreur: Email ou mot de passe invalide.</p>
        </div>
    
        <div class="d-flex justify-content-between align-items-center">
            <!-- Checkbox -->
            <div class="form-check mb-0">
                <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                <label class="form-check-label" for="form2Example3">
                    Se souvenir de moi
                </label>
            </div>
            <a href="#!" class="text-body">Mot de passe oublié?</a>
        </div>
    
        <div class="text-center text-lg-start mt-4 pt-2">
            <button id="loginBtn" type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg"
                style="padding-left: 2.5rem; padding-right: 2.5rem;">Se Connecter</button>
    
            <p class="small fw-bold mt-2 pt-1 mb-0">Vous n'avez pas un compte? <a href="./register.php"
                    class="link-danger">S'inscrire</a></p>
        </div>
    </form>
     
    
                   
                </div>
                </div>
            </div>
        </section>        
    
    </div>
    </body>


    </body>
</div>
</html>

