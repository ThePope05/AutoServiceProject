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

<body class="w-12 h12">
    <a href="<?= URLROOT . "/instructeur/overzichtInstructeur" ?>" class="button back">Back</a>
    <div class="center column w-12 h12">
        <u><?= $data['title']; ?></u>
        <p>
            Naam: <?= $data['personData']->Voornaam . " " . $data['personData']->Tussenvoegsel . " " . $data['personData']->Achternaam ?> <br>
            Datum in dienst: <?= $data['personData']->DatumInDienst; ?> <br>
            Aantal sterren: <?= $data['personData']->AantalSterren ?>
        </p>
        <div class="row">
            <p class="center message"><?= $data['message'] ?></p>
            <a class="button" href="<?= URLROOT . '/instructeur/beschikbarenVoertuigen/' . $data['personData']->Id ?>">Voeg voertuig toe</a>
        </div>

        <table>
            <thead>
                <th>Voertuig Type</th>
                <th>Type</th>
                <th>Kenteken</th>
                <th>Bouwjaar</th>
                <th>Brandstof</th>
                <th>Rijbewijs</th>
                <th>Edit</th>
                <th>Delete</th>
            </thead>
            <tbody>
                <?= $data['tableRows'] ?>
            </tbody>
        </table>
    </div>
</body>

</html>