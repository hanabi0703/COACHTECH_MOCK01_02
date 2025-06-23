window.addEventListener('load', function main() {
    const payment = document.getElementById('payment');
    payment.addEventListener('change', (event) => {
        if (document.getElementById('payment')) {
            id = document.getElementById('payment').value;
            if (id == '1') {
                document.getElementById('Box1').style.display = "";
                document.getElementById('Box2').style.display = "none";
            } else if (id == '2') {
                document.getElementById('Box1').style.display = "none";
                document.getElementById('Box2').style.display = "";
            }
            }
        })
});