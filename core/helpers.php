<?php

/**
 * Helpers - Funções Auxiliares do Framework
 * 
 * Funções utilitárias usadas pelo framework e disponíveis
 * para as páginas e includes.
 */

/**
 * Verifica se uma página está ativa (para navegação)
 */
function isActive(string $pagina): string
{
    if (!defined('ACTIVE_PAGE')) {
        return '';
    }
    
    if (strpos(ACTIVE_PAGE, $pagina) !== false) {
        return 'active';
    }
    
    return '';
}

/**
 * Lê e decodifica um arquivo JSON
 */
function getJsonFile(string $path): ?array
{
    if (!file_exists($path)) {
        return null;
    }
    
    $json = file_get_contents($path);
    $result = json_decode($json, true);
    
    return $result;
}
