# JARVIS SmartHome

Jarvis is a WebApp that allows you to turn your home into a DIY SmartHome.

# Progress [### 25%       ]

I'm still working on it, I hope to have a first beta in few days.

## Tell me more !

Jarvis has some code written in PHP (and a small part in Python) and a data base in MySQL. You can install it on your home  server (I'm using a Raspberry Pi) and control your "smart things" from a webpage or an App.

## Smart Things ?

At the moment I'm working with this kind of [sockets](http://www.amazon.co.uk/REMOTE-CONTROLLED-MAINS-SOCKETS-OPERATION/dp/B0068JOTTA/ref=pd_sim_sbs_diy_7), this kind of [movement sensors](http://dx.com/p/hw-01a-wireless-pir-motion-detector-white-1-x-9v-127629), and this kind of [door sensors](http://dx.com/p/oudi-ad-87-433mhz-wireless-door-contact-white-248919). They work with radio frequency on the 433 Mhz Band and they are really really cheap.

## What do I need ?

- A Raspberry Pi or any PC with Linux.
- Any Arduino board, I'm using [this one](http://dx.com/p/nano-v3-0-avr-atmega328-p-20au-module-board-usb-cable-for-arduino-118037#.Ut65AXk4lGE).
- One 433Mhz RF Transmitter module and one receiver module, I'm using [this one](http://dx.com/p/433mhz-rf-transmitter-module-receiver-module-link-kit-for-arduino-arm-mcu-wl-green-220194#.UvT5r3k8bRt).
- Actuators: Some sockets working on the 433 Mhz, I'm using [this one](http://www.amazon.co.uk/REMOTE-CONTROLLED-MAINS-SOCKETS-OPERATION/dp/B0068JOTTA/ref=pd_sim_sbs_diy_7).
- Sensors: Some [movement sensors](http://dx.com/p/hw-01a-wireless-pir-motion-detector-white-1-x-9v-127629) and [door sensors](http://dx.com/p/oudi-ad-87-433mhz-wireless-door-contact-white-248919).

## Arduino + 433Mhz RF Modules ?

We will make a kind of "433Mhz USB remote control" with an Arduino board and the 433Mhz modules. It will send and receive the commands between the Raspberry Pi, the sensors and the actuators.

## Let's talk about security

The commands that you'll send to turn on and off the actuators are not cypher. So... the bad news is that your neighbor can copy the commands when you are sending them, the good news is that you actually know where he lives ;)

Obviously it is not the safer system in the market, but it is damn cheap, so... use it under your own risk.
