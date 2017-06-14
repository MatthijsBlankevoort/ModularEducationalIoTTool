/*
    Attiny code slave module



   SETUP:
   ATtiny Pin 1 = (RESET) N/U                      ATtiny Pin 2 = (D3) N/U
   ATtiny Pin 3 = (D4) to LED1                     ATtiny Pin 4 = GND
   ATtiny Pin 5 = I2C SDA on DS1621  & GPIO        ATtiny Pin 6 = (D1) to LED2
   ATtiny Pin 7 = I2C SCL on DS1621  & GPIO        ATtiny Pin 8 = VCC (2.7-5.5V)
   NOTE! - It's very important to use pullups on the SDA & SCL lines!

*/


#include "TinyWireS.h"                  // wrapper class for I2C slave routines
#include "usiTwiSlave.h"

#define I2C_SLAVE_ADDR 0x02  //0x02
#define potPin      2 //pin 3 op bord (analogread)


uint16_t sensorWaarde = 0;
unsigned char bytes[4];
byte byteRcvd = 0;


void setup() {
  TinyWireS.begin(I2C_SLAVE_ADDR);      // init I2C Slave mode
  pinMode(potPin, INPUT);
}

void loop() {
  sensorWaarde = analogRead(potPin);
  sensorWaarde = map(sensorWaarde, 0,1023, 0, 254);
  TinyWireS.send(sensorWaarde);        //lichtsensor waarde
  if (TinyWireS.available()) {          // got I2C input!
    byteRcvd = TinyWireS.receive();     // get the byte from master
    TinyWireS.send(byteRcvd);           //check
    TinyWireS.send(I2C_SLAVE_ADDR);     //ID

  }


}

