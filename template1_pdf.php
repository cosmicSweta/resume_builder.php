<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Resume</title>
    <style>
        body { font-family: "Helvetica", "Arial", sans-serif; color: #333; font-size: 11px; }
        h2 { text-transform: uppercase; font-size: 1.1em; letter-spacing: 1px; color: #2c3e50; border-bottom: 2px solid #2c3e50; padding-bottom: 5px; margin-top: 20px; }
        p { line-height: 1.6; white-space: pre-wrap; margin: 10px 0; }
        .resume-table { width: 100%; border-spacing: 0; }
        .left-column { width: 35%; padding: 20px; vertical-align: top; background-color: #e8eaf6; }
        .right-column { width: 65%; padding: 20px; vertical-align: top; }
        .left-column h2 { color: #2c3e50; border-bottom-color: #aeb4d3; }
        .header h1 { margin: 0; font-size: 2.5em; color: #2c3e50; }
        .header .job-title { margin: 5px 0; font-size: 1.2em; color: #555; font-weight: bold; }
        .contact-info { margin-top: 10px; }
    </style>
</head>
<body>
    <table class="resume-table">
        <tr>
            <td class="left-column">
                <div class="section"><h2>Personal Info</h2>
                <p><strong>Date of Birth:</strong> <?php echo date("d M, Y", strtotime($resume['dob'])); ?></p>
                <p><strong>Gender:</strong> <?php echo htmlspecialchars($resume['gender']); ?></p>
                <p><strong>Marital Status:</strong> <?php echo htmlspecialchars($resume['marital_status']); ?></p>
                <?php if (!empty($resume['guardian_name'])){$guardian_label = ($resume['marital_status'] == 'Married') ? 
                    "Husband's Name" : "Father's Name"; echo '<p><strong>'. $guardian_label .':</strong> '. htmlspecialchars($resume['guardian_name']) .'</p>';}?>
                    <p><strong>City:</strong> <?php echo htmlspecialchars($resume['city']); ?></p>
                    <p><strong>State:</strong> <?php echo htmlspecialchars($resume['state']); ?></p></div>
                <div class="section"><h2>Skills</h2><p><?php echo htmlspecialchars($resume['skills']); ?></p></div>
                <div class="section"><h2>Hobbies</h2><p><?php echo htmlspecialchars($resume['hobbies']); ?></p></div>
                <div class="section"><h2>Languages</h2><p><?php echo htmlspecialchars($resume['languages']); ?></p></div>
            </td>

            <td class="right-column">
                <div class="header"><h1><?php echo htmlspecialchars($resume['full_name']); ?></h1>
                <p class="job-title">Back Office Executive</p>
                <div class="contact-info"><span><?php echo htmlspecialchars($resume['email']); ?></span> | 
                <span><?php echo htmlspecialchars($resume['phone']); ?></span></div></div>
                <div class="section"><h2>Profile Summary</h2><p><?php echo htmlspecialchars($resume['summary']); ?></p></div>
                <div class="section"><h2>Education</h2><p><?php echo htmlspecialchars($resume['education']); ?></p></div>
                <div class="section"><h2>Work Experience</h2><p><?php echo htmlspecialchars($resume['experience']); ?></p></div>
            </td>
        </tr>
    </table>
</body>
</html>