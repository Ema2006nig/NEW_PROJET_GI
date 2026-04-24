<?php
// index.php : Page principale [cite: 33, 74]
require 'db.php'; // Inclusion de la connexion PDO [cite: 67]

// 1. Récupérer les filières pour la liste déroulante (Partie 5) [cite: 75, 79]
$filieres = $pdo->query("SELECT * FROM filieres")->fetchAll(PDO::FETCH_ASSOC);

// 2. Récupérer les étudiants avec une jointure (Partie 8) [cite: 120]
$query = "SELECT e.*, f.nom as filiere_nom 
          FROM etudiants e 
          JOIN filieres f ON e.filiere_id = f.id";
$etudiants = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion Étudiants</title>
    <link rel="stylesheet" href="assets/css/style.css"> </head>
<body>
    <div class="container">
        <h2>Ajouter un étudiant</h2>
        <form action="traitement.php" method="POST" id="etudiantForm">
            <input type="text" name="nom" id="nom" placeholder="Nom" required>
            <input type="text" name="prenom" id="prenom" placeholder="Prénom" required>
            
            <select name="filiere_id" id="filiere" required>
                <option value="">Choisir une filière</option>
                <?php foreach($filieres as $f): ?>
                    <option value="<?= $f['id'] ?>"><?= htmlspecialchars($f['nom']) ?></option>
                <?php endforeach; ?>
            </select>
            
            <button type="submit" name="ajouter">Ajouter l'étudiant</button>
        </form>

        <hr>

        <h2>Liste des étudiants</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Filière</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
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
            </tbody>
        </table>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>