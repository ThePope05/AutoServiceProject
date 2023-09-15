<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= URLROOT; ?>/css/style.css">
    <title><?= $data['title'] ?></title>
</head>

<body>
    <h2><?= $data['title']; ?></h2>
    <a class="button" href="<?= URLROOT; ?>/Instructeur/overzichtinstructeur">Instructeurs in dienst</a>
    <a class="button" href="<?= URLROOT; ?>/Examens/overzichtexamens">Examinatoren in dienst</a>
    <a class="button" href="<?= URLROOT; ?>/Voertuig/overzichtVoertuigen">Alle voertuigen</a>
    <a class="button" href="<?= URLROOT; ?>/Voertuig/createVoertuig">Nieuw voertuig</a>
</body>

</html>