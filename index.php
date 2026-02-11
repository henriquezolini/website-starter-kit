<?php
/**
 * Entry Point do Framework
 * 
 * Este é o ponto de entrada da aplicação.
 * Não é necessário modificar este arquivo.
 */

require __DIR__ . '/core/Application.php';

$app = new \Core\Application();
$app->run();