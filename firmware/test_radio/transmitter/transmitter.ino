//**************************************************************//
//  Name    : R A D I O   T E S T
//  Author  : Mikhail (Mik™) <miksoft.tm@gmail.com>
//  Version : 1.1 (22 Aug 2016)
//  Notes   : Transmitter - communication range test
//**************************************************************//

#include <VirtualWire.h>             // Library for the 1-Wire Transmitter
#include <EasyTransferVirtualWire.h> // Transmitter Library

#define DEBUG // Debug mode (messages are displayed in a series)

#define POWER_R    4  // Pin-powered radio control
#define PIN_RADIO  7  // Digital pin transmitter

EasyTransferVirtualWire ET; // Transmitter protocol initialization

unsigned int iteration = 0; // The counter of iterations

// Structure Radio (transport packets). The structure must be defined identically 
// at all receivers and the transmitter. Structure size must not exceed 26 bytes.
struct RADIODATA_STRUCTURE {
    byte seed_random;  // Randomly generated sequence of characters (8 bits 0..255)
    unsigned int seed; // Sequence (2 bytes 0 ... 65535)
};

RADIODATA_STRUCTURE radiodata; // Establish a link to the structure of the Radio

void setup() {
    #ifdef DEBUG
        Serial.begin(9600);
        Serial.println("Transmitter programm");
        Serial.println(" ");
    #endif

    // The control pin for transmitter power
    pinMode(POWER_R, OUTPUT);

    digitalWrite(POWER_R, HIGH);

    // Initialization of the transmitter
    #ifdef DEBUG
        Serial.print("Transmitter start...");
    #endif
    ET.begin(details(radiodata)); // Transmitter initializing
    vw_set_tx_pin(PIN_RADIO);     // Set pin transmitter
    vw_setup(2000);               // We set the speed of the reception / transmission (bit / s)
    #ifdef DEBUG
        Serial.println(" ok");
    #endif

    // Report on program startup
    #ifdef DEBUG
        Serial.println("Start programm... ok");
        Serial.println(" ");
    #endif
} // void setup()


// MAIN LOOP
void loop () {
  
    delay(1000);

    #ifdef DEBUG
        Serial.print("Data transfer...");
    #endif

    iteration++;

    delay(50);

    radiodata.seed_random = random(0, 255);
    radiodata.seed        = iteration;

    // The data is sent two times to improve noise immunity
    ET.sendData();
    delay(300);
    ET.sendData();
    delay(300);

    #ifdef DEBUG
        Serial.println(" ok!");
        Serial.print("[R = ");
        Serial.print(radiodata.seed_random);
        Serial.print(", I = ");
        Serial.print(radiodata.seed);
        Serial.println("]");
        Serial.println(" ");
    #endif
} // void loop ()