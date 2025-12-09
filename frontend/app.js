const API_URL = 'http://localhost:8080';
let authToken = null;

async function register() {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    const res = await fetch(`${API_URL}/auth/register`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ username, password })
    });
    const data = await res.json();
    alert(data.message || data.error);
}

async function login() {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    const res = await fetch(`${API_URL}/auth/login`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ username, password })
    });
    const data = await res.json();
    if (data.token) {
        authToken = data.token;
        document.getElementById('token').textContent = authToken;
        alert('Logged in!');
    } else {
        alert(data.message || 'Login failed');
    }
}

async function loadProducts() {
    const res = await fetch(`${API_URL}/catalog/products`);
    const products = await res.json();

    const list = document.getElementById('products-list');
    list.innerHTML = ''; // Clear list
    const ul = document.createElement('ul');

    products.forEach(p => {
        const li = document.createElement('li');
        li.textContent = `ID: ${p.id} - ${p.name} ($${p.price})`;
        ul.appendChild(li);
    });
    list.appendChild(ul);
}

async function addProduct() {
    const name = document.getElementById('prod-name').value;
    const price = document.getElementById('prod-price').value;

    const res = await fetch(`${API_URL}/catalog/products`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ name, price: parseFloat(price) })
    });
    const data = await res.json();
    if (data.id) {
        alert('Product Added');
        loadProducts();
    } else {
        alert('Error adding product');
    }
}

async function placeOrder() {
    if (!authToken) {
        alert('Please login first');
        return;
    }

    const payload = JSON.parse(atob(authToken.split('.')[1]));
    const userId = payload.userId;

    const productId = document.getElementById('order-prod-id').value;
    const quantity = document.getElementById('order-qty').value;

    const prodRes = await fetch(`${API_URL}/catalog/products/${productId}`);
    if (!prodRes.ok) {
        alert('Product not found');
        return;
    }
    const product = await prodRes.json();
    const totalPrice = product.price * quantity;

    const orderData = {
        user_id: userId,
        product_id: productId,
        quantity: quantity,
        total_price: totalPrice
    };

    const res = await fetch(`${API_URL}/sales/orders`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(orderData)
    });

    const data = await res.json();
    document.getElementById('order-result').textContent = JSON.stringify(data, null, 2);
}
