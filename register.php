<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TKO Portal - Fighter Registration</title>
    <link href="https://fonts.googleapis.com/css2?family=Chalan:wght@700&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #121212;
            --card-bg: #1a1a1a;
            --accent-color: #ff3333;
            --accent-hover: #cc0000;
            --text-main: #ffffff;
            --text-muted: #aaaaaa;
            --input-border: #333333;
            --input-focus: #555555;
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

        .register-container {
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
            font-family: 'Inter', sans-serif;
            font-weight: 900;
            letter-spacing: 2px;
            margin: 0;
            font-size: 2.2rem;
            color: var(--text-main);
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

        .msg-box {
            margin-bottom: 20px;
            font-size: 0.95rem;
            text-align: center;
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

        select.input-control {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23aaaaaa' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 16px;
            padding-right: 40px;
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

<div class="register-container">
    <div class="brand-header">
        <h1>TKO<span>PORTAL</span></h1>
        <p>Combat Club Management</p>
    </div>

    <?php if (!empty($message)): ?>
        <div class="msg-box"><?php echo $message; ?></div>
    <?php endif; ?>
    
    <form action="register.php" method="POST">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" class="input-control" placeholder="e.g., Khabib Nurmagomedov" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" class="input-control" placeholder="name@example.com" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="input-control" placeholder="••••••••" required>
        </div>
        
        <div class="form-group">
            <label for="role">System Access Role</label>
            <select id="role" name="role" class="input-control" required>
                <option value="" disabled selected>Select your access tier...</option>
                <option value="fighter">Fighter (Track stats & matches)</option>
                <option value="coach">Coach (Manage rosters & logs)</option>
            </select>
        </div>
        
        <button type="submit" class="btn-submit">Initialize Account</button>
    </form>

    <div class="form-footer">
        Already have an account? <a href="login.php">Log In</a>
    </div>
</div>

</body>
</html>