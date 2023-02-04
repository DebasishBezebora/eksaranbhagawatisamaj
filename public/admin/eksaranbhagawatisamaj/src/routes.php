<?php

namespace PHPMaker2022\eksbs;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

// Handle Routes
return function (App $app) {
    // site_settings
    $app->map(["GET","POST","OPTIONS"], '/SiteSettingsList[/{ID}]', SiteSettingsController::class . ':list')->add(PermissionMiddleware::class)->setName('SiteSettingsList-site_settings-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/SiteSettingsAdd[/{ID}]', SiteSettingsController::class . ':add')->add(PermissionMiddleware::class)->setName('SiteSettingsAdd-site_settings-add'); // add
    $app->map(["GET","OPTIONS"], '/SiteSettingsView[/{ID}]', SiteSettingsController::class . ':view')->add(PermissionMiddleware::class)->setName('SiteSettingsView-site_settings-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/SiteSettingsEdit[/{ID}]', SiteSettingsController::class . ':edit')->add(PermissionMiddleware::class)->setName('SiteSettingsEdit-site_settings-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/SiteSettingsDelete[/{ID}]', SiteSettingsController::class . ':delete')->add(PermissionMiddleware::class)->setName('SiteSettingsDelete-site_settings-delete'); // delete
    $app->group(
        '/site_settings',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{ID}]', SiteSettingsController::class . ':list')->add(PermissionMiddleware::class)->setName('site_settings/list-site_settings-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{ID}]', SiteSettingsController::class . ':add')->add(PermissionMiddleware::class)->setName('site_settings/add-site_settings-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{ID}]', SiteSettingsController::class . ':view')->add(PermissionMiddleware::class)->setName('site_settings/view-site_settings-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{ID}]', SiteSettingsController::class . ':edit')->add(PermissionMiddleware::class)->setName('site_settings/edit-site_settings-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{ID}]', SiteSettingsController::class . ':delete')->add(PermissionMiddleware::class)->setName('site_settings/delete-site_settings-delete-2'); // delete
        }
    );

    // user_log
    $app->map(["GET","POST","OPTIONS"], '/UserLogList[/{id}]', UserLogController::class . ':list')->add(PermissionMiddleware::class)->setName('UserLogList-user_log-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/UserLogAdd[/{id}]', UserLogController::class . ':add')->add(PermissionMiddleware::class)->setName('UserLogAdd-user_log-add'); // add
    $app->map(["GET","OPTIONS"], '/UserLogView[/{id}]', UserLogController::class . ':view')->add(PermissionMiddleware::class)->setName('UserLogView-user_log-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/UserLogEdit[/{id}]', UserLogController::class . ':edit')->add(PermissionMiddleware::class)->setName('UserLogEdit-user_log-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/UserLogDelete[/{id}]', UserLogController::class . ':delete')->add(PermissionMiddleware::class)->setName('UserLogDelete-user_log-delete'); // delete
    $app->group(
        '/user_log',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{id}]', UserLogController::class . ':list')->add(PermissionMiddleware::class)->setName('user_log/list-user_log-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{id}]', UserLogController::class . ':add')->add(PermissionMiddleware::class)->setName('user_log/add-user_log-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{id}]', UserLogController::class . ':view')->add(PermissionMiddleware::class)->setName('user_log/view-user_log-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{id}]', UserLogController::class . ':edit')->add(PermissionMiddleware::class)->setName('user_log/edit-user_log-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{id}]', UserLogController::class . ':delete')->add(PermissionMiddleware::class)->setName('user_log/delete-user_log-delete-2'); // delete
        }
    );

    // users
    $app->map(["GET","POST","OPTIONS"], '/UsersList[/{ID}]', UsersController::class . ':list')->add(PermissionMiddleware::class)->setName('UsersList-users-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/UsersAdd[/{ID}]', UsersController::class . ':add')->add(PermissionMiddleware::class)->setName('UsersAdd-users-add'); // add
    $app->map(["GET","OPTIONS"], '/UsersView[/{ID}]', UsersController::class . ':view')->add(PermissionMiddleware::class)->setName('UsersView-users-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/UsersEdit[/{ID}]', UsersController::class . ':edit')->add(PermissionMiddleware::class)->setName('UsersEdit-users-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/UsersDelete[/{ID}]', UsersController::class . ':delete')->add(PermissionMiddleware::class)->setName('UsersDelete-users-delete'); // delete
    $app->map(["GET","POST","OPTIONS"], '/UsersSearch', UsersController::class . ':search')->add(PermissionMiddleware::class)->setName('UsersSearch-users-search'); // search
    $app->group(
        '/users',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{ID}]', UsersController::class . ':list')->add(PermissionMiddleware::class)->setName('users/list-users-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{ID}]', UsersController::class . ':add')->add(PermissionMiddleware::class)->setName('users/add-users-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{ID}]', UsersController::class . ':view')->add(PermissionMiddleware::class)->setName('users/view-users-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{ID}]', UsersController::class . ':edit')->add(PermissionMiddleware::class)->setName('users/edit-users-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{ID}]', UsersController::class . ':delete')->add(PermissionMiddleware::class)->setName('users/delete-users-delete-2'); // delete
            $group->map(["GET","POST","OPTIONS"], '/' . Config("SEARCH_ACTION") . '', UsersController::class . ':search')->add(PermissionMiddleware::class)->setName('users/search-users-search-2'); // search
        }
    );

    // user_level2
    $app->map(["GET","POST","OPTIONS"], '/UserLevel2List[/{userlevelid}]', UserLevel2Controller::class . ':list')->add(PermissionMiddleware::class)->setName('UserLevel2List-user_level2-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/UserLevel2Add[/{userlevelid}]', UserLevel2Controller::class . ':add')->add(PermissionMiddleware::class)->setName('UserLevel2Add-user_level2-add'); // add
    $app->map(["GET","OPTIONS"], '/UserLevel2View[/{userlevelid}]', UserLevel2Controller::class . ':view')->add(PermissionMiddleware::class)->setName('UserLevel2View-user_level2-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/UserLevel2Edit[/{userlevelid}]', UserLevel2Controller::class . ':edit')->add(PermissionMiddleware::class)->setName('UserLevel2Edit-user_level2-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/UserLevel2Delete[/{userlevelid}]', UserLevel2Controller::class . ':delete')->add(PermissionMiddleware::class)->setName('UserLevel2Delete-user_level2-delete'); // delete
    $app->group(
        '/user_level2',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{userlevelid}]', UserLevel2Controller::class . ':list')->add(PermissionMiddleware::class)->setName('user_level2/list-user_level2-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{userlevelid}]', UserLevel2Controller::class . ':add')->add(PermissionMiddleware::class)->setName('user_level2/add-user_level2-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{userlevelid}]', UserLevel2Controller::class . ':view')->add(PermissionMiddleware::class)->setName('user_level2/view-user_level2-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{userlevelid}]', UserLevel2Controller::class . ':edit')->add(PermissionMiddleware::class)->setName('user_level2/edit-user_level2-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{userlevelid}]', UserLevel2Controller::class . ':delete')->add(PermissionMiddleware::class)->setName('user_level2/delete-user_level2-delete-2'); // delete
        }
    );

    // user_permission
    $app->map(["GET","POST","OPTIONS"], '/UserPermissionList[/{keys:.*}]', UserPermissionController::class . ':list')->add(PermissionMiddleware::class)->setName('UserPermissionList-user_permission-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/UserPermissionAdd[/{keys:.*}]', UserPermissionController::class . ':add')->add(PermissionMiddleware::class)->setName('UserPermissionAdd-user_permission-add'); // add
    $app->map(["GET","OPTIONS"], '/UserPermissionView[/{keys:.*}]', UserPermissionController::class . ':view')->add(PermissionMiddleware::class)->setName('UserPermissionView-user_permission-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/UserPermissionEdit[/{keys:.*}]', UserPermissionController::class . ':edit')->add(PermissionMiddleware::class)->setName('UserPermissionEdit-user_permission-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/UserPermissionDelete[/{keys:.*}]', UserPermissionController::class . ':delete')->add(PermissionMiddleware::class)->setName('UserPermissionDelete-user_permission-delete'); // delete
    $app->group(
        '/user_permission',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{keys:.*}]', UserPermissionController::class . ':list')->add(PermissionMiddleware::class)->setName('user_permission/list-user_permission-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{keys:.*}]', UserPermissionController::class . ':add')->add(PermissionMiddleware::class)->setName('user_permission/add-user_permission-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{keys:.*}]', UserPermissionController::class . ':view')->add(PermissionMiddleware::class)->setName('user_permission/view-user_permission-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{keys:.*}]', UserPermissionController::class . ':edit')->add(PermissionMiddleware::class)->setName('user_permission/edit-user_permission-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{keys:.*}]', UserPermissionController::class . ':delete')->add(PermissionMiddleware::class)->setName('user_permission/delete-user_permission-delete-2'); // delete
        }
    );

    // event_category
    $app->map(["GET","POST","OPTIONS"], '/EventCategoryList[/{ID}]', EventCategoryController::class . ':list')->add(PermissionMiddleware::class)->setName('EventCategoryList-event_category-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/EventCategoryAdd[/{ID}]', EventCategoryController::class . ':add')->add(PermissionMiddleware::class)->setName('EventCategoryAdd-event_category-add'); // add
    $app->map(["GET","OPTIONS"], '/EventCategoryView[/{ID}]', EventCategoryController::class . ':view')->add(PermissionMiddleware::class)->setName('EventCategoryView-event_category-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/EventCategoryEdit[/{ID}]', EventCategoryController::class . ':edit')->add(PermissionMiddleware::class)->setName('EventCategoryEdit-event_category-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/EventCategoryDelete[/{ID}]', EventCategoryController::class . ':delete')->add(PermissionMiddleware::class)->setName('EventCategoryDelete-event_category-delete'); // delete
    $app->group(
        '/event_category',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{ID}]', EventCategoryController::class . ':list')->add(PermissionMiddleware::class)->setName('event_category/list-event_category-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{ID}]', EventCategoryController::class . ':add')->add(PermissionMiddleware::class)->setName('event_category/add-event_category-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{ID}]', EventCategoryController::class . ':view')->add(PermissionMiddleware::class)->setName('event_category/view-event_category-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{ID}]', EventCategoryController::class . ':edit')->add(PermissionMiddleware::class)->setName('event_category/edit-event_category-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{ID}]', EventCategoryController::class . ':delete')->add(PermissionMiddleware::class)->setName('event_category/delete-event_category-delete-2'); // delete
        }
    );

    // events
    $app->map(["GET","POST","OPTIONS"], '/EventsList[/{ID}]', EventsController::class . ':list')->add(PermissionMiddleware::class)->setName('EventsList-events-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/EventsAdd[/{ID}]', EventsController::class . ':add')->add(PermissionMiddleware::class)->setName('EventsAdd-events-add'); // add
    $app->map(["GET","OPTIONS"], '/EventsView[/{ID}]', EventsController::class . ':view')->add(PermissionMiddleware::class)->setName('EventsView-events-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/EventsEdit[/{ID}]', EventsController::class . ':edit')->add(PermissionMiddleware::class)->setName('EventsEdit-events-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/EventsDelete[/{ID}]', EventsController::class . ':delete')->add(PermissionMiddleware::class)->setName('EventsDelete-events-delete'); // delete
    $app->group(
        '/events',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{ID}]', EventsController::class . ':list')->add(PermissionMiddleware::class)->setName('events/list-events-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{ID}]', EventsController::class . ':add')->add(PermissionMiddleware::class)->setName('events/add-events-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{ID}]', EventsController::class . ':view')->add(PermissionMiddleware::class)->setName('events/view-events-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{ID}]', EventsController::class . ':edit')->add(PermissionMiddleware::class)->setName('events/edit-events-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{ID}]', EventsController::class . ':delete')->add(PermissionMiddleware::class)->setName('events/delete-events-delete-2'); // delete
        }
    );

    // links
    $app->map(["GET","POST","OPTIONS"], '/LinksList[/{ID}]', LinksController::class . ':list')->add(PermissionMiddleware::class)->setName('LinksList-links-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/LinksAdd[/{ID}]', LinksController::class . ':add')->add(PermissionMiddleware::class)->setName('LinksAdd-links-add'); // add
    $app->map(["GET","OPTIONS"], '/LinksView[/{ID}]', LinksController::class . ':view')->add(PermissionMiddleware::class)->setName('LinksView-links-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/LinksEdit[/{ID}]', LinksController::class . ':edit')->add(PermissionMiddleware::class)->setName('LinksEdit-links-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/LinksDelete[/{ID}]', LinksController::class . ':delete')->add(PermissionMiddleware::class)->setName('LinksDelete-links-delete'); // delete
    $app->map(["GET","POST","OPTIONS"], '/LinksSearch', LinksController::class . ':search')->add(PermissionMiddleware::class)->setName('LinksSearch-links-search'); // search
    $app->group(
        '/links',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{ID}]', LinksController::class . ':list')->add(PermissionMiddleware::class)->setName('links/list-links-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{ID}]', LinksController::class . ':add')->add(PermissionMiddleware::class)->setName('links/add-links-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{ID}]', LinksController::class . ':view')->add(PermissionMiddleware::class)->setName('links/view-links-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{ID}]', LinksController::class . ':edit')->add(PermissionMiddleware::class)->setName('links/edit-links-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{ID}]', LinksController::class . ':delete')->add(PermissionMiddleware::class)->setName('links/delete-links-delete-2'); // delete
            $group->map(["GET","POST","OPTIONS"], '/' . Config("SEARCH_ACTION") . '', LinksController::class . ':search')->add(PermissionMiddleware::class)->setName('links/search-links-search-2'); // search
        }
    );

    // photo_galleries
    $app->map(["GET","POST","OPTIONS"], '/PhotoGalleriesList[/{ID}]', PhotoGalleriesController::class . ':list')->add(PermissionMiddleware::class)->setName('PhotoGalleriesList-photo_galleries-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/PhotoGalleriesAdd[/{ID}]', PhotoGalleriesController::class . ':add')->add(PermissionMiddleware::class)->setName('PhotoGalleriesAdd-photo_galleries-add'); // add
    $app->map(["GET","OPTIONS"], '/PhotoGalleriesView[/{ID}]', PhotoGalleriesController::class . ':view')->add(PermissionMiddleware::class)->setName('PhotoGalleriesView-photo_galleries-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/PhotoGalleriesEdit[/{ID}]', PhotoGalleriesController::class . ':edit')->add(PermissionMiddleware::class)->setName('PhotoGalleriesEdit-photo_galleries-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/PhotoGalleriesDelete[/{ID}]', PhotoGalleriesController::class . ':delete')->add(PermissionMiddleware::class)->setName('PhotoGalleriesDelete-photo_galleries-delete'); // delete
    $app->group(
        '/photo_galleries',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config("LIST_ACTION") . '[/{ID}]', PhotoGalleriesController::class . ':list')->add(PermissionMiddleware::class)->setName('photo_galleries/list-photo_galleries-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config("ADD_ACTION") . '[/{ID}]', PhotoGalleriesController::class . ':add')->add(PermissionMiddleware::class)->setName('photo_galleries/add-photo_galleries-add-2'); // add
            $group->map(["GET","OPTIONS"], '/' . Config("VIEW_ACTION") . '[/{ID}]', PhotoGalleriesController::class . ':view')->add(PermissionMiddleware::class)->setName('photo_galleries/view-photo_galleries-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config("EDIT_ACTION") . '[/{ID}]', PhotoGalleriesController::class . ':edit')->add(PermissionMiddleware::class)->setName('photo_galleries/edit-photo_galleries-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config("DELETE_ACTION") . '[/{ID}]', PhotoGalleriesController::class . ':delete')->add(PermissionMiddleware::class)->setName('photo_galleries/delete-photo_galleries-delete-2'); // delete
        }
    );

    // error
    $app->map(["GET","POST","OPTIONS"], '/error', OthersController::class . ':error')->add(PermissionMiddleware::class)->setName('error');

    // personal_data
    $app->map(["GET","POST","OPTIONS"], '/personaldata', OthersController::class . ':personaldata')->add(PermissionMiddleware::class)->setName('personaldata');

    // login
    $app->map(["GET","POST","OPTIONS"], '/login', OthersController::class . ':login')->add(PermissionMiddleware::class)->setName('login');

    // change_password
    $app->map(["GET","POST","OPTIONS"], '/changepassword', OthersController::class . ':changepassword')->add(PermissionMiddleware::class)->setName('changepassword');

    // userpriv
    $app->map(["GET","POST","OPTIONS"], '/userpriv', OthersController::class . ':userpriv')->add(PermissionMiddleware::class)->setName('userpriv');

    // logout
    $app->map(["GET","POST","OPTIONS"], '/logout', OthersController::class . ':logout')->add(PermissionMiddleware::class)->setName('logout');

    // captcha
    $app->map(["GET","OPTIONS"], '/captcha[/{page}]', OthersController::class . ':captcha')->add(PermissionMiddleware::class)->setName('captcha');

    // Swagger
    $app->get('/' . Config("SWAGGER_ACTION"), OthersController::class . ':swagger')->setName(Config("SWAGGER_ACTION")); // Swagger

    // Index
    $app->get('/[index]', OthersController::class . ':index')->add(PermissionMiddleware::class)->setName('index');

    // Route Action event
    if (function_exists(PROJECT_NAMESPACE . "Route_Action")) {
        Route_Action($app);
    }

    /**
     * Catch-all route to serve a 404 Not Found page if none of the routes match
     * NOTE: Make sure this route is defined last.
     */
    $app->map(
        ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
        '/{routes:.+}',
        function ($request, $response, $params) {
            $error = [
                "statusCode" => "404",
                "error" => [
                    "class" => "text-warning",
                    "type" => Container("language")->phrase("Error"),
                    "description" => str_replace("%p", $params["routes"], Container("language")->phrase("PageNotFound")),
                ],
            ];
            Container("flash")->addMessage("error", $error);
            return $response->withStatus(302)->withHeader("Location", GetUrl("error")); // Redirect to error page
        }
    );
};
