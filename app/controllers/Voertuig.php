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
                $linkEl = "<a href='" . URLROOT . "/instructeur/overzichtVoertuigen/$voertuig->InstructeurId'>
                                <span class='material-symbols-outlined'>
                                    person
                                </span>
                            </a>";
            }

            $deleteEl = "<a href='/voertuig/deleteVoertuig/$voertuig->Id";
            $deleteEl .= (!is_null($voertuig->InstructeurId)) ? "/" . $voertuig->InstructeurId : "";
            $deleteEl .= "'>
                                <span class='material-symbols-outlined'>
                                    delete
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
                        <td>$deleteEl</td>
                      </tr>";
        }

        $data = [
            'title' => 'Alle voertuigen',
            'rows' => $rows,
            'amount' => $amount
        ];

        $this->view('Voertuigen/overzichtVoertuigen', $data);
    }

    public function editVoertuig($id)
    {
        $result = $this->voertuigModel->getVoertuig($id);

        $data = [
            'title' => 'Edit voertuig',
            'voertuig' => $result
        ];

        var_dump($data);

        $this->view('Voertuigen/editVoertuig', $data);
    }

    public function deleteVoertuig($id, $instructeurId = null)
    {
        $this->voertuigModel->deleteVoertuig($id, $instructeurId);

        header("Location: " . URLROOT . "/voertuig/overzichtVoertuigen");
    }
}
