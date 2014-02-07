import serial
import time
import MySQLdb

lastTime = 0
nowTime = 0

lastReceive = ""
nowReceive = ""

insert = 0


conn = MySQLdb.connect(host= "localhost",
                  user="root",
                  passwd="raspberry",
                  db="iDomo")

ser = serial.Serial('/dev/ttyUSB0', 9600)

while 1 :
	time.sleep(0.25)
	bytesWaiting = ser.inWaiting()
	if bytesWaiting:
		nowReceive = ser.readline()
		nowTime = time.time()
		
		if lastReceive == nowReceive:
			if (nowTime-lastTime)>2:
				insert = 1
			else:
				insert = 0
		else:
			insert = 1
			
		lastReceive = nowReceive;
		lastTime = nowTime;
		
		if insert == 1:
			print time.strftime("%d/%m/%Y %H:%M:%S")
			print nowReceive
			
			values = nowReceive.split(';')
			
			x = conn.cursor()
			
			try:
				x.execute("""INSERT INTO rflog VALUES (NULL, %s, %s, %s, %s, NOW())""",(values[0], values[1], values[2], values[3]))
				conn.commit()
			except:
				conn.rollback()
		

conn.close()