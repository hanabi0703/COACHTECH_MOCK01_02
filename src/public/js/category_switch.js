window.addEventListener('load', function main() {
    const button = document.getElementsByClassName('category-input');
    const label = document.getElementsByClassName('category-input__parent');
    for (let i = 0; i < button.length; i++) {
        button[i].addEventListener('click', toggleClass);
    }
    function toggleClass() {
        let target = this.value-1;
        label[target].classList.toggle("category__on");
    }
});