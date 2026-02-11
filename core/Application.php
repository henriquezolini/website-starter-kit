<?php

namespace Core;

/**
 * Application - Classe Principal do Framework
 * 
 * Responsável por inicializar o framework, carregar configurações,
 * resolver rotas e renderizar o layout com contexto compartilhado.
 */
class Application
{
    private Router $router;
    private SEO $seo;
    private string $rootDir;

    public function __construct()
    {
        $this->rootDir = dirname(__DIR__);
        
        // Define constantes globais
        $this->defineConstants();
        
        // Carrega classes do core
        require_once __DIR__ . '/Router.php';
        require_once __DIR__ . '/SEO.php';
        require_once __DIR__ . '/helpers.php';
        
        // Inicializa componentes
        $this->router = new \Core\Router(PAGES_DIR);
        $this->seo = new \Core\SEO();
    }

    /**
     * Define constantes globais do framework
     */
    private function defineConstants(): void
    {
        // Define a URL base do site dinamicamente
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $baseDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
        define('BASE_URL', "{$protocol}://{$host}{$baseDir}/");
        
        // Define diretórios
        define('PAGES_DIR', $this->rootDir . '/pages');
        define('ROOT_DIR', $this->rootDir);
    }

    /**
     * Carrega configurações do usuário
     */
    private function loadUserConfig(): void
    {   
        // Carrega bootstrap do usuário (integração com CMS, etc)
        $bootstrapFile = $this->rootDir . '/bootstrap.php';
        if (file_exists($bootstrapFile)) {
            require_once $bootstrapFile;
        }
    }

    /**
     * Carrega configuração de SEO do usuário
     */
    private function loadSEOConfig(): void
    {
        $seoConfigFile = $this->rootDir . '/configs/seo.php';
        
        if (file_exists($seoConfigFile)) {
            // Passa o objeto SEO para o arquivo de configuração
            $seo = $this->seo;
            require $seoConfigFile;
        }
    }

    /**
     * Executa a aplicação
     */
    public function run(): void
    {
        // Carrega configurações do usuário
        $this->loadUserConfig();
        
        // Carrega configuração de SEO
        $this->loadSEOConfig();
        
        // Resolve a rota
        $route = $this->router->resolve();
        
        // Define constante ACTIVE_PAGE
        define('ACTIVE_PAGE', $route['activePage']);
        
        // Define o código HTTP
        if ($route['is404']) {
            http_response_code(404);
        }
        
        // Verifica se o arquivo existe
        if (!file_exists($route['file'])) {
            http_response_code(500);
            die("Erro Crítico: O arquivo da página '{$route['file']}' não foi encontrado.");
        }
        
        // Obtém metadados da página
        $pageSEO = $this->seo->get($route['activePage'], $route['slug']);
        
        // Renderiza o layout com contexto compartilhado
        $this->renderLayout($route['file'], $route['slug'], $pageSEO);
    }

    /**
     * Renderiza o layout com contexto compartilhado
     * 
     * Esta função garante que todas as variáveis definidas nos includes
     * (head, header, etc) estejam disponíveis na página e vice-versa.
     */
    private function renderLayout(string $pageFile, ?string $slug, array $pageSEO): void
    {
        // Define o arquivo de layout
        $layoutFile = $this->rootDir . '/configs/layout.php';
        
        if (!file_exists($layoutFile)) {
            // Fallback: se não houver layout.php, usa estrutura básica
            echo "<!DOCTYPE html>\n<html lang=\"pt-br\">\n<head>\n";
            echo "<title>{$pageSEO['title']}</title>\n";
            echo "</head>\n<body>\n<main>\n";
            
            require $pageFile;
            
            echo "\n</main>\n</body>\n</html>";
            return;
        }
        
        // Carrega o layout
        // Todas as variáveis definidas aqui estarão disponíveis no layout e nos includes
        require $layoutFile;
    }
}