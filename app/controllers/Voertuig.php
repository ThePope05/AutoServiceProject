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

            if($isOdd){
                $backgroundColor = "#edd";
            }

            if($voertuig->InstructeurId == null){
                $voertuig->Voornaam = "Niet";
                $voertuig->Tussenvoegsel = "toegewezen";
                $voertuig->Achternaam = "";

                $linkEl = "";
            }else{
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

    public function editVoertuig($id){
        $result = $this->voertuigModel->getVoertuig($id);

        $data = [
            'title' => 'Edit voertuig',
            'voertuig' => $result
        ];

        var_dump($data);

        $this->view('Voertuigen/editVoertuig', $data);
    }

    // public function overzichtVoertuigen($Id)
    // {
    //     $result = $this->instructeurModel->getInstructeurs();
    //     foreach($result as $person){
    //         if($person->Id == $Id){
    //             $instructeur = $person;
    //         }
    //     }

    //     $result = $this->instructeurModel->getToegewezenVoertuigen($Id);
    //     if($result != null){
    //         $tableRows = "";
    //         foreach($result as $voertuig){
    //             $tableRows .= "<tr>
    //                             <td>$voertuig->TypeVoertuig</td>
    //                             <td>$voertuig->Type</td>
    //                             <td>$voertuig->Kenteken</td>
    //                             <td>$voertuig->Bouwjaar</td>
    //                             <td>$voertuig->Brandstof</td>
    //                             <td>$voertuig->RijbewijsCategorie</td>
    //                            </tr> ";
    //         };
    //     }else{
    //         $tableRows = "<tr><td colspan='6'>Nog geen voertuigen toegewezen</td></tr>";
    //     }

    //     $data = [
    //         'title' => 'Door instructeur gebruikte voertuigen',
    //         'tableRows' => $tableRows,
    //         'personData' => $instructeur
    //     ];

    //     $this->view('Instructeur/overzichtVoertuigen', $data);
    // }

    // public function beschikbarenVoertuigen($Id){
    //     $result = $this->instructeurModel->getInstructeurs();
    //     foreach($result as $person){
    //         if($person->Id == $Id){
    //             $instructeur = $person;
    //         }
    //     }

    //     $result = $this->instructeurModel->getVrijeVoertuigen($Id);
    //     if($result != null){
    //         $tableRows = "";
    //         foreach($result as $voertuig){
    //             $tableRows .= "<tr>
    //                             <td>$voertuig->TypeVoertuig</td>
    //                             <td>$voertuig->Type</td>
    //                             <td>$voertuig->Kenteken</td>
    //                             <td>$voertuig->Bouwjaar</td>
    //                             <td>$voertuig->Brandstof</td>
    //                             <td>$voertuig->RijbewijsCategorie</td>
    //                             <td>
    //                                 <a href='" . URLROOT . "/instructeur/beschikbarenVoertuigen/" . $instructeur->Id . "?Update=true&CarId=$voertuig->Id'>
    //                                     <span class='material-symbols-outlined'>
    //                                         add_box
    //                                     </span>
    //                                 </a>
    //                             </td>
    //                            </tr> ";
    //         };
    //     }else{
    //         $tableRows = "<tr><td colspan='7'>Geen vrije voertuigen</td></tr>";
    //     }

    //     $data = [
    //         'title' => 'Alle beschikbaren voertuigen',
    //         'tableRows' => $tableRows,
    //         'personData' => $instructeur
    //     ];

    //     $this->view('Instructeur/beschikbarenVoertuigen', $data);
    // }

    // public function updateVoertuigen($CarId, $PersonId){
    //     $this->instructeurModel->addCarToInstructeur($CarId, $PersonId);
    // }
}
