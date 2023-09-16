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
    <u><?= $data['title']; ?></u>
    <a href="<?= URLROOT . "/Homepage" ?>" class="button back">Back</a>
    <table>
        <thead>
            <th>Type</th>
            <th>Merk</th>
            <th>Kenteken</th>
            <th>Bouwjaar</th>
            <th>Brandstof</th>
            <th>Rijbewijs</th>
            <th>Instructeur</th>
            <th>Edit</th>
        </thead>
        <tbody>
            <?= $data['rows'] ?>
        </tbody>
    </table>
</body>

</html>