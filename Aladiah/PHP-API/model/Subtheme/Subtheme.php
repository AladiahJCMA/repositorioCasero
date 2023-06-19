<?php
declare(strict_types=1);

class Subtheme implements JsonSerializable {
    private int $subthemeId;
    private int $mainthemeId;
    private string $subthemeName;

    function __construct(int $nSubthemeId, int $nMainthemeId, string $nSubhtemeName) {
        $this->subthemeId=$nSubthemeId;
        $this->mainthemeId=$nMainthemeId;
        $this->subthemeName=$nSubhtemeName;
    }

    /**
     * Get the value of subthemeId
     */
    public function getSubthemeId(): int
    {
        return $this->subthemeId;
    }

    /**
     * Set the value of subthemeId
     */
    public function setSubthemeId(int $subthemeId): self
    {
        $this->subthemeId = $subthemeId;

        return $this;
    }

    /**
     * Get the value of mainthemeId
     */
    public function getMainthemeId(): int
    {
        return $this->mainthemeId;
    }

    /**
     * Set the value of mainthemeId
     */
    public function setMainthemeId(int $mainthemeId): self
    {
        $this->mainthemeId = $mainthemeId;

        return $this;
    }

    /**
     * Get the value of subthemeName
     */
    public function getSubthemeName(): string
    {
        return $this->subthemeName;
    }

    /**
     * Set the value of subthemeName
     */
    public function setSubthemeName(string $subthemeName): self
    {
        $this->subthemeName = $subthemeName;

        return $this;
    }
	/**
	 * Specify data which should be serialized to JSON
	 * Serializes the object to a value that can be serialized natively by json_encode().
	 * @return mixed Returns data which can be serialized by json_encode(), which is a value of any type other than a resource .
	 */
	public function jsonSerialize() {
        return [
            "id" => $this->getSubthemeId(),
            "name" => $this->getSubthemeName(),
            "themeId" => $this->getMainthemeId()
        ];
	}
}