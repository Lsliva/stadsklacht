<?php

class Review
{
    public function __construct()
    {
       
    }

    public function insertreview($review, $linkId) {
        require 'database/conn.php';
if (!$linkId) {
    header('Location:./');
} 

        $statement = $conn->prepare("INSERT INTO reviews (review, linkId) VALUES (:review, :linkId)");
        $statement->bindParam(':review', $review);
        $statement->bindParam(':linkId', $linkId);
        $statement->execute();
        header("Location: readKlacht.php");

    }

    public function readReview()
{
    require 'database/conn.php';

    $sql = $conn->prepare('SELECT * FROM reviews');
    $sql->execute();

    echo '<div style="display: flex; padding: 24px; font-size: 20px; justify-content: center; text-align: center; color: white; flex-direction: column; "><table>';
    echo '<tr><th>Review Omschrijving</th><th></th><th>id</th> <th> </th> <th></th><th></th><th></th><th></th><th></th><th>     </th></tr>';

    foreach ($sql as $review) {
        echo '<tr>';
        echo '<td class="review-column">' . $review['review'] . '</td>';
        echo '<td>' . $review['linkId'] . '</td>';
        echo '<td>' . $review['review_id'] . '</td>';
       
        echo '</tr>';
    }

    echo '</table></div>';
}


}


?>


<style>
    .review-column {
        /* Add your styling for the review column here */
        font-weight: bold; /* Example: Make the text bold */
        max-width: 5em;
        overflow-x: scroll;

    }
    
</style>
