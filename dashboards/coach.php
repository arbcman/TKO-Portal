<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TKO Portal - Coach Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #121212;
            --card-bg: #1a1a1a;
            --accent-color: #ff3333;
            --accent-hover: #cc0000;
            --text-main: #ffffff;
            --text-muted: #aaaaaa;
            --border-color: #262626;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            margin: 0;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
        }

        .dashboard-wrapper {
            width: 100%;
            max-width: 1100px;
            display: flex;
            flex-direction: column;
            gap: 40px;
        }

        /* --- TOP CONTROL BAR --- */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 20px;
        }

        .dashboard-header h1 {
            margin: 0;
            font-size: 2.2rem;
            font-weight: 900;
            letter-spacing: -0.5px;
        }

        .dashboard-header h1 span {
            color: var(--accent-color);
        }

        .btn-logout {
            padding: 10px 20px;
            background-color: transparent;
            border: 1px solid var(--border-color);
            color: #ff4444;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .btn-logout:hover {
            background-color: #ff4444;
            color: #ffffff;
            border-color: #ff4444;
        }

        /* --- LEADERBOARD GRID SPLIT --- */
        .leaderboards-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .panel {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 24px;
        }

        .panel-title {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 1.2rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-left: 4px solid var(--accent-color);
            padding-left: 12px;
        }

        .leaderboard-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .leaderboard-table th {
            padding: 12px;
            font-size: 0.8rem;
            text-transform: uppercase;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
        }

        .leaderboard-table td {
            padding: 14px 12px;
            font-size: 0.95rem;
            border-bottom: 1px solid var(--border-color);
        }

        .rank-number {
            font-weight: 900;
            color: var(--accent-color);
            width: 50px;
        }

        /* --- ROSTER PROFILES SECTION --- */
        .roster-section h2 {
            font-size: 1.5rem;
            font-weight: 900;
            text-transform: uppercase;
            margin: 0 0 20px 0;
            letter-spacing: -0.5px;
        }

        .profiles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .profile-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 20px;
            transition: border-color 0.2s ease, transform 0.2s ease;
        }

        .profile-card:hover {
            border-color: var(--accent-color);
            transform: translateY(-2px);
        }

        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .profile-name {
            font-weight: 700;
            font-size: 1.1rem;
            margin: 0;
        }

        .discipline-badge {
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            padding: 4px 8px;
            border-radius: 4px;
            background-color: #242424;
            color: var(--text-muted);
            border: 1px solid var(--border-color);
        }

        .profile-card:hover .discipline-badge {
            color: var(--text-main);
        }

        .profile-stats {
            display: flex;
            gap: 24px;
        }

        .stat-item span {
            display: block;
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            margin-bottom: 4px;
            letter-spacing: 0.5px;
        }

        .stat-item strong {
            font-size: 1.1rem;
            font-weight: 700;
        }

        /* --- RESPONSIVE FIXES --- */
        @media (max-width: 850px) {
            .leaderboards-container { grid-template-columns: 1fr; }
            body { padding: 20px 10px; }
        }
    </style>
</head>
<body>

<div class="dashboard-wrapper">

    <div class="dashboard-header">
        <h1>TKO<span>PORTAL</span> // COACH</h1>
        <a href="../login.php" class="btn-logout">Exit Session</a>
    </div>

    <div class="leaderboards-container">
        
        <div class="panel">
            <h3 class="panel-title">Wrestling Leaderboard</h3>
            <table class="leaderboard-table">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Name</th>
                        <th>Weight</th>
                        <th>Record</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="rank-number">#1</td>
                        <td>Mahmoud Elshahed</td>
                        <td>74 kg</td>
                        <td style="font-weight: 600; color: #2ed573;">14 - 2</td>
                    </tr>
                    <tr>
                        <td class="rank-number">#2</td>
                        <td>Ahmed Aly</td>
                        <td>86 kg</td>
                        <td style="font-weight: 600;">10 - 4</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="panel">
            <h3 class="panel-title">BJJ Leaderboard</h3>
            <table class="leaderboard-table">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Name</th>
                        <th>Weight</th>
                        <th>Record</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="rank-number">#1</td>
                        <td>Alex Mercer</td>
                        <td>82 kg</td>
                        <td style="font-weight: 600; color: #2ed573;">12 - 1</td>
                    </tr>
                    <tr>
                        <td class="rank-number">#2</td>
                        <td>Omar Hassan</td>
                        <td>77 kg</td>
                        <td style="font-weight: 600; color: #2ed573;">9 - 5</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

    <div class="roster-section">
        <h2>Active Fighter Profiles</h2>
        <div class="profiles-grid">
            
            <div class="profile-card">
                <div class="profile-header">
                    <h4 class="profile-name">Abdo Elshahed</h4>
                    <span class="discipline-badge">Wrestling</span>
                </div>
                <div class="profile-stats">
                    <div class="stat-item">
                        <span>Class</span>
                        <strong>74 kg</strong>
                    </div>
                    <div class="stat-item">
                        <span>Record</span>
                        <strong style="color: #2ed573;">14 - 2</strong>
                    </div>
                </div>
            </div>

            <div class="profile-card">
                <div class="profile-header">
                    <h4 class="profile-name">Alex Mercer</h4>
                    <span class="discipline-badge">BJJ</span>
                </div>
                <div class="profile-stats">
                    <div class="stat-item">
                        <span>Class</span>
                        <strong>82 kg</strong>
                    </div>
                    <div class="stat-item">
                        <span>Record</span>
                        <strong style="color: #2ed573;">12 - 1</strong>
                    </div>
                </div>
            </div>

            <div class="profile-card">
                <div class="profile-header">
                    <h4 class="profile-name">Omar Hassan</h4>
                    <span class="discipline-badge">BJJ</span>
                </div>
                <div class="profile-stats">
                    <div class="stat-item">
                        <span>Class</span>
                        <strong>77 kg</strong>
                    </div>
                    <div class="stat-item">
                        <span>Record</span>
                        <strong style="color: #2ed573;">9 - 5</strong>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

</body>
</html>