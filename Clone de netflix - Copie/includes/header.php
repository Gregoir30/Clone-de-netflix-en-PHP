<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Clone de Netflix</title>
    
    <!-- Lien vers le fichier CSS -->
    <link rel="stylesheet" href="./../assets/css/styles.css">
    
    <!-- Lien vers Google Fonts (optionnel) -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    
    <!-- Lien vers Font Awesome (pour les icônes, optionnel) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- En-tête principal de la page -->
    <header>
        <div class="container">
            <!-- Logo de l'application -->
            <div class="logo">
                <a href="index.php">
                    <img src="./../assets/images/lojo.jpg" alt="Logo de Netflix Clone">
                </a>
            </div>
            <!-- Barre de navigation -->
            <nav>
                <ul class="nav-links">
                    <li><a href="./../index.php">Accueil</a></li>
                    <li><a href="./../pages/popular.php">Populaires</a></li>
                    <li><a href="./../pages/top_rated.php">Les mieux notés</a></li>
                    <li><a href="./../pages/recent.php">Récents</a></li>
                </ul>
            </nav>
            <!-- Barre de recherche -->
            <div class="search-bar">
                <form action="./../pages/search.php" method="GET">
                    <input type="text" name="query" placeholder="Rechercher un film...">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
    </header>
