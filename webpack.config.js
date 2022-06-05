"use strict";

const dotenv = require("dotenv");
const path = require("path");

const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const ImageMinimizerPlugin = require("image-minimizer-webpack-plugin");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const TerserPlugin = require("terser-webpack-plugin");
const { WebpackManifestPlugin } = require("webpack-manifest-plugin");

dotenv.config();

module.exports = {
  mode: "production",
  context: path.resolve(__dirname, "resources"),
  entry: {
    default: "./js/default.js",
    errors: "./js/errors.js",
  },
  output: {
    path: path.resolve(__dirname, "public", "assets"),
    filename: "js/[name].js",
    publicPath: process.env.ASSETS_PUBLIC_PATH,
  },
  module: {
    rules: [
      {
        test: /\.css|s[ac]ss$/,
        use: [
          MiniCssExtractPlugin.loader,
          {
            loader: "css-loader",
            options: {
              sourceMap: false,
            },
          },
          {
            loader: "postcss-loader",
            options: {
              postcssOptions: {
                plugins: [["autoprefixer"]],
              },
              sourceMap: false,
            },
          },
          {
            loader: "sass-loader",
            options: {
              sourceMap: false,
            },
          },
        ],
      },
      {
        test: /\.(eot|otf|ttf|woff|woff2)$/,
        type: "asset/resource",
        generator: {
          filename: "[path][hash][ext][query]",
        },
      },
      {
        test: /\.(gif|jpeg|jpg|png|svg|webp)$/,
        type: "asset/resource",
        generator: {
          filename: "[path][hash][ext][query]",
        },
      },
      {
        test: /\.js$/,
        exclude: /(node_modules|bower_components)/,
        use: {
          loader: "babel-loader",
          options: {
            presets: ["@babel/preset-env"],
          },
        },
      },
    ],
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: "css/[name].css",
    }),
    new WebpackManifestPlugin(),
  ],
  optimization: {
    minimize: true,
    minimizer: [
      new CssMinimizerPlugin(),
      new ImageMinimizerPlugin({
        minimizer: {
          implementation: ImageMinimizerPlugin.squooshMinify,
        },
      }),
      new TerserPlugin(),
    ],
  },
};
