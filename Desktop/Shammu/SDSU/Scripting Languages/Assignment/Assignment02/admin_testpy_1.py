#!C:\Anaconda3\python.exe
#
# This code prints the http server environment variables.
# It is the start in learing to process http request.

import os

print ("Content-type: text/html\r\n\r\n");
print ("<font size=+1>Environment</font><\\hr>");
for param in os.environ.keys():
  print ("<b> " + param + "</b>:" + os.environ[param] + " </br>" );