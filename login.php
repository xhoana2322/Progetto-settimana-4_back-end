<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<head>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/assets/js/color-modes.js"></script> -->

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - Progetto Settimana 16</title>
    <link  rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <!-- <link href="https://getbootstrap.com/docs/5.3/examples/sign-in/sign-in.css" rel="stylesheet" /> -->
    <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body class="body-login d-flex align-items-center justify-content-center py-4">
    <main class="form-signin w-100 m-auto">
        <form class='form-login' action="controller.php" method="post">
            <h1 class="h3 mb-3 fw-normal text-center">LOGIN</h1>

            <div class="form-input">
                <div class="form-floating">
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email"
                        value="mp@example.com" />
                    <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password"
                        value="Pa$$w0rd!" />
                    <label for="floatingPassword">Password</label>
                </div>
            </div>

            <button class="btn-login btn btn-success w-100 py-2" type="submit">
                Sign in
            </button>
            <?php
            if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger my-3" role="alert">' . $_SESSION['error'] . '</div>';
            }
            ?>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>