<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Bukit Pandan Hotel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #000000;
        }
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #000000;
            color: white;
            padding: 1rem 2rem;
        }
        header img {
            height: 140px;
			margin-right: -100px;
        }
        header h1 {
            flex-grow: 1;
            text-align: center;
            margin: 0;
            color: #FFD700;
        }
        .admin-container {
            max-width: 900px;
            margin: 2rem auto;
            background-color: white;
            padding: 2rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            border-radius: 8px;
        }
        h1 {
            color: #FFD700;
        }
        .button {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            margin-top: 2rem;
            color: white;
            background-color: #FFD700;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #000000;
        }
    </style>
</head>
<body>
    <header>
        <img src="logobp.png" alt="Bukit Pandan Hotel Logo">
        <h1>Admin Panel - Bukit Pandan Hotel</h1>
    </header>

    <div class="admin-container">
        <h1>Welcome, Admin</h1>
        <p>Use the button below to access the Admin Dashboard.</p>
        <a href="admin_dashboard.php" class="button">Admin Dashboard</a>
        <p style="margin-top: 2rem;">
            <a href="logout.php" class="button" style="background-color: #000000;">Logout</a>
        </p>
    </div>
</body>
</html>
