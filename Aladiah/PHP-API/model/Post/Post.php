<?php
declare(strict_types=1);

class Post implements JsonSerializable {
    private int $postId;
    private string $postType;
    private int $creatorId;
    private int $subthemeId1;
    private int $subthemeId2;
    private int $subthemeId3;
    private string $postName;
    private string $postDescription;
    private bool $originalCode;
    private string $link;
    private string $linkDemo;
    private bool $verifiedLink;

    function __construct(
        int $nPostId, string $nPostType, int $nCreatorId, 
        int $nSubthemeId1, int $nSubthemeId2, int $nSubthemeId3, string $nPostName, 
        string $nPostDescription, bool $nOriginalCode, string $nLink, 
        string $nLinkDemo, bool $nVerifiedLink) 
    {
        $this->postId=$nPostId;
        $this->postType=$nPostType;
        $this->creatorId=$nCreatorId;
        $this->subthemeId1=$nSubthemeId1;
        $this->subthemeId2=$nSubthemeId2;
        $this->subthemeId3=$nSubthemeId3;
        $this->postName=$nPostName;
        $this->postDescription=$nPostDescription;
        $this->originalCode=$nOriginalCode;
        $this->link=$nLink;
        $this->linkDemo=$nLinkDemo;
        $this->verifiedLink=$nVerifiedLink;
    }

    /**
     * Get the value of postId
     */
    public function getPostId(): int
    {
        return $this->postId;
    }

    /**
     * Set the value of postId
     */
    public function setPostId(int $postId): self
    {
        $this->postId = $postId;

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
     * Get the value of creatorId
     */
    public function getCreatorId(): int
    {
        return $this->creatorId;
    }

    /**
     * Set the value of creatorId
     */
    public function setCreatorId(int $creatorId): self
    {
        $this->creatorId = $creatorId;

        return $this;
    }

    /**
     * Get the value of subthemeId1
     */
    public function getSubthemeId1(): int
    {
        return $this->subthemeId1;
    }

    /**
     * Set the value of subthemeId1
     */
    public function setSubthemeId1(int $subthemeId1): self
    {
        $this->subthemeId1 = $subthemeId1;

        return $this;
    }

    /**
     * Get the value of subthemeId2
     */
    public function getSubthemeId2(): int
    {
        return $this->subthemeId2;
    }

    /**
     * Set the value of subthemeId2
     */
    public function setSubthemeId2(int $subthemeId2): self
    {
        $this->subthemeId2 = $subthemeId2;

        return $this;
    }

    /**
     * Get the value of subthemeId3
     */
    public function getSubthemeId3(): int
    {
        return $this->subthemeId3;
    }

    /**
     * Set the value of subthemeId3
     */
    public function setSubthemeId3(int $subthemeId3): self
    {
        $this->subthemeId3 = $subthemeId3;

        return $this;
    }

    /**
     * Get the value of postName
     */
    public function getPostName(): string
    {
        return $this->postName;
    }

    /**
     * Set the value of postName
     */
    public function setPostName(string $postName): self
    {
        $this->postName = $postName;

        return $this;
    }

    /**
     * Get the value of postDescription
     */
    public function getPostDescription(): string
    {
        return $this->postDescription;
    }

    /**
     * Set the value of postDescription
     */
    public function setPostDescription(string $postDescription): self
    {
        $this->postDescription = $postDescription;

        return $this;
    }

    /**
     * Get the value of originalCode
     */
    public function isOriginalCode(): bool
    {
        return $this->originalCode;
    }

    /**
     * Set the value of originalCode
     */
    public function setOriginalCode(bool $originalCode): self
    {
        $this->originalCode = $originalCode;

        return $this;
    }

    /**
     * Get the value of link
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * Set the value of link
     */
    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get the value of link
     */
    public function getLinkDemo(): string
    {
        return $this->linkDemo;
    }

    /**
     * Set the value of link
     */
    public function setLinkDemo(string $linkDemo): self
    {
        $this->link = $linkDemo;

        return $this;
    }

    /**
     * Get the value of verifiedLink
     */
    public function isVerifiedLink(): bool
    {
        return $this->verifiedLink;
    }

    /**
     * Set the value of verifiedLink
     */
    public function setVerifiedLink(bool $verifiedLink): self
    {
        $this->verifiedLink = $verifiedLink;

        return $this;
    }
	/**
	 * Specify data which should be serialized to JSON
	 * Serializes the object to a value that can be serialized natively by json_encode().
	 * @return mixed Returns data which can be serialized by json_encode(), which is a value of any type other than a resource .
	 */
	public function jsonSerialize() {
        return [
            'id' => $this->getPostId(),
            'type' => $this->getPostType(),
            'creatorId' => $this->getCreatorId(),
            'subtheme1' => $this->getSubthemeId1(),
            'subtheme2' => $this->getSubthemeId2(),
            'subtheme3' => $this->getSubthemeId3(),
            'name' => $this->getPostName(),
            'description' => $this->getPostDescription(),
            'originalCode' => $this->isOriginalCode(),
            'link' => $this->getLink(),
            'linkDemo' => $this->getLinkDemo(),
            'verifiedLink' => $this->isVerifiedLink()
        ];
	}
}