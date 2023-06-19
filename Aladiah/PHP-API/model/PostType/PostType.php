<?php
declare(strict_types=1);

class PostType implements JsonSerializable {
    private int $postTypeId;
    private string $postType;

    function __construct(int $nPostTypeId, string $nPostType) {
        $this->postTypeId=$nPostTypeId;
        $this->postType=$nPostType;
    }


    /**
     * Get the value of postTypeId
     */
    public function getPostTypeId(): int
    {
        return $this->postTypeId;
    }

    /**
     * Set the value of postTypeId
     */
    public function setPostTypeId(int $postTypeId): self
    {
        $this->postTypeId = $postTypeId;

        return $this;
    }

    /**
     * Get the value of postType
     */
    public function getPostType(): string
    {
        return $this->postType;
    }

    /**
     * Set the value of postType
     */
    public function setPostType(string $postType): self
    {
        $this->postType = $postType;

        return $this;
    }
	/**
	 * Specify data which should be serialized to JSON
	 * Serializes the object to a value that can be serialized natively by json_encode().
	 * @return mixed Returns data which can be serialized by json_encode(), which is a value of any type other than a resource .
	 */
	public function jsonSerialize() {
        return [
            "id" => $this->getPostTypeId(),
            "postType" => $this->getPostType()
        ];
	}
}
