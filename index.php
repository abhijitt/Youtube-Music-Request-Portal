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
    if ($_POST["name"] !== NULL) {                 // Adds POST request URL to the file 
        $data = $data . "\n" . $_POST["name"];
        $temp = explode("?v=", $_POST["name"]);    // Gets the video ID
        $vidID= substr($temp[1], 0, 11);
        $url = "http://gdata.youtube.com/feeds/api/videos/" . $vidID;  // The Youtube API
        $doc = new DOMDocument;
        $doc->load($url);
        $title = $doc->getElementsByTagName("title")->item(0)->nodeValue;  // Gets the title and duration from the API 
        $duration = $doc->getElementsByTagName('duration')->item(0)->getAttribute('seconds');
        echo $title;
        echo $duration;
        $data = $data . "\n" . $vidID . "\n" . $title . "\n" . $duration;  // Adds them to the $data variable that will later be written to the file
    }

    $pieces = explode("\n", $data);
    $x=1;
    foreach ($pieces as $value) {
        if ($x%4 === 3 ) echo "<li> $value";  // Echoes every third line in the file i.e. the song names
        $x++;
    }
    echo "</ul>";
    $fh = fopen($file, "w") or die('Could not open file!');
    fwrite($fh,$data) or die('Could not write to file!');
    fclose($fh);
    ?>
		<form action="" method="post">
		Youtube URL: <input type="text" name="name"><br>
		<input type="submit">
		</form>
	</body>
</html>