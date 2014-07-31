<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@getIndex');

// Usuarios
Route::get('/access/{shortName?}', 'UsersController@getMain');
Route::get('/login', 'UsersController@getLogin');
Route::post('/login', 'UsersController@postLogin');
Route::get('/logout', 'UsersController@logout');
Route::get('/register', 'UsersController@getRegister');
Route::post('/register', 'UsersController@postRegister');

// Password
Route::get('password/reset', 'PasswordController@remind');
Route::post('password/reset', 'PasswordController@request');
Route::get('password/reset/{token}', 'PasswordController@reset');
Route::post('password/reset/{token}', 'PasswordController@update');

Route::group(array('before' => 'auth|access'), function()
{
  // Main
	Route::get('main', 'HomeController@getMain');
	
  // Options
  Route::get('options/createDetail', 'OptionsController@createDetail');
  Route::get('options/back', 'OptionsController@back');
  Route::get('options/search', 'OptionsController@getSearch');
	Route::resource('options', 'OptionsController');
  
  // Organizations
  Route::get('organizations/editDetail', 'OrganizationsController@editDetail');
  Route::get('organizations/createDetail', 'OrganizationsController@createDetail');
  Route::get('organizations/back', 'OrganizationsController@back');
  Route::resource('organizations', 'OrganizationsController');

  Route::get('parameters/createDetail', 'ParametersController@createDetail');
  Route::get('parameters/back', 'ParametersController@back');
  Route::get('parameters/search', 'ParametersController@getSearch');
  Route::resource('parameters', 'ParametersController');

  Route::get('organizationParameters/search', 'OrganizationParametersController@getSearch');
  Route::resource('organizationParameters', 'OrganizationParametersController');

  Route::get('userParameters/search', 'UserParametersController@getSearch');
  Route::resource('userParameters', 'UserParametersController');

  // Teams
  Route::get('teams/createDetail', 'TeamsController@createDetail');
  Route::get('teams/back', 'TeamsController@back');
  Route::get('teams/search', 'TeamsController@getSearch');
  Route::resource('teams', 'TeamsController');

  // Users
  Route::get('users/back', 'UsersController@back');
  Route::get('users/changePassword', 'UsersController@changePassword');
  Route::get('users/assignRoles', 'UsersController@assignRoles');
  Route::get('users/assignGroups', 'UsersController@assignGroups');
  Route::get('users/search', 'UsersController@getSearch');
  Route::resource('users', 'UsersController');

  // Groups
  Route::get('groups/editDetail', 'GroupsController@editDetail');
  Route::get('groups/createDetail', 'GroupsController@createDetail');
  Route::get('groups/back', 'GroupsController@back');
  Route::get('groups/assignRoles', 'GroupsController@assignRoles');
  Route::get('groups/assignUsers', 'GroupsController@assignUsers');
  Route::get('groups/search', 'GroupsController@getSearch');
  Route::resource('groups', 'GroupsController');

  // MetaDatas
  Route::get('metaDatas/editDetail', 'MetaDatasController@editDetail');
  Route::get('metaDatas/createDetail', 'MetaDatasController@createDetail');
  Route::get('metaDatas/back', 'MetaDatasController@back');
  Route::get('metaDatas/generate', 'MetaDatasController@generate');
  Route::get('metaDatas/search', 'MetaDatasController@getSearch');
  Route::resource('metaDatas', 'MetaDatasController');

  // Activities
  Route::get('activities/editDetail', 'ActivitiesController@editDetail');
  Route::get('activities/createDetail', 'ActivitiesController@createDetail');
  Route::get('activities/back', 'ActivitiesController@back');
  Route::get('activities/search', 'ActivitiesController@getSearch');
  Route::resource('activities', 'ActivitiesController');

  // Processes
  Route::get('processes/editDetail', 'ProcessesController@editDetail');
  Route::get('processes/createDetail', 'ProcessesController@createDetail');
  Route::get('processes/back', 'ProcessesController@back');
  Route::get('processes/assignActivities', 'ProcessesController@assignActivities');
  Route::get('processes/createByOrganization', 'ProcessesController@createByOrganization');
  Route::get('processes/search', 'ProcessesController@getSearch');
  Route::resource('processes', 'ProcessesController');

  // Roles
  Route::get('roles/editDetail', 'RolesController@editDetail');
  Route::get('roles/createDetail', 'RolesController@createDetail');
  Route::get('roles/back', 'RolesController@back');
  Route::get('roles/assignOptions', 'RolesController@assignOptions');
  Route::get('roles/assignGroups', 'RolesController@assignGroups');
  Route::get('roles/assignUsers', 'RolesController@assignUsers');
  Route::get('roles/search', 'RolesController@getSearch');
  Route::resource('roles', 'RolesController');

  // Clients
  Route::get('clients/createDetail', 'ClientsController@createDetail');
  Route::get('clients/back', 'ClientsController@back');
  Route::get('clients/search', 'ClientsController@getSearch');
  Route::resource('clients', 'ClientsController');

  // Tasks
  Route::post('tasks/execute', 'TasksController@execute');
  Route::post('tasks/terminate', 'TasksController@terminate');
  Route::get('tasks/getTasks', 'TasksController@getTasks');
  Route::get('tasks/loadAssistantDropDown', 'TasksController@loadAssistantDropDown');
  Route::get('tasks/updateDropDown', 'TasksController@updateDropDown');
  Route::get('tasks/fulltextSearch', 'TasksController@fulltextSearch');
  Route::post('tasks/destroyRelated', 'TasksController@destroyRelated');
  Route::post('tasks/editRelated', 'TasksController@editRelated');
  Route::get('tasks/editDetail', 'TasksController@editDetail');
  Route::post('tasks/createRelated', 'TasksController@createRelated');
  Route::get('tasks/createDetail', 'TasksController@createDetail');
  Route::get('tasks/back', 'TasksController@back');
  Route::get('tasks/search', 'TasksController@getSearch');
  Route::resource('tasks', 'TasksController');

  // Databases
  Route::get('databases/editDetail', 'DatabasesController@editDetail');
  Route::get('databases/createDetail', 'DatabasesController@createDetail');
  Route::get('databases/back', 'DatabasesController@back');
  Route::get('databases/search', 'DatabasesController@getSearch');
  Route::resource('databases', 'DatabasesController');

  // Structures
  Route::get('structures/save', 'StructuresController@save');
  Route::get('structures/back', 'StructuresController@back');
  Route::get('structures/search', 'StructuresController@getSearch');
  Route::resource('structures', 'StructuresController');

  // Fields
  Route::get('fields/editDetail', 'FieldsController@editDetail');
  Route::get('fields/createDetail', 'FieldsController@createDetail');
  Route::get('fields/back', 'FieldsController@back');
  Route::get('fields/search', 'FieldsController@getSearch');
  Route::resource('fields', 'FieldsController');

  // Applications
  Route::get('applications/search', 'ApplicationsController@getSearch');
  Route::resource('applications', 'ApplicationsController');

  // Rules
  Route::get('rules/search', 'RulesController@getSearch');
  Route::resource('rules', 'RulesController');

  // Addresses
  Route::get('addresses/editDetail', 'AddressesController@editDetail');
  Route::get('addresses/createDetail', 'AddressesController@createDetail');
  Route::get('addresses/back', 'AddressesController@back');
  Route::get('addresses/search', 'AddressesController@getSearch');
  Route::resource('addresses', 'AddressesController');

  // Locations
  Route::resource('locations', 'LocationsController');

  // Businesses
  Route::get('businesses/editContactsBusiness', 'BusinessesController@editContactsBusiness');
  Route::get('businesses/deleteContactsBusiness', 'BusinessesController@deleteContactsBusiness');
  Route::get('businesses/storeContact', 'BusinessesController@storeContact');
  Route::get('businesses/storeLocation', 'BusinessesController@storeLocation');
  Route::get('businesses/editLocation', 'BusinessesController@editLocation');
  Route::get('businesses/deleteLocation', 'BusinessesController@deleteLocation');
  Route::get('businesses/cancelTabModal/{id_tab}', 'BusinessesController@cancelTabModal');
  Route::get('businesses/assignContact', 'BusinessesController@assignContact');
  Route::get('businesses/assignLocation', 'BusinessesController@assignLocation');
  Route::get('businesses/editDetail', 'BusinessesController@editDetail');
  Route::get('businesses/createDetail', 'BusinessesController@createDetail');
  Route::get('businesses/back', 'BusinessesController@back');
  Route::get('businesses/search', 'BusinessesController@getSearch');
  Route::resource('businesses', 'BusinessesController');

  // Contacts
  Route::get('contacts/search', 'ContactsController@getSearch');
  Route::resource('contacts', 'ContactsController');

  // Orders
  Route::get('orders/search', 'OrdersController@getSearch');
  Route::resource('orders', 'OrdersController');

  // Workflows
  Route::get('workflows/search', 'WorkflowsController@getSearch');
  Route::resource('workflows', 'WorkflowsController');

  // Supervisions
  Route::get('supervisions/search', 'SupervisionsController@getSearch');
  Route::resource('supervisions', 'SupervisionsController');

  // Scorecards
  Route::get('scorecards/search', 'ScorecardsController@getSearch');
  Route::resource('scorecards', 'ScorecardsController');

  // Reports
  Route::get('reports/search', 'ReportsController@getSearch');
  Route::resource('reports', 'ReportsController');
});

