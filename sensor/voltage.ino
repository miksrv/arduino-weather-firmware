//**************************************************************//
//  Name    : W E A T H E R   S T A T I O N
//  Author  : Mikhail (Mik™) <miksoft.tm@gmail.com>
//  Version : 1.0.1 (2 Oct 2016)
//  Notes   : FUNCTION - voltage
//**************************************************************//

void voltage() {
    digitalWrite(POWER_V, HIGH);

    delay(10);

    float R1 = 100.3; // (kOm) the face value shunt resistor (between GND and analog input)
    float R2 = 9.93;  // (kOm) nominal resistor divider (between the input voltage and variable)
    float Vo = 1.1;   // reference voltage Arduino (const 1.1V)
    float vout = (analogRead(PIN_VOLT) * Vo) / 1023.0;

    volt += vout / (R2/(R1+R2)); // Calculation of battery voltage

    #ifdef DEBUG
        Serial.print("   [OK] Internal voltage = ");
        Serial.print(vout);
        Serial.println(" volt");
        Serial.print("   [OK] Battery voltage = ");
        Serial.print(volt);
        Serial.println(" volt");
    #endif

    delay(10);

    digitalWrite(POWER_V, LOW);
} // void voltage()
