<?php
declare(strict_types=1);
require_once('./model/PostType/PostTypesSQL.php');

class PostTypesController {
    private $ps;

    public function __construct() {
        $this->ps = new PostTypesSQL(ConnectionDB::connect());
    }

    public function getPostTypes() {
        echo json_encode($this->ps->obtainPostTypes());
    }

    public function newPostType() {
        $adminId = intval(filter_var(file_get_contents('idAdmin'), FILTER_SANITIZE_NUMBER_INT));
        $type = htmlspecialchars(json_decode(file_get_contents('php://input'))->type);
        echo json_encode($this->ps->createPostType($type, $adminId));
    }
}