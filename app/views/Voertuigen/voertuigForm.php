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
    <h2><?= $data['title']; ?></h2>
    <a href="<?= URLROOT . "/Homepage" ?>" class="button back">Back</a>
    <form method="post" action="<?= $data['formAction'] ?>">
        <?php
        $voertuigIsset = false;
        if ($data['voertuig'] != null) {
            $voertuigIsset = true;
        } else {
            $voertuigIsset = false;
        }
        ?>
        <div>
            <label for="instr">Instructeur</label>
            <select name="instr">
                <?php
                if ($data['voertuig']->InstructeurId == null) {
                    echo '<option value="">Kies een instructeur</option>';
                }
                foreach ($data['subData']['instructors'] as $instructor) {
                    if ($voertuigIsset) {
                        if ($instructor->Id == $data['voertuig']->InstructeurId) {
                            echo "<option value='$instructor->Id' selected>$instructor->Naam</option>";
                        } else {
                            echo "<option value='$instructor->Id'>$instructor->Naam</option>";
                        }
                    } else {
                        echo "<option value='$instructor->Id'>$instructor->Naam</option>";
                    }
                }
                ?>
            </select>
        </div>

        <div>
            <label for="typevoer">Type voertuig</label>
            <select name="typevoer">
                <?php
                if (!$voertuigIsset) {
                    echo '<option value="">Kies een Voertuig type</option>';
                }
                foreach ($data['subData']['types'] as $type) {
                    if ($voertuigIsset) {
                        if ($type->TypeVoertuig == $data['voertuig']->TypeVoertuig) {
                            echo "<option value='$type->TypeVoertuig' selected>$type->TypeVoertuig</option>";
                        } else {
                            echo "<option value='$type->TypeVoertuig'>$type->TypeVoertuig</option>";
                        }
                    } else {
                        echo "<option value='$type->TypeVoertuig'>$type->TypeVoertuig</option>";
                    }
                }
                ?>
            </select>
        </div>

        <div>
            <label for="type">Type</label>
            <input type="text" name="type" <?php echo ($voertuigIsset) ? ("value='" . $data['voertuig']->Type . "'") : "" ?>>
        </div>

        <div>
            <label for="bouwjaar">Bouwjaar</label>
            <input type="date" name="bouwjaar" <?php echo ($voertuigIsset) ? ("value='" . $data['voertuig']->Bouwjaar . "' readonly") : "" ?>>
        </div>

        <div>
            <label for="">Brandstof</label>
            <input type="radio" name="Brandstof" value="Diesel" <?php echo ($voertuigIsset && $data['voertuig']->Brandstof == "Diesel") ? ("checked") : "" ?>>
            <label for="Diesel">Diesel</label>
            <input type="radio" name="Brandstof" value="Benzine" <?php echo ($voertuigIsset && $data['voertuig']->Brandstof == "Benzine") ? ("checked") : "" ?>>
            <label for="Benzine">Benzine</label>
            <input type="radio" name="Brandstof" value="Elektrisch" <?php echo ($voertuigIsset && $data['voertuig']->Brandstof == "Elektrisch") ? ("checked") : "" ?>>
            <label for="Elektrisch">Elektrisch</label>
        </div>

        <div>
            <label for="kenteken">Kenteken</label>
            <input type="text" name="kenteken" <?php echo ($voertuigIsset) ? ("value='" . $data['voertuig']->Kenteken . "'") : "" ?>>
        </div>

        <input type="submit" value="<?= $data['buttonText'] ?>">
    </form>
</body>

</html>