<?php
session_start();
require 'vendor/autoload.php';
require_once 'database.php';

use Dompdf\Dompdf;
use Dompdf\Options;

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to download the resume.");
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM resumes WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$resume = $result->fetch_assoc();

if (!$resume) {
    die("No resume found to download.");
}

$template_choice = $_SESSION['template_choice'] ?? '1';
switch ($template_choice) {
    case '2':
        $template_file = 'templates/template2_pdf.php';
        break;
    case '1':
    default:
        $template_file = 'templates/template1_pdf.php';
        break;
}

ob_start();
include $template_file;
$html = ob_get_clean();

$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$filename = "Resume-" . preg_replace('/[^A-Za-z0-9\-]/', '', $resume['full_name']) . ".pdf";
$dompdf->stream($filename, ["Attachment" => TRUE]);