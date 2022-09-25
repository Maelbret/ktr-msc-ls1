<?php

function isConnected(): bool {
    return isset($_SESSION["user_id"]) && !is_null($_SESSION["user_id"]);
}