import serial
import time

ser = serial.Serial('/dev/ttyUSB0', 9600)

while 1 :
	time.sleep(0.05)
	bytesWaiting = ser.inWaiting()
	if bytesWaiting:
		nowReceive = ser.readline()
		nowTime = time.time()
		
		print time.strftime("%d/%m/%Y %H:%M:%S")
		print nowReceive
