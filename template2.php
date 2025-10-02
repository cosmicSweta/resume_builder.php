<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Resume</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
    body { font-family: 'Georgia', serif; background-color: #f4f7f9; margin: 0; padding: 0; color: #444; }
    .resume-container { max-width: 800px; margin: 30px auto; background-color: #fff; 
        padding: 40px; border-top: 5px solid #0d2c4b; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    .navigation { text-align: center; padding: 20px; background-color: #fff; }
    .header { text-align: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #eee; }
    .header h1 { margin: 0; font-size: 3em; color: #0d2c4b; }
    .header p { margin: 5px 0; color: #777; }
    .section { margin-bottom: 25px; }
    .section h2 { font-size: 1.4em; color: #0d2c4b; border-bottom: 2px solid #eee; padding-bottom: 8px; margin-bottom: 15px; }
    .section p { white-space: pre-wrap; line-height: 1.7; }
    .personal-info-table { width: 100%; }
    .personal-info-table td { padding: 4px 0; }
    .personal-info-table strong { width: 140px; display: inline-block; }
</style>

</head>
<body>
    <div class="navigation">
        <a href="dashboard.php">Back to Dashboard</a> | 
        <a href="resume_form.php">Edit Resume</a> |
        <a href="download_resume.php"><strong>Download as PDF</strong></a>
    </div>

    <div class="resume-container">
        <div class="header">
            <h1><?php echo htmlspecialchars($resume['full_name']); ?></h1>
            <p><?php echo htmlspecialchars($resume['email']); ?> | <?php echo htmlspecialchars($resume['phone']); ?></p>
        </div>

        <div class="section">
            <h2>Profile Summary</h2>
            <p><?php echo htmlspecialchars($resume['summary']); ?></p>
        </div>

        <div class="section">
            <h2>Skills</h2>
            <p><?php echo htmlspecialchars($resume['skills']); ?></p>
        </div>
        
        <div class="section">
            <h2>Work Experience</h2>
            <p><?php echo htmlspecialchars($resume['experience']); ?></p>
        </div>

        <div class="section">
            <h2>Education</h2>
            <p><?php echo htmlspecialchars($resume['education']); ?></p>
        </div>
        
        <div class="section">
            <h2>Personal Information</h2>
            <table class="personal-info-table">
                <tr><td><strong>Date of Birth:</strong></td><td><?php echo date("d M, Y", strtotime($resume['dob'])); ?></td></tr>
                <tr><td><strong>Gender:</strong></td><td><?php echo htmlspecialchars($resume['gender']); ?></td></tr>
                <tr><td><strong>Marital Status:</strong></td><td><?php echo htmlspecialchars($resume['marital_status']); ?></td></tr>
                <?php if (!empty($resume['guardian_name'])): ?>
                    <?php if ($resume['marital_status'] == 'Married'): ?>
                        <tr><td><strong>Husband's Name:</strong></td><td><?php echo htmlspecialchars($resume['guardian_name']); ?></td></tr>
                    <?php else: ?>
                        <tr><td><strong>Father's Name:</strong></td><td><?php echo htmlspecialchars($resume['guardian_name']); ?></td></tr>
                    <?php endif; ?>
                <?php endif; ?>
                <tr><td><strong>Location:</strong></td><td><?php echo htmlspecialchars($resume['city']) .', '. htmlspecialchars($resume['state']); ?></td></tr>
                <tr><td><strong>Languages:</strong></td><td><?php echo htmlspecialchars($resume['languages']); ?></td></tr>
                <tr><td><strong>Hobbies:</strong></td><td><?php echo htmlspecialchars($resume['hobbies']); ?></td></tr>
            </table>
        </div>
    </div>
</body>
</html>