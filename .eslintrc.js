module.exports = {
    root: true,
    parserOptions: {
        ecmaVersion: 6,
        sourceType: 'module',
        ecmaFeatures: {
            impliedStrict: true,
            experimentalObjectRestSpread: true
        },
    },
    globals: {
        '__webpack_public_path__': true
    },
    env: {
        es6: true,
        node: true,
        browser: true
    },
    extends: 'valtech',
    rules: {
        'rest-spread-spacing': [2, 'never']
    }
};
