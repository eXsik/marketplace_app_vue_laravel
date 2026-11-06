/* eslint-env node */
require("@rushstack/eslint-patch/modern-module-resolution")

module.exports = {
    root: true,
    extends: [
        "plugin:vue/vue3-essential",
        "eslint:recommended",
        "@vue/eslint-config-prettier"
    ],
    parserOptions: {
        ecmaVersion: "latest"
    },
    env: {
        browser: true,
        es2022: true
    },
    globals: {
        route: "readonly"
    },
    rules: {
        "vue/multi-word-component-names": "off"
    }
}
