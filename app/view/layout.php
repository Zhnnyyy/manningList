<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $data['title'] ?? "Manning List" ?></title>
        <link rel="stylesheet" href="<?= ROOT_CSS ?>layout.css">
        <link rel="stylesheet" href="<?= ROOT_CSS ?>bootstrap.min.css">
        <link rel="stylesheet" href="<?= ROOT_CSS ?>dataTables.bootstrap5.css">
        <?php
        if (isset($data['styles'])) {
                foreach ($data['styles'] as $style) {
                        echo $style;
                }
        }
        ?>
</head>

<body>
        <?php isset($data['header']) && $data['header'] == 1 ? include 'partials/header.php' : "" ?>
        <?php include $view; ?>
        <?php isset($data['footer']) && $data['header'] == 1 ? include 'partials/footer.php' : "" ?>


        <?php include 'partials/modals.php' ?>


        <script src="<?= ROOT_JS ?>jquery.min.js"></script>
        <script src="<?= ROOT_JS ?>sweetalert2@11.js"></script>
        <script src="<?= ROOT_JS ?>bootstrap.bundle.min.js"></script>
        <script src="<?= ROOT_JS ?>dataTables.js"></script>
        <script src="<?= ROOT_JS ?>dataTables.bootstrap5.js"></script>
        <script type="module" src="<?= ROOT_JS ?>ajax.js"></script>
        <script type="module" src="<?= ROOT_JS ?>functions.js"></script>
        <script src="<?= ROOT_JS ?>main.js"></script>
        <?php
        if (isset($data['script'])) {
                foreach ($data['script'] as $script) {
                        echo $script;
                }
        }
        ?>
</body>

</html>