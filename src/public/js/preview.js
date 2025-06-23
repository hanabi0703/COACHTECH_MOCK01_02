window.addEventListener('load', function main() {
    const input = document.querySelector('#input')
    const figure = document.querySelector('#figure')
    const figureImage = document.querySelector('#figureImage')
    const existFigure = document.querySelector('#existFigure')

    input.addEventListener('change', (event) => { // <1>
        const file = event.target.files[0];
        if (file) {
            figureImage.setAttribute('src', URL.createObjectURL(file))
            figure.style.display = 'block'
            if (existFigure) {
                existFigure.style.display = 'none'
            }
        } else {
            figure.style.display = 'none'
        }
    })
});

// main()