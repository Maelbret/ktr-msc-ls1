<?php
include_once("inc/header.php");
$success = null;

// On vérifie si l'utilisateur ne souhaite pas se déconnecter
if (isset($_GET["signout"])) {
  unset($_SESSION["user_id"]);
}

// On vérifie si l'utilisateur est déjà connecté
if (isset($_SESSION["user_id"]) && !is_null($_SESSION["user_id"]) && $_SESSION["user_id"] > 0) {
  // On redirige l'utilisateur sur la page de gestion des cartes
  header("Location: library.php");
  exit();
}

// Si on recoit des données du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // On récupère les arguments attendus
  $post_email = isset($_POST['email']) ? $_POST['email'] : null;
  $post_password = isset($_POST['password']) ? $_POST['password'] : null;

  // On récupère l'entrée en base pour vérifier le mot de passe
  $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = :email LIMIT 1");
  $stmt->execute(["email" => $post_email]);
  $row = $stmt->fetch();
  $stmt->closeCursor();
  $success = $row && $row["id"] > 0;

  // On compare les mots de passe
  if ($success === true) {
    $success = password_verify($post_password, $row["password"]);
  }

  // Si les informations ont été validées, on peut saauvegarder l'ID de l'utilisateur
  if ($success) {
    $_SESSION["user_id"] = $row["id"];

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
  <title>Sign In - My Business Card</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
  <?php include("menu.php"); ?>

  <div class="container">

    <?php if (!is_null($success) && $success === false) : ?>
      <div class="alert alert-danger" role="alert">
        Wrong password or user not found!
      </div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <!-- Email input -->
          <div class="form-outline mb-4">
            <input type="email" id="inputEmail" class="form-control" name="email" required />
            <label class="form-label" for="inputEmail">Email address</label>
          </div>

          <!-- Password input -->
          <div class="form-outline mb-4">
            <input type="password" id="inputPassword" class="form-control" name="password" required />
            <label class="form-label" for="inputPassword">Password</label>
          </div>

          <div class="row">
            <div class="col">
              <!-- Submit button -->
              <button type="submit" class="btn btn-primary btn-block">Sign in</button>
            </div>
            <div class="col">
              <!-- Submit button -->
              <a href="signup.php" class="btn btn-link btn-block">No account?</a>
            </div>
          </div>

        </div>
      </div>
    </form>


    <?php include("footer.php"); ?>
  </div>

  <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>