Code voor de hardware van IoT workshop groep 2.
In de Attiny folder zitten de files voor de slave modules(AtTiny85 modules). 
In de sensor folder zit code om een sensor uit te lezen en vervolgens te versturen via de I2C bus naar de master module(nodeMCU).
Om dit te kunnen uploaden naar de AtTiny85 is een arduino nodig als ISP programmer en de AtTiny85 library voor de arduino IDE.

In de NodeMCU folder zit de node folder(oude nodeMCU code gestript van LED code) en de MasterNodeSensor die de slave modules kan uitlezen die op de 
I2C bus zijn aangesloten samen met de code om met het internet te verbinden en te communiceren met de API. Om het te kunnen uploaden naar de NodeMCU heb je de esp8266 library nodig. 
De MasterModuleActuator stuurt een commando(sensor waarde) naar de Attiny.