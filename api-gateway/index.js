const express = require('express');
const { createProxyMiddleware } = require('http-proxy-middleware');
const cors = require('cors');

const app = express();
const PORT = 8080;

app.use(cors());

// Configuration
const USER_SERVICE_URL = process.env.USER_SERVICE_URL || 'http://localhost:3000';
const PRODUCT_SERVICE_URL = process.env.PRODUCT_SERVICE_URL || 'http://localhost:5000';
const ORDER_SERVICE_URL = process.env.ORDER_SERVICE_URL || 'http://localhost:8000';

app.get('/', (req, res) => {
    res.send('API Gateway is running');
});

// Proxy routes
app.use('/auth', createProxyMiddleware({
    target: USER_SERVICE_URL,
    changeOrigin: true,
    pathRewrite: {
        '^/auth': '', // remove base path
    },
}));

app.use('/catalog', createProxyMiddleware({
    target: PRODUCT_SERVICE_URL,
    changeOrigin: true,
    pathRewrite: {
        '^/catalog': '',
    },
}));

app.use('/sales', createProxyMiddleware({
    target: ORDER_SERVICE_URL,
    changeOrigin: true,
    pathRewrite: {
        '^/sales': '',
    },
}));

app.listen(PORT, () => {
    console.log(`API Gateway listening on port ${PORT}`);
});
