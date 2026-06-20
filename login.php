<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TKO Portal - Authentication</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #121212;
            --card-bg: #1a1a1a;
            --accent-color: #ff3333;
            --accent-hover: #cc0000;
            --text-main: #ffffff;
            --text-muted: #aaaaaa;
            --input-border: #333333;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }

        .login-container {
            background-color: var(--card-bg);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.7);
            width: 100%;
            max-width: 420px;
            border-top: 4px solid var(--accent-color);
        }

        .brand-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand-header h1 {
            font-weight: 900;
            letter-spacing: 2px;
            margin: 0;
            font-size: 2.2rem;
        }

        .brand-header h1 span {
            color: var(--accent-color);
        }

        .brand-header p {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin: 5px 0 0 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
        }

        .input-control {
            width: 100%;
            padding: 12px 16px;
            background-color: #242424;
            border: 1px solid var(--input-border);
            color: var(--text-main);
            border-radius: 6px;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .input-control:focus {
            outline: none;
            border-color: var(--accent-color);
            background-color: #2a2a2a;
            box-shadow: 0 0 0 3px rgba(255, 51, 51, 0.15);
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background-color: var(--accent-color);
            border: none;
            color: #ffffff;
            font-size: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.1s ease;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background-color: var(--accent-hover);
        }

        .btn-submit:active {
            transform: scale(0.98);
        }

        .form-footer {
            text-align: center;
            margin-top: 25px;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .form-footer a {
            color: var(--accent-color);
            text-decoration: none;
            font-weight: 600;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="brand-header">
        <h1>TKO<span>PORTAL</span></h1>
        <p>Secure Access Gateway</p>
    </div>
    
    <form action="dashboard.php" method="POST">
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" class="input-control" placeholder="name@example.com" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="input-control" placeholder="••••••••" required> 
        </div>

        <button type="submit" class="btn-submit">AUTHENTICATE ACCOUNT</button>
    </form>

    <div class="form-footer">
        New candidate to the roster? <a href="register.php">Create Account</a>
    </div>
</div>

</body>
</html>