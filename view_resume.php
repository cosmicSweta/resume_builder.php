<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM resumes WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$resume = $result->fetch_assoc();

$template_choice = $_SESSION['template_choice'] ?? '1';

switch ($template_choice) {
    case '2':
        $template_file = 'templates/template2.php';
        break;
    case '1':
    default:
        $template_file = 'templates/template1.php';
        break;
}

if (!$resume) {
    header("Location: resume_form.php");
    exit();
}

include $template_file;
?>