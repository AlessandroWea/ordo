<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=APP_NAME . (isset($page_title) ? (' - ' . $page_title) : '');?></title>
</head>
<style>
    .red {
        color: red;
    }

    body {
        background-color: #333;
    }
</style>
<body>
    <?=$content;?>
</body>
</html>