<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// 1. Session Protection Gatekeeper
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'coach') {
    header("Location: ../login.php");
    exit();
}

// ANTI-CACHE HEADERS: Prevents back-button tracking issues
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$mysqli = new mysqli('localhost', 'root', '', 'TKO-Portal_db');
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// 2. Handle Stat Increments AND Profile Deletions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['user_id'])) {
    $target_id = intval($_POST['user_id']);
    $action = $_POST['action'];
    
    if (in_array($action, ['wins', 'losses', 'draws'])) {
        // Increment records
        $mysqli->query("UPDATE fighter_profile SET $action = $action + 1 WHERE user_id = $target_id");
    } else if ($action === 'delete_profile') {
        // COORDINATED DELETE ENGINE
        // First, drop the dependent profile child record to avoid key assignment locks
        $mysqli->query("DELETE FROM fighter_profile WHERE user_id = $target_id");
        // Next, drop the main master user account row entirely
        $mysqli->query("DELETE FROM users WHERE user_id = $target_id");
    }
    
    // Redirect back to itself to cleanly refresh the visual tallies and lists
    header("Location: coach.php");
    exit();
}

// 3. Fetch All Registered Fighters and Their Associated Metrics (Alphabetical)
$rosterQuery = $mysqli->query("
    SELECT u.user_id, u.name, f.sport, f.weight_kg, f.wins, f.losses, f.draws 
    FROM users u
    JOIN fighter_profile f ON u.user_id = f.user_id
    ORDER BY u.name ASC
");

if (!$rosterQuery) {
    die("Database Error on Roster Query: " . $mysqli->error);
}

// 4. Fetch Global Leaderboard Data (Ranked by highest wins, then lowest losses)
$leaderboardQuery = $mysqli->query("
    SELECT u.name, f.sport, f.weight_kg, f.wins, f.losses, f.draws 
    FROM users u
    JOIN fighter_profile f ON u.user_id = f.user_id
    ORDER BY f.wins DESC, f.losses ASC, f.draws DESC
");

if (!$leaderboardQuery) {
    die("Database Error on Leaderboard Query: " . $mysqli->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TKO Portal - Coach Roster Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #0d0d0d;
            --card-bg: #161616;
            --accent-color: #ff3333;
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

        /* Panels Shared Layout Styles */
        .roster-panel, .leaderboard-panel {
            background-color: var(--card-bg);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.6);
            margin-bottom: 40px;
        }

        .roster-panel h3, .leaderboard-panel h3 {
            margin: 0 0 25px 0;
            font-size: 1.4rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .roster-table, .leaderboard-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .roster-table th, .leaderboard-table th {
            padding: 12px;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
            letter-spacing: 0.5px;
        }

        .roster-table td, .leaderboard-table td {
            padding: 16px 12px;
            font-size: 0.95rem;
            border-bottom: 1px solid #1f1f1f;
            vertical-align: middle;
        }

        .roster-table tr:hover td, .leaderboard-table tr:hover td {
            background-color: #1c1c1c;
        }

        .fighter-meta {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .tally-badge {
            font-weight: 700;
            font-size: 1.05rem;
        }

        .rank-badge {
            font-weight: 700;
            color: var(--text-muted);
        }

        /* Podium styling accents */
        tr:nth-child(1) .rank-badge { color: #ffd700; } 
        tr:nth-child(2) .rank-badge { color: #c0c0c0; } 
        tr:nth-child(3) .rank-badge { color: #cd7f32; } 

        /* Interactive Control Buttons */
        .btn-group {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn-control {
            border: none;
            padding: 8px 14px;
            border-radius: 4px;
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            cursor: pointer;
            transition: opacity 0.2s ease, transform 0.1s ease;
            color: #ffffff;
        }

        .btn-win  { background-color: #2ed573; }
        .btn-loss { background-color: #ff3333; }
        .btn-draw { background-color: #33a1ff; }
        .btn-delete { background-color: #444444; border: 1px solid #555555; }

        .btn-control:hover { opacity: 0.85; }
        .btn-control:active { transform: scale(0.96); }
        .btn-delete:hover { background-color: #b30000; border-color: #ff3333; }
    </style>
</head>
<body>

<div class="dashboard-wrapper">
    <div class="dash-header">
        <h1>COACH<span>CONSOLE</span></h1>
        <a href="../logout.php" class="btn-logout">Sign Out</a>
    </div>

    <div class="roster-panel">
        <h3>Active Team Roster</h3>
        <table class="roster-table">
            <thead>
                <tr>
                    <th>Competitor</th>
                    <th>Discipline</th>
                    <th>Weight</th>
                    <th>Current Record (W/L/D)</th>
                    <th>Actions / Update Stats</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($rosterQuery->num_rows > 0): ?>
                    <?php while($row = $rosterQuery->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <div class="fighter-meta">
                                    <div style="font-weight: 600;"><?php echo htmlspecialchars($row['name']); ?></div>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($row['sport'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($row['weight_kg'] ?? '0'); ?> kg</td>
                            <td class="tally-badge">
                                <span style="color: #2ed573;"><?php echo $row['wins']; ?>W</span> / 
                                <span style="color: #ff3333;"><?php echo $row['losses']; ?>L</span> / 
                                <span style="color: #33a1ff;"><?php echo $row['draws']; ?>D</span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <form action="coach.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                        <input type="hidden" name="action" value="wins">
                                        <button type="submit" class="btn-control btn-win">+ Win</button>
                                    </form>

                                    <form action="coach.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                        <input type="hidden" name="action" value="losses">
                                        <button type="submit" class="btn-control btn-loss">+ Loss</button>
                                    </form>

                                    <form action="coach.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                        <input type="hidden" name="action" value="draws">
                                        <button type="submit" class="btn-control btn-draw">+ Draw</button>
                                    </form>

                                    <form action="coach.php" method="POST" style="display:inline;" onsubmit="return confirm('Are you completely sure you want to permanently delete <?php echo addslashes($row['name']); ?> from the portal database?');">
                                        <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                        <input type="hidden" name="action" value="delete_profile">
                                        <button type="submit" class="btn-control btn-delete">Wipe Profile</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 30px;">No registered fighters are currently assigned to your roster directory.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
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
                    while($lbRow = $leaderboardQuery->fetch_assoc()): 
                ?>
                    <tr>
                        <td class="rank-badge">#<?php echo $rank++; ?></td>
                        <td style="font-weight: 600;"><?php echo htmlspecialchars($lbRow['name']); ?></td>
                        <td><?php echo htmlspecialchars($lbRow['sport'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($lbRow['weight_kg'] ?? '0'); ?> kg</td>
                        <td style="text-align: right; font-weight: 700; letter-spacing: 0.5px;">
                            <span style="color: #2ed573;"><?php echo $lbRow['wins']; ?></span>-<span style="color: #ff3333;"><?php echo $lbRow['losses']; ?></span>-<span style="color: #33a1ff;"><?php echo $lbRow['draws']; ?></span>
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

</body>
</html>