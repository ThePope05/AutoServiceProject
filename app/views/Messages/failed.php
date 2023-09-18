<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,700,1,200" />
    <link rel="stylesheet" href="<?= URLROOT; ?>/css/style.css">
    <title><?= $data['title'] ?></title>
</head>

<body>
    <a href="<?= URLROOT . "/Homepage" ?>" class="button back">Back</a>

    <div class="failed">
        <u><?= $data['title']; ?></u>
        <a href="<?= $data['link'] ?>" class="button">
            <h1><?= $data['message'] ?></h1>
        </a>
    </div>
</body>

</html>