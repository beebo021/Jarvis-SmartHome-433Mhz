#include <avr/sleep.h>
#include <avr/wdt.h>
#include <EEPROM.h>
#include <RCSwitch.h>

#ifndef cbi
#define cbi(sfr, bit) (_SFR_BYTE(sfr) &= ~_BV(bit))
#endif
#ifndef sbi
#define sbi(sfr, bit) (_SFR_BYTE(sfr) |= _BV(bit))
#endif

RCSwitch mySwitch = RCSwitch();

int senderPowerPin = 0;
int senderPin = 1;

int timer = 0;
int counter;

void setup() {
  
  pinMode(senderPowerPin, OUTPUT); 
  mySwitch.enableTransmit(senderPin);
  setup_watchdog(8);
  
  counter = EEPROM.read(0);  //EEPROM read
}


void loop() {
  
  if (counter == timer)
  {
    counter = 0;
    EEPROM.write(0, counter);
    
    digitalWrite(senderPowerPin, HIGH);
    mySwitch.send(111103, 32);
    digitalWrite(senderPowerPin, LOW);
  }
  else
  {
    counter++;
    EEPROM.write(0, counter);
  }
  
  system_sleep();
}


// Watchdog timeout values
// 0=16ms, 1=32ms, 2=64ms, 3=128ms, 4=250ms, 5=500ms
// 6=1sec, 7=2sec, 8=4sec, 9=8sec
void setup_watchdog(int ii) 
{  
 // The prescale value is held in bits 5,2,1,0
 // This block moves ii itno these bits
 byte bb;
 if (ii > 9 ) ii=9;
 bb=ii & 7;
 if (ii > 7) bb|= (1<<5);
 bb|= (1<<WDCE);
 
 // Reset the watchdog reset flag
 MCUSR &= ~(1<<WDRF);
 // Start timed sequence
 WDTCR |= (1<<WDCE) | (1<<WDE);
 // Set new watchdog timeout value
 WDTCR = bb;
 // Enable interrupts instead of reset
 WDTCR |= _BV(WDIE);
}


void system_sleep() 
{
 cbi(ADCSRA,ADEN); // Switch Analog to Digital converter OFF 
 set_sleep_mode(SLEEP_MODE_PWR_DOWN); // Set sleep mode
 //set_sleep_mode(SLEEP_MODE_IDLE); // Set sleep mode
 sleep_mode(); // System sleeps here
 sbi(ADCSRA,ADEN);  // Switch Analog to Digital converter ON
}


void doBlink(int mlseconds)
{
  digitalWrite(senderPin, HIGH);
  delay (mlseconds);
  digitalWrite(senderPin, LOW);
  delay(100);
}


void reBlink(int times, int mlseconds)
{
  for (int i=times; i > 0; i--) 
  {
      doBlink(mlseconds);
  }
}

