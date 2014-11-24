import webbrowser
import time
import urllib2

x=0
while(1): # Watches the file forever, plays the song if there are any additions
	response = urllib2.urlopen('http://example.com/playlist.txt') # Put the URL of the playlist file here, will update once the current songs are over and will continue from where it left since value of x is not reinitialised
	f = response.readlines()
	for line in f:
		if (x%4 == 0) : webbrowser.open_new(line) # Opens the video in browser window (Every fourth line contains the URL)
		if (x%4 == 3) : time.sleep(int(line) + 3) # Sleeps for video duration + 3 second buffer
		x = x + 1