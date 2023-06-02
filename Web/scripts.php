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
                        <a href="" class="active"><span class="fa-solid fa-scroll"></span>
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
                    <span class="fa-solid fa-scroll"></span>
                    </label>
                    Python Scripts
                </h2>
            </header>

            <main>
                <div class="script">
                    <form id="form" method="POST">
                        <textarea name="data" id="typedtext" class="textarea" placeholder="Type script here..."></textarea>
                        <div class="scriptoptions">
                            <div class="savepayload">
                                <input type ="text" name="file" class="textbox" placeholder="Enter filename...">
                                <input type="submit" name="save" class="button" value="Save"  onclick="alert('Saved.')">
                            </div>
                                <div class="savedpayloads">
                                    <select name="payloads" class="channel">
                                        <option>Select payload</option>
                                        <?php
                                                        $dirpath="/home/dietpi/Payloads";
                                                        $filenames="";
                                                        if(is_dir($dirpath))
                                                        {
                                                            $files=opendir($dirpath);
                                                            if($files)
                                                            {
                                                                while(($filename=readdir($files))!=false)
                                                                {
                                                                    if(preg_match("/^.*\.pd$/",$filename) || preg_match("/^.*\.py$/",$filename))
                                                                    {
                                                                        $filenames=$filenames."<option>$filename</option>";
                                                                    }
                                                                }
                                                             }
                                                        }
                                            ?>
                                            <?php echo $filenames; ?>
                                    </select><input type="submit" name="run" class="button" value="Run" onclick="alert('Running script.')">
                                    <input type="submit" name="stop" class="button" value="Stop" onclick="alert('Stopping script.')">
                                </div>
                        </div>
                    </form>
                </div>
            </main>
        </div>

    </body>
</html>

<?php
    if(isset($_POST["save"])) {
        $data=$_POST["data"];
	$data=str_replace("\r","",$data);
        $file=$_POST["file"];
        $file="/home/dietpi/Payloads/".$file;
        $fo=fopen($file,"w");
        fwrite($fo,$data);
	fclose($fo);
    }
    if(isset($_POST["run"])) {
        if($_POST["payloads"] != "Select payload") {
        $payload=$_POST["payloads"];
        if(preg_match("/^.*\.pd$/",$payload)) {
            $payload="/home/dietpi/Payloads/".$payload;
            shell_exec("cp $payload /home/dietpi/Interpreter/payload.pd");
            shell_exec("chmod +x /home/dietpi/Interpreter/piducky.sh");
            shell_exec("sudo bash /home/dietpi/Interpreter/piducky.sh /home/dietpi/Interpreter/payload.pd");
        }
        else if (preg_match("/^.*\.py$/",$payload)) {
            $payload="/home/dietpi/Payloads/".$payload;
            shell_exec("nohup sudo python3 $payload");
        }
        }
    }
    if(isset($_POST["stop"]))
        shell_exec("nohup sudo killall python3");
?>
