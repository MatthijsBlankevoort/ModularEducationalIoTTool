/*
    Attiny code slave module
    Actuator Servo motor



   SETUP:
   ATtiny Pin 1 = (RESET) N/U                      ATtiny Pin 2 = (D3) N/U
   ATtiny Pin 3 = (D4) to LED1                     ATtiny Pin 4 = GND
   ATtiny Pin 5 = I2C SDA on DS1621  & GPIO        ATtiny Pin 6 = (D1) to LED2
   ATtiny Pin 7 = I2C SCL on DS1621  & GPIO        ATtiny Pin 8 = VCC (2.7-5.5V)
   NOTE! - It's very important to use pullups on the SDA & SCL lines!

   Orange =   pwm
   Red =      VCC
   Brown =    Ground

*/


#include "TinyWireS.h"                  // wrapper class for I2C slave routines
#include "usiTwiSlave.h"
#include <SoftwareServo.h>

#define I2C_SLAVE_ADDR  0x02

SoftwareServo servo;

int potpin = 4;
int val;
int timer = 0;

uint8_t flippelichtWaarded = 0;
uint16_t test = 45;
uint8_t a = 55;
unsigned char bytes[4];
int byteRcvd = 0;



void setup() {
  TinyWireS.begin(I2C_SLAVE_ADDR);      // init I2C Slave mode
  servo.attach(1);
  // servo.setMinimumPulse(700);
  // servo.setMaximumPulse(2000);
}

void loop() {
  /*
    if (TinyWireS.available()) {          // got I2C input!
      // byteRcvd = (TinyWireS.receive() | TinyWireS.receive() << 8);     // get the 2 bytes from master
      byteRcvd = TinyWireS.receive();     // get the 2 bytes from master
      TinyWireS.send(byteRcvd);           //check
      TinyWireS.send(I2C_SLAVE_ADDR);     //ID
    }
    byteRcvd = map(byteRcvd, 0, 255, 0, 180);
  */
  servo.write(45);      // Turn SG90 servo Left to 45 degrees
  delay(1000);          // Wait 1 second
  servo.write(90);      // Turn SG90 servo back to 90 degrees (center position)
  delay(1000);          // Wait 1 second
  servo.write(135);     // Turn SG90 servo Right to 135 degrees
  delay(1000);          // Wait 1 second
  servo.write(90);      // Turn SG90 servo back to 90 degrees (center position)
  delay(1000);          // Wait 1 second

  //SoftwareServo::refresh();
  /*
  if (test < 180) {
    test -= 20;
  }
  else {
    test += 20;
  }*/
}



