<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Resume</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Montserrat:wght@600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Lato', 'Helvetica', sans-serif;
            background-color: #e6f0f7;
            margin: 0;
            padding: 0;
            color: #333;
        }
        h1, h2, h3 {
            font-family: 'Montserrat', sans-serif;
        }
        .resume-container {
            max-width: 900px;
            margin: 30px auto;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            display: flex;
        }
        h2 {
            text-transform: uppercase;
            font-size: 1.1em;
            letter-spacing: 1px;
            color: #003366;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 5px;
            margin-top: 25px;
        }
        p { line-height: 1.6; white-space: pre-wrap; }
        a { text-decoration: none; color: #004488; }

        .left-column {
            background-color: #003366;
            color: #ffffff;
            width: 35%;
            padding: 30px;
            box-sizing: border-box;
        }
        .right-column {
            width: 65%;
            padding: 30px;
            box-sizing: border-box;
        }
        .left-column h2 { border-bottom-color: #ffffff; }

        .header {
            text-align: center;
            border-bottom: 1px solid #ddd;
            border-bottom-color: #4CAF50;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h1 { margin: 0; font-size: 2.5em; color: #003366; }
        .header .job-title { margin: 5px 0; font-size: 1.2em; color: #555; font-weight: bold; }
        .contact-info { display: flex; justify-content: center; gap: 20px; margin-top: 15px; flex-wrap: wrap; font-size: 0.9em; }
        .contact-info i { margin-right: 5px; color: #004488; }

        .section-title { display: flex; align-items: center; gap: 10px; }
        .navigation { text-align: center; padding: 20px; background-color: #fff; }
    </style>
</head>
<body>
    <div class="navigation">
        <a href="dashboard.php">Back to Dashboard</a> | 
        <a href="resume_form.php">Edit Resume</a> |
        <a href="download_resume.php"><strong>Download as PDF</strong></a>
    </div>

    <div class="resume-container">
        <div class="left-column">
            <div class="section personal-info">
                <h2><i class="fas fa-user-circle"></i> Personal Info</h2>
                <p><strong>Date of Birth:</strong> <?php echo date("d M, Y", strtotime($resume['dob'])); ?></p>
                <p><strong>Gender:</strong> <?php echo htmlspecialchars($resume['gender']); ?></p>
                <p><strong>Marital Status:</strong> <?php echo htmlspecialchars($resume['marital_status']); ?></p>
                <?php if (!empty($resume['guardian_name'])): ?>
                    <?php if ($resume['marital_status'] == 'Married'): ?>
                        <p><strong>Husband's Name:</strong> <?php echo htmlspecialchars($resume['guardian_name']); ?></p>
                    <?php else: ?>
                        <p><strong>Father's Name:</strong> <?php echo htmlspecialchars($resume['guardian_name']); ?></p>
                    <?php endif; ?>
                <?php endif; ?>
                <p><strong>City:</strong> <?php echo htmlspecialchars($resume['city']); ?></p>
                <p><strong>State:</strong> <?php echo htmlspecialchars($resume['state']); ?></p>
            </div>
            <div class="section">
                <h2><i class="fas fa-cogs"></i> Skills</h2>
                <p><?php echo htmlspecialchars($resume['skills']); ?></p>
            </div>
            <div class="section">
                <h2><i class="fas fa-palette"></i> Hobbies</h2>
                <p><?php echo htmlspecialchars($resume['hobbies']); ?></p>
            </div>
            <div class="section">
                <h2><i class="fas fa-language"></i> Languages</h2>
                <p><?php echo htmlspecialchars($resume['languages']); ?></p>
            </div>
        </div>

        <div class="right-column">
            <div class="header">
                <h1><?php echo htmlspecialchars($resume['full_name']); ?></h1>
                <p class="job-title">Back Office Executive</p>
                <div class="contact-info">
                    <span><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($resume['email']); ?></span>
                    <span><i class="fas fa-phone"></i> <?php echo htmlspecialchars($resume['phone']); ?></span>
                </div>
            </div>
            <div class="section">
                <h2 class="section-title"><i class="fas fa-id-card-alt"></i> Profile Summary</h2>
                <p><?php echo htmlspecialchars($resume['summary']); ?></p>
            </div>
            <div class="section">
                <h2 class="section-title"><i class="fas fa-graduation-cap"></i> Education</h2>
                 <p><?php echo htmlspecialchars($resume['education']); ?></p>
            </div>
            <div class="section">
                <h2 class="section-title"><i class="fas fa-briefcase"></i> Work Experience</h2>
                 <p><?php echo htmlspecialchars($resume['experience']); ?></p>
            </div>
        </div>
    </div>
</body>
</html>