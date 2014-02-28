#include <RCSwitch.h>
#include <Time.h> 

////////////
// Config Start
////////////

int ledPin = 13; // 13 -> PIN D13
int senderPowerPin = 7; // 7 -> PIN D7
int senderPin = 10; // 10 -> PIN D10
int receiverPin = 0; // 0 -> PIN D2

////////////
// Config End
////////////

RCSwitch mySwitch = RCSwitch();
String content = "";
char character;

String lastValueReceived = "";
int lastTimeReceived = 0;

void setup() {
  
  Serial.begin(9600);
  mySwitch.enableReceive(receiverPin); // 0 -> PIN D2
  mySwitch.enableTransmit(senderPin); //10 -> PIN D10
  pinMode(senderPowerPin, OUTPUT); 
}

void loop() {
  
  checkReceive();
  checkSend();
}

void checkReceive() {
  
  if (mySwitch.available()) 
  {
    digitalWrite(ledPin, HIGH);
     
    int value = mySwitch.getReceivedValue();
    
    if (value != 0) 
    {
      String received = "D;";
      received += mySwitch.getReceivedValue();
      received += ";";
      received += mySwitch.getReceivedBitlength();
      received += ";";
      received += mySwitch.getReceivedProtocol();
      received += "#";
      
      if (received == lastValueReceived)
      {
        if ((now() - lastTimeReceived) > 3)
        {
          lastValueReceived = "";
        }
      }
      
      if (received != lastValueReceived)
      {
        Serial.println( received );              
        lastValueReceived = received;
        lastTimeReceived = now();
      }  
    }

    mySwitch.resetAvailable();
    
    digitalWrite(ledPin, LOW); 
  }  
}


void checkSend() {
while(Serial.available()) {
    
    character = Serial.read();
    
    if (character == '#') {
     Serial.print("R;"); 
     Serial.print(content);
     Serial.println("#");
     processString(content);
     content = "";   
    } else {
        content.concat(character);
    }
  }  
}


void processString(String data)
{
  digitalWrite(senderPowerPin, HIGH);
  
  String msg = getValue(data, ';', 0);
  String msg_size = getValue(data, ';', 1);
  String protocol = getValue(data, ';', 2);
    
  mySwitch.setProtocol(protocol.toInt());
  mySwitch.send(msg.toInt(), msg_size.toInt());
  
  Serial.print("S;"); 
  Serial.print(msg); 
  Serial.print(";");
  Serial.print(msg_size); 
  Serial.print(";");
  Serial.print(protocol);
  Serial.println("#");
  
  digitalWrite(senderPowerPin, LOW);
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
