<?php

class Instructeur extends BaseController
{
    private $instructeurModel;

    public function __construct()
    {
        $this->instructeurModel = $this->model('InstructeurModel');
    }

    public function index()
    {
        $this->overzichtInstructeur();
    }

    public function overzichtInstructeur()
    {
        $result = $this->instructeurModel->getInstructeurs();

        $rows = "";
        $amount = 0;
        foreach ($result as $instructeur) {
            $date = date_create($instructeur->DatumInDienst);
            $formattedDate = date_format($date, "d-m-Y");
            $amount++;

            $verlofEl = ($instructeur->IsActief) ? "<td>
                            <a href='" . URLROOT . "/Instructeur/setActive/" . $instructeur->IsActief . "/" . $instructeur->Id . "'>
                                <span class='material-symbols-outlined'>
                                    recommend
                                </span>
                            </a>
                        </td>" : "
                        <td>
                            <a href='" . URLROOT . "/Instructeur/setActive/" . $instructeur->IsActief . "/" . $instructeur->Id . "'>
                                <span class='material-symbols-outlined'>
                                    healing
                                </span>
                            </a>
                        </td>";

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
                        $verlofEl       
                      </tr>";
        }

        $data = [
            'title' => 'Instructeurs in dienst',
            'rows' => $rows,
            'amount' => $amount
        ];

        $this->view('Instructeur/overzichtinstructeur', $data);
    }

    public function setActive($curState, $Id)
    {
        $this->instructeurModel->setActive($curState, $Id);

        if ($curState) {
            header("Location: " . URLROOT . "/Message/Message/Instructeur_is_niet_actief/Instructeur");
        } else {
            header("Location: " . URLROOT . "/Message/Message/Instructeur_is_actief/Instructeur");
        }
    }

    public function overzichtVoertuigen($Id, $Message = null)
    {
        $result = $this->instructeurModel->getInstructeurs();
        foreach ($result as $person) {
            if ($person->Id == $Id) {
                $instructeur = $person;
            }
        }

        $result = $this->instructeurModel->getToegewezenVoertuigen($Id);
        if ($result != null) {
            $tableRows = "";
            foreach ($result as $voertuig) {
                $toegewezenEl = ($this->instructeurModel->getSickLeaveActivity($instructeur->Id, $voertuig->Id)) ? "
                <span class='material-symbols-outlined'>
                    check_box
                </span>"
                    : "
                <span class='material-symbols-outlined'>
                    check_box_outline_blank
                </span>";

                $tableRows .= "<tr>
                                <td>$voertuig->TypeVoertuig</td>
                                <td>$voertuig->Type</td>
                                <td>$voertuig->Kenteken</td>
                                <td>$voertuig->Bouwjaar</td>
                                <td>$voertuig->Brandstof</td>
                                <td>$voertuig->RijbewijsCategorie</td>
                                <td>$toegewezenEl</td>
                                <th>
                                    <a href='" . URLROOT . "/Voertuig/editVoertuig/" . $voertuig->Id . "'>
                                        <span class='material-symbols-outlined'>
                                            edit
                                        </span>
                                    </a>
                                </th>
                                <th>
                                    <a href='" . URLROOT . "/instructeur/deleteCar/$voertuig->Id/$instructeur->Id'>
                                        <span class='material-symbols-outlined'>
                                            delete
                                        </span>
                                    </a>
                                </th>
                               </tr> ";
            };
        } else {
            if ($instructeur->IsActief) {
                $tableRows = "<tr><td colspan='6'>Nog geen voertuigen toegewezen</td></tr>";
            } else {
                $tableRows = "<tr><td colspan='6'>Instructeur is niet actief</td></tr>";
            }
        }

        $data = [
            'title' => 'Door instructeur gebruikte voertuigen',
            'tableRows' => $tableRows,
            'personData' => $instructeur,
            'message' => $Message
        ];

        $this->view('Instructeur/overzichtVoertuigen', $data);
    }

    public function beschikbarenVoertuigen($Id)
    {
        $result = $this->instructeurModel->getInstructeurs();
        foreach ($result as $person) {
            if ($person->Id == $Id) {
                $instructeur = $person;
            }
        }

        $result = $this->instructeurModel->getVrijeVoertuigen($Id);
        if ($result != null) {
            $tableRows = "";
            foreach ($result as $voertuig) {
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
        } else {
            $tableRows = "<tr><td colspan='7'>Geen vrije voertuigen</td></tr>";
        }

        $data = [
            'title' => 'Alle beschikbaren voertuigen',
            'tableRows' => $tableRows,
            'personData' => $instructeur
        ];

        $this->view('Instructeur/beschikbarenVoertuigen', $data);
    }

    public function updateVoertuigen($CarId, $PersonId)
    {
        $this->instructeurModel->addCarToInstructeur($CarId, $PersonId);

        header("Location: " . URLROOT . "/instructeur/overzichtVoertuigen/$PersonId/Voertuig%20toegevoegd");
    }

    public function deleteCar($CarId, $PersonId)
    {
        $this->instructeurModel->deleteCarFromInstructeur($CarId, $PersonId);

        header("Location: " . URLROOT . "/instructeur/overzichtVoertuigen/$PersonId/Voertuig%20verwijderd");
    }
}
