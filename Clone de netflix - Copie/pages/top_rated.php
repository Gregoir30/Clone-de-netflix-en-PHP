<?php
// Inclure le fichier de configuration pour TMDb
include_once './../api/tmdb.php';

// Fonction pour obtenir les films les mieux notés
function getTopRatedMovies() {
    $apiKey = '8bce871298dd734807f2cce3b5bc7440'; // Remplacez par votre clé API
    $url = 'https://api.themoviedb.org/3/movie/top_rated?api_key=' . $apiKey . '&language=fr-FR';

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        echo 'Erreur cURL: ' . curl_error($curl);
        return false;
    }

    curl_close($curl);
    return json_decode($response, true);
}

// Récupérer les films les mieux notés
$topRatedMovies = getTopRatedMovies();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Films les Mieux Notés</title>
    <link rel="stylesheet" href="./../assets/css/styles.css">
    <style>
        body {
            color: black;
            font-size: 1.2em;
            text-align: center;
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
        .movie-item img {
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
        .movie-rating {
            font-size: 1em;
            color: gold;
        }
    
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
        <h1>Films les Mieux Notés</h1>

        <?php if (!empty($topRatedMovies['results']) && is_array($topRatedMovies['results'])): ?>
            <div class="movie-list">
                <?php foreach ($topRatedMovies['results'] as $movie): ?>
                    <div class="movie-item">
                        <a href="details.php?id=<?php echo htmlspecialchars($movie['id']); ?>" class="movie-link">
                            <?php if (!empty($movie['poster_path'])): ?>
                                <img src="https://image.tmdb.org/t/p/w500<?php echo htmlspecialchars($movie['poster_path']); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>" class="movie-poster">
                            <?php endif; ?>
                            <div class="movie-info">
                                <h2 class="movie-title"><?php echo htmlspecialchars($movie['title']); ?></h2>
                                <p><strong>Date de sortie:</strong> <?php echo htmlspecialchars($movie['release_date']); ?></p>
                                <p class="movie-rating"><strong>Note:</strong> <?php echo htmlspecialchars($movie['vote_average']); ?>/10</p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Aucun film trouvé.</p>
        <?php endif; ?>

    </main>

    <?php include './../includes/footer.php'; ?>
</body>
</html>
