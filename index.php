<?php
session_start();
require_once './model/model.php';
require_once './controller/controller.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ('/' === $uri) {
    main();
    return;
}

if ('/about' === $uri) {
    about();
    return;
}

if ('/sign-in' === $uri) {
    signin();
    return;
}

if ('/sign-up' === $uri) {
    signup();
    return;
}

if ('/order' === $uri) {
    order();
    return;
}


// Функція для перевірки авторизації
function ensure_authenticated()
{
    if (!isset($_SESSION['user_id'])) {
        header("Location: /sign-in");
        exit;
    }
}

// Функція для перевірки ролі адміністратора
function ensure_admin()
{
    ensure_authenticated();
    if ($_SESSION['user_role'] !== 'admin') {
        header("Location: /");
        exit;
    }
}

if ('/account/settings' === $uri) {
    ensure_authenticated();
    settings();
    return;
}
if ('/account/instruction' === $uri) {
    ensure_authenticated();
    instructionController();
    return;
}

if('/account/statistics' === $uri){
    // ensure_authenticated();
    statistics();
    return;
}

if ('/account/bpla' === $uri) {
    // ensure_authenticated();
    bpla();
    return;
}

if ('/account/drone-statistic' === $uri) {
    // ensure_authenticated();
    droneStatistics();
    return;
}




if ('/account/create-order' === $uri) {
    ensure_authenticated();
    create_order();
    return;
}

// if ('/account/dashboard' === $uri) {
//     ensure_authenticated();
//     dashboard();
//     return;
// }

if ('/account/chat' === $uri) {
    ensure_authenticated();
    chat();
    return;
}

if ('/account/history' === $uri) {
    ensure_authenticated();
    history();
    return;
}

if('/maps' === $uri) {
    mapsController();
    return;
}

// admin

if ('/admin/users' === $uri) {
    ensure_admin();
    adminUsers();
    return;
}

if ('/admin/projects' === $uri) {
    ensure_admin();
    adminProjects();
    return;
}

if ('/admin/maps' === $uri) {
    ensure_admin();
    adminMaps();
    return;
}

if ('/logout' === $uri) {
    logout();
    return;
}

not_found();
?>