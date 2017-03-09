<?php
	
	session_start();
	
	$configFile = include('config/app.conf');
	require_once 'connection/DB.class.php';
	require_once 'controller/Users.class.php';
	require_once 'controller/Order.class.php';