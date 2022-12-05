<?php
session_start();

$_SESSION = [];

header('Location: /inventario_ayuntamiento/index.php');