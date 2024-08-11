document.getElementById('item').addEventListener('change', function() {
    var itemName = this.value;

    if (itemName !== "0") {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'bill/data.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById('price').value = xhr.responseText;
            }
        };

        xhr.send('item=' + encodeURIComponent(itemName));
    } else {
        document.getElementById('price').value = '';
    }
});


// amount

document.getElementById('quantity').addEventListener('change', function() {
    var price = document.getElementById('price').value;
    var quantity = document.getElementById('quantity').value;
    let sum = price * quantity;
    let amount = sum.toFixed(2);
    document.getElementById('amount').value = amount;

    console.log(price);

}) || document.getElementById('item').addEventListener('change', function() {
    var price = document.getElementById('price').value;
    var quantity = document.getElementById('quantity').value;
    let sum = price * quantity;
    let amount = sum.toFixed(2);
    document.getElementById('amount').value = amount;

    console.log(price);

})


// invoice  
document.addEventListener("DOMContentLoaded", function () {
    let x = parseInt(document.getElementById("num").value, 10)
                .toString()
                .padStart(4, "0");
    
    let year = new Date().getFullYear().toString().slice(-2);
    let month = new Date().getMonth().toString().padStart(2, "0");

    
    let invoice = document.getElementById("invoice");
    invoice.value =year + month + x;
  });