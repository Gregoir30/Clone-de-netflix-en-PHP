<?php
// index.php

// Inclure les fichiers nécessaires
include_once './api/tmdb.php';

// Récupérer les films populaires
$popularMovies = getPopularMovies();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Netflix Clone</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <?php include_once './includes/header.php'; ?>
    
    <main>
        <h1>Films Populaires</h1>
        <div class="movies-container">
        <?php if (!empty($popularMovies['results'])): ?>
            <div class="movie-list">
                <?php foreach ($popularMovies['results'] as $movie): ?>
                    <div class="movie_card">
                        <div class="blur_back" style="background-image: url('https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($movie['backdrop_path'] ?? ''); ?>');"></div>
                        <div class="info_section">
                            <div class="movie_header">
                                <?php if (!empty($movie['poster_path'])): ?>
                                    <img class="locandina" src="https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($movie['poster_path']); ?>" alt="<?php echo htmlspecialchars($movie['title'] ?? ''); ?>">
                                <?php endif; ?>
                                <h1><?php echo htmlspecialchars($movie['title'] ?? ''); ?></h1>
                                <h4><?php echo htmlspecialchars($movie['release_date'] ?? ''); ?></h4>
                                <span class="minutes"><?php echo htmlspecialchars($movie['runtime'] ?? 'N/A'); ?> min</span>
                            </div>
                            <div class="movie_desc">
                                <p class="text"><?php echo htmlspecialchars($movie['overview'] ?? ''); ?></p>
                            </div>
                            <div class="details">
                            <a href="./pages/details.php?id=<?php echo $movie['id']; ?>">Voir les détails</a>
                            </div>
                            <!-- <div class="movie_social">
                            <ul>
                            <li><a href="https://facebook.com" class="fab fa-facebook-f" target="_blank"></a></li>
                            <li><a href="https://twitter.com" class="fab fa-twitter" target="_blank"></a></li>
                            <li><a href="https://instagram.com" class="fab fa-instagram" target="_blank"></a></li>
                            </ul>
                            </div> -->
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Aucun film trouvé.</p>
        <?php endif; ?>
    </main>
    
    <?php include_once './includes/footer.php'; ?>
</body>
</html>
