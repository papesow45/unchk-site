<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Redirection si déjà connecté
    if (isset($_SESSION['user_id'])) {
        header('Location: ' . BASE_URL . '/index.php?page=dashboard');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Connexion</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>

            body{
                padding: 0;
                margin: 0;
                background: url('assets/images/uvs.jpg') no-repeat center center fixed;
                height: 100vh;
                background-size: cover;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            a{
                text-decoration: none;
            }

            span{
                width: 40px;
                height: 40px;
                border-radius: 50%;
            }

            span i{
                color: #28a745;
            }

            .login-container{
                background-color: rgba(255, 255, 255, 0.95);
                /* border: 1px solid red; */
                box-shadow: 0 8px 16px rgba(0,0,0,0.2);
                width: 100%;
                max-width: 35%;
                padding: 3% 2%;
                border-radius: 15px;
            }

            .login-container h2{
                margin-bottom: 20px;
                font-weight: 600;
                text-align: center;
            }

            .login-container .form-label{
                font-weight: 600;
            }

            .login-container .form-control{
                border-radius: 10px;
                border: 1px solid #ccc;
                padding: 10px;
            }

            .login-container .btn{
                width: 100%;
                border-radius: 10px;
                margin-top: 20px;
                margin-bottom: 20px;
                background-color: #28a745;
                color: white;
                font-weight: bold;
                cursor: pointer;
                transition: background-color 0.3s;
            }
        </style>
    </head>

    <body onload="noBack();">
        <div class="login-container">

            <span class="d-flex justify-content-center align-items-center rounded-full border p-2">
                <a href="?page=accueil" class="justify-content-center align-items-center">
                    <i class="fa fa-home"></i>
                </a>
            </span>

            <div class="login-header">
                <h2 class="text-success">Connexion</h2>
            </div>

            <form action="?page=login_process" method="POST">
                
                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="alert alert-success">
                        <?php 
                            echo $_SESSION['success_message'];
                            unset($_SESSION['success_message']);
                        ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['login_error'])): ?>
                    <div class="alert alert-danger">
                        <?php 
                            echo $_SESSION['login_error'];
                            unset($_SESSION['login_error']);
                        ?>
                    </div>
                <?php endif; ?>

                <div class="mb-4">
                    <input type="email" class="form-control" id="email" placeholder="Adresse Email" name="email" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control mb-3" id="password" placeholder="Mot de passe" name="password" required>
                    <p><a href="?page=reset-password" >Mot de passe oublié ?</a></p>
                </div>
                
                <button type="submit" class="btn border-0">Connexion</button>
                
                <div class="login-footer d-flex justify-content-center align-items-center">
                    <p>Pas encore de compte ? <a href="?page=register">S'inscrire</a></p>
                </div>
            </form>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Empêcher le retour en arrière
            window.history.forward();
            function noBack() {
                window.history.forward();
            }
        </script>
    </body>

</html>