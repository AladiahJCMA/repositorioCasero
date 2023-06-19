<?php
declare(strict_types=1);

class Theme implements JsonSerializable {
    private int $themeId;
    private string $themeName;

    function __construct(int $nThemeId, string $nThemeName) {
        $this->themeId=$nThemeId;
        $this->themeName=$nThemeName;
    }

    /**
     * Get the value of themeId
     */
    public function getThemeId(): int
    {
        return $this->themeId;
    }

    /**
     * Set the value of themeId
     */
    public function setThemeId(int $themeId): self
    {
        $this->themeId = $themeId;

        return $this;
    }

    /**
     * Get the value of themeName
     */
    public function getThemeName(): string
    {
        return $this->themeName;
    }

    /**
     * Set the value of themeName
     */
    public function setThemeName(string $themeName): self
    {
        $this->themeName = $themeName;

        return $this;
    }
	/**
	 * Specify data which should be serialized to JSON
	 * Serializes the object to a value that can be serialized natively by json_encode().
	 * @return mixed Returns data which can be serialized by json_encode(), which is a value of any type other than a resource .
	 */
	public function jsonSerialize() {
        return [
            "id" => $this->getThemeId(),
            "name" => $this->getThemeName()
        ];
	}
}