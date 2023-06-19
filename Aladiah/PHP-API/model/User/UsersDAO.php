<?php
declare(strict_types=1);

interface UsersDAO {
    public function registerUser(User $nUser): bool;
    public function getUser($data): User | null;
    public function verifyUser(int $userId, bool $nVerify): bool;
    public function usernameExists(string $nUsername): bool;
    public function emailExists(string $nEmail): bool;
}