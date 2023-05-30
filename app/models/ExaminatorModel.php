<?php

class ExaminatorModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getExaminators()
    {
        $sql = "SELECT Id
                      ,Voornaam
                      ,Tussenvoegsel
                      ,Achternaam
                      ,Mobiel
                FROM  Examinator
                ORDER BY Achternaam DESC";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getAllExamData() // alle data waar examinator en examen in zelfde row in externe tabel staan
    {
        $sql = "SELECT EXAM.Id
                       ,EXNA.Voornaam
                       ,EXNA.Tussenvoegsel
                       ,EXNA.Achternaam
                       ,EXAM.Datum
                       ,EXAM.RijbewijsCategorie
                       ,EXAM.Rijschool
                       ,EXAM.Stad
                       ,EXAM.Uitslag  
                FROM  Examen AS EXAM
                INNER JOIN Examinator AS EXNA
                ON EXNA.Id = (SELECT ExaminatorId FROM ExamenPerExaminator WHERE ExamenId = EXAM.Id)
                ORDER BY Achternaam DESC";

        $this->db->query($sql);

        return $this->db->resultSet();
    }
}