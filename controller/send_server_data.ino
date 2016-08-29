//**************************************************************//
//  Name    : W E A T H E R   S T A T I O N
//  Author  : Mikhail (Mik™) <miksoft.tm@gmail.com>
//  Version : 1.0.1 (29 Aug 2016)
//  Notes   : FUNCTION - Sending data to the server
//**************************************************************//

void send_server_data() {
    String serverdata1;
    String serverdata2;

    serverdata1 = "ID=3859F96DD7FF&p=";
    serverdata1.concat(pres);
    serverdata1.concat("&t1=");
    serverdata1.concat(temp1);
    serverdata1.concat("&t2=");
    serverdata1.concat(temp2);

    serverdata2 = "&h=";
    serverdata2.concat(humd);
    serverdata2.concat("&v=");
    serverdata2.concat(volt);
    serverdata2.concat("&l=");
    serverdata2.concat(light);
    serverdata2.concat("&w=");
    serverdata2.concat(wind);

    #ifdef DEBUG
        Serial.print("[");
        Serial.print(serverdata1.length() + serverdata2.length());
        Serial.println("] Send server data...");
        Serial.print(serverdata1);
        Serial.println(serverdata2);
    #endif

    if (LAN.connect(serverweather, 80)) {
        LAN.println("POST http://miksrv.ru/meteo/insert HTTP/1.0");
        LAN.println("Host: miksrv.ru");
        LAN.println("Content-Type: application/x-www-form-urlencoded");
        LAN.println("Connection: close");
        LAN.print("Content-Length: ");
        LAN.println(serverdata1.length() + serverdata2.length());
        LAN.println();
        LAN.print(serverdata1);
        LAN.println(serverdata2);
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
