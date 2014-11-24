Youtube-Music-Request-Portal
============================
The idea of the portal is the following-
There is one person in the room who has his / her laptop connected to the speakers. However, others in the room would also like to play songs of their choice. They can add the Youtube URL of the song they would like to request on the portal, that song is added to the playlist.

How it works-
There are three files -
PHP page (portal), playlist.txt, playmusic.py
The portal is a PHP file with a form. It shows the current list of songs as well as an option to add more. Once the URL is submitted the page calls the Youtube API to get the duration and song title (which is then displayed on the page).

The "playlist.txt" file has four fields for each song. They are-
1)Youtube URL
2)Video ID
3)Video name
4)Video duration

The python script is run on the computer of the person on whose laptop the speakers are connected. It will run continuously in a terminal session and watch for the playlist.txt file. All Youtube URLs will be opened one after the other (the duration field is used to decide when to open the next video + a buffer is added).

How to get it to work-
Configure the address of the "playlist.txt" file in the python script to the URL you have hosted it on. The "playlist.txt" file needs to be given 766 / 777 permissions.

Next up-
-Add CSS
-Find a way around using a pulicly writable file (security issue)
-Configure the python script to open the next song exactly when the song ends (currently it is assumed that the video always buffers before it loads) 
