<?php
session_start();
require 'db.php';

// Generate a simple CSRF token (store in session once per session)
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// If the student ID is invalid, redirect back
if ($id <= 0) {
    header('Location: index.php');
    exit;
}

// Fetch student name for the confirmation message
$stmt = $pdo->prepare("SELECT nom, email FROM etudiants WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch();

if (!$student) {
    header('Location: index.php');
    exit;
}

// If POST request with valid token, perform deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token');
    }
    
    if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
        $pdo->prepare("DELETE FROM etudiants WHERE id = ?")->execute([$id]);
    }
    
    // Regenerate CSRF token after successful action
    unset($_SESSION['csrf_token']);
    header('Location: index.php');
    exit;
}

// Otherwise show the confirmation page
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmer la suppression</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container" style="max-width: 500px; text-align: center;">
        <h2>Confirmer la suppression</h2>
        <p style="font-size: 1.1rem; margin: 2rem 0;">
            Voulez-vous vraiment supprimer l'étudiant 
            <strong><?= htmlspecialchars($student['nom']) ?></strong> 
            (<?= htmlspecialchars($student['email']) ?>) ?
        </p>
        
        <form method="post" style="display: flex; gap: 1rem; justify-content: center; background: none; padding: 0; box-shadow: none; border: none;">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <button type="submit" name="confirm" value="yes" style="background: #dc2626;">
                Supprimer définitivement
            </button>
            <a href="index.php" class="btn-edit" style="padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600; background: #e2e8f0; color: #475569;">
                Annuler
            </a>
        </form>
    </div>
</body>
</html>
<?php
exit;