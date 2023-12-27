const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
  publicPath: process.env.NODE_ENV === 'production' ? 'dist/' : './',
  outputDir: '../dist',
  indexPath: '../index.html'
})
