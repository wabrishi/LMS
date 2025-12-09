const express = require('express');
const mysql = require('mysql2/promise');

const app = express();
const PORT = process.env.PORT || 80;

// Environment variables
const DB_HOST = process.env.DB_HOST || 'localhost';
const DB_NAME = process.env.DB_NAME || 'orders_db';
const DB_USER = process.env.DB_USER || 'user';
const DB_PASS = process.env.DB_PASS || 'password';

app.use(express.json());

// Create connection pool
const pool = mysql.createPool({
  host: DB_HOST,
  user: DB_USER,
  password: DB_PASS,
  database: DB_NAME,
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0
});

// Initialize DB
const initDb = async () => {
  try {
    const connection = await pool.getConnection();
    await connection.query(`
      CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id VARCHAR(255) NOT NULL,
        product_id INT NOT NULL,
        quantity INT NOT NULL,
        total_price DECIMAL(10, 2) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      )
    `);
    console.log("Table 'orders' created or exists.");
    connection.release();
  } catch (err) {
    console.error("Database initialization failed:", err);
  }
};

initDb();

// Health check
app.get('/', (req, res) => {
  res.send("Order Service is running");
});

// Create Order
app.post('/orders', async (req, res) => {
  const { user_id, product_id, quantity, total_price } = req.body;

  if (!user_id || !product_id || !quantity || !total_price) {
    return res.status(400).json({ error: 'Missing required fields' });
  }

  try {
    const [result] = await pool.execute(
      'INSERT INTO orders (user_id, product_id, quantity, total_price) VALUES (?, ?, ?, ?)',
      [user_id, product_id, quantity, total_price]
    );

    res.status(201).json({
      id: result.insertId,
      user_id,
      product_id,
      status: 'created'
    });
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: 'Internal Server Error' });
  }
});

// List Orders
app.get('/orders', async (req, res) => {
  try {
    const [rows] = await pool.query('SELECT * FROM orders');
    res.json(rows);
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: 'Internal Server Error' });
  }
});

app.listen(PORT, () => {
  console.log(`Order service listening on port ${PORT}`);
});
