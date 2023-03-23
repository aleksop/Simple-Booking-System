<?php
class Reviews
{

    private $DB;
    public function __construct()
    {
        $this->DB = Dbh::getInstance();
    }
    function insertReview($name, $content, $rating)
    {
        // Insert a new review (user submitted form)
        $sql = "INSERT INTO `reviews` (`name`, `content`, `rating`, `submit_date`) VALUES (?,?,?,NOW())";
        $data = [$name, $content, $rating];
        $this->DB->query($sql, $data);
        return true;
    }

    function getReviews()
    {
        // Get all reviews ordered by the submit date
        $this->DB->stmt = $this->DB->pdo->prepare('SELECT * FROM reviews ORDER BY submit_date DESC');
        $this->DB->stmt->execute();
        $reviews =  $this->DB->stmt->fetchAll(PDO::FETCH_ASSOC);
        return $reviews;
    }

    function getRating()
    {
        // Get the overall rating and total amount of reviews
        $this->DB->stmt = $this->DB->pdo->prepare('SELECT AVG(rating) AS overall_rating, COUNT(*) AS total_reviews FROM reviews');
        $this->DB->stmt->execute();
        $reviews_info = $this->DB->stmt->fetch(PDO::FETCH_ASSOC);
        return $reviews_info;
    }
}
