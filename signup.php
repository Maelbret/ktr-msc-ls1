<?php
include_once("inc/header.php");
$success = null;

// Si on recoit des données du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // On récupère les arguments attendus
  $post_name = isset($_POST['name']) ? $_POST['name'] : null;
  $post_company = isset($_POST['company']) ? $_POST['company'] : null;
  $post_email = isset($_POST['email']) ? $_POST['email'] : null;
  $post_phone = isset($_POST['phone']) ? $_POST['phone'] : null;
  $post_password = isset($_POST['password']) ? $_POST['password'] : null;

  $stmt = $pdo->prepare("INSERT INTO users (name, company, email, phone, password) VALUES (?, ?, ?, ?, ?)");
  $stmt->execute([$post_name, $post_company, $post_email, $post_phone, password_hash($post_password, PASSWORD_BCRYPT)]);
  $id = $pdo->lastInsertId();
  $stmt->closeCursor();

  $success = $id > 0;

  // Si les informations ont été validées, on peut sauvegarder l'ID de l'utilisateur
  if ($success) {
    $_SESSION["user_id"] = $id;

    // On redirige l'utilisateur sur la page de gestion des cartes
    header("Location: library.php");
    exit();
  }
}

?>

<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>Sign Up - My Business Cards</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
  <?php include("menu.php"); ?>

  <div class="container">

    <form action="" method="post">
      <div class="row justify-content-center">
        <div class="col-md-6">

          <div class="form-outline mb-4">
            <label for="input-Name" class="form-label">Name</label>
            <input type="text" class="form-control" id="input-Name" name="name" placeholder="Enter your name" required>
          </div>

          <div class="form-outline mb-4">
            <label for="input-Company" class="form-label">Company Name</label>
            <input type="text" class="form-control" id="input-Company" name="company" placeholder="Enter your Company Name">
          </div>

          <div class="form-outline mb-4">
            <label for="input-Email" class="form-label">Email adress</label>
            <input type="email" class="form-control" id="input-Email" name="email" placeholder="Enter your Email adress">
          </div>

          <div class="form-outline mb-4">
            <label for="input-Phone" class="form-label">Phone number</label>
            <input type="number" class="form-control" id="input-Phone" name="phone" placeholder="Enter your Phone number">
          </div>

          <div class="form-outline mb-4">
            <label for="input-Password" class="form-label">Password</label>
            <input type="password" class="form-control" id="input-PAssword" name="password" required />
          </div>

          <div class="row">
            <div class="col">
              <!-- Submit button -->
              <button type="submit" class="btn btn-primary btn-block">Sign up</button>
            </div>
            <div class="col">
              <!-- Submit button -->
              <a href="signin.php" class="btn btn-link btn-block">Already have account?</a>
            </div>
          </div>

        </div>

      </div>

    </form>

    <?php include("footer.php"); ?>
  </div> <!-- container end -->







  <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>