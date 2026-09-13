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

if (isset($_POST['submit'])) {
    {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=tp_php;port=3506', 'root', 'root');

    $query = "DELETE FROM movies where movie_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':id' => $movie["movie_id"]]);
    header('Location: index.php');
    exit;
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Martin Mabrut">

    <title>Supprimer un film</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5" style="max-width: 500px;">
    <div class="card">
        <div class="card-body">

            <h5 class="card-title">Supprimer un film</h5>

            <form method="post">
                <p>Êtes vous sûr de vouloir supprimer <strong><?= $movie["name"]?></strong> ?</p>

                <div class="d-flex flex-row gap-2">
                    <button type="submit" class="btn btn-danger" name="submit">Oui</button>
                    <a href="index.php" class="btn btn-secondary">Non</a>
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>