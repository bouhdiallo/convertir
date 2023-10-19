
<?php
// Démarrer la session (si elle n'est pas déjà démarrée)
if (!isset($_SESSION)) {
    session_start();
}

// Initialisation de l'historique (vide au départ ou récupéré de la session)
if (!isset($_SESSION['conversionHistory'])) {
    $_SESSION['conversionHistory'] = [];
}

if(isset($_POST['convertissez'])) {
    // Récupérez le montant en FCFA depuis le formulaire
    $amountInFCFA = $_POST['montant'];

    // Vérifiez si le montant est numérique et positif
    if (is_numeric($amountInFCFA) && $amountInFCFA >= 0) {
        // Define the exchange rate
        $exchangeRate = 0.00153; // Remplacez par le taux de change actuel

        // Effectuez la conversion
        $amountInEuro = $amountInFCFA * $exchangeRate;

        // Assurez-vous d'assigner la valeur correctement à $_POST["resultat"]
        $_POST['resultat'] = $amountInEuro;

        // Ajoutez la conversion à l'historique
        $_SESSION['conversionHistory'][] = [
            'date' => date("Y-m-d"),
            'montant_fcfa' => $amountInFCFA,
            'montant_euro' => $amountInEuro
        ];
    } else {
        // Si le montant n'est pas valide, réinitialisez la valeur de $_POST["resultat"] à vide
        $_POST['resultat'] = '';
        
        // Affichez un message d'erreur
        echo "Erreur : Veuillez entrer un montant valide en FCFA.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convertisseur FCFA vers Euro</title>
</head>
<body>
    <form method="post" action="">
        <div class="formulaire">
            <div>
                <label for="fcfa" class="fcfa">Montant en FCFA</label>
                <input type="text" id="fcfa" name="montant">
            </div>
            <div>
                <button class="btn" type="submit" name="convertissez">Convertir</button>
            </div>
            <div>
                <label for="euro" class="euro">Résultat en Euro</label>
                <input type="text" id="euro" name="resultat" value="<?php echo isset($_POST['resultat']) ? $_POST['resultat'] : ''; ?>">
            </div>
        </div>
    </form>

    <!-- Affichage de l'historique de toutes les conversions -->
    <h2>Historique de toutes les conversions</h2>
    <ul>
        <?php foreach ($_SESSION['conversionHistory'] as $conversion): ?>
            <li>Date : <?php echo $conversion['date']; ?></li>
            <ul>
                <li>Montant en FCFA : <?php echo $conversion['montant_fcfa']; ?></li>
                <li>Montant en Euro : <?php echo $conversion['montant_euro']; ?></li>
            </ul>
        <?php endforeach; ?>
    </ul>
</body>
</html>

