// Fonction pour afficher une notification
function showAlert(message, type = 'success', duration = 3000) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.textContent = message;

    // Styles CSS pour les notifications
    alertDiv.style.position = 'fixed';
    alertDiv.style.top = '20px';
    alertDiv.style.right = '20px';
    alertDiv.style.padding = '10px 20px';
    alertDiv.style.borderRadius = '5px';
    alertDiv.style.color = '#fff';
    alertDiv.style.zIndex = '1000';
    alertDiv.style.backgroundColor = type === 'success' ? '#28a745' : '#dc3545';

    document.body.appendChild(alertDiv);

    // Supprimer la notification après la durée spécifiée
    setTimeout(() => {
        alertDiv.remove();
    }, duration);
}

// Confirmation avant la suppression
document.querySelectorAll('a.supprimer').forEach(link => {
    link.addEventListener('click', function (e) {
        e.preventDefault(); // Empêcher le comportement par défaut du lien

        if (confirm("Êtes-vous sûr de vouloir supprimer cet élément ?")) {
            const id = this.getAttribute('data-id'); // Récupérer l'ID depuis l'attribut data-id
            const url = this.getAttribute('href'); // Récupérer l'URL de suppression

            // Envoyer une requête AJAX pour supprimer l'élément
            fetch(url, {
                method: 'GET',
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert("Élément supprimé avec succès !", 'success');
                    window.location.reload(); // Recharger la page pour mettre à jour la liste
                } else {
                    showAlert("Erreur lors de la suppression : " + data.message, 'error');
                }
            })
            .catch(error => {
                console.error("Erreur :", error);
                showAlert("Une erreur s'est produite lors de la suppression.", 'error');
            });
        }
    });
});

// Validation des formulaires
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', (e) => {
        let valid = true;

        form.querySelectorAll('input[required], select[required]').forEach(input => {
            if (!input.value.trim()) {
                valid = false;
                input.style.borderColor = 'red';

                // Afficher un message d'erreur spécifique
                const errorMessage = document.createElement('div');
                errorMessage.className = 'error-message';
                errorMessage.textContent = 'Ce champ est obligatoire.';
                errorMessage.style.color = 'red';
                errorMessage.style.fontSize = '0.9rem';
                input.parentNode.appendChild(errorMessage);
            } else {
                input.style.borderColor = '#ccc';
                const errorMessage = input.parentNode.querySelector('.error-message');
                if (errorMessage) {
                    errorMessage.remove();
                }
            }
        });

        if (!valid) {
            e.preventDefault();
            showAlert('Veuillez remplir tous les champs obligatoires.', 'error');
        }
    });
});

// Mise à jour dynamique du montant total des commandes
document.querySelectorAll('input[name="quantite"], input[name="prix_unitaire"]').forEach(input => {
    input.addEventListener('input', () => {
        const quantite = parseFloat(document.querySelector('input[name="quantite"]').value) || 0;
        const prixUnitaire = parseFloat(document.querySelector('input[name="prix_unitaire"]').value) || 0;

        // Vérifier que les valeurs ne sont pas négatives
        if (quantite < 0 || prixUnitaire < 0) {
            showAlert('Les valeurs ne peuvent pas être négatives.', 'error');
            return;
        }

        const montantTotal = quantite * prixUnitaire;
        document.querySelector('input[name="montant_total"]').value = montantTotal.toFixed(2);
    });
});