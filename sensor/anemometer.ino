//**************************************************************//
//  Name    : W E A T H E R   S T A T I O N
//  Author  : Mikhail (Mik™) <miksoft.tm@gmail.com>
//  Version : 1.0.1 (1 Sen 2016)
//  Notes   : FUNCTION - anemometer
//**************************************************************//

void anemometer() {
    impulse = 0;

    attachInterrupt(0, rpm, RISING);
    delay(1000);
    detachInterrupt(0);

    avg_wind += impulse;

    #ifdef DEBUG
        Serial.print("   [OK] Pulses number (wind) = ");
        Serial.print(impulse);
        Serial.println(" units");
    #endif
} // void anemometer()

void rpm() {
    impulse++;
} // void rpm()
