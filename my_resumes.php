<?php
session_start();
include 'db.php';
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM resumes WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Resumes</title>
    <style>
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        a.button {
            padding: 5px 10px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        a.button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">My Resumes</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo $row['created_at']; ?></td>
            <td>
                <a class="button" href="view_resume.php?id=<?php echo $row['id']; ?>">View</a>
                <a class="button" href="resume_form.php?id=<?php echo $row['id']; ?>">Edit</a>
                <a class="button" href="delete_resume.php?id=<?php echo $row['id']; ?>" 
                onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>