<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=tp_php;port=3506', 'root', 'root');

$query = "SELECT * FROM movies";
$stmt = $pdo->prepare($query);
$stmt->execute();
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

var_dump($movies);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Martin Mabrut">
    
    <title>TP_PHP_MOVIES</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        
    </style>
</head>
<body class="">

<div class="d-flex flex-column gap-2 align-items-center">
    <div class="d-flex flex-row gap-5">
        <div>
            <p>Name</p>
        </div>
        <div>
            <p>Action</p>
        </div>
    </div>
    <?php foreach($movies as $movie) : ?>
    <div class="d-flex flex-row gap-5">
        <div>
            <p><a href="item.php?id=<?= $movie["movie_id"] ?>"><?= $movie["name"] ?></a></p>
        </div>
        <div>
            <a href="delete-item.php?id=<?= $movie["movie_id"] ?>"><p>Delete</p></a>
            <a href="update-item.php?id=<?= $movie["movie_id"] ?>"><p>Update</p></a>
            <a href="item.php?id=<?= $movie["movie_id"] ?>"><p>Voir</p></a>
        </div>
    </div>
    <?php endforeach; ?>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>