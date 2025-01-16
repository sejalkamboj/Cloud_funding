const express = require('express');
const mysql = require('mysql2');

const app = express();
const PORT = 3000; // You can use any port you prefer

// Create a MySQL connection
const connection = mysql.createConnection({
    host: 'localhost', // Your MySQL host (usually 'localhost')
    user: 'root', // Your MySQL username
    password: 'pswrd123', // Your MySQL password
    database: 'crowdfunding_platform' // Your MySQL database name
});

// Connect to MySQL
connection.connect((err) => {
    if (err) {
        console.error('Error connecting to MySQL:', err);
        return;
    }
    console.log('Connected to MySQL!');
});

// Example route
app.get('/', (req, res) => {
    res.send('Welcome to the Fund Flow API!');
});

// Start the server
app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});
