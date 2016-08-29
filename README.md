Arduino Weather Station
===============
This project is designed to teach the basic skills and understanding of working with microcontrollers ATmega (Arduino). The project is a working model of an automated weather station, consisting of two the Component: transmitter and receiver. The controller transmits data to a remote web server, and to indicate the current readings uses character.

The weather station is capable of transmitting on the following environmental sotoyanii data protection:

- temperature
- humidity
- illumination
- wind speed
- atmosphere pressure

----------------------

### Components

- Arduino PRO mini
- Arduino NANO
- Arduino Ethernet Shield
- BMP085
- DHT22
- DS18B20
- RF modules

The project uses self-made developments, such as the airflow meter (angular velocity sensor based), voltmeter, light meter, as well as the switching board for Arduino PRO mini and transistor switches.

----------------------

### Libraries
List of additional (other than standard) libraries

##### Transmitter

- [DHT22 & DHT11] [DHT]
- [Virtual Wire] [VirtualWire]
- [Easy Transfer Virtual Wire] [EasyTransferVirtualWire]
- [Simple Timer] [SimpleTimer]
- [Low Power] [LowPower]

##### Master controller

- [BMP085] [BMP085]
- [OneWire] [OneWire]
- [Dallas Temperature] [DallasTemperature]

[DHT]: <https://github.com/RobTillaart/Arduino/tree/master/libraries/DHTlib>
[VirtualWire]: <https://github.com/digistump/DigistumpArduino/tree/master/digistump-avr/libraries/VirtualWire>
[EasyTransferVirtualWire]: <https://github.com/madsci1016/Arduino-EasyTransfer>
[SimpleTimer]: <https://github.com/jfturcot/SimpleTimer>
[LowPower]: <https://github.com/rocketscream/Low-Power>
[BMP085]: <https://github.com/adafruit/Adafruit-BMP085-Library>
[OneWire]: <http://playground.arduino.cc/Learning/OneWire>
[DallasTemperature]: <https://github.com/milesburton/Arduino-Temperature-Control-Library>