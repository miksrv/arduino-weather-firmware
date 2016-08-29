//**************************************************************//
//  Name    : W E A T H E R   S T A T I O N
//  Author  : Mikhail (Mik™) <miksoft.tm@gmail.com>
//  Version : 1.0.0 (22 Aug 2016)
//  Notes   : FUNCTION - luxmeter
//**************************************************************//

void luxmeter() {
    // Getting light sensor values
    delay(10);
    // We get the light sensor data
    lux = analogRead(PIN_LUX);
    //lux = map(lux, 509, 1009, 0, 500); // change the range of values
    //lux = constrain(lux, 0, 500);      // we limit the value of a variable outside
    #ifdef DEBUG
        Serial.print("   [OK] Photosensor lux = ");
        Serial.print(lux);
        Serial.println(" units");
    #endif

    avg_lux += lux;

    delay(10);
} // void luxmeter()