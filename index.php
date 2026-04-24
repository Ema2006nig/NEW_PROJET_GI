<?php
// index.php : Page principale (Formulaire + Affichage)
require 'db.php'; // 1. Connexion à la base

// 2. Récupérer les filières pour alimenter la liste déroulante (Partie 5)
$stmtFiliere = $pdo->query("SELECT * FROM filieres");
$filieres = $stmtFiliere->fetchAll(PDO::FETCH_ASSOC);

// 3. Récupérer les étudiants avec le nom de leur filière grâce à une JOINTURE (Partie 8)
$query = "SELECT e.id, e.nom, e.prenom, f.nom AS filiere_nom 
          FROM etudiants e 
          JOIN filieres f ON e.filiere_id = f.id";
$stmtEtudiants = $pdo->query($query);
$etudiants = $stmtEtudiants->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Étudiants</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Ajouter un étudiant</h2>
        <form action="traitement.php" method="POST">
            <input type="text" id="nom" name="nom" placeholder="Nom" required>
            <input type="text" id="prenom" name="prenom" placeholder="Prénom" required>
            
            <select name="filiere_id" required>
                <option value="">-- Choisir une filière --</option>
                <?php foreach($filieres as $f): ?>
                    <option value="<?= $f['id'] ?>"><?= htmlspecialchars($f['nom']) ?></option>
                <?php endforeach; ?>
            </select>
            
            <button type="submit" name="ajouter">Ajouter</button>
        </form>

        <h2>Liste des étudiants</h2>
        <table>
            <tr><th>Nom</th><th>Prénom</th><th>Filière</th><th>Actions</th></tr>
            <?php foreach($etudiants as $e): ?>
            <tr>
                <td><?= htmlspecialchars($e['nom']) ?></td>
                <td><?= htmlspecialchars($e['prenom']) ?></td>
                <td><?= htmlspecialchars($e['filiere_nom']) ?></td>
                <td>
                    <a href="update.php?id=<?= $e['id'] ?>">Modifier</a> | 
                    <a href="#" onclick="confirmerSuppression(<?= $e['id'] ?>)">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <script src="assets/js/script.js"></script>
</body>
</html>