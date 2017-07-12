#include <OpenWiFi.h>
#include <ESP8266HTTPClient.h>
#include <ESP8266WiFi.h>
#include <WiFiManager.h>
#include <Wire.h>
#include "config.h"

#define device 0x01 //hardcoded device id for testing purposes


int oldTime = 0;
int counter = 0;
int lightVal = 0;//light value
int sensorId = 0;//sensorID/Address
int checkVal = 0;//Check
String chipID;
String serverURL = SERVER_URL;
String response;
char response2[100];

OpenWiFi hotspot;


void printDebugMessage(String message) {
#ifdef DEBUG_MODE
  Serial.println(String(PROJECT_SHORT_NAME) + ": " + message);
#endif
}

void setup() {
  ESP.wdtDisable();
  ESP.wdtEnable(WDTO_8S);
  Wire.begin(D1, D2);
  pinMode(BUTTONLOW_PIN, OUTPUT);
  digitalWrite(BUTTONLOW_PIN, LOW);
  Serial.begin(115200); Serial.println("");
  WiFiManager wifiManager;

  while (digitalRead(BUTTON_PIN) == LOW)
  {
    counter++;
    delay(10);

    if (counter > 500)
    {
      wifiManager.resetSettings();
      printDebugMessage("Remove all wifi settings!");
      ESP.reset();
    }
  }
  hotspot.begin(BACKUP_SSID, BACKUP_PASSWORD);
  chipID = "22T2";
  String configSSID = String(CONFIG_SSID) + "_" + chipID;
  wifiManager.autoConnect(configSSID.c_str());
}

void get_data() {

  Wire.beginTransmission(device);
  Wire.write(0xAA);
  Wire.endTransmission();
  delay(5);

  Wire.requestFrom(device, 3);
  while (Wire.available()) {
    sensorId = Wire.read();//address slave
    lightVal = Wire.read();//licht waarde
    checkVal = Wire.read();//check
  }
  Serial.println(sensorId);
  Serial.println(lightVal);
  Serial.println(checkVal);
  //Serial.println();
}


void loop() {
  ESP.wdtFeed();
  get_data();
  Serial.println("Address, value, check: ");

  delay(250);
/*
  //Check for button press
  if (digitalRead(BUTTON_PIN) == LOW)
  {
    sendButtonPress();
    delay(250);
  }*/
  //Every requestDelay, send a request to the server
  if (millis() > oldTime + REQUEST_DELAY)
  {
    requestMessage();
    oldTime = millis();
  }
}


void sendButtonPress()
{
  printDebugMessage("Sending button press to server");
  Serial.println("Button pressed");
  HTTPClient http;
  http.begin(serverURL + "/api.php?t=sqi&d=" + chipID);
  uint16_t httpCode = http.GET();
  http.end();
}

void requestMessage()
{

  HTTPClient http;
  String requestString = serverURL + "/api.php?deviceId=" + chipID + "&deviceFunctie=sensor" + "&sensorId=00" + sensorId + "&value=" + lightVal; //url om data te verzenden naar de database
  String requestString2 = serverURL + "/api.php?deviceId=" + chipID + "&deviceFunctie=sensor"; //url om sensor ID op te vragen
  if (sensorId == 0) { //als er geen sensorId is dan wordt die eerst opgevraagd
    http.begin(requestString2);

    uint16_t httpCode = http.GET();
    //Response code for sensor module
    if (httpCode == 200)
    {
      response = http.getString();
      Serial.print("response: ");
      Serial.println(response);
      response.toCharArray(response2, 100);
      sensorId = atoi(response2);

      if (response == "-1")
      {
        printDebugMessage("There are no messages waiting in the queue");
      }
    }
    else
    {
      //ESP.reset();
    }

    http.end();
  }
  if(sensorId != 0) {
    http.begin(requestString);

    uint16_t httpCode = http.GET();
    //Response code for sensor module
    if (httpCode == 200)
    {
      response = http.getString();
      Serial.print("response: ");
      Serial.println(response);

      if (response == "-1")
      {
        printDebugMessage("There are no messages waiting in the queue");
      }

    }
    else
    {
     // ESP.reset();
    }

    http.end();
  }
}
