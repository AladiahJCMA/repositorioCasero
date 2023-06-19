<?php
declare(strict_types=1);
require_once('ThemesDAO.php');

class ThemesSQL implements ThemesDAO {
	private $conn;

	public function __construct($nConn) {
		$this->conn=$nConn;
	}
    
	/**
	 * @param Theme $nTheme
	 * @param int $adminId
	 * @return bool
	 */
	public function createTheme(Theme $nTheme, int $adminId): bool {
		$sqlQuery1 = "SELECT 1 FROM users WHERE `id-user` = ? 
        AND (`role` = 'admin' OR `role` = 'root');;";

        if (!$statement1 = $this->conn->prepare($sqlQuery1)) {
            die("Error when preparing the statement: " . $this->conn->error);
        }

        $statement1->bind_param('i', $adminId);
        $statement1->execute();
        $result1 = $statement1->get_result()->fetch_all();
        $flag = $result1[0]>0;

        if ($flag) {
            $sqlQuery2 = "INSERT INTO `themes` (`theme-name`) 
                VALUES (?);";

            if (!$statement2 = $this->conn->prepare($sqlQuery2)) {
                die("Error when preparing the statement: " . $this->conn->error);
            }

            $nThemeName = $nTheme->getThemeName();

            $statement2->bind_param('s', $nThemeName);
            $flag = $statement2->execute();
        }
        return $flag;
	}
	
	/**
	 *
	 * @param int $dThemeId
	 * @param int $adminId
	 * @return bool
	 */
	public function deleteTheme(int $dThemeId, int $adminId): bool {
		$sqlQuery = "DELETE FROM `themes` 
		WHERE `id-theme` = ? 
		AND EXISTS (SELECT 1 FROM users WHERE `id-user` = ? 
		AND (`role` = 'admin' OR `role` = 'root'));";

	if (!$statement = $this->conn->prepare($sqlQuery)) {
		die("Error when preparing the statement: " . $this->conn->error);
	}

	$statement->bind_param('ii', $dThemeId, $adminId);
	return $statement->execute();
	}
	
	/**
	 *
	 * @param int $themeId
	 * @return Theme
	 */
	public function getTheme(int $themeId): Theme {
		$sqlQuery = "SELECT `id-theme`, `theme-name` FROM `themes`
            WHERE `id-subtheme` = ?;";

        if (!$statement = $this->conn->prepare($sqlQuery)) {
            die("Error when preparing the statement: " . $this->conn->error);
        }

        $statement->bind_param('i', $themeId);
        $result = $statement->execute()->fetch_assoc();

        return new Theme(intval($result['id-theme']), $result['theme-name']);
	}
	
	/**
	 * @return array<Theme>
	 */
	public function getThemes(): array {
		$sqlQuery = "SELECT `id-theme`, `theme-name` FROM `themes`;";

        if (!$statement = $this->conn->prepare($sqlQuery)) {
            die("Error when preparing the statement: " . $this->conn->error);
        }

        $reply = array();
		if($statement->execute()) {
			$result = $statement->get_result()->fetch_all();
			for($i = 0; $i<count($result); $i++) {
				array_push($reply, new Theme(
					intval($result[$i][0]), 
					$result[$i][1]
				));
			}
		}
	
        return $reply;
	}
}