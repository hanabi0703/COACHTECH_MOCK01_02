// window.addEventListener('load', function main() {
//     const button = document.getElementById('favorite__button');
//     const favorite_black = document.getElementById('favorite_black');
//     const favorite_white = document.getElementById('favorite_white');
//     // for (let i = 0; i < button.length; i++) {
//         button.addEventListener('click', toggleClass);
//     // }
//     function toggleClass() {
//         console.log('クリックイベント発火！', this);
//         // let target = this.value-1;
//         favorite_black.classList.toggle("active");
//         favorite_black.classList.toggle("hidden");
//         favorite_white.classList.toggle("active");
//         favorite_white.classList.toggle("hidden");
//     }
// });

window.addEventListener('load', function main() {
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function (e) {
            const button = this.querySelector('button[type="submit"]');
            button.disabled = true; // ボタンを無効化
        });
    });
});