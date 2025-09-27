<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $errors = [];
    $input = $_POST;

    if (empty($input['full_name'])) {
        $errors['full_name'] = "Full name is required.";
    }
    if (empty($input['email'])) {
        $errors['email'] = "Email is required.";
    }
    if (empty($input['summary'])) {
        $errors['summary'] = "Profile summary is required.";
    }

    if (!empty($input['email']) && !filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please enter a valid email address.";
    }

    if (!empty($errors)) {
        $_SESSION['form_errors'] = $errors;
        $_SESSION['old_input'] = $input;
        header('Location: resume_form.php');
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $full_name = $input['full_name'];
    $email = $input['email'];
    $phone = $input['phone'];
    $summary = $input['summary']; 
    $education = $input['education'];
    $skills = $input['skills'];
    $experience = $input['experience'];
    $hobbies = $input['hobbies'];
    $languages = $input['languages'];
    $gender = $input['gender'];
    $dob = $input['dob'];
    if(isset($input['$marital_status']) && $input['marital_status'] == 'Married') {
    $guardian_name = $input['guardian_name_husband'] ?? '';
    } else { 
        $guardian_name = $input['guardian_name_father'] ?? ''; }
    $city = $input['city'];
    $state = $input['state'];

    $sql = "INSERT INTO resumes (user_id, full_name, email, phone, summary, education, skills, experience, hobbies, languages, gender, dob, marital_status, guardian_name, city, state) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE 
                full_name=VALUES(full_name), email=VALUES(email), phone=VALUES(phone), summary=VALUES(summary), 
                education=VALUES(education), skills=VALUES(skills), experience=VALUES(experience), hobbies=VALUES(hobbies), 
                languages=VALUES(languages), gender=VALUES(gender), dob=VALUES(dob), marital_status=VALUES(marital_status), 
                guardian_name=VALUES(guardian_name), city=VALUES(city), state=VALUES(state)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssssssssssss", $user_id, $full_name, $email, $phone, $summary, $education, $skills, $experience, $hobbies, $languages, $gender, $dob, $marital_status, $guardian_name, $city, $state);

    if ($stmt->execute()) {
        echo <<<HTML
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Success!</title>
            <style>
                body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(to right, #6a11cb, #2575fc); display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
                .success-container { background-color: #fff; padding: 40px 50px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); text-align: center; animation: fadeIn 0.5s ease-in-out; }
                h2 { color: #2c3e50; margin-top: 20px; margin-bottom: 10px; }
                p { color: #777; margin-bottom: 30px; }
                .button { display: inline-block; padding: 12px 25px; border-radius: 8px; background: linear-gradient(to right, #6a11cb, #2575fc); color: white; text-decoration: none; font-weight: bold; transition: transform 0.2s, opacity 0.3s; }
                .button:hover { opacity: 0.9; transform: translateY(-2px); }
                .checkmark-circle { stroke-dasharray: 166; stroke-dashoffset: 166; stroke-width: 3; stroke-miterlimit: 10; stroke: #28a745; fill: none; animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards; }
                .checkmark { width: 80px; height: 80px; border-radius: 50%; display: block; stroke-width: 3; stroke: #fff; stroke-miterlimit: 10; margin: 0 auto; box-shadow: inset 0px 0px 0px #28a745; animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both; }
                .checkmark-check { transform-origin: 50% 50%; stroke-dasharray: 48; stroke-dashoffset: 48; animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards; }
                @keyframes stroke { 100% { stroke-dashoffset: 0; } }
                @keyframes scale { 0%, 100% { transform: none; } 50% { transform: scale3d(1.1, 1.1, 1); } }
                @keyframes fill { 100% { box-shadow: inset 0px 0px 0px 40px #28a745; } }
                @keyframes fadeIn { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
            </style>
        </head>
        <body>
            <div class="success-container">
                <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                    <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
                    <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                </svg>
                <h2>Success!</h2>
                <p>Your resume has been saved successfully.</p>
                <a href="view_resume.php" class="button">View Your Resume</a>
            </div>
        </body>
        </html>
HTML;
        exit();
    } else {
        echo "<p>Error: Could not save the resume. " . $stmt->error . "</p>";
    }
    
    $stmt->close();
    $conn->close();

} else {
    header('Location: resume_form.php');
    exit();
}
?>