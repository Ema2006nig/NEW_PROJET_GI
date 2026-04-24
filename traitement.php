<?php
require 'db.php'; // [cite: 67]
if(isset($_POST['ajouter'])) {
    $sql = "INSERT INTO etudiants (nom, prenom, filiere_id) VALUES (?, ?, ?)";
    $pdo->prepare($sql)->execute([$_POST['nom'], $_POST['prenom'], $_POST['filiere_id']]);
    header('Location: index.php'); // [cite: 112]
}
if(isset($_POST['modifier'])) {
    $sql = "UPDATE etudiants SET nom=?, prenom=?, filiere_id=? WHERE id=?";
    $pdo->prepare($sql)->execute([$_POST['nom'], $_POST['prenom'], $_POST['filiere_id'], $_POST['id']]);
    header('Location: index.php'); // [cite: 155]
}
?>