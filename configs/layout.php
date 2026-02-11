<!DOCTYPE html>
<html lang="pt-br">

<head>
  <?php include "includes/head.php"; ?>
</head>

<body>
  <?php include "includes/header.php"; ?>
  <main>
    <?php 
      /**
       * Este é o conteúdo da página.
       * 
       * Variáveis disponíveis aqui:
       * - $slug: slug da URL (null se não for rota dinâmica)
       * - $pageSEO: array com metadados (title, description, image, data)
       * - Todas as variáveis definidas no header também estão disponíveis
       */
      
      // A variável $pageFile é definida pelo Application.php
      if (isset($pageFile) && file_exists($pageFile)) {
          require $pageFile;
      }
    ?>
  </main>
  <?php
    include "includes/footer.php";
    include "includes/scripts.php";
  ?>
</body>

</html>