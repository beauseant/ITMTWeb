import json
import time


with open('/var/www/html/assets/data/sample.json') as user_file:
  data = user_file.read()
time.sleep(3)


print (data)

#print ('[{"a":1,"b":2,"c":3,"d":4,"e":5},{"b":20,"a":10,"c":30,"d":40,"e":50}]')
