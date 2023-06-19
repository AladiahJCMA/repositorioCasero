<?php
declare(strict_types=1);
require_once('./model/Subtheme/SubthemesSQL.php');
require_once('./model/Subtheme/Subtheme.php');

class SubthemesController {
    private $ss;
    public function __construct() {
        $this->ss = new SubthemesSQL(ConnectionDB::connect());
    }
    
    public function getSubthemes() {
        echo json_encode($this->ss->getSubthemes());
    }
    
    public function getSubthemesByTheme() {
        $idTheme = intval(filter_var(file_get_contents('idTheme'), FILTER_SANITIZE_NUMBER_INT));
        echo json_encode($this->ss->getSubthemesByTheme($idTheme));
    }

    public function newSubtheme() {
        $idAdmin = intval(file_get_contents('idAdmin'));
        $data = json_decode(file_get_contents('php://input'));
        $nSubtheme = new Subtheme(
            intval(filter_var($data->id, FILTER_SANITIZE_NUMBER_INT)),
            intval(filter_var($data->themeId, FILTER_SANITIZE_NUMBER_INT)),
            htmlspecialchars($data->name)
        );

        echo json_encode($this->ss->createSubtheme($nSubtheme, $idAdmin));
    }

    public function editSubtheme() {
        $idAdmin = intval(filter_var(file_get_contents('idAdmin'), FILTER_SANITIZE_NUMBER_INT));
        $data = json_decode(file_get_contents('php://input'));
        $nSubtheme = new Subtheme(
            intval(filter_var($data->id, FILTER_SANITIZE_NUMBER_INT)),
            intval(filter_var($data->themeId, FILTER_SANITIZE_NUMBER_INT)),
            htmlspecialchars($data->name)
        );

        echo json_encode($this->ss->editSubtheme($nSubtheme, $idAdmin));
    }

    public function deleteSubtheme() {
        $idAdmin = intval(filter_var(file_get_contents('idAdmin'), FILTER_SANITIZE_NUMBER_INT));
        $idSubtheme = intval(filter_var(file_get_contents('idSubtheme'), FILTER_SANITIZE_NUMBER_INT));

        echo json_encode($this->ss->deleteSubtheme($idSubtheme, $idAdmin));
    }
}