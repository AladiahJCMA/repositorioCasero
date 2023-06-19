<?php
// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

/*header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Auth-Token, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE, PATCH');
header('Allow: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Max-Age: 86400');*/

require_once 'connect.php';
require_once 'Router.php';

$router = new Router();
$route = '/Aladiah/PHP-API/FrontController.php/';

/////// GET
$router->get($route . 'user/{idUser}', 'UsersController@getUser');
$router->get($route . 'users', 'UsersController@getUsers');
$router->get($route . 'user/checkUsername/{username}', 'UsersController@checkUsername');
$router->get($route . 'user/checkEmail/{email}', 'UsersController@checkEmail');
$router->get($route . 'post/{idPost}', 'PostsController@getPost');
$router->get($route . 'posts/{idSubtheme}', 'PostsController@getPostsBySubtheme');
$router->get($route . 'posts/score', 'PostsController@getPostsByScore');
$router->get($route . 'themes', 'ThemesController@getThemes');
$router->get($route . 'subthemes', 'SubthemesController@getSubthemes');
$router->get($route . 'subthemes/{idTheme}', 'SubthemesController@getSubthemesByTheme');
$router->get($route . 'post_types', 'PostTypesController@getPostTypes');
/////// POST
$router->post($route . 'user', 'UsersController@registerUser');
$router->post($route . 'user/login/{setCookie}', 'UsersController@login');
$router->post($route. 'user/cookieLogin', 'UsersController@cookieLogin');
$router->post($route . 'user/verify', 'UsersController@verify');
$router->post($route . 'post', 'PostsController@newPost');
$router->post($route . 'theme/admin/{idAdmin}', 'ThemesController@newTheme');
$router->post($route . 'subtheme/admin/{idAdmin}', 'SubthemesController@newSubtheme');
$router->post($route . 'post_types/admin/{idAdmin}', 'PostTypesController@newPostType');
/////// PUT
$router->put($route . 'user', 'UsersController@editUser');
$router->put($route . 'post/user/{idUser}', 'PostsController@editPostUser');
$router->put($route . 'post/admin/{idAdmin}', 'PostsController@editPostAdmin');
$router->put($route . 'post/{idPost}/user/{idUser}/vote', 'PostsController@votePost');
$router->put($route . 'theme/admin/{idAdmin}', 'ThemesController@editTheme');
$router->put($route . 'subtheme/admin/{idAdmin}', 'SubthemesController@editSubtheme');
/////// DELETE
$router->delete($route . 'user/{idUser}', 'UsersController@deleteUser');
$router->delete($route . 'user/{idUser}/admin/{idAdmin}', 'UsersController@deleteUserAdmin');
$router->delete($route . 'post/{idPost}/user/{idUser}', 'PostsController@deletePost');
$router->delete($route . 'post/{idPost}/admin/{idAdmin}', 'PostsController@deletePostAdmin');
$router->delete($route . 'theme/{idTheme}/admin/{idAdmin}', 'ThemesController@deleteTheme');
$router->delete($route . 'subtheme/{idSubtheme}/admin/{idAdmin}', 'SubthemesController@deleteSubtheme');

/////// DISPATCH
$router->dispatch();
