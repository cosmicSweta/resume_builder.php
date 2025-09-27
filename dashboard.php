<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'database.php';

$last_updated_text = "You haven't created a resume yet.";
$sql = "SELECT last_updated FROM resumes WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($resume = $result->fetch_assoc()) {
        $last_updated_text = "Last updated: " . date("F j, Y, g:i a", strtotime($resume['last_updated']));
    }
}
$stmt->close();

$current_template = $_SESSION['template_choice'] ?? '1';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f9;
            margin: 0;
            padding-top: 60px;
            box-sizing: border-box;
        }
        .dashboard-container {
            max-width: 800px;
            margin: 40px auto;
            background-color: #fff;
            padding: 40px 50px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            text-align: center;
        }
        .dashboard-header h2 { margin: 0; color: #333; font-size: 2em; }
        .dashboard-header p { color: #777; font-size: 1.1em; margin-bottom: 40px; }
        .dashboard-header .last-updated {
            font-size: 0.9em;
            color: #999;
            margin-top: -30px;
            margin-bottom: 30px;
        }
        .action-cards { display: flex; gap: 30px; justify-content: center; }
        .card { flex: 1; padding: 30px; border: 1px solid #e0e0e0; border-radius: 10px;
         text-decoration: none; color: #333; transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .card:hover { cursor: pointer; transform: translateY(-8px); box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12); }
        .card i { font-size: 3em; margin-bottom: 15px; }
        .card h3 { margin: 0 0 5px 0; font-size: 1.2em; }
        .card p { margin: 0; color: #777; font-size: 0.9em; }
        .card.create-resume i { color: #28a745; }
        .card.view-resume i { color: #17a2b8; }

        .template-selector { margin-top: 40px; padding-top: 30px; border-top: 1px solid #eee; }
        .template-selector h2 { font-size: 1.5em; }
        .template-grid { display: flex; gap: 30px; justify-content: center; }
        .template-preview { border: 3px solid #ddd; border-radius: 8px; overflow: hidden; text-decoration: none;
         color: #333; transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .template-preview:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .template-preview img { display: block; width: 150px; height: auto; }
        .template-preview p { padding: 10px; margin: 0; font-weight: 600; background-color: #f9f9f9; }
        .template-preview.active-template {
            border-color: #2575fc;
            box-shadow: 0 8px 25px rgba(37, 117, 252, 0.2);
        }

        .navbar { background-color: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); padding: 0 40px; display: flex;
         justify-content: space-between; align-items: center; width: 100%; position: fixed; 
         top: 0; left: 0; z-index: 1000; box-sizing: border-box; }
        .nav-links ul { margin: 0; padding: 0; list-style: none; display: flex; }
        .nav-links li a { display: block; padding: 20px 15px; color: #555; text-decoration: none; 
        font-weight: 600; transition: color 0.3s, background-color 0.3s; }
        .nav-links li a:hover { background-color: #f4f4f4; color: #2575fc; }
        .nav-links li a i { margin-right: 8px; }
        .user-info { display: flex; align-items: center; gap: 20px; color: #333; }
        .logout-form button { border: none; background-color: #dc3545; color: white; padding: 10px 15px;
         border-radius: 5px; cursor: pointer; font-weight: 600; transition: background-color 0.3s; }
        .logout-form button:hover { background-color: #c82333; }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-links">
            <ul>
                <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="view_resume.php"><i class="fas fa-eye"></i> View Resume</a></li>
                <li><a href="resume_form.php"><i class="fas fa-edit"></i> Edit Resume</a></li>
            </ul>
        </div>
        <div class="user-info">
            <span>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
            <form action="logout.php" method="post" class="logout-form">
                <button type="submit">Logout <i class="fas fa-sign-out-alt"></i></button>
            </form>
        </div>
    </nav>
    
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h2>Dashboard</h2>
            <p>Manage your resume and preferences.</p>
            <p class="last-updated"><?php echo $last_updated_text; ?></p>
        </div>

        <div class="action-cards">
            <a href="resume_form.php" class="card create-resume">
                <i class="fas fa-file-alt"></i>
                <h3>Create / Edit Resume</h3>
                <p>Build or update your professional resume.</p>
            </a>
            <a href="view_resume.php" class="card view-resume">
                <i class="fas fa-eye"></i>
                <h3>View Resume</h3>
                <p>See your generated resume.</p>
            </a>
        </div>
        
        <div class="template-selector">
            <h2>Choose Your Template</h2>
            <div class="template-grid">
                <a href="select_template.php?template=1" class="template-preview 
                <?php if($current_template == '1') echo 'active-template'; ?>">
                    <img src="two-column.png" alt="Modern Template Preview">
                    <p>Modern Two-Column</p>
                </a>
                <a href="select_template.php?template=2" class="template-preview 
                <?php if($current_template == '2') echo 'active-template'; ?>">
                    <img src="singlecolumn.png" alt="Classic Template Preview">
                    <p>Classic Single-Column</p>
                </a>
            </div>
        </div>
    </div>
</body>
</html>