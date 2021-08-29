<?php 
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\PDFPreview;
use App\Models\Announcement;
use App\Models\Internship;
use App\Models\Requesd;
use App\Models\RequestType;
use DB;
use Auth;

class StatisticController 
{
    public function dashboard()
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(Auth::User()->role_id!="3")
            {
            return response()->json([
                'error' => "Vous n'êtes pas un admin."
            ], 422);
        }
        $data = new \stdClass;
        $data->users = new \stdClass;
        $data->users->alls = new \stdClass;
        $data->users->alls->student = User::where('role_id',"=","1")->count();
        $data->users->alls->prof = User::where('role_id',"=","2")->count();
        $data->users->alls->admin = User::where('role_id',"=","3")->count();
        $data->users->alls->total = $this->getSum($data->users->alls);
        $data->users->verified = new \stdClass;
        $data->users->verified->student = User::where(['role_id'=>"1","verified"=>"1"])->count();
        $data->users->verified->prof = User::where(['role_id'=>"2","verified"=>"1"])->count();
        $data->users->verified->admin = User::where(['role_id'=>"3","verified"=>"1"])->count();
        $data->users->verified->total = $this->getSum($data->users->verified);
        $data->users->unverified = new \stdClass;
        $data->users->unverified->student= $data->users->alls->student-$data->users->verified->student;
        $data->users->unverified->prof= $data->users->alls->prof-$data->users->verified->prof;
        $data->users->unverified->admin= $data->users->alls->admin-$data->users->verified->admin;
        $data->users->unverified->total = $this->getSum($data->users->unverified);
        $data->usersByMonth = User::select(DB::raw("MONTH(created_at) as month"),DB::raw('count(*) as total'))->where(DB::raw('YEAR(created_at)'),'=',$this->getThisYear())->groupBy(DB::raw("MONTH(created_at)"))->get();
        $data->coursesByMonth = Course::select(DB::raw("MONTH(created_at) as month"),DB::raw('count(*) as total'))->where(DB::raw('YEAR(created_at)'),'=',$this->getThisYear())->groupBy(DB::raw("MONTH(created_at)"))->get();
        $data->courses = new \stdClass;
        $data->courses->profs = Course::select(DB::raw("prof"),DB::raw('count(*) as total'))->where(DB::raw('YEAR(created_at)'),'=',$this->getThisYear())->groupBy("prof")->get();
        $data->courses->profs=(array)$data->courses->profs;
        $data->courses->profs=array_values($data->courses->profs)[0];
        usort($data->courses->profs, function($a, $b) { return $b->total - $a->total; });
        $data->courses->profs = array_slice($data->courses->profs, 0, 10);
        foreach($data->courses->profs as $val)
        {
            $user=User::find($val->prof);
            $val->prof=$user->lname;
        }
        $data->courses->students = PDFPreview::select(DB::raw("student"),DB::raw('count(*) as total'))->where(DB::raw('YEAR(created_at)'),'=',$this->getThisYear())->groupBy("student")->get();
        $data->courses->students=(array)$data->courses->students;
        $data->courses->students=array_values($data->courses->students)[0];
        usort($data->courses->students, function($a, $b) { return $b->total - $a->total; });
        $data->courses->students = array_slice($data->courses->students, 0, 10);
        foreach($data->courses->students as $val)
        {
            $user=User::where("cne","=",$val->student)->first();
            $val->student=$user->lname." ".$user->fname;
        }
        $data->annonces = Announcement::all()->count();
        $data->internship = Internship::all()->count();
        $data->requests_undone = Requesd::all()->where("is_done","=","0")->count();
        $data->requests_done = Requesd::all()->where("is_done","=","1")->count();
        $data->courseNum = Course::all()->count();
        $data->request_type = RequestType::all()->count();
        $data->requestsByMonth = Requesd::select(DB::raw("MONTH(updated_at) as month"),DB::raw('count(*) as total'))->where(DB::raw('YEAR(updated_at)'),'=',$this->getThisYear())->where("is_done","=","1")->groupBy(DB::raw("MONTH(updated_at)"))->get();
        $data->requestsByMonthN = Requesd::select(DB::raw("MONTH(updated_at) as month"),DB::raw('count(*) as total'))->where(DB::raw('YEAR(updated_at)'),'=',$this->getThisYear())->where("is_done","=","0")->groupBy(DB::raw("MONTH(updated_at)"))->get();
        return json_encode($data);
    }
    
    public function dashboardIndex()
    {
        return view("statistic.dashboard");
    }
    
    public function getThisYear()
    {
        return date("Y");
    }
    
    public function getSum($obj)
    {
        return $obj->student+$obj->prof+$obj->admin;
    }
}

?>