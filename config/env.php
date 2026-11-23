<?php

$env = parse_ini_file(__DIR__ . '/../.env');

if ($env === false) {
    die('.env-Datei konnte nicht geladen werden.');
}