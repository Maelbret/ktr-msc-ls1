<?php
include_once("inc/header.php");
include_once("inc/check_login.php");

$creation_success = null;
$deletion_success = null;

// On récupère l'action désirée
$action = isset($_GET["action"]) ? $_GET["action"] : null;

// Si on recoit des données du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ($action === "create") {
    // On récupère les arguments attendus
    $post_name = isset($_POST['createName']) ? $_POST['createName'] : null;
    $post_company = isset($_POST['createCompany']) ? $_POST['createCompany'] : null;
    $post_email = isset($_POST['createEmail']) ? $_POST['createEmail'] : null;
    $post_phone = isset($_POST['createPhone']) ? $_POST['createPhone'] : null;

    $stmt = $pdo->prepare("INSERT INTO cards (name, company, email, phone, owner) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$post_name, $post_company, $post_email, $post_phone, $_SESSION["user_id"]]);
    $creation_success = $pdo->lastInsertId() > 0;
    $stmt->closeCursor();
  }
}

// Si on recoit l'action de supprimer
if ($action === "delete") {
  // On récupère l'argument
  $get_id = isset($_GET["id"]) ? $_GET["id"] : null;

  if (!is_null($get_id)) {
    $stmt = $pdo->prepare("DELETE FROM cards WHERE id = ? AND owner = ?");
    $stmt->execute([$get_id, $_SESSION["user_id"]]);
    $deletion_success = $stmt->rowCount() > 0;
    $stmt->closeCursor();
  }
}

// On récupère toutes les cartes de l'utilisateur 
$stmt = $pdo->prepare("SELECT * FROM cards WHERE owner = ?");
$stmt->execute([$_SESSION["user_id"]]);
$cards = $stmt->fetchAll();
$stmt->closeCursor();

?>

<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>My cards - My Business Cards</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
  <?php include("menu.php"); ?>

  <div class="container">
    <?php if (!is_null($creation_success) && $creation_success === true) : ?>
      <div class="alert alert-success" role="alert">
        Card created successfully!
      </div>
    <?php endif; ?>
    <?php if (!is_null($creation_success) && $creation_success === false) : ?>
      <div class="alert alert-danger" role="alert">
        Error during card creation.
      </div>
    <?php endif; ?>
    <?php if (!is_null($deletion_success) && $deletion_success === true) : ?>
      <div class="alert alert-success" role="alert">
        Card deleted successfully!
      </div>
    <?php endif; ?>
    <?php if (!is_null($deletion_success) && $deletion_success === false) : ?>
      <div class="alert alert-danger" role="alert">
        Error during card deletion.
      </div>
    <?php endif; ?>

    <div class="row">

      <div class="col-md-8">
        <div class="row">

          <?php foreach ($cards as $card) : ?>
            <div class="col-md-4">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title"><?= $card["name"] ?></h5>
                  <h6 class="card-subtitle mb-2 text-muted"><?= $card["company"] ?></h6>
                  <p class="card-text"><?= $card["phone"] ?></p>
                  <a href="mailto:<?= $card["email"] ?>" class="card-link"><?= $card["email"] ?></a>
                </div>
                <div class="card-footer">
                  <a href="?action=delete&id=<?= $card["id"] ?>" class="btn btn-outline-danger btn-sm">Delete</a>
                </div>
              </div>
            </div>

          <?php endforeach; ?>

        </div>
      </div>
      <div class="col-md-4">

        <div class="card border-primary">
          <div class="card-body">
            <h5 class="card-title text-primary">New card</h5>
            <h6 class="card-subtitle mb-2 text-muted">Create a new business card.</h6>
            <div class="card-text">

              <form action="?action=create" method="POST">
                <div class="form-group">
                  <label for="inputCreateName">Name</label>
                  <input type="text" class="form-control" name="createName" id="inputCreateName" placeholder="Card name">
                </div>
                <div class="form-group">
                  <label for="inputCreateCompany">Company name</label>
                  <input type="text" class="form-control" name="createCompany" id="inputCreateCompany" placeholder="Card company name">
                </div>
                <div class="form-group">
                  <label for="inputCreateEmail">Email</label>
                  <input type="email" class="form-control" name="createEmail" id="inputCreateEmail" placeholder="Card email" required>
                </div>
                <div class="form-group">
                  <label for="inputCreatePhone">Phone</label>
                  <input type="phone" class="form-control" name="createPhone" id="inputCreatePhone" placeholder="Card phone">
                </div>
                <button type="submit" class="btn btn-block btn-outline-success">Save</button>
              </form>

            </div>
          </div>
        </div>

      </div>


    </div>

    <?php include("footer.php"); ?>
  </div> <!-- container end -->

  <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>