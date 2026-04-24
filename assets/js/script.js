// script.js : Validation et interactions [cite: 39, 93]
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    
    // Validation avant envoi [cite: 94, 97]
    if (form) {
        form.addEventListener('submit', (e) => {
            const nom = document.getElementById('nom').value.trim();
            const prenom = document.getElementById('prenom').value.trim();
            
            if (!nom || !prenom) {
                e.preventDefault();
                alert("Veuillez remplir le nom et le prénom ! [cite: 98]");
            }
        });
    }
});

// Confirmation avant suppression [cite: 144]
function confirmerSuppression(id) {
    if (confirm("Supprimer cet étudiant ? Cette action est irréversible.")) {
        window.location.href = `delete.php?id=${id}`;
    }
}