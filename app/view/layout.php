<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title'] ?? "Manning List" ?></title>
      <?php
      if (isset($data['styles'])) {
              foreach ($data['styles'] as $style) {
                      echo $style;
              }
      }
      ?>
</head>
<body>

        <?php require $view; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" ></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>