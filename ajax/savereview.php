<?php

    session_start();
    if(!empty($_POST)){
            
        include_once(__DIR__.'/../classes/Review.php');
        include_once(__DIR__.'/../classes/User.php');

        $review = new Review();
        $review->setText($_POST['text']);
        $review->setStars($_POST['stars']);
        $review->setProduct_id($_POST['reviewId']);
        $review->setUser_id(User::sGetUser($_SESSION['username'])['id']);

        $review->save();

        $response = [
            'status' => 'success',
            'body' => htmlspecialchars($review->getText()),
            'stars' => htmlspecialchars($review->getStars()),
            'user' => htmlspecialchars($_SESSION['username']),
            'message' => 'Review saved'
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }
?>