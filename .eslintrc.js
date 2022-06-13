module.exports = {
  extends: [
    'plugin:vue/recommended',
    '@vue/standard',
  ],
  globals: {
    axios: 'readable',
    route: 'readable',
    _: 'readable',
  },
  rules: {
    'comma-dangle': ['error', 'always-multiline'],
  },
}
