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

            $editEl = "<a href='" . URLROOT . "/Voertuig/editVoertuig/" . $voertuig->Id . "/";

            if ($voertuig->InstructeurId != null) {
                $editEl .= $voertuig->InstructeurId;
            } else {
                $editEl .= "null";
            }

            $editEl .= "'>
                            <span class='material-symbols-outlined'>
                                edit
                            </span>
                        </a>";

            $rows .= "<tr style='background-Color: " . $backgroundColor . ";'>
                        <td>$voertuig->TypeVoertuig</td>
                        <td>$voertuig->Type</td>
                        <td>$voertuig->Kenteken</td>
                        <td>$voertuig->Bouwjaar</td>
                        <td>$voertuig->Brandstof</td>
                        <td>$voertuig->RijbewijsCategorie</td>
                        <td>$voertuig->Voornaam $voertuig->Tussenvoegsel $voertuig->Achternaam</td>
                        <td>$linkEl</td>
                        <td>$editEl</td>
                      </tr>";
        }

        $data = [
            'title' => 'Alle voertuigen',
            'rows' => $rows,
            'amount' => $amount
        ];

        $this->view('Voertuigen/overzichtVoertuigen', $data);
    }

    public function editVoertuig($carId, $instId = null)
    {
        if ($instId == "null") {
            $result = $this->voertuigModel->getVoertuig($carId);
        } else {
            $result = $this->voertuigModel->getVoertuigInstructor($carId, $instId);
        }
        $data = [
            'title' => 'Verander voertuig',
            'buttonText' => 'Verander voertuig',
            'voertuig' => (is_array($result)) ? $result[0] : $result,
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
