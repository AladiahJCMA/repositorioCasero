<?php
declare(strict_types=1);

interface PostTypeDAO {
    public function createPostType(string $nPostType, int $adminId): bool;
    public function deletePostType(int $dPostTypeId, int $adminId): bool;
    /**
     * @inheritDoc
     * @return PostType[]
     */
    public function obtainPostTypes(): array;
}