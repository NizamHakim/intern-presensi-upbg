import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            width:{
                "1/10": "10%",
                "2/10": "20%",
                "3/10": "30%",
                "4/10": "40%",
                "5/10": "50%",
                "6/10": "60%",
                "7/10": "70%",
                "8/10": "80%",
                "9/10": "90%",
                "10/10": "100%",
                "100": "25rem",
                "104": "26rem",
                "108": "27rem",
                "112": "28rem",
            },
            height:{
                "0.75" : "0.1875rem",
                "12.5": "3.125rem",
                "54": "13.5rem",
                "61": "15.25rem",
                "62": "15.5rem",
            },
            maxWidth: {
                "8xl": "88rem",
                "9xl": "96rem",
                "10xl": "104rem",
            },
            minWidth:{
                "84": "21rem",
                "88": "22rem",
                "92": "23rem",
                "100": "25rem",
                "104": "26rem",
                "108": "27rem",
                "112": "28rem",
            },
            fontFamily: {
                poppins: ["Poppins", "sans-serif"],
            },
            colors: {
                upbg: "#0866b7",
                "upbg-light": "#0d8af6",
                "upbg-dark": "#004c8c",
                "false-black": "#333",
                "backdrop": "rgba(0, 0, 0, 0.2)",
            },
            boxShadow: {
                strong: "rgba(0, 0, 0, 0.24) 0px 3px 8px;",
                mainContent: "rgba(0, 0, 0, 0.1) -1px 0px 2px;",
                'inner-2': 'inset 0 0 3px rgba(0, 0, 0, 0.1)',
            },
            flex: {
                "2": "2 2 0%",
            },
            borderRadius: {
                "sm-md": "0.25rem",
            },
            outlineWidth: {
                "0.5": "0.5px",
                "1.5": "1.5px",
            },
        },
    },
    plugins: [],
};
