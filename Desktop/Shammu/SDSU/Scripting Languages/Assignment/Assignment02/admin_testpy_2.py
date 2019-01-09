#!C:\Anaconda3\python.exe
#
# This code is a simple HTTP GET or POST cgi handler.

# Import modules for CGI handling 
import os, cgi, cgitb 

# Create instance of FieldStorage 
form = cgi.FieldStorage() 

# Get data from fields
first_name = form.getvalue('first_name')
last_name  = form.getvalue('last_name')

print ("Content-type:text/html\r\n\r\n");
print ("<html>");
print ("<head>");
print ("<title>Hello - Second CGI Program</title>");
print ("</head>");
print ("<body>");
print ("<h2>Hello %s %s</h2>" % (first_name, last_name));
print ("</body>");
print ("</html>");