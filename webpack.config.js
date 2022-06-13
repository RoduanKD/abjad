const VuetifyLoaderPlugin = require('vuetify-loader/lib/plugin')
const ESLintPlugin = require('eslint-webpack-plugin')

module.exports = {
  plugins: [
    new VuetifyLoaderPlugin({
      progressiveImages: true,
    }),
    new ESLintPlugin({
      fix: true,
      extensions: ['js', 'vue'],
    }),
  ],
  // module: {
  //   rules: [
  //     // SASS has different line endings than SCSS
  //     // and cannot use semicolons in the markup
  //     {
  //       test: /\.sass$/,
  //       use: [
  //         'vue-style-loader',
  //         'css-loader',
  //         {
  //           loader: 'sass-loader',
  //           options: {
  //             // This is the path to your variables
  //             additionalData: "@import './resources/scss/variables.scss'"
  //           },
  //         },
  //       ],
  //     },
  //     // SCSS has different line endings than SASS
  //     // and needs a semicolon after the import.
  //     {
  //       test: /\.scss$/,
  //       use: [
  //         'vue-style-loader',
  //         'css-loader',
  //         {
  //           loader: 'sass-loader',
  //           options: {
  //             additionalData: "@import './resources/scss/variables.scss';"
  //           },
  //         },
  //       ],
  //     },
  //   ],
  // },
}
