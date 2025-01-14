<?php
$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$nomelibro = $_POST['nomelibro'];
$autore = $_POST['autore'];
$conn = new mysqli('localhost', 'root', '', 'biblioteca');
$stmt = $conn->prepare("Insert into biba(nome, cognome, nomelibro, autore)values(?, ?, ?, ?)");
$stmt->bind_param("ssss", $nome, $cognome, $nomelibro, $autore);
$stmt->execute();
echo "DAJE";
$stmt->close();
$conn->close();
?>