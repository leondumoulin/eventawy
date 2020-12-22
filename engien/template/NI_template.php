<?php
class NI_template
{
    public static $lang_code;
    public static $kit;
    public static $bootstrap;
    public static $lang_dir;
    public static $page;
    public static $url_array = [];
    
    public static function css_lang()
    {
        switch (self::$lang_code) {
            case 'ar':
                self::$kit = 'uikit-rtl';
                self::$bootstrap = 'bootstrap-rtl';
                self::$lang_dir = 'rtl';
                break;
            default:
                self::$kit = 'uikit';
                self::$bootstrap = 'bootstrap';
                self::$lang_dir = 'ltr';
                break;
        }
    }

    public static function page()
    {
        $page = basename($_SERVER['REQUEST_URI']);
        $u_arr = explode('/', $_SERVER['REQUEST_URI']);
        array_shift($u_arr);
        self::$url_array = $u_arr;
        $page = $u_arr[0];
        self::$page = $page;
    }

    public static function http($bool)
    {
        if ($bool == true) {
            echo '<script>if (location.protocol != "https:"){location.href = "https:" + window.location.href.substring(window.location.protocol.length);}</script>';
        }
    }

    public static function special_css($args = array())
    {
        $result = [];
        if (!empty($args)) {
            foreach ($args as $css_file) {
                $path = 'app'.SEP.'static'.SEP.'css'.SEP.$css_file.'.css';
                if (file_exists($path)) {
                    array_push($result, '    <link rel="stylesheet" href="/'.$path.'">');
                }
            }
        }
        return $result;
    }

    public static function special_js($args = array())
    {
        $result = [];
        if (!empty($args)) {
            foreach ($args as $js_file) {
                $path = 'app'.SEP.'static'.SEP.'js'.SEP.$js_file.'.js';
                if (file_exists($path)) {
                    array_push($result, '<script src="/'.$path.'"></script>'."\n");
                }
            }
        }
        return $result;
    }

    public static function call_css()
    {
        echo '
        <!DOCTYPE html>
        <html lang="'.self::$lang_code.'" dir="'.self::$lang_dir.'">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <script src="/engien/static/js/cleave.min.js"></script>
        ';
        switch (FrontFrame) {
            case 'UIkit':
                echo '
                <link rel="stylesheet" href="/engien/static/css/'.self::$kit.'.min.css">
                <script src="/engien/static/js/uikit.min.js"></script>
                <script src="/engien/static/js/uikit-icons.min.js"></script>
                ';
                break;
            case 'Bootstrap':
                echo '
                <link rel="stylesheet" href="/engien/static/css/'.self::$bootstrap.'.min.css">
                ';
                break;
            case 'all':
                echo '
                <link rel="stylesheet" href="/engien/static/css/'.self::$kit.'.min.css">
                <link rel="stylesheet" href="/engien/static/css/'.self::$bootstrap.'.min.css">
                <script src="/engien/static/js/uikit.min.js"></script>
                <script src="/engien/static/js/uikit-icons.min.js"></script>
                ';
                break;
            default:
        }
        echo'
        <link rel="stylesheet" href="/engien/static/css/all.min.css">
        <style>
        
        @font-face {
            font-family: "Tajawal";
            font-style: normal;
            font-weight: 200;
            font-display: swap;
            src: url("/app/static/fonts/Tajawal-Bold.woff2") format("woff2");
            unicode-range: U+0600-06FF, U+200C-200E, U+2010-2011, U+204F, U+2E41, U+FB50-FDFF, U+FE80-FEFC;
          }
          /* latin */
          @font-face {
            font-family: "Tajawal";
            font-style: normal;
            font-weight: 200;
            font-display: swap;
            src: url("/app/static/fonts/Tajawal-Light.woff2") format("woff2");
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
          }

        </style>
        
        ';
    }

    public static function langfile()
    {
        $lang_file = ROOT.SEP.'engien'.SEP.'lang'.SEP.self::$lang_code.'.php';
        if (file_exists($lang_file)) {
            require_once $lang_file;
        }
    }

    public static function head()
    {
        $args = func_get_args();
        self::$lang_code = $args[0];
        self::css_lang();
        self::page();
        self::http(false);
        self::call_css();

        if (isset($args[2])) {
            $js_lib_up = self::special_js($args[2]);
            foreach ($js_lib_up as $js) {
                echo $js;
            }
        }


        if (isset($args[1])) {
            $css_lib = self::special_css($args[1]);
            if (!empty($css_lib)) {
                foreach ($css_lib as $key) {
                    echo $key."\n";
                }
            }
        }
        echo '
            <link rel="icon" href="/storage/icon/favicon.ico">
        </head>
        <body>
        ';
        self::langfile();
    }

    public static function footer()
    {
        $args = func_get_args();
        echo '
                <script src="/engien/static/js/jquery.js"></script>
            ';
        if (FrontFrame == 'Bootstrap' || FrontFrame == 'all') {
            echo '
            <script src="/engien/static/js/popper.min.js"></script>
            <script src="/engien/static/js/bootstrap.min.js"></script>
            ';
        }
        if (!empty($args)) {
            $js_lib = self::special_js($args[0]);
            foreach ($js_lib as $js) {
                echo $js;
            }
        }
        echo '
            </body>
            </html>
        ';
    }

    public static function copyright()
    {
        echo '
            <div id="lowerbar" class="text-center uk-background-secondary d-flex align-items-center" dir="ltr">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <p class="m-0 text-muted">Copyright © 2019 <a class="text-light" href="https://nullissues.com">NULLissues</a> Inc. All rights reserved.</p>
                    </div>
                </div>
            </div>
            </div>
        ';
    }
}
