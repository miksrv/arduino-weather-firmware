//**************************************************************//
//  Name    : W E A T H E R   S T A T I O N
//  Author  : Mikhail (Mik™) <miksoft.tm@gmail.com>
//  Version : 1.9.1 (22 Aug 2016)
//  Notes   : Transmitter for weather station
//**************************************************************//

#include <dht.h>                     // DHT22 sensor library
#include <VirtualWire.h>             // library for the 1-Wire Transmitter
#include <EasyTransferVirtualWire.h> // transmitter library
#include <SimpleTimer.h>             // http://playground.arduino.cc/Code/SimpleTimer sensor poll timer
#include <LowPower.h>                // https://github.com/rocketscream/Low-Power sleep for MK

//#define DEBUG // debug mode (messages are displayed in a series)

#define ITERATIONS 2  // еhe number of iterations of the survey sensors before sending data
#define POWER_V    6  // pin power management voltmeter
#define POWER_S    5  // power management pin sensors
#define POWER_R    4  // pin power radio control
#define PIN_RADIO  7  // digital pin transmitter
#define PIN_DHT22  3  // digital pin DHT22 sensor
#define PIN_WIND   2  // digital pin anemometer sensor
#define PIN_VOLT   A0 // pin analog control voltage of the battery
#define PIN_LUX    A1 // pin analog light sensor
#define DEVICE_ID  5  // [NOT USED] unique device identifier, may be used that would take 
                      // only the data that is intended for it by radio (0-255)

EasyTransferVirtualWire ET; // transmitter protocol initialization
dht DHT;                    // initialization DHT22

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

int   counter = 0;
long  lux = 0, avg_lux = 0, avg_wind = 0, impulse = 0;
float avg_temp = 0, avg_humd = 0, temp = 0, humd = 0, volt = 0;

void setup() {
    #ifdef DEBUG
        Serial.begin(9600);
        Serial.println("Explorer v2 programm");
        Serial.println(" ");
    #endif

    // The control pins to power peripherals, a transmitter and a voltmeter
    pinMode(POWER_S, OUTPUT);
    pinMode(POWER_R, OUTPUT);
    pinMode(POWER_V, OUTPUT);
    
    // The function determines the reference voltage against which the analog measurement occu (INTERNAL == 1.1V)
    analogReference(INTERNAL);

    // Initialization of the transmitter
    #ifdef DEBUG
        Serial.print("Transmitter start...");
    #endif
    ET.begin(details(radiodata)); // transmitter initializing
    vw_set_tx_pin(PIN_RADIO);     // set pin transmitter
    vw_setup(2000);               // we set the speed of the reception / transmission (bit / s)
    #ifdef DEBUG
        Serial.println(" ok");
    #endif

    // Start a timer that will periodically poll sensors and send values
    #ifdef DEBUG
        Serial.println("Start programm... ok");
        Serial.println(" ");
    #endif
} // void setup()


// MAIN LOOP
void loop () {
    // The microcontroller is in sleep mode in a loop in the loop iterations 38, 
    // then 38 * 8 = 304 seconds (approximately) will MC "sleep" When the debug 
    // mode after each iteration MK LED will flash
    for (byte i=0;i<=20;i++) {
        LowPower.powerDown(SLEEP_8S, ADC_OFF, BOD_OFF); // leaving sleep
        #ifdef DEBUG
            digitalWrite(13, HIGH);
            delay(500);
            digitalWrite(13, LOW);
        #endif
    }

    // Start the process of receiving and processing data after waking up
    #ifdef DEBUG
        Serial.println("Reading sensor data...");
    #endif

    digitalWrite(POWER_S, HIGH); // ON power for sensor
    luxmeter();
    temperature();
    anemometer();
    digitalWrite(POWER_S, LOW);  // OFF power for sensor

    voltage();

    #ifdef DEBUG
        Serial.println("End reading sensor");
        Serial.println(" ");
    #endif

    counter++;

    if (counter >= ITERATIONS) {
        transmitter();

        // Reset All average values
        counter = 0;
        avg_lux  = avg_wind = 0;
        avg_temp = avg_humd = volt = 0;
    }
} // void loop ()
