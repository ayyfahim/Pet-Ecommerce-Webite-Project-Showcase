const fs = require('fs');

const { envConfig, requiredEnvConfig } = require('./env.config');

const shallowPages = ['auth'];

Object.keys(requiredEnvConfig).forEach((key) => {
  if (requiredEnvConfig[key] && !envConfig[key]) {
    throw new Error(`Environment variable ${key} not found`);
  }
});

function getRewriteRoutesForFolder(rewriteRoutes, pageFolder) {
  const files = fs.readdirSync(`./pages/${pageFolder}/`).map((f) => f.replace('.tsx', ''));
  files.forEach((f) => {
    rewriteRoutes.push({
      source: `/${f}`,
      destination: `/${pageFolder}/${f}`,
    });
  });

  return rewriteRoutes;
}
const rewriteRoutes = shallowPages.reduce(getRewriteRoutesForFolder, []);

/** @type {import('next').NextConfig} */
const nextConfig = {
  reactStrictMode: true,
  async rewrites() {
    return rewriteRoutes;
  },
  images: {
    domains: [
      'dealaday.karimkhamiss.com',
      'admin.vitalpawz.com',
      'http://vitalpawz-admin.test',
      '127.0.0.1',
      'vitalpawz-admin.test',
    ],
  },
};

module.exports = nextConfig;
