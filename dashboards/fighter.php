<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// 1. Session Protection Gatekeeper
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'fighter') {
    header("Location: ../login.php");
    exit();
}

$mysqli = new mysqli('localhost', 'root', '', 'TKO-Portal_db');
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$email = $_SESSION['email'];

// 2. Fetch Logged-in Fighter's Profile Data (Including new record counters)
$profileQuery = $mysqli->query("
    SELECT u.name, f.sport, f.weight_kg, f.wins, f.losses, f.draws 
    FROM users u
    JOIN fighter_profile f ON u.user_id = f.user_id
    WHERE u.email = '$email'
");

$fighter = $profileQuery->fetch_assoc();

// 3. Fetch Global Leaderboard Data (Ranked by highest wins, then lowest losses)
$leaderboardQuery = $mysqli->query("
    SELECT u.name, f.sport, f.weight_kg, f.wins, f.losses, f.draws 
    FROM users u
    JOIN fighter_profile f ON u.user_id = f.user_id
    ORDER BY f.wins DESC, f.losses ASC, f.draws DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TKO Portal - Fighter Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #0d0d0d;
            --card-bg: #161616;
            --accent-color: #ff3333;
            --accent-hover: #cc0000;
            --text-main: #ffffff;
            --text-muted: #888888;
            --border-color: #222222;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            margin: 0;
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            box-sizing: border-box;
        }

        .dashboard-wrapper {
            width: 100%;
            max-width: 950px;
        }

        /* Top Navigation Header */
        .dash-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 20px;
        }

        .dash-header h1 {
            margin: 0;
            font-weight: 900;
            letter-spacing: 1px;
            font-size: 1.8rem;
        }

        .dash-header h1 span {
            color: var(--accent-color);
        }

        .btn-logout {
            background-color: transparent;
            border: 1px solid var(--accent-color);
            color: var(--accent-color);
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            transition: all 0.2s ease;
        }

        .btn-logout:hover {
            background-color: var(--accent-color);
            color: #ffffff;
        }

        /* Two-Column Workspace Layout */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
        }

        @media (min-width: 768px) {
            .dashboard-grid {
                grid-template-columns: 340px 1fr;
            }
        }

        /* Fighter Identity Profile Card */
        .fighter-card {
            background-color: var(--card-bg);
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            border-top: 4px solid var(--accent-color);
            box-shadow: 0 8px 32px rgba(0,0,0,0.6);
            height: fit-content;
        }

        .avatar-container {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin: 0 auto 20px auto;
            border: 3px solid var(--accent-color);
            overflow: hidden;
            background-color: #222;
        }

        .avatar-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .fighter-card h2 {
            margin: 0 0 5px 0;
            font-size: 1.6rem;
            font-weight: 700;
        }

        .fighter-tag {
            color: var(--accent-color);
            text-transform: uppercase;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 25px;
        }

        .stats-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            border-top: 1px solid var(--border-color);
            padding-top: 20px;
            margin-bottom: 20px;
        }

        .stat-box label {
            display: block;
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }

        .stat-box span {
            font-size: 1.1rem;
            font-weight: 700;
        }

        .record-box {
            background-color: #1a1a1a;
            border: 1px solid var(--border-color);
            padding: 14px;
            border-radius: 6px;
            font-weight: 900;
            font-size: 1.3rem;
            letter-spacing: 1px;
        }

        .record-box label {
            display: block;
            font-size: 0.7rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
            font-weight: 600;
        }

        /* Leaderboard Panel Layout */
        .leaderboard-panel {
            background-color: var(--card-bg);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.6);
        }

        .leaderboard-panel h3 {
            margin: 0 0 20px 0;
            font-size: 1.3rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .leaderboard-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .leaderboard-table th {
            padding: 12px;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
            letter-spacing: 0.5px;
        }

        .leaderboard-table td {
            padding: 14px 12px;
            font-size: 0.95rem;
            border-bottom: 1px solid #1f1f1f;
        }

        .leaderboard-table tr:hover td {
            background-color: #1c1c1c;
        }

        .rank-badge {
            font-weight: 700;
            color: var(--text-muted);
        }

        /* Podium styling accents */
        tr:nth-child(1) .rank-badge { color: #ffd700; } 
        tr:nth-child(2) .rank-badge { color: #c0c0c0; } 
        tr:nth-child(3) .rank-badge { color: #cd7f32; } 

    </style>
</head>
<body>

<div class="dashboard-wrapper">
    <div class="dash-header">
        <h1>TKO<span>PORTAL</span></h1>
        <a href="../logout.php" class="btn-logout">Sign Out</a>
    </div>
<script>
    document.querySelector('.btn-logout').addEventListener('click', function(event) {
            endSession();
        
    });
</script>
    <div class="dashboard-grid">
        
        <div class="fighter-card">
            <h2><?php echo htmlspecialchars($fighter['name']); ?></h2>
            <div class="fighter-tag">Roster Competitor</div>
            
            <div class="stats-row">
                <div class="stat-box">
                    <label>Discipline</label>
                    <span><?php echo htmlspecialchars($fighter['sport'] ?? 'N/A'); ?></span>
                </div>
                <div class="stat-box">
                    <label>Weight Class</label>
                    <span><?php echo htmlspecialchars($fighter['weight_kg'] ?? '0'); ?> kg</span>
                </div>
            </div>

            <div class="record-box">
                <label>Combat Record</label>
                <span style="color: #2ed573;"><?php echo $fighter['wins']; ?>W</span>
                <span style="color: var(--text-muted); font-weight: 400;">/</span>
                <span style="color: #ff3333;"><?php echo $fighter['losses']; ?>L</span>
                <span style="color: var(--text-muted); font-weight: 400;">/</span>
                <span style="color: #33a1ff;"><?php echo $fighter['draws']; ?>D</span>
            </div>
        </div>

        <div class="leaderboard-panel">
            <h3>Combat Standings</h3>
            <table class="leaderboard-table">
                <thead>
                    <tr>
                        <th style="width: 70px;">Rank</th>
                        <th>Competitor</th>
                        <th>Style</th>
                        <th>Weight</th>
                        <th style="text-align: right;">Record (W-L-D)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $rank = 1;
                    if ($leaderboardQuery->num_rows > 0):
                        while($row = $leaderboardQuery->fetch_assoc()): 
                    ?>
                        <tr>
                            <td class="rank-badge">#<?php echo $rank++; ?></td>
                            <td style="font-weight: 600;"><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['sport'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($row['weight_kg'] ?? '0'); ?> kg</td>
                            <td style="text-align: right; font-weight: 700; letter-spacing: 0.5px;">
                                <span style="color: #2ed573;"><?php echo $row['wins']; ?></span>-<span style="color: #ff3333;"><?php echo $row['losses']; ?></span>-<span style="color: #33a1ff;"><?php echo $row['draws']; ?></span>
                            </td>
                        </tr>
                    <?php 
                        endwhile;
                    else:
                    ?>
                        <tr>
                            <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 30px;">No active profiles detected in system registry.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

</body>
</html>