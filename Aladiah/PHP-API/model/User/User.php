<?php
declare(strict_types=1);

class User implements JsonSerializable {
    private int $userId;
    private string $username;
    private string $email;
    private string $password;
    private string $userRole;
    private DateTime $premiumExpire;
    private bool $isPremium;
    private DateTime $registerDate;
    private bool $verified;

    function __construct(int $nUserId, string $nUsername, string $nEmail, 
        string $nPassword, string $nUserRole, DateTime $nPremiumExpire, 
        bool $nIsPremium, DateTime $nRegisterDate, bool $nVerified) 
    {
        $this->userId=$nUserId;
        $this->username=$nUsername;
        $this->email=$nEmail;
        $this->password=$nPassword;
        $this->userRole=$nUserRole;
        $this->premiumExpire=$nPremiumExpire;
        $this->isPremium=$nIsPremium;
        $this->registerDate=$nRegisterDate;
        $this->verified=$nVerified;
    }

    /**
     * Get the value of userId
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     */
    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get the value of username
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Set the value of username
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of userRole
     */
    public function getUserRole(): string
    {
        return $this->userRole;
    }

    /**
     * Set the value of userRole
     */
    public function setUserRole(string $userRole): self
    {
        $this->userRole = $userRole;

        return $this;
    }

    /**
     * Get the value of premiumExpire
     */
    public function getPremiumExpire(): DateTime
    {
        return $this->premiumExpire;
    }

    /**
     * Set the value of premiumExpire
     */
    public function setPremiumExpire(DateTime $premiumExpire): self
    {
        $this->premiumExpire = $premiumExpire;

        return $this;
    }

    /**
     * Get the value of isPremium
     */
    public function getIsPremium(): bool
    {
        return $this->isPremium;
    }

    /**
     * Set the value of isPremium
     */
    public function setIsPremium(bool $isPremium): self
    {
        $this->isPremium = $isPremium;

        return $this;
    }
    
    /**
     * Get the value of registerDate
     */
    public function getRegisterDate(): DateTime
    {
        return $this->registerDate;
    }

    /**
     * Set the value of registerDate
     */
    public function setRegisterDate(DateTime $registerDate): self
    {
        $this->registerDate = $registerDate;

        return $this;
    }

    /**
     * Get the value of verified
     */
    public function isVerified(): bool
    {
        return $this->verified;
    }

    /**
     * Set the value of verified
     */
    public function setVerified(bool $verified): self
    {
        $this->verified = $verified;

        return $this;
    }
	/**
	 * Specify data which should be serialized to JSON
	 * Serializes the object to a value that can be serialized natively by json_encode().
	 * @return mixed Returns data which can be serialized by json_encode(), which is a value of any type other than a resource .
	 */
	public function jsonSerialize() {
        return [
            'id' => $this->getUserId(),
            'username' => $this->getUsername(),
            'email' => $this->getEmail(),
            'role' => $this->getUserRole(),
            'premiumExpire' => $this->getPremiumExpire(),
            'isPremium' => $this->getIsPremium(),
            'registerDate' => $this->getRegisterDate(),
            'verified' => $this->isVerified()            
        ];
    }
}