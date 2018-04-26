<?php

namespace Alberthorta\Bonobo\Report;

class FacebookLikes {
    protected $facebok_likes_data;

    /**
     * FacebookLikes constructor.
     * @param $facebok_likes_data
     */
    public function __construct($facebok_likes_data) {
        $this->facebok_likes_data = $facebok_likes_data;
    }

    /**
     * @return int
     */
    public function getRecipientLikes() {
        return $this->facebok_likes_data->recipient_likes;
    }

    /**
     * @return int
     */
    public function getUniqueLikes() {
        return $this->facebok_likes_data->unique_likes;
    }

    /**
     * @return int
     */
    public function getFacebookLikes() {
        return $this->facebok_likes_data->facebook_likes;
    }
}