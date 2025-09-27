<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'database.php';

$errors = $_SESSION['form_errors'] ?? [];
$old_input = $_SESSION['old_input'] ?? [];
unset($_SESSION['form_errors']);
unset($_SESSION['old_input']);

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM resumes WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$resume = $result->fetch_assoc();
$conn->close();

$is_editing = $resume ? true : false;
$full_name = $old_input['full_name'] ?? ($resume['full_name'] ?? '');
$email = $old_input['email'] ?? ($resume['email'] ?? '');
$phone = $old_input['phone'] ?? ($resume['phone'] ?? '');
$summary = $old_input['summary'] ?? ($resume['summary'] ?? '');
$education = $old_input['education'] ?? ($resume['education'] ?? '');
$skills = $old_input['skills'] ?? ($resume['skills'] ?? '');
$experience = $old_input['experience'] ?? ($resume['experience'] ?? '');
$hobbies = $old_input['hobbies'] ?? ($resume['hobbies'] ?? '');
$languages = $old_input['languages'] ?? ($resume['languages'] ?? '');
$gender = $old_input['gender'] ?? ($resume['gender'] ?? '');
$dob = $old_input['dob'] ?? ($resume['dob'] ?? '');
$marital_status = $old_input['marital_status'] ?? ($resume['marital_status'] ?? '');
$guardian_name = $old_input['guardian_name_father'] ?? ($old_input['guardian_name_husband'] ?? 
($resume['guardian_name'] ?? ''));
$city = $old_input['city'] ?? ($resume['city'] ?? '');
$state = $old_input['state'] ?? ($resume['state'] ?? '');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $is_editing ? 'Edit Resume' : 'Create Resume'; ?></title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
        background: linear-gradient(to right, #6a11cb, #2575fc); margin: 0; padding: 40px 20px; }
        .form-container { max-width: 800px; margin: auto; background: #fff; padding: 30px 40px; 
        border-radius: 12px; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1); animation: fadeIn 0.5s ease-in-out; }
        h2 { text-align: center; margin-bottom: 30px; color: #333; font-weight: 600; }
        label { display: block; margin-top: 20px; margin-bottom: 8px; color: #555; font-weight: 600; }
        input[type="text"], input[type="email"], input[type="date"], select, textarea { width: 100%; 
        padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; font-size: 16px; font-family: inherit; transition: border-color 0.3s, box-shadow 0.3s; }
        textarea { resize: vertical; min-height: 100px; }
        input:focus, select:focus, textarea:focus { outline: none; border-color: #2575fc; 
        box-shadow: 0 0 8px rgba(37, 117, 252, 0.2); }
        button { width: 100%; padding: 15px; margin-top: 30px; border: none; border-radius: 8px; 
        background: linear-gradient(to right, #6a11cb, #2575fc); color: white; font-size: 18px; 
        font-weight: bold; cursor: pointer; transition: opacity 0.3s, transform 0.2s; }
        button:hover { opacity: 0.9; transform: translateY(-2px); }
        .error-message { color: #dc3545; font-size: 0.9em; margin-top: 5px; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>
<div class="form-container">
    <h2><?php echo $is_editing ? 'Edit Your Resume' : 'Create Your Resume'; ?></h2>
    <form method="post" action="save_resume.php">
        
        <label for="full_name">Full Name</label>
        <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($full_name); ?>" required>
        <?php if (isset($errors['full_name'])): ?><p class="error-message"><?php echo $errors['full_name']; ?></p><?php endif; ?>
        
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        <?php if (isset($errors['email'])): ?><p class="error-message"><?php echo $errors['email']; ?></p><?php endif; ?>

        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
        
        <label for="summary">Profile Summary</label>
        <textarea id="summary" name="summary" required placeholder="Write a brief summary about your professional background">
            <?php echo htmlspecialchars($summary); ?></textarea>
        <?php if (isset($errors['summary'])): ?><p class="error-message"><?php echo $errors['summary']; ?></p><?php endif; ?>
        
        <label for="education">Education</label>
        <textarea id="education" name="education"><?php echo htmlspecialchars($education); ?></textarea>

        <label for="skills">Key Skills</label>
        <textarea id="skills" name="skills" placeholder="e.g., PHP, MySQL, Project Management">
            <?php echo htmlspecialchars($skills); ?></textarea>
        
        <label for="experience">Work Experience</label>
        <textarea id="experience" name="experience"><?php echo htmlspecialchars($experience); ?></textarea>
        
        <label for="hobbies">Hobbies</label>
        <textarea id="hobbies" name="hobbies"><?php echo htmlspecialchars($hobbies); ?></textarea>
        
        <label for="languages">Languages</label>
        <textarea id="languages" name="languages"><?php echo htmlspecialchars($languages); ?></textarea>
        
        <hr style="margin-top: 30px; border: 1px solid #eee;">
        <h3 style="margin-top: 20px; text-align: center;">Personal Information</h3>

        <label for="gender">Gender</label>
        <select id="gender" name="gender">
            <option value="">Select Gender</option>
            <option value="Female" <?php if($gender == 'Female') echo 'selected'; ?>>Female</option>
            <option value="Male" <?php if($gender == 'Male') echo 'selected'; ?>>Male</option>
            <option value="Other" <?php if($gender == 'Other') echo 'selected'; ?>>Other</option>
        </select>
        
        <label for="dob">Date of Birth</label>
        <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($dob); ?>">

        <label for="marital_status">Marital Status</label>
        <select id="marital_status" name="marital_status">
            <option value="">Select Status</option>
            <option value="Unmarried" <?php if($marital_status == 'Unmarried') echo 'selected'; ?>>Unmarried</option>
            <option value="Married" <?php if($marital_status == 'Married') echo 'selected'; ?>>Married</option>
        </select>

        <div id="fatherNameField">
            <label for="father_name">Father's Name</label>
            <input type="text" id="father_name" name="guardian_name_father" 
            value="<?php if($marital_status != 'Married') echo htmlspecialchars($guardian_name); ?>">
        </div>
        <div id="husbandNameField" style="display:none;">
            <label for="husband_name">Husband's Name</label>
            <input type="text" id="husband_name" name="guardian_name_husband" 
            value="<?php if($marital_status == 'Married') echo htmlspecialchars($guardian_name); ?>">
        </div>
        
        <label for="city">City</label>
        <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($city); ?>">
        
        <label for="state">State</label>
        <input type="text" id="state" name="state" value="<?php echo htmlspecialchars($state); ?>">
        
        <button type="submit"><?php echo $is_editing ? 'Update Resume' : 'Save Resume'; ?></button>
    </form>
</div>
<script>
    const maritalStatusSelect = document.getElementById('marital_status');
    const fatherNameField = document.getElementById('fatherNameField');
    const husbandNameField = document.getElementById('husbandNameField');
    const fatherNameInput = document.getElementById('father_name');
    const husbandNameInput = document.getElementById('husband_name');
    function toggleGuardianField() {
        if (maritalStatusSelect.value === 'Married') {
            fatherNameField.style.display = 'none';
            husbandNameField.style.display = 'block';
            if ('<?php echo $marital_status; ?>' !== 'Married') fatherNameInput.value = '';
        } else {
            fatherNameField.style.display = 'block';
            husbandNameField.style.display = 'none';
            if ('<?php echo $marital_status; ?>' === 'Married') husbandNameInput.value = '';
        }
    }
    document.addEventListener('DOMContentLoaded', toggleGuardianField);
    maritalStatusSelect.addEventListener('change', toggleGuardianField);
</script>
</body>
</html>