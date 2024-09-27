<?php
// Inclure le fichier de configuration pour TMDb
include_once './../api/tmdb.php';

// Obtenir les films récents
$recentMovies = getRecentMovies();

if (!$recentMovies) {
    $recentMovies = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Films Récents</title>
    <link rel="stylesheet" href="./../assets/css/styles.css">
    <style>
        h1{
            color: red;
        }
        main p{
            color: #000;
        }

    </style>
</head>
<body>
    <?php include './../includes/header.php'; ?>

    <main>
        <h1>Films Récents</h1>

        <?php if (!empty($recentMovies['results'])): ?>
            <div class="movie-list">
                <?php foreach ($recentMovies['results'] as $movie): ?>
                    <div class="movie-item">
                        <a href="details.php?id=<?php echo htmlspecialchars($movie['id']); ?>">
                            <?php if (!empty($movie['poster_path'])): ?>
                                <img src="https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($movie['poster_path']); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>">
                            <?php endif; ?>
                            <h2><?php echo htmlspecialchars($movie['title']); ?></h2>
                            <p><strong>Date de sortie:</strong> <?php echo htmlspecialchars($movie['release_date']); ?></p>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Aucun film récent trouvé.</p>
        <?php endif; ?>
    </main>

    <?php include './../includes/footer.php'; ?>
</body>
</html>
