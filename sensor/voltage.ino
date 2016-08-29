//**************************************************************//
//  Name    : W E A T H E R   S T A T I O N
//  Author  : Mikhail (Mik™) <miksoft.tm@gmail.com>
//  Version : 1.0.0 (22 Aug 2016)
//  Notes   : FUNCTION - voltage
//**************************************************************//

void voltage() {
    digitalWrite(POWER_V, HIGH);

    delay(10);

    float vout = 0.0; // the measured voltage
    float vin  = 0.0; // without voltage divider
    float R1 = 100300.0; // (Om) the face value shunt resistor (between GND and analog input)
    float R2 = 9930.0;   // (Om) nominal resistor divider (between the input voltage and variable)
    float Vo = 5; // nominal resistor divider (between the input voltage and variable)
    vout  = (analogRead(PIN_VOLT) * Vo) / 1024.0;
    vin   = vout / (R2/(R1+R2)); // we count on the divider
    volt += vin;

    #ifdef DEBUG
        Serial.print("   [OK] Internal voltage = ");
        Serial.print(vout);
        Serial.println(" volt");
        Serial.print("   [OK] Battery voltage = ");
        Serial.print(vin);
        Serial.println(" volt");
    #endif

    delay(10);

    digitalWrite(POWER_V, LOW);
} // void voltage()