<?php
declare(strict_types=1);
require_once('PostTypesDAO.php');

class PostTypesSQL implements PostTypeDAO {
    private $conn;

    /**
     * 
     */
    public function __construct($nConn) {
        $this->conn = $nConn;
    }

	/**
	 * @param PostType $nPostType
	 * @return bool
	 */
	public function createPostType(string $nPostType, int $adminId): bool {
        $sqlQuery1 = "SELECT 1 FROM users WHERE `id-user` = ? 
        AND (`role` = 'admin' OR `role` = 'root');";

        if (!$statement1 = $this->conn->prepare($sqlQuery1)) {
            die("Error when preparing the statement: " . $this->conn->error);
        }

        $statement1->bind_param('i', $adminId);
        $statement1->execute();
        $result1 = $statement1->get_result()->fetch_all();
        $flag = $result1[0]>0;

        if ($flag) {
            $sqlQuery2 = "INSERT INTO `post-types` (`type`) VALUES (?);";

            if (!$statement2 = $this->conn->prepare($sqlQuery2)) {
                die("Error when preparing the statement: " . $this->conn->error);
            }

            $statement2->bind_param('s', $nPostType);
            $flag = $statement2->execute();
        }

        return $flag;
	}
	
	/**
	 *
	 * @param int $dPostTypeId
	 * @param int $adminId
	 * @return bool
	 */
	public function deletePostType(int $dPostTypeId, int $adminId): bool {
        $sqlQuery = "DELETE FROM `post-types` 
            WHERE `id-post-type` = ? 
            AND EXISTS (SELECT 1 FROM users WHERE `id-user` = ? 
            AND (`role` = 'admin' OR `role` = 'root'));";

        if (!$statement = $this->conn->prepare($sqlQuery)) {
            die("Error when preparing the statement: " . $this->conn->error);
        }

        $statement->bind_param('ii', $dPostTypeId, $adminId);
        return $statement->execute();
	}
	
	/**
	 * @return array<PostType>
	 */
	public function obtainPostTypes(): array {
        $sqlQuery = "SELECT `type` FROM `post-types`;";

        if (!$statement = $this->conn->prepare($sqlQuery)) {
            die("Error when preparing the statement: " . $this->conn->error);
        }

        $statement->execute();
        $result = $statement->get_result();
        $postTypes = [];
        
        while ($row = $result->fetch_assoc()) {
            $postTypes[] = $row['type'];
        }

        return $postTypes;
	}
}