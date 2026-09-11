<?php
if(!isset($_GET['id'])){
    header('Location: index.php');
    exit;
}

$pdo = new PDO('mysql:host=127.0.0.1;dbname=tp_php;port=3506', 'root', 'root');

$id = $_GET['id'];

$query = "SELECT * FROM movies WHERE movie_id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute([':id' => $id]);
$movie = $stmt->fetch(PDO::FETCH_ASSOC);
var_dump($movie);

$queryGenre = "SELECT label FROM genres WHERE genre_id = :genre_id";
$stmt = $pdo->prepare($queryGenre);
$stmt->execute([':genre_id' => $movie["genre_id"]]);
$genre = $stmt->fetch(PDO::FETCH_ASSOC);
var_dump($genre);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Martin Mabrut">
    
    <title>TP_PHP_MOVIES_<?= $movie["name"] ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        
    </style>
</head>
<body class="">
    <div class="container">
        <div class="row g-3">
            <div class="col-md-4">
                <div>
                    <img src="<?= $movie["image_url"] ?>"/>
                </div>
                <div>
                    <p><?= $movie["rating"] ?> / 5</p>
                </div>
                <div>
                    <p><?= $genre["label"]?></p>
                </div>
            </div>
            <div class="col-md-8">
                <div>
                    <h1><?= $movie["name"] ?></h1>
                </div>
                <div>
                    <p><?= $movie["synopsis"]?></p>
                </div>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>