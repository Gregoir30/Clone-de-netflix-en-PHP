<?php
// Inclure le fichier de configuration pour TMDb
include_once './../api/tmdb.php';

// Vérifier si l'ID du film est passé dans les paramètres GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo 'Aucun ID de film spécifié.';
    exit;
}

$movieId = intval($_GET['id']);
$movieDetails = getMovieDetails($movieId);

// Récupérer la bande-annonce du film
$trailer = getMovieTrailer($movieId);

if (!$movieDetails) {
    echo 'Impossible de récupérer les détails du film.';
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Film</title>
    <link rel="stylesheet" href="./../assets/css/styles.css">
    <style>
        .movie-details p {
            color: black;
        }
        h2 {
            color: blue;
        }
        .btn-download, .btn-back {
            display: inline-block;
            margin-top: 1em;
            padding: 0.5em 1em;
            background-color: #5bc0de;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .btn-download:hover, .btn-back:hover {
            background-color: #31b0d5;
        }
        .btn-download {
            background-color: #d9534f;
        }
        .btn-download:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
    <?php include './../includes/header.php'; ?>

    <main>
        <h1>Détails du Film</h1>

        <?php if (isset($movieDetails['title'])): ?>
            <div class="movie-details">
                <h2><?php echo htmlspecialchars($movieDetails['title']); ?></h2>
                
                <p><strong>Date de sortie:</strong> <?php echo htmlspecialchars($movieDetails['release_date']); ?></p>
                <p><strong>Genre:</strong> 
                    <?php
                    $genres = array_map(function($genre) {
                        return htmlspecialchars($genre['name']);
                    }, $movieDetails['genres']);
                    echo implode(', ', $genres);
                    ?>
                </p>
                <p><strong>Note:</strong> <?php echo htmlspecialchars($movieDetails['vote_average']); ?>/10</p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($movieDetails['overview']); ?></p>
                <?php if (!empty($movieDetails['poster_path'])): ?>
                    <img src="https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($movieDetails['poster_path']); ?>" alt="<?php echo htmlspecialchars($movieDetails['title']); ?>">
                <?php endif; ?>
            </div>
        <?php else: ?>
            <p>Aucun détail disponible pour ce film.</p>
        <?php endif; ?>

        <!-- Affichage de la bande-annonce -->
        <?php if ($trailer): ?>
            <h2>Bande-annonce</h2>
            <video width="640" height="360" controls>
                <source src="<?php echo htmlspecialchars($trailer['url']); ?>" type="video/mp4">
                Votre navigateur ne supporte pas la vidéo.
            </video>

            <!-- Bouton de téléchargement -->
            <a href="<?php echo htmlspecialchars($trailer['url']); ?>" download="<?php echo htmlspecialchars($movieDetails['title'] . '-trailer.mp4'); ?>" class="btn-download">
                Télécharger la bande-annonce
            </a>
        <?php else: ?>
            <p>Aucune bande-annonce disponible.</p>
        <?php endif; ?>

        <a href="popular.php" class="btn-back">Retour aux films populaires</a>
    </main>

    <?php include './../includes/footer.php'; ?>
</body>
</html>
