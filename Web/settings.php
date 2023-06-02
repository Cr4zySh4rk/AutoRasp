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
        <script type="text/javascript">
            function EnableDisableTextBox(chkPassport) {
                var txtPassportNumber = document.getElementById("portarea");
                txtPassportNumber.disabled = chkPassport.checked ? false : true;
                if (!txtPassportNumber.disabled) {
                    txtPassportNumber.focus();
                }
                
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
                        <a href="" class="active"><span class="fa-solid fa-gear"></span>
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
                    <span class="fa-solid fa-gear"></span>
                    </label>
                    Settings
                </h2>
            </header>

            <main>
                <form action="" method="post">
                <div class="ethernet">
                    <div class="ethernet_switch">
                        <h2>Ethernet: 
                        <select class="ftp_select" name="net">
                                        <option value="">Select</option>
                                        <option value="1">Enable</option>
                                        <option value="0">Disable</option>
                                    </select>
                            
                        </h2>
                    </div>
                    <div class="ethernet_save">
                        <h2>
                            <input type="submit" name="net-save" class="button" value="Save" >
                        </h2>
                    </div>
                </div>
                <div class="storage">
                    <div class="storage_area">
                        <h2>Storage:  
                            <input type="text" name="size" placeholder="Max: 1000Mb" class="textbox">Mb
                        </h2>
                        
                    </div>
                    <div class="storage_save">
                        <h2>
                            <input type="submit" name="storesave" class="button" value="Set" >
                        </h2>
                    </div>
                    
                </div>
                <div class="ftp">
                    
                    <div class="ftp_enable">
                        
                        <h2>FTP: <label class="switch">
                        <select class="ftp_select" name="ftp">
                                        <option value="">Select</option>
                                        <option value="1">Enable</option>
                                        <option value="0">Disable</option>
                                    </select>
                        </h2>
                    </div>
                    <div class="ftp_port">
                        <h2>Port #:  
                            <input type="text" id="portarea" name="ftp-port" placeholder="Default port:21" class="textbox">
                        </h2>
                    </div>
                    <div class="ftp_options">
                        <h2><input type="submit" class="button" name="ftp-def" value="Default" id="defbut">
                            <input type="submit" class="button" name="ftp-save" value="Save" id="savebut">
                        </h2>
                    
                    </div>
                    
                </div>
                <div class="system">
                    <div class="system_head">
                        <h2>System:</h2>
                    </div>
                    <div class="system_body">
                        <h2><span class="fa-solid fa-power-off"></span><input type="submit" class="button" name="shutdown" value="Shutdown" onclick="alert('Shutting down!')"></h2>
                        <h2><span class="fa-solid fa-clock-rotate-left"></span><input type="submit" class="button" name="reboot" value="Reboot" onclick="alert('Rebooting system...')"></h2>
                    </div>
                </div><br><br>
                <div class="system">
                    <div class="system_head">
                        <h2>Themes:</h2>
                    </div><br>
                    <div class="system_body">
                        <select class="ftp_select" name="themes">
                            <option value="">Select theme</option>
                            <option value="dark.css">Dark (Default)</option>
                            <option value="cherry.css">Cherry</option>
                            <option value="lime.css">Lime</option>
                            <option value="mango.css">Mango</option>
                            <option value="grape.css">Grape</option>
                            <option value="orange.css">Orange</option>
                        </select>
                        <input type="submit" name="themesave" class="button" value="Add" >
                    </div>
                </div>
                </form>
            </main>
        </div>

    </body>
</html>

<?php
if(isset($_POST['net-save'])) {
   $netstat=$_POST['net'];
   if ($netstat == 0) {
    shell_exec("sudo cp /home/dietpi/Scripts/noE.sh /var/lib/dietpi/postboot.d/hidsetup.sh");
    shell_exec("sudo chmod +x /var/lib/dietpi/postboot.d/hidsetup.sh");
   }
   else if ($netstat == 1){
    shell_exec("sudo cp /home/dietpi/Scripts/hidsetup.sh /var/lib/dietpi/postboot.d/hidsetup.sh");
    shell_exec("sudo chmod +x /var/lib/dietpi/postboot.d/hidsetup.sh");
   }
  }
if(isset($_POST['storesave'])) {
    $size=$_POST['size'];
    if ($size >= 0 && $size <=1000) {
        $size=$size*1024;
        shell_exec("nohup bash /home/dietpi/Scripts/storage.sh $size");
    }
  }

if(isset($_POST['ftp-save'])) {
    $ftp=$_POST['ftp'];
    if ($ftp == 0) {
        shell_exec("sudo service proftpd stop");
    }
    else if ($ftp == 1) {
        $port=$_POST['ftp-port'];
        if ($port>=0 && $port<=65535) {
            shell_exec("sudo sed -i 's/^Port.*/Port $port/' /etc/proftpd/proftpd.conf");
            shell_exec("sudo service proftpd restart");
        }
        else {
            shell_exec("sudo cp /etc/proftpd/proftpd.conf.orig /etc/proftpd/proftpd.conf");
            shell_exec("sudo service proftpd restart");
        }
    }


  }

  if(isset($_POST['ftp-def'])) {
    shell_exec("sudo cp /etc/proftpd/proftpd.conf.orig /etc/proftpd/proftpd.conf");
    shell_exec("sudo service proftpd restart");
  }

  if(isset($_POST['reboot'])) {
    shell_exec("sudo reboot");
  }

  if(isset($_POST['shutdown'])) {
    shell_exec("sudo shutdown -r now");
  }

  if(isset($_POST['themesave'])) {
    $theme=$_POST['themes'];
    if($theme != "Select theme" || $ch != "")
        shell_exec("sudo cp css/$theme css/style.css");
  }

?>
