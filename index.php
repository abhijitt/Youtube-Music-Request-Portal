<!DOCTYPE html>
<html>
    <head>
        <title>
            YouTube Song Request
        </title>
        <link href='https://fonts.googleapis.com/css?family=Roboto|Oswald|Open Sans|Montserrat' rel='stylesheet' type='text/css'>
        <style type="text/css">
        body{
            background:
            linear-gradient(45deg, #a1e877 45px, transparent 45px)64px 64px,
            linear-gradient(45deg, #a1e877 45px, transparent 45px,transparent 91px, #f5f4f7 91px, #f5f4f7 135px, transparent 135px),
            linear-gradient(-45deg, #a1e877 23px, transparent 23px, transparent 68px,#a1e877 68px,#a1e877 113px,transparent 113px,transparent 158px,#a1e877 158px);
            background-color:#f5f4f7;
            background-size: 128px 128px;
        }
        #timer{
                font-family: "Monospace";
        }
        </style>
        <script type="text/javascript" >
            window.onload = function(){
                var target_date = new Date("Dec 26, 2014").getTime();
                var current_date = new Date().getTime();
                var centiseconds_left = (target_date - current_date + 36000000)/10;
                CreateTimer("timer", centiseconds_left);
            }

            var Timer;
            var TotalcSeconds;


            function CreateTimer(TimerID, Time) {
            Timer = document.getElementById(TimerID);
            TotalcSeconds = Time;

            UpdateTimer()
            window.setTimeout("Tick()", 1);
            }

            function Tick() {
            if (TotalcSeconds <= 0) {
            alert("Time's up!")
            return;
            }

            TotalcSeconds -= 1;
            UpdateTimer()
            window.setTimeout("Tick()", 10);
            }
             

            function UpdateTimer() {
            var target_date = new Date("Dec 26, 2014").getTime();
            var current_date = new Date().getTime();
            var centiseconds_left = (target_date - current_date + 36000000)/10;

            var cSeconds = TotalcSeconds;

            var cSeconds=centiseconds_left;
            var Days = Math.floor(cSeconds / 8640000);
            cSeconds -= Days * 8640000;
            var Hours = Math.floor(cSeconds / 360000);
            cSeconds -= Hours * (360000);
            var Minutes = Math.floor(cSeconds / 6000);
            cSeconds -= Minutes * (6000);
            var Seconds = Math.floor(cSeconds / 100);
            cSeconds -= Seconds * (100);

            var TimeStr = ((Days > 0) ? Days + " DAYS " : "") + LeadingZero(Hours) + ":" + LeadingZero(Minutes) + ":" + LeadingZero(Seconds) + "." + LeadingZero(Math.floor(cSeconds))
            Timer.innerHTML = TimeStr;
            }

            function LeadingZero(Time) {
            return (Time < 10) ? "0" + Time : + Time;
            }
        </script>
    </head>
    <body>
    <h1 style="text-align:center; font-family:Roboto;">MI 2014 YOGA ROOM <div id='timer' /></h1>
	<?php
    echo "<h2 style='font-family:Oswald;'>PLAYLIST:</h2>\n\t\t<ul>";
    $file = ('playlist.txt');
    $fh = fopen($file, "r") or die('Could not open file!');
    $data = fread($fh, filesize($file)) or die('Could not read file!');
    fclose($fh);
    
    
    $ldap_id=$_POST["id"];
    $ldap_password=$_POST["pass"];

    $ds = ldap_connect("ldap.iitb.ac.in") or die("Unable to connect to LDAP server. Please try again later.");
    // if($ldap_id=='') die("You have not entered any LDAP ID. Please go back and fill it up.");
    // if($ldap_password=='') die("You have not entered any password. Please go back and fill it up.");
    $sr = ldap_search($ds,"dc=iitb,dc=ac,dc=in","(uid=$ldap_id)");
    $info = ldap_get_entries($ds, $sr);
        $roll = $info[0]["employeenumber"][0];
        //print_r($info);
    $ldap_id = $info[0]['dn'];
    if(@ldap_bind($ds,$ldap_id,$ldap_password)){
        if ($_POST["name"] !== NULL) {                 // Adds POST request URL to the file 
            $data = $data . "\n" . $_POST["name"];
            $temp = explode("?v=", $_POST["name"]);    // Gets the video ID
            $vidID= substr($temp[1], 0, 11);
            $url = "http://gdata.youtube.com/feeds/api/videos/" . $vidID;  // The Youtube API
            $doc = new DOMDocument;
            $doc->load($url);
            $title = $doc->getElementsByTagName("title")->item(0)->nodeValue;  // Gets the title and duration from the API 
            $duration = $doc->getElementsByTagName('duration')->item(0)->getAttribute('seconds');
            $data = $data . "\n" . $vidID . "\n" . $title . "\n" . $_POST["id"] . "\n" . $duration;  // Adds them to the $data variable that will later be written to the file
            echo "Authentication Successful\n";
        }
    }
    else
    {
        echo "Authentication Failed\n";
    }
        
    $pieces = explode("\n", $data);
    $x=1;
    foreach ($pieces as $value) {
        if ($x%5 === 3 ) echo "\n\t\t\t<li style='font-family:Open Sans;'><b> $value </b></li>";  // Echoes every third line in the file i.e. the song names
        if ($x%5 === 4 ) echo "<em> $value </em>"; //Echoes the LDAP of the person who requested the song
        $x++;
    }
    echo "\n\t\t</ul>\n";
    $fh = fopen($file, "w") or die('Could not open file!');
    fwrite($fh,$data) or die('Could not write to file!');
    fclose($fh);
    ?>
		<form action="" method="post">
		<div style="font-family:Montserrat;">Youtube URL:<input style="left:30%;position:absolute;" type="text" name="name"></div>
        <div style="font-family:Montserrat;">LDAP ID:<input style="left:30%;position:absolute;" type="text" name="id"></div>
        <div style="font-family:Montserrat;">LDAP Password:<input style="left:30%;position:absolute;" type="password" name="pass"></div>
		<input style="color:white; background-color: #337AB7; border-color: #2E6DA4; border:1px solid transparent; border-radius:4px; padding:5px 10px; margin-top:10px;" type="submit">
		</form>
        <div style="font-family:Montserrat;font-size:15px;text-align:center;">Credits- Web and Creatives</div>
	</body>
</html>