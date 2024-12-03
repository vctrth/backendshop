document.querySelector('#submit_review').addEventListener('click', function() {

    let reviewId = this.dataset.reviewid;
    let text = document.querySelector('#review_text').value;
    let stars = document.querySelector('#review_stars').value;

    console.log(reviewId, text, stars);

    //Post to database (ajax)
    let formData = new FormData();
    formData.append('text', text);
    formData.append('stars', stars);
    formData.append('reviewId', reviewId);

    fetch('ajax/savereview.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(result => {
            console.log('Success:', result);

            let newReview = document.createElement('li');
            newReview.innerHTML = '<b>' + result.user + '</b>: ' + result.body + ' ' + result.stars + '/5 stars';
            document.querySelector('.reviews').appendChild(newReview);
        });
});