//**************************************************************//
//  Name    : W E A T H E R   S T A T I O N
//  Author  : Mikhail (Mik™) <miksoft.tm@gmail.com>
//  Version : 1.0.0 (22 Aug 2016)
//  Notes   : FUNCTION - luxmeter
//**************************************************************//

void luxmeter() {
    delay(10);

    lux = analogRead(PIN_LUX);

    // EXPEREMENTAL:
    // MAX_ADC_READING = 1023, ADC_REF_VOLTAGE = 5
    // LUX_CALC_SCALAR = 12518931, LUX_CALC_EXPONENT = -1.405

    // rawData = analogRead(__PIN);
    // resistorVoltage = (float)ldrRawData / MAX_ADC_READING * ADC_REF_VOLTAGE;
    // ldrVoltage = ADC_REF_VOLTAGE - resistorVoltage;
    // ldrResistance = ldrVoltage/resistorVoltage * REF_RESISTANCE;
    // ldrLux = LUX_CALC_SCALAR * pow(ldrResistance, LUX_CALC_EXPONENT);

    #ifdef DEBUG
        Serial.print("   [OK] Photosensor lux = ");
        Serial.print(lux);
        Serial.println(" units");
    #endif

    avg_lux += lux;

    delay(10);
} // void luxmeter()