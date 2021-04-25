#include <ESP8266WiFi.h>
#include <WiFiClient.h> 
#include <ESP8266WebServer.h>
#include <ESP8266HTTPClient.h>
#include <SoftwareSerial.h>  //Nap thu vien SoftwareSerial
#include <TinyGPS++.h>
int Led_OnBoard = 2;
#include "DHT.h"
#define DHTPIN D5                         //Connect GpS  TX - GPIO4(D2)
#define DHTTYPE DHT11                     //             RX - GPIO5 (D1)  
DHT dht(DHTPIN, DHTTYPE);
TinyGPSPlus gps;  // The TinyGPS++ object
SoftwareSerial ss(4, 5); // The serial connection to the GPS device// Initialize the Led_OnBoard 

const char* ssid = "DANGTHANH";                  // Your wifi Name       
const char* password = "0915359928";          // Your wifi Password

const char *host = "192.168.100.17"; //Your pc or server (database) IP, example : 192.168.0.0 , if you are a windows os user, open cmd, then type ipconfig then look at IPv4 Address.

void setup() {
  // put your setup code here, to run once:
  delay(1000);
  ss.begin(9600);
  dht.begin(9600);
  pinMode(Led_OnBoard, OUTPUT);       // Initialize the Led_OnBoard pin as an output
  Serial.begin(115200);
  WiFi.mode(WIFI_OFF);        //Prevents reconnection issue (taking too long to connect)
  delay(1000);
  WiFi.mode(WIFI_STA);        //This line hides the viewing of ESP as wifi hotspot
  
  WiFi.begin(ssid, password);     //Connect to your WiFi router
  Serial.println("");

  Serial.print("Connecting");
  // Wait for connection
  while (WiFi.status() != WL_CONNECTED) {
    digitalWrite(Led_OnBoard, LOW);
    delay(250);
    Serial.print(".");
    digitalWrite(Led_OnBoard, HIGH);
    delay(250);
  }

  digitalWrite(Led_OnBoard, HIGH);
  //If connection successful show IP address in serial monitor
  Serial.println("");
  Serial.println("Connected to Network/SSID");
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());  //IP address assigned to your ESP
}

void loop() {
  // put your main code here, to run repeatedly:
  HTTPClient http;    //Declare object of class HTTPClient
 
  boolean newData = false;
  for (unsigned long start = millis(); millis() - start < 2000;){
  while (ss.available() > 0) //while data is available
    if (gps.encode(ss.read())) //read gps data
    {
      if (gps.location.isValid()) //check whether gps location is valid
      {
      newData = true;
      }
    }
  }

  if(true){
  newData = false;
  String postData;    
  String latitude, longitude;
  String temperaturevalue,humidityvalue;
  latitude = String(gps.location.lat(), 6); // Latitude in degrees (double)
  longitude = String(gps.location.lng(), 6); // Longitude in degrees (double)
  float temperature = dht.readTemperature();
  float humidity = dht.readHumidity();
  temperaturevalue = String(temperature);
  humidityvalue = String(humidity);
  //Post Data
  postData = "temperature=" + temperaturevalue+"&humidity="+humidity+"&longitude="+longitude+"&latitude="+latitude;
  
  http.begin("http://192.168.100.17:8080/testcode/test.php");              //Specify request destination
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");    //Specify content-type header
 
  int httpCode = http.POST(postData);   //Send the request
  String payload = http.getString();    //Get the response payload

  //Serial.println("LDR Value=" + ldrvalue);
  Serial.println(httpCode);   //Print HTTP return code
  Serial.println(payload);    //Print request response payload
  Serial.println(temperature);
  Serial.println(humidity);
  Serial.println(longitude);
  Serial.println(latitude);
  
  http.end();  //Close connection

  delay(4000);  //Here there is 4 seconds delay plus 1 second delay below, so Post Data at every 5 seconds
  digitalWrite(Led_OnBoard, LOW);
  delay(1000);
  digitalWrite(Led_OnBoard, HIGH);
  }
}