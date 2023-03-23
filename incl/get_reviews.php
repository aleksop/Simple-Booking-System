<?php

require '../classes/dbh.classes.php';
require '../classes/reviews.classes.php';

$Reviews = new Reviews();

// Below function will convert datetime to time elapsed string.
function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    $string = array('y' => 'year', 'm' => 'month', 'w' => 'week', 'd' => 'day', 'h' => 'hour', 'i' => 'minute', 's' => 'second');
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }
    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

if (isset($_POST['name'], $_POST['rating'], $_POST['content'])) {
    // Insert a new review (user submitted form)
    $Reviews->insertReview($_POST['name'], $_POST['content'], $_POST['rating']);
    exit('Your review has been submitted!');
}
$reviewsArray = $Reviews->getReviews();
$reviews_info = $Reviews->getRating();
$overallRating = $reviews_info['overall_rating'] == null ? 0 : $reviews_info['overall_rating'];

?>

<div class="overall_rating">
    <span class="num"><?= $overallRating == 0 ? "" : number_format($overallRating, 1) ?></span>
    <span class="stars"><?= str_repeat('&#9733;', round($overallRating)) ?></span>
    <span class="total"><?= $reviews_info['total_reviews'] ?> reviews</span>
</div>
<a href="#" class="write_review_btn">Write Review</a>
<div class="write_review">
    <form>
        <input name="name" type="text" placeholder="Your Name" id="userName" required>
        <input name="rating" type="number" min="1" max="5" placeholder="Rating (1-5)" required>
        <textarea name="content" placeholder="Write your review here..." required></textarea>
        <button type="submit">Submit Review</button>
    </form>
</div>
<?php foreach ($reviewsArray as $review) : ?>
    <div class="review">
        <h3 class="name"><?= htmlspecialchars($review['name'], ENT_QUOTES) ?></h3>
        <div>
            <span class="rating"><?= str_repeat('&#9733;', $review['rating']) ?></span>
            <span class="date"><?= time_elapsed_string($review['submit_date']) ?></span>
        </div>
        <p class="content"><?= htmlspecialchars($review['content'], ENT_QUOTES) ?></p>
    </div>
<?php endforeach ?>