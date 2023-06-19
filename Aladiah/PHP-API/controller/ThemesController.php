<?php
declare(strict_types=1);
require_once('./model/Theme/ThemesSQL.php');
require_once('./model/Theme/Theme.php');

class ThemesController {
    private $ts;
    public function __construct() {
        $this->ts = new ThemesSQL(ConnectionDB::connect());
    }

    public function getThemes() {
        echo json_encode($this->ts->getThemes());
    }

    public function newTheme() {
        $idAdmin = intval(filter_var(file_get_contents('idAdmin'), FILTER_SANITIZE_NUMBER_INT));
        $data = json_decode(file_get_contents('php://input'));
        $nTheme = new Theme(
            intval(filter_var($data->id, FILTER_SANITIZE_NUMBER_INT)),
            htmlspecialchars($data->name)
        );

        echo json_encode($this->ts->createTheme($nTheme, $idAdmin));
    }

    public function editTheme() {
        $idAdmin = intval(filter_var(file_get_contents('idAdmin'), FILTER_SANITIZE_NUMBER_INT));
        $data = json_decode(file_get_contents('php://input'));
        $nTheme = new Theme(
            intval(filter_var($data->id, FILTER_SANITIZE_NUMBER_INT)),
            htmlspecialchars($data->name)
        );

        echo json_encode($this->ts->editTheme($nTheme, $idAdmin));
    }

    public function deleteTheme() {
        $idAdmin = intval(file_get_contents('idAdmin'));
        $idSubtheme = intval(file_get_contents('idTheme'));

        echo json_encode($this->ts->deleteTheme($idSubtheme, $idAdmin));
    }
}