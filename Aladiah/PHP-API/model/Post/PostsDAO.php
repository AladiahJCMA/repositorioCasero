<?php
declare(strict_types=1);

interface PostsDAO {
    public function createPost(Post $nPost): bool;
    public function getPost(int $postId): Post;
    /**
     * @inheritDoc
     * @return Post[]
     */
    public function getPostsBySubtheme(int $subtheme): array;
    public function deletePost(int $dPostId, int $userId): bool;
    public function deletePostAdmin(int $dPostId, int $adminId): bool;
    public function editPost(Post $ePost, int $userId): bool;
    public function editPostAdmin(Post $ePost, int $adminId): bool;
    public function verifyLink(int $vPostId, bool $vLinkVerified, int $adminId): bool;
    public function countScore(int $postId): int;
    public function votePost(int $userId, int $postId, bool $vote): bool;

}