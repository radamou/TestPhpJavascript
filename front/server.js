const express = require('express');
const app = express();
const path = require('path');
const fs = require('fs');

app.use('/', express.static(path.resolve(__dirname, '../dist/')))

app.get('*', function(req, res) {
    const entrypoint = path.resolve(__dirname, 'dist/dashboard.html')
    res.send(fs.readFileSync(entrypoint, 'utf-8'));
})
app.listen(9000, function() {
    console.log('Application is running on http://localhost:9000')
})