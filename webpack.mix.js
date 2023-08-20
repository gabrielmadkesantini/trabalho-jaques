mix.js("resources/js/app.js", "public/js")
    .postCss("resources/css/app.css", "public/css", [
        //
    ])
    .copy("node_modules/bootstrap-icons/font", "public/fonts/bootstrap-icons");
