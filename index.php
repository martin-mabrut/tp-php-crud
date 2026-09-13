<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=tp_php;port=3506', 'root', 'root');

$query = "SELECT * FROM movies";
$stmt = $pdo->prepare($query);
$stmt->execute();
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

// var_dump($movies);

$queryGenres = "SELECT * FROM genres";
$stmt = $pdo->prepare($queryGenres);
$stmt->execute();
$genres = $stmt->fetchAll(PDO::FETCH_ASSOC);
// var_dump($genres);
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

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Ajouter un film
</button>

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


// Modale




<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ajouter un film</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">



        <form method="post" id="addMovieForm">

         <?php
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

                            $query = "INSERT INTO movies (name, synopsis, rating, genre_id, image_url) VALUES (:name, :synopsis, :rating, :genre_id, :image_url)";
                            $stmt = $pdo->prepare($query);
                            $stmt->execute([':name' => $name, ':synopsis' => $synopsis, ':rating' => $rating, ':genre_id' => $genre_id, ':image_url' => $image_url]);
                            header('Location: index.php');
                }
            }

            if ($erreur !== "") {
                echo "<p class='text-danger'>" . $erreur . "</p>";
            }
        ?>

            <div class="container">
                <div class="row g-3">
                    <div class="col-12 d-flex flex-column">                  
                        <label for="name">Nom</label>
                        <input type="text" name="name" id="name" />
                    </div> 
                    <div class="col-12 d-flex flex-column">
                        <label for="synopsis">Synopsis</label>
                        <input type="text" name="synopsis" id="synopsis" />
                    </div>
                    <div class="col-12 d-flex flex-column">
                        <label for="rating">Évaluation</label>
                        <input type="number" name="rating" id="rating" min="0" max="5" value="0"/>
                    </div>
                    <div class="col-12 d-flex flex-column">
                        <label for="image_url">URL de l'image</label>
                        <input type="text" name="image_url" id="image_url" />
                    </div>

                    <div class="col-12 d-flex flex-column">
                        <label for="genre">Sélectionnez un genre</label>
                        <select name="genre_id" id="genre">
                            <?php foreach($genres as $genre) : ?>
                                <option value="<?= $genre["genre_id"]?>"><?= $genre["label"]?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </form>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>

        <button type="submit" class="btn btn-primary" name="submit" form="addMovieForm">Valider</button>
      </div>
    </div>
  </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
var myModal = document.getElementById('exampleModal')
var myInput = document.getElementById('name')

myModal.addEventListener('shown.bs.modal', function () {
  myInput.focus()
})

<?php if ($erreur !== "") : ?>
  new bootstrap.Modal(myModal).show()
<?php endif; ?>
</script>
</body>
</html>