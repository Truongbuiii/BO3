
function updateQuantity(productId, change) {
    const quantitySpan = document.getElementById('quantity-' + productId);
    const input = document.getElementById('input-' + productId);
    const priceCell = document.getElementById('price-' + productId);
    const price = parseInt(priceCell.dataset.price);

    let quantity = parseInt(quantitySpan.textContent);
    quantity += change;

    if (quantity < 1) quantity = 1; // không cho nhỏ hơn 1

    quantitySpan.textContent = quantity;
    input.value = quantity;

    // Cập nhật tổng tiền
    updateTotal();
}

function updateTotal() {
    let total = 0;
    const allRows = document.querySelectorAll("tbody tr");

    allRows.forEach(row => {
        const priceCell = row.querySelector("td[data-price]");
        if (!priceCell) return;

        const price = parseInt(priceCell.dataset.price);
        const quantitySpan = row.querySelector("span[id^='quantity-']");
        const quantity = parseInt(quantitySpan.textContent);

        total += price * quantity;
    });

    // Format tiền
    const formatted = total.toLocaleString('vi-VN') + ' VND';
    document.getElementById('total-price').textContent = formatted;
}
