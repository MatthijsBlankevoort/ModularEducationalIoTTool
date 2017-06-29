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
#define sensorPin 2

double alpha = 0.75;
int period = 100;
double change = 0.0;
double minval = 0.0;
uint16_t sensorWaarde = 22;
byte byteRcvd = 0;
char c = 'a'; 



void setup() {
  TinyWireS.begin(I2C_SLAVE_ADDR);      // init I2C Slave mode
}

void loop() {
  union {
    double value;
    unsigned char bytes[4];
  }heartRate; 
  
  static double oldValue = 0;
  static double oldChange = 0;

  int rawValue = analogRead (sensorPin);
  heartRate.value = alpha * oldValue + (1 - alpha) * rawValue;


  oldValue = heartRate.value;

  delay (period);

  TinyWireS.send(heartRate.bytes[0]);           //sensor waarde
  if (TinyWireS.available()) {          // got I2C input!
    byteRcvd = TinyWireS.receive();     // get the byte from master
    TinyWireS.send(heartRate.bytes[1]);           //stuurt ontvangen byte terug naar master om te debuggen
    TinyWireS.send(heartRate.bytes[2]);     //ID
  }

}

