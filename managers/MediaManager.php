<?php

class MediaManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findByName(string $name) : ? Media
    {
        $query = $this->db->prepare("
        SELECT * 
        FROM medias 
        WHERE name = :name
        ");
        $parameters = [
            'name' => $name
        ];
        $query->execute($parameters);
        $img = $query->fetch(PDO::FETCH_ASSOC);
        if($img){
            $mediaClass = new Media($img["name"], $img["url"]);
            return $mediaClass;
        }
        else{
            return null;
        }
    }

    public function findAllWhere(string $name) : ? array
    {
        $query = $this->db->prepare("
        SELECT *
        FROM medias
        WHERE name 
        LIKE :name
        ");
        $parameters = [
         'name' => '%' . $name . '%'
        ];
        $query->execute($parameters);
        $images = $query->fetchAll(PDO::FETCH_ASSOC);
        $imagesMedia = [];
        if($images){
            foreach ($images as $image){
                $imagesMedia[] = new Media($image["name"], $image["url"]);
            }
            return $imagesMedia;
        }
        else {
            return null;
        }
    }

    public function addOne(string $name, string $url) : void
    {
        $query = $this->db->prepare("INSERT INTO medias (name, url) VALUES (:name, :url)");
        $parameters = [
            'name' => $name,
            'url' => $url
        ];
        $query->execute($parameters);
    }

}