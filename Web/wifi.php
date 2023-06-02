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
        <script>
            function confirm() {
                alert("A reboot is required to apply changes to WiFi settings!");
            }
        </script>
    </head>
    <body>
        <input type="checkbox" id="nav-toggle">
        <div class="sidebar">
            <div class="sidebar-brand">
                <h1><span><img src="res/logo.png" width="50px" height="73px" alt=""></span><span><a href="index.php">AutoRasp</a></span></h1>
            </div>
            <div class="sidebar-menu">
                <ul>
                    <li>
                        <a href="index.php"><span class="fa-solid fa-house"></span>
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
                        <a href="" class="active"><span class="fa-solid fa-wifi"></span>
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
                    <span class="fa-solid fa-wifi"></span>
                    </label>
                    WiFi Settings
                </h2>
            </header>

            <main>
                <div class="wifi">
                    <span class="fa-solid fa-wifi" style="font-size: 7rem; color: var(--main-color)"></span>
                    <div class="wifisettings">
                        <span>
                            <form action="wifi.php" method="post">
                                <div class="creds">
                                    <div class="ssid">
                                        <label class="wifilabel" for="SSID">SSID:</label>
                                        <input type="text" class="textbox" id="SSID" name="SSID" placeholder="(min length: 2)">
                                    </div>
                                    <div class="password">
                                        <label class="wifilabel" for="Password">Password:</label>
                                        <input type="text" class="textbox" id="Password" name="Password" placeholder="(min length: 8)">
                                    </div>
                                </div>
                                <div>
                                    <label class="wifilabel" for="Channel">Channel:</label>
                                    <select class="channel"name="Channel">
                                        <option value="">Select</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                    </select>
                                </div>
                                <div class="wifibutton">
                                    <input type="submit" class="button" value="Apply" name="apply" data-inline="true" onclick="confirm()">
                                    <input type="submit" class="button" value="Default" name="noapply" data-inline="true" onclick="confirm()">
                                </div>
                            </form>
                        </span>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>

<?php
if(isset($_POST['apply'])) {
   $ssid = $_POST["SSID"];
   $passwd = $_POST["Password"];
   $ch = $_POST["Channel"];
   if($ch != "Select" || $ch != "") {
    shell_exec("nohup sudo bash /home/dietpi/Scripts/cngwifi.sh $ssid $passwd $ch");
   }
   else {
    shell_exec("nohup sudo bash /home/dietpi/Scripts/cngwifi.sh $ssid $passwd 7");
   }
  }
if(isset($_POST['noapply'])) {
   shell_exec("sudo cp /etc/hostapd/hostapd.conf.orig /etc/hostapd/hostapd.conf");
  }
?>
