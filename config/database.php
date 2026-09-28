<?php

$dsn = 'mysql:host=localhost;dbname=task_manager;charset=utf8mb4';

return new PDO($dsn, 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);
