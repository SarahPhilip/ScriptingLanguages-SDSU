#!/Library/anaconda/bin/python3
import cgi, cgitb, os
from PIL import Image, ImageDraw, ImageFont
from PIL.Image import core as _imaging
from PIL import ImageFilter

cgitb.enable()
print ("Content-type:text/html\r\n\r\n")
print ('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">')
print ('<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">')
print ('<head>')
print ('<title>Hello Word - First CGI Program</title>')
print ('</head>')
print ('<body>')

form_data = cgi.FieldStorage()
# print (form_data['isbn'].value)
isbn = form_data['isbn'].value
file_data = form_data['myfile'].value
file_name = form_data['myfile'].filename
text_message = form_data['bookName'].value
print ('<form name="images_form" method="post" action = "images.php">')
print ('<input type="hidden" name="ISBN" value="'+isbn+'" />')
print ('<input type="hidden" name="bookName" value="'+text_message+'" />')
print ('<td><input type="submit" id="sample_image" name="sample_image"  value="Back"/></td>')
print ('</form>')

file, ext = os.path.splitext(file_name)
fp =open('tmpmedia/'+isbn+'.jpeg','wb')
fp.write(file_data)
fp.close()
img =  Image.open('tmpmedia/'+isbn+'.jpeg').convert('RGBA')
# thumbnail
saved = "tmpmedia/"+isbn+".thumbnail.jpeg"
size = (128, 128)
try:
    im =  Image.open('tmpmedia/'+isbn+'.jpeg')
except:
    print ("Unable to load image")

im.thumbnail(size)
im.save(saved)

# Teaser
image =  Image.open('tmpmedia/'+isbn+'.jpeg').convert('RGBA')
img_t = image.resize((500,400))
teaser = "tmpmedia/"+isbn+".teaser.jpeg"
# make a blank image for the text, initialized to transparent text color
txt = Image.new('RGBA', img.size, (255,255,255,0))
draw = ImageDraw.Draw(image)
fontsize = 1  # starting font size

# # portion of image width you want text width to be
img_fraction = 0.50
# # get a font
fnt = ImageFont.truetype('/Library/anaconda/lib/python3.4/site-packages/matplotlib/mpl-data/fonts/ttf/Vera.ttf', fontsize)
while fnt.getsize(text_message)[0] < img_fraction*image.size[0]:
#     # iterate until the text size is just larger than the criteria
	fontsize += 1
	fnt = ImageFont.truetype('/Library/anaconda/lib/python3.4/site-packages/matplotlib/mpl-data/fonts/ttf/Vera.ttf', fontsize)

# optionally de-increment to be sure it is less than criteria
fontsize -= 1
fnt = ImageFont.truetype('/Library/anaconda/lib/python3.4/site-packages/matplotlib/mpl-data/fonts/ttf/Vera.ttf', fontsize)
w, h = draw.textsize(text_message)
W = image.size[0]
H = image.size[1]
# print 'final font size',fontsize
draw.text(((W-w)/3, 15), text_message, font=fnt) # put the text on the image
image.save(teaser) # save it

#Book Cover
#350 350 100
#Image Processing COntour
img_f =  Image.open('tmpmedia/'+isbn+'.jpeg').convert('RGBA')
W = img_f.size[0]
H = img_f.size[1]
img_c = img_f.filter(ImageFilter.EMBOSS)
img_c.save("tmpmedia/"+isbn+".contour.jpeg")
offset = (0, 0)
border = 15
img_b = img_f.crop((border, border, W - border, H - border))
# img_b.save("tmpmedia/"+isbn+".border.jpeg")
img_c.paste(img_b, (border, border, W - border, H - border))
img_c.save("tmpmedia/"+isbn+".border.jpeg")

frontImage = image.resize((350, 400))
backImage = img_c.resize((350, 400))
frontImage.save("tmpmedia/"+isbn+".front.jpeg")
backImage.save("tmpmedia/"+isbn+".back.jpeg")
spine = Image.new('RGBA', (400, 100), (255,255,255,0))
spine_background = Image.new('RGBA', (400, 100), (0 ,0 ,0,0))
spine_text = text_message
dr = ImageDraw.Draw(spine)
w, h = dr.textsize(text_message)
W = image.size[0]
H = image.size[1]
x = (W-w)/2
y = ((H-h)/2) - 50 
dr.text((x,y), text_message, font=fnt, fill="white")
spine_start = Image.alpha_composite(spine_background, spine)
spine_start = spine_start.rotate(90).convert('RGBA')
spine_start.save("tmpmedia/"+isbn+".spine.jpeg")
bookCoverLocation = "tmpmedia/"+isbn+".bookCover.jpeg"
bookCover = Image.new('RGBA',(800, 400), (255,255,255,0))
bookCover.paste(frontImage,(0,0,350, 400))
bookCover.paste(spine_start,(350,0,450,400))
bookCover.paste(backImage,(450,0,800,400))
bookCover.save("tmpmedia/"+isbn+".bookCover.jpeg")
#####################################
# get a drawing context
d = ImageDraw.Draw(txt)
# text_message = "HELLO WORLD"
w, h = d.textsize(text_message)
W = img.size[0]
H = img.size[1]
# draw text, full opacity
d.text(((W-w)/2,(H-h)/2), text_message, font=fnt, fill="black")
out = Image.alpha_composite(img, txt)
# out.save(teaser)
# frontImage = out.resize((350, 400))
# backImage = out.resize((350, 400))
# frontImage.save("tmpmedia/"+isbn+".front.jpeg")
# frontImage.save("tmpmedia/"+isbn+".back.jpeg")
# spine = Image.new('RGBA', (400, 100), (255,255,255,0))
# spine_background = Image.new('RGBA', (400, 100), (0 ,0 ,0,0))

# spine_text = text_message
# dr = ImageDraw.Draw(spine)
# dr.text(((400-w)/2,(100-h)/2), text_message, font=fnt, fill="blue")
# spine_start = Image.alpha_composite(spine_background, spine)
# spine_start = spine_start.rotate(90).convert('RGBA')
# spine_start.save("tmpmedia/"+isbn+".spine.jpeg")

#Image Processing COntour
# img_c = img.filter(ImageFilter.EMBOSS)
# img_c.save("tmpmedia/"+isbn+".contour.jpeg")
# offset = (0, 0)
# border = 50
# img_b = img.crop((border, border, W - border, H - border))
# img_c.paste(img_b, (border, border, W - border, H - border))
# img_c.save("tmpmedia/"+isbn+".border.jpeg")



#Watermark
watermark_main = Image.open('tmpmedia/'+isbn+'.jpeg').convert('RGBA')
watermark = Image.new("RGBA", watermark_main.size)
waterdraw = ImageDraw.ImageDraw(watermark, "RGBA")
waterdraw.text((10, 10), "Watermarked")
watermask = watermark.convert("L").point(lambda x: min(x, 100))
watermark.putalpha(watermask)
watermark_main.paste(watermark, None, watermark)
watermark_main.save("tmpmedia/"+isbn+".watermark.jpeg", "JPEG")

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