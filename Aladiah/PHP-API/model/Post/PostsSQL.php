<?php
declare(strict_types=1);
require_once('PostsDAO.php');

class PostsSQL implements PostsDAO {
    private $conn;

    /**
     * 
     */
    public function __construct($nConn) {
        $this->conn = $nConn;
    }

	/**
	 * @param Post $nPost
	 * @param int $userId
	 * @return bool
	 */
	public function createPost(Post $nPost): bool {
        $sqlQuery = "INSERT INTO `posts` 
			(`type`, `id-creator`, `id-subtheme-1`, `id-subtheme-2`, `id-subtheme-3`, 
			`post-name`, `post-description`, `original-code`, `link`, `link-demo`) 
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if (!$statement = $this->conn->prepare($sqlQuery)) {
            die("Error when preparing the statement: " . $this->conn->error);
        }
        // isset for idSubthemes?
		$nType=$nPost->getPostType();
		$nIdCreator=$nPost->getCreatorId();
		$nIdSubtheme1=$nPost->getSubthemeId1();
		$nIdSubtheme2=($nPost->getSubthemeId2()!=null)?$nPost->getSubthemeId2():"";
		$nIdSubtheme3=($nPost->getSubthemeId3()!=null)?$nPost->getSubthemeId3():"";
		$nPostName=$nPost->getPostName();
		$nPostDescription=$nPost->getPostDescription();
		$nOriginalCode=$nPost->isOriginalCode();
		$nLink=$nPost->getLink();
		$nLinkDemo = $nPost->getLinkDemo();

        $statement->bind_param('siiiississ', 
			$nType, $nIdCreator, $nIdSubtheme1, $nIdSubtheme2, $nIdSubtheme3, $nPostName, 
			$nPostDescription, $nOriginalCode, $nLink, $nLinkDemo);

        return $statement->execute();
	}
	
	/**
	 *
	 * @param int $postId
	 * @return Post
	 */
	public function getPost(int $postId): Post {
		$sqlQuery = "SELECT `id-post`, `type`, `id-creator`, `id-subtheme-1`, 
			`id-subtheme-2`, `id-subtheme-3`, `post-name`, `post-description`, 
			`original-code`, `link`, `link-demo`, `link-verified`
			FROM `posts` WHERE `id-post` = ?";

		if (!$statement = $this->conn->prepare($sqlQuery)) {
			die("Error when preparing the statement: " . $this->conn->error);
		}

		$statement->bind_param('i', $postId);
		$statement->execute();

		if($statement->execute()) {
			$result = $statement->get_result()->fetch_all();
			$reply = new Post(
				intval($result[0][0]),
				$result[0][1],
				intval($result[0][2]),
				intval($result[0][3]),
				intval($result[0][4]),
				intval($result[0][5]),
				$result[0][6],
				$result[0][7],
				boolval($result[0][8]),
				$result[0][9],
				$result[0][10],
				boolval($result[0][10])
			);
		}
		return $reply;
	}
	
	/**
	 *
	 * @param int $subtheme
	 * @return array<Post>
	 */
	public function getPostsBySubtheme(int $subtheme): array {
		/*$sqlQuery = "SELECT `id-post`, `type`, `id-creator`, `id-subtheme-1`, 
			`id-subtheme-2`, `id-subtheme-3`, `post-name`, `post-description`, 
			`original-code`, `link`, `link-demo`, `link-verified` 
			FROM `posts` WHERE `id-subtheme-1` = ? OR `id-subtheme-2` = ? OR `id-subtheme-3` = ?";*/

		$sqlQuery = 
			"SELECT 
				p.*,
					(SELECT COUNT(*) FROM `post-score` WHERE `score` = 1 AND `id-post` = p.`id-post`) -
		  			(SELECT COUNT(*) FROM `post-score` WHERE `score` = 0 AND `id-post` = p.`id-post`) AS 
				`score`,
				st1.`subtheme-name` AS subtheme_1_name,
				st2.`subtheme-name` AS subtheme_2_name,
				st3.`subtheme-name` AS subtheme_3_name
	  		FROM
				posts p
				LEFT JOIN `post-score` ps ON p.`id-post` = ps.`id-post`
				LEFT JOIN subthemes st1 ON p.`id-subtheme-1` = st1.`id-subtheme`
				LEFT JOIN subthemes st2 ON p.`id-subtheme-2` = st2.`id-subtheme`
				LEFT JOIN subthemes st3 ON p.`id-subtheme-3` = st3.`id-subtheme`
	  		WHERE
				p.`id-subtheme-1` = ? OR p.`id-subtheme-2` = ? OR p.`id-subtheme-3` = ?;";

		if (!$statement = $this->conn->prepare($sqlQuery)) {
			die("Error when preparing the statement: " . $this->conn->error);
		}

		$statement->bind_param('iii', $subtheme, $subtheme, $subtheme);
		$statement->execute();

		$reply = array();
		if($statement->execute()) {
			$result = $statement->get_result()->fetch_all();
			for($i = 0; $i<count($result); $i++) {
				array_push($reply, array(
					"id" => intval($result[$i][0]),
					"type" => $result[$i][1],
                    "creatorId" => intval($result[$i][2]),
                    "subtheme1" => intval($result[$i][3]),
					"subtheme1name" => $result[$i][13],
                    "subtheme2" => intval($result[$i][4]),
					"subtheme2name" => $result[$i][14],
                    "subtheme3" => intval($result[$i][5]),
                    "subtheme3name" => $result[$i][15],
					"name" => $result[$i][6],
					"description" => $result[$i][7],
                    "originalCode" => boolval($result[$i][8]),
                    "link" => $result[$i][9],
                    "linkDemo" => $result[$i][10],
                    "linkVerified" => boolval($result[$i][11]),
					"score" => intval($result[$i][12])
				));
			}
		}
		return $reply;
	}
	
	/**
	 *
	 * @param int $dPostId
	 * @param int $userId
	 * @return bool
	 */
	public function deletePost(int $dPostId, int $userId): bool {
		$sqlQuery = "DELETE FROM `posts` WHERE `id-post` = ? AND `id-creator` = ?";

        if (!$statement = $this->conn->prepare($sqlQuery)) {
            die("Error when preparing the statement: " . $this->conn->error);
        }

        $statement->bind_param('ii', $dPostId, $userId);

        return $statement->execute();
	}
	
	/**
	 *
	 * @param int $dPostId
	 * @param int $adminId
	 * @return bool
	 */
	public function deletePostAdmin(int $dPostId, int $adminId): bool {
		$sqlQuery = "DELETE FROM `posts` WHERE `id-post` = ? 
			AND EXISTS (SELECT 1 FROM `users` WHERE `id-user` = ? AND 
			(`role` = 'admin' OR `role` = 'root'));";

        if (!$statement = $this->conn->prepare($sqlQuery)) {
            die("Error when preparing the statement: " . $this->conn->error);
        }

        $statement->bind_param('ii', $dPostId, $adminId);
		return $statement->execute();
	}
	
	/**
	 *
	 * @param Post $ePost
	 * @param int $userId
	 * @return bool
	 */
	public function editPost(Post $ePost, int $userId): bool {
		$sqlQuery = "UPDATE `posts` SET 
			`type` = ?, 
			`id-subtheme-1` = ?,
			`id-subtheme-2` = ?,
			`id-subtheme-3` = ?,
			`post-name` = ?,
			`post-description` = ?,
			`link` = ?,
			`link-demo` = ?
			WHERE `id-post` = ? AND `id-creator` = ?";

		if (!$statement = $this->conn->prepare($sqlQuery)) {
			die("Error when preparing the statement: " . $this->conn->error);
		}

		$eType = $ePost->getPostType();
		$eIdSubtheme1 = $ePost->getSubthemeId1();
		$eIdSubtheme2 = $ePost->getSubthemeId2();
		$eIdSubtheme3 = $ePost->getSubthemeId3();
		$ePostName = $ePost->getPostName();
		$ePostDesc = $ePost->getPostDescription();
		$eLink = $ePost->getLink();
		$eLinkDemo = $ePost->getLinkDemo();
		$ePostId = $ePost->getPostId();

		$statement->bind_param('siiissssii', 
			$eType, $eIdSubtheme1, $eIdSubtheme2, $eIdSubtheme3, 
			$ePostName,	$ePostDesc, $eLink, $eLinkDemo, $ePostId, $userId);

		return $statement->execute();
	}
	
	/**
	 *
	 * @param Post $ePost
	 * @param int $adminId
	 * @return bool
	 */
	public function editPostAdmin(Post $ePost, int $adminId): bool {
		$sqlQuery = "UPDATE `posts` SET 
			`type` = ?, 
			`id-subtheme-1` = ?,
			`id-subtheme-2` = ?,
			`id-subtheme-3` = ?,
			`post-name` = ?,
			`post-description` = ?,
			`original-code` = ?,
			`link` = ?,
			`link-demo` = ?,
			`link-verified` = ?
			WHERE `id-post` = ? 
			AND EXISTS (SELECT 1 FROM users WHERE `id-user` = ? AND 
			(`role` = 'admin' OR `role` = 'root'));";

		if (!$statement = $this->conn->prepare($sqlQuery)) {
			die("Error when preparing the statement: " . $this->conn->error);
		}

		$eType = $ePost->getPostType();
		$eIdSubtheme1 = $ePost->getSubthemeId1();
		$eIdSubtheme2 = $ePost->getSubthemeId2();
		$eIdSubtheme3 = $ePost->getSubthemeId3();
		$ePostName = $ePost->getPostName();
		$ePostDesc = $ePost->getPostDescription();
		$eOC = $ePost->isOriginalCode();
		$eLink = $ePost->getLink();
		$eLinkDemo = $ePost->getLinkDemo();
		$eLinkVerified = $ePost->isVerifiedLink();
		$ePostId = $ePost->getPostId();

		$statement->bind_param('siiississiii', 
			$eType, $eIdSubtheme1, $eIdSubtheme2, $eIdSubtheme3, $ePostName, 
			$ePostDesc, $eOC, $eLink, $eLinkDemo, $eLinkVerified, $ePostId, $adminId);

		return $statement->execute();
	}
	
	/**
	 *
	 * @param int $vPostId
	 * @param int $adminId
	 * @return bool
	 */
	public function verifyLink(int $vPostId, bool $vLinkVerified, int $adminId): bool {
		$sqlQuery = "UPDATE `posts` SET 
			`link-verified` = ?
			WHERE `id-post` = ? 
			AND EXISTS (SELECT 1 FROM users WHERE `id-user` = ? AND 
			(`role` = 'admin' OR `role` = 'root'));";

		if (!$statement = $this->conn->prepare($sqlQuery)) {
			die("Error when preparing the statement: " . $this->conn->error);
		}

		$statement->bind_param('iii', $vLinkVerified, $vPostId, $adminId);

		return $statement->execute();
	}
	
	/**
	 *
	 * @param int $postId
	 * @return number
	 */
	public function countScore(int $postId): int {
		$sqlQuery = "SELECT 
			(SELECT COUNT(*) FROM `post-score` WHERE `id-post` = ? AND `score` = 1) -
			(SELECT COUNT(*) FROM `post-score` WHERE `id-post` = ? AND `score` = 0) AS `result`;";

		if (!$statement = $this->conn->prepare($sqlQuery)) {
			die("Error when preparing the statement: " . $this->conn->error);
		}

		$statement->bind_param('ii', $postId, $postId);

		$result = $statement->execute()->fetch_assoc();

		return $result['result'];
	}

	/**
	 *
	 * @param int $userId
	 * @param int $postId
	 * @param $vote
	 * @return bool
	 */
	public function votePost(int $userId, int $postId, bool | null $vote): bool {
		$sqlQuery = "SELECT 1 from `post-score` WHERE `id-user` =? AND `id-post` =?;";

		if (!$statement = $this->conn->prepare($sqlQuery)) {
			die("Error when preparing the statement: " . $this->conn->error);
		}

		$statement->bind_param('ii', $userId, $postId);

		$exists = false;
		if ($statement->execute()) {
			$query = $statement->get_result()->fetch_all();
			$exists = !empty($query);
		}

		$nVote = ($vote !== null)? intval($vote): null;

		if($exists) {
			$sqlQuery = "UPDATE `post-score` SET `score` =? 
				WHERE `id-user` = ? AND `id-post` =?;";

			if (!$statement = $this->conn->prepare($sqlQuery)) {
				die("Error when preparing the statement: " . $this->conn->error);
			}

			$statement->bind_param('iii', $nVote, $userId, $postId);
		} else {
			$sqlQuery = "INSERT INTO `post-score` (`id-user`, `id-post`, `score`) 
                VALUES (?,?,?);";
			
			if (!$statement = $this->conn->prepare($sqlQuery)) {
				die("Error when preparing the statement: " . $this->conn->error);
			}

			$statement->bind_param('iii', $userId, $postId, $nVote);
		}

		return $statement->execute();
	}
}