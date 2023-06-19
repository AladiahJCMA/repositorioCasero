<?php
declare(strict_types=1);

interface SubthemesDAO {
    public function createSubtheme(Subtheme $nSubtheme, int $adminId): bool;
    public function deleteSubtheme(int $dSubthemeId, int $adminId): bool;
    public function getSubtheme(int $subthemeId): Subtheme;
    public function getSubthemesByTheme(int $themeId): array;
    public function getAllSubthemes(): array;
}