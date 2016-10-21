//**************************************************************//
//  Name    : W E A T H E R   S T A T I O N
//  Author  : Mikhail (Mik™) <miksoft.tm@gmail.com>
//  Version : 1.1.0 (21 Oct 2016)
//  Notes   : FUNCTION - Preparation of environmental data from local sensors
//**************************************************************//

void get_local_sensors() {
    tempSensors.requestTemperatures(); // DS18B20
    DPS.getPressure(&pressure);        // BMP180

    float temperature = tempSensors.getTempCByIndex(0);
    float temp_press  = pressure / 133.3

    // Formatting values
    dtostrf(temperature, 4, 1, temp1);
    dtostrf(temp_press, 5, 1, mmHg);

    #ifdef DEBUG
        Serial.println("get_local_sensors init...");
        Serial.print("  tem_inside = ");
        Serial.println(temp1);
        Serial.print("  var_pressure = ");
        Serial.println(round(temp_press));
        Serial.println(" ");
        Serial.println(" ");
    #endif
} // void get_local_sensors()
