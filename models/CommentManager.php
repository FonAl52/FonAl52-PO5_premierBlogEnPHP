<?php

/**
 *
 */
class CommentManager extends Model
{


    /**
     * Get all comments.
     *
     * @return array An array of comments.
     *
     */
    public function getAll()
    {
        return $this->getAllComment('comment', 'Comment');

    }//end getAll()


    /**
     * Get one comment.
     *
     * @param   int $postId The ID of the post.
     * @return array An array of one comment content.
     */
    public function getOne($postId)
    {
        return $this->getOneComment('comment', 'Comment', $postId);

    }//end getOne()


    /**
     * Create one comment.
     *
     * @param   int $comment The comment create by createOne().
     * @return array An array of one comment content.
     */
    public function createComment($comment)
    {

        if (!($comment instanceof Comment)) {
            // Return an error or an exception.
            return false;
        }

        return $this->createOne('comment', $comment);

    }//end createComment()


    /**
     * Get all comments from a table.
     *
     * @param   string $table The table name.
     * @param   string $obj The object name.
     * @return array An array of comments.
     *
     */
    private function getAllComment($table, $obj)
    {
        $this->getBdd();
        $var = [];
        $req = self::$bdd->prepare('SELECT * FROM '.$table.' ORDER BY id desc');
        $req->execute();
        // Create the variable data that will hold the data.
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            // var will hold the data in the form of objects.
            $var[] = new $obj($data);
        }

        $req->closeCursor();
        return $var;

    }//end getAllComment()


    /**
     * Get a single comment from a table.
     *
     * @param   string $table The table name.
     * @param   string $obj The object name.
     * @param   int $postId The ID of the post.
     * @return array|null The comment or null if not found.
     *
     */
    private function getOneComment($table, $obj, $postId)
    {
        $this->getBdd();
        $var = [];

        $req = self::$bdd->prepare("SELECT id, postId, userId, content, DATE_FORMAT(createdAt, '%d/%m/%Y à %Hh%imin%ss') AS createdAt, DATE_FORMAT(updatedAt, '%d/%m/%Y à %Hh%imin%ss') AS updatedAt FROM ".$table." WHERE postId = ?");
        $req->execute([$postId]);
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $var[] = new $obj($data);
        }

        $req->closeCursor();
        return $var;

    }//end getOneComment()


    /**
     * Get comments by post ID.
     *
     * @param   int $postId The ID of the post.
     * @return array An array of comments.
     *
     */
    public function getCommentsByPostId($postId)
    {
        $this->getBdd();
        $comments = [];

        $req = self::$bdd->prepare("SELECT * FROM comment WHERE postId = ? AND validated = 1 ORDER BY id desc");

        $req->execute([$postId]);

        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            // Conversion of dates to French format.
            $data['createdAt'] = date('d/m/Y à H:i:s', strtotime($data['createdAt']));
            $data['updatedAt'] = date('d/m/Y à H:i:s', strtotime($data['updatedAt']));

            $comments[] = new Comment($data);
        }

        $req->closeCursor();
        return $comments;

    }//end getCommentsByPostId()


    /**
     * Create a new record in the specified table.
     *
     * @param   string $table The name of the table.
     * @param   object $obj The object containing the data to be inserted.
     * @return boolean
     */
    public function createOne($table, $obj)
    {
        $this->getBdd();
        $req = self::$bdd->prepare("INSERT INTO ".$table." (postId, userId, comment, validated, createdAt, updatedAt) VALUES (?, ?, ?, 0, NOW(), NOW())");
        $req->execute(
            [
                     $obj->getPostId(),
                     $obj->getUserId(),
                     $obj->getComment(),
            ]
        );
        $req->closeCursor();

        return true;

    }//end createOne()


    /**
     * Update the validation status of a comment.
     *
     * @param   int $commentId The ID of the comment.
     * @param   array $options The options containing the data to be updated.
     * @return boolean
     */
    public function commentValidation($commentId, $options)
    {
        $this->getBdd();
        $set = [];
        $values = [];
        foreach ($options as $key => $value) {
            $set[] = "$key = ?";
            $values[] = $value;
        }

        $values[] = $commentId;

        $req = self::$bdd->prepare("UPDATE comment SET ".implode(", ", $set)." WHERE id = ?");
        $req->execute($values);

        return $req->rowCount() > 0;

    }//end commentValidation()


    /**
     * Update the validation status of a comment.
     *
     * @param   int $commentId The ID of the comment to be deleted.
     * @return bool True if the deletion was successful, false otherwise.
     */
    public function deleteComment($commentId)
    {
        $this->getBdd();
        $req = self::$bdd->prepare("DELETE FROM comment WHERE id = ?");
        $req->execute([$commentId]);
        return $req->rowCount() > 0;

    }//end deleteComment()


}
