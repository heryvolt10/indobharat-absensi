$(function () {
    ("use strict");
    $("#main-wrapper").AdminSettings({
        Layout: "vertical", // vertical | horizontal
        SidebarType: "full", // full / mini-sidebar
        BoxedLayout: true, // true | false
        Direction: "ltr", // ltr | rtl
        Theme: "light", // light | dark
        ColorTheme: "Blue_Theme", // Blue_Theme | Aqua_Theme | Purple_Theme | Green_Theme | Cyan_Theme | Orange_Theme
        cardBorder: false, // true | false
    });

    // $ly_theme = "{{session()->get('ly_theme') }}";
    // $ly_container = "{{ session()->get('ly_container') }}";
    // $ly_sidebar = "{{ session()->get('ly_sidebar') }}";

    // console.log("userid", ly_theme);
    // ("use strict");
    // $("#main-wrapper").AdminSettings({
    //     Layout: "vertical", // vertical | horizontal
    //     SidebarType: $ly_sidebar == 1 ? 'mini-sidebar' : 'full', // full / mini-sidebar
    //     BoxedLayout: $ly_container == 1 ? false : true, // true | false
    //     Direction: "ltr", // ltr | rtl
    //     Theme: $ly_theme == 1 ? 'dark' : 'light', // light | dark
    //     ColorTheme: "Blue_Theme", // Blue_Theme | Aqua_Theme | Purple_Theme | Green_Theme | Cyan_Theme | Orange_Theme
    //     cardBorder: false, // true | false
    // });
});
