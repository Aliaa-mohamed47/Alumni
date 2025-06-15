<?php
session_start();
require_once '../../Controlers/UserControler.php';
require_once '../../Controlers/DBControler.php';

$db = new DBControler();
$userController = new UserControler($db);

function isEmailExists($email, $db) {
    $result = $db->selectt(
        "SELECT id FROM admins WHERE email = ? 
        UNION 
        SELECT id FROM alumnis WHERE email = ? 
        UNION 
        SELECT id FROM students WHERE email = ?", 
        [$email, $email, $email]
    );
    
    if ($result && $result->num_rows > 0) {
        return true;
    }
    return false;
}

function isValidPassword($password) {
    return preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'] ?? '';
    $sex = $_POST['sex'] ?? '';
    $graduation_year = $_POST['graduation_year'] ?? '';
    $department = $_POST['department'] ?? '';
    $job_title = $_POST['job_title'] ?? '';
    $level = $_POST['level'] ?? '';
    $company = $_POST['company'] ?? '';
    $role = $_POST['role'];

    if (isEmailExists($email, $db)) {
        $_SESSION["errMsg"] = "Email already exists!";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } 
    elseif (!isValidPassword($password)) {
        $_SESSION["errMsg"] = "Password must be at least 8 characters long, include a capital letter, a number, and a special character.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } 
    else {
        $isAdded = false;
        switch ($role) {
            case 'admin':
                $isAdded = $userController->addAdmin($name, $email, $password, $phone);
                break;
            case 'alumni':
                $isAdded = $userController->addAlumni($name, $email, $password, $sex, $graduation_year, $department, $job_title, $phone, $company);
                break;
            case 'student':
                $isAdded = $userController->addStudent($name, $email, $password, $sex, $level, $department);
                break;
        }

        if ($isAdded) {
            $_SESSION["successMsg"] = "User added successfully!";
        } else {
            $_SESSION["errMsg"] = "Email already exists!";
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #16406d !important;
            color: #fff;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            margin-top: 50px;
        }
        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #16406d;
        }
        .alert {
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <?php include 'headerAdmin.php'; ?>

    <div class="container">
        <div class="form-container">
            <div class="app-brand justify-content-center mb-6">
                <a class="navbar-brand" href="index.html">
                    <img src="../assets/images/alumni-removebg-preview.png" style="height: 80px; width: 80px;" alt="" />
                    <span style="color:black; font-size: 30px;">Alumni</span>
                </a>
            </div>
            <h2>Add New User</h2>

            <?php if (isset($_SESSION["errMsg"])): ?>
                <div class="alert alert-danger"><?php echo $_SESSION["errMsg"]; unset($_SESSION["errMsg"]); ?></div>
            <?php endif; ?>

            <?php if (isset($_SESSION["successMsg"])): ?>
                <div class="alert alert-success"><?php echo $_SESSION["successMsg"]; unset($_SESSION["successMsg"]); ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-control" required>
                        <option value="">Select role</option>
                        <option value="admin">Admin</option>
                        <option value="alumni">Alumni</option>
                        <option value="student">Student</option>
                    </select>
                </div>
                <div id="extraFields"></div>
                <button type="submit" class="btn btn-primary">Add New User</button>
            </form>
        </div>
    </div>

    <script>
        const roleSelect = document.querySelector('select[name="role"]');
        const extraFields = document.getElementById('extraFields');

        roleSelect.addEventListener('change', function() {
            extraFields.innerHTML = '';
            if (roleSelect.value === 'alumni') {
                extraFields.innerHTML = `
                    <div class="mb-3">
                        <label class="form-label">Sex</label>
                        <select name="sex" class="form-control">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Graduation Year</label>
                        <input type="text" name="graduation_year" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <select name="department" class="form-control">
                            <option value="CS">CS</option>
                            <option value="AI">AI</option>
                            <option value="IT">IT</option>
                            <option value="IS">IS</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Job Title</label>
                        <input type="text" name="job_title" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Company</label>
                        <input type="text" name="company" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                `;
            } else if (roleSelect.value === 'student') {
                extraFields.innerHTML = `
                    <div class="mb-3">
                        <label class="form-label">Sex</label>
                        <select name="sex" class="form-control">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Level</label>
                        <select name="level" class="form-control">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <select name="department" class="form-control">
                            <option value="CS">CS</option>
                            <option value="AI">AI</option>
                            <option value="IT">IT</option>
                            <option value="IS">IS</option>
                            <option value="General">General</option>
                        </select>
                    </div>
                `;
            } else if (roleSelect.value === 'admin') {
                extraFields.innerHTML = `
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                `;
            }
        });
    </script>

</body>
</html>
