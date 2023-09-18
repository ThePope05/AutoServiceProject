<?php

class VoertuigModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getVoertuigen()
    {
        $sql = "SELECT VOER.Id,
                       VOER.Type,
                       VOER.Kenteken,
                       VOER.Bouwjaar,
                       VOER.Brandstof,
                       TYVO.RijbewijsCategorie,
                       TYVO.TypeVoertuig,
                       INST.Voornaam,
                       INST.Tussenvoegsel,
                       INST.Achternaam,
                       INST.AantalSterren,
                       VOERINST.DatumToekenning,
                       INST.Id AS InstructeurId
                FROM   Voertuig AS VOER
                INNER JOIN TypeVoertuig AS TYVO
                ON VOER.TypeVoertuigId = TYVO.Id
                LEFT JOIN voertuiginstructeur AS VOERINST
                ON VOER.Id = VOERINST.VoertuigId
                LEFT JOIN instructeur AS INST
                ON VOERINST.InstructeurId = INST.Id
                ORDER BY INST.Voornaam";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getVoertuigInstructor($carId, $instId)
    {
        $sql = "SELECT VOER.Id,
                       VOER.Type,
                       VOER.Kenteken,
                       VOER.Bouwjaar,
                       VOER.Brandstof,
                       TYVO.RijbewijsCategorie,
                       TYVO.TypeVoertuig,
                       INST.Voornaam,
                       INST.Tussenvoegsel,
                       INST.Achternaam,
                       INST.Id AS InstructeurId
                FROM   Voertuig AS VOER
                INNER JOIN TypeVoertuig AS TYVO
                ON VOER.TypeVoertuigId = TYVO.Id
                LEFT JOIN voertuiginstructeur AS VOERINST
                ON VOER.Id = VOERINST.VoertuigId
                LEFT JOIN instructeur AS INST
                ON VOERINST.InstructeurId = INST.Id
                WHERE VOER.Id = $carId AND VOERINST.InstructeurId = $instId;";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getVoertuig($carId)
    {
        $sql = "SELECT VOER.Id,
                       VOER.Type,
                       VOER.Kenteken,
                       VOER.Bouwjaar,
                       VOER.Brandstof,
                       TYVO.RijbewijsCategorie,
                       TYVO.TypeVoertuig
                FROM   Voertuig AS VOER
                INNER JOIN TypeVoertuig AS TYVO
                ON VOER.TypeVoertuigId = TYVO.Id;";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getTypes()
    {
        $sql = "SELECT TypeVoertuig FROM TypeVoertuig";
        $this->db->query($sql);
        $types = $this->db->resultSet();

        $sql = "SELECT RijbewijsCategorie FROM TypeVoertuig";
        $this->db->query($sql);
        $categories = $this->db->resultSet();

        $sql = "SELECT CONCAT(Voornaam, ' ', Tussenvoegsel, ' ', Achternaam) AS Naam, Id FROM Instructeur";
        $this->db->query($sql);
        $instructors = $this->db->resultSet();

        $sql = "SELECT Brandstof FROM Voertuig GROUP BY Brandstof";
        $this->db->query($sql);
        $fuels = $this->db->resultSet();

        $data = [
            'types' => $types,
            'instructors' => $instructors,
            'categories' => $categories,
            'fuels' => $fuels
        ];

        return $data;
    }

    public function createVoertuig($voertuig)
    {
        $subStatement = 'SELECT Id FROM typeVoertuig WHERE TypeVoertuig = "' . $voertuig['typevoer'] . '"';

        $sql = 'INSERT INTO Voertuig (Type, Kenteken, Bouwjaar, Brandstof, TypeVoertuigId, DatumAangemaakt, DatumGewijzigd)
                VALUES ( "' . $voertuig['type'] . '", "' .
            $voertuig['kenteken'] . '", "' .
            $voertuig['bouwjaar'] . '", "' .
            $voertuig['brandstof'] . '", (' .
            $subStatement . '), NOW(), NOW());';

        $statement = $this->db->query($sql);

        $this->db->executeWithoutReturn();

        $subStatement = 'SELECT Id FROM Voertuig WHERE Kenteken = "' . $voertuig['kenteken'] . '"';

        $sql = 'INSERT INTO voertuiginstructeur (VoertuigId, InstructeurId, DatumToekenning, DatumAangemaakt, DatumGewijzigd)
                VALUES ( (' . $subStatement . '), "' .
            $voertuig['instructeurId'] . '", NOW(), NOW(), NOW());';

        $this->db->query($sql);

        $this->db->executeWithoutReturn();
    }

    public function updateVoertuig($voertuig)
    {
        $subStatement = 'SELECT Id FROM typeVoertuig WHERE TypeVoertuig = "' . $voertuig['typevoer'] . '"';

        $sql = 'UPDATE Voertuig
                SET Type = "' . $voertuig['type'] . '", Kenteken = "' . $voertuig['kenteken'] . '", Bouwjaar = "' . $voertuig['bouwjaar'] . '", Brandstof = "' . $voertuig['brandstof'] . '", TypeVoertuigId = (' . $subStatement . '), DatumGewijzigd = NOW()
                WHERE Id = ' . $voertuig['Id'] . ';';

        $this->db->query($sql);

        $this->db->executeWithoutReturn();

        $sql = 'UPDATE voertuiginstructeur
                SET InstructeurId = "' . $voertuig['instructeurId'] . '", DatumGewijzigd = NOW()
                WHERE VoertuigId = ' . $voertuig['Id'] . ' AND InstructeurId = "' . $voertuig['oldInstrId'] . '";';

        $this->db->query($sql);

        $this->db->executeWithoutReturn();
    }
}
