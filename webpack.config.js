const defaultConfig = require('@wordpress/scripts/config/webpack.config');
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
    new MiniCssExtractPlugin(),
  ]
};
