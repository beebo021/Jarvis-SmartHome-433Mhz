import sys
import serial

ser = serial.Serial('/dev/ttyUSB0', 9600)

ser.write(sys.argv[1])