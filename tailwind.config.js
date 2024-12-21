import defaultTheme from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                montserrat: ["Montserrat", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: "#FFC82C",
                secondary: "#1E1E23",
                background: "#19191C",
                accent: "#4D4D6C",
                textColor: "#FFFFFF",
            },
        },
    },

    plugins: [],
};
