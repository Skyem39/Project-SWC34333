<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Access - Bukit Pandan Hotel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .pre-login-container {
            background-color: white;
            padding: 2rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            text-align: center;
            width: 400px;
        }

        h1 {
            color: #FFD700;
            margin-bottom: 1rem;
        }

        p {
            margin-bottom: 2rem;
            color: #333;
        }

        .button {
            background-color: #FFD700;
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #000000;
        }
    </style>
</head>
<body>
    <div class="pre-login-container">
        <h1>Welcome to Admin Access</h1>
        <p>Click the button below to proceed to the admin login page.</p>
        <a href="login.php" class="button">Proceed to Admin Login</a>
    </div>
</body>
</html>
