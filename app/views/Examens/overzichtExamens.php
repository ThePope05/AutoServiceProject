<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,700,1,200" />
    <link rel="stylesheet" href="<?= URLROOT; ?>/css/style.css">
    <title>Overzicht Examens</title>
</head>
<body>
    <u><?= $data['title']; ?></u>
    <p>Aantal examens <?= $data['amount'] ?></p>
    <a href="<?= URLROOT . "/Homepage/index" ?>" class="button">Back</a>

    <table>
        <thead>
            <th>Voornaam</th>
            <th>Tussenvoegsel</th>
            <th>Achternaam</th>
            <th>Mobiel</th>
        </thead>
        <tbody>
            <?= $data['rows']; ?>
        </tbody>
    </table>
</body>
</html>



