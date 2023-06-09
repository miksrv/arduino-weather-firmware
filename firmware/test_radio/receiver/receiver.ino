//**************************************************************//
//  Name    : R A D I O   T E S T
//  Author  : Mikhail (Mik™) <miksoft.tm@gmail.com>
//  Version : 1.1 (22 Aug 2016)
//  Notes   : Receiver - communication range test
//**************************************************************//

#include <VirtualWire.h>             // Library for the 1-Wire Transmitter
#include <EasyTransferVirtualWire.h> // Transmitter Library
#include <LiquidCrystal.h>

#define DEBUG // Debug mode (messages are displayed in a series)

const byte PIN_RADIO   = 2; // Digital pin to connect the receiver

// Receiver initialization
EasyTransferVirtualWire RADIO;

// We initialize the object screen, used to pass the connection pins 
// on the Arduino in order:
// RS, E, DB4, DB5, DB6, DB7
LiquidCrystal lcd(9, 8, 4, 5, 6, 7);

unsigned int counter = 0; // The received data counter of iterations
byte seed            = 0; // Data received random number (1 bytes 0 ... 255)

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
        Serial.println("Receiver programm");
        Serial.println(" ");
    #endif

    lcd.begin(16, 2);
    lcd.setCursor(0, 0);
    lcd.print("Initiali");
    lcd.setCursor(0, 1);
    lcd.print("zation..");

    RADIO.begin(details(radiodata)); // Initialization radio
    vw_set_rx_pin(PIN_RADIO); // Receiver pin set
    vw_setup(2000);           // We set the speed of the reception / transmission (bit / s)
    vw_rx_start();            // Radio reception launch mode

    delay(1000);

    lcd.clear();
} // void setup()


// MAIN LOOP
void loop () {
    // Check whether the data came on the radio
    if (RADIO.receiveData()) {
        seed    = radiodata.seed_random;
        counter = radiodata.seed;

        Serial.println("Received!");
        Serial.println(" ");

        lcd.clear();
        lcd.setCursor(0, 0);
        lcd.print("R=");
        lcd.print(seed);

        lcd.setCursor(0, 1);
        lcd.print("C=");
        lcd.print(counter);
    }
} // void loop ()