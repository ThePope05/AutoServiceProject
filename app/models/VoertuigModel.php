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

    public function getVoertuig($Id)
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
                WHERE VOER.Id = $Id";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function deleteVoertuig($id, $instructeurId)
    {
        if (!is_null($instructeurId)) {
            $sql = "DELETE FROM VoertuigInstructeur WHERE VoertuigId = :id AND InstructeurId = :instructeurId";

            $this->db->query($sql);

            $this->db->bind(':id', $id);
            $this->db->bind(':instructeurId', $instructeurId);

            $this->db->excecuteWithoutReturn();
        }

        $sql = "DELETE FROM Voertuig WHERE Id = :id";

        $this->db->query($sql);

        $this->db->bind(':id', $id);

        $this->db->excecuteWithoutReturn();
    }
}
