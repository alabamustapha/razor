<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home_redirect', 'HomeRedirectController@index')->name('home_redirect');


/* Creation de la route indice de base */
Route::resource('/indicedebase', 'IndiceDeBaseController');


/* Route pour gérer le tarificateur batiment */
Route::get('/tarificateurbatiment/index', [
   'uses' => 'TarificateurBatimentController@index1']);

Route::post('/tarificateurbatiment/result_tarif_batiment', 'TarificateurBatimentController@result_tarif_batiment');


Route::get('/tarificateurbatiment/tarifbat_step2', 'TarificateurBatimentController@step2');

Route::post('/tarificateurbatiment/tarifbat_step3', 'TarificateurBatimentController@step3');

Route::get('/tarificateurbatiment/tarifbat_step4', 'TarificateurBatimentController@step4');

Route::get('/tarificateurbatiment/report', [
    'middleware' => 'isadmin',
    'uses' => 'ReportController@show'])->name('show_report');

Route::get('/tarificateurbatiment/editioncontrat/{id}', [
    'middleware' => 'isadmin',
    'uses' => 'TarificateurBatimentController@edition_contrat'])->name('editioncontrat');
Route::get('/tarificateurolddevis/old_edition_contrat/{id}', [
    'middleware' => 'isadmin',
    'uses' => 'TarificateurOldDevisController@old_edition_contrat'])->name('oldeditioncontrat');

/* Route pour gérer le tarificateur groupama */
Route::get('/tarificateurgroupama/index', 'TarificateurGroupamaController@index');
Route::get('/tarificateurgroupama/nbr_sinistre', 'TarificateurGroupamaController@nbr_sinistre')->name('choixsinistre');
Route::post('/tarificateurgroupama/result_tarificateur_groupama', 'TarificateurGroupamaController@test_result');
Route::post('/tarificateurgroupama/nbr_sinistre_post', 'TarificateurGroupamaController@nbr_sinistre_post');
Route::get('/tarificateurgroupama/tarifgroupama_step2', 'TarificateurGroupamaController@step2');
Route::post('/tarificateurgroupama/tarifgroupama_step3', 'TarificateurGroupamaController@step3');
Route::get('/tarificateurgroupama/tarifgroupama_step4', 'TarificateurGroupamaController@step4');

//////// Page de recherche de l'admin' ///////////
Route::get('/tarificateurbatiment/page_test_search','TarificateurBatimentController@test_search');
Route::post('/tarificateurbatiment/result_search','TarificateurBatimentController@result_test_search');


/////// Route pour gérer les page de modification du tarificateur batiment ////

Route::get('/tarificateurbatiment/modif_batiment_step1/{id}',[
    'uses' => 'TarificateurBatimentController@modif_batiment_step_1'
])->name('modif_batiment_step_1');
Route::post('/tarificateurbatiment/result_tarif_modif', 'TarificateurBatimentController@result_tarif_modif');
Route::post('/tarificateurbatiment/modif_step_1_post/{id}', 'TarificateurBatimentController@modif_step_1_post')->name('modif_step_1_post');

//////// Details devis page home ///////////
Route::get('/tarificateurbatiment/details/{id}', [
    'uses' => 'TarificateurBatimentController@details'])->name('details');
Route::get('/tarificateurolddevis/old_details/{id}', [
    'uses' => 'TarificateurOldDevisController@old_details'])->name('old_details');
Route::post('/tarificateurbatiment/edition_contrat_post/{id}', 'TarificateurBatimentController@edition_contrat_post')->name('editioncontratpost');
Route::post('/tarificateurolddevis/old_edition_contrat_post/{id}', 'TarificateurOldDevisController@old_edition_contrat_post')->name('oldeditioncontratpost');
Route::post('/tarificateurbatiment/edition_contrat_post2/{id}', 'TarificateurBatimentController@edition_contrat_post2')->name('editioncontratpost2');
Route::post('/tarificateurbatiment/edition_contrat_post3/{id}', 'TarificateurBatimentController@edition_contrat_post3')->name('editioncontratpost3');
Route::post('/tarificateurolddevis/old_edition_contrat_post2/{id}', 'TarificateurOldDevisController@old_edition_contrat_post2')->name('oldeditioncontratpost2');
Route::post('/tarificateurbatiment/search_devis_contrat/', 'TarificateurBatimentController@search_devis_contrat');
Route::resource('/tarificateurbatiment', 'TarificateurBatimentController');


/* Route pour gérer les clauses */
Route::resource('/clauses', 'ClausesController');


/* Route for activia products*/ 

Route::get('/activia', 'ActiviaController@index');
Route::post('/activia/result', 'ActiviaController@result');
Route::get('/activia/step2', 'ActiviaController@step2')->name('activia_step2');
Route::post('/activia/step3', 'ActiviaController@step3')->name('activia_step3');
Route::get('/activia/step4', 'ActiviaController@step4')->name('activia_step4');

/* Route pour convertir affilié en courtier */
Route::post('/user/update_afflink_post/{id}', 'UserController@update_afflink_post')->name('update_afflink_post');
Route::post('/user/update_afflink_post2/{id}', 'UserController@update_afflink_post2')->name('update_afflink_post2');

Route::get('/UserController/courtier_affilie/{id}', [
    'uses' => 'UserController@courtier_affilie'
])->name('courtier_affilie');
Route::get('/UserController/convert_to_courtier/{id}', [
   'uses' => 'UserController@convert_affilie_to_courtier'])->name('convert_aff');

Route::get('/UserController/convert_to_affilie/{id}', [
    'uses' => 'UserController@convert_courtier_to_affilie'])->name('convert_courtier');
Route::get('/UserController/test_index',[
    'uses' => 'UserController@test_index'
])->name('test_index');



/* Route pour gérer les users */
Route::resource('/user', 'UserController');


/* Route pour l'admin */
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::resource('/', 'AdminController');
});
/* Export */
Route::get('/tarificateurbatiment/ExportClient', 'ExcelController@ExportClients');

/* FPDF */
///// Devis batiment //////
Route::get('/devis_bat', 'FPDFController@devisbatpdf');
Route::get('/activia_pdf', 'FPDFController@activiapdf');
Route::get('/old_devis_bat','FpdfOldDevisController@olddevisbatpdf');
Route::get('/devis_bat_groupama','PdfGroupamaDevis@devisbatgroupamapdf');
//// Lettre d'envoi //////
Route::get('/letttrepdf', 'FPDFLettreController@letttrepdf');
Route::get('/oldletttrepdf', 'FpdfOldLettreController@oldletttrepdf');
///// attestation //////
Route::get('/attestationpdf', 'FPDFAttestationController@attestationpdf');
Route::get('/oldattestationpdf', 'FpdfOldAttestationController@oldattestationpdf');
///// Autorisation //////
Route::get('/autorisationpdf', 'FPDFAutorisationController@autorisationpdf');
Route::get('/oldautorisationpdf', 'FpdfOldAutorisationController@oldautorisationpdf');
///// Contrat  //////
Route::get('/contratpdf', 'FPDFContratController@contratpdf');
Route::get('/oldcontratpdf', 'FpdfOldContratController@oldcontratpdf');
Route::get('/contratgroupamapdf','PdfGroupamaContratController@contrat_groupama_pdf');

