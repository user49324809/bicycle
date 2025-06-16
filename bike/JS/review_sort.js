document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('#filterButton').addEventListener('click', () => {
        const selectedValue = document.querySelector('#ratingFilter').value;
        const reviews = document.querySelectorAll('#reviewModule > .col-md-6');
        reviews.forEach(review => {
            const rating = review.getAttribute('data-rating');
            if (selectedValue === '' || selectedValue === rating) {
                review.style.display = 'block';
            } else {
                review.style.display = 'none';
            }
        });
    });
});
