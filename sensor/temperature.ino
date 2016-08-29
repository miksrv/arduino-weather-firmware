//**************************************************************//
//  Name    : W E A T H E R   S T A T I O N
//  Author  : Mikhail (Mik™) <miksoft.tm@gmail.com>
//  Version : 1.0.0 (22 Aug 2016)
//  Notes   : FUNCTION - temperature
//**************************************************************//

void temperature() {
    delay(2500);

    if (DHT.read22(PIN_DHT22) == DHTLIB_OK) {
        temp = DHT.temperature;
        humd = DHT.humidity;

        #ifdef DEBUG
            Serial.print("   [OK] DHTT22 temperature = ");
            Serial.print(temp);
            Serial.println("C");
            Serial.print("   [OK] DHTT22 humduty = ");
            Serial.print(humd);
            Serial.println("%");
        #endif
    } else {
        #ifdef DEBUG
            Serial.println("   [FAIL] DHTT22 temperature");
            Serial.println("   [FAIL] DHTT22 humduty");
        #endif
    }

    avg_temp += temp;
    avg_humd += humd;
} // void temperature()
