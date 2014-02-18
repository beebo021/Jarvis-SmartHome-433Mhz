#include <RCSwitch.h>


RCSwitch mySwitch = RCSwitch();
int led = 13;
String content = "";
char character;


void setup() {
  
  Serial.begin(9600);
  mySwitch.enableReceive(0);
  mySwitch.enableTransmit(10);
}


void loop() {
  
  if (mySwitch.available()) {
    digitalWrite(led, HIGH);
     
    int value = mySwitch.getReceivedValue();
    
    if (value != 0) 
    {
      Serial.print("D;");
      Serial.print(mySwitch.getReceivedValue());
      Serial.print(";");
      Serial.print( mySwitch.getReceivedBitlength());
      Serial.print(";");
      Serial.println( mySwitch.getReceivedProtocol());
    }

    mySwitch.resetAvailable();
    
    digitalWrite(led, LOW); 
  }

  while(Serial.available()) {
    
    character = Serial.read();
    
    if (character == '#') {
     Serial.print("R;"); Serial.println(content);
     processString(content);
     content = "";   
    } else {
        content.concat(character);
    }
  }
}


void processString(String data)
{
  String msg = getValue(data, ';', 0);
  String msg_size = getValue(data, ';', 1);
  String protocol = getValue(data, ';', 2);
  
  //Serial.print("msg: "); Serial.println(msg);
  //Serial.print("msg_size: "); Serial.println(msg_size);
  //Serial.print("protocol: "); Serial.println(protocol);
  
  mySwitch.setProtocol(protocol.toInt());
  mySwitch.send(msg.toInt(), msg_size.toInt());
  
  Serial.print("S;"); 
  Serial.print(msg); Serial.print(";");
  Serial.print(msg_size); Serial.print(";");
  Serial.println(protocol);
}


String getValue(String data, char separator, int index)
{
  int found = 0;
  int strIndex[] = {0, -1};
  int maxIndex = data.length()-1;

  for(int i=0; i<=maxIndex && found<=index; i++){
    if(data.charAt(i)==separator || i==maxIndex){
        found++;
        strIndex[0] = strIndex[1]+1;
        strIndex[1] = (i == maxIndex) ? i+1 : i;
    }
  }

  return found>index ? data.substring(strIndex[0], strIndex[1]) : "";
}