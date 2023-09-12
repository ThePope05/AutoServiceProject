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

    // public function getToegewezenVoertuigen($Id)
    // {
    //     $sql = "SELECT TYVO.TypeVoertuig,
    //                    VOER.Type,
    //                    VOER.Kenteken,
    //                    VOER.Bouwjaar,
    //                    VOER.Brandstof,
    //                    TYVO.RijbewijsCategorie
    //             FROM   Voertuig AS VOER
    //             INNER JOIN TypeVoertuig AS TYVO
    //             ON VOER.TypeVoertuigId = TYVO.Id
    //             WHERE VOER.Id IN (
    //             SELECT VoertuigId FROM voertuiginstructeur 
    //             WHERE InstructeurId = $Id)
    //             ORDER BY TYVO.RijbewijsCategorie";

    //     $this->db->query($sql);

    //     return $this->db->resultSet();
    // }

    // public function getVrijeVoertuigen($Id)
    // {
    //     $sql = "SELECT TYVO.TypeVoertuig,
    //                    VOER.Type,
    //                    VOER.Kenteken,
    //                    VOER.Bouwjaar,
    //                    VOER.Brandstof,
    //                    TYVO.RijbewijsCategorie,
    //                    VOER.Id
    //             FROM   Voertuig AS VOER
    //             INNER JOIN TypeVoertuig AS TYVO
    //             ON VOER.TypeVoertuigId = TYVO.Id
    //             WHERE VOER.Id NOT IN (
    //                 SELECT VoertuigId from voertuiginstructeur
    //             );";

    //     $this->db->query($sql);

    //     return $this->db->resultSet();
    // }

    // public function addCarToInstructeur($CarId, $PersonId)
    // {
    //     $sql = "INSERT INTO voertuiginstructeur
    //             VALUES(null, 
    //             (SELECT Id FROM Voertuig WHERE Id = $CarId),
    //             (SELECT Id FROM instructeur WHERE Id = $PersonId), 
    //             (SELECT Bouwjaar FROM Voertuig WHERE Id = $CarId),
    //             1, null, SYSDATE(6), SYSDATE(6));";

    //     $this->db->query($sql);

    //     $this->db->excecuteWithoutReturn();
    // }
}