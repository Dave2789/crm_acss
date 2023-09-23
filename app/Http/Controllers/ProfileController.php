<?php namespace App\Http\Controllers;

use DB;
use Input;
use Session;
use App\Models\User_type;
use Illuminate\Http\Request;

class ProfileController extends Controller {

	public function __construct()
        {
            $this->middleware('guest')->except('logout');
        }
        
        public function myProfile(){
            
            $id = Session::get('pkUser');
              
                $agentInfo = DB::table('users as u')
                               ->join('user_type as t','t.pkUser_type','=','u.fkUser_type')
                               ->select('u.full_name'
                                       ,'u.mail'
                                       ,'u.pkUser'
                                       ,'u.image'
                                       ,'u.phone_extension'
                                       ,'t.name as type'
                                        ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkUser = u.pkUser'
                                         . ' AND q.quotations_status = 5) as salesPay')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkUser = u.pkUser'
                                         . ' AND (q.quotations_status = 4 OR q.quotations_status = 3)) as salesLoss')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkUser = u.pkUser'
                                         . ' AND (q.quotations_status = 2 OR q.quotations_status = 1)) as quotations')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . '  AND q.fkUser = u.pkUser'
                                         . ' AND q.opportunities_status = 5) as oportunityAproved')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkUser = u.pkUser'
                                         . ' AND q.opportunities_status = 4 OR q.opportunities_status = 3) as oportunityLoss')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkUser = u.pkUser'
                                         . ' AND q.opportunities_status = 1 OR q.opportunities_status = 2) as oportunityOpen')
                                       )
                                ->where('u.pkUser','=',$id)
                                ->first();
                
              //  dd($agentInfo);
            $date                   = date("Y-m-d");
            $hour                   = date("H:i:s");
            $startYear              = date("Y")."-01-01";
            $endYear                = date("Y")."-12-31";
            $month                  = date("Y-m");
            $aux                    = date('Y-m-d', strtotime("{$month} + 1 month"));
            $last_day               = date('Y-m-d', strtotime("{$aux} - 1 day"));
            $startDate              = date("Y-m")."-01";
            $endDate                = $last_day;
            
            
            $lastActivitiesQuery    = DB::table('activities')
                                        ->join('activities_type', function ($join) {
                                            $join->on('activities_type.pkActivities_type', '=', 'activities.fkActivities_type');
                                        })
                                        ->join('activities_subtype', function ($join) {
                                            $join->on('activities_subtype.pkActivities_subtype', '=', 'activities.fkActivities_subtype');
                                        })
                                        ->join('users', function ($join) {
                                            $join->on('users.pkUser', '=', 'activities.fkUser');
                                        })
                                        ->join('business', function ($join) {
                                            $join->on('business.pkBusiness', '=', 'activities.fkBusiness');
                                        })
                                        ->where('activities.status', '=', 1)
                                        ->where('activities_type.status', '=', 1)
                                        ->where('activities_subtype.status', '=', 1)
                                        ->where('users.status', '=', 1)
                                        ->where('business.status', '=', 1)
                                        ->where(function ($query) use($startDate, $endDate) {
                                            $query->where('execution_date', '>=', "".$startDate."")
                                                  ->where('execution_date', '<=', "".$endDate."");
                                        })
                                        ->where('activities.fkUser', '=', $id)
                                        ->select(
                                                'activities.description AS description',
                                                'activities.execution_date AS execution_date',
                                                'activities.execution_hour AS execution_hour',
                                                'activities_type.text AS text',
                                                'activities_type.color AS color',
                                                'activities_type.icon AS icon',
                                                'activities_subtype.text AS text_subtype',
                                                'activities_subtype.color AS color_subtype',
                                                'users.full_name AS full_name',
                                                'business.name AS business_name')
                                        ->orderBy("execution_date", "desc")
                                        ->orderBy("execution_hour", "desc")
                                        ->get(); 
                                        
            $activitiesQuery    = DB::table('activities')
                                        ->join('activities_type', function ($join) {
                                            $join->on('activities_type.pkActivities_type', '=', 'activities.fkActivities_type');
                                        })
                                        ->join('users', function ($join) {
                                            $join->on('users.pkUser', '=', 'activities.fkUser');
                                        })
                                        ->join('business', function ($join) {
                                            $join->on('business.pkBusiness', '=', 'activities.fkBusiness');
                                        })
                                        ->where('activities.status', '=', 1)
                                        ->where('activities_type.status', '=', 1)
                                        ->where('users.status', '=', 1)
                                        ->where('business.status', '=', 1)
                                        ->where('activities.execution_date', '=', NULL)
                                        ->where(function ($query) use($startDate, $endDate) {
                                            $query->where('final_date', '>=', "".$startDate."")
                                                  ->where('final_date', '<=', "".$endDate."");
                                        })
                                        ->where('activities.fkUser', '=', $id)
                                        ->select(
                                                'activities.description AS description',
                                                'activities.final_date AS final_date',
                                                'activities.final_hour AS final_hour',
                                                'activities_type.text AS text',
                                                'activities_type.color AS color',
                                                'activities_type.icon AS icon',
                                                'users.full_name AS full_name',
                                                'business.name AS business_name')
                                        ->orderBy("final_date", "desc")
                                        ->orderBy("final_hour", "desc")
                                        ->get();                           
                                        
                $usersActivities = DB::table('business as b')
                                     ->select('b.name'
                                             ,'b.pkBusiness'
                                            ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkUser = '.$id.''
                                         . ' AND q.fkBusiness = b.pkBusiness'           
                                         . ' AND q.quotations_status = 5) as salesPay')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkUser = '.$id.''
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.quotations_status = 4 OR q.quotations_status = 3)) as salesLoss')
                                       ,DB::raw('(SELECT count(pkQuotations)'
                                         . ' FROM quotations as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkUser = '.$id.''
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.quotations_status = 2 OR q.quotations_status = 1)) as quotations')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkUser = '.$id.''
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND q.opportunities_status = 5) as oportunityAproved')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkUser = '.$id.''
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.opportunities_status = 4 OR q.opportunities_status = 3)) as oportunityLoss')
                                       ,DB::raw('(SELECT count(pkOpportunities)'
                                         . ' FROM opportunities as q'
                                         . ' WHERE q.status = 1'
                                         . ' AND q.fkUser = '.$id.''
                                         . ' AND q.fkBusiness = b.pkBusiness'   
                                         . ' AND (q.opportunities_status = 1 OR q.opportunities_status = 2)) as oportunityOpen')
                                         ,DB::raw('(SELECT SUM(number_places)'
                                         . ' FROM quotations as q'
                                         . ' INNER JOIN quotations_detail AS d ON d.fkQuotations = q.pkQuotations'
                                         . ' WHERE q.status = 1'
                                         . ' AND d.isSelected = 1'
                                         . ' AND q.fkUser = '.$id.''
                                         . ' AND q.fkBusiness = b.pkBusiness' 
                                         . ' AND q.quotations_status = 5) as salesPlaces')
                               ,DB::raw('(SELECT SUM(price)'
                                         . ' FROM quotations as q'
                                         . ' INNER JOIN quotations_detail AS d ON d.fkQuotations = q.pkQuotations'
                                         . ' WHERE q.status = 1'
                                         . ' AND d.isSelected = 1'
                                         . ' AND q.fkUser = '.$id.''
                                         . ' AND q.fkBusiness = b.pkBusiness' 
                                         . ' AND q.quotations_status = 5) as salesMont')
                                             )
                                     ->where('status','=',1)
                                     ->get();
                                        
                return view('agentes.myProfile')->with('agentInfo',$agentInfo)
                                                ->with('lastActivitiesQuery',$lastActivitiesQuery)
                                                ->with('activitiesQuery',$activitiesQuery)
                                                ->with('usersActivities',$usersActivities)
                                                ->with('date',$date)
                                                ->with('hour',$hour)
                                                ->with('pkUser',$id);
        }
       

	
}
