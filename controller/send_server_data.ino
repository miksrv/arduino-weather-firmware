//**************************************************************//
//  Name    : W E A T H E R   S T A T I O N
//  Author  : Mikhail (Mik™) <miksoft.tm@gmail.com>
//  Version : 1.1.0 (21 Oct 2016)
//  Notes   : FUNCTION - Sending data to the server
//**************************************************************//

void send_server_data() {
    char buf5[5];
  
    memset(replyBuffer, 0, sizeof(replyBuffer));

    strcpy(replyBuffer,"ID=3859F96DD7FF");

    strcat(replyBuffer, "&p=");  // Atmosphere pressure
    strcat(replyBuffer, mmHg);
    strcat(replyBuffer, "&t1="); // Room temperature
    strcat(replyBuffer, temp1);
    strcat(replyBuffer, "&t2="); // The temperature in the street
    strcat(replyBuffer, temp2);
    strcat(replyBuffer, "&h=");  // Air humidity
    strcat(replyBuffer, humd);
    strcat(replyBuffer, "&v=");  // Battery voltage
    strcat(replyBuffer, volt);
    strcat(replyBuffer, "&l=");  // Illumination
    strcat(replyBuffer, itoa(light, buf5, 5));
    strcat(replyBuffer, "&w=");  // Wind speed
    strcat(replyBuffer, wind);

    strcat(replyBuffer,'\0');

    #ifdef DEBUG
        Serial.print("[Content-Length: ");
        Serial.print(len(replyBuffer));
        Serial.print("] ");
        Serial.println(replyBuffer);
    #endif

    if (LAN.connect(serverweather, 80)) {
        LAN.println("POST http://miksrv.ru/meteo/insert HTTP/1.0");
        LAN.println("Host: miksrv.ru");
        LAN.println("Content-Type: application/x-www-form-urlencoded");
        LAN.println("Connection: close");
        LAN.print("Content-Length: ");
        LAN.println(len(replyBuffer));
        LAN.println();
        LAN.println(replyBuffer);
        LAN.println();
        delay(500);
        LAN.stop();

        #ifdef DEBUG
          Serial.println("SUCCESS!");
          Serial.println();
        #endif
    } else {
        #ifdef DEBUG
          Serial.println("ERROR!");
          Serial.println();
        #endif
    }
}
