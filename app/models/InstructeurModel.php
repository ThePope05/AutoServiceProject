<?php

class InstructeurModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getInstructeurs()
    {
        $sql = "SELECT Id
                      ,Voornaam
                      ,Tussenvoegsel
                      ,Achternaam
                      ,Mobiel
                      ,DatumInDienst
                      ,AantalSterren
                      ,IsActief
                FROM  Instructeur
                ORDER BY AantalSterren DESC";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getInstructeurById(int $Id)
    {
        $sql = "SELECT Id
                      ,Voornaam
                      ,Tussenvoegsel
                      ,Achternaam
                      ,Mobiel
                      ,DatumInDienst
                      ,AantalSterren
                      ,IsActief
                FROM  Instructeur
                WHERE Id = :Id";

        $this->db->query($sql);
        $this->db->bind(':Id', $Id);

        return $this->db->resultSet();
    }

    public function setInstructorActive(bool $curState, int $Id)
    {
        if ($curState) {
            $sql = "UPDATE Instructeur
                    SET IsActief = 0
                    WHERE Id = :Id";
        } else {
            $sql = "UPDATE Instructeur
                    SET IsActief = 1
                    WHERE Id = :Id";
        }

        $this->db->query($sql);
        $this->db->bind(':Id', $Id);

        $this->db->excecuteWithoutReturn();
    }

    public function deleteInstructor(int $Id)
    {
        $sql = "DELETE FROM Instructeur
                WHERE Id = :Id";

        $this->db->query($sql);
        $this->db->bind(':Id', $Id);

        $this->db->excecuteWithoutReturn();
    }

    public function setCarInstructorActive(int $CarId, int $PersonId)
    {
        $sql = "UPDATE VoertuigInstructeur
                SET IsActief = 1
                WHERE VoertuigId = :CarId
                AND InstructeurId = :PersonId;
                UPDATE VoertuigInstructeur
                SET IsActief = 0
                WHERE VoertuigId = :CarId
                AND InstructeurId != :PersonId";

        $this->db->query($sql);
        $this->db->bind(':CarId', $CarId);
        $this->db->bind(':PersonId', $PersonId);

        $this->db->excecuteWithoutReturn();
    }

    public function getToegewezenVoertuigen($Id)
    {
        $sql = "SELECT VOER.Id,
                       TYVO.TypeVoertuig,
                       VOER.Type,
                       VOER.Kenteken,
                       VOER.Bouwjaar,
                       VOER.Brandstof,
                       TYVO.RijbewijsCategorie,
                       INSTR.IsActief
                FROM   Voertuig AS VOER
                INNER JOIN TypeVoertuig AS TYVO
                ON VOER.TypeVoertuigId = TYVO.Id
                INNER JOIN Instructeur AS INSTR
                ON INSTR.Id = :Id
                WHERE VOER.Id IN (
                SELECT VoertuigId FROM voertuiginstructeur 
                WHERE InstructeurId = :Id) AND INSTR.IsActief = 1
                ORDER BY TYVO.RijbewijsCategorie";

        $this->db->query($sql);

        $this->db->bind(':Id', $Id);

        return $this->db->resultSet();
    }

    public function getSickLeaveActivity(int $instructorId, int $CarId)
    {
        $sql = "SELECT Id, IsActief
                FROM VoertuigInstructeur
                WHERE VoertuigId = :CarId
                AND InstructeurId = :instructorId;";

        $this->db->query($sql);

        $this->db->bind(':instructorId', $instructorId);
        $this->db->bind(':CarId', $CarId);

        $result = $this->db->resultSet();

        return $result[0];
    }

    public function getVrijeVoertuigen($Id)
    {
        $sql = "SELECT TYVO.TypeVoertuig,
                       VOER.Type,
                       VOER.Kenteken,
                       VOER.Bouwjaar,
                       VOER.Brandstof,
                       TYVO.RijbewijsCategorie,
                       VOER.Id
                FROM   Voertuig AS VOER
                INNER JOIN TypeVoertuig AS TYVO
                ON VOER.TypeVoertuigId = TYVO.Id
                WHERE VOER.Id NOT IN (
                    SELECT VoertuigId FROM voertuiginstructeur
                    INNER JOIN Instructeur AS INSTR
                    ON InstructeurId = INSTR.Id
                    WHERE INSTR.IsActief = 1
                );";

        $this->db->query($sql);

        return $this->db->resultSet();
    }

    public function addCarToInstructeur($CarId, $PersonId)
    {
        $sql = "UPDATE voertuiginstructeur
                SET IsActief = 0
                WHERE InstructeurId != :PersonId
                AND VoertuigId = :CarId";

        $this->db->query($sql);
        $this->db->bind(':PersonId', $PersonId);
        $this->db->bind(':CarId', $CarId);

        $this->db->excecuteWithoutReturn();

        $sql = "INSERT INTO voertuiginstructeur
                VALUES(null, 
                (SELECT Id FROM Voertuig WHERE Id = $CarId),
                (SELECT Id FROM instructeur WHERE Id = $PersonId), 
                (SELECT Bouwjaar FROM Voertuig WHERE Id = $CarId),
                1, null, SYSDATE(6), SYSDATE(6));";

        $this->db->query($sql);

        $this->db->resultSet();
    }

    public function deleteCarFromInstructeur($CarId, $PersonId)
    {
        $sql = "DELETE FROM voertuiginstructeur
                WHERE VoertuigId = :CarId
                AND InstructeurId = :PersonId;";

        $this->db->query($sql);

        $this->db->bind(':CarId', $CarId);
        $this->db->bind(':PersonId', $PersonId);

        $this->db->excecuteWithoutReturn();
    }

    public function deleteCarsFromInstructeur($PersonId)
    {
        $sql = "DELETE FROM voertuiginstructeur
                WHERE InstructeurId = :PersonId;";

        $this->db->query($sql);

        $this->db->bind(':PersonId', $PersonId);

        $this->db->excecuteWithoutReturn();
    }
}
