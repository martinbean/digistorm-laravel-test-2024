/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    ],
    darkMode: 'dark',
    theme: {
        container: {
            center: true,
            padding: '2rem',
        },
        extend: {},
    },
    plugins: [
        // require('@tailwindcss/forms'),
    ],
}
