// Script to handle expanding feature boxes
document.addEventListener('DOMContentLoaded', function () {
    const boxes = document.querySelectorAll('.box-content');
    boxes.forEach(box => {
        // Add expand button
        const expandBtn = document.createElement('button');
        expandBtn.textContent = 'Click for more';
        expandBtn.classList.add('btn', 'btn-primary', 'btn-sm', 'mt-2', 'expand-btn');
        expandBtn.addEventListener('click', function () {
            box.style.maxHeight = 'none';
            this.style.display = 'none';
        });
        box.parentNode.querySelector('.feature-box').appendChild(expandBtn);
    });
});
