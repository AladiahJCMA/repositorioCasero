<?php
declare(strict_types=1);

interface ThemesDAO {
    public function createTheme(Theme $nTheme, int $adminId): bool;
    public function deleteTheme(int $dThemeId, int $adminId): bool;
    public function getTheme(int $themeId): Theme;
    /**
     * @inheritDoc
     * @return Theme[]
     */
    public function getThemes(): array;
}