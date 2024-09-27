<?php
// Inclure le fichier de configuration pour TMDb
include_once './../api/tmdb.php';

// Initialiser la variable pour les résultats et la requête
$searchResults = [];
$searchQuery = '';

// Vérifier si une requête de recherche a été soumise
if (isset($_GET['query']) && !empty($_GET['query'])) {
    $searchQuery = htmlspecialchars($_GET['query']);
    $searchResults = searchMovies($searchQuery);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche de Films</title>
    <link rel="stylesheet" href="./../assets/css/styles.css">
</head>
<body>
    <?php include './../includes/header.php'; ?>

    <main>
        <h1 class="page-title">Votre résultat de recherche</h1>

        <?php if (!empty($searchResults['results']) && is_array($searchResults['results'])): ?>
            <div class="movie-list">
                <?php foreach ($searchResults['results'] as $movie): ?>
                    <div class="movie-item">
                        <a href="details.php?id=<?php echo htmlspecialchars($movie['id']); ?>" class="movie-link">
                            <div class="movie-poster-container">
                                <?php if (!empty($movie['poster_path'])): ?>
                                    <img src="https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($movie['poster_path']); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>" class="movie-poster">
                                <?php endif; ?>
                                <div class="movie-info">
                                    <h2 class="movie-title"><?php echo htmlspecialchars($movie['title']); ?></h2>
                                    <p><strong>Date de sortie:</strong> <?php echo htmlspecialchars($movie['release_date']); ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php elseif (isset($_GET['query'])): ?>
            <p class="no-results">Aucun film trouvé pour "<?php echo htmlspecialchars($searchQuery); ?>".</p>
        <?php endif; ?>

    </main>

    <?php include './../includes/footer.php'; ?>
    <style>
        /* Styles pour la page de recherche */
.page-title {
    color: red;
    text-align: center;
    font-size: 2em;
    margin-top: 20px;
}

.movie-list {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.movie-item {
    margin: 10px;
    position: relative;
    text-align: center;
}

.movie-link {
    text-decoration: none;
    color: inherit;
}

.movie-poster-container {
    position: relative;
    display: inline-block;
}

.movie-poster {
    width: 150px;
    height: auto;
    border-radius: 5px;
}

.movie-info {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    opacity: 0;
    transition: opacity 0.3s ease;
    padding: 10px;
    text-align: left;
}

.movie-item:hover .movie-info {
    opacity: 1;
}

.movie-title {
    font-size: 1.2em;
    margin: 10px 0;
}

.movie-release-date {
    font-size: 1em;
}

.no-results {
    color: black;
    font-size: 1.2em;
    text-align: center;
    margin-top: 20px;
}

    </style>
</body>
</html>
