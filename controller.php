<?php

require 'db.php';

session_start();

print_r($_REQUEST);

// Verifico il formato di una email
$regexemail = '/^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$/m';
preg_match_all($regexemail, htmlspecialchars($_REQUEST['email']), $matchesEmail, PREG_SET_ORDER, 0);
$email = $matchesEmail ? htmlspecialchars($_REQUEST['email']) : exit();

// Verifico il formato di una password
$regexPass = '/^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,})\S$/';
preg_match_all($regexPass, htmlspecialchars($_REQUEST['password']), $matchesPass, PREG_SET_ORDER, 0);
$pass = $matchesPass ? htmlspecialchars($_REQUEST['password']) : exit();
//$password = password_hash($pass , PASSWORD_DEFAULT);

// Leggo dati da una tabella
$sql = "SELECT * FROM users WHERE email = '" . $email . "'";
$res = $mysqli->query($sql); // return un mysqli result

if($row = $res->fetch_assoc()) { 
    if(password_verify($pass, $row['password'])){
        $_SESSION['userLogin'] = $row;
        session_write_close();
        // Verifico se durante il login è stata messa la spunto sulla checkbox Remember me
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['error'] = 'Password errata!!!';
        header('Location: login.php');
    }
} else {
    $_SESSION['error'] = 'Email e Password errati!!!';
    header('Location: login.php');
}
