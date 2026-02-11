<?php
/**
 * Configuração de SEO do Site
 * * Este arquivo centraliza a configuração de metadados (títulos, descrições, imagens)
 * para páginas estáticas e dinâmicas utilizando o objeto $seo.
 * * Métodos disponíveis:
 * - setDefaults([])       : Define os dados padrão (fallback).
 * - setPage('', [])       : Define metadados para uma URL/arquivo específico.
 * - setDynamicPage('', fn): Define metadados baseados em um slug dinâmico.
 */

// 1. CONFIGURAÇÕES PADRÃO (Aparecem quando nada mais for definido)
$seo->setDefaults([
    'title'       => 'Nome do Site | Descrição Curta',
    'description' => 'Descrição padrão do site para aparecer nos motores de busca.',
    'image'       => 'https://seusite.com.br/assets/img/og-default.png',
    'data'        => null
]);

// Variável auxiliar para manter um padrão visual nos títulos (opcional)
$titleTemplate = 'Nome do Site | %s';


// 2. PÁGINAS ESTÁTICAS (Exemplos)
$seo->setPage('/index.php', [
    'title'       => sprintf($titleTemplate, 'Home'),
    'description' => 'Bem-vindo à nossa página inicial.'
]);

$seo->setPage('/contato/index.php', [
    'title'       => sprintf($titleTemplate, 'Contato'),
    'description' => 'Entre em contato com a nossa equipe.'
]);


// 3. PÁGINAS DINÂMICAS (Exemplos baseados em slug)
/**
 * O primeiro parâmetro é o prefixo da rota.
 * O segundo é uma função que recebe o $slug e retorna o array de metadados.
 */

// Exemplo para Posts de Blog
$seo->setDynamicPage('/blog', function($slug) use ($titleTemplate) {
    // Exemplo de lógica de busca (ajuste conforme seu sistema de dados/CMS)
    if (!function_exists('getCollection')) return null;
    
    $data = getCollection('posts', ['filter' => ['slug' => $slug]]);
    
    if (!empty($data)) {
        $item = $data[0];
        return [
            'title'       => sprintf($titleTemplate, $item['titulo']),
            'description' => substr(strip_tags($item['conteudo'] ?? ''), 0, 160),
            'image'       => $item['imagem_capa'] ?? '',
            'data'        => $item // Passa os dados brutos para uso posterior se necessário
        ];
    }
    
    return null;
});

// Exemplo para Categorias ou Serviços
$seo->setDynamicPage('/servicos', function($slug) use ($titleTemplate) {
    // Lógica para buscar dados do serviço pelo slug
    // return [ ... ];
    return null; 
});

// ============================================================================
// ESPAÇO PARA NOVAS CONFIGURAÇÕES
// ============================================================================