<?php
// Recupera i dati dal form
$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$telefono = $_POST['telefono'];
$nomelibro = $_POST['nomelibro'];

// Connessione al database
$conn = new mysqli('localhost', 'root', '', 'biblioteca');

// Controlla la connessione
if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->connect_error);
}

// Prepara lo statement
$stmt = $conn->prepare("INSERT INTO prenotazioni (nome, cognome, telefono, nomelibro) VALUES (?, ?, ?, ?)");
if (!$stmt) {
    die("Errore nella preparazione dello statement: " . $conn->error);
}

// Associa i parametri
$stmt->bind_param("ssss", $nome, $cognome, $telefono, $nomelibro);

// Esegui lo statement
if ($stmt->execute()) {
    echo "Richiesta registrata con successo. ";
} else {
    echo "Errore durante l'inserimento della richiesta: " . $stmt->error;
}

// Decrementa il campo 'quantita' di 1
$query = "UPDATE catalogo SET copie = copie - 1 WHERE nomelibro = ?";

// Prepara la query
$stmt = $conn->prepare($query);

// Lega il parametro (nome del libro)
$stmt->bind_param("s", $nomelibro);

// Esegui la query
if ($stmt->execute()) {
    echo "Quantità aggiornata con successo!";
} else {
    echo "Errore durante l'aggiornamento: " . $stmt->error;
}

// Chiudi lo statement e la connessione
$stmt->close();
$conn->close();
?>
