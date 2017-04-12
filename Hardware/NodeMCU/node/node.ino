#include<OpenWiFi.h>
#include  <ESP8266HTTPClient.h>
#include <ESP8266WiFi.h>
#include <WiFiManager.h>
#include "config.h"

int oldTime = 0;
int counter = 0;
String chipID;
String serverURL = SERVER_URL;
OpenWiFi hotspot;


void printDebugMessage(String message) {
#ifdef DEBUG_MODE
  Serial.println(String(PROJECT_SHORT_NAME) + ": " + message);
#endif
}

void setup() {
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
  chipID = "11T1";
  String configSSID = String(CONFIG_SSID) + "_" + chipID;
  wifiManager.autoConnect(configSSID.c_str());





}

void loop() {

{
  //Check for button press
  if (digitalRead(BUTTON_PIN) == LOW)
  {
    sendButtonPress();
    delay(250);
  }
  //Every requestDelay, send a request to the server
  if (millis() > oldTime + REQUEST_DELAY)
  {
    requestMessage();
    oldTime = millis();
  }
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
  String requestString = serverURL + "/api.php?t=gqi&d=" + chipID + "&v=2";

  http.begin(requestString);

  uint16_t httpCode = http.GET();

  if (httpCode == 200)
  {
    String response;
    response = http.getString();
    //Serial.println(response);

    if (response == "-1")
    {
      printDebugMessage("There are no messages waiting in the queue");
    }
    else
    {
      //Get the indexes of some commas, will be used to split strings
      int firstComma = response.indexOf(',');
      int secondComma = response.indexOf(',', firstComma + 1);
      int thirdComma = response.indexOf(',', secondComma + 1);

      //Parse data as strings
      String hexColor = response.substring(0, 7);
      String springConstant = response.substring(firstComma + 1, secondComma);
      String dampConstant = response.substring(secondComma + 1, thirdComma);;
      String message = response.substring(thirdComma + 1, response.length());;

      printDebugMessage("Message received from server: \n");
      printDebugMessage("Hex color received: " + hexColor);
      printDebugMessage("Spring constant received: " + springConstant);
      printDebugMessage("Damp constant received: " + dampConstant);
      printDebugMessage("Message received: " + message);

    }
  }
  else
  {
    ESP.reset();
  }

  http.end();
}
