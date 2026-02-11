<?php
/**
 * Página de Categoria do Blog
 * 
 * A variável $slug está automaticamente disponível nesta página.
 */

// Busca a regsitro pelo slug

// Se não encontrou a categoria, exibe 404
if (!$slug) {
    http_response_code(404);
    include "pages/404.php";
    return;
}


?>

<h1>Dynamic - <?php echo $slug; ?></h1>