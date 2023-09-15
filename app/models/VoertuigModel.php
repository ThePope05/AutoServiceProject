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

    public function getVoertuig($carId, $instId)
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
}
