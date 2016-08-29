//**************************************************************//
//  Name    : W E A T H E R   S T A T I O N
//  Author  : Mikhail (Mik™) <miksoft.tm@gmail.com>
//  Version : 1.0.0 (22 Aug 2016)
//  Notes   : FUNCTION - Preparation of environmental data from local sensors
//**************************************************************//

void get_local_sensors() {
    tempSensors.requestTemperatures(); // DS18B20

    float temperature = tempSensors.getTempCByIndex(0);
    long  pressure    = DPS.readPressure();

    // Formatting values
    dtostrf(temperature, 4, 1, temp1);
    pres  = round(pressure / 133.3);

    #ifdef DEBUG
        Serial.println("get_local_sensors init...");
        Serial.print("  tem_inside = ");
        Serial.println(temp1);
        Serial.print("  var_pressure = ");
        Serial.println(pres);
        Serial.println(" ");
        Serial.println(" ");
    #endif
} // void get_local_sensors()
