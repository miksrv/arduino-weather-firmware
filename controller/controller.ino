//**************************************************************//
//  Name    : W E A T H E R   S T A T I O N
//  Author  : Mikhail (Mik™) <miksoft.tm@gmail.com>
//  Version : 1.9.6 (21 Oct 2016)
//  Notes   : The controller-receiver for weather station
//**************************************************************//

#include <Wire.h>              // library barometer
#include <BMP085.h>            // library barometer
#include <OneWire.h>           // library for DS18B20 sensor
#include <DallasTemperature.h> // library for DS18B20 sensor
#include <SPI.h>      // ethernet shield
#include <Ethernet.h> // ethernet shield
#include <VirtualWire.h>             // library for the 1-Wire Transmitter
#include <EasyTransferVirtualWire.h> // transmitter library
#include <LiquidCrystal.h>           // library for the character LCD screen

//#define DEBUG // Debug mode (messages are displayed in a series)

const byte PIN_RADIO   = 2; // Digital pin to connect the receiver
const byte PIN_DS18B20 = 3; // Digital pin for connecting DS18B20 temperature sensor
const int DPS_ALTITUDE = 1000; // The height of the thermometer above sea level (cm)

// Sign degrees LCD screen
uint8_t degrees[8] = {
    B01100,
    B10010,
    B10010,
    B01100,
    B00000,
    B00000,
    B00000,
    B00000 
};

// We initialize the object screen, used to pass the connection pins 
// on the Arduino in order:
// RS, E, DB4, DB5, DB6, DB7
LiquidCrystal lcd(9, 8, 4, 5, 6, 7);

BMP085 DPS = BMP085();        // (DPS) Digital Pressure Sensor
OneWire oneWire(PIN_DS18B20); // Connecting OneWire
DallasTemperature tempSensors(&oneWire); // Initialization 'DallasTemperature' library

long previousMillis = 0;  // the last to send the local data
long screenMillis   = 0;  // the time between the screen shiftsx
long interval = 300000;   // interval between sending data (ms)

// To display all information on one screen make several virtual screens to be 
// switched between an on time interval
byte screen = 1; // the current virtual screen

// Convert sensor values
int  light = 0;
long pressure = 0;
char replyBuffer[160];
char temp1[6] = "00.0", temp2[6] = "00.0", 
     humd[6] = "00.0", wind[6] = "00.0", 
     mmHg[6] = "000.0", volt[6] = "0.0";

// Receiver initialization
EasyTransferVirtualWire RADIO;

// The structure of the radio data (transport packets). The structure must be 
// defined identically at all receivers and the transmitter. structure size must 
// not exceed 26 bytes. This package uses the 1 + 2 + 2 + 2 + 2 + 2 = 11 bytes
struct RADIODATA_STRUCTURE {
    unsigned int volt; // battery voltage (2 bytes 0 ... 65535)
    unsigned int temp; // temperature data (2 bytes 0 ... 65535)
    unsigned int humd; // humidity data (2 bytes 0 ... 65535)
    unsigned int lux;  // luminance data (2 bytes 0 ... 65535)
    unsigned int wind; // wind speed data (2 bytes 0 ... 65535)
};

// Establish a link to the structure of the Radio
RADIODATA_STRUCTURE radiodata;

// NETWORK SETTINGS
byte mac[] = { 0x38, 0x59, 0xF9, 0x6D, 0xD7, 0xFF }; // MAC-address
IPAddress ip(10,10,1,3);                 // IP address of the device on the network
IPAddress serverweather(81,177,135,251); // IP address server

EthernetClient LAN;

// SETUP
void setup(void) {
    lcd.createChar(0, degrees); // register new display sign
    lcd.begin(16, 2);
    lcd.setCursor(0, 0);
    lcd.print("Initiali");
    lcd.setCursor(0, 1);
    lcd.print("zation..");
 
    #ifdef DEBUG
      Serial.begin(9600);
    #endif

    Wire.begin();
  
    #ifdef DEBUG
      Serial.println("SmartController start init...");
      Serial.println(" ");
    #endif

    delay(1000);

    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print("--");

    #ifdef DEBUG
      Serial.print("(DPS) Digital Pressure Sensor init...");
    #endif

    DPS.init(MODE_ULTRA_HIGHRES, DPS_ALTITUDE, true);
    delay(2000);
    tempSensors.begin();

    lcd.print("--");
    lcd.print("--");

    #ifdef DEBUG
      Serial.println(" ok");
      Serial.print("Radio library init...");
    #endif

    RADIO.begin(details(radiodata)); // initialization radio
    vw_set_rx_pin(PIN_RADIO); // receiver pin set
    vw_setup(2000);           // we set the speed of the reception / transmission (bit / s)
    vw_rx_start();            // radio reception launch mode

    lcd.print("--");

    lcd.setCursor(0, 1);
    lcd.print("--");
    lcd.print("--");

    #ifdef DEBUG
      Serial.println(" ok");
      Serial.println("DS18B20 library init... ok");
      Serial.print("Ethernet init...");
    #endif

    Ethernet.begin(mac, ip);
    delay(2000);
  
    lcd.print("--");
    lcd.print("--");
  
    #ifdef DEBUG
      Serial.println(" ok");
      Serial.println(" ");
      Serial.println(" ");
    #endif
} // void setup(void)


// MAIN LOOP
void loop(void) {
    // In case of receiving data by radio
    if (RADIO.receiveData()) {

        float t_temp = 0, t_humd = 0, t_volt = 0, t_wind = 0;

        t_temp = (( float(radiodata.temp) / 100) - 100);
        t_humd = ( float(radiodata.humd) / 100);
        t_volt = ( float(radiodata.volt) / 100);
        t_wind = ( float(radiodata.wind));

        dtostrf(t_temp, 4, 1, temp2);
        dtostrf(t_humd, 4, 1, humd);
        dtostrf(t_wind, 4, 1, wind);
        dtostrf(t_volt, 3, 1, volt);

        light = radiodata.lux;

        #ifdef DEBUG
            Serial.println("Data taken over the radio channel:");
            Serial.print("   temp = ");
            Serial.println(radiodata.temp);
            Serial.print("   humd = ");
            Serial.println(radiodata.humd);
            Serial.print("   lux = ");
            Serial.println(radiodata.lux);
            Serial.print("   wind = ");
            Serial.println(radiodata.wind);
            Serial.print("   volt = ");
            Serial.println(radiodata.volt);
            Serial.println("end");

            Serial.print(t_temp);
            Serial.print("; ");
            Serial.print(t_humd);
            Serial.print("; ");
            Serial.print(t_volt);
            Serial.print(";");

            Serial.println(" ");
        #endif
    }

    // This code is executed constantly. First, we check to see if the desired 
    // interval has passed, then retain the last shift, and send data to the server
    unsigned long currentMillis = millis();

    if (currentMillis - previousMillis > interval) {
        previousMillis = currentMillis; 
        get_local_sensors();
        send_server_data();
    }
    
    if (currentMillis - screenMillis > 5000) {
        screenMillis = currentMillis; 

        
        change_display();
    }
} // void loop(void)


// The method determines the length of the string
int len(char *buf) {
  int i=0; 
  do
  {
    i++;
  } while (buf[i]!='\0');
  return i;
} // int len(char *buf)
