const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const Dotenv = require('dotenv-webpack');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
  // Extend the provided webpack config
  ...defaultConfig,
  module: {
    ...defaultConfig.module,
    rules: [
        ...defaultConfig.module.rules,
    ],
  },
  plugins: [
    new Dotenv(),
    new MiniCssExtractPlugin(),
  ]
};
