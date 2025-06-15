<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Logging Out</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        body {
            background-color: #16406d;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logout-box {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            max-width: 400px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- مثال على الـ Frontend -->
    <div class="logout-box">
        <h4 class="mb-3">Are you sure you want to logout?</h4>
        <form method="POST" action="../Auth/logout.php"> <!-- توجه إلى logout.php -->
            <button type="submit" class="btn btn-danger">Yes, Logout</button>
            <a type="button" class="btn btn-secondary ms-2" onclick="window.history.back()">Cancel</a>
            </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
