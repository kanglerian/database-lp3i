const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            }, colors: {
                lp3i: {
                    '100': '#006CB2',
                    '200': '#005F9C',
                    '300': '#00568D',
                    '400': '#004D7E',
                    '500': '#00426D',
                    '600': '#00395E',
                    '700': '#003354',
                    '800': '#002A45',
                    '900': '#001E32',
                },
                merah: {
                    '100': '#FF7A84',
                    '200': '#F15C67',
                    '300': '#E35762',
                },
                hijau: {
                    '100': '#00AEB6',
                    '200': '#009FA6',
                },
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
