<?php
require 'db.php';
if(isset($_GET['id'])) {
    $pdo->prepare("DELETE FROM etudiants WHERE id=?")->execute([$_GET['id']]); // [cite: 139]
}
header('Location: index.php'); // [cite: 140]
?>