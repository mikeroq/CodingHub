-- phpMyAdmin SQL Dump
-- version 2.6.4-pl2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jun 06, 2006 at 01:20 AM
-- Server version: 4.0.25
-- PHP Version: 4.3.11
-- 
-- Database: `mikeroq_site`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `banned`
-- 

CREATE TABLE `banned` (
  `id` int(11) NOT NULL auto_increment,
  `ip` varchar(255) NOT NULL default '',
  `reason` text NOT NULL,
  `legnth` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `logs`
-- 

CREATE TABLE `logs` (
  `id` int(11) NOT NULL auto_increment,
  `page` text NOT NULL,
  `ip` varchar(255) NOT NULL default '',
  `host` text NOT NULL,
  `agent` text NOT NULL,
  `ref` text NOT NULL,
  `date` varchar(255) NOT NULL default '',
  `user` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1599 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `mem`
-- 

CREATE TABLE `mem` (
  `id` int(11) NOT NULL auto_increment,
  `date` varchar(255) NOT NULL default '',
  `time` varchar(255) NOT NULL default '',
  `number` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `members`
-- 

CREATE TABLE `members` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(15) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `regdate` varchar(255) default NULL,
  `aim` varchar(255) NOT NULL default '',
  `msn` varchar(255) NOT NULL default '',
  `googletalk` varchar(255) NOT NULL default '',
  `icq` varchar(255) NOT NULL default '',
  `yahoo` varchar(255) NOT NULL default '',
  `sitetitle` varchar(255) NOT NULL default '',
  `siteurl` text NOT NULL,
  `interests` varchar(255) NOT NULL default '',
  `pages` int(11) NOT NULL default '0',
  `level` int(1) NOT NULL default '0',
  `regip` varchar(255) NOT NULL default '',
  `lastip` varchar(255) NOT NULL default '',
  `lastlogin` varchar(255) NOT NULL default '',
  `time` int(11) NOT NULL default '0',
  `date` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `online`
-- 

CREATE TABLE `online` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(40) NOT NULL default '',
  `lasttime` varchar(40) NOT NULL default '',
  `ip` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=173 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `pmessages`
-- 

CREATE TABLE `pmessages` (
  `id` int(15) NOT NULL auto_increment,
  `subject` varchar(255) NOT NULL default '',
  `message` text NOT NULL,
  `to` varchar(255) NOT NULL default '',
  `from` varchar(255) NOT NULL default '',
  `read` int(1) NOT NULL default '0',
  `date` varchar(255) NOT NULL default '',
  `reply` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `referers`
-- 

CREATE TABLE `referers` (
  `url` varchar(255) default NULL,
  `full` text NOT NULL,
  `d` datetime default NULL
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `servers`
-- 

CREATE TABLE `servers` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `type` varchar(255) NOT NULL default '',
  `reason` text NOT NULL,
  `game` varchar(255) NOT NULL default '',
  `banner` varchar(255) NOT NULL default '',
  `date` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `settings`
-- 

CREATE TABLE `settings` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `value` text NOT NULL,
  `type` varchar(255) NOT NULL default '',
  `sub` varchar(255) NOT NULL default 'global',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `todays`
-- 

CREATE TABLE `todays` (
  `id` int(11) NOT NULL auto_increment,
  `ip` varchar(255) NOT NULL default '',
  `date` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1595 ;
