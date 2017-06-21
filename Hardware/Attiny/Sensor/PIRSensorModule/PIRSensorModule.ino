#include "TinyWireS.h"                  // wrapper class for I2C slave routines 
#include "usiTwiSlave.h" 


int ledPin = 1; //LED pin on attiny

int inputPin = 1; //Input of the PIR
int pirState = LOW; //Start with no motion detected
int val = 0; //Declare variable for the value of the input
byte byteRcvd;
int motionDetected;
#define I2C_SLAVE_ADDR 2  

void setup() {
  TinyWireS.begin(I2C_SLAVE_ADDR);      // init I2C Slave mode 
  pinMode(ledPin, OUTPUT); //Initialize ledpin as output
  pinMode(inputPin, INPUT); //Initialize inputpin as INPUT of the PIR
}
  
void loop(){
  motionDetected = 0;
  
  val = digitalRead(inputPin);  //Read the inputpin value
  if (val == HIGH) {
    motionDetected = 1;
    digitalWrite(ledPin, HIGH); //Turn on LED 
      if (pirState == LOW) {
        Serial.println("Motion detected!");
        pirState = HIGH; //Set PIR to high so the motion ends.
    }
  } else {
      digitalWrite(ledPin, LOW); //Turn off LED
      motionDetected = 0;
      
      if (pirState == HIGH){
        Serial.println("Motion ended!");
        pirState = LOW;
    }
  }



  TinyWireS.send(motionDetected);
  if (TinyWireS.available()) {          // got I2C input! 
    byteRcvd = TinyWireS.receive();     // get the byte from master 
    TinyWireS.send(byteRcvd);           //stuurt ontvangen byte terug naar master om te debuggen 
    TinyWireS.send(I2C_SLAVE_ADDR);     //ID 
  } 
 
}

