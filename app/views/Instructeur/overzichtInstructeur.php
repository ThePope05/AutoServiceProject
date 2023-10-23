<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,700,1,200" />
    <link rel="stylesheet" href="<?= URLROOT; ?>/css/style.css">
    <title>Overzicht Instructeurs</title>
</head>

<body>
    <a href="<?= URLROOT . "/Homepage/" ?>" class="button back">Back</a>
    <div class="column center w-12 h-12">
        <u><?= $data['title']; ?></u>
        <p>Aantal instructeurs <?= $data['amount'] ?></p>
        <table>
            <thead>
                <th>Voornaam</th>
                <th>Tussenvoegsel</th>
                <th>Achternaam</th>
                <th>Mobiel</th>
                <th>Datum in dienst</th>
                <th>Aantal sterren</th>
                <th>Voertuigen</th>
            </thead>
            <tbody>
                <?= $data['rows']; ?>
            </tbody>
        </table>
    </div>
</body>

</html>