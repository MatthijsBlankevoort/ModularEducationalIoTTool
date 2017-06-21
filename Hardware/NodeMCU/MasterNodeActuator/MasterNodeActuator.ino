#include <OpenWiFi.h>
#include  <ESP8266HTTPClient.h>
#include <ESP8266WiFi.h>
#include <WiFiManager.h>
#include <Wire.h>
#include "config.h"

#define device 0x01
#define actuator 0x02


int oldTime = 0;
int counter = 0;
int lightVal = 0;//light value
int actuatorId = 0;//sensorID/Address
int checkVal = 0;//Check
String chipID;
String serverURL = SERVER_URL;
String response;
OpenWiFi hotspot;
String serverURL = SERVER_URL;

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

void giveCommand(int command, int threshold) {
  Serial.print("command: ");
  Serial.println(command);
  Wire.beginTransmission(actuator);
  Wire.write(command);
  Wire.write(threshold);
 // Wire.write(command >> 8);
  Wire.endTransmission();
  delay(5);

  Wire.requestFrom(actuator, 2);
  while (Wire.available()) {
    checkVal = Wire.read();//check if slave received correct data
    actuatorId = Wire.read();//address slave

  }
  Serial.println(actuatorId);
  Serial.println(checkVal);
}


void loop() {
  ESP.wdtFeed();

  
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
  delay(1000);
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
  //String requestString = serverURL + "/api.php?t=gqi&d=" + chipID + "&v=2";
  String requestString = serverURL + "/api.php?deviceId=" + chipID + "&deviceFunctie=actuator"  + "&sensorId=001"  + "&value=1" ;

  http.begin(requestString);

  uint16_t httpCode = http.GET();

  if (httpCode == 200)
  {
    response = http.getString();
    //Serial.println(response);

    if (response == "-1")
    {
      printDebugMessage("There are no messages waiting in the queue");
    }
    else
    {
      String configurationApi = getValue(response, ',', 0);
      String valueApi = getValue(response, ',', 1);
      String thresholdApi = getValue(response, ',', 2);
      
      int configuration = configurationApi.toInt();
      int value = valueApi.toInt();
      int threshold = thresholdApi.toInt();
      
      //api.php?deviceId=44T4&deviceFunctie=actuator&sensorId=002&value=1

      Serial.print("Config received: ");
      Serial.println(configuration);
      Serial.print("Value received: ");
      Serial.println(value);
      checkResponse(configuration, value);
    }
  }
  else
  {
    ESP.reset();
  }

  http.end();
}

//See what activity is linked to the config
void checkResponse(int configuration, int value) {

  //lightsensor/led config
  if (configuration == 20) {
    giveCommand(value, threshold);
  }


}

String getValue(String data, char separator, int index)
{
  int found = 0;
  int strIndex[] = { 0, -1 };
  int maxIndex = data.length() - 1;

  for (int i = 0; i <= maxIndex && found <= index; i++) {
    if (data.charAt(i) == separator || i == maxIndex) {
      found++;
      strIndex[0] = strIndex[1] + 1;
      strIndex[1] = (i == maxIndex) ? i + 1 : i;
    }
  }
  return found > index ? data.substring(strIndex[0], strIndex[1]) : "";
}

