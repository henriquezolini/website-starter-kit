<?php

namespace Core;

/**
 * Router - Sistema de Roteamento do Framework
 * 
 * Responsável por resolver rotas estáticas e dinâmicas,
 * transformando URLs amigáveis em caminhos de arquivos.
 */
class Router
{
    private string $pagesDir;
    private ?string $slug = null;
    private array $routeParams = [];

    public function __construct(string $pagesDir)
    {
        $this->pagesDir = $pagesDir;
    }

    /**
     * Resolve a rota atual e retorna o caminho do arquivo da página
     */
    public function resolve(): array
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $baseDir = dirname($_SERVER['SCRIPT_NAME']);
        $route = $requestUri;
        
        if ($baseDir !== '/' && str_starts_with($requestUri, $baseDir)) {
            $route = substr($requestUri, strlen($baseDir));
        }
        
        $route = trim($route, '/');
        $route = preg_replace('/\.php$/i', '', $route);
        
        $pageHome = $this->pagesDir . '/index.php';
        $page404 = $this->pagesDir . '/404.php';

        // Rota vazia = homepage
        if (empty($route)) {
            return [
                'file' => $pageHome,
                'slug' => null,
                'activePage' => '/index.php',
                'is404' => false
            ];
        }

        // 1. Tenta encontrar rotas estáticas
        $potentialPaths = [
            $this->pagesDir . '/' . $route . '.php',      // Ex: /pages/empresa.php
            $this->pagesDir . '/' . $route . '/index.php'   // Ex: /pages/empresa/index.php
        ];

        foreach ($potentialPaths as $path) {
            if (file_exists($path)) {
                $activePage = str_replace($this->pagesDir, '', $path);
                return [
                    'file' => $path,
                    'slug' => null,
                    'activePage' => $activePage,
                    'is404' => false
                ];
            }
        }

        // 2. Procura por rotas dinâmicas (com slug)
        $routeParts = explode('/', $route);
        
        if (count($routeParts) > 1) {
            // A última parte da URL é o slug
            $slug = array_pop($routeParts);
            
            // O caminho restante é a base da rota dinâmica
            $dynamicRouteBase = implode('/', $routeParts);
            
            // Tenta encontrar arquivo [slug].php
            $potentialDynamicPath = $this->pagesDir . '/' . $dynamicRouteBase . '/[slug].php';

            if (file_exists($potentialDynamicPath)) {
                $activePage = str_replace($this->pagesDir, '', $potentialDynamicPath);
                $activePage = str_replace('/[slug].php', '', $activePage);
                
                return [
                    'file' => $potentialDynamicPath,
                    'slug' => $slug,
                    'activePage' => $activePage,
                    'is404' => false
                ];
            }
        }

        // 3. Nenhuma rota encontrada = 404
        return [
            'file' => $page404,
            'slug' => null,
            'activePage' => '/404.php',
            'is404' => true
        ];
    }

    /**
     * Retorna o slug da rota (se houver)
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * Retorna parâmetros adicionais da rota
     */
    public function getRouteParams(): array
    {
        return $this->routeParams;
    }
}