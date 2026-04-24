<?php
require 'db.php';
$e = $pdo->prepare("SELECT * FROM etudiants WHERE id=?")->execute([$_GET['id']]) ? $pdo->prepare("SELECT * FROM etudiants WHERE id=?")->fetch() : null; // [cite: 152]
$filieres = $pdo->query("SELECT * FROM filieres")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr"><head><link rel="stylesheet" href="assets/css/style.css"></head>
<body><div class="container">
    <form action="traitement.php" method="POST">
        <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
        <input type="text" name="nom" value="<?= $e['nom'] ?>" required>
        <input type="text" name="prenom" value="<?= $e['prenom'] ?>" required>
        <select name="filiere_id">
            <?php foreach($filieres as $f): ?>
                <option value="<?= $f['id'] ?>" <?= $f['id']==$e['filiere_id']?'selected':'' ?>><?= $f['nom'] ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" name="modifier">Modifier</button>
    </form>
</div></body></html>