//**************************************************************//
//  Name    : W E A T H E R   S T A T I O N
//  Author  : Mikhail (Mik™) <miksoft.tm@gmail.com>
//  Version : 1.0.3 (24 Oct 2016)
//  Notes   : FUNCTION - Changes display readings on a certain period of time
//**************************************************************//

void change_display() {
      if (screen == 1) {
            lcd.clear();
            lcd.setCursor(0, 0);
            lcd.print("I=");
            lcd.print(temp1);
            lcd.write((uint8_t)0);
            lcd.print("C");
            lcd.setCursor(0, 1);
            lcd.print(" P=");
            lcd.print(round(pressure / 133.3));
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
} // void change_display()
