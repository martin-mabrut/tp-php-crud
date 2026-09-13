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

$queryGenres = "SELECT * FROM genres";
$stmt = $pdo->prepare($queryGenres);
$stmt->execute();
$genres = $stmt->fetchAll(PDO::FETCH_ASSOC);

$erreur = "";

if (isset($_POST['submit'])) {


    $name = $_POST['name'];
    $synopsis = $_POST['synopsis'];
    $rating = $_POST['rating'];
    $image_url = $_POST['image_url'];
    $genre_id = $_POST['genre_id'];


    if ($name === "" || $synopsis === "" || $image_url === "" || $rating === "") {
        $erreur = "Tous les champs doivent être remplis";
    } else if ($rating < 0 || $rating > 5) {
        $erreur = "L'évaluation doit être comprise entre 0 et 5";
    } else if (!in_array($genre_id, array_column($genres,'genre_id'))) {
        $erreur = "Ce genre n'existe pas";
    } else {
                $pdo = new PDO('mysql:host=127.0.0.1;dbname=tp_php;port=3506', 'root', 'root');

                $query = "UPDATE movies SET name = :name, synopsis = :synopsis, rating = :rating, genre_id = :genre_id, image_url = :image_url WHERE movie_id = :id";
                $stmt = $pdo->prepare($query);
                $stmt->execute([':name' => $name, ':synopsis' => $synopsis, ':rating' => $rating, ':genre_id' => $genre_id, ':image_url' => $image_url, ':id' => $movie["movie_id"]]);
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

    <title>Modifier un film</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<form method="post" id="updateMovieForm">
    <div class="container mt-5" style="max-width: 500px;">
        <div class="row g-3">
            <div class="col-12 d-flex flex-column">                  
                <label for="name">Nom</label>
                <input type="text" name="name" id="name" value="<?= $movie["name"] ?>" />
            </div> 
            <div class="col-12 d-flex flex-column">
                <label for="synopsis">Synopsis</label>
                <input type="text" name="synopsis" id="synopsis" value="<?= $movie["synopsis"] ?>" />
            </div>
            <div class="col-12 d-flex flex-column">
                <label for="rating">Évaluation</label>
                <input type="number" name="rating" id="rating" min="0" max="5" value="<?= $movie["rating"] ?>"/>
            </div>
            <div class="col-12 d-flex flex-column">
                <label for="image_url">URL de l'image</label>
                <input type="text" name="image_url" id="image_url" value="<?= $movie["image_url"] ?>" />
            </div>

            <div class="col-12 d-flex flex-column">
                <label for="genre">Sélectionnez un genre</label>
                <select name="genre_id" id="genre">
                    <?php foreach($genres as $genre) : ?>
                        <option value="<?= $genre["genre_id"]?>" <?= ($genre["genre_id"] == $movie["genre_id"]) ? "selected" : "" ?>><?= $genre["label"]?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="submit" form="updateMovieForm">Modifier</button>

            <a href="index.php" class="btn btn-secondary">Annuler</a>
        </div>

        <?php 
        if ($erreur !== "") {
        echo "<p class='text-danger'>" . $erreur . "</p>";
        }
        ?>
    </div>
</form>

</body>
</html>