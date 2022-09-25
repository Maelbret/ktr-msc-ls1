<?php
include_once("inc/header.php");
include_once("inc/check_login.php");

$success = null;

// Si on recoit des données du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // On récupère les arguments attendus
    $post_name = isset($_POST['name']) ? $_POST['name'] : null;
    $post_company = isset($_POST['company']) ? $_POST['company'] : null;
    $post_email = isset($_POST['email']) ? $_POST['email'] : null;
    $post_phone = isset($_POST['phone']) ? $_POST['phone'] : null;

    $stmt = $pdo->prepare("UPDATE users SET name = :name, company = :company, email = :email, phone = :phone WHERE id = :id");
    $stmt->execute(["name" => $post_name, "company" => $post_company, "email" => $post_email, "phone" => $post_phone, "id" => $_SESSION["user_id"]]);
    $success = $stmt->rowCount() > 0;
    $stmt->closeCursor();
}

// On récupère les informations de l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
$stmt->execute([$_SESSION["user_id"]]);
$user = $stmt->fetch();
$stmt->closeCursor();

?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>My account - My Business Cards</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php include("menu.php"); ?>

    <div class="container">
        <?php if (!is_null($success) && $success === true) : ?>
            <div class="alert alert-success" role="alert">
                Account updated successfully!
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="row justify-content-center">
                <div class="col-md-6">

                    <div class="form-outline mb-4">
                        <label for="input-Name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="input-Name" name="name" placeholder="Enter your name" value="<?= $user["name"] ?>" required>
                    </div>

                    <div class="form-outline mb-4">
                        <label for="input-Company" class="form-label">Company Name</label>
                        <input type="text" class="form-control" id="input-Company" name="company" value="<?= $user["company"] ?>" placeholder="Enter your Company Name">
                    </div>

                    <div class="form-outline mb-4">
                        <label for="input-Email" class="form-label">Email adress</label>
                        <input type="email" class="form-control" id="input-Email" name="email" value="<?= $user["email"] ?>" placeholder="Enter your Email adress">
                    </div>

                    <div class="form-outline mb-4">
                        <label for="input-Phone" class="form-label">Phone number</label>
                        <input type="number" class="form-control" id="input-Phone" name="phone" value="<?= $user["phone"] ?>" placeholder="Enter your Phone number">
                    </div>


                    <button type="submit" class="btn btn-outline-primary btn-block">Save</button>

                </div>

            </div>

        </form>

        <?php include("footer.php"); ?>
    </div> <!-- container end -->



    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>