<?php

class Examens extends BaseController
{
    private $examinatorModel;

    public function __construct()
    {
        $this->examinatorModel = $this->model('ExaminatorModel');
    }

    public function overzichtExamens()
    {
        $AllExaminatoren = $this->examinatorModel->getAllExamData();

        $rows = "";
        $amount = 0;
        foreach ($AllExaminatoren as $exam) {
            $amount++;
            $rows .= "<tr>
                        <td>$exam->Voornaam $exam->Tussenvoegsel $exam->Achternaam</td>
                        <td>$exam->Datum</td>
                        <td>$exam->RijbewijsCategorie</td>
                        <td>$exam->Rijschool</td>
                        <td>$exam->Stad</td>
                        <td>$exam->Uitslag</td>                     
                      </tr>";
        }
        
        $data = [
            'title' => 'Alle examens',
            'rows' => $rows,
            'amount' => $amount
        ];

        $this->view('Examens/overzichtexamens', $data);
    }
}