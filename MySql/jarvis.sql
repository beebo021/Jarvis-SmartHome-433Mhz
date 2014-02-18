-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 12, 2014 at 06:02 PM
-- Server version: 5.5.29
-- PHP Version: 5.4.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `jarvis`
--

-- --------------------------------------------------------

--
-- Table structure for table `cmds_queue`
--

CREATE TABLE `cmds_queue` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `cod_thing` int(11) NOT NULL,
  `cmd` varchar(50) NOT NULL,
  `value` varchar(50) NOT NULL,
  `triggerAt` datetime NOT NULL,
  `executedAt` datetime NOT NULL,
  `executed` tinyint(1) NOT NULL,
  PRIMARY KEY (`cod`),
  KEY `executed` (`executed`),
  KEY `triggerAt` (`triggerAt`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `rf433_daemon`
--

CREATE TABLE `rf433_daemon` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `cod_thing` int(11) NOT NULL,
  `cmd` varchar(50) NOT NULL,
  `value` varchar(50) NOT NULL,
  `rfString` varchar(50) NOT NULL,
  PRIMARY KEY (`cod`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `rf433_log`
--

CREATE TABLE `rf433_log` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(50) NOT NULL,
  `created_at` date NOT NULL,
  PRIMARY KEY (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rules`
--

CREATE TABLE `rules` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `cod_thing` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `timely` tinyint(1) NOT NULL,
  `atTime` time NOT NULL,
  `atDate` date NOT NULL,
  `repeat` varchar(25) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `triggeredAt` datetime NOT NULL,
  PRIMARY KEY (`cod`),
  KEY `cod_thing` (`cod_thing`),
  KEY `timely` (`timely`),
  KEY `atTime` (`atTime`),
  KEY `active` (`active`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `rules_commands`
--

CREATE TABLE `rules_commands` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `cod_rule` int(11) NOT NULL,
  `cod_thing` int(11) NOT NULL,
  `delay` int(11) NOT NULL,
  `cmd` varchar(25) NOT NULL,
  `value` varchar(25) NOT NULL,
  `order` int(11) NOT NULL,
  `triggeredAt` datetime NOT NULL,
  PRIMARY KEY (`cod`),
  KEY `cod_rule` (`cod_rule`),
  KEY `cod_thing` (`cod_thing`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `rules_conditions`
--

CREATE TABLE `rules_conditions` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `cod_rule` int(11) NOT NULL,
  `cod_thing` int(11) NOT NULL,
  `trigger` tinyint(1) NOT NULL,
  `condition` varchar(10) NOT NULL,
  `value` varchar(10) NOT NULL,
  `triggeredAt` datetime NOT NULL,
  PRIMARY KEY (`cod`),
  KEY `cod_rule` (`cod_rule`),
  KEY `cod_thing` (`cod_thing`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `things`
--

CREATE TABLE `things` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `kind` varchar(25) NOT NULL,
  `name` varchar(50) NOT NULL,
  `config` text NOT NULL,
  `status` int(11) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `cod_parent` int(11) NOT NULL,
  `ord` int(11) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`cod`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `things_log`
--

CREATE TABLE `things_log` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `cod_thing` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`cod`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;
