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

Route::get('/facturar',                      '\App\Http\Controllers\BillingController@generateInvoice');
Route::get('/',                      '\App\Http\Controllers\LoginController@showLoginForm');
Route::post('/login',                '\App\Http\Controllers\LoginController@login');
Route::get('/logout',               array(
                                        'as'                => 'logout',
                                        'uses'              => '\App\Http\Controllers\LoginController@logout'
                                        ));

Route::get('/dashboard',                          '\App\Http\Controllers\DashboardController@dashboard');
Route::post('/dashboardFilter',                   '\App\Http\Controllers\DashboardController@dashboardFilter');
Route::get('/actividad',                          '\App\Http\Controllers\ActivityViewController@activity');
Route::post('/loadPieGraphicTypeActivities',      '\App\Http\Controllers\ActivityViewController@loadPieGraphicTypeActivities');
Route::post('/loadModalSubActivity',              '\App\Http\Controllers\ActivityViewController@loadModalSubActivity');
Route::post('/loadPieGraphicAgents',              '\App\Http\Controllers\ActivityViewController@loadPieGraphicAgents');
Route::post('/loadModalActivityByAgent',          '\App\Http\Controllers\ActivityViewController@loadModalActivityByAgent');
Route::post('/seachArcivityAgent',                '\App\Http\Controllers\ActivityViewController@seachArcivityAgent');
Route::post('/getUsersConect',                    '\App\Http\Controllers\DashboardController@getUsersConect');
Route::post('/getNotification',                   '\App\Http\Controllers\DashboardController@getNotification');
Route::post('/NotificationView',                  '\App\Http\Controllers\DashboardController@NotificationView');
Route::get('/oportunidadesConvertidas',           '\App\Http\Controllers\DashboardController@oportunidadesConvertidas');
Route::get('/oportunidadesAbiertas',              '\App\Http\Controllers\DashboardController@oportunidadesAbiertas');
Route::get('/oportunidadesPerdidas',              '\App\Http\Controllers\DashboardController@oportunidadesPerdidas');
Route::get('/cotizacionesCerradas',               '\App\Http\Controllers\DashboardController@cotizacionesCerradas');
Route::get('/cotizacionesAbiertas',               '\App\Http\Controllers\DashboardController@cotizacionesAbiertas');
Route::get('/cotizacionesDescartadas',            '\App\Http\Controllers\DashboardController@cotizacionesDescartadas');
Route::get('/empresasTipo/{id}',                  '\App\Http\Controllers\DashboardController@empresasTipo');
Route::get('/syncBussines',                       '\App\Http\Controllers\ConnectController@syncBussines');
Route::get('/syncSales',                          '\App\Http\Controllers\ConnectController@syncSales');
Route::get('/syncCources',                        '\App\Http\Controllers\ConnectController@syncCources');
Route::get('/miperfil',                           '\App\Http\Controllers\ProfileController@myProfile');
Route::post('/reloadCuorses',                     '\App\Http\Controllers\DashboardController@reloadCuorses');
Route::post('/actividadSearch',                   '\App\Http\Controllers\ActivityViewController@actividadSearch');

/* CRUD CURSOS */
Route::get('/viewCursos',                     '\App\Http\Controllers\CoursesController@viewCursos');
Route::post('/addCourse',                     '\App\Http\Controllers\CoursesController@addCourse');
Route::post('/viewUpdateCourse',              '\App\Http\Controllers\CoursesController@viewUpdateCourse');
Route::post('/updateCourse',                  '\App\Http\Controllers\CoursesController@updateCourse');
Route::post('/deleteCourse',                  '\App\Http\Controllers\CoursesController@deleteCourse');

/* CRUD CATEGORIAS */
Route::get('/viewCategories',                 '\App\Http\Controllers\CategoriesController@viewCategories');
Route::post('/addCategory',                   '\App\Http\Controllers\CategoriesController@addCategory');
Route::post('/viewupdateCategory',            '\App\Http\Controllers\CategoriesController@viewupdateCategory');
Route::post('/updateCategory',                '\App\Http\Controllers\CategoriesController@updateCategory');
Route::post('/deleteCategory',                '\App\Http\Controllers\CategoriesController@deleteCategory');

/* CRUD TIPOS DE USUARIO */
Route::get('/viewUserType',                   '\App\Http\Controllers\UserTypeController@viewUserType');
Route::post('/addUserType',                   '\App\Http\Controllers\UserTypeController@addUserType');
Route::post('/viewupdateUserType',            '\App\Http\Controllers\UserTypeController@viewupdateUserType');
Route::post('/updateUserType',                '\App\Http\Controllers\UserTypeController@updateUserType');
Route::post('/deleteUserType',                '\App\Http\Controllers\UserTypeController@deleteUserType');

/* CRUD GIROS */
Route::get('/viewCommercialBusiness',          '\App\Http\Controllers\CommercialBusinessController@viewCommercialBusiness');
Route::post('/addCommercialBusiness',          '\App\Http\Controllers\CommercialBusinessController@addCommercialBusiness');
Route::post('/viewupdateCommercialBusiness',   '\App\Http\Controllers\CommercialBusinessController@CommercialBusiness');
Route::post('/updateCommercialBusiness',       '\App\Http\Controllers\CommercialBusinessController@updateCommercialBusiness');
Route::post('/deleteCommercialBusiness',       '\App\Http\Controllers\CommercialBusinessController@deleteCommercialBusiness');

Route::get('/cargarGiros', function () {
    return view('catalogos.cargarGiros');
});

Route::post('/saveMasiveBussinesTypeDB',         '\App\Http\Controllers\CommercialBusinessController@saveMasiveBussinesTypeDB');
/* CRUD TIPOS DE ACTIVIDAD */
Route::get('/viewActivityType',          '\App\Http\Controllers\ActivityTypeController@viewActivityType');
Route::post('/addActivityType',          '\App\Http\Controllers\ActivityTypeController@addActivityType');
Route::post('/viewupdateActivityType',   '\App\Http\Controllers\ActivityTypeController@viewupdateActivityType');
Route::post('/updateActivityType',       '\App\Http\Controllers\ActivityTypeController@updateActivityType');
Route::post('/deleteActivityType',       '\App\Http\Controllers\ActivityTypeController@deleteActivityType');

/* CRUD SUB TIPOS DE ACTIVIDAD */
Route::get('/viewActivitySubtype',          '\App\Http\Controllers\ActivitySubtypeController@viewActivitySubtype');
Route::post('/addActivitySubtype',          '\App\Http\Controllers\ActivitySubtypeController@addActivitySubtype');
Route::post('/viewupdateaddActivitySubtype','\App\Http\Controllers\ActivitySubtypeController@viewupdateaddActivitySubtype');
Route::post('/updateActivitySubtype',       '\App\Http\Controllers\ActivitySubtypeController@updateActivitySubtype');
Route::post('/deleteActivitySubtype',       '\App\Http\Controllers\ActivitySubtypeController@deleteActivitySubtype');

/* CRUD ESTATUS DE LA EMPRESA */
Route::get('/viewBusinessStatus',          '\App\Http\Controllers\BusinessStatusController@viewBusinessStatus');
Route::post('/addBusinessStatus',          '\App\Http\Controllers\BusinessStatusController@addBusinessStatus');
Route::post('/viewupdateBusinessStatus',  '\App\Http\Controllers\BusinessStatusController@BusinessStatus');
Route::post('/updateBusinessStatus',       '\App\Http\Controllers\BusinessStatusController@updateBusinessStatus');
Route::post('/deleteBusinessStatus',       '\App\Http\Controllers\BusinessStatusController@deleteBusinessStatus');

/* CRUD NIVEL DE INTERES */
Route::get('/viewLevelInterest',          '\App\Http\Controllers\LevelInterestController@viewLevelInterest');
Route::post('/addLevelInterest',          '\App\Http\Controllers\LevelInterestController@addLevelInterest');
Route::post('/viewupdateLevelInterest',   '\App\Http\Controllers\LevelInterestController@LevelInterest');
Route::post('/updateLevelInterest',       '\App\Http\Controllers\LevelInterestController@updateLevelInterest');
Route::post('/deleteLevelInterest',       '\App\Http\Controllers\LevelInterestController@deleteLevelInterest');

/* CRUD METODOS DE PAGO */
Route::get('/viewPaymentMethods',          '\App\Http\Controllers\PaymentMethodsController@viewPaymentMethods');
Route::post('/addPaymentMethods',          '\App\Http\Controllers\PaymentMethodsController@addPaymentMethods');
Route::post('/viewupdatePaymentMethods',   '\App\Http\Controllers\PaymentMethodsController@viewupdatePaymentMethods');
Route::post('/updatePaymentMethods',       '\App\Http\Controllers\PaymentMethodsController@updatePaymentMethods');
Route::post('/deletePaymentMethods',       '\App\Http\Controllers\PaymentMethodsController@deletePaymentMethods');

/* CRUD ORIGENES*/
Route::get('/viewOrigin',                '\App\Http\Controllers\BusinessOriginController@viewOrigin');
Route::post('/addBusinessType',          '\App\Http\Controllers\BusinessOriginController@addBusinessType');
Route::post('/viewupdateBusinessType',   '\App\Http\Controllers\BusinessOriginController@viewupdateBusinessType');
Route::post('/updateBusinessType',       '\App\Http\Controllers\BusinessOriginController@updateBusinessType');
Route::post('/deleteBusinessType',       '\App\Http\Controllers\BusinessOriginController@deleteBusinessType');

/* CRUD TIPOS DE EMPRESA */
Route::get('/viewCampaignsType',          '\App\Http\Controllers\CampaignsTypeController@viewCampaignsType');
Route::post('/addCampaignsType',          '\App\Http\Controllers\CampaignsTypeController@addCampaignsType');
Route::post('/viewupdateCampaignsType',   '\App\Http\Controllers\CampaignsTypeController@viewupdateCampaignsType');
Route::post('/updateCampaignsType',       '\App\Http\Controllers\CampaignsTypeController@updateCampaignsType');
Route::post('/pkTypeBusiness',            '\App\Http\Controllers\CampaignsTypeController@pkTypeBusiness');
Route::post('/deleteCampaignsType',       '\App\Http\Controllers\CampaignsTypeController@deleteCampaignsType');


/* CRUD EMPRESAS */
Route::get('/businessCreateView',             '\App\Http\Controllers\BusinessController@businessCreateView');
Route::post('/businessCreateView',            '\App\Http\Controllers\BusinessController@businessCreateView');
Route::post('/getCity',                       '\App\Http\Controllers\BusinessController@getCity');
Route::post('/addbusinessDB',                 '\App\Http\Controllers\BusinessController@addbusinessDB');
Route::get('/verEmpresas',                    '\App\Http\Controllers\BusinessController@viewBussines');
Route::get('/verEmpresasProspecto',           '\App\Http\Controllers\BusinessController@viewBussinesProspect');
Route::get('/verEmpresasCliente',             '\App\Http\Controllers\BusinessController@verEmpresasCliente');
Route::get('/verEmpresasLeads',               '\App\Http\Controllers\BusinessController@verEmpresasLeads');
Route::post('/deleteBusiness',                '\App\Http\Controllers\BusinessController@deleteBusiness');
Route::post('/activeBusiness',                '\App\Http\Controllers\BusinessController@activeBusiness');
Route::post('/viewupdateBusiness',            '\App\Http\Controllers\BusinessController@viewupdateBusiness');
Route::post('/editupdateBusiness',            '\App\Http\Controllers\BusinessController@editupdateBusiness');
Route::post('/viewBusinessContact',           '\App\Http\Controllers\BusinessController@viewBusinessContact');
Route::post('/deleteBusinessContact',         '\App\Http\Controllers\BusinessController@deleteBusinessContact');
Route::post('/addContactBusinessDB',          '\App\Http\Controllers\BusinessController@addContactBusinessDB');
Route::get('/detEmpresa/{id}',                '\App\Http\Controllers\BusinessController@detEmpresa');
Route::post('/searcher',                      '\App\Http\Controllers\BusinessController@searcher');
Route::post('/searcherTextBussines',          '\App\Http\Controllers\BusinessController@searcherTextBussines');
Route::get('/buscar-empresa/{empresa}',       '\App\Http\Controllers\BusinessController@searchBussines')->where(array('empresa'=>'^[a-zA-Z0-9.;_-]+$'));
Route::post('/saveMasiveBussinesDB',          '\App\Http\Controllers\BusinessController@saveMasiveBussinesDB');
Route::get('/descargarCorreos',               '\App\Http\Controllers\BusinessController@viewDowloadEmail');
Route::get('/dowloadBussienes/{giro}/{type}', '\App\Http\Controllers\BusinessController@dowloadBussienes');
Route::post('/searchBusinessByStatus',        '\App\Http\Controllers\BusinessController@searchBusinessByStatus');
Route::post('/searchBusinessByStatusPros',    '\App\Http\Controllers\BusinessController@searchBusinessByStatusPros');
Route::post('/searchBusiness',                '\App\Http\Controllers\BusinessController@searchBusiness');
Route::post('/searchBusinessProspect',        '\App\Http\Controllers\BusinessController@searchBusinessProspect');
Route::post('/searchBusinessLeads',           '\App\Http\Controllers\BusinessController@searchBusinessLeads');
Route::post('/searchBusinessClient',          '\App\Http\Controllers\BusinessController@searchBusinessClient');
Route::post('/updateContact',                 '\App\Http\Controllers\BusinessController@updateContact');
Route::post('/btnUpdateContactDB',            '\App\Http\Controllers\BusinessController@btnUpdateContactDB');
Route::post('/searchTimeLine',                '\App\Http\Controllers\BusinessController@searchTimeLine');
Route::get('/dowloadExcel/{type}',            '\App\Http\Controllers\BusinessController@dowloadExcel');
Route::post('/searchnameBussines',            '\App\Http\Controllers\BusinessController@searchnameBussines');
Route::post('/searchBussinesMoreSale',        '\App\Http\Controllers\BusinessController@searchBussinesMoreSale');

Route::get('/cargarEmpresas', function () {
    return view('empresas.cargarEmpresas');
});

/* CRUD CAMPANAS */
Route::get('/commercialCampaignsCreateView',  '\App\Http\Controllers\CommercialCampaignsController@commercialCampaignsCreateView');
Route::post('/commercialCampaignsCreateDB',  '\App\Http\Controllers\CommercialCampaignsController@commercialCampaignsCreateDB');
Route::get('/commercialCampaignsView',   '\App\Http\Controllers\CommercialCampaignsController@commercialCampaignsView');
Route::get('/commercialCampaignsViewDetail/{campaign}',  '\App\Http\Controllers\CommercialCampaignsController@commercialCampaignsViewDetail');
Route::post('/updateCampaign',            '\App\Http\Controllers\CommercialCampaignsController@updateCampaign');
Route::post('/deleteBusinessCampaign',    '\App\Http\Controllers\CommercialCampaignsController@deleteBusinessCampaign');
Route::post('/updateCampaignDB',          '\App\Http\Controllers\CommercialCampaignsController@updateCampaignDB');
Route::post('/udateBusinessByCampaning',  '\App\Http\Controllers\CommercialCampaignsController@udateBusinessByCampaning');
Route::post('/deleteCampaning',           '\App\Http\Controllers\CommercialCampaignsController@deleteCampaning');
Route::post('/viewCampaningAgent',        '\App\Http\Controllers\CommercialCampaignsController@viewCampaningAgent');

/* CRUD Oportunidadades */
Route::get('/crearOportunidades',     '\App\Http\Controllers\OpportunityController@viewOpportunity');
Route::get('/verOportunidades',       '\App\Http\Controllers\OpportunityController@viewTableOportunity');
Route::post('/addbusinessContactDB',  '\App\Http\Controllers\OpportunityController@addbusinessContactDB');
Route::post('/getContactBussines',    '\App\Http\Controllers\OpportunityController@getContactBussines');
Route::post('/addOportunityDB',       '\App\Http\Controllers\OpportunityController@addOportunityDB');
Route::post('/deleteOportunity',      '\App\Http\Controllers\OpportunityController@deleteOportunity');
Route::post('/updateOportunity',      '\App\Http\Controllers\OpportunityController@updateOportunity');
Route::post('/updateOportunityDB',    '\App\Http\Controllers\OpportunityController@updateOportunityDB');
Route::post('/convertToQuotation',    '\App\Http\Controllers\OpportunityController@convertToQuotation');
Route::post('/convertToQuotationDB',  '\App\Http\Controllers\OpportunityController@convertToQuotationDB');
Route::post('/searchOportunity',      '\App\Http\Controllers\OpportunityController@searchOportunity');
Route::post('/viewDetailOportunity',  '\App\Http\Controllers\OpportunityController@viewDetailOportunity');
Route::post('/getTotalOportunity',    '\App\Http\Controllers\OpportunityController@getTotalOportunity');
Route::post('/getCoursesOportunity',  '\App\Http\Controllers\OpportunityController@getCoursesOportunity');

/* CRUD cotizaciones */
Route::get('/crearCotizaciones',      '\App\Http\Controllers\QuotationController@createOpportunity');
Route::post('/addQuotationDB',       '\App\Http\Controllers\QuotationController@addQuotationDB');
Route::get('/verCotizaciones',       '\App\Http\Controllers\QuotationController@viewQuotation');
Route::post('/deleteQuotation',       '\App\Http\Controllers\QuotationController@deleteQuotation');
Route::post('/viewDetailQuotation',   '\App\Http\Controllers\QuotationController@viewDetailQuotation');
Route::post('/updateQuotation',        '\App\Http\Controllers\QuotationController@updateQuotation');
Route::post('/updateQuotationDB',      '\App\Http\Controllers\QuotationController@updateQuotationDB');
Route::post('/deleteDetailQuotation',  '\App\Http\Controllers\QuotationController@deleteDetailQuotation');
Route::post('/addDetailQuotation',     '\App\Http\Controllers\QuotationController@addDetailQuotation');
Route::post('/updateStatus',           '\App\Http\Controllers\QuotationController@updateStatus');
Route::post('/updateStatusDB',         '\App\Http\Controllers\QuotationController@updateStatusDB');
Route::post('/paymetQuotation',        '\App\Http\Controllers\QuotationController@paymetQuotation');
Route::post('/paymetQuotationDB',      '\App\Http\Controllers\QuotationController@paymetQuotationDB');
Route::get('/viewQuotationFormat/{quotation}', '\App\Http\Controllers\QuotationController@viewQuotationFormat');
Route::get('/viewQuotationFormatOpen/{quotation}', '\App\Http\Controllers\QuotationController@viewQuotationFormatOpen');
Route::get('verCotizacionesFacturar',    '\App\Http\Controllers\QuotationController@verCotizacionesFacturar');
Route::post('/searchQuotations',            '\App\Http\Controllers\QuotationController@searchQuotations');
Route::post('/getPriceQuotation',            '\App\Http\Controllers\QuotationController@getPriceQuotation');
Route::post('/setPaymentInCount',            '\App\Http\Controllers\QuotationController@setPaymentInCount');
Route::get('/prefactura/{id}',             '\App\Http\Controllers\QuotationController@viewPreFacture');
Route::post('/generateInvoice',            '\App\Http\Controllers\QuotationController@generateInvoice');
Route::get('/dowloadPDF/{id}',             '\App\Http\Controllers\QuotationController@dowloadPDF');
Route::get('/dowloadXML/{id}',             '\App\Http\Controllers\QuotationController@dowloadXML');
Route::post('/addpayment',                 '\App\Http\Controllers\QuotationController@addpayment');
Route::post('/addpayment',                 '\App\Http\Controllers\QuotationController@addpayment');
Route::post('/getCoursesQuotation',        '\App\Http\Controllers\QuotationController@getCoursesQuotation');
Route::post('/getCoursesQuotation2',      '\App\Http\Controllers\QuotationController@getCoursesQuotation2');
Route::post('/generateBreakdown',          '\App\Http\Controllers\QuotationController@generateBreakdown');
Route::post('/generateBreakdownDB',        '\App\Http\Controllers\QuotationController@generateBreakdownDB');
Route::post('/removeBreakdown',            '\App\Http\Controllers\QuotationController@removeBreakdown');
Route::post('/sendMailQuotation',          '\App\Http\Controllers\QuotationController@sendMailQuotation');
Route::post('/sendMailQuotationDB',        '\App\Http\Controllers\QuotationController@sendMailQuotationDB');
Route::post('/prefactura',                 '\App\Http\Controllers\QuotationController@prefacture');

/* CRUD NOTIFICACIONES */
Route::get('/alertCreateView',  '\App\Http\Controllers\AlertController@alertCreateView');
Route::post('/createAlertDB',  '\App\Http\Controllers\AlertController@createAlertDB');
Route::get('/alertView',  '\App\Http\Controllers\AlertController@alertView');
Route::post('/deleteAlert',  '\App\Http\Controllers\AlertController@deleteAlert');
Route::post('/updateAlert',  '\App\Http\Controllers\AlertController@updateAlert');
Route::post('/updateAlertDB',  '\App\Http\Controllers\AlertController@updateAlertDB');

/* CRUD ACTIVIDADES */
Route::get('/activityCreateView',  '\App\Http\Controllers\ActivityController@activityCreateView');
Route::post('/selectOportunitiesAndQuotations',  '\App\Http\Controllers\ActivityController@selectOportunitiesAndQuotations');
Route::post('/activityCreateDB',   '\App\Http\Controllers\ActivityController@activityCreateDB');
Route::get('/activityView',        '\App\Http\Controllers\ActivityController@activityView');
Route::post('/deleteAvtivity',     '\App\Http\Controllers\ActivityController@deleteAvtivity');
Route::post('/updateAvtivity',    '\App\Http\Controllers\ActivityController@updateAvtivity');
Route::post('/updateAvtivityDB',  '\App\Http\Controllers\ActivityController@updateAvtivityDB');
Route::post('/finishActivity',    '\App\Http\Controllers\ActivityController@finishActivity');
Route::post('/finishActivityDB',  '\App\Http\Controllers\ActivityController@finishActivityDB');
Route::post('/seachArcivity',     '\App\Http\Controllers\ActivityController@seachArcivity');
Route::post('/seachArcivityText',     '\App\Http\Controllers\ActivityController@seachArcivityText');

/* AGENTES */
Route::get('/salesByAgent',           '\App\Http\Controllers\AgentController@salesByAgent');
Route::get('/viewProfileAgent/{id}',  '\App\Http\Controllers\AgentController@viewProfileAgent');
Route::get('/viewWorkinAgent/{id}/{month}/{year}',  '\App\Http\Controllers\AgentController@viewWorkinAgent');
Route::post('/deleteCalls',           '\App\Http\Controllers\AgentController@deleteCalls');
Route::post('/viewSalesAgent',        '\App\Http\Controllers\AgentController@viewSalesAgent');
Route::post('/viewSalesLostAgent',    '\App\Http\Controllers\AgentController@viewSalesLostAgent');
Route::post('/viewOpenQuotation',     '\App\Http\Controllers\AgentController@viewOpenQuotation');
Route::post('/viewAprovedOportunity', '\App\Http\Controllers\AgentController@viewAprovedOportunity');
Route::post('/viewOpenOportunity',    '\App\Http\Controllers\AgentController@viewOpenOportunity');
Route::post('/viewLossOportunity',    '\App\Http\Controllers\AgentController@viewLossOportunity');
Route::get('/cargarLlamadas', function () {
    return view('agentes.cargarllamada');
});
Route::post('/saveMasiveCallsDB',    '\App\Http\Controllers\AgentController@saveMasiveCallsDB');
Route::post('/filterActivity',       '\App\Http\Controllers\AgentController@filterActivity');

/*Pipeline*/
Route::get('/viewPipeline',           '\App\Http\Controllers\PipelineController@viewPipeline');
Route::post('/addOportunityModal',    '\App\Http\Controllers\PipelineController@addOportunityModal');
Route::get('/AgentPipeline/{id}',     '\App\Http\Controllers\PipelineController@AgentPipeline');

/*Invoice*/
Route::get('/viewInvoice/{quotation}', '\App\Http\Controllers\InvoiceController@viewInvoice');
Route::post('/invoiceQuotation',       '\App\Http\Controllers\InvoiceController@invoiceQuotation');


Route::get('/emailQuotation', function () {
    return view('emails.quotation');
});

/*Calendario*/
Route::get('/calendario',              '\App\Http\Controllers\CalendarController@viewCalendar');
Route::get('/calendario/{moth}',              '\App\Http\Controllers\CalendarController@viewCalendar');
Route::get('/AgentCalendary/{id}',     '\App\Http\Controllers\CalendarController@viewCalendarFilter');

Route::post('/getDaysActivity',       '\App\Http\Controllers\CalendarController@getDaysActivity');
Route::post('/getDetailActivity',     '\App\Http\Controllers\CalendarController@getDetailActivity');
Route::post('/getCreateActivity',     '\App\Http\Controllers\CalendarController@getCreateActivity');

/*Plan de trabajo*/
Route::get('/plandetrabajo',          '\App\Http\Controllers\WorkPlanController@createWorkPlan');
Route::post('/addWorkPlandDB',        '\App\Http\Controllers\WorkPlanController@addWorkPlandDB');
Route::get('/verplandetrabajo',       '\App\Http\Controllers\WorkPlanController@viewWorkPlan');
Route::post('/viewWorkingPlan',       '\App\Http\Controllers\WorkPlanController@viewWorkingPlan');
Route::post('/deleteWorkinPlan',      '\App\Http\Controllers\WorkPlanController@deleteWorkinPlan');
Route::post('/updateWorkinPlan',      '\App\Http\Controllers\WorkPlanController@updateWorkinPlan');
Route::post('/updateWorkinPlanDB',    '\App\Http\Controllers\WorkPlanController@updateWorkinPlanDB');
Route::post('/viewFestiveDays',       '\App\Http\Controllers\WorkPlanController@viewFestiveDays');
Route::post('/deleteDaysWorkin',      '\App\Http\Controllers\WorkPlanController@deleteDaysWorkin');
Route::post('/addDaysWorkin',         '\App\Http\Controllers\WorkPlanController@addDaysWorkin');
Route::post('/addDaysWorkinDB',       '\App\Http\Controllers\WorkPlanController@addDaysWorkinDB');
Route::post('/deleteDaysFestive',     '\App\Http\Controllers\WorkPlanController@deleteDaysFestive');
Route::post('/addDaysFestive',        '\App\Http\Controllers\WorkPlanController@addDaysFestive');
Route::post('/addDaysFestiveDB',      '\App\Http\Controllers\WorkPlanController@addDaysFestiveDB');
Route::post('/viewPermission',        '\App\Http\Controllers\WorkPlanController@viewPermission');
Route::post('/addPermission',         '\App\Http\Controllers\WorkPlanController@addPermission');
Route::post('/addPermissionDB',       '\App\Http\Controllers\WorkPlanController@addPermissionDB');
Route::post('/deletePermission',      '\App\Http\Controllers\WorkPlanController@deletePermission');

/*Bonos*/
Route::get('/bonoBase',               '\App\Http\Controllers\BonusesController@createBonBase');
Route::get('/viwbonosBase',           '\App\Http\Controllers\BonusesController@viewBonBase');
Route::post('/addBono',               '\App\Http\Controllers\BonusesController@addBono');
Route::post('/viewAgentByBono',       '\App\Http\Controllers\BonusesController@viewAgentByBono');
Route::post('/delteBono',             '\App\Http\Controllers\BonusesController@delteBono');
Route::post('/viewUpdateByBono',      '\App\Http\Controllers\BonusesController@viewUpdateByBono');
Route::post('/updateByBono',          '\App\Http\Controllers\BonusesController@updateByBono');
Route::post('/getMontBase',           '\App\Http\Controllers\BonusesController@getMontBase');
Route::post('/searchBonusBase',       '\App\Http\Controllers\BonusesController@searchBonusBase');
Route::post('/getAgent',              '\App\Http\Controllers\BonusesController@getAgent');

Route::get('/bonoRecord',             '\App\Http\Controllers\BonusesController@createBonRecord');
Route::get('/viwbonosRecord',         '\App\Http\Controllers\BonusesController@viewBonoRecord');
Route::post('/addBonoRecord',         '\App\Http\Controllers\BonusesController@addBonoRecord');
Route::post('/viewAgentByBonoRecord', '\App\Http\Controllers\BonusesController@viewAgentByBonoRecord');
Route::post('/delteBonoRecord',       '\App\Http\Controllers\BonusesController@delteBonoRecord');
Route::post('/viewUpdateByBonoRecord','\App\Http\Controllers\BonusesController@viewUpdateByBonoRecord');
Route::post('/updateByBonoRecord',    '\App\Http\Controllers\BonusesController@updateByBonoRecord');
Route::post('/getMontRecord',         '\App\Http\Controllers\BonusesController@getMontRecord');
Route::post('/searchBonusRecord',     '\App\Http\Controllers\BonusesController@searchBonusRecord');

Route::get('/bonoTecho',              '\App\Http\Controllers\BonusesController@createBonTecho');
Route::get('/viwbonosTecho',          '\App\Http\Controllers\BonusesController@viwbonosTecho');
Route::post('/addBonoTecho',          '\App\Http\Controllers\BonusesController@addBonoTecho');
Route::post('/viewAgentBondTecho',    '\App\Http\Controllers\BonusesController@viewAgentBondTecho');
Route::post('/viewUpdateByBonoTecho', '\App\Http\Controllers\BonusesController@viewUpdateByBonoTecho');
Route::post('/updateByBonoTecho',     '\App\Http\Controllers\BonusesController@updateByBonoTecho');
Route::post('/delteBonoTecho',        '\App\Http\Controllers\BonusesController@delteBonoTecho');
Route::post('/getMontTecho',          '\App\Http\Controllers\BonusesController@getMontTecho');
Route::post('/searchBonusTecho',      '\App\Http\Controllers\BonusesController@searchBonusTecho');

/*Comision*/
Route::get('/comision',               '\App\Http\Controllers\BonusesController@createComition');
Route::get('/viewComition',           '\App\Http\Controllers\BonusesController@viewComition');
Route::post('/addcomition',           '\App\Http\Controllers\BonusesController@addcomition');
Route::post('/viewAgentBondComit',    '\App\Http\Controllers\BonusesController@viewAgentBondComit');
Route::post('/viewUpdateByBonoComit', '\App\Http\Controllers\BonusesController@viewUpdateByBonoComit');
Route::post('/updateByBonoComit',     '\App\Http\Controllers\BonusesController@updateByBonoComit');
Route::post('/delteBonoComit',        '\App\Http\Controllers\BonusesController@delteBonoComit');
Route::post('/getMontComition',       '\App\Http\Controllers\BonusesController@getMontComition');
Route::post('/searchBonusComition',   '\App\Http\Controllers\BonusesController@searchBonusComition');
/*Penalizacion*/
Route::get('/penalizacion',           '\App\Http\Controllers\BonusesController@createPenalization');
Route::get('/viewcapacitation',       '\App\Http\Controllers\BonusesController@viewcapacitation');
Route::post('/getCourses',            '\App\Http\Controllers\BonusesController@getCourses');
Route::post('/addCourses',            '\App\Http\Controllers\BonusesController@addCourses');
Route::post('/addMoreCourses',        '\App\Http\Controllers\BonusesController@addMoreCourses');
Route::post('/viewCources',           '\App\Http\Controllers\BonusesController@viewCources');
Route::post('/updateCourseview',      '\App\Http\Controllers\BonusesController@updateCourseview');
Route::post('/deleteCourses',         '\App\Http\Controllers\BonusesController@deleteCourses');
Route::post('/viewUpdateByCourse',    '\App\Http\Controllers\BonusesController@viewUpdateByCourse');
Route::post('/deleteCourseByUser',    '\App\Http\Controllers\BonusesController@deleteCourseByUser');
Route::post('/addDocumentByUser',     '\App\Http\Controllers\BonusesController@addDocumentByUser');
Route::post('/addDocumentByUserDB',   '\App\Http\Controllers\BonusesController@addDocumentByUserDB');
Route::post('/searchCapacitation',    '\App\Http\Controllers\BonusesController@searchCapacitation');
Route::post('/getMontCapacitation',   '\App\Http\Controllers\BonusesController@getMontCapacitation');


/*configuracion llamadas*/
Route::get('/configPrice',            '\App\Http\Controllers\WorkPlanController@configPrice');
Route::post('/configPriceDB',         '\App\Http\Controllers\WorkPlanController@configPriceDB');

/*cargar excel descuentos*/
Route::get('/cargarDescuentos',       '\App\Http\Controllers\WorkPlanController@cargarDescuentos');
Route::post('/deleteProMotion',       '\App\Http\Controllers\WorkPlanController@deleteProMotion');
Route::post('/viewUpdatePromotion',   '\App\Http\Controllers\WorkPlanController@viewUpdatePromotion');
Route::post('/updatePromotion',       '\App\Http\Controllers\WorkPlanController@updatePromotion');
Route::post('/saveMasiveDescDB',      '\App\Http\Controllers\WorkPlanController@saveMasiveDescDB');

/*reenvio de correo*/
Route::get('/viewSendMail',           '\App\Http\Controllers\MailController@viewSendMail');
Route::post('/sendEmail',             '\App\Http\Controllers\MailController@sendEmail');

Route::get('/formatoCotizacion', function () {
    return view('cotizaciones.formatoCotizacion');
});
/* usuarios */

Route::get('/viewCreateUser',         '\App\Http\Controllers\UsersController@viewCreateUser');
Route::post('/addCreateUserDB',       '\App\Http\Controllers\UsersController@addCreateUserDB');
Route::get('/viewUser',               '\App\Http\Controllers\UsersController@viewUser');
Route::post('/deleteUser',            '\App\Http\Controllers\UsersController@deleteUser');
Route::post('/updateUser',            '\App\Http\Controllers\UsersController@updateUser');
Route::post('/updateUserDB',          '\App\Http\Controllers\UsersController@updateUserDB');
Route::post('/updatePermition',       '\App\Http\Controllers\UsersController@updatePermition');
Route::post('/updatePermitionDB',     '\App\Http\Controllers\UsersController@updatePermitionDB');

/* documentos */
Route::get('/viewCreateDocument',     '\App\Http\Controllers\DocumentController@viewCreateDocument');
Route::post('/viewCreateDocumentDB',  '\App\Http\Controllers\DocumentController@viewCreateDocumentDB');
Route::post('/deleteDocument',        '\App\Http\Controllers\DocumentController@deleteDocument');
Route::post('/updateDocument',        '\App\Http\Controllers\DocumentController@updateDocument');
Route::post('/updateDocumentDB',      '\App\Http\Controllers\DocumentController@updateDocumentDB');


/* migracion */
Route::get('/getCourses',             '\App\Http\Controllers\ConnectController@getCourses');
Route::get('/typeUsers',              '\App\Http\Controllers\ConnectController@typeUsers');
Route::get('/Users',                  '\App\Http\Controllers\ConnectController@Users');
Route::get('/Bussinnes',              '\App\Http\Controllers\ConnectController@BussinnesAdd');
Route::get('/addSales',               '\App\Http\Controllers\ConnectController@addSales');
Route::get('/addActivities',          '\App\Http\Controllers\ConnectController@addActivities');


/* llamadas pendientes */
Route::get('/viewPendingCalls',       '\App\Http\Controllers\ActivityController@viewPendingCalls');
Route::post('/searchPendingCalls',    '\App\Http\Controllers\ActivityController@searchPendingCalls');

/*sync buttons*/
Route::get('/syncCRMold',             '\App\Http\Controllers\ConnectController@syncCRMold');
Route::get('/syncCap',                '\App\Http\Controllers\ConnectController@syncCap');

