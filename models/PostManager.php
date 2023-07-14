<?php

/**
 *
 */
class PostManager extends Model
{

    /**
     * Create a new post.
     *
     * @param array $post The data of the post to be created.
     * @return boolean True if the creation was successful, false otherwise.
     */
    public function createPost($post)
    {
        if (!($post instanceof Post)) {
            // Return an error or an exception.
            return false;
        }

        return $this->createOne('post', $post);

    }//end createPost()


    /**
     * Get all posts.
     *
     * @return array An array of Post objects representing the posts.
     */
    public function getPosts()
    {
        return $this->getAll('posts', 'Post');

    }//end getPosts()


    /**
     * Get a post by its ID.
     *
     * @param   int    $id The ID of the post.
     * @return Post|null The Post object representing the post, or null if not found.
     */
    public function getPost($id)
    {
        return $this->getOne('post', 'Post', $id);

    }//end getPost()


    /**
     * Create a new entry in the specified table with the provided object.
     *
     * @param   string    $table The name of the table.
     * @param   object    $obj The object containing the data to be inserted.
     * @return boolean True if the entry was created successfully, false otherwise.
     */
    private function createOne($table, $obj)
    {
        $this->getBdd();

        $req = self::$bdd->prepare("INSERT INTO ".$table." (categoryId, userId, title, chapo, picture, content) VALUES (?, ?, ?, ?, ?, ?)");
        $req->execute(
            [
                     $obj->getCategoryId(),
                     $obj->getUserId(),
                     $obj->getTitle(),
                     $obj->getChapo(),
                     $obj->getPicture(),
                     $obj->getContent(),
            ]
        );
        $req->closeCursor();
        return true;

    }//end createOne()


    /**
     * Get a single entry from the specified table by ID.
     *
     * @param   string    $table The name of the table.
     * @param   object    $obj The object representing the entry.
     * @param   int    $id The ID of the entry.
     * @return mixed|null The retrieved entry or null if not found.
     */
    private function getOne($table, $obj, $id)
    {
        $this->getBdd();
        $data = [];
        $req = self::$bdd->prepare("SELECT id, categoryId, userId, title, chapo, picture, content, DATE_FORMAT(createdAt, '%d/%m/%Y à %Hh%imin%ss') AS createdAt, DATE_FORMAT(updatedAt, '%d/%m/%Y à %Hh%imin%ss') AS updatedAt FROM ".$table." WHERE id = ?");
        $req->execute([$id]);
        while ($var = $req->fetch(PDO::FETCH_ASSOC)) {
            $data[] = new $obj($var);

        }
        $req->closeCursor();

        return $data;

    }//end getOne()


    /**
     * Get all entries from the specified table.
     *
     * @param   string    $table The name of the table.
     * @return array The retrieved entries.
     */
    public function getAll($table)
    {
        $this->getBdd();
        $data = [];
        $req = self::$bdd->prepare("SELECT id, categoryId, userId, title, chapo, picture, content, DATE_FORMAT(createdAt, '%d/%m/%Y à %Hh%imin%ss') AS createdAt, DATE_FORMAT(updatedAt, '%d/%m/%Y à %Hh%imin%ss') AS updatedAt FROM ".$table.' ORDER BY id DESC');
        $req->execute();

        // On récupère les données directement dans un tableau.
        while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        $req->closeCursor();

        return $data;

    }//end getAll()


    /**
     * Update a post with the specified options.
     *
     * @param   int    $postId The ID of the post to update.
     * @param   array    $options The options to update the post with.
     * @return bool True if the update was successful, false otherwise.
     */
    public function updatePost($postId, $options)
    {
        $this->getBdd();
        $set = [];
        $values = [];

        foreach ($options as $key => $value) {
            $set[] = "$key = ?";
            $values[] = $value;
        }
        $values[] = $postId;
        $req = self::$bdd->prepare("UPDATE post SET ".implode(", ", $set)." WHERE id = ?");

        $req->execute($values);
        return $req->rowCount() > 0;

    }//end updatePost()


    /**
     * Delete a post with the specified ID.
     *
     * @param   int    $postId The ID of the post to delete.
     * @return bool True if the deletion was successful, false otherwise.
     */
    public function deletePost($postId)
    {
        $this->getBdd();

        $req = self::$bdd->prepare("DELETE FROM post WHERE `post`.`id` = ?");
        $req->execute([$postId]);
        return $req->rowCount() > 0;

    }//end deletePost()


}
