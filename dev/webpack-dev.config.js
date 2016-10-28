var path = require("path");
var webpack = require("webpack");

module.exports = {
  devtool: "source-map",
  debug: true,
  entry: {
    'location-select': './scripts/location-select.js',
    'property-id-repeater': './scripts/property-id-repeater.js'
  },
  output: {
    path: '../assets',
    filename: '[name].js'
  },
  module: {
    loaders: [
      {
        test: /\.js$/,
        loaders: ['babel-loader'],
        exclude: /node_modules/
      },
      {
        test: /\.css$/,
        loaders: ['style-loader', 'css-loader', 'postcss-loader']
      }
    ]
  },
  postcss: [
    require('autoprefixer')()
  ],
  externals: {
    "jquery": "jQuery",
    "backbone": "Backbone",
    "underscore": "_"
  },
  plugins: [
    new webpack.optimize.OccurrenceOrderPlugin(),
    new webpack.optimize.DedupePlugin()
  ]
};
