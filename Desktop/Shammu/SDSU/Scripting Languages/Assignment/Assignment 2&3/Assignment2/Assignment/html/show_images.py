#!/Library/anaconda/bin/python3
import cgi, cgitb, os
from PIL import Image, ImageDraw, ImageFont
from PIL.Image import core as _imaging
from PIL import ImageFilter

cgitb.enable()
print ("Content-type:text/html\r\n\r\n")
print ('<html>')
print ('<head>')
print ('<title>Images</title>')
print ('</head>')
print ('<body>')

form_data = cgi.FieldStorage()
# print (form_data['isbn'].value)
isbn = form_data['isbn'].value
text_message = form_data['bookName'].value
print ('<form name="images_form" method="post" action = "images.php">')
print ('<input type="hidden" name="ISBN" value="'+isbn+'" />')
print ('<input type="hidden" name="bookName" value="'+text_message+'" />')
print ('<td><input type="submit" id="sample_image" name="sample_image"  value="Back"/></td>')
print ('</form>')
print ('<br /> <br />')
img =  Image.open('tmpmedia/'+isbn+'.jpeg').convert('RGBA')
print ('<br /> ')
# print ('Original Image  <br />')
# print ('<img src="tmpmedia/'+isbn+'.jpeg" alt="image" width="304" height="228"/> <br />') 
print ('Thumbnail Image  <br />')
print ('<img src="tmpmedia/'+isbn+'.thumbnail.jpeg" alt="image"/> <br /> ') 
print ('Teaser Image  <br />')
print ('<img src="tmpmedia/'+isbn+'.teaser.jpeg" alt="image"/> <br /> ')
# print ('Border Image  <br />')
# print ('<img src="tmpmedia/'+isbn+'.border.jpeg" alt="image" width="304" height="228"/> <br /> ')
print ('Book Cover<br /> ')
print ('<img src="tmpmedia/'+isbn+'.bookCover.jpeg" alt="image" /> <br /> ')
print ('Image Processing  <br />')
print ('<img src="tmpmedia/'+isbn+'.contour.jpeg" alt="image"/> <br /> ')
print ('Watermarked <br /> ')
print ('<img src="tmpmedia/'+isbn+'.watermark.jpeg" alt="image" /> <br /> ')
print ('</body>')
print ('</html>')