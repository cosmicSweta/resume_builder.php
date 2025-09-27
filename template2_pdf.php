<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Resume</title>
    <style>
        body { font-family: "Helvetica", "Arial", sans-serif; color: #333; font-size: 12px; line-height: 1.6; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 2.5em; color: #2c3e50; }
        .header p { margin: 5px 0 0 0; font-size: 1.1em; }
        .section { margin-bottom: 20px; }
        .section h2 { font-size: 1.3em; text-transform: uppercase; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 10px; color: #2c3e50; }
        .section p { margin: 0; white-space: pre-wrap; }
        .personal-info-table { width: 100%; border-collapse: collapse; }
        .personal-info-table td { padding: 4px 0; }
        .personal-info-table strong { width: 140px; display: inline-block; }
    </style>
</head>
<body>
    <div class="header"><h1><?php echo htmlspecialchars($resume['full_name']); ?></h1><p><?php echo htmlspecialchars($resume['email']); ?> | <?php echo htmlspecialchars($resume['phone']); ?></p></div>
    <div class="section"><h2>Profile Summary</h2><p><?php echo htmlspecialchars($resume['summary']); ?></p></div>
    <div class="section"><h2>Skills</h2><p><?php echo htmlspecialchars($resume['skills']); ?></p></div>
    <div class="section"><h2>Work Experience</h2><p><?php echo htmlspecialchars($resume['experience']); ?></p></div>
    <div class="section"><h2>Education</h2><p><?php echo htmlspecialchars($resume['education']); ?></p></div>
    <div class="section"><h2>Personal Information</h2><table class="personal-info-table"><tr><td><strong>Date of Birth:</strong></td><td><?php echo date("d M, Y", strtotime($resume['dob'])); ?></td></tr><tr><td><strong>Gender:</strong></td><td><?php echo htmlspecialchars($resume['gender']); ?></td></tr><tr><td><strong>Marital Status:</strong></td><td><?php echo htmlspecialchars($resume['marital_status']); ?></td></tr><?php if (!empty($resume['guardian_name'])){ $guardian_label = ($resume['marital_status'] == 'Married') ? "Husband's Name" : "Father's Name"; echo '<tr><td><strong>'. $guardian_label .':</strong></td><td>'. htmlspecialchars($resume['guardian_name']) .'</td></tr>'; } ?><tr><td><strong>Location:</strong></td><td><?php echo htmlspecialchars($resume['city']) .', '. htmlspecialchars($resume['state']); ?></td></tr><tr><td><strong>Languages:</strong></td><td><?php echo htmlspecialchars($resume['languages']); ?></td></tr><tr><td><strong>Hobbies:</strong></td><td><?php echo htmlspecialchars($resume['hobbies']); ?></td></tr></table></div>
</body>
</html>