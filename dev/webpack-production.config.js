var _ = require('underscore');
var defaultConf = require ('./webpack-dev.config');

var path = require("path");
var webpack = require("webpack");

module.exports = _.extend(_.omit(defaultConf, 'debug', 'devtool', 'plugins'), {
  plugins: defaultConf.plugins.concat(
    new webpack.optimize.UglifyJsPlugin({
      compress: {
        warnings: false
      }
    })
  )
});