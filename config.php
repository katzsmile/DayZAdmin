<?php
	defined('DS') ? null : define('DS',DIRECTORY_SEPARATOR);
	$hostname = "127.0.0.1";  //Database host
	$serverip = "127.0.0.1";  //game-server host
	$rconpassword = "123456"; //rcon password
	$serverport = 2302; //server port
	$username = "dayz"; //database user
	$password = "123456"; //database password
	$dbName = "dayz"; //database name
	$sitename = "DayZ Administration"; //Admin panel name
	$gamepath = "D:".DS."arma2"; //path to the game, ex. "D:\arma2"
	$gameexe = "arma2oaserver.exe"; //server executable name
	$exepath = $gamepath.DS."Expansion".DS."beta".DS.$gameexe; //executable path, ex. "D:\arma2\Expansion\beta\arma2oaserver.exe"
	$serverstring = " -beta=Expansion".DS."beta;Expansion".DS."beta".DS."Expansion -arma2netdev -mod=Expansion".DS."beta\;Expansion".DS."beta".DS."Expansion;@Arma2NET;@CBA;@dayz;@Sanctuary; -name=cfgdayz -config=cfgdayz".DS."server.cfg -cfg=cfgdayz".DS."arma2.cfg -profiles=cfgdayz -cpuCount=2 -maxMem=1578"; //server startup parametres
	$config = "cfgdayz".DS."server.cfg"; //server config file
?>