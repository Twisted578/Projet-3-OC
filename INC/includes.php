<?php
session_start();
include 'config.php';
include 'classes/Db.php';
$DB = new Db();
require "classes/Texte.php";
include 'classes/User.php';