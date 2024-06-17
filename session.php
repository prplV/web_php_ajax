<?php 
    function startSession() {
        session_start();
    }
    function destroySession() {
        session_destroy();
    }
    function checkLoggedIn() {
        if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
            return true;
        } else {
            return false;
        }
    }
    function isAdmin() {
        if (isset($_SESSION['username']) && $_SESSION['username'] == "admin") {
            return true;
        } else {
            return false;
        }
    }
    function getLoggedInUsername() {
        return $_SESSION["username"];
    }
?>