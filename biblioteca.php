<?php
// Impostazioni di connessione al database
$servername = "localhost";  // Cambia con il tuo server
$username = "root";         // Cambia con il tuo username
$password = "";             // Cambia con la tua password
$dbname = "biblioteca";     // Nome del database

// Creazione della connessione
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica connessione
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ottieni il nome del libro dalla query string
$nomeLibro = isset($_GET['nomeLibro']) ? $_GET['nomeLibro'] : '';

// Prepara la query per verificare la disponibilità del libro
$sql = "SELECT copie FROM catalogo WHERE nomelibro = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nomeLibro);
$stmt->execute();
$stmt->bind_result($copie);
$stmt->fetch();
$stmt->close();

// Verifica la disponibilità del libro
if ($copie > 0) {
    echo "Il libro '$nomeLibro' è disponibile. Copie disponibili: $copie";
    header("Location: richiesta.html");
} else {
    echo "<script type='text/javascript'>alert('Il libro '$nomeLibro' non è disponibile al momento.');</script>";
    header("Location: error.html");
}

// Chiudi la connessione
$conn->close();
?>
