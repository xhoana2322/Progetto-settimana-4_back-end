<?php

    $db = 'progetto_settimanale_4';
    
    $config = [
        'mysql_host' => 'localhost',
        'mysql_user' => 'root',
        'mysql_password' => ''
    ];

    $mysqli = new mysqli(
        $config['mysql_host'],
        $config['mysql_user'],
        $config['mysql_password']);

    if($mysqli->connect_error) { 
        die('Errore nella creazione del database: ' . $mysqli->error); 
    } 

    // Creo il mio DB
    $sql = 'CREATE DATABASE IF NOT EXISTS ' . $db;
    if(!$mysqli->query($sql)) { 
        die('Errore nella creazione del database: ' . $mysqli->error); 
    }

    // Seleziono il DB
    $sql = 'USE ' . $db;
    $mysqli->query($sql);

    // Creo la tabella
    $sql = 'CREATE TABLE IF NOT EXISTS users ( 
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        firstname VARCHAR(255) NOT NULL, 
        lastname VARCHAR(255) NOT NULL, 
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL 
    )';


    if(!$mysqli->query($sql)) { 
        die('Errore nella creazione del database: ' . $mysqli->error);; 
    }

    // Leggo dati da una tabella
    $sql = 'SELECT * FROM users;';
    $res = $mysqli->query($sql); // return un mysqli result

    if($res->num_rows === 0) { 
        $password = password_hash('Pa$$w0rd!' , PASSWORD_DEFAULT);
        // Inserisco dati in una tabella
         $sql = 'INSERT INTO users (firstname, lastname, email, password) 
            VALUES ("Pdor", "figlio di Kmer", "p.kmer@example.com", "'.$password.'");';

        if(!$mysqli->query($sql)) { 
            echo($mysqli->connect_error); 
        } else { 
            echo 'Record aggiunto con successo!!!';
        }
    }