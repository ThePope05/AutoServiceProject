<?php

class Instructeur extends BaseController
{
    private $instructeurModel;

    public function __construct()
    {
        $this->instructeurModel = $this->model('InstructeurModel');
    }

    public function overzichtInstructeur()
    {
        $result = $this->instructeurModel->getInstructeurs();

        //  var_dump($result);

        $rows = "";
        $amount = 0;
        foreach ($result as $instructeur) {
            $date = date_create($instructeur->DatumInDienst);
            $formattedDate = date_format($date, "d-m-Y");
            $amount++;
            $rows .= "<tr>
                        <td>$instructeur->Voornaam</td>
                        <td>$instructeur->Tussenvoegsel</td>
                        <td>$instructeur->Achternaam</td>
                        <td>$instructeur->Mobiel</td>
                        <td>$formattedDate</td>            
                        <td>$instructeur->AantalSterren</td> 
                        <td>
                            <a href='" . URLROOT . "/instructeur/overzichtvoertuigen/$instructeur->Id'>
                                <span class='material-symbols-outlined'>
                                directions_car
                                </span>
                            </a>
                        </td>            
                      </tr>";
        }
        
        $data = [
            'title' => 'Instructeurs in dienst',
            'rows' => $rows,
            'amount' => $amount
        ];

        $this->view('Instructeur/overzichtinstructeur', $data);
    }

    public function overzichtVoertuigen($Id)
    {
        $result = $this->instructeurModel->getInstructeurs();
        foreach($result as $person){
            if($person->Id == $Id){
                $instructeur = $person;
            }
        }

        $result = $this->instructeurModel->getToegewezenVoertuigen($Id);
        if($result != null){
            $tableRows = "";
            foreach($result as $voertuig){
                $tableRows .= "<tr>
                                <td>$voertuig->TypeVoertuig</td>
                                <td>$voertuig->Type</td>
                                <td>$voertuig->Kenteken</td>
                                <td>$voertuig->Bouwjaar</td>
                                <td>$voertuig->Brandstof</td>
                                <td>$voertuig->RijbewijsCategorie</td>
                               </tr> ";
            };
        }else{
            $tableRows = "<tr><td colspan='6'>Nog geen voertuigen toegewezen</td></tr>";
        }

        $data = [
            'title' => 'Door instructeur gebruikte voertuigen',
            'tableRows' => $tableRows,
            'personData' => $instructeur
        ];

        $this->view('Instructeur/overzichtVoertuigen', $data);
    }

    public function beschikbarenVoertuigen($Id){
        $result = $this->instructeurModel->getInstructeurs();
        foreach($result as $person){
            if($person->Id == $Id){
                $instructeur = $person;
            }
        }

        $result = $this->instructeurModel->getVrijeVoertuigen($Id);
        if($result != null){
            $tableRows = "";
            var_dump(URLROOT);
            foreach($result as $voertuig){
                $tableRows .= "<tr>
                                <td>$voertuig->TypeVoertuig</td>
                                <td>$voertuig->Type</td>
                                <td>$voertuig->Kenteken</td>
                                <td>$voertuig->Bouwjaar</td>
                                <td>$voertuig->Brandstof</td>
                                <td>$voertuig->RijbewijsCategorie</td>
                                <td>
                                    <a href='" . URLROOT . "/instructeur/beschikbarenVoertuigen/" . $instructeur->Id . "?Update=true&CarId=$voertuig->Id'>
                                        <span class='material-symbols-outlined'>
                                            add_box
                                        </span>
                                    </a>
                                </td>
                               </tr> ";
            };
        }else{
            $tableRows = "<tr><td colspan='6'>Nog geen voertuigen toegewezen</td></tr>";
        }

        $data = [
            'title' => 'Alle beschikbaren voertuigen',
            'tableRows' => $tableRows,
            'personData' => $instructeur
        ];

        $this->view('Instructeur/beschikbarenVoertuigen', $data);
    }

    public function updateVoertuigen($CarId, $PersonId){
        $this->instructeurModel->addCarToInstructeur($CarId, $PersonId);
    }
}