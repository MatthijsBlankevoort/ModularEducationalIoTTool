/*
    Attiny code slave module
    Actuator Buzzer
    Door Durin


   SETUP:
   ATtiny Pin 1 = (RESET) N/U                      ATtiny Pin 2 = (D3) N/U
   ATtiny Pin 3 = (D4) to LED1                     ATtiny Pin 4 = GND
   ATtiny Pin 5 = I2C SDA on DS1621  & GPIO        ATtiny Pin 6 = (D1) to LED2
   ATtiny Pin 7 = I2C SCL on DS1621  & GPIO        ATtiny Pin 8 = VCC (2.7-5.5V)
   NOTE! - It's very important to use pullups on the SDA & SCL lines!

*/

#include "usiTwiSlave.h"
#include "TinyWireS.h"                  // wrapper class for I2C slave routines
#define I2C_SLAVE_ADDR  0x03
int buzzerPin = 1;

uint8_t flipped = 0;
uint8_t a = 55;
unsigned char bytes[4];

// Notes
#define Note_C   239
#define Note_CS  225
#define Note_D   213
#define Note_DS  201
#define Note_E   190
#define Note_F   179
#define Note_FS  169
#define Note_G   159
#define Note_GS  150
#define Note_A   142
#define Note_AS  134
#define Note_B   127

int byteRcvd = 0;
int speaker = 1;
int threshold = 200;
int value = 250;
void setup() {
  
//  TinyWireS.begin(I2C_SLAVE_ADDR);      // init I2C Slave mode
  pinMode(buzzerPin, OUTPUT);           // setup for the buzzer

}
void TinyTone(unsigned char divisor, unsigned char octave, unsigned long duration)
{
  TCCR1 = 0x90 | (11-octave); // for 8MHz clock
  OCR1C = divisor-1;         // set the OCR
  delay(duration);
  TCCR1 = 0x90;              // stop the counter
}

        
void loop() {

/*if (TinyWireS.available()) {          // got I2C input!
     byteRcvd = TinyWireS.receive();     // get the 2 bytes from master
     TinyWireS.send(byteRcvd);           //check
     TinyWireS.send(I2C_SLAVE_ADDR);     //ID
  }*/
  if (value > threshold * 2) {                      //High value, high tone
    TinyTone(Note_C, 8, 500);
    delay(1000);
  }
  if (value > threshold * 1.5) {                      //Lower value, lower tone
    TinyTone(Note_C, 4, 500);
    delay(1000);
  }
  if (value > threshold) {                      //Lowest value, lowest tone
    TinyTone(Note_C, 1, 500);
    delay(1000);
  }


  
}  

