<?php
declare(strict_types=1);
require_once('UsersDAO.php');

class UsersSQL implements UsersDAO {
    private $conn;

	public function __construct($nConn) {
		$this->conn=$nConn;
	}
    
	/**
	 * @param User $nUser
	 * @return bool
	 */
	public function registerUser(User $nUser): bool {
        $sqlQuery = "INSERT INTO `users` 
			(`username`, `email`, `password`, `role`) 
			VALUES (?, ?, ?, ?)";

        if (!$statement = $this->conn->prepare($sqlQuery)) {
            die("Error when preparing the statement: " . $this->conn->error);
        }
        
        $nUsername = $nUser->getUsername();
        $nEmail = $nUser->getEmail();
        $nPassword = password_hash($nUser->getPassword(), PASSWORD_DEFAULT);
		$nRole = 'user';
        unset($nUser);

        $statement->bind_param('ssss', $nUsername, $nEmail, $nPassword, $nRole);

        return $statement->execute();
	}

	public function getUsers(): array {
		$sqlQuery = "SELECT * FROM users";

		if (!$statement = $this->conn->prepare($sqlQuery)) {
			die("Error when preparing the statement: " . $this->conn->error);
		}

		$reply = array();
		if ($statement->execute()) {
			$result = $statement->get_result()->fetch_all();
			for($i = 0; $i<count($result); $i++) {
				array_push($reply, new User(
					intval($result[$i][0]),
					$result[$i][1],
					$result[$i][2],
					$result[$i][3],
					$result[$i][4],
					($result[$i][5]===null)? new DateTime('0000:00:00 00:00:00') : new DateTime($result[$i][5]),
					boolval($result[$i][6]),
					new DateTime($result[$i][7]),
					boolval($result[$i][8])
				));
			}
		}
		return $reply;
	}
	
	/**
	 * @param mixed $data integer for id, string without @ for username, string with @ for email
	 * @return User|null
	 */
	public function getUser($data): User | null {
		$sqlQuery = "";
		if (intval($data) !== 0) {
			$sqlQuery = "SELECT * FROM `users` WHERE `id-user` = ?;";
			if (!$statement = $this->conn->prepare($sqlQuery)) 
				{ die("Error when preparing the statement: " . $this->conn->error); }
			$statement->bind_param('i', $data);

		} else if (strpos($data, "@") !== false) {
			$sqlQuery = "SELECT * FROM `users` WHERE `email` = ?;";
			if (!$statement = $this->conn->prepare($sqlQuery)) 
				{ die("Error when preparing the statement: " . $this->conn->error); }
			$statement->bind_param('s', $data);

		} else {
			$sqlQuery = "SELECT * FROM `users` WHERE `username` = ?;";
			if (!$statement = $this->conn->prepare($sqlQuery)) 
				{ die("Error when preparing the statement: " . $this->conn->error);}
			$statement->bind_param('s', $data);

		}

		if ($statement->execute()) {
			$result = $statement->get_result()->fetch_all();
			$reply = new User(
				intval($result[0][0]),
				$result[0][1],
				$result[0][2],
				$result[0][3],
				$result[0][4],
				($result[0][5]===null)? new DateTime('0000:00:00 00:00:00') : new DateTime($result[0][5]),
				boolval($result[0][6]),
				($result[0][7]===null)? new DateTime('0000:00:00 00:00:00') : new DateTime($result[0][7]),
				boolval($result[0][8])
			);
		}
		return $reply;
	}

	/**
	 * 
	 * @param int $cId
	 * @param string $cookie
	 * @return bool
	 */
	public function verifyCookie(int $cId, string $cookie): bool {
		$sqlQuery = "SELECT 1 FROM `users` WHERE `id-user` = ? AND `cookie-md5` = ?;";

		if (!$statement = $this->conn->prepare($sqlQuery)) {
			die("Error when preparing the statement: " . $this->conn->error);
		}

		$statement->bind_param('is', $cId, $cookie);

		$exists = false;
		if ($statement->execute()) {
			$query = $statement->get_result()->fetch_all();
			$exists = !empty($query);
		}
		return $exists;
	}
	
	/**
	 *
	 * @param int $userId
	 * @return bool
	 */
	public function verifyUser(int $userId, bool $nVerify): bool {
		$sqlQuery = "UPDATE users SET `verified` = ? WHERE `id-user` = ?;";

		if (!$statement = $this->conn->prepare($sqlQuery)) {
			die("Error when preparing the statement: " . $this->conn->error);
		}

		$boolVerify = intval($nVerify);

		$statement->bind_param('ii', $boolVerify, $userId);

		return $statement->execute();
	}
	
	/**
	 * @param string $nUsername
	 * @return bool
	 */
	public function usernameExists(string $nUsername): bool {
		$sqlQuery = "SELECT 1 FROM `users` WHERE `username` = ?;";

		if (!$statement = $this->conn->prepare($sqlQuery)) {
			die("Error when preparing the statement: " . $this->conn->error);
		}

		$statement->bind_param('s', $nUsername);

		$exists = false;
		if ($statement->execute()) {
			$query = $statement->get_result()->fetch_all();
			$exists = !empty($query);
		}
		return $exists;
	}
	
	/**
	 *
	 * @param string $nEmail
	 * @return bool
	 */
	public function emailExists(string $nEmail): bool {
		$sqlQuery = "SELECT 1 FROM `users` WHERE `email` = ?;";

		if (!$statement = $this->conn->prepare($sqlQuery)) {
			die("Error when preparing the statement: " . $this->conn->error);
		}

		$statement->bind_param('s', $nEmail);

		$exists = false;
		if ($statement->execute()) {
			$query = $statement->get_result()->fetch_all();
			$exists = !empty($query);
		}

		return $exists;
	}

	public function setCookie(int $lId, string $cookie) {
		$sqlQuery = "UPDATE `users` SET `cookie-md5` = ? WHERE `id-user` = ?;";

		if (!$statement = $this->conn->prepare($sqlQuery)) {
			die("Error when preparing the statement: " . $this->conn->error);
		}

		$statement->bind_param('si', $cookie, $lId);

		return $statement->execute();
	}

	public function deleteUser(int $userId, int $dUserId) {
		$sqlQuery = "DELETE FROM `users` WHERE `id-user` =? AND `id-user` = ?;";

		if (!$statement = $this->conn->prepare($sqlQuery)) {
			die("Error when preparing the statement: " . $this->conn->error);
		}

		$statement->bind_param('is', $userId, $dUserId);

		return $statement->execute();
	}

	public function deleteUserAdmin(int $dUserId, int $adminId) {
		$sqlQuery = "DELETE FROM `users` WHERE `id-user` =? AND
			AND EXISTS (SELECT 1 FROM users WHERE `id-user` = ? 
			AND (`role` = 'admin' OR `role` = 'root'));";

		if (!$statement = $this->conn->prepare($sqlQuery)) {
			die("Error when preparing the statement: " . $this->conn->error);
		}

		$statement->bind_param('ii', $dUserId, $adminId);

		return $statement->execute();
	}

	public function editUser(User $eUser, int $eUserId) {
		$sqlQuery = "UPDATE `users` SET
		    `username` = ?,
            `email` = ?,
            `password` = ?
			WHERE `id-user` = ?;";

        if (!$statement = $this->conn->prepare($sqlQuery)) {
            die("Error when preparing the statement: " . $this->conn->error);
        }
        
		$idUser = $eUser->getUserId();
        $nUsername = $eUser->getUsername();
        $nEmail = $eUser->getEmail();
        $nPassword = password_hash($eUser->getPassword(), PASSWORD_DEFAULT);
        unset($eUser);

        $statement->bind_param('sssi', $nUsername, $nEmail, $nPassword, $idUser);

        return $statement->execute();
	}
}