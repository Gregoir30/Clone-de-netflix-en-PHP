<?php
// Inclure le fichier de configuration pour les paramètres généraux
// include_once './../api/config.php';

$errors = [];
$successMessage = '';

// Fonction pour envoyer un email
function sendEmail($name, $email, $message) {
    $to = 'your-email@example.com'; // Remplacez par votre adresse email
    $subject = 'Nouveau message de contact';
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $body = "<h2>Nouveau message de contact</h2>";
    $body .= "<p><strong>Nom:</strong> $name</p>";
    $body .= "<p><strong>Email:</strong> $email</p>";
    $body .= "<p><strong>Message:</strong></p>";
    $body .= "<p>$message</p>";

    return mail($to, $subject, $body, $headers);
}

// Fonction pour sauvegarder le message dans un fichier JSON
function saveMessage($name, $email, $message) {
    $file = './../data/contact_messages.json'; // Chemin vers le fichier JSON

    // Lire le contenu actuel du fichier
    $data = [];
    if (file_exists($file)) {
        $data = json_decode(file_get_contents($file), true);
    }

    // Ajouter le nouveau message
    $data[] = [
        'name' => $name,
        'email' => $email,
        'message' => $message,
        'created_at' => date('Y-m-d H:i:s')
    ];

    // Écrire les données mises à jour dans le fichier
    return file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
}

// Traitement du formulaire de contact
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Validation des champs
    if (empty($name)) {
        $errors[] = 'Le nom est requis.';
    }
    if (empty($email)) {
        $errors[] = 'L\'email est requis.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'L\'email n\'est pas valide.';
    }
    if (empty($message)) {
        $errors[] = 'Le message est requis.';
    }

    // Si pas d'erreurs, envoyer l'email et sauvegarder dans le fichier JSON
    if (empty($errors)) {
        if (sendEmail($name, $email, $message) && saveMessage($name, $email, $message)) {
            $successMessage = 'Votre message a été envoyé avec succès.';
        } else {
            $errors[] = 'Une erreur est survenue lors de l\'envoi du message.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactez-Nous</title>
    <link rel="stylesheet" href="./../assets/css/styles.css">
    <style>
        h1{
            color: red;
        }
        .movie-list p{
            color: #000;
        }
    </style>
</head>
<body>
    <?php include './../includes/header.php'; ?>

    <main>
        <h1>Contactez-Nous</h1>

        <?php if (!empty($successMessage)): ?>
            <p class="success-message"><?php echo htmlspecialchars($successMessage); ?></p>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="contact.php" method="post">
            <div class="form-group">
                <label for="name">Nom:</label>
                <input type="text" id="name" name="name" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="6" required><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>
            </div>

            <button type="submit">Envoyer</button>
        </form>

        <section>
            <h2>Nos Coordonnées</h2>
            <p><strong>Adresse:</strong> 123 Rue de Exemple, Ville, Pays</p>
            <p><strong>Téléphone:</strong> +123 456 7890</p>
            <p><strong>Email:</strong> <a href="mailto:contact@example.com">contact@example.com</a></p>
        </section>

        <section>
            <h2>Heures d'Ouverture</h2>
            <ul>
                <li>Lundi - Vendredi: 9h00 - 17h00</li>
                <li>Samedi: 10h00 - 14h00</li>
                <li>Dimanche: Fermé</li>
            </ul>
        </section>
    </main>

    <?php include './../includes/footer.php'; ?>
</body>
<style>
    /* Styles de base pour le formulaire de contact */



main {
    max-width: 800px;
    margin: 2em auto;
    padding: 2em;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    color: #d9534f;
    margin-bottom: 1em;
}

h2 {
    color: #333;
    margin-top: 2em;
}

form {
    display: flex;
    flex-direction: column;
}

.form-group {
    margin-bottom: 1em;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 0.5em;
}

input[type="text"], input[type="email"], textarea {
    width: 100%;
    padding: 0.75em;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type="text"]:focus, input[type="email"]:focus, textarea:focus {
    border-color: #d9534f;
    outline: none;
}

textarea {
    resize: vertical;
}

button {
    background-color: #d9534f;
    color: #fff;
    border: none;
    padding: 0.75em;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1em;
}

button:hover {
    background-color: #c9302c;
}

.success-message {
    color: #5bc0de;
    background-color: #d9edf7;
    border: 1px solid #bce8f1;
    padding: 1em;
    border-radius: 4px;
    margin-bottom: 1em;
}

.error-messages {
    color: #a94442;
    background-color: #f2dede;
    border: 1px solid #ebccd1;
    padding: 1em;
    border-radius: 4px;
    margin-bottom: 1em;
}

.error-messages p {
    margin: 0;
}

/* Section des coordonnées */
section {
    margin-top: 2em;
}

section p {
    margin: 0.5em 0;
}

section a {
    color: #d9534f;
    text-decoration: none;
}

section a:hover {
    text-decoration: underline;
}

ul {
    list-style: none;
    padding: 0;
}

ul li {
    margin: 0.5em 0;
}

</style>
</html>
