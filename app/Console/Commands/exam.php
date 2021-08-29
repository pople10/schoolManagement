<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Models\ModuleLevel;
use App\Models\Level;
use App\Models\Student;

class exam extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:exam';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
            $allQst = DB::table('examQst')->get();
            foreach($allQst as $val)
            {
                $exam = DB::table("examens")->where("id","=",$val->examen)->get()[0];
                /*var_dump($exam)."<br>";
                echo strtotime($exam->end)."<br>";
                echo time()."<br>";*/
                if(strtotime($exam->end)<time())
                {
                    $level = ModuleLevel::find($exam->moduleLevel)->level;
                    $students = Student::all()->where("level","=",$level);
                    foreach($students as $val2)
                    {
                        if(count(DB::table("examRs")->where([["qst","=",$val->id],["student","=",$val2->cne]])->get())==0)
                        {
                            if(!DB::table("examRs")->insert(["student"=>$val2->cne,"qst"=>$val->id,"mark"=>"0"]))
                                echo "Probleme dans l'insertion\n";
                            else
                                echo "done\n";
                        }
                        else
                        {
                             //echo "Probleme dans le code";
                        }
                    }
                }
                else
                {
                    //echo "Probleme dans le code 2";
                }
            }
    }
}
