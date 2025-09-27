<?php
session_start();

if (isset($_GET['template']) && isset($_SESSION['user_id'])) {
    $_SESSION['template_choice'] = $_GET['template'];
    header('Location: view_resume.php');
    exit();
} else {
    header('Location: dashboard.php');
    exit();
}
?>