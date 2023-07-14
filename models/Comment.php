<?php


/**
 *
 */
class Comment
{


    /**
     * The ID of the comment.
     *
     * @var integer
     */
    private $id;


    /**
     * The post related ID of the comment.
     *
     * @var integer
     */
    private $postId;


    /**
     * The userID of the comment.
     *
     * @var integer
     */
    private $userId;

    
    /**
     * The content of the comment.
     *
     * @var string
     */
    private $comment;


    /**
     * The statut of the comment.
     *
     * @var integer
     */
    private $validated;


    /**
     * The date of creation of the comment.
     *
     * @var integer
     */
    private $createdAt;


    /**
     * The update date of the comment.
     *
     * @var integer
     */
    private $updatedAt;

    
    /**
     * Class constructor.
     *
     * @param array $data The data used for object initialization.
     */
    public function __construct(array $data)
    {
        $this->hydrate($data);

    }//end __construct()


    /**
     * Hydrates the object with the provided data.
     *
     * @param array $data The data to be used for object initialization.
     */
    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }

    }//end hydrate()

    
    // setters

    /**
     * Set the ID of the comment.
     *
     * @param integer $id The ID of the comment.
     */
    public function setId($id)
    {
        $id = (int) $id;
        if ($id > 0) {
            $this->id = $id;
        }

    }//end setId()


    /**
     * Set the Post related ID of the comment.
     *
     * @param integer $postId The Post related ID of the comment.
     */
    public function setPostId($postId)
    {
        $postId = (int) $postId;
        if ($postId > 0) {
            $this->postId = $postId;
        }

    }//end setPostId()


    /**
     * Set the user ID of the comment.
     *
     * @param integer $userId The user ID of the comment.
     */
    public function setUserId($userId)
    {
        if (is_string($userId)) {
            $this->userId = $userId;
        }

    }//end setUserId()


    /**
     * Set the content of the comment.
     *
     * @param string $comment The content of the comment.
     */
    public function setComment($comment)
    {
        if (is_string($comment)) {
            $this->comment = $comment;
        }

    }//end setComment()


    /**
     * Set the validation status of the comment.
     *
     * @param integer $validated The validation status of the comment.
     */
    public function setValidated($validated)
    {
        if (is_string($validated)) {
            $this->validated = $validated;
        }

    }//end setValidated()


    /**
     * Set the date of creation of the comment.
     *
     * @param integer $createdAt The validation status of the comment.
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

    }//end setCreatedAt


    /**
     * Set the update date of the comment.
     *
     * @param integer $updatedAt The update date of the comment.
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

    }//end setUpdatedAt


    // getters

    /**
     * Get the ID of the comment.
     *
     * @return integer The ID of the comment.
     */
    public function getId()
    {
        return $this->id;

    }//end getId()


    /**
     * Get the Post related ID of the comment.
     *
     * @return integer The Post related ID of the comment.
     */
    public function getPostId()
    {
        return $this->postId;

    }//end getPostId()


    /**
     * Get the user ID of the comment.
     *
     * @return integer The user ID of the comment.
     */
    public function getUserId()
    {
        return $this->userId;

    }//end getUserId()


    /**
     * Get the content of the comment.
     *
     * @return string The content of the comment.
     */
    public function getComment()
    {
        return $this->comment;
    
    }//end getComment()



    /**
     * Get the validation status of the comment.
     *
     * @return integer The validation status of the comment.
     */
    public function getValidated()
    {
        return $this->validated;

    }//end getValidated()


    /**
     * Get the date of creation of the comment.
     *
     * @return integer The date of creation of the comment.
     */
    public function getCreatedAt()
    {
        return $this->createdAt;

    }//end getCreatedAt()


    /**
     * Get the update date of the comment.
     *
     * @return integer The update date of the comment.
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    
    }//end getUpdateAt()


}
