const express = require('express');
require('dotenv').config();

const app = express();
const port = process.env.REACT_APP_SERVER_PORT;

app.get('/', (req, res) => {
  res.send('Hello World!');
})

app.listen(port, () => {
  console.log(`Example app listening on port ${port}`);
})
