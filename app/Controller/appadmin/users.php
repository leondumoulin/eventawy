<?php
namespace appadmin;

class users
{
    public static function index()
    {
        \NI_security::authorized('login', true, '/appadmin/login');
        \NI_security::authorized('role', 'appadmin', '/appadmin/login');

        $path = ['AdminApp','users'];
        $static = [
            'css_arr' => [
                'datatablefinal',
                'Students'
            ],
            'header_js_arr' => [],
            'footer_js_arr' => [
                'assets/axios',
                'assets/all.min',
                'assets/dataTables',
                'assets/jquery.dataTables.min',
                'assets/dataTables.buttons.min',
                'assets/buttons.flash.min',
                'assets/jszip.min',
                'assets/pdfmake.min',
                'assets/buttons.min',
                'assets/vfs_fonts',
                'assets/buttons.print.min',
                'assets/buttons.colVis.min',
                'page/users'
            ]
        ];
        $data = [
            'users' => \model\users::select()
        ];
        \NI_view::Twig($path, $static, $data);
        $error = [
            'ErrorType' => $_COOKIE['ErrorType']??null,
            'ErrorMsg'=> $_COOKIE['ErrorMsg']??null
        ];
    }
}
