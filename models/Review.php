<?php

  class Review { #todos os campos do banco de dados, para montar o usuario 
    
    public $id;
    public $rating;
    public $review;
    public $users_id;
    public $movies_id;

  }   

  interface ReviewDAOinterface {

    public function buildReview($data);
    public function create(Review $review);
    public function getMoviesReview($id);
    public function hasAlreadyReviewed($id, $userId);
    public function getRatings($id);

  }