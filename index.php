<!DOCTYPE html>
<html>
    <head>
        <title>
            YouTube Song Request
        </title>
    </head>
    <body>
	<?php
    echo "<h1>Playlist:</h1>\n\t\t<ul>";
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
        if ($x%5 === 3 ) echo "\n\t\t\t<li> $value";  // Echoes every third line in the file i.e. the song names
        if ($x%5 === 4 ) echo "<em> $value </em>"; //Echoes the LDAP of the person who requested the song
        $x++;
    }
    echo "\n\t\t</ul>\n";
    $fh = fopen($file, "w") or die('Could not open file!');
    fwrite($fh,$data) or die('Could not write to file!');
    fclose($fh);
    ?>
		<form action="" method="post">
		Youtube URL: <input type="text" name="name"><br>
        LDAP ID: <input type="text" name="id"><br>
        LDAP Password: <input type="password" name="pass"><br>
		<input type="submit">
		</form>
	</body>
</html>