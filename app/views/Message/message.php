<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,700,1,200" />
    <link rel="stylesheet" href="<?= URLROOT; ?>/css/style.css">
    <title>Message</title>
</head>

<body>
    <div class="column center w-12 h-12">
        <h2><?= $data['message']; ?></h2>
        <p>Redirecting in <?= $data['time']; ?> seconds</p>
    </div>

    <script>
        setTimeout(function() {
            window.location.href = "<?= URLROOT . "/" . $data['ref'] ?>";
        }, <?= $data['time'] * 1000 ?>);
    </script>
</body>