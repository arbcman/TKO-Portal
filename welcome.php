<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TKO Portal - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #121212;
            --sidebar-bg: #181818;
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
            padding: 0;
            display: flex;
            min-height: 100vh;
        }

        /* --- SIDE NAVIGATION --- */
        aside {
            width: 260px;
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .aside-header {
            padding: 30px 24px;
            border-bottom: 1px solid var(--border-color);
        }

        .aside-header h2 {
            margin: 0;
            font-size: 1.4rem;
            font-weight: 900;
            letter-spacing: 1.5px;
        }

        .aside-header h2 span {
            color: var(--accent-color);
        }

        .menu-group {
            flex: 1;
            padding: 24px 16px;
        }

        .menu-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            padding-left: 12px;
            margin-bottom: 12px;
            display: block;
        }

        .menu-item {
            display: block;
            padding: 12px;
            color: var(--text-main);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            border-radius: 6px;
            margin-bottom: 4px;
            transition: all 0.2s ease;
        }

        .menu-item:hover, .menu-item.active {
            background-color: rgba(255, 51, 51, 0.1);
            color: var(--accent-color);
        }

        .aside-footer {
            padding: 20px 16px;
            border-top: 1px solid var(--border-color);
        }

        .btn-logout {
            display: block;
            text-align: center;
            padding: 10px;
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

        /* --- MAIN CONTENT AREA --- */
        main {
            flex: 1;
            padding: 40px;
            box-sizing: border-box;
            overflow-y: auto;
        }

        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 36px;
        }

        .main-header h1 {
            margin: 0;
            font-size: 2rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: -0.5px;
        }

        .user-badge {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            padding: 8px 16px;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background-color: #2ed573;
            border-radius: 50%;
        }

        /* --- STATS GRID --- */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }

        .stat-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 24px;
        }

        .stat-label {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 900;
            color: var(--text-main);
        }

        .stat-value span {
            color: var(--accent-color);
        }

        /* --- DASHBOARD SPLIT LAYOUT --- */
        .content-split {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
        }

        .panel {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 24px;
        }

        .panel-title {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 1.1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-left: 3px solid var(--accent-color);
            padding-left: 10px;
        }

        /* --- DATA TABLE STYLE --- */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .data-table th {
            padding: 12px;
            font-size: 0.8rem;
            text-transform: uppercase;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
        }

        .data-table td {
            padding: 14px 12px;
            font-size: 0.95rem;
            border-bottom: 1px solid var(--border-color);
        }

        .badge-win { color: #2ed573; font-weight: bold; }
        .badge-loss { color: #ff4757; font-weight: bold; }

        /* --- ANNOUNCEMENT FEED --- */
        .feed-item {
            padding-bottom: 16px;
            margin-bottom: 16px;
            border-bottom: 1px solid var(--border-color);
        }

        .feed-item:last-child {
            padding-bottom: 0;
            margin-bottom: 0;
            border-bottom: none;
        }

        .feed-date {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-bottom: 4px;
        }

        .feed-title {
            font-weight: 600;
            font-size: 0.95rem;
            margin: 0 0 4px 0;
        }

        .feed-body {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin: 0;
            line-height: 1.4;
        }

        /* Responsive UI adjustments */
        @media (max-width: 900px) {
            body { flex-direction: column; }
            aside { width: 100%; border-right: none; border-bottom: 1px solid var(--border-color); }
            .content-split { grid-template-columns: 1fr; }
            main { padding: 24px; }
        }
    </style>
</head>
<body>

    <aside>
        <div class="aside-header">
            <h2>TKO<span>PORTAL</span></h2>
        </div>
        <nav class="menu-group">
            <span class="menu-label">Navigation</span>
            <a href="dashboard.php" class="menu-item active">Overview</a>
            <a href="#" class="menu-item">Leaderboard</a>
            <a href="#" class="menu-item">Match Logs</a>
            <a href="#" class="menu-item">Roster Ranks</a>
        </nav>
        <div class="aside-footer">
            <a href="index.php" class="btn-logout">Exit Session</a>
        </div>
    </aside>

    <main>
        <div class="main-header">
            <h1>HQ Overview</h1>
            <div class="user-badge">
                <div class="status-dot"></div>
                Active User Profile
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Registered Fighters</div>
                <div class="stat-value">42<span> active</span></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Matches Logged</div>
                <div class="stat-value">184</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Next Club Event</div>
                <div class="stat-value">June 26</div>
            </div>
        </div>

        <div class="content-split">
            
            <div class="panel">
                <h3 class="panel-title">Recent Activity Log</h3>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Athlete</th>
                            <th>Opponent</th>
                            <th>Method</th>
                            <th>Outcome</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Mahmoud Elshahed</td>
                            <td>Alex Mercer</td>
                            <td>KO (Round 2)</td>
                            <td><span class="badge-win">WIN</span></td>
                        </tr>
                        <tr>
                            <td>John Doe</td>
                            <td>Jane Smith</td>
                            <td>Decision (Split)</td>
                            <td><span class="badge-loss">LOSS</span></td>
                        </tr>
                        <tr>
                            <td>Coach Thompson</td>
                            <td>Roster Update</td>
                            <td>System Event</td>
                            <td><span>LOG</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="panel">
                <h3 class="panel-title">Club Briefing</h3>
                
                <div class="feed-item">
                    <div class="feed-date">June 19, 2026</div>
                    <h4 class="feed-title">Sparring Schedule Update</h4>
                    <p class="feed-body">Heavyweight division matching starts next Friday at 18:00 sharp. Attendance is mandatory for rostered competitors.</p>
                </div>

                <div class="feed-item">
                    <div class="feed-date">June 15, 2026</div>
                    <h4 class="feed-title">System Update 1.0</h4>
                    <p class="feed-body">Database connection arrays upgraded successfully to PDO structures for real-time tracking accuracy.</p>
                </div>
            </div>

        </div>
    </main>

</body>
</html>