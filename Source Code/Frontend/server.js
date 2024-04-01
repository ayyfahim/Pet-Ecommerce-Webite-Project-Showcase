/* eslint-disable @typescript-eslint/no-var-requires */
const { createServer } = require("https");
const { parse } = require("url");
const next = require("next");

const fs = require('fs');
// eslint-disable-next-line no-process-env
const dev = process.env.NODE_ENV !== 'production';
const app = next({ dev });
const handle = app.getRequestHandler();
const httpsOptions = {
  key: fs.readFileSync('./certs/localhost.key'),
  cert: fs.readFileSync('./certs/localhost.crt'),
};
app.prepare().then(() => {
  createServer(httpsOptions, (req, res) => {
    const parsedUrl = parse(req.url || '', true);
    handle(req, res, parsedUrl);
  }).listen(3000, (err) => {
    if (err) throw err;
    console.log('> Server started on https://localhost:3000');
  });
});

export {};
