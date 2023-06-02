import Adafruit_DHT
import os
from gpiozero import Servo
from time import sleep

DHT_SENSOR = Adafruit_DHT.DHT11
DHT_PIN = 4

servo = Servo(18)
#os.system("sudo nohup shutdown -r now")
while (True):
  humidity, temperature = Adafruit_DHT.read(DHT_SENSOR, DHT_PIN)
  if temperature is not None:
    servo.value = (temperature-20)*-0.05+1
  sleep(1)
  print (temperature)
