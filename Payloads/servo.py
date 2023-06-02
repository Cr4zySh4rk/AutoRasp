import os
#from gpiozero import AngularServo
from gpiozero import Servo
#from gpiozero.pins.pigpio import PiGPIOFactory
from time import sleep

#factory = PiGPIOFactory()
servo = Servo(18)
#servo = AngularServo(18, min_angle=-90, max_angle=90)
#os.system("sudo nohup shutdown -r now")
while (True):
  #servo.angle = 90
  servo.value = 1
  sleep(1)
  #servo.angle = -90
  servo.value = 0
  sleep(1)
  servo.value = -1
  sleep(1)
