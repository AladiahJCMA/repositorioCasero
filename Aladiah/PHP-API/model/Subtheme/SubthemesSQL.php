<?php
declare(strict_types=1);
require_once('SubthemesDAO.php');

class SubthemesSQL implements SubthemesDAO {
    private $conn;

    /**
     * 
     */
    public function __construct($nConn) {
        $this->conn = $nConn;
    }

	/**
	 * @param Subtheme $nSubtheme
	 * @param int $adminId
	 * @return bool
	 */
	public function createSubtheme(Subtheme $nSubtheme, int $adminId): bool {
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
            $sqlQuery2 = "INSERT INTO `subthemes` (`main-theme-id`, `subtheme-name`) 
                VALUES (?, ?);";

            if (!$statement2 = $this->conn->prepare($sqlQuery2)) {
                die("Error when preparing the statement: " . $this->conn->error);
            }

            $nMainThemeId = $nSubtheme->getMainthemeId();
            $nSubthemeName = $nSubtheme->getSubthemeName();

            $statement2->bind_param('is', $nMainThemeId, $nSubthemeName);
            $flag = $statement2->execute();
        }
        return $flag;
	}
	
	/**
	 *
	 * @param int $dSubthemeId
	 * @param int $adminId
	 * @return bool
	 */
	public function deleteSubtheme(int $dSubthemeId, int $adminId): bool {
        $sqlQuery = "DELETE FROM `subthemes` 
            WHERE `id-subtheme` = ? 
            AND EXISTS (SELECT 1 FROM users WHERE `id-user` = ? 
            AND (`role` = 'admin' OR `role` = 'root'));";

        if (!$statement = $this->conn->prepare($sqlQuery)) {
            die("Error when preparing the statement: " . $this->conn->error);
        }

        $statement->bind_param('ii', $dSubthemeId, $adminId);
        return $statement->execute();
	}
	
	/**
	 *
	 * @param int $subthemeId
	 * @return Subtheme
	 */
	public function getSubtheme(int $subthemeId): Subtheme {
        $sqlQuery = "SELECT `id-subtheme`, `main-theme-id`, `subtheme-name` FROM `subthemes`
            WHERE `id-subtheme` = ?;";

        if (!$statement = $this->conn->prepare($sqlQuery)) {
            die("Error when preparing the statement: " . $this->conn->error);
        }

        $statement->bind_param('i', $subthemeId);
        $result = $statement->execute()->fetch_assoc();

        return new Subtheme(intval($result['id-subtheme']), 
            intval($result['main-theme-id']), $result['subtheme-name']);
	}

    /**
     * 
     * @param int $themeId
     * @return array
     */
    public function getSubthemes(): array {
        $sqlQuery = "SELECT `id-subtheme`, `main-theme-id`, `subtheme-name` FROM `subthemes`;";

        if (!$statement = $this->conn->prepare($sqlQuery)) {
            die("Error when preparing the statement: " . $this->conn->error);
        }

        $reply = array();

        if($statement->execute()) {
            $result = $statement->get_result()->fetch_all();
            for($i = 0; $i<count($result); $i++) {
                array_push($reply, new Subtheme(
                    intval($result[$i][0]),
                    intval($result[$i][1]),
                    $result[$i][2]
                ));
            }
        }
            
        return $reply;
    }

    /**
     * 
     * @param int $themeId
     * @return array
     */
    public function getSubthemesByTheme(int $themeId): array {
        $sqlQuery = "SELECT `id-subtheme`, `main-theme-id`, `subtheme-name` FROM `subthemes`
        WHERE `main-theme-id` = ?;";

        if (!$statement = $this->conn->prepare($sqlQuery)) {
            die("Error when preparing the statement: " . $this->conn->error);
        }

        $statement->bind_param('i', $themeId);
        $reply = array();

        if($statement->execute()) {
            $result = $statement->get_result()->fetch_all();
            for($i = 0; $i<count($result); $i++) {
                array_push($reply, new Subtheme(
                    intval($result[$i][0]), 
                    intval($result[$i][1]), 
                    $result[$i][2]
                ));
            }
        }
            
        return $reply;
    }

	
	/**
	 * @return array<Subtheme>
	 */
	public function getAllSubthemes(): array {
        $sqlQuery = "SELECT `id-subtheme`, `main-theme-id`, `subtheme-name` FROM `subthemes`;";

        if (!$statement = $this->conn->prepare($sqlQuery)) {
            die("Error when preparing the statement: " . $this->conn->error);
        }

        $result = $statement->execute();
        $subthemesArray = [];

        while ($row = $result->fetch_assoc()) {
            array_push($subthemesArray, 
                new Subtheme(intval($row['id-subtheme']), intval($row['main-theme-id']), $row['subtheme-name']));
        }
            
        return $subthemesArray;
	}
}