#include <ESP8266WiFi.h>
#include <WiFiClient.h>
#include <ESP8266WebServer.h>
#include "DHT.h"
#define DHTPIN D2
#define DHTTYPE DHT11
DHT dht(DHTPIN, DHTTYPE);

const char* ssid     = "DANGTHANH";
const char* password = "0915359928";
const char* host = "192.168.100.17"; // cmd ipconfig ipAddress IPv4

// tat firewall truoc khi chay chuong trinh de ket noi voi database


void setup()
{
  
    Serial.begin(115200);
    Serial.println("DHT11 Output!");
    dht.begin();

    // We start by connecting to a WiFi network

    Serial.println();
    Serial.println();
    Serial.print("Connecting to ");
    Serial.println(ssid);

    WiFi.begin(ssid, password);

    while (WiFi.status() != WL_CONNECTED) {
        delay(500);
        Serial.print(".");
    }

    Serial.println("");
    Serial.println("WiFi connected");
    Serial.println("IP address: ");
    Serial.println(WiFi.localIP());
}



void loop()
{
  
float temperature = dht.readTemperature();
  float humidity = dht.readHumidity();  
  if(isnan(temperature) || isnan(humidity)){
    Serial.println("Failed to read DHT11");
  }else{
    Serial.print("Humidity: ");
    Serial.print(humidity);
    Serial.print(" %\t");
    Serial.print("Temperature: ");
    Serial.print(temperature);
    Serial.println(" *C");
    delay(3000);
  }
   
    Serial.print("connecting to ");
    Serial.println(host);

    // Use WiFiClient class to create TCP connections
    WiFiClient client;
    const uint16_t httpPort = 8080;
    if (!client.connect(host, httpPort)) {
        Serial.println("connection failed");
        return;
    }

 


    // This will send the request to the server
 client.print(String("GET http://192.168.100.17:8080/testcode/dht.php?") + 
                          ("&temperature=") + temperature +
                          ("&humidity=") + humidity +
                          " HTTP/1.1\r\n" +
                 "Host: " + host + "\r\n" +
                 "Connection: close\r\n\r\n");
    unsigned long timeout = millis();
    while (client.available() == 0) {
        if (millis() - timeout > 1000) {
            Serial.println(">>> Client Timeout !");
            client.stop();
            return;
        }
    }

    // Read all the lines of the reply from server and print them to Serial
    while(client.available()) {
        String line = client.readStringUntil('\r');
        Serial.print(line);
        
    }

    Serial.println();
    Serial.println("closing connection");
}