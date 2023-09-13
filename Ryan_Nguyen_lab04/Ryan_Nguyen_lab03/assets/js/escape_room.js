document.addEventListener('DOMContentLoaded', function() {
    const img1Opacity = document.getElementById('image1Control');
    img1Opacity.addEventListener('click', () => {
        const img1 = document.getElementById('first-image');
        img1.style.opacity = img1Opacity.value;
        const txt1 = document.getElementById('image1Opacity');
        txt1.value = img1Opacity.value;
    });

    const img2Opacity = document.getElementById('image2Control');
    img2Opacity.addEventListener('click', () => {
        const img2 = document.getElementById('second-image');
        img2.style.opacity = img2Opacity.value;
        const txt2 = document.getElementById('image2Opacity');
        txt2.value = img2Opacity.value;
    });
})