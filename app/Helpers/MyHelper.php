<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


function help_setapp($name)
{
    $data = App\Models\M_Setting_app::where('name', $name)->first()->value;

    return $data;
}



function imageToBase64($path)
{

    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    return $base64;
}


function help_user_auth($email)
{

    $query = "SELECT A.*, B.nama as org, C.nama as role
                        FROM users A
                        INNER JOIN mt_org B ON B.id = A.f_org
                        INNER JOIN users_role C ON C.id = A.f_role
                        WHERE A.email = '$email'
                        ";

    $result = DB::select($query);

    if ($result) {
        return $result[0];
    } else {
        return '';
    }
}

function help_data_auth_user()
{
    $userId = Auth::id();

    $data = DB::select('SELECT A.*, B.nama as org, C.nama as role
                        FROM users A
                        INNER JOIN mt_org B ON B.id = A.f_org
                        INNER JOIN users_role C ON C.id = A.f_role
                        WHERE A.id = ' . $userId . '
                        ');
    return $data[0];
}


function help_menu()
{
    $sess_org = session('user_f_org');

    $query = "SELECT A.* FROM users_menu A ORDER BY seq ASC";
    $result = DB::select($query);

    return $result;
}

function help_submenu($submenu_id = null)
{


    $query = "SELECT A.*, B.nama as menu, B.icon as menu_icon, B.seq as menu_seq 
            FROM users_submenu A
            INNER JOIN users_menu B ON B.id = A.f_menu
            WHERE 1 = 1
            ";

    if ($submenu_id) {
        $query .= " AND A.id = $submenu_id ";
        $result = DB::select($query);

        return $result[0];
    } else {
        $query .= " ORDER BY B.seq, A.seq ASC ";
        $result = DB::select($query);

        return $result;
    }
}

function help_submenu_by_url($url = null)
{

    $query = "SELECT A.*, B.nama as menu, B.icon as menu_icon, B.seq as menu_seq 
            FROM users_submenu A
            INNER JOIN users_menu B ON B.id = A.f_menu
            WHERE 1 = 1 AND A.url = '$url'
            ";


    $result = DB::select($query);

    if ($result) {
        return $result;
    } else {
        return '';
    }
}


function help_update_sess_submenu($submenu_id = null)
{
    $query = "SELECT A.*, B.nama as menu, B.icon as menu_icon, B.seq as menu_seq 
            FROM users_submenu A
            INNER JOIN users_menu B ON B.id = A.f_menu
            WHERE A.id = $submenu_id 
            ";


    $result = DB::select($query);

    session()->put('submenu_id', $result[0]->id);
    session()->put('submenu_nama', $result[0]->nama);
    session()->put('submenu_url', $result[0]->url);
    session()->put('menu_id', $result[0]->f_menu);
    session()->put('menu_nama', $result[0]->menu);


    return "";
}


function help_user_access_menu()
{

    $sess_userid = session('user_id');
    $sess_role = session('user_frole');
    $sess_org = session('user_forg');

    if ($sess_userid == "1") {
        $query = "SELECT A.* FROM users_menu A WHERE A.f_status = 2 AND A.f_org = $sess_org ORDER BY A.seq ASC";
    } else {
        $query = "SELECT C.*
                FROM users_access_menu A
                INNER JOIN users_submenu B ON B.id = A.submenu_id
                INNER JOIN users_menu C ON C.id = B.f_menu
                INNER JOIN users_role D ON D.id = A.f_role
                WHERE B.f_org = $sess_org AND B.f_status = 2 AND D.f_status = 2 AND A.ishow = 1 
                AND A.f_role = $sess_role
                GROUP BY C.*
                ORDER BY C.seq ASC
                ";
    }

    $result = DB::select($query);

    return $result;
}

function help_user_access_submenu($submenuid = null)
{
    $sess_userid = session('user_id');
    $sess_role = session('user_frole');
    $sess_org = session('user_forg');

    if ($sess_userid == "1") {
        $query = "SELECT A.*, B.id as f_menu, B.nama as menu, B.seq as menu_seq, B.icon as menu_icon, 1 as ishow, 1 as isave, 1 as iadd, 1 as iedit, 1 as idelete
                FROM users_submenu A
                INNER JOIN users_menu B ON B.id = A.f_menu WHERE A.f_status = 2";

        if ($submenuid) {
            $query .= " AND A.id = $submenuid ";
        }

        $query .= " ORDER BY B.seq, A.seq ";

        if ($submenuid) {
            $query .= " LIMIT 1 ";
        }
    } else {
        $query = "SELECT B.*, C.id as f_menu, C.nama as menu, C.seq as menu_seq, C.icon as menu_icon, A.ishow, A.isave, A.iadd, A.iedit, A.idelete
                FROM users_access_menu A
                INNER JOIN users_submenu B ON B.id = A.f_submenu
                INNER JOIN users_menu C ON C.id = B.f_menu
                INNER JOIN users_role D ON D.id = A.f_role
                WHERE B.f_org = $sess_org AND B.f_status = 2 AND D.f_status = 2 
                AND A.f_role = $sess_role 
                ";

        if ($submenuid) {
            $query .= " AND B.id = $submenuid ";
        }

        $query .= " ORDER BY C.seq, B.seq ";

        if ($submenuid) {
            $query .= " LIMIT 1 ";
        }
    }

    $result = DB::select($query);



    if ($submenuid) {
        return $result[0];
    } else {
        return $result;
    }
}


function help_user_access_submenu_list($f_role = null)
{

    $query = "SELECT A.*, B.nama as submenu, C.id as f_menu, C.nama as menu, C.seq as menu_seq, C.icon as menu_icon
                FROM users_access_menu A
                INNER JOIN users_submenu B ON B.id = A.f_submenu
                INNER JOIN users_menu C ON C.id = B.f_menu
                INNER JOIN users_role D ON D.id = A.f_role
                WHERE B.f_status = 2 AND D.f_status = 2 
                AND A.f_role = $f_role
                ";

    $query .= " ORDER BY C.seq, B.seq ";

    $result = DB::select($query);


    return $result;
}



function help_get_status($type)
{

    $query = "SELECT A.* FROM mt_status A
    WHERE A.f_status <> 1 ";

    if ($type == 1) {
        $query .= " AND A.id IN (1,2) ";
    }
    $query .= " ORDER BY A.id DESC ";

    $data = DB::select($query);



    return $data;
}

function help_get_status_by_id($id)
{

    $query = "SELECT * FROM mt_status
    WHERE 1 =1 ";

    if ($id) {
        $query .= " AND id = $id ";
    }


    $data = DB::select($query);

    if ($data) {
        return $data[0];
    } else {
        return '';
    }
}



function help_default_status_filter($tableid)
{

    if ($tableid == '1') {
        $idIn = "2";
    } else {
        $idIn = "2";
    }

    $query = "SELECT * FROM mt_status
        WHERE id IN ($idIn)
        ORDER BY nama";

    $result = DB::select($query);

    return $result[0];
}


function help_format_money($angka)
{
    // ubah jadi string dan pastikan ada 2 desimal
    $angka = (string) $angka;

    if (strpos($angka, '.') !== false) {
        list($integer, $decimal) = explode('.', $angka);
        $decimalPart = "." . $decimal;
    } else {
        $integer = $angka;
        $decimalPart = "";
    }

    $rev = strrev($integer);
    $groups = str_split($rev, 3);
    $ribuan = strrev(implode(",", $groups));

    return $ribuan . $decimalPart;


    // return str_replace(array(".", ","), array(",", "."), $angka);
}
