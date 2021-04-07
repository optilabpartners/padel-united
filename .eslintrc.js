module.exports = {
  'root': true,
  'extends': 'eslint:recommended',
  'globals': {
    'wp': true,
  },
  'env': {
    'node': true,
    'es6': true,
    'amd': true,
    'browser': true,
    'jquery': true,
  },
  'parser': 'babel-eslint',
  'parserOptions': {
    'ecmaFeatures': {
      'globalReturn': true,
      'generators': false,
      'objectLiteralDuplicateProperties': false,
      'experimentalObjectRestSpread': true,
      'jsx': true,
      'modules': true
    },
    'ecmaVersion': 2017,
    'sourceType': 'module',
  },
  'plugins': [
    'import',
    'react'
  ],
  'settings': {
    'import/core-modules': [],
    'import/ignore': [
      'node_modules',
      '\\.(coffee|scss|css|less|hbs|svg|json)$',
    ],
    'react': {
      'createClass': 'createReactClass',
      'pragma': 'React',
      'version': 'latest'
    }
  },
  'extends': ['eslint:recommended', 'plugin:react/recommended'],
  'rules': {
    'no-console': 0,
    'quotes': ['error', 'single'],
    'comma-dangle': [
      'error',
      {
        'arrays': 'always-multiline',
        'objects': 'always-multiline',
        'imports': 'always-multiline',
        'exports': 'always-multiline',
        'functions': 'ignore',
      },
    ],
    'comma-dangle': 0,
    'no-console': 0,
    'no-undef': 0,
    'quotes': 0
  },
};
