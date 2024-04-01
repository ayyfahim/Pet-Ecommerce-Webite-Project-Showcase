module.exports = {
  plugins: {
    tailwindcss: {},
    autoprefixer: {},
    // eslint-disable-next-line no-process-env
    ...(process.env.NODE_ENV === 'production' ? { cssnano: {} } : {})
  },
}
