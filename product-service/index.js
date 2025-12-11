const express = require('express');
const { Pool } = require('pg');

const app = express();
const PORT = process.env.PORT || 5000;
const DATABASE_URL = process.env.DATABASE_URL || 'postgresql://user:password@localhost:5432/products_db';

app.use(express.json());

const pool = new Pool({
  connectionString: DATABASE_URL,
});

// Create Table
const createTable = async () => {
  const query = `
    CREATE TABLE IF NOT EXISTS product (
      id SERIAL PRIMARY KEY,
      name VARCHAR(100) NOT NULL,
      price DECIMAL(10, 2) NOT NULL,
      description VARCHAR(255)
    );
  `;
  try {
    await pool.query(query);
    console.log("Table 'product' created or already exists.");
  } catch (err) {
    console.error("Error creating table:", err);
  }
};

// Connect and create table
pool.connect((err, client, release) => {
  if (err) {
    console.error('Error acquiring client', err.stack);
  } else {
    console.log('Connected to PostgreSQL');
    createTable();
  }
});

// Health Check
app.get('/', (req, res) => {
  res.send('Product Service is running');
});

// List Products
app.get('/products', async (req, res) => {
  try {
    const result = await pool.query('SELECT * FROM product');
    // Convert price to float for consistency with previous API
    const products = result.rows.map(p => ({
      ...p,
      price: parseFloat(p.price)
    }));
    res.json(products);
  } catch (err) {
    console.error(err);
    res.status(500).send('Server Error');
  }
});

// Create Product
app.post('/products', async (req, res) => {
  const { name, price, description } = req.body;
  if (!name || price === undefined) {
    return res.status(400).json({ message: 'Name and price are required' });
  }

  try {
    const result = await pool.query(
      'INSERT INTO product (name, price, description) VALUES ($1, $2, $3) RETURNING *',
      [name, price, description || '']
    );
    const newProduct = result.rows[0];
    newProduct.price = parseFloat(newProduct.price);
    res.status(201).json(newProduct);
  } catch (err) {
    console.error(err);
    res.status(500).send('Server Error');
  }
});

// Get Single Product
app.get('/products/:id', async (req, res) => {
  const { id } = req.params;
  try {
    const result = await pool.query('SELECT * FROM product WHERE id = $1', [id]);
    if (result.rows.length === 0) {
      return res.status(404).send('Product not found');
    }
    const product = result.rows[0];
    product.price = parseFloat(product.price);
    res.json(product);
  } catch (err) {
    console.error(err);
    res.status(500).send('Server Error');
  }
});

app.listen(PORT, () => {
  console.log(`Product service listening on port ${PORT}`);
});
