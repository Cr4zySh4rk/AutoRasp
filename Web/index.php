<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <Title>AutoRasp</Title>
        <script src="res/icons.js"></script>
        <link rel="stylesheet" href="css/all.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="icon" type="png" href="res/titlelogo.png" />
    </head>
    <body>
        <input type="checkbox" id="nav-toggle">
        <div class="sidebar">
            <div class="sidebar-brand">
                <h1><span><img src="res/logo.png" width="50px" height="73px" alt=""></span><span>AutoRasp</span></h1>
            </div>
            <div class="sidebar-menu">
                <ul>
                    <li>
                        <a href="index.php" class="active"><span class="fa-solid fa-house"></span>
                            <span>Dashboard</span></a>
                    </li>
                    <li>
                        <a href="settings.php"><span class="fa-solid fa-gear"></span>
                            <span>Settings</span></a>
                    </li>
                    <li>
                        <a href="scripts.php"><span class="fa-solid fa-scroll"></span>
                            <span>Python Scripts</span></a>
                    </li>
                    <li>
                        <a href="wifi.php"><span class="fa-solid fa-wifi"></span>
                            <span>WiFi Settings</span></a>
                    </li>
                    <li>
                        <a href="docs.php"><span class="fa-solid fa-book"></span>
                            <span>Documentation</span></a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="main-content">
            <header>
                <h2>
                    <label for="nav-toggle">
                    <span class="fa-solid fa-bars"></span>
                    </label>
                    Dashboard
                </h2>
            </header>
            <main>
                <div class="cards">
                    <div class="card-single">
                        <div>
                            <h1>
                                <a href="settings.php">Storage Settings</a>
                            </h1>
                        </div>
                        <div>
                            <span><a href="settings.php" class="fa-solid fa-database" style="font-size: 4rem;"></a></span>
                        </div>
                    </div>
                    <div class="card-single">
                        <div>
                            <h1>
                                <a href="scripts.php">Python Scripts</a>
                            </h1>
                        </div>
                        <div>
                            <span><a href="settings.php" class="fa-solid fa-scroll" style="font-size: 4rem;"></a></span>
                        </div>
                    </div>
                    <div class="card-single">
                        <div>
                            <h1>
                                <a href="wifi.php">WiFi Settings</a>
                            </h1>
                        </div>
                        <div>
                            <span><a href="settings.php" class="fa-solid fa-wifi" style="font-size: 4rem;"></a></span>
                        </div>
                    </div>
                    <div class="card-single">
                        <div>
                            <h1>
                                <a href="settings.php">FTP Settings</a>
                            </h1>
                        </div>
                        <div>
                            <span><a href="settings.php" class="fa-solid fa-file-export" style="font-size: 4rem;"></a></span>
                        </div>
                    </div>
                    <div class="card-single">
                        <div>
                            <h1>
                                <a href="settings.php">System Settings</a>
                            </h1>
                        </div>
                        <div>
                            <span><a href="settings.php" class="fa-solid fa-microchip" style="font-size: 4rem;"></a></span>
                        </div>
                    </div>

                    <div class="card-single">
                        <div>
                            <h1 style="font-family: myfont"><?php
                            $uptime = shell_exec("uptime | awk '{print $3 $4}' | sed 's/.$//'");
                            echo("Uptime: $uptime");
                            ?></h1>
                        </div>
                        <div>
                            <span><a href="settings.php" class="fa-solid fa-globe" style="font-size: 4rem;"></a></span>
                        </div>
                    </div>
                   
                </div>
            </main>
        </div>

    </body>
</html>
