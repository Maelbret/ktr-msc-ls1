<?php

if (!isConnected()) {
    // On redirige l'utilisateur sur la page de connexion
  header("Location: signin.php");
  exit();
}