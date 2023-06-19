<?php
declare(strict_types=1);
require_once('./model/Post/PostsSQL.php');
require_once('./model/Post/Post.php');

class PostsController {
    private $ps;
    public function __construct() {
        $this->ps = new PostsSQL(ConnectionDB::connect());
    }

    public function getPost() {
        $idPost = filter_var(intval(file_get_contents('idPost')), FILTER_SANITIZE_NUMBER_INT);
        echo json_encode($this->ps->getPost($idPost));
    }

    public function getPostsBySubtheme() {
        $idSubtheme = filter_var(intval(file_get_contents('idSubtheme')), FILTER_SANITIZE_NUMBER_INT);
        echo json_encode($this->ps->getPostsBySubtheme(intval($idSubtheme)));
    }

    public function getPostsByScore() {
        echo json_encode($this->ps->getPostsByScore());
    }

    public function newPost() {
        $data = json_decode(file_get_contents('php://input'));
        echo json_encode($this->ps->createPost(
            new Post(
                filter_var(intval($data->id), FILTER_SANITIZE_NUMBER_INT),
                htmlspecialchars($data->type),
                filter_var(intval($data->creatorId), FILTER_SANITIZE_NUMBER_INT),
                filter_var(intval($data->subtheme1), FILTER_SANITIZE_NUMBER_INT),
                filter_var(intval($data->subtheme2), FILTER_SANITIZE_NUMBER_INT),
                filter_var(intval($data->subtheme3), FILTER_SANITIZE_NUMBER_INT),
                htmlspecialchars($data->name),
                htmlspecialchars($data->description),
                boolval($data->originalCode),
                htmlspecialchars($data->link),
                htmlspecialchars($data->linkDemo),
                boolval($data->verifiedLink)
            )
        ));
    }

    public function editPostUser() {
        $userId = intval(file_get_contents('idUser'));
        $data = json_decode(file_get_contents('php://input'));
        echo json_encode($this->ps->editPost(
            new Post(
                filter_var(intval($data->id), FILTER_SANITIZE_NUMBER_INT),
                htmlspecialchars($data->type),
                filter_var(intval($data->creatorId), FILTER_SANITIZE_NUMBER_INT),
                filter_var(intval($data->subtheme1), FILTER_SANITIZE_NUMBER_INT),
                filter_var(intval($data->subtheme2), FILTER_SANITIZE_NUMBER_INT),
                filter_var(intval($data->subtheme3), FILTER_SANITIZE_NUMBER_INT),
                htmlspecialchars($data->name),
                htmlspecialchars($data->description),
                boolval($data->originalCode),
                htmlspecialchars($data->link),
                htmlspecialchars($data->linkDemo),
                boolval($data->verifiedLink)
            ), $userId
        ));
    }

    public function editPostAdmin() {
        $adminId = intval(file_get_contents('idAdmin'));
        $data = json_decode(file_get_contents('php://input'));
        echo json_encode($this->ps->editPostAdmin(
            new Post(
                filter_var(intval($data->id), FILTER_SANITIZE_NUMBER_INT),
                htmlspecialchars($data->type),
                filter_var(intval($data->creatorId), FILTER_SANITIZE_NUMBER_INT),
                filter_var(intval($data->subtheme1), FILTER_SANITIZE_NUMBER_INT),
                filter_var(intval($data->subtheme2), FILTER_SANITIZE_NUMBER_INT),
                filter_var(intval($data->subtheme3), FILTER_SANITIZE_NUMBER_INT),
                htmlspecialchars($data->name),
                htmlspecialchars($data->description),
                boolval($data->originalCode),
                htmlspecialchars($data->link),
                htmlspecialchars($data->linkDemo),
                boolval($data->verifiedLink)
            ), $adminId
        ));
    }

    public function deletePost() {
        $dIdUser = intval(file('idUser'));
        $dIdPost = intval(file_get_contents('idPost'));

        echo json_encode($this->ps->deletePost($dIdPost, $dIdUser));
    }

    public function deletePostAdmin() {
        $dIdAdmin = intval(file('idAdmin'));
        $dIdPost = intval(file_get_contents('idPost'));

        echo json_encode($this->ps->deletePostAdmin($dIdPost, $dIdAdmin));
    }

    public function votePost() {
        $vIdUser = intval(file('idUser'));
        $vIdPost = intval(file_get_contents('idPost'));
        $vote = (file_get_contents('php://input'))==="true"? true : false;

        echo json_encode($this->ps->votePost($vIdUser, $vIdPost, $vote));
    }
}