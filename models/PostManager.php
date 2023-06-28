<?php

/**
 *
 */
class PostManager extends Model
{

    public function createPost($post)
    {
        if (!($post instanceof Post)) {
            // Return an error or an exception
            return false;
        }

        return $this->createOne('post', $post);
    }

    // Create the function to retrieve
    // all posts from the database
    public function getPosts()
    {
        return $this->getAll('posts', 'Post');
    }

    public function getPost($id)
    {
        return $this->getOne('post', 'Post', $id);
    }

    private function createOne($table, $obj)
    {
        $this->getBdd();

        $req = self::$bdd->prepare("INSERT INTO " . $table . " (categoryId, userId, title, chapo, picture, content) VALUES (?, ?, ?, ?, ?, ?)");
        $req->execute(array(
            $obj->getCategoryId(),
            $obj->getUserId(),
            $obj->getTitle(),
            $obj->getChapo(),
            $obj->getPicture(),
            $obj->getContent(),
        ));
        $req->closeCursor();
        return true;
    }

    private function getOne($table, $obj, $id)
    {
        $this->getBdd();
        $data = [];
        $req = self::$bdd->prepare("SELECT id, categoryId, userId, title, chapo, picture, content, DATE_FORMAT(createdAt, '%d/%m/%Y à %Hh%imin%ss') AS createdAt, DATE_FORMAT(updatedAt, '%d/%m/%Y à %Hh%imin%ss') AS updatedAt FROM " . $table . " WHERE id = ?");
        $req->execute(array($id));
        while ($var = $req->fetch(PDO::FETCH_ASSOC)) {
            $data[] = new $obj($var);
        }
        $req->closeCursor();

        return $data;
    }

    public function getAll($table)
    {
        $this->getBdd();
        $data = [];
        $req = self::$bdd->prepare("SELECT id, categoryId, userId, title, chapo, picture, content, DATE_FORMAT(createdAt, '%d/%m/%Y à %Hh%imin%ss') AS createdAt, DATE_FORMAT(updatedAt, '%d/%m/%Y à %Hh%imin%ss') AS updatedAt FROM " . $table . ' ORDER BY id DESC');
        $req->execute();

        // On récupère les données directement dans un tableau
        while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        $req->closeCursor();

        return $data;
    }

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
        $req = self::$bdd->prepare("UPDATE post SET " . implode(", ", $set) . " WHERE id = ?");
        
        $req->execute($values);
        return $req->rowCount() > 0;
}



    public function deletePost($postId)
    {
        $this->getBdd();

        $req = self::$bdd->prepare("DELETE FROM post WHERE `post`.`id` = ?");
        $req->execute([$postId]);
        return $req->rowCount() > 0;
    }
}
