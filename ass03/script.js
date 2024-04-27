document.addEventListener('DOMContentLoaded', function() {
    var ads = document.querySelectorAll('.advert');
    var currentIndex = 0;

    setInterval(function() {
        // Hide the current ad
        ads[currentIndex].style.display = 'none';

        // Move to the next ad
        currentIndex = (currentIndex + 1) % ads.length;

        // Show the next ad
        ads[currentIndex].style.display = 'block';
    }, 5000); // Switch ads every 5 seconds
});
