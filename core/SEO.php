<?php

namespace Core;

/**
 * SEO - Gerenciamento de Metadados e SEO
 * 
 * Classe responsável por gerenciar títulos, descrições e metadados
 * das páginas de forma simples e centralizada.
 */
class SEO
{
    private array $defaults = [];
    private array $staticPages = [];
    private array $dynamicPageCallbacks = [];

    /**
     * Define os metadados padrão (fallback)
     */
    public function setDefaults(array $meta): void
    {
        $this->defaults = $meta;
    }

    /**
     * Registra metadados para uma página estática
     */
    public function setPage(string $activePage, array $meta): void
    {
        $this->staticPages[$activePage] = $meta;
    }

    /**
     * Registra um callback para páginas dinâmicas
     * 
     * @param string $activePage Ex: '/posts' ou '/segmentos'
     * @param callable $callback Função que recebe $slug e retorna array de meta
     */
    public function setDynamicPage(string $activePage, callable $callback): void
    {
        $this->dynamicPageCallbacks[$activePage] = $callback;
    }

    /**
     * Retorna os metadados finais para a página atual
     */
    public function get(string $activePage, ?string $slug = null): array
    {
        $meta = $this->defaults;

        // Se for página estática, retorna os metadados configurados
        if (isset($this->staticPages[$activePage])) {
            return array_merge($meta, $this->staticPages[$activePage]);
        }

        // Se for página dinâmica e tiver slug
        if ($slug && isset($this->dynamicPageCallbacks[$activePage])) {
            $callback = $this->dynamicPageCallbacks[$activePage];
            $dynamicMeta = $callback($slug);
            
            if ($dynamicMeta) {
                return array_merge($meta, $dynamicMeta);
            }
        }

        // Retorna padrão se nada foi encontrado
        return $meta;
    }

    /**
     * Helper para formatar template de título
     */
    public static function formatTitle(string $title, string $template = 'Eventool | %s | Software para Gestão de Eventos'): string
    {
        return sprintf($template, $title);
    }
}
