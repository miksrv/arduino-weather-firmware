//**************************************************************//
//  Name    : W E A T H E R   S T A T I O N
//  Author  : Mikhail (Mik™) <miksoft.tm@gmail.com>
//  Version : 1.0.0 (22 Aug 2016)
//  Notes   : FUNCTION - transmitter
//**************************************************************//

void transmitter() {
    #ifdef DEBUG
        Serial.print("Transmission data...");
    #endif

    digitalWrite(POWER_R, HIGH);
    
    delay(50);

    //radiodata.device_id      = DEVICE_ID;
    //radiodata.destination_id = 1;
    //radiodata.seed_random = random(0, 255);
    radiodata.volt = (int) round((volt / ITERATIONS) * 100); // voltage, remove the decimal places
    radiodata.temp = (int) round(((avg_temp / ITERATIONS) + 100) * 100); // temperature, remove the decimal places, remove the negative temperature
    radiodata.humd = (int) round((avg_humd / ITERATIONS) * 100);         // humidity, remove the decimal places
    radiodata.wind = (int) round(avg_wind / ITERATIONS);  // the amount of rotation of encoder pulses
    radiodata.lux  = (int) round(avg_lux / ITERATIONS);   // light

    // The data is sent two times to improve noise immunity
    ET.sendData();
    delay(300);
    ET.sendData();
    delay(300);

    #ifdef DEBUG
        Serial.println(" ok!");
        Serial.print("[V = ");
        Serial.print(radiodata.volt);
        Serial.print(", T = ");
        Serial.print(radiodata.temp);

        delay(10);

        Serial.print(", H = ");
        Serial.print(radiodata.humd);
        Serial.print(", W = ");
        Serial.print(radiodata.wind);
        Serial.print(", L = ");
        Serial.print(radiodata.lux);
        Serial.println("]");
        Serial.println(" ");
    #endif

    delay(10);
    digitalWrite(POWER_R, LOW);
} // void transmitter()