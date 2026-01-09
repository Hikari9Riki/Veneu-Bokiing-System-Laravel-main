import { plugin } from "postcss";

export default{
    content: [
        "./resource/**/*.blade.php",
        "./resource/**/*.js",
        "./resource/**/*.vue",
    ],

    theme: {
        extend: {},
    },
    plugin: [],
}