const input = document.getElementById('image');
const preview = document.getElementById('preview');
const placeholder = 'https://marcolanci.it/boolean/assets/placeholder.png';

input.addEventListener('input', () => {
    preview.src = input.value || placeholder;
})