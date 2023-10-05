<?php namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use App\Models\User_type;
use App\Models\Quotation;
use Illuminate\Http\Request;
use App\Permissions\UserPermits;
use App\Helpers\helper;

class DashboardController extends Controller {
    
    private $UserPermits;
    private $helper;

	public function __construct()
        {
            $this->middleware('guest')->except('logout');
            $this->UserPermits = new UserPermits();
            $this->helper = new helper();
        }
        
        public function dashboardFilter(Request $request){
        /* INFORMACION QUE DEPENDE DEL CONECTOR DE ABRVIUS CAPACITACION
         * ventas realizadas (total de cotizaciones cerradas mas ventas directas de la web)
         * historico de ventas por mes (total de cotizaciones cerradas mas ventas directas de la web)
         * cursos mas vendidos (registro de cursos comprados en la web)
         * cursos y lugares (registro de cursos comprados en la web mas lugares de la web y lugares de cotizaciones cerrads)
         * si ya registro una empresa una compra en web se toma y se suma a cliente como empresa en caso que no se haya contado
         */

            $dia = $request->input("day");
            $mes = $request->input("month");
            $anio = $request->input("year");
            $user = $request->input("pkUser");
            $giro = $request->input("pkGiro");
            $campany = $request->input("pkCampanin");
            $fechStart = $request->input("startDay");
            $fechFinish = $request->input("finishDay");

            if (!empty($fechStart) && !empty($fechFinish)) {
                $startDate = $fechStart;
                $endDate = $fechFinish;
            } else {
                if ($dia > 0) {
                    $startDate = date("Y-m-d");
                    $endDate = date("Y-m-d");
                }
                if ($mes > 0) {
                    $startDate = date("Y-m") . "-01";
                    $month = date("Y-m");
                    $aux = date('Y-m-d', strtotime("{$month} + 1 month"));
                    $last_day = date('Y-m-d', strtotime("{$aux} - 1 day"));
                    $endDate = $last_day;
                }
                if ($anio > 0) {
                    $startDate = date("Y") . "-01-01";
                    $endDate = date("Y") . "-12-31";
                }
            }

            $whereFilters               = "";
            $whereFiltersOppotunities   = "";
            
            if ($user > 0) {
                $whereFilters               .= "and quotations.fkUser = " . $user;
                $whereFiltersOppotunities   .= "and o.fkUser = " . $user;
            }

            if ($giro > 0) {
                $whereFilters               .= "and fkComercial_business = " . $giro;
                $whereFiltersOppotunities   .= "and b.fkComercial_business = " . $giro;
            }

            if ($campany > 0) {
                $whereFilters               .= "and fkCampaign = " . $campany;
                $whereFiltersOppotunities   .= "and fkCampaign = " . $campany;
            }


            $quotationsClose = array(); //number, percent, mount
            $quotationsOpen = array();
            $quotationsRejected = array();
            $opportunitiesClose = array(); //number, percent, mount
            $opportunitiesOpen = array();
            $opportunitiesRejected = array();
            $typeBusiness = array();
            $typeCountBusiness = array();
            $contQuotationsTotal = 0;
            $contOpportunitiesTotal = 0;
            $arrayPaymentMethods = array();
            $arrayCategories = array();
            $arrayLevelInterest = array();
            $monthValues = array();
            $monthValuesOport = array();
            $salesTotalArray = array();
            $salesTotalRejectArray = array();
            $totalQuotations = 0;

            $quotationsQuery = DB::select("select "
                            . "pkQuotations, quotations_status, fkBusiness, fkLevel_interest,fkPayment_methods, fkComercial_business, withIva  "
                            . "from quotations "
                            . "INNER JOIN business ON business.pkBusiness = quotations.fkBusiness "
                            . "where quotations.status = 1 and business.status = 1 " . $whereFilters . "  and ((final_date >= '" . $startDate . "' and final_date <= '" . $endDate . "') or (register_day >= '" . $startDate . "' and register_day <= '" . $endDate . "'))");


            $opportunitiesQuery = DB::select("select o.`pkOpportunities`, o.`opportunities_status`, o.`fkBusiness`, o.`fkLevel_interest`, o.`fkPayment_methods`,o.`price_total`,o.`iva` "
                            . "from `opportunities` AS o INNER JOIN business as b ON b.pkBusiness = o.fkBusiness "
                            . "where b.`status` = 1 and o.`status` = 1 and `opportunities_status` != 3 " . $whereFiltersOppotunities . " and o.`status` = 1 and ((o.`final_date` >= '" . $startDate . "' and o.`final_date` <= '" . $endDate . "') or (o.`register_day` >= '" . $startDate . "' and o.`register_day` <= '" . $endDate . "'))");

            $quotationsYearQuery    = DB::select("select "
                            . "`pkQuotations`, `quotations_status`, `fkBusiness`, `fkLevel_interest`, `fkPayment_methods`, `fkComercial_business`, `final_date`, `register_day` , `withIva`"
                            . "from "
                            . "`quotations` "
                            . "INNER JOIN business ON business.pkBusiness = quotations.fkBusiness "
                            . "where "
                            . "quotations.status = 1 " . $whereFilters . " and ((`final_date` >= '".$startDate."' and `final_date` <= '".$endDate."') or (`register_day` >= '".$startDate."' and `register_day` <= '".$endDate."'))");


            $quotationsByMounth = array();
            foreach ($quotationsYearQuery as $quotationsYearInfo) {
                $currentDate = "";
                                
                if($quotationsYearInfo->quotations_status != 4 && $quotationsYearInfo->quotations_status != 5){
                    $currentDate = $quotationsYearInfo->register_day;
                }else{
                    $currentDate = $quotationsYearInfo->final_date;
                }
                                
                $listDate = explode("-", $currentDate);
                                
                if($quotationsYearInfo->quotations_status == 4 || $quotationsYearInfo->quotations_status == 5){
                    
                    if(isset($quotationsByMounth["closed"][$listDate[1]])){
                        $quotationsByMounth["closed"][$listDate[1]]++;
                    }else{
                        $quotationsByMounth["closed"][$listDate[1]] = 1;
                    } 
                                    
                    $quotationsDetailQuerySale  = DB::table('quotations_detail')->select('price','number_places','iva','date')
                                                        ->where('status', '=', 1)
                                                       // ->where('date', '>=', $date)
                                                        ->where('fkQuotations', '=', $quotationsYearInfo->pkQuotations)
                                                        ->where('isSelected', '=', 1)
                                                        ->orderBy("date","asc")
                                                        ->first();
                    if(empty($quotationsDetailQuerySale)) continue;
                
                    if(isset($salesTotalArray[$listDate[1]])){

                        if ($quotationsYearInfo->withIva) {
                            $salesTotalArray[$listDate[1]] = $salesTotalArray[$listDate[1]] + $this->helper->getPriceWithIvaQuotation($quotationsDetailQuerySale->price,$quotationsDetailQuerySale->iva);
                        } else {
                            $salesTotalArray[$listDate[1]] = $salesTotalArray[$listDate[1]] + $quotationsDetailQuerySale->price;
                        }
                                      
                                       
                    }else{

                        if ($quotationsYearInfo->withIva) {
                            $salesTotalArray[$listDate[1]] = $this->helper->getPriceWithIvaQuotation($quotationsDetailQuerySale->price,$quotationsDetailQuerySale->iva);
                        } else {
                            $salesTotalArray[$listDate[1]] = $quotationsDetailQuerySale->price;
                        }
                                       
                    } 
                                    
                }else{

                    if($quotationsYearInfo->quotations_status == 1){
                        
                        if(isset($quotationsByMounth["open"][$listDate[1]])){
                            $quotationsByMounth["open"][$listDate[1]]++;
                        }else{
                            $quotationsByMounth["open"][$listDate[1]] = 1;
                        } 

                    }else{
                        
                        if(isset($quotationsByMounth["rejected"][$listDate[1]])){
                            $quotationsByMounth["rejected"][$listDate[1]]++;
                        }else{
                            $quotationsByMounth["rejected"][$listDate[1]] = 1;
                        } 
                                        
                        $quotationsDetailQuerySale  = DB::table('quotations_detail')->select('price','number_places','iva','date')
                                                            ->where('status', '=', 1)
                                                           // ->where('date', '>=', $date)
                                                            ->where('fkQuotations', '=', $quotationsYearInfo->pkQuotations)
                                                            //->where('isSelected', '=', 1)
                                                            ->orderByRaw("CAST(price AS DECIMAL(10,2)) asc")
                                                            ->first();
                                        
                        if(isset($salesTotalRejectArray[$listDate[1]])){
                            
                            if ($quotationsYearInfo->withIva) {
                                $salesTotalRejectArray[$listDate[1]] = $salesTotalRejectArray[$listDate[1]] + $this->helper->getPriceWithIvaQuotation($quotationsDetailQuerySale->price,$quotationsDetailQuerySale->iva);
                            } else {
                                $salesTotalRejectArray[$listDate[1]] = $salesTotalRejectArray[$listDate[1]] + $quotationsDetailQuerySale->price;
                            }
                                      
                                       
                        }else{
                                        
                            if ($quotationsYearInfo->withIva) {
                                $salesTotalRejectArray[$listDate[1]] = $this->helper->getPriceWithIvaQuotation($quotationsDetailQuerySale->price,$quotationsDetailQuerySale->iva);
                            } else {
                                $salesTotalRejectArray[$listDate[1]] = $quotationsDetailQuerySale->price;
                            }
                        } 
                                        
                    }
                } 
            }

            $businessQuery = DB::table('business')
                    ->select('pkBusiness'
                            , 'name', 'fkCategory')
                    ->where('status', '=', 1)
                    ->where(function ($query) use($startDate, $endDate) {
                        $query->where('date_register', '>=', "" . $startDate . "")
                        ->where('date_register', '<=', "" . $endDate . "");
                    })
                    ->get();

            $categoriesQuery = DB::table('categories')
                    ->select('pkCategory'
                            , 'name')
                    ->where('status', '=', 1)
                    ->get();

            $levelInterestQuery = DB::table('level_interest')
                    ->select('pkLevel_interest'
                            , 'text', 'color')
                    ->where('status', '=', 1)
                    ->get();

            $paymentMethodsQuery = DB::table('payment_methods')
                    ->select('pkPayment_methods'
                            , 'name')
                    ->where('status', '=', 1)
                    ->get();

            foreach ($quotationsQuery as $quotationsInfo) {
                $contQuotationsTotal++;
                $totalQuotations++;

                if ($quotationsInfo->quotations_status == 5) {
                    if (isset($arrayPaymentMethods[$quotationsInfo->fkPayment_methods])) {
                        $arrayPaymentMethods[$quotationsInfo->fkPayment_methods] ++;
                    } else {
                        $arrayPaymentMethods[$quotationsInfo->fkPayment_methods] = 1;
                    }
                }
                
                if($quotationsInfo->quotations_status == 1 || $quotationsInfo->quotations_status == 4){
                    if (isset($arrayLevelInterest[$quotationsInfo->fkLevel_interest])) {
                        $arrayLevelInterest[$quotationsInfo->fkLevel_interest] ++;
                    } else {
                        $arrayLevelInterest[$quotationsInfo->fkLevel_interest] = 1;
                    }
                }
                
                if ($quotationsInfo->quotations_status == 5) {
                    $typeBusiness["client"][$quotationsInfo->fkBusiness] = $quotationsInfo->fkBusiness;
                } else {
                    $typeBusiness["lead"][$quotationsInfo->fkBusiness] = $quotationsInfo->fkBusiness;
                }
                
                if(($quotationsInfo->quotations_status == 1) || ($quotationsInfo->quotations_status == 2) || ($quotationsInfo->quotations_status == 3)){
                    $quotationsDetailQuery = DB::table('quotations_detail')
                        ->select('price', 'number_places', 'iva'
                                , 'date')
                        ->where('status', '=', 1)
                        // ->where('date', '>=', $date)
                        ->where('fkQuotations', '=', $quotationsInfo->pkQuotations)
                        
                        // ->where('isSelected', '=', 1)
                        ->orderByRaw("CAST(price AS DECIMAL(10,2)) asc")
                        ->first();
                }else{
                    $quotationsDetailQuery = DB::table('quotations_detail')
                        ->select('price', 'number_places', 'iva'
                                , 'date')
                        ->where('status', '=', 1)
                        // ->where('date', '>=', $date)
                        ->where('fkQuotations', '=', $quotationsInfo->pkQuotations)
                        ->where('isSelected', '=', 1)
                        ->orderByRaw("CAST(price AS DECIMAL(10,2)) asc")
                        ->first();
                }

                switch ($quotationsInfo->quotations_status) {
                    case '3':
                    case "2":
                        if (isset($quotationsRejected["total"])) {
                            $quotationsRejected["total"] ++;
                        } else {
                            $quotationsRejected["total"] = 1;
                        }

                        if (isset($quotationsRejected["mount"])) {
                            if ($quotationsInfo->withIva) {
                                $quotationsRejected["mount"] = $quotationsRejected["mount"] + $this->helper->getPriceWithIvaQuotation($quotationsDetailQuery->price, $quotationsDetailQuery->iva);
                            } else {
                                $quotationsRejected["mount"] = $quotationsRejected["mount"] + $this->helper->getPriceWithIvaQuotation($quotationsDetailQuery->price, $quotationsDetailQuery->iva);//$quotationsRejected["mount"] + $quotationsDetailQuery->price;
                            }
                        } else {
                            if ($quotationsInfo->withIva) {
                                $quotationsRejected["mount"] = $this->helper->getPriceWithIvaQuotation($quotationsDetailQuery->price, $quotationsDetailQuery->iva);
                            } else {
                                $quotationsRejected["mount"] = $this->helper->getPriceWithIvaQuotation($quotationsDetailQuery->price, $quotationsDetailQuery->iva);//$quotationsDetailQuery->price;
                            }
                        }
                        break;
                    case "1":
                        if (isset($quotationsOpen["total"])) {
                            $quotationsOpen["total"] ++;
                        } else {
                            $quotationsOpen["total"] = 1;
                        }
                        // dd($quotationsDetailQuery);
                        if (isset($quotationsOpen["mount"])) {
                            if ($quotationsInfo->withIva) {
                                $quotationsOpen["mount"] = $quotationsOpen["mount"] + $this->helper->getPriceWithIvaQuotation($quotationsDetailQuery->price, $quotationsDetailQuery->iva);
                            } else {
                                $quotationsOpen["mount"] = $quotationsOpen["mount"] + $this->helper->getPriceWithIvaQuotation($quotationsDetailQuery->price, $quotationsDetailQuery->iva);//$quotationsOpen["mount"] + $quotationsDetailQuery->price;
                            }

                            //  $quotationsOpen["mount"] = 0;
                        } else {
                            if ($quotationsInfo->withIva) {
                                $quotationsOpen["mount"] = $this->helper->getPriceWithIvaQuotation($quotationsDetailQuery->price, $quotationsDetailQuery->iva);
                            } else {
                                $quotationsOpen["mount"] = $this->helper->getPriceWithIvaQuotation($quotationsDetailQuery->price, $quotationsDetailQuery->iva);//$quotationsDetailQuery->price;
                            }

                            // $quotationsOpen["mount"] = 0;
                        }
                        break;
                    case "4":
                        if (isset($quotationsOpen["total"])) {
                            $quotationsOpen["total"] ++;
                        } else {
                            $quotationsOpen["total"] = 1;
                        }
                        // dd($quotationsDetailQuery);
                        if (isset($quotationsOpen["mount"])) {
                            if ($quotationsInfo->withIva) {
                                $quotationsOpen["mount"] = $quotationsOpen["mount"] + $this->helper->getPriceWithIvaQuotation($quotationsDetailQuery->price, $quotationsDetailQuery->iva);
                            } else {
                                $quotationsOpen["mount"] = $quotationsOpen["mount"] + $this->helper->getPriceWithIvaQuotation($quotationsDetailQuery->price, $quotationsDetailQuery->iva);//$quotationsOpen["mount"] + $quotationsDetailQuery->price;
                            }

                            //  $quotationsOpen["mount"] = 0;
                        } else {
                            if ($quotationsInfo->withIva) {
                                $quotationsOpen["mount"] = $this->helper->getPriceWithIvaQuotation($quotationsDetailQuery->price, $quotationsDetailQuery->iva);
                            } else {
                                $quotationsOpen["mount"] = $this->helper->getPriceWithIvaQuotation($quotationsDetailQuery->price, $quotationsDetailQuery->iva);//$quotationsDetailQuery->price;
                            }

                            // $quotationsOpen["mount"] = 0;
                        }
                        break;
                        case "5":
                            if (isset($quotationsClose["total"])) {
                            $quotationsClose["total"] ++;
                        } else {
                            $quotationsClose["total"] = 1;
                        }

                        $quotationsDetailQuerySale = DB::table('quotations_detail')
                                ->select('price', 'number_places'
                                        , 'date')
                                ->where('status', '=', 1)
                                // ->where('date', '>=', $date)
                                ->where('fkQuotations', '=', $quotationsInfo->pkQuotations)
                                ->where('isSelected', '=', 1)
                                ->orderBy("date", "asc")
                                ->first();

                        if (isset($quotationsClose["mount"])) {
                            if ($quotationsInfo->withIva) {
                                $quotationsClose["mount"] = $quotationsClose["mount"] + $this->helper->getPriceWithIvaQuotation($quotationsDetailQuery->price, $quotationsDetailQuery->iva);
                            } else {
                                $quotationsClose["mount"] = $quotationsClose["mount"] + $this->helper->getPriceWithIvaQuotation($quotationsDetailQuery->price, $quotationsDetailQuery->iva);//$quotationsClose["mount"] + $quotationsDetailQuery->price;
                            }
                        } else {
                            if ($quotationsInfo->withIva) {
                                $quotationsClose["mount"] = $this->helper->getPriceWithIvaQuotation($quotationsDetailQuery->price, $quotationsDetailQuery->iva);
                            } else {
                                $quotationsClose["mount"] = $this->helper->getPriceWithIvaQuotation($quotationsDetailQuery->price, $quotationsDetailQuery->iva);//$quotationsDetailQuery->price;
                            }
                        }
                            
                            
                            
                            
                            
                            if (isset($quotationsSales["total"])) {
                            $quotationsSales["total"] ++;
                        } else {
                            $quotationsSales["total"] = 1;
                        }

                        $quotationsDetailQuerySale = DB::table('quotations_detail')
                                ->select('price', 'number_places', 'iva'
                                        , 'date')
                                ->where('status', '=', 1)
                                // ->where('date', '>=', $date)
                                ->where('fkQuotations', '=', $quotationsInfo->pkQuotations)
                                ->where('isSelected', '=', 1)
                                ->first();

                        if (isset($quotationsSales["mount"])) {
                            if ($quotationsInfo->withIva) {
                                $quotationsSales["mount"] = $quotationsSales["mount"] + $this->helper->getPriceWithIvaQuotation($quotationsDetailQuerySale->price, $quotationsDetailQuerySale->iva);
                            } else {
                                $quotationsSales["mount"] = $quotationsSales["mount"] + $this->helper->getPriceWithIvaQuotation($quotationsDetailQuerySale->price, $quotationsDetailQuerySale->iva);//$quotationsSales["mount"] + $quotationsDetailQuerySale->price;
                            }
                        } else {
                            if ($quotationsInfo->withIva) {
                                $quotationsSales["mount"] = $this->helper->getPriceWithIvaQuotation($quotationsDetailQuerySale->price, $quotationsDetailQuerySale->iva);
                            } else {
                                $quotationsSales["mount"] = $this->helper->getPriceWithIvaQuotation($quotationsDetailQuerySale->price, $quotationsDetailQuerySale->iva);//$quotationsDetailQuerySale->price;
                            }
                        }
                        break;
                }
            }
            //dd($quotationsRejected);
            if (isset($quotationsOpen["total"])) {
                $quotationsOpen["percent"] = ($quotationsOpen["total"] / $contQuotationsTotal) * 100;
            } else {
                $quotationsOpen["percent"] = 0;
            }

            if (isset($quotationsRejected["total"])) {
                $quotationsRejected["percent"] = ($quotationsRejected["total"] / $contQuotationsTotal) * 100;
            } else {
                $quotationsRejected["percent"] = 0;
            }

            if (isset($quotationsClose["total"])) {
                $quotationsClose["percent"] = ($quotationsClose["total"] / $contQuotationsTotal) * 100;
            } else {
                $quotationsClose["percent"] = 0;
            }

            foreach ($opportunitiesQuery as $opportunitiesInfo) {
                $contOpportunitiesTotal++;

                if(($opportunitiesInfo->opportunities_status != 2) && ($opportunitiesInfo->opportunities_status != 3)){
                    $typeBusiness["lead"][$opportunitiesInfo->fkBusiness] = $opportunitiesInfo->fkBusiness;
                }

                switch ($opportunitiesInfo->opportunities_status) {
                    case "2":
                        if (isset($opportunitiesRejected["total"])) {
                            $opportunitiesRejected["total"] ++;
                        } else {
                            $opportunitiesRejected["total"] = 1;
                        }

                        if (isset($opportunitiesRejected["mount"])) {
                            $opportunitiesRejected["mount"] = $opportunitiesRejected["mount"] + $this->helper->getPriceWithIvaQuotation($opportunitiesInfo->price_total, $opportunitiesInfo->iva);
                        } else {
                            $opportunitiesRejected["mount"] = $this->helper->getPriceWithIvaQuotation($opportunitiesInfo->price_total, $opportunitiesInfo->iva);
                        }
                        break;
                    case "1":
                        if (isset($opportunitiesOpen["total"])) {
                            $opportunitiesOpen["total"] ++;
                        } else {
                            $opportunitiesOpen["total"] = 1;
                        }

                        if (isset($opportunitiesOpen["mount"])) {

                            $opportunitiesOpen["mount"] = $opportunitiesOpen["mount"] + $this->helper->getPriceWithIvaQuotation($opportunitiesInfo->price_total, $opportunitiesInfo->iva);
                        } else {

                            $opportunitiesOpen["mount"] = $this->helper->getPriceWithIvaQuotation($opportunitiesInfo->price_total, $opportunitiesInfo->iva);
                        }
                        break;
                    case "5":
                        if (isset($opportunitiesClose["total"])) {
                            $opportunitiesClose["total"] ++;
                        } else {
                            $opportunitiesClose["total"] = 1;
                        }

                        if (isset($opportunitiesClose["mount"])) {

                            $opportunitiesClose["mount"] = $opportunitiesClose["mount"] + $this->helper->getPriceWithIvaQuotation($opportunitiesInfo->price_total, $opportunitiesInfo->iva);
                        } else {

                            $opportunitiesClose["mount"] = $this->helper->getPriceWithIvaQuotation($opportunitiesInfo->price_total, $opportunitiesInfo->iva);
                        }
                        break;
                }
            }

            if (isset($opportunitiesRejected["total"])) {
                $opportunitiesRejected["percent"] = ($opportunitiesRejected["total"] / $contOpportunitiesTotal) * 100;
            } else {
                $opportunitiesRejected["percent"] = 0;
            }

            if (isset($opportunitiesOpen["total"])) {
                $opportunitiesOpen["percent"] = ($opportunitiesOpen["total"] / $contOpportunitiesTotal) * 100;
            } else {
                $opportunitiesOpen["percent"] = 0;
            }

            if (isset($opportunitiesClose["total"])) {
                $opportunitiesClose["percent"] = ($opportunitiesClose["total"] / $contOpportunitiesTotal) * 100;
            } else {
                $opportunitiesClose["percent"] = 0;
            }

            foreach ($businessQuery as $businessInfo) {
                if (isset($arrayCategories[$businessInfo->fkCategory])) {
                    $arrayCategories[$businessInfo->fkCategory] ++;
                } else {
                    $arrayCategories[$businessInfo->fkCategory] = 1;
                }

                if (isset($typeBusiness["client"][$businessInfo->pkBusiness])) {
                    if (isset($typeCountBusiness["client"])) {
                        $typeCountBusiness["client"] ++;
                    } else {
                        $typeCountBusiness["client"] = 1;
                    }
                }

                if (isset($typeBusiness["lead"][$businessInfo->pkBusiness])) {
                    if (isset($typeCountBusiness["lead"])) {
                        $typeCountBusiness["lead"] ++;
                    } else {
                        $typeCountBusiness["lead"] = 1;
                    }
                }

                if ((!isset($typeBusiness["client"][$businessInfo->pkBusiness])) && (!isset($typeBusiness["lead"][$businessInfo->pkBusiness]))) {
                    if (isset($typeCountBusiness["prospect"])) {
                        $typeCountBusiness["prospect"] ++;
                    } else {
                        $typeCountBusiness["prospect"] = 1;
                    }
                }
            }

            if (!isset($quotationsSales["total"])) {
                $quotationsSales["total"] = 0;
                $quotationsSales["percent"] = 0;
                $quotationsSales["mount"] = 0;
            }

            if (!isset($quotationsRejected["total"])) {
                $quotationsRejected["total"] = 0;
                $quotationsRejected["percent"] = 0;
                $quotationsRejected["mount"] = 0;
            }

            if (!isset($quotationsOpen["total"])) {
                $quotationsOpen["total"] = 0;
                $quotationsOpen["percent"] = 0;
                $quotationsOpen["mount"] = 0;
            }

            if (!isset($quotationsClose["total"])) {
                $quotationsClose["total"] = 0;
                $quotationsClose["percent"] = 0;
                $quotationsClose["mount"] = 0;
            }

            if (!isset($opportunitiesRejected["total"])) {
                $opportunitiesRejected["total"] = 0;
                $opportunitiesRejected["percent"] = 0;
                $opportunitiesRejected["mount"] = 0;
            }

            if (!isset($opportunitiesOpen["total"])) {
                $opportunitiesOpen["total"] = 0;
                $opportunitiesOpen["percent"] = 0;
                $opportunitiesOpen["mount"] = 0;
            }

            if (!isset($opportunitiesClose["total"])) {
                $opportunitiesClose["total"] = 0;
                $opportunitiesClose["percent"] = 0;
                $opportunitiesClose["mount"] = 0;
            }

            //Faltan cursos y lugares (lugares los puedo obtener del crm cotizaciones cerradas)
            //Cursos se obtiene de la web capacitación
            $salesMount = DB::table('sales')
                    ->select('mont')
                    ->where('status', '=', 1)
                    ->where(function ($query)use($startDate,$endDate) {
                        $query->whereDate('day', '>=', $startDate)
                                ->whereDate('day', '<=', $endDate);
                    })
                    ->sum('mont');

            $salesTotal = DB::table('sales')
                    ->select('mont')
                    ->where('status', '=', 1)
                    ->where(function ($query)use($startDate,$endDate) {
                        $query->whereDate('day', '>=', $startDate)
                                ->whereDate('day', '<=', $endDate);
                    })
                    ->count('pkSales');

            if(isset($quotationsSales["total"])){
                $sales["total"] = $quotationsSales["total"] + $salesTotal;
                        }else{
                    $sales["total"] =  $salesTotal;      
                        }
        
            $sales["percent"] = 100;
        
            if(isset($quotationsSales["total"])){
            $sales["mount"] = $quotationsSales["mount"] + $salesMount;
            }else{
            $sales["mount"] = $salesMount;    
            }

            $arrayMonths = array(   '01' => 'Enero',
                                    '02' => 'Febrero',
                                    '03' => 'Marzo',
                                    '04' => 'Abril',
                                    '05' => 'Mayo',
                                    '06' => 'Junio',
                                    '07' => 'Julio',
                                    '08' => 'Agosto',
                                    '09' => 'Septiembre',
                                    '10' => 'Octubre',
                                    '11' => 'Noviembre',
                                    '12' => 'Diciembre');
            
            foreach ($arrayMonths as $key => $month) {

                if(!isset($quotationsByMounth["closed"][$key])){
                    $quotationsByMounth["closed"][$key] = 0;
                }
                
                if(!isset($quotationsByMounth["open"][$key])){
                    $quotationsByMounth["open"][$key] = 0;
                }
                
                if(!isset($quotationsByMounth["rejected"][$key])){
                    $quotationsByMounth["rejected"][$key] = 0;
                }
                
                //$monthValues[] = "y: '".$month."', a: ".$quotationsByMounth["closed"][$key].", b: ".$quotationsByMounth["open"][$key].", c: ".$quotationsByMounth["rejected"][$key]."";
                $monthValues[] = array(
                    'y' => $month,
                    'a' => $quotationsByMounth["closed"][$key],
                    'b' => $quotationsByMounth["open"][$key],
                    'c' => $quotationsByMounth["rejected"][$key],
                );
                
                if(!isset($opportunitiesByMounth["closed"][$key])){
                    $opportunitiesByMounth["closed"][$key] = 0;
                }
                
                if(!isset($opportunitiesByMounth["open"][$key])){
                    $opportunitiesByMounth["open"][$key] = 0;
                }
                
                if(!isset($opportunitiesByMounth["rejected"][$key])){
                    $opportunitiesByMounth["rejected"][$key] = 0;
                }
                
                $monthValuesOport[] = "y: '".$month."', a: ".$opportunitiesByMounth["closed"][$key].", b: ".$opportunitiesByMounth["open"][$key].", c: ".$opportunitiesByMounth["rejected"][$key]."";
                
                
                if(!isset($salesTotalArray[$key])){
                    $salesTotalArray[$key] = 0;
                }
                
                
                if(!isset($salesTotalRejectArray[$key])){
                    $salesTotalRejectArray[$key] = 0;
                }
                
                $initialMonth = date("Y")."-".$key."-01";
                $finishMonth  = date("Y")."-".$key."-31";

                $salesMount = DB::table('sales')
                        ->select('mont')
                        ->where('status','=',1)
                        ->whereDate('day','>=',$initialMonth)
                        ->whereDate('day','<=',$finishMonth)
                        ->sum('mont');

                $numCourse = Quotation::join("quotations_detail", "quotations.pkQuotations","=", "quotations_detail.fkQuotations")->where([['quotations.quotations_status', 5], ['final_date', '>=', $initialMonth], ['final_date', '<=', $finishMonth]])->count();
                $numPlaces = Quotation::join("quotations_detail", "quotations.pkQuotations","=", "quotations_detail.fkQuotations")->where([['quotations.quotations_status', 5], ['final_date', '>=', $initialMonth], ['final_date', '<=', $finishMonth]])->sum('places');
                /*$numCourse = DB::table('sales')
                        ->select('mont')
                        ->where('status','=',1)
                        ->whereDate('day','>=',$initialMonth)
                        ->whereDate('day','<=',$finishMonth)
                        ->count();*/
                
                /*$numPlaces = DB::table('sales')
                        ->select('mont')
                        ->where('status','=',1)
                        ->whereDate('day','>=',$initialMonth)
                        ->whereDate('day','<=',$finishMonth)
                        ->sum('places');*/
                
                $salesTotalArray[$key] = $salesTotalArray[$key] + $salesMount;
                
                $places_and_courses[$key] = array("courses" => $numCourse ,"places" => $numPlaces);
            }

            $view = view('getInfoDashboard', array(
                'quotationsRejected' => $quotationsRejected,
                'quotationsOpen' => $quotationsOpen,
                'quotationsClose' => $quotationsClose,
                'opportunitiesRejected' => $opportunitiesRejected,
                'opportunitiesOpen' => $opportunitiesOpen,
                'opportunitiesClose' => $opportunitiesClose,
                'arrayPaymentMethods' => $arrayPaymentMethods,
                'categoriesQuery' => $categoriesQuery,
                'levelInterestQuery' => $levelInterestQuery,
                'paymentMethodsQuery' => $paymentMethodsQuery,
                'arrayLevelInterest' => $arrayLevelInterest,
                'arrayCategories' => $arrayCategories,
                'typeCountBusiness' => $typeCountBusiness,
                'monthValues' => $monthValues,
                'monthValuesOport' => $monthValuesOport,
                'sales' => $sales,
                'salesTotal' => $salesTotalArray,
                'salesTotalRejectArray' => $salesTotalRejectArray,
            ))->render();

            return \Response::json(array(
                        "valid" => "true",
                        "view" => $view,
                        "salesTotal" => $salesTotalArray,
                        'salesTotalRejectArray' => $salesTotalRejectArray,
                        "monthValues" => $monthValues,
                        'places_and_courses' => $places_and_courses,
            ));
        }
        
        public function dashboard(){
            $arrayPermition = array();
            $arrayPermition["dashboard"]  = $this->UserPermits->getPermition("dashboard");
            /*INFORMACION QUE DEPENDE DEL CONECTOR DE ABRVIUS CAPACITACION
             * ventas realizadas (total de cotizaciones cerradas mas ventas directas de la web)
             * historico de ventas por mes (total de cotizaciones cerradas mas ventas directas de la web)
             * cursos mas vendidos (registro de cursos comprados en la web)
             * cursos y lugares (registro de cursos comprados en la web mas lugares de la web y lugares de cotizaciones cerrads)
             * si ya registro una empresa una compra en web se toma y se suma a cliente como empresa en caso que no se haya contado
             */   
            $quotationsClose        = array();//number, percent, mount
            $quotationsSales        = array();
            $quotationsOpen         = array();
            $quotationsRejected     = array();
            $opportunitiesClose     = array();//number, percent, mount
            $opportunitiesOpen      = array();
            $opportunitiesRejected  = array();
            $typeBusiness           = array();
            $typeCountBusiness      = array();
            $contQuotationsTotal    = 0;
            $contOpportunitiesTotal = 0;
            $date                   = date("Y-m-d");
            //$startYear              = date("Y")."-01-01";
            //$endYear                = date("Y")."-12-31";
            $startYear              = date("Y")."-".date("m")."-01";
            $endYear                = date("Y")."-".date("m")."-".date('d');
            $month                  = date("Y-m");
            $aux                    = date('Y-m-d', strtotime("{$month} + 1 month"));
            $last_day               = date('Y-m-d', strtotime("{$aux} - 1 day"));
            $startDate              = date("Y-m")."-01";
            $endDate                = $last_day;
            $arrayPaymentMethods    = array();
            $arrayCategories        = array();
            $arrayLevelInterest     = array();
            $monthValues            = array();
            $monthValuesOport       = array();
            $salesTotalArray        = array();
            $salesTotalRejectArray  = array();
            $totalQuotations        = 0;
            $places_and_courses     = array();
            
            
            
            
            $quotationsQuery    = DB::select("select "
                                        . "`pkQuotations`, `quotations_status`, `fkBusiness`, `fkLevel_interest`, `fkPayment_methods` , `withIva`"
                                        . "from `quotations` inner join business on business.pkBusiness = quotations.fkBusiness "
                                        . "where business.`status` = 1 and quotations.`status` = 1 and `quotations_status` != 3 and ((`final_date` >= '".$startDate."' and `final_date` <= '".$endDate."') or (`register_day` >= '".$startDate."' and `register_day` <= '".$endDate."'))");
                                        
            
            $opportunitiesQuery = DB::select("select `pkOpportunities`, `opportunities_status`, `fkBusiness`, `fkLevel_interest`, `fkPayment_methods`,`price_total` ,`iva` "
                                        . "from `opportunities`  inner join business on business.pkBusiness = opportunities.fkBusiness "
                                        . "where business.`status` = 1 and opportunities.`status` = 1 and `opportunities_status` != 3 and ((`final_date` >= '".$startDate."' and `final_date` <= '".$endDate."') or (`register_day` >= '".$startDate."' and `register_day` <= '".$endDate."'))");
            
            
            $businessQuery      = DB::table('business')
                                        ->select('pkBusiness'
                                                ,'name','fkCategory')
                                        ->where('status', '=', 1)
                                        ->where(function ($query) use($startDate, $endDate) {
                                            $query->where('date_register', '>=', "".$startDate."")
                                                  ->where('date_register', '<=', "".$endDate."");
                                        })
                                        ->get();  
            
            $categoriesQuery      = DB::table('categories')
                                        ->select('pkCategory'
                                                ,'name')
                                        ->where('status', '=', 1)
                                        ->get(); 
            
            $levelInterestQuery      = DB::table('level_interest')
                                        ->select('pkLevel_interest'
                                                ,'text','color')
                                        ->where('status', '=', 1)
                                        ->get(); 
            
            $paymentMethodsQuery      = DB::table('payment_methods')
                                        ->select('pkPayment_methods'
                                                ,'name')
                                        ->where('status', '=', 1)
                                        ->get();
            
            foreach ($quotationsQuery as $quotationsInfo) {
                $contQuotationsTotal++;
                $totalQuotations++;
                
                if($quotationsInfo->quotations_status == 5){
                    if(isset($arrayPaymentMethods[$quotationsInfo->fkPayment_methods])){
                        $arrayPaymentMethods[$quotationsInfo->fkPayment_methods]++;
                    }else{
                        $arrayPaymentMethods[$quotationsInfo->fkPayment_methods] = 1;
                    }
                }
                
                if($quotationsInfo->quotations_status == 1 || $quotationsInfo->quotations_status == 4){
                    if(isset($arrayLevelInterest[$quotationsInfo->fkLevel_interest])){
                        $arrayLevelInterest[$quotationsInfo->fkLevel_interest]++;
                    }else{
                        $arrayLevelInterest[$quotationsInfo->fkLevel_interest] = 1;
                    }
                }
                
                
                if($quotationsInfo->quotations_status == 5){
                    $typeBusiness["client"][$quotationsInfo->fkBusiness] = $quotationsInfo->fkBusiness;
                }else{
                    $typeBusiness["lead"][$quotationsInfo->fkBusiness] = $quotationsInfo->fkBusiness;
                }
                   
                if(($quotationsInfo->quotations_status == 1) || ($quotationsInfo->quotations_status == 2)){
                    $quotationsDetailQuery  = DB::table('quotations_detail')
                                                    ->select('price','number_places','iva'
                                                            ,'date')
                                                    ->where('status', '=', 1)
                                                   // ->where('date', '>=', $date)
                                                    ->where('fkQuotations', '=', $quotationsInfo->pkQuotations)
                                                   // ->where('isSelected', '=', 1)
                                                    
                                                    ->orderByRaw("CAST(price AS DECIMAL(10,2)) asc")
                                                    ->first(); 
                }else{
                    $quotationsDetailQuery  = DB::table('quotations_detail')
                                                    ->select('price','number_places','iva'
                                                            ,'date')
                                                    ->where('status', '=', 1)
                                                   // ->where('date', '>=', $date)
                                                    ->where('fkQuotations', '=', $quotationsInfo->pkQuotations)
                                                    ->where('isSelected', '=', 1)
                                                    ->orderByRaw("CAST(price AS DECIMAL(10,2)) asc")
                                                    ->first(); 
                }
                
                
                
                switch ($quotationsInfo->quotations_status) {
                    case "2":
                        if (isset($quotationsRejected["total"])) {
                        $quotationsRejected["total"] ++;
                    } else {
                        $quotationsRejected["total"] = 1;
                    }

                    if (isset($quotationsRejected["mount"])) {

                        if ($quotationsInfo->withIva) {
                            $quotationsRejected["mount"] = $quotationsRejected["mount"] + $this->helper->getPriceWithIvaQuotation($quotationsDetailQuery->price, $quotationsDetailQuery->iva);
                        } else {
                            $quotationsRejected["mount"] = $quotationsRejected["mount"] + $this->helper->getPriceWithIvaQuotation($quotationsDetailQuery->price, $quotationsDetailQuery->iva);//$quotationsRejected["mount"] + $quotationsDetailQuery->price;
                        }
                    } else {
                        if ($quotationsInfo->withIva) {
                            $quotationsRejected["mount"] = $this->helper->getPriceWithIvaQuotation($quotationsDetailQuery->price, $quotationsDetailQuery->iva);
                        } else {
                            $quotationsRejected["mount"] = $this->helper->getPriceWithIvaQuotation($quotationsDetailQuery->price, $quotationsDetailQuery->iva);//$quotationsDetailQuery->price;
                        }
                    }
                    break;
                    case "1":
                        if(isset($quotationsOpen["total"])){
                            $quotationsOpen["total"]++;
                        }else{
                            $quotationsOpen["total"] = 1;
                        }
                        
                        if(isset($quotationsOpen["mount"])){
                            
                             if ($quotationsInfo->withIva) {
                            $quotationsOpen["mount"] = $quotationsOpen["mount"] + $this->helper->getPriceWithIvaQuotation($quotationsDetailQuery->price, $quotationsDetailQuery->iva);
                        } else {
                            $quotationsOpen["mount"] = $quotationsOpen["mount"] + $this->helper->getPriceWithIvaQuotation($quotationsDetailQuery->price, $quotationsDetailQuery->iva);//$quotationsOpen["mount"] + $quotationsDetailQuery->price;
                        }
                        //  $quotationsOpen["mount"] = 0;
                    } else {

                        if ($quotationsInfo->withIva) {
                            $quotationsOpen["mount"] = $this->helper->getPriceWithIvaQuotation($quotationsDetailQuery->price, $quotationsDetailQuery->iva);
                        } else {
                            $quotationsOpen["mount"] = $this->helper->getPriceWithIvaQuotation($quotationsDetailQuery->price, $quotationsDetailQuery->iva); //$quotationsDetailQuery->price;
                        }
                        //  $quotationsOpen["mount"] = 0;
                    }
                    break;
                    case "4":
                        if(isset($quotationsOpen["total"])){
                            $quotationsOpen["total"]++;
                        }else{
                            $quotationsOpen["total"] = 1;
                        }
                        
                        if(isset($quotationsOpen["mount"])){
                            
                             if ($quotationsInfo->withIva) {
                            $quotationsOpen["mount"] = $quotationsOpen["mount"] + $this->helper->getPriceWithIvaQuotation($quotationsDetailQuery->price, $quotationsDetailQuery->iva);
                        } else {
                            $quotationsOpen["mount"] = $quotationsOpen["mount"] + $this->helper->getPriceWithIvaQuotation($quotationsDetailQuery->price, $quotationsDetailQuery->iva);//$quotationsOpen["mount"] + $quotationsDetailQuery->price;
                        }
                        //  $quotationsOpen["mount"] = 0;
                    } else {

                        if ($quotationsInfo->withIva) {
                            $quotationsOpen["mount"] = $this->helper->getPriceWithIvaQuotation($quotationsDetailQuery->price, $quotationsDetailQuery->iva);
                        } else {
                            $quotationsOpen["mount"] = $this->helper->getPriceWithIvaQuotation($quotationsDetailQuery->price, $quotationsDetailQuery->iva);//$quotationsDetailQuery->price;
                        }
                        //  $quotationsOpen["mount"] = 0;
                    }
                    break;
                    
                     case "5":
                         //**** COTIZACIONES PAGADAS PARA CUADRO DE DASHBOARD
                         if (isset($quotationsClose["total"])) {
                        $quotationsClose["total"] ++;
                    } else {
                        $quotationsClose["total"] = 1;
                    }

                    $quotationsDetailQuerySale = DB::table('quotations_detail')
                            ->select('price', 'number_places', 'iva'
                                    , 'date')
                            ->where('status', '=', 1)
                            // ->where('date', '>=', $date)
                            ->where('fkQuotations', '=', $quotationsInfo->pkQuotations)
                            ->where('isSelected', '=', 1)
                            ->orderBy("date", "asc")
                            ->first();

			    if(empty($quotationsDetailQuerySale)) return;

                    if (isset($quotationsClose["mount"])) {
                        if ($quotationsInfo->withIva) {
                            $quotationsClose["mount"] = $quotationsClose["mount"] + $this->helper->getPriceWithIvaQuotation($quotationsDetailQuerySale->price, $quotationsDetailQuerySale->iva);
                        } else {
                            $quotationsClose["mount"] = $quotationsClose["mount"] + $this->helper->getPriceWithIvaQuotation($quotationsDetailQuerySale->price, $quotationsDetailQuerySale->iva);//$quotationsClose["mount"] + $quotationsDetailQuerySale->price;
                        }
                    } else {
                        if ($quotationsInfo->withIva) {
                            $quotationsClose["mount"] = $this->helper->getPriceWithIvaQuotation($quotationsDetailQuerySale->price, $quotationsDetailQuerySale->iva);
                        } else {
                            $quotationsClose["mount"] = $this->helper->getPriceWithIvaQuotation($quotationsDetailQuerySale->price, $quotationsDetailQuerySale->iva);//$quotationsDetailQuerySale->price;
                        }
                    }
                    //**** COTIZACIONES PAGADAS     
   
                         
                    //**** COTIZACIONES PAGADAS PARA CUADRO DE DASHBOARD VENTAS OJO! FALTA INCLUIR LAS VENTAS DE CAPACITACION     
                    if (isset($quotationsSales["total"])) {
                        $quotationsSales["total"] ++;
                    } else {
                        $quotationsSales["total"] = 1;
                    }

                    $quotationsDetailQuerySale = DB::table('quotations_detail')
                            ->select('price', 'number_places', 'iva'
                                    , 'date')
                            ->where('status', '=', 1)
                            // ->where('date', '>=', $date)
                            ->where('fkQuotations', '=', $quotationsInfo->pkQuotations)
                            ->where('isSelected', '=', 1)
                            ->orderBy("date", "asc")
                            ->first();

                    if (isset($quotationsSales["mount"])) {
                        if ($quotationsInfo->withIva) {
                            $quotationsSales["mount"] = $quotationsSales["mount"] + $this->helper->getPriceWithIvaQuotation($quotationsDetailQuerySale->price, $quotationsDetailQuerySale->iva);
                        } else {
                            $quotationsSales["mount"] = $quotationsSales["mount"] + $this->helper->getPriceWithIvaQuotation($quotationsDetailQuerySale->price, $quotationsDetailQuerySale->iva);//$quotationsSales["mount"] + $quotationsDetailQuerySale->price;
                        }
                    } else {
                        if ($quotationsInfo->withIva) {
                            $quotationsSales["mount"] = $this->helper->getPriceWithIvaQuotation($quotationsDetailQuerySale->price, $quotationsDetailQuerySale->iva);
                        } else {
                            $quotationsSales["mount"] = $this->helper->getPriceWithIvaQuotation($quotationsDetailQuerySale->price, $quotationsDetailQuerySale->iva); //$quotationsDetailQuerySale->price;
                        }
                    }
                    break;
            }
            }
            
            if(isset($quotationsOpen["total"])){
                $quotationsOpen["percent"] = ($quotationsOpen["total"] / $contQuotationsTotal) * 100;
            }else{
                $quotationsOpen["percent"] = 0;
            }
            
            if(isset($quotationsRejected["total"])){
                $quotationsRejected["percent"] = ($quotationsRejected["total"] / $contQuotationsTotal) * 100;
            }else{
                $quotationsRejected["percent"] = 0;
            }
            
            if(isset($quotationsClose["total"])){
                $quotationsClose["percent"] = ($quotationsClose["total"] / $contQuotationsTotal) * 100;
            }else{
                $quotationsClose["percent"] = 0;
            }
            
            foreach ($opportunitiesQuery as $opportunitiesInfo) {
                $contOpportunitiesTotal++;
                
                if(($opportunitiesInfo->opportunities_status != 2) && ($opportunitiesInfo->opportunities_status != 3)){
                    $typeBusiness["lead"][$opportunitiesInfo->fkBusiness] = $opportunitiesInfo->fkBusiness; 
                }
                
                switch ($opportunitiesInfo->opportunities_status) {
                    case "2":
                        if (isset($opportunitiesRejected["total"])) {
                        $opportunitiesRejected["total"] ++;
                    } else {
                        $opportunitiesRejected["total"] = 1;
                    }

                    if (isset($opportunitiesRejected["mount"])) {
                            $opportunitiesRejected["mount"] = $opportunitiesRejected["mount"] + $this->helper->getPriceWithIvaQuotation($opportunitiesInfo->price_total, $opportunitiesInfo->iva);
                    } else {
                            $opportunitiesRejected["mount"] = $this->helper->getPriceWithIvaQuotation($opportunitiesInfo->price_total, $opportunitiesInfo->iva);
                       
                    }
                    break;
                    case "1":
                        if(isset($opportunitiesOpen["total"])){
                            $opportunitiesOpen["total"]++;
                        }else{
                            $opportunitiesOpen["total"] = 1;
                        }
                        
                        if(isset($opportunitiesOpen["mount"])){
                            $opportunitiesOpen["mount"] = $opportunitiesOpen["mount"] + $this->helper->getPriceWithIvaQuotation($opportunitiesInfo->price_total,$opportunitiesInfo->iva);
    
                        }else{
                           $opportunitiesOpen["mount"] = $this->helper->getPriceWithIvaQuotation($opportunitiesInfo->price_total,$opportunitiesInfo->iva);
                        }
                        break;
                    case "5":
                        if (isset($opportunitiesClose["total"])) {
                        $opportunitiesClose["total"] ++;
                    } else {
                        $opportunitiesClose["total"] = 1;
                    }

                    if (isset($opportunitiesClose["mount"])) {
                            $opportunitiesClose["mount"] = $opportunitiesClose["mount"] + $this->helper->getPriceWithIvaQuotation($opportunitiesInfo->price_total, $opportunitiesInfo->iva);
                    } else {
                            $opportunitiesClose["mount"] = $this->helper->getPriceWithIvaQuotation($opportunitiesInfo->price_total, $opportunitiesInfo->iva);
                       
                    }
                    break;
                }
                }
            
                if(isset($opportunitiesRejected["total"])){
                    $opportunitiesRejected["percent"] = ($opportunitiesRejected["total"] / $contOpportunitiesTotal) * 100;
                }else{
                    $opportunitiesRejected["percent"] = 0;
                }
                
                if(isset($opportunitiesOpen["total"])){
                    $opportunitiesOpen["percent"] = ($opportunitiesOpen["total"] / $contOpportunitiesTotal) * 100;
                }else{
                    $opportunitiesOpen["percent"] = 0;
                }
                
                if(isset($opportunitiesClose["total"])){
                    $opportunitiesClose["percent"] = ($opportunitiesClose["total"] / $contOpportunitiesTotal) * 100;
                }else{
                    $opportunitiesClose["percent"] = 0;
                }
            
                foreach ($businessQuery as $businessInfo) {
                    if(isset($arrayCategories[$businessInfo->fkCategory])){
                        $arrayCategories[$businessInfo->fkCategory]++;
                    }else{
                        $arrayCategories[$businessInfo->fkCategory] = 1;
                    }
                    
                    if(isset($typeBusiness["client"][$businessInfo->pkBusiness])){
                        if(isset($typeCountBusiness["client"])){
                            $typeCountBusiness["client"]++;
                        }else{
                            $typeCountBusiness["client"] = 1;
                        }
                    }
                    
                    if(isset($typeBusiness["lead"][$businessInfo->pkBusiness])){
                        if(isset($typeCountBusiness["lead"])){
                            $typeCountBusiness["lead"]++;
                        }else{
                            $typeCountBusiness["lead"] = 1;
                        }
                    }
                
                    if((!isset($typeBusiness["client"][$businessInfo->pkBusiness])) && (!isset($typeBusiness["lead"][$businessInfo->pkBusiness]))){
                        if(isset($typeCountBusiness["prospect"])){
                            $typeCountBusiness["prospect"]++;
                        }else{
                            $typeCountBusiness["prospect"] = 1;
                        }
                }
            }
            
            
            $quotationsYearQuery    = DB::select("select "
                                            . "`pkQuotations`, `quotations_status`, `fkBusiness`, `fkLevel_interest`, `fkPayment_methods`, `final_date`, `register_day` , `withIva`"
                                            . "from "
                                            . "`quotations` "
                                            . "where "
                                            . "`status` = 1 and ((`final_date` >= '".$startYear."' and `final_date` <= '".$endYear."') or (`register_day` >= '".$startYear."' and `register_day` <= '".$endYear."'))");
             
            $opportunitiesYearQuery = DB::select("select `pkOpportunities`, `opportunities_status`, `fkBusiness`, `fkLevel_interest`, `fkPayment_methods`, `final_date`, `register_day` "
                                            . "from `opportunities` "
                                            . "where `status` = 1 and `status` = 1 and ((`final_date` >= '".$startYear."' and `final_date` <= '".$endYear."') or (`register_day` >= '".$startYear."' and `register_day` <= '".$endYear."'))");
            
        
              $quotationsByMounth = array();

            foreach ($quotationsYearQuery as $quotationsYearInfo) {
                $currentDate = "";
                
                if($quotationsYearInfo->quotations_status != 4 && $quotationsYearInfo->quotations_status != 5){
                    $currentDate = $quotationsYearInfo->register_day;
                }else{
                    $currentDate = $quotationsYearInfo->final_date;
                }
                
                $listDate = explode("-", $currentDate);
                
                if($quotationsYearInfo->quotations_status == 4 || $quotationsYearInfo->quotations_status == 5){
                    if(isset($quotationsByMounth["closed"][$listDate[1]])){
                        
                        $quotationsByMounth["closed"][$listDate[1]]++;
                    }else{
                        $quotationsByMounth["closed"][$listDate[1]] = 1;
                    } 
                    
                     $quotationsDetailQuerySale  = DB::table('quotations_detail')
                                                    ->select('price','number_places','iva'
                                                            ,'date')
                                                    ->where('status', '=', 1)
                                                   // ->where('date', '>=', $date)
                                                    ->where('fkQuotations', '=', $quotationsYearInfo->pkQuotations)
                                                    ->where('isSelected', '=', 1)
                                                    ->orderBy("date","asc")
                                                    ->first();
                     if(empty($quotationsDetailQuerySale)) continue;

                     if(isset($salesTotalArray[$listDate[1]])){
                         if ($quotationsYearInfo->withIva) {
                          $salesTotalArray[$listDate[1]] = $salesTotalArray[$listDate[1]] + $this->helper->getPriceWithIvaQuotation($quotationsDetailQuerySale->price,$quotationsDetailQuerySale->iva);
                        } else {
                          $salesTotalArray[$listDate[1]] = $salesTotalArray[$listDate[1]] + $quotationsDetailQuerySale->price;
                        }
                      
                       
                    }else{
                        if ($quotationsYearInfo->withIva) {
                           $salesTotalArray[$listDate[1]] = $this->helper->getPriceWithIvaQuotation($quotationsDetailQuerySale->price,$quotationsDetailQuerySale->iva);
                        } else {
                          $salesTotalArray[$listDate[1]] = $quotationsDetailQuerySale->price;
                        }
                       
                    } 
                    
                }else{
                    if($quotationsYearInfo->quotations_status == 1){
                        if(isset($quotationsByMounth["open"][$listDate[1]])){
                            $quotationsByMounth["open"][$listDate[1]]++;
                        }else{
                            $quotationsByMounth["open"][$listDate[1]] = 1;
                        } 
                    }else{
                        if(isset($quotationsByMounth["rejected"][$listDate[1]])){
                            $quotationsByMounth["rejected"][$listDate[1]]++;
                        }else{
                            $quotationsByMounth["rejected"][$listDate[1]] = 1;
                        } 
                        
                        $quotationsDetailQuerySale  = DB::table('quotations_detail')
                                                    ->select('price','number_places','iva'
                                                            ,'date')
                                                    ->where('status', '=', 1)
                                                   // ->where('date', '>=', $date)
                                                    ->where('fkQuotations', '=', $quotationsYearInfo->pkQuotations)
                                                    //->where('isSelected', '=', 1)
                                                    ->orderByRaw("CAST(price AS DECIMAL(10,2)) asc")
                                                    ->first();
                        
                         if(isset($salesTotalRejectArray[$listDate[1]])){
                              if ($quotationsYearInfo->withIva) {
                           $salesTotalRejectArray[$listDate[1]] = $salesTotalRejectArray[$listDate[1]] + $this->helper->getPriceWithIvaQuotation($quotationsDetailQuerySale->price,$quotationsDetailQuerySale->iva);
                        } else {
                           $salesTotalRejectArray[$listDate[1]] = $salesTotalRejectArray[$listDate[1]] + $quotationsDetailQuerySale->price;
                        }
                      
                       
                    }else{
                          if ($quotationsYearInfo->withIva) {
                         $salesTotalRejectArray[$listDate[1]] = $this->helper->getPriceWithIvaQuotation($quotationsDetailQuerySale->price,$quotationsDetailQuerySale->iva);
                        } else {
                         $salesTotalRejectArray[$listDate[1]] = $quotationsDetailQuerySale->price;
                        }
                        
                    } 
                        
                    }
                } 
            }
            
            $opportunitiesByMounth = array();                            
                                        
            foreach ($opportunitiesYearQuery as $opportunitiesYearInfo) {
                $currentDate = "";
                
                if($opportunitiesYearInfo->opportunities_status != 5){
                    $currentDate = $opportunitiesYearInfo->register_day;
                }else{
                    $currentDate = $opportunitiesYearInfo->final_date;
                }
                
                $listDate = explode("-", $currentDate);
                
                if($opportunitiesYearInfo->opportunities_status == 5){
                    if(isset($opportunitiesByMounth["closed"][$listDate[1]])){
                        $opportunitiesByMounth["closed"][$listDate[1]]++;
                    }else{
                        $opportunitiesByMounth["closed"][$listDate[1]] = 1;
                    } 
                }else{
                    if($opportunitiesYearInfo->opportunities_status == 1){
                        if(isset($opportunitiesByMounth["open"][$listDate[1]])){
                            $opportunitiesByMounth["open"][$listDate[1]]++;
                        }else{
                            $opportunitiesByMounth["open"][$listDate[1]] = 1;
                        } 
                    }else{
                        if(isset($opportunitiesByMounth["rejected"][$listDate[1]])){
                            $opportunitiesByMounth["rejected"][$listDate[1]]++;
                        }else{
                            $opportunitiesByMounth["rejected"][$listDate[1]] = 1;
                        } 
                    }
                } 
            }
            
            if(!isset($quotationsRejected["total"])){
                $quotationsRejected["total"] = 0;
                $quotationsRejected["percent"] = 0;
                $quotationsRejected["mount"] = 0;
            }
            
            if(!isset($quotationsOpen["total"])){
                $quotationsOpen["total"] = 0;
                $quotationsOpen["percent"] = 0;
                $quotationsOpen["mount"] = 0;
            }
            
            if(!isset($quotationsClose["total"])){
                $quotationsClose["total"] = 0;
                $quotationsClose["percent"] = 0;
                $quotationsClose["mount"] = 0;
            }
            
            if(!isset($opportunitiesRejected["total"])){
                $opportunitiesRejected["total"] = 0;
                $opportunitiesRejected["percent"] = 0;
                $opportunitiesRejected["mount"] = 0;
            }
            
            if(!isset($opportunitiesOpen["total"])){
                $opportunitiesOpen["total"] = 0;
                $opportunitiesOpen["percent"] = 0;
                $opportunitiesOpen["mount"] = 0;
            }
            
            if(!isset($opportunitiesClose["total"])){
                $opportunitiesClose["total"] = 0;
                $opportunitiesClose["percent"] = 0;
                $opportunitiesClose["mount"] = 0;
            }
            
            $arrayMonths = array( '01' => 'Enero',
                                  '02' => 'Febrero',
                                  '03' => 'Marzo',
                                  '04' => 'Abril',
                                  '05' => 'Mayo',
                                  '06' => 'Junio',
                                  '07' => 'Julio',
                                  '08' => 'Agosto',
                                  '09' => 'Septiembre',
                                  '10' => 'Octubre',
                                  '11' => 'Noviembre',
                                  '12' => 'Diciembre');
            
            foreach ($arrayMonths as $key => $month) {
               
                if(!isset($quotationsByMounth["closed"][$key])){
                    $quotationsByMounth["closed"][$key] = 0;
                }
                
                if(!isset($quotationsByMounth["open"][$key])){
                    $quotationsByMounth["open"][$key] = 0;
                }
                
                if(!isset($quotationsByMounth["rejected"][$key])){
                    $quotationsByMounth["rejected"][$key] = 0;
                }
                
                $monthValues[] = "y: '".$month."', a: ".$quotationsByMounth["closed"][$key].", b: ".$quotationsByMounth["open"][$key].", c: ".$quotationsByMounth["rejected"][$key]."";
                
                if(!isset($opportunitiesByMounth["closed"][$key])){
                    $opportunitiesByMounth["closed"][$key] = 0;
                }
                
                if(!isset($opportunitiesByMounth["open"][$key])){
                    $opportunitiesByMounth["open"][$key] = 0;
                }
                
                if(!isset($opportunitiesByMounth["rejected"][$key])){
                    $opportunitiesByMounth["rejected"][$key] = 0;
                }
                
                $monthValuesOport[] = "y: '".$month."', a: ".$opportunitiesByMounth["closed"][$key].", b: ".$opportunitiesByMounth["open"][$key].", c: ".$opportunitiesByMounth["rejected"][$key]."";
                
                
                if(!isset($salesTotalArray[$key])){
                    $salesTotalArray[$key] = 0;
                }
                
                
                if(!isset($salesTotalRejectArray[$key])){
                    $salesTotalRejectArray[$key] = 0;
                }
                
                $initialMonth = date("Y")."-".$key."-01";
                $finishMonth  = date("Y")."-".$key."-31";
              
                $salesMount = DB::table('sales')
                        ->select('mont')
                        ->where('status','=',1)
                        ->whereDate('day','>=',$initialMonth)
                        ->whereDate('day','<=',$finishMonth)
                        ->sum('mont');

                $numCourse = Quotation::join("quotations_detail", "quotations.pkQuotations","=", "quotations_detail.fkQuotations")->where([['quotations.quotations_status', 5], ['final_date', '>=', $initialMonth], ['final_date', '<=', $finishMonth]])->count();
                $numPlaces = Quotation::join("quotations_detail", "quotations.pkQuotations","=", "quotations_detail.fkQuotations")->where([['quotations.quotations_status', 5], ['final_date', '>=', $initialMonth], ['final_date', '<=', $finishMonth]])->sum('number_places');
                
                /*$numCourse = DB::table('sales')
                        ->select('mont')
                        ->where('status','=',1)
                        ->whereDate('day','>=',$initialMonth)
                        ->whereDate('day','<=',$finishMonth)
                        ->count();
                
                $numPlaces = DB::table('sales')
                        ->select('mont')
                        ->where('status','=',1)
                        ->whereDate('day','>=',$initialMonth)
                        ->whereDate('day','<=',$finishMonth)
                        ->sum('places');*/
                
                $salesTotalArray[$key] = $salesTotalArray[$key] + $salesMount;
                
                $places_and_courses[$key] = array("courses" => $numCourse ,"places" => $numPlaces);
            }
            
          // dd($places_and_courses);
            
            //entradas
             $numVisit = DB::table('visits')
                              ->where('pkVisit','=',1)
                              ->first();
          
            //conectados
             $usersConect = DB::table('users')
                              ->select('full_name'
                                      ,'image'
                                      ,'color'
                                      ,'mail'
                                      ,'connected')
                              ->where('status','=',1)
                              ->get();
            
            //Faltan cursos y lugares (lugares los puedo obtener del crm cotizaciones cerradas)
            //Cursos se obtiene de la web capacitación
             $salesMount = DB::table('sales')
                        ->select('mont')
                        ->where('status','=',1)
                        ->whereDate('day','>=',$initialMonth)
                        ->whereDate('day','<=',$finishMonth)
                        ->sum('mont');
             
             $salesTotal = DB::table('sales')
                        ->select('mont')
                        ->where('status','=',1)
                        ->whereDate('day','>=',$initialMonth)
                        ->whereDate('day','<=',$finishMonth)
                        ->count('pkSales');
             
                    if(isset($quotationsSales["total"])){
                        $sales["total"] = $quotationsSales["total"] + $salesTotal;
                    }else{
                        $sales["total"] =  $salesTotal;      
                    }
                
                if($totalQuotations + $salesTotal > 0){
                $sales["percent"] = ($sales["total"] / ($totalQuotations + $salesTotal)) * 100;
                }
                  if(isset($quotationsSales["total"])){
                $sales["mount"] = $quotationsSales["mount"] + $salesMount;
                  }else{
                  $sales["mount"] = $salesMount;     
                  }

            //   dd($quotationsOpen);
                
                $users = DB::table('users')
                           ->select('pkUser'
                                   ,'full_name')
                           ->orderby('full_name','asc')
                           ->where('status','=',1)
                           ->get();
                
                $giros = DB::table('commercial_business')
                           ->select('pkCommercial_business'
                                   ,'name')
                           ->orderby('name','asc')
                           ->where('status','=',1)
                           ->get();
                
                $campanias = DB::table('commercial_campaigns')
                           ->select('pkCommercial_campaigns'
                                   ,'name')
                           ->orderby('name','asc')
                           ->where('status','=',1)
                           ->get();
                
                //cursos
                $numCurse = DB::table('courses')
                              ->where('status','=',1)
                              ->count();

                $courseMore = Quotation::join("quotations_detail", "quotations.pkQuotations","=", "quotations_detail.fkQuotations")
                            ->join("quotation_by_courses", "quotations_detail.pkQuotations_detail", "=", "quotation_by_courses.fkQuotationDetail")
                            ->select(
                                'quotation_by_courses.fkCourses',
                                DB::raw('(SELECT name FROM courses WHERE pkCourses = quotation_by_courses.fkCourses) as name'),
                                DB::raw('(SELECT SUM(number_places) FROM quotations_detail WHERE quotations_detail.fkQuotations = quotations.pkQuotations) as places'),
                            )->where([['quotations.quotations_status', 5], ['quotation_by_courses.fkCourses', '!=', -1], ['final_date', '>=', '2023-01-01'], ['final_date', '<=', $endDate] ])->groupBy('fkCourses')->get();

                $totalCourse = Quotation::join("quotations_detail", "quotations.pkQuotations","=", "quotations_detail.fkQuotations")
                            ->where([['quotations.quotations_status', 5], ['final_date', '>=', '2023-01-01'], ['final_date', '<=', $endDate] ])->sum('number_places');
                
                /*$courseMore = DB::table('sales')
                              ->select('nameCourse as name'
                                      ,DB::raw('SUM(places) AS places'))
                              ->where('status','=',1)
                              ->orderby('places','desc')
                              ->groupby('nameCourse')
                              ->distinct('nameCourse')
                              ->whereDate('day','>=',$startDate)
                              ->whereDate('day','<=',$endDate)
                              ->get();*/
                
                
            /*$totalCourse    = DB::table('sales')
                              ->select('nameCourse as name')
                              ->where('status','=',1)
                              ->whereDate('day','>=',$startDate)
                              ->whereDate('day','<=',$endDate)
                              ->sum('places');*/

            return view('welcome',['quotationsRejected'     => $quotationsRejected,
                                    'quotationsOpen'        => $quotationsOpen,
                                    'quotationsClose'       => $quotationsClose,
                                    'opportunitiesRejected' => $opportunitiesRejected,
                                    'opportunitiesOpen'     => $opportunitiesOpen,
                                    'opportunitiesClose'    => $opportunitiesClose,
                                    'arrayPaymentMethods'   => $arrayPaymentMethods,
                                    'categoriesQuery'       => $categoriesQuery,
                                    'levelInterestQuery'    => $levelInterestQuery,
                                    'paymentMethodsQuery'   => $paymentMethodsQuery,
                                    'arrayLevelInterest'    => $arrayLevelInterest,
                                    'arrayCategories'       => $arrayCategories,
                                    'typeCountBusiness'     => $typeCountBusiness,
                                    'monthValues'           => $monthValues,
                                    'monthValuesOport'      => $monthValuesOport,
                                    'numVisit'              => $numVisit->num_visit,
                                    'usersConect'           => $usersConect,
                                    'sales'                 => $sales,
                                    'salesTotal'            => $salesTotalArray,
                                    'salesTotalRejectArray' => $salesTotalRejectArray,
                                    'users'                 => $users,
                                    'giros'                 => $giros,
                                    'campanias'             => $campanias,
                                    'courseMore'            => $courseMore,
                                    'numCurse'              => $numCurse,
                                    'places_and_courses'    => $places_and_courses,
                                    'arrayPermition'        => $arrayPermition,
                                    'totalCourse'           => $totalCourse
                                      ]);
        }
        
        public function getUsersConect(){
            
            $usersConect = DB::table('users')
                              ->select('full_name'
                                      ,DB::raw("(CASE WHEN image IS NULL THEN 'user.jpg' 
                                                      ELSE image END) as image")
                                      ,'color'
                                      ,'mail'
                                      ,'connected'
                                      ,DB::raw("(CASE WHEN connected = 0 THEN 'Sin conexión' 
                                                      WHEN connected = 1 THEN 'En línea'
                                                      ELSE 'N/A' END) as connectedText")
)
                              ->where('status','=',1)
                              ->get();
            
             $view  = view('viewAgentConect', array(
                    "usersConect" => $usersConect,
                        ))->render();
           
      return \Response::json(array("view" => $view)); 
            
        }
        
        public function getNotification(){
            
            $pkUser = Session::get("pkUser");
            $new    = 0;
            
            $notification = DB::table('alerts as a')
                      ->join('users_per_alert as u','u.fkAlert','=','a.pkAlert')
                      ->select('a.pkAlert'
                              ,'a.fkUser'
                              ,'a.title'
                              ,'a.comment'
                              ,'u.view'
                              ,'a.type'
                              ,'a.document'
                              ,'a.fkQuotation'
                              ,'u.pkUser_per_alert'
                              )
                      ->where('a.status','=',1)
                      ->where('u.status','=',1)
                      ->where('u.view','=',0)
                      ->where('u.fkUser_assigned','=',$pkUser)
                      ->get();
            
            if(sizeof($notification) > 0){
                $new = 1;
            }
            
             $view  = view('viewAlert', array(
                    "notification" => $notification,
                        ))->render();
           
      return \Response::json(array("view" => $view
                                  ,"new"  => $new)); 
                     
        }
        
        public function NotificationView(Request $request){
            
            $pkAlert = $request->input("pkAlert");
            
            $update = DB::table("users_per_alert")
               ->where("pkUser_per_alert", "=",$pkAlert)
               ->update(['view' => 1]);
            
            if($update >= 1){
                return "true";
            }
            else{
                return "false";
            }
            
           return "false";  
        }

	public function oportunidadesConvertidas(Request $request){
            
            $date                   = date("Y-m-d");
            $startYear              = date("Y")."-01-01";
            $endYear                = date("Y")."-12-31";
            $month                  = date("Y-m");
            $aux                    = date('Y-m-d', strtotime("{$month} + 1 month"));
            $last_day               = date('Y-m-d', strtotime("{$aux} - 1 day"));
            $startDate              = date("Y-m")."-01";
            $endDate                = $last_day;
            
                $oportunity = DB::table('opportunities as o')
                            ->join('business as b','b.pkBusiness','=','o.fkBusiness')
                            ->join('users as u','u.pkUser','=','o.fkUser')
                            ->join('contacts_by_business as c','c.pkContact_by_business','=','o.fkContact_by_business')
                            ->join('level_interest as l','l.pkLevel_interest','=','o.fkLevel_interest')
                            ->leftjoin('payment_methods as p','p.pkPayment_methods','=','o.fkPayment_methods')
                            ->select('o.pkOpportunities'
                                    ,'o.name'
                                    ,'b.name as bussines'
                                    ,'o.folio'
                                    ,'o.register_day'
                                    ,'o.register_hour'
                                    ,'b.name as bussines'
                                    ,'u.full_name as agent'
                                    ,'c.name as contact'
                                    ,'l.text as level'
                                    ,'l.color'
                                    ,'o.opportunities_status as opportunities_statu'
                                    ,DB::raw('(SELECT description'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.execution_date IS NOT NULL'
                                         . ' AND a.pkOpportunities = o.pkOpportunities'
                                         . ' ORDER BY pkActivities desc limit 1) as lastActivity')
                                    ,DB::raw('(SELECT description'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.pkOpportunities = o.pkOpportunities'
                                         . ' ORDER BY pkActivities desc limit 1) as nextActivity')
                                    ,DB::raw('(SELECT final_date'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.pkOpportunities = o.pkOpportunities'
                                         . ' ORDER BY pkActivities desc limit 1) as finalActivity')
                                    ,DB::raw("(CASE WHEN o.opportunities_status = 1 THEN 'Creada' 
                                                    WHEN o.opportunities_status = 2 THEN 'Abierta'
                                                    WHEN o.opportunities_status = 3 THEN 'Rechazada'
                                                    WHEN o.opportunities_status = 4 THEN 'Cancelada'
                                                    WHEN o.opportunities_status = 5 THEN 'Cotizada'
                                                    ELSE 'N/A' END) as opportunities_status")
                                    ,'o.number_employees'
                                    ,'o.number_places'
                                    ,'o.number_courses'
                                    ,'o.price_total'
                                    ,'o.necesites'
                                    ,'o.comment'
                                    ,'p.name as typePayment'
                                    ,'o.isBudget')
                            ->where('o.opportunities_status','=',5)
                            ->where('o.status','=',1)
                            ->whereDate('o.final_date','>=',$startDate)
                            ->whereDate('o.final_date','<=',$endDate)
                            ->get();
            
             return view('oportunidades.verOportunidades', ["oportunity" => $oportunity]);
        }
        
        public function oportunidadesAbiertas(Request $request){
           
            $date                   = date("Y-m-d");
            $startYear              = date("Y")."-01-01";
            $endYear                = date("Y")."-12-31";
            $month                  = date("Y-m");
            $aux                    = date('Y-m-d', strtotime("{$month} + 1 month"));
            $last_day               = date('Y-m-d', strtotime("{$aux} - 1 day"));
            $startDate              = date("Y-m")."-01";
            $endDate                = $last_day;
            
                $oportunity = DB::table('opportunities as o')
                            ->join('business as b','b.pkBusiness','=','o.fkBusiness')
                            ->join('users as u','u.pkUser','=','o.fkUser')
                            ->join('contacts_by_business as c','c.pkContact_by_business','=','o.fkContact_by_business')
                            ->join('level_interest as l','l.pkLevel_interest','=','o.fkLevel_interest')
                            ->leftjoin('payment_methods as p','p.pkPayment_methods','=','o.fkPayment_methods')
                            ->select('o.pkOpportunities'
                                    ,'o.name'
                                    ,'b.name as bussines'
                                    ,'o.folio'
                                    ,'o.register_day'
                                    ,'o.register_hour'
                                    ,'b.name as bussines'
                                    ,'u.full_name as agent'
                                    ,'c.name as contact'
                                    ,'l.text as level'
                                    ,'l.color'
                                    ,'o.opportunities_status as opportunities_statu'
                                    ,DB::raw('(SELECT description'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.execution_date IS NOT NULL'
                                         . ' AND a.pkOpportunities = o.pkOpportunities'
                                         . ' ORDER BY pkActivities desc limit 1) as lastActivity')
                                    ,DB::raw('(SELECT description'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.pkOpportunities = o.pkOpportunities'
                                         . ' ORDER BY pkActivities desc limit 1) as nextActivity')
                                    ,DB::raw('(SELECT final_date'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.pkOpportunities = o.pkOpportunities'
                                         . ' ORDER BY pkActivities desc limit 1) as finalActivity')
                                    ,DB::raw("(CASE WHEN o.opportunities_status = 1 THEN 'Creada' 
                                                    WHEN o.opportunities_status = 2 THEN 'Abierta'
                                                    WHEN o.opportunities_status = 3 THEN 'Rechazada'
                                                    WHEN o.opportunities_status = 4 THEN 'Cancelada'
                                                    WHEN o.opportunities_status = 5 THEN 'Cotizada'
                                                    ELSE 'N/A' END) as opportunities_status")
                                    ,'o.number_employees'
                                    ,'o.number_places'
                                    ,'o.number_courses'
                                    ,'o.price_total'
                                    ,'o.necesites'
                                    ,'o.comment'
                                    ,'p.name as typePayment'
                                    ,'o.isBudget')
                            ->where('o.opportunities_status','=',1)
                            ->where('o.status','=',1)
                            ->whereDate('o.register_day','>=',$startDate)
                            ->whereDate('o.register_day','<=',$endDate)
                            ->get();
                
            
             return view('oportunidades.verOportunidades', ["oportunity" => $oportunity]);  
        }
        
        public function oportunidadesPerdidas(Request $request){
              
            $date                   = date("Y-m-d");
            $startYear              = date("Y")."-01-01";
            $endYear                = date("Y")."-12-31";
            $month                  = date("Y-m");
            $aux                    = date('Y-m-d', strtotime("{$month} + 1 month"));
            $last_day               = date('Y-m-d', strtotime("{$aux} - 1 day"));
            $startDate              = date("Y-m")."-01";
            $endDate                = $last_day;
            
                $oportunity = DB::table('opportunities as o')
                            ->join('business as b','b.pkBusiness','=','o.fkBusiness')
                            ->join('users as u','u.pkUser','=','o.fkUser')
                            ->join('contacts_by_business as c','c.pkContact_by_business','=','o.fkContact_by_business')
                            ->join('level_interest as l','l.pkLevel_interest','=','o.fkLevel_interest')
                            ->leftjoin('payment_methods as p','p.pkPayment_methods','=','o.fkPayment_methods')
                            ->select('o.pkOpportunities'
                                    ,'o.name'
                                    ,'b.name as bussines'
                                    ,'o.folio'
                                    ,'o.register_day'
                                    ,'o.register_hour'
                                    ,'b.name as bussines'
                                    ,'u.full_name as agent'
                                    ,'c.name as contact'
                                    ,'l.text as level'
                                    ,'l.color'
                                    ,'o.opportunities_status as opportunities_statu'
                                    ,DB::raw('(SELECT description'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.execution_date IS NOT NULL'
                                         . ' AND a.pkOpportunities = o.pkOpportunities'
                                         . ' ORDER BY pkActivities desc limit 1) as lastActivity')
                                    ,DB::raw('(SELECT description'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.pkOpportunities = o.pkOpportunities'
                                         . ' ORDER BY pkActivities desc limit 1) as nextActivity')
                                    ,DB::raw('(SELECT final_date'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.pkOpportunities = o.pkOpportunities'
                                         . ' ORDER BY pkActivities desc limit 1) as finalActivity')
                                    ,DB::raw("(CASE WHEN o.opportunities_status = 1 THEN 'Creada' 
                                                    WHEN o.opportunities_status = 2 THEN 'Abierta'
                                                    WHEN o.opportunities_status = 3 THEN 'Rechazada'
                                                    WHEN o.opportunities_status = 4 THEN 'Cancelada'
                                                    WHEN o.opportunities_status = 5 THEN 'Cotizada'
                                                    ELSE 'N/A' END) as opportunities_status")
                                    ,'o.number_employees'
                                    ,'o.number_places'
                                    ,'o.number_courses'
                                    ,'o.price_total'
                                    ,'o.necesites'
                                    ,'o.comment'
                                    ,'p.name as typePayment'
                                    ,'o.isBudget')
                            ->where('o.opportunities_status','=',2)
                            ->where('o.status','=',1)
                            ->whereDate('o.register_day','>=',$startDate)
                            ->whereDate('o.register_day','<=',$endDate)
                            ->get();
            
             return view('oportunidades.verOportunidades', ["oportunity" => $oportunity]);  
        }
        
        public function cotizacionesCerradas(){
            
            $date                   = date("Y-m-d");
            $startYear              = date("Y")."-01-01";
            $endYear                = date("Y")."-12-31";
            $month                  = date("Y-m");
            $aux                    = date('Y-m-d', strtotime("{$month} + 1 month"));
            $last_day               = date('Y-m-d', strtotime("{$aux} - 1 day"));
            $startDate              = date("Y-m")."-01";
            $endDate                = $last_day;
            
             $quotation = DB::table('quotations as o')
                            ->join('business as b','b.pkBusiness','=','o.fkBusiness')
                            ->join('users as u','u.pkUser','=','o.fkUser')
                            ->join('contacts_by_business as c','c.pkContact_by_business','=','o.fkContact_by_business')
                            ->join('level_interest as l','l.pkLevel_interest','=','o.fkLevel_interest')
                            ->select('o.pkQuotations'
                                    ,'o.name'
                                    ,'o.folio'
                                    ,'b.name as bussines'
                                    ,'u.full_name as agent'
                                    ,'c.name as contact'
                                    ,'l.text as level'
                                    ,'l.color'
                                    ,'o.final_date'
                                    ,'o.register_day'
                                    ,'o.register_hour'
                                    ,'o.money_in_account'
                                    ,'o.quotations_status as quotation_status'
                                    ,DB::raw('(SELECT description'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.execution_date IS NOT NULL'
                                         . ' AND a.pkQuotations = o.pkQuotations'
                                         . ' ORDER BY pkActivities desc limit 1) as lastActivity')
                                    ,DB::raw('(SELECT description'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.pkQuotations = o.pkQuotations'
                                         . ' ORDER BY pkActivities desc limit 1) as nextActivity')
                                    ,DB::raw('(SELECT final_date'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.pkQuotations = o.pkQuotations'
                                         . ' ORDER BY pkActivities desc limit 1) as finalActivity')
                                    ,DB::raw("(CASE WHEN o.quotations_status = 1 THEN 'Creada' 
                                                    WHEN o.quotations_status = 2 THEN 'Abierta'
                                                    WHEN o.quotations_status = 3 THEN 'Rechazada'
                                                    WHEN o.quotations_status = 4 THEN 'Cancelada'
                                                    WHEN o.quotations_status = 5 THEN 'Pendiente de pago'
                                                    WHEN o.quotations_status = 6 THEN 'Pagada'
                                                     WHEN o.quotations_status = 7 THEN 'Facturada'
                                                    ELSE 'N/A' END) as quotations_status"))
                            ->where('o.quotations_status','>',4)
                            ->where('o.status','=',1)
                            ->whereDate('o.register_day','>=',$startDate)
                            ->whereDate('o.register_day','<=',$endDate)
                            ->get();
            
             return view('cotizaciones.verCotizaciones', ["quotation" => $quotation]);
        }
        
        public function cotizacionesAbiertas(){
          $date                   = date("Y-m-d");
            $startYear              = date("Y")."-01-01";
            $endYear                = date("Y")."-12-31";
            $month                  = date("Y-m");
            $aux                    = date('Y-m-d', strtotime("{$month} + 1 month"));
            $last_day               = date('Y-m-d', strtotime("{$aux} - 1 day"));
            $startDate              = date("Y-m")."-01";
            $endDate                = $last_day;
            
             $quotation = DB::table('quotations as o')
                            ->join('business as b','b.pkBusiness','=','o.fkBusiness')
                            ->join('users as u','u.pkUser','=','o.fkUser')
                            ->join('contacts_by_business as c','c.pkContact_by_business','=','o.fkContact_by_business')
                            ->join('level_interest as l','l.pkLevel_interest','=','o.fkLevel_interest')
                            ->select('o.pkQuotations'
                                    ,'o.name'
                                    ,'o.folio'
                                    ,'b.name as bussines'
                                    ,'u.full_name as agent'
                                    ,'c.name as contact'
                                    ,'l.text as level'
                                    ,'l.color'
                                    ,'o.final_date'
                                    ,'o.register_day'
                                    ,'o.register_hour'
                                    ,'o.quotations_status as quotation_status'
                                    ,DB::raw('(SELECT description'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.execution_date IS NOT NULL'
                                         . ' AND a.pkQuotations = o.pkQuotations'
                                         . ' ORDER BY pkActivities desc limit 1) as lastActivity')
                                    ,DB::raw('(SELECT description'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.pkQuotations = o.pkQuotations'
                                         . ' ORDER BY pkActivities desc limit 1) as nextActivity')
                                    ,DB::raw('(SELECT final_date'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.pkQuotations = o.pkQuotations'
                                         . ' ORDER BY pkActivities desc limit 1) as finalActivity')
                                    ,DB::raw("(CASE WHEN o.quotations_status = 1 THEN 'Creada' 
                                                    WHEN o.quotations_status = 2 THEN 'Abierta'
                                                    WHEN o.quotations_status = 3 THEN 'Rechazada'
                                                    WHEN o.quotations_status = 4 THEN 'Cancelada'
                                                    WHEN o.quotations_status = 5 THEN 'Pendiente de pago'
                                                    WHEN o.quotations_status = 6 THEN 'Pagada'
                                                     WHEN o.quotations_status = 7 THEN 'Facturada'
                                                    ELSE 'N/A' END) as quotations_status"))
                            ->where('o.quotations_status','=',1)
                            ->where('o.status','=',1)
                            ->whereDate('o.register_day','>=',$startDate)
                            ->whereDate('o.register_day','<=',$endDate)
                            ->get();
            
             return view('cotizaciones.verCotizaciones', ["quotation" => $quotation]);  
        }
        
        public function cotizacionesDescartadas(){
            $date                   = date("Y-m-d");
            $startYear              = date("Y")."-01-01";
            $endYear                = date("Y")."-12-31";
            $month                  = date("Y-m");
            $aux                    = date('Y-m-d', strtotime("{$month} + 1 month"));
            $last_day               = date('Y-m-d', strtotime("{$aux} - 1 day"));
            $startDate              = date("Y-m")."-01";
            $endDate                = $last_day;
            
             $quotation = DB::table('quotations as o')
                            ->join('business as b','b.pkBusiness','=','o.fkBusiness')
                            ->join('users as u','u.pkUser','=','o.fkUser')
                            ->join('contacts_by_business as c','c.pkContact_by_business','=','o.fkContact_by_business')
                            ->join('level_interest as l','l.pkLevel_interest','=','o.fkLevel_interest')
                            ->select('o.pkQuotations'
                                    ,'o.name'
                                    ,'o.folio'
                                    ,'b.name as bussines'
                                    ,'u.full_name as agent'
                                    ,'c.name as contact'
                                    ,'l.text as level'
                                    ,'l.color'
                                    ,'o.final_date'
                                    ,'o.register_day'
                                    ,'o.register_hour'
                                    ,'o.quotations_status as quotation_status'
                                    ,DB::raw('(SELECT description'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.execution_date IS NOT NULL'
                                         . ' AND a.pkQuotations = o.pkQuotations'
                                         . ' ORDER BY pkActivities desc limit 1) as lastActivity')
                                    ,DB::raw('(SELECT description'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.pkQuotations = o.pkQuotations'
                                         . ' ORDER BY pkActivities desc limit 1) as nextActivity')
                                    ,DB::raw('(SELECT final_date'
                                         . ' FROM activities as a'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.pkQuotations = o.pkQuotations'
                                         . ' ORDER BY pkActivities desc limit 1) as finalActivity')
                                    ,DB::raw("(CASE WHEN o.quotations_status = 1 THEN 'Creada' 
                                                    WHEN o.quotations_status = 2 THEN 'Abierta'
                                                    WHEN o.quotations_status = 3 THEN 'Rechazada'
                                                    WHEN o.quotations_status = 4 THEN 'Cancelada'
                                                    WHEN o.quotations_status = 5 THEN 'Pendiente de pago'
                                                    WHEN o.quotations_status = 6 THEN 'Pagada'
                                                     WHEN o.quotations_status = 7 THEN 'Facturada'
                                                    ELSE 'N/A' END) as quotations_status"))
                            ->where('o.quotations_status','=',2)
                            ->where('o.status','=',1)
                            ->whereDate('o.register_day','>=',$startDate)
                            ->whereDate('o.register_day','<=',$endDate)
                            ->get();
            
             return view('cotizaciones.verCotizaciones', ["quotation" => $quotation]);   
        }
        
        public function empresasTipo($id){
            $bussines = DB::table('business as b')
                       ->join('categories as c','c.pkCategory','=','b.fkCategory')
                       ->join('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
                       ->join('business_origin as o','o.pkBusiness_origin','=','b.fKOrigin')
                       ->select('b.pkBusiness'
                               ,'b.name'
                               ,'o.name as fKOrigin'
                               ,'c.name as category'
                               ,'g.name as giro'
                               ,'b.stateType'
                               ,'b.date_register'
                                ,DB::raw('(SELECT execution_date'
                                         . ' FROM activities as a'
                                        . ' JOIN activities_type as t ON t.pkActivities_type = a.fkActivities_type'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.execution_date IS NOT NULL'
                                         . ' AND a.fkBusiness = b.pkBusiness'
                                        . ' AND t.pkActivities_type > 0'
                                         . ' ORDER BY pkActivities desc limit 1) as lastActivity')
                                ,DB::raw('(SELECT description'
                                         . ' FROM activities as a'
                                        . ' JOIN activities_type as t ON t.pkActivities_type = a.fkActivities_type'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.fkBusiness = b.pkBusiness'
                                         . ' AND a.execution_date IS NULL'
                                        . ' AND t.pkActivities_type > 0'
                                         . ' ORDER BY pkActivities desc limit 1) as nextActivity')
                                    ,DB::raw('(SELECT final_date'
                                         . ' FROM activities as a'
                                            . ' JOIN activities_type as t ON t.pkActivities_type = a.fkActivities_type'
                                         . ' WHERE a.status = 1'
                                         . ' AND a.fkBusiness = b.pkBusiness'
                                         . ' AND a.execution_date IS NULL'
                                         . ' AND t.pkActivities_type > 0'
                                         . ' ORDER BY pkActivities desc limit 1) as finalActivity')
                               ,DB::raw('(SELECT name'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as nameContact')
                               ,DB::raw('(SELECT mail'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mailContact')
                               ,DB::raw('(SELECT phone'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as phoneContact')
                               ,DB::raw('(SELECT mobile_phone'
                                         . ' FROM contacts_by_business as cb'
                                         . ' WHERE cb.status = 1'
                                         . ' AND cb.fkBusiness = b.pkBusiness'
                                         . ' ORDER BY pkContact_by_business ASC LIMIT 1) as mobile_phone')
                                    ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'           
                                         . ' AND q.quotations_status = 5) as salesPay')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.quotations_status = 4 OR q.quotations_status = 3)) as salesLoss')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.quotations_status = 2 OR q.quotations_status = 1)) as quotations')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.opportunities_status = 5) as oportunityAproved')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.opportunities_status = 4 OR q.opportunities_status = 3)) as oportunityLoss')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.opportunities_status = 1 OR q.opportunities_status = 2)) as oportunityOpen')
                                         ,DB::raw('(SELECT SUM(number_places)'
                                         . ' FROM quotations as q'
                                         . ' INNER JOIN quotations_detail AS d ON d.fkQuotations = q.pkQuotations'
                                         . ' WHERE q.status = 1'
                                         . ' AND d.isSelected = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness' 
                                         . ' AND q.quotations_status = 5) as salesPlaces')
                               ,DB::raw('(SELECT COUNT(fkBusiness_status)'
                                         . ' FROM status_by_bussines as s'
                                         . ' WHERE s.fkBusiness = b.pkBusiness'
                                         . ' AND s.status = 1'
                                         . ' AND s.fkBusiness_status = 3) as initial')
                               ,DB::raw('(SELECT COUNT(fkBusiness_status)'
                                         . ' FROM status_by_bussines as s'
                                         . ' WHERE s.fkBusiness = b.pkBusiness'
                                         . ' AND s.status = 1'
                                         . ' AND (s.fkBusiness_status = 4 OR s.fkBusiness_status = 6)) as leds')
                               ,DB::raw('(SELECT COUNT(fkBusiness_status)'
                                         . ' FROM status_by_bussines as s'
                                         . ' WHERE s.fkBusiness = b.pkBusiness'
                                         . ' AND s.status = 1'
                                         . ' AND s.fkBusiness_status = 9) as client')
                               ,DB::raw('(SELECT SUM(price)'
                                         . ' FROM quotations as q'
                                         . ' INNER JOIN quotations_detail AS d ON d.fkQuotations = q.pkQuotations'
                                         . ' WHERE q.status = 1'
                                         . ' AND d.isSelected = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness' 
                                         . ' AND q.quotations_status = 5) as salesMont')
                                             
                               )
                       ->where('b.status','=',1)
                       ->where('b.fkCategory','=',$id)
                       ->get();
        
          $BussinessAddRes = DB::table('business as b')
                       ->join('categories as c','c.pkCategory','=','b.fkCategory')
                       ->join('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
                       ->join('business_origin as o','o.pkBusiness_origin','=','b.fKOrigin')
                       ->select('b.pkBusiness'
                               ,'b.name'
                               ,'o.name as fKOrigin'
                               ,'c.name as category'
                               ,'g.name as giro'
                               ,'b.stateType'
                               ,'b.date_register'
                               ,DB::raw('(SELECT COUNT(fkBusiness_status)'
                                         . ' FROM status_by_bussines as s'
                                         . ' WHERE s.fkBusiness = b.pkBusiness'
                                         . ' AND s.status = 1'
                                         . ' AND s.fkBusiness_status = 3) as initial')
                               ,DB::raw('(SELECT COUNT(fkBusiness_status)'
                                         . ' FROM status_by_bussines as s'
                                         . ' WHERE s.fkBusiness = b.pkBusiness'
                                         . ' AND s.status = 1'
                                         . ' AND (s.fkBusiness_status = 4 OR s.fkBusiness_status = 6)) as leds')
                               ,DB::raw('(SELECT COUNT(fkBusiness_status)'
                                         . ' FROM status_by_bussines as s'
                                         . ' WHERE s.fkBusiness = b.pkBusiness'
                                         . ' AND s.status = 1'
                                         . ' AND s.fkBusiness_status = 9) as client')
                               ,DB::raw('(SELECT SUM(price)'
                                         . ' FROM quotations as q'
                                         . ' INNER JOIN quotations_detail AS d ON d.fkQuotations = q.pkQuotations'
                                         . ' WHERE q.status = 1'
                                         . ' AND d.isSelected = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness' 
                                         . ' AND q.quotations_status = 5) as salesMont')
                               )
                        ->where('b.status','=',1)
                        ->orderby('b.date_register','DESC')
                        ->get();
          
     
           $BussinessMoreRes = DB::table('business as b')
                       ->join('categories as c','c.pkCategory','=','b.fkCategory')
                       ->join('commercial_business as g','g.pkCommercial_business','=','b.fkComercial_business')
                       ->join('business_origin as o','o.pkBusiness_origin','=','b.fKOrigin')
                       ->select('b.pkBusiness'
                               ,'b.name'
                               ,'o.name as fKOrigin'
                               ,'c.name as category'
                               ,'g.name as giro'
                               ,'b.stateType'
                               ,'b.date_register'                             
                               ,DB::raw('(SELECT SUM(price)'
                                         . ' FROM quotations as q'
                                         . ' INNER JOIN quotations_detail AS d ON d.fkQuotations = q.pkQuotations'
                                         . ' WHERE q.status = 1'
                                         . ' AND d.isSelected = 1'
                                         . ' AND q.fkBusiness = b.pkBusiness' 
                                         . ' AND q.quotations_status = 5) as salesMont')
                                             
                               )
                        ->where('b.status','=',1)
                        ->orderby('b.date_register','DESC')
                        ->get();
                 
            $giros = DB::table('commercial_business')
                           ->select('pkCommercial_business'
                                   ,'name')
                           ->orderby('name','asc')
                           ->where('status','=',1)
                           ->get();
                
                $campanias = DB::table('commercial_campaigns')
                           ->select('pkCommercial_campaigns'
                                   ,'name')
                           ->orderby('name','asc')
                           ->where('status','=',1)
                           ->get();
                
        return view('empresas.verEmpresas')->with('bussines',$bussines)
                                           ->with('giros',$giros)
                                           ->with('campanias',$campanias)
                                           ->with('BussinessAddRes',$BussinessAddRes)
                                           ->with('BussinessMoreRes',$BussinessMoreRes);
        }
        
        public function reloadCuorses(Request $request){
            
              $date = $request->input("date");
              
              switch ($date) {
                  case 1:
                      $start  = date('Y-m-d');
                      $finish = date('Y-m-d');
                      break;
                  
                  case 2:
                      $start  = date('Y-m-1');
                      $finish = date('Y-m-31');
                      break;
                  
                  case 3:
                      $start  = date('Y-1-1');
                      $finish = date('Y-12-31');
                      break;

                  default:
                      break;
              }
              
              $courseMore = DB::table('sales')
                              ->select('nameCourse as name'
                                      ,DB::raw('SUM(places) AS places'))
                              ->where('status','=',1)
                              ->whereDate('day','>=',$start)
                              ->whereDate('day','<=',$finish)
                              ->orderby('places','desc')
                              ->groupby('nameCourse')
                              ->distinct('nameCourse')
                              ->take(10)
                              ->get();
              
                $totalCourse    = DB::table('sales')
                              ->select('nameCourse as name')
                              ->where('status','=',1)
                              ->whereDate('day','>=',$start)
                              ->whereDate('day','<=',$finish)
                              ->sum('places');
              
               $view  = view('getCourses', array(
                    "courseMore" => $courseMore,
                    "totalCourse" => $totalCourse
                        ))->render();
           
            return $view; 
              
              
        }
}
