<?php
// api/tmdb.php

// Votre clé d'API TMDb
$apiKey = '8bce871298dd734807f2cce3b5bc7440'; // Remplacez par votre clé d'API

// URL de base de l'API TMDb
$baseUrl = 'https://api.themoviedb.org/3/';

// Chemin vers le fichier cacert.pem (assurez-vous que ce chemin est correct)
 $cacertPath = 'C:/certs/cacert.pem'; // Remplacez par le chemin correct vers cacert.pem
//$cacertPath = './../certs/cacert.pem'; // Remplacez par le chemin correct vers cacert.pem

// Fonction pour récupérer des données de l'API TMDb
function fetchFromTMDB($endpoint, $params = []) {
    global $baseUrl, $apiKey, $cacertPath;
    
    // Préparer les paramètres 
    $params['api_key'] = $apiKey;
    
    // Construire l'URL de la requête
    $url = $baseUrl . $endpoint . '?' . http_build_query($params);
    
    // Initialiser la session cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CAINFO, $cacertPath); // Ajout du certificat SSL

    // Exécuter la requête
    $response = curl_exec($ch);
    
    // Vérifier les erreurs cURL
    if (curl_errno($ch)) {
        echo 'Erreur cURL : ' . curl_error($ch);
        curl_close($ch);
        return null;
    }
    
    // Vérifier le code de réponse HTTP
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($httpCode != 200) {
        echo 'Erreur API : Code HTTP ' . $httpCode;
        curl_close($ch);
        return null;
    }
    
    // Fermer la session cURL
    curl_close($ch);
    
    // Retourner la réponse JSON décodée
    return json_decode($response, true);
}

// Fonction pour obtenir les films populaires
function getPopularMovies() {
    return fetchFromTMDB('movie/popular');
}

// Fonction pour obtenir les détails d'un film
function getMovieDetails($movieId) {
    return fetchFromTMDB('movie/' . $movieId);
}

// Fonction pour obtenir les films récents
function getRecentMovies() {
    return fetchFromTMDB('movie/latest', ['language' => 'en-US']);
}

// Fonction pour rechercher des films
function searchMovies($query) {
    return fetchFromTMDB('search/movie', ['query' => $query, 'language' => 'fr-FR']);
}

// Fonction pour obtenir la bande-annonce d'un film
function getMovieTrailer($movie_id) {
    $data = fetchFromTMDB("movie/{$movie_id}/videos", ['language' => 'fr-FR']);

    // Vérifier si $data est bien un tableau et s'il contient des résultats
    if (is_array($data) && isset($data['results'])) {
        foreach ($data['results'] as $video) {
            if ($video['type'] === 'Trailer' && $video['site'] === 'YouTube') {
                // Retourner l'URL YouTube de la bande-annonce
                return [
                    'site' => 'YouTube',
                    'url' => 'https://www.youtube.com/watch?v=' . $video['key']
                ];
            }
        }
    }

    // Si aucune bande-annonce trouvée
    return null;
}
