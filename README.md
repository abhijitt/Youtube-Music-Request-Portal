Youtube-Music-Request-Portal
============================
<h2>The idea of the portal is the following-</h2>
There is one person in the room who has his / her laptop connected to the speakers. However, others in the room would also like to play songs of their choice. They can add the Youtube URL of the song they would like to request on the portal, that song is added to the playlist.
<br>
<h2>How it works-</h2>
There are three files -<br>
PHP page (portal), playlist.txt, playmusic.py<br>
The portal is a PHP file with a form. It shows the current list of songs as well as an option to add more. Once the URL is submitted the page calls the Youtube API to get the duration and song title (which is then displayed on the page).
<br>
The "playlist.txt" file has four fields for each song. They are-<br>
1)Youtube URL<br>
2)Video ID<br>
3)Video name<br>
4)Video duration<br>
<br>
The python script is run on the computer of the person on whose laptop the speakers are connected. It will run continuously in a terminal session and watch for the playlist.txt file. All Youtube URLs will be opened one after the other (the duration field is used to decide when to open the next video + a buffer is added).
<br>
<h2>How to get it to work-</h2>
Configure the address of the "playlist.txt" file in the python script to the URL you have hosted it on. The "playlist.txt" file needs to be given 766 / 777 permissions.
<br>
<h2>Next up-</h2>
-Add CSS<br>
-Find a way around using a pulicly writable file (security issue)<br>
-Configure the python script to open the next song exactly when the song ends (currently it is assumed that the video always buffers before it loads) 
