module.exports = {
  parser: "babel-eslint",
  extends: [
    "eslint:recommended"
  ],
  parserOptions: {
    ecmaVersion: 6,
    sourceType: "module"
  },
  env: {
    "browser": true,
    "node": true
  },
  rules: {
    "quotes": 0,
    "no-console": 1
  },
  globals: {
    ahr_ga_conf: true
  }
}
