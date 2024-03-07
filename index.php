<?php
// PDO -> Php Data Object
require_once('db.php');
require_once('user.php');
require_once('db_pdo.php');
$config = require_once('config.php');

use DB\DB_PDO as DB;

$PDOConn = DB::getInstance($config);
$conn = $PDOConn->getConnection(); //Mi connetto

$userDTO = new UserDTO($conn);

if (isset($_REQUEST['firstname'])) {
    $firstname = $_REQUEST['firstname'];
    $lastname = $_REQUEST['lastname'];
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];
    $admin = $_REQUEST['admin'];

    $res = $userDTO->saveUser([
        'firstname' => $firstname,
        'lastname' => $lastname,
        'email' => $email,
        'password' => $password,
        'admin' => $admin
    ]);
}

if (isset($_REQUEST['id']) && $_REQUEST['action'] == 'edit') {
    $firstname = $_REQUEST['firstname'];
    $lastname = $_REQUEST['lastname'];
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];
    $admin = $_REQUEST['admin'];
    $id = intval($_REQUEST['id']);

    echo $id;
    var_dump($firstname);

}

if (isset($_REQUEST['id']) && $_REQUEST['action'] == 'delete') {
    $id = intval($_REQUEST['id']);

    $res = $userDTO->deleteUser($id);

    header('Location: index.php');
    exit;
}

$res = $userDTO->getAll();

// logout
session_start();
if(!isset($_SESSION['userLogin']) && isset($_COOKIE["useremail"]) && isset($_COOKIE["userpassword"])) {
  header('Location: http://localhost/Progetto-settimana-4_back-end/controller.php?email='.$_COOKIE["useremail"].'&password='.$_COOKIE["userpassword"]);
} else if(!isset($_SESSION['userLogin'])) {
  //print_r($_SESSION['userLogin']);
  header('Location: login.php');
} else 
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Progetto Settimana 16</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <header>
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand">PS16</a>
                <form class="d-flex" role="search">
                    <a class="nav-link active ms-3" aria-current="page" href="logout.php">Logout</a>
                </form>
            </div>
        </nav>
    </header>

    <div class="hero d-flex justify-content-center align-items-center flex-column mt-3 mb-5">
        <h1 class="my-3">Admin Dashboard</h1>
        <p class="text-center"> <span class="fw-semibold fs-5">Welcome to Admin Control Panel. </span> <br>Manage and protect sensitive data effectively.<br>Total monitoring, security and control at the click of a button.</p>
        <a href="create.php" class="btn btn-success w-25" data-bs-toggle="modal" data-bs-target="#creaUtente">Aggiungi utenti</a>
    </div>
    
    
    <div class="container">
        <table class="table table-bordered">
            <thead>
                <tr class="table-success">
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Surname</th>
                    <th scope="col">Email</th>
                    <th scope="col">Password</th>
                    <th scope="col">Admin</th>
                    <th scope="col" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>

                <?php
                if ($res) {
                    foreach ($res as $record) {
                        ?>
                        <tr>
                            <td>
                                <?= $record["id"] ?>
                            </td>
                            <td>
                                <?= $record["firstname"] ?>
                            </td>
                            <td>
                                <?= $record["lastname"] ?>
                            </td>
                            <td>
                                <?= $record["email"] ?>
                            </td>
                            <td>
                                <?= $record["password"] ?>
                            </td>
                            <td class="text-center align-middle">
                                <?php if ($record["admin"] == 0): ?>
                                    <p> No </p>
                                <?php else: ?>
                                    <p> Yes </p>
                                <?php endif; ?>
                            </td>
                            <td class="d-flex">
                                <a href="index.php?action=edit&id=<?= $record["id"] ?>" class="btn btn-warning"
                                    data-bs-toggle="modal" data-bs-target="#modificaUtente"><i class="bi bi-pen-fill"></i></a>
                                <a href="index.php?action=delete&id=<?= $record["id"] ?>" class="btn btn-danger ms-2"><i class="bi bi-trash3-fill text-black"></i></a>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>


    <!-- modale per l'aggiunta di un utente -->
    <div class="modal fade" id="creaUtente" tabindex="-1" aria-labelledby="creaUtenteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="creaUtenteLabel">Aggiungi Utente</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="index.php">
                        <div class="mb-3">
                            <label for="firstname" class="form-label">Name</label>
                            <input name="firstname" type="text" class="form-control" id="firstname"
                                aria-describedby="firstname">
                        </div>
                        <div class="mb-3">
                            <label for="lastname" class="form-label">Surname</label>
                            <input name="lastname" type="text" class="form-control" id="lastname"
                                aria-describedby="lastname">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input name="password" type="password" class="form-control" id="password">
                        </div>
                        <div class="mb-3">
                            <label for="admin" class="form-label">Admin</label>
                            <input name="admin" type="number" class="form-control" id="admin" aria-describedby="admin"
                                min="0" max="1">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- modale per la modifica -->
    <div class="modal fade" id="modificaUtente" tabindex="-1" aria-labelledby="modificaUtenteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modificaUtenteLabel">Modifica Utente</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="index.php">
                        <div class="mb-3">
                            <label for="firstname" class="form-label">Name</label>
                            <input name="firstname" type="text" class="form-control" id="firstname"
                                aria-describedby="firstname">
                        </div>
                        <div class="mb-3">
                            <label for="lastname" class="form-label">Surname</label>
                            <input name="lastname" type="text" class="form-control" id="lastname"
                                aria-describedby="lastname">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input name="password" type="password" class="form-control" id="password">
                        </div>
                        <div class="mb-3">
                            <label for="admin" class="form-label">Admin</label>
                            <input name="admin" type="number" class="form-control" id="admin" aria-describedby="admin"
                                min="0" max="1">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <a href="index.php?action=edit&id=<?= $record["id"] ?>" type="submit"
                                class="btn btn-primary">Save changes</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>