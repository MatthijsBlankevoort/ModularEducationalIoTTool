/*
    Attiny code slave module
    Door Filmon
    Tilt sensor uitlezen en versturen op I2C bus.


   SETUP:
   ATtiny Pin 1 = (RESET) N/U                      ATtiny Pin 2 = (D3) N/U
   ATtiny Pin 3 = (D4) to LED1                     ATtiny Pin 4 = GND
   ATtiny Pin 5 = I2C SDA on DS1621  & GPIO        ATtiny Pin 6 = (D1) to LED2
   ATtiny Pin 7 = I2C SCL on DS1621  & GPIO        ATtiny Pin 8 = VCC (2.7-5.5V)
   NOTE! - It's very important to use pullups on the SDA & SCL lines!

*/


#include "TinyWireS.h"                  // wrapper class for I2C slave routines
#include "usiTwiSlave.h"

#define I2C_SLAVE_ADDR  0x02
int xPin = 1;
int yPin = 3;
int zPin = 4;

unsigned char bytes[4];
byte byteRcvd = 0;
uint16_t sensorWaarde = 0;

double xValue, yValue, zValue;
double roll;


void setup() {
  TinyWireS.begin(I2C_SLAVE_ADDR);      // init I2C Slave mode
  pinMode(xPin, INPUT);
  pinMode(yPin, INPUT);
  pinMode(zPin, INPUT);
}

void loop() {
  xValue = analogRead(xPin);
  yValue = analogRead(yPin);
  zValue = analogRead(zPin);
  roll = atan2(yValue, zValue) * 57.3;
  sensorWaarde = (int) roll;
  TinyWireS.send(sensorWaarde);           //sensor waarde
  //  TinyWireS.send(sensorWaarde);           //sensor waarde

  if (TinyWireS.available()) {          // got I2C input!
    byteRcvd = TinyWireS.receive();     // get the byte from master
    TinyWireS.send(byteRcvd);           //stuurt ontvangen byte terug naar master om te debuggen
    TinyWireS.send(I2C_SLAVE_ADDR);     //ID
  }

}

