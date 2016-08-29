//**************************************************************//
//  Name    : W E A T H E R   S T A T I O N
//  Author  : Mikhail (Mik™) <miksoft.tm@gmail.com>
//  Version : 1.0.0 (22 Aug 2016)
//  Notes   : FUNCTION - Changes display readings on a certain period of time
//**************************************************************//

void change_display() {
    // This code is executed constantly. First, we check to see if the desired 
    // interval has passed, then retain the last shift, and send data to the server
    unsigned long currentMillis = millis();

    if (currentMillis - previousMillis > interval) {
        previousMillis = currentMillis; 
        get_local_sensors();
        send_server_data();
    }

    if (currentMillis - screenMillis > 5000) {
        screenMillis = currentMillis; 

        if (screen == 1) {
            lcd.clear();
            lcd.setCursor(0, 0);
            lcd.print("I=");
            lcd.print(temp1);
            lcd.write((uint8_t)0);
            lcd.print("C");
            lcd.setCursor(0, 1);
            lcd.print(" P=");
            lcd.print(pres);
            lcd.print("mm");
            screen = 2;
        } else if (screen == 2) {
            lcd.clear();
            lcd.setCursor(0, 0);
            lcd.print("O=");
            lcd.print(temp2);
            lcd.write((uint8_t)0);
            lcd.print("C");
            lcd.setCursor(0, 1);
            lcd.print(" H=");
            lcd.print(humd);
            lcd.print("\x25");
            screen = 3;
        } else if (screen == 3) {
            lcd.clear();
            lcd.setCursor(0, 0);
            lcd.print("L=");
            lcd.print(light);
            lcd.setCursor(0, 1);
            lcd.print("V=");
            lcd.print(volt);
            screen = 1                                                                                                                                                                              ;
        }
    }
} // void change_display()