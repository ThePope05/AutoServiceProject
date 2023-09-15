<?php

class Voertuig extends BaseController
{
    private $voertuigModel;

    public function __construct()
    {
        $this->voertuigModel = $this->model('VoertuigModel');
    }

    public function overzichtVoertuigen()
    {
        $result = $this->voertuigModel->getVoertuigen();

        $rows = "";
        $amount = 0;
        foreach ($result as $voertuig) {
            $date = date_create($voertuig->DatumToekenning);
            $formattedDate = date_format($date, "d-m-Y");
            $amount++;

            //I need all car data in the tabel
            //There needs to be a link that goes to the linked instructor
            //I need only the last name of the instructor
            //This needs to be right before the link to the instructor
            //It needs to be html To inject into the $rows variable

            //I need a variable to determine if $amount is an odd or even number and make a boolean out of it

            $isOdd = $amount % 2 == 1;
            $backgroundColor = "white";

            if ($isOdd) {
                $backgroundColor = "#edd";
            }

            if ($voertuig->InstructeurId == null) {
                $voertuig->Voornaam = "Niet";
                $voertuig->Tussenvoegsel = "toegewezen";
                $voertuig->Achternaam = "";

                $linkEl = "";
            } else {
                $linkEl = "<a href='" . URLROOT . "/instructeur/overzichtVoertuigen/" . $voertuig->InstructeurId . "'>
                                <span class='material-symbols-outlined'>
                                    person
                                </span>
                            </a>";
            }

            $rows .= "<tr style='background-Color: " . $backgroundColor . ";'>
                        <td>$voertuig->TypeVoertuig</td>
                        <td>$voertuig->Type</td>
                        <td>$voertuig->Kenteken</td>
                        <td>$voertuig->Bouwjaar</td>
                        <td>$voertuig->Brandstof</td>
                        <td>$voertuig->RijbewijsCategorie</td>
                        <td>$voertuig->Voornaam $voertuig->Tussenvoegsel $voertuig->Achternaam</td>
                        <td>$linkEl</td>
                      </tr>";
        }

        $data = [
            'title' => 'Alle voertuigen',
            'rows' => $rows,
            'amount' => $amount
        ];

        $this->view('Voertuigen/overzichtVoertuigen', $data);
    }

    public function editVoertuig($carId, $instId)
    {
        $result = $this->voertuigModel->getVoertuig($carId, $instId);
        $data = [
            'title' => 'Verander voertuig',
            'buttonText' => 'Verander voertuig',
            'voertuig' => $result,
            'subData' => $this->voertuigModel->getTypes(),
        ];

        $this->view('Voertuigen/voertuigForm', $data);
    }

    public function createVoertuig()
    {
        $data = [
            'title' => 'Voeg nieuw voertuig toe',
            'buttonText' => 'Voeg voertuig toe',
            'voertuig' => null,
            'subData' => $this->voertuigModel->getTypes()
        ];

        $this->view('Voertuigen/voertuigForm', $data);
    }
}
