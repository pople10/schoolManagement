<?php

use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\AnnouncementController;
Route::get('/', [AnnouncementController::class, 'home']);

use App\Http\Controllers\Auth\LogoutController;
Auth::routes();
Route::get('/logout',[LogoutController::class,"destroySession"]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/Register/MoreInfo', [App\Http\Controllers\RegisterSecondPage::class, 'index'])->name('RS2');
Route::post('/Register/MoreInfo', [App\Http\Controllers\RegisterSecondPage::class, 'store']);
use App\Http\Controllers\Profil;
Route::get('/profil', [Profil::class, 'index'])->name('profil');
Route::post('/profil/edit', [Profil::class, 'edit']);




Route::get('/announcement/download/{attachement}', [AnnouncementController::class, 'download'])->name("announcement.download");
//Route::get('/announcement', [AnnouncementController::class, 'index']);
Route::get('/announcement/data', [AnnouncementController::class, 'dataTableJson']);
Route::get('/announcement/add', [AnnouncementController::class, 'create'])->name("announcement.create");
Route::post('/announcement/store', [AnnouncementController::class, 'store']);
Route::any('/announcement/getContent/{id}', [AnnouncementController::class, 'getContentById']);
Route::get('announcement/{announcement}', [AnnouncementController::class, 'show']);
//Route::get('announcement/{announcement}/edit', [AnnouncementController::class, 'edit'])->name("announcement.edit");
Route::post('/announcement/update/{announcement}', [AnnouncementController::class, 'update']);
Route::get('/announcement/find/{id}', [AnnouncementController::class, 'findById']);
Route::delete('/announcement/{announcement}', [AnnouncementController::class, 'destroy'])->name("announcement.delete");
Route::any('/annonce', function(){return view("announcement.show");});
Route::any('/concours', function(){return view("announcement.concours");});
Route::any('/concoursResultats', function(){return view("announcement.results");});
Route::post('/annonce/finyFromId',[AnnouncementController::class, 'finyFromId']);
Route::post('/annonce/finyFromIdConcours',[AnnouncementController::class, 'finyFromIdConcours']);
Route::post('/annonce/finyFromIdResults',[AnnouncementController::class, 'finyFromIdResults']);
Route::get('/annonce/{id}',[AnnouncementController::class, 'showOne']);

use App\Http\Controllers\RoleController;
//Route::get('/Roles',[RoleController::class, 'index'])->name('Roles');
Route::get('/api/Prvil/getAll', [RoleController::class, 'GetAllP']);
Route::post('/api/role/add', [RoleController::class, 'store']);
Route::post('/api/role/{r}',[RoleController::class, 'update']);
Route::post('/api/roleonep/{r}',[RoleController::class, 'updateone']);
Route::get('/roles&prvil/data', [RoleController::class, 'GetAllR_P']);
Route::delete('/roles/{role}', [RoleController::class, 'delete']);


use App\Http\Controllers\FacultyController;
//Route::get('/filieres',[FacultyController::class, 'index']);
Route::post('/api/filieres/add',[FacultyController::class, 'store']);
Route::get('/filieres/data', [FacultyController::class, 'GetAllJson']);
Route::delete('/filieres/{f}', [FacultyController::class, 'delete']);
Route::post('api/filieres/modifier/{f}',[FacultyController::class, 'update']);



//for the internship form
use App\Http\Controllers\InternshipController;
Route::get('/internship/data', [InternshipController::class, 'dataTableJson'])->name('internship.data');
//dont forget to add internship before available in the server
Route::get('/internship/available', [InternshipController::class, 'demandeData']);
//Route::get('/internship/available/data', [InternshipController::class, 'demandeData']);
//Route::get('/internship/edit', [InternshipController::class, 'editView'])->name('internship.edit.view');
Route::resource('internship', InternshipController::class);
use App\Http\Controllers\UserController;
Route::post('/users/prof', [UserController::class, 'getProf'])->name('users.prof');
use App\Http\Controllers\LevelController;
Route::post('/levels/promo', [LevelController::class, 'getPromos'])->name('level.promo');

//demande de stage
use App\Http\Controllers\DemandeController;
Route::get('/demande', [DemandeController::class, 'index'])->name('demande.index');
Route::post('/demande/store', [DemandeController::class, 'store'])->name('demande.store');
Route::get('/demande/data', [DemandeController::class,'dataTableJson'])->name('demande.data');
Route::delete('/demande/stg/{demande}', [DemandeController::class, 'destroy'])->name('demande.destroy');
Route::post('/demande/Stages/accept', [DemandeController::class, 'accept'])->name('demande.accept');

//les notes
use App\Http\Controllers\MarkController;
Route::get('mark/create/{level}', [MarkController::class, 'create']);
Route::post('mark', [MarkController::class, 'store']);
Route::get('mark', [MarkController::class, 'index']);
Route::get('mark/{module}', [MarkController::class, 'show']);
Route::get('mark/affichage/{user}', [MarkController::class, 'affichage']);
use App\Http\Controllers\PhdController;
Route::post('/prof/active/all/{id}',[PhdController::class,"findAll"]);

//biblio
use App\Http\Controllers\LibraryController;
//Route::get('/library', [LibraryController::class, 'index']);
Route::get('/library/create', [LibraryController::class, 'create']);
Route::post('/library/store', [LibraryController::class, 'store']);
Route::get('/library/data', [LibraryController::class, 'data']);
Route::delete('/library/{library}', [LibraryController::class, 'destroy']);
//Route::get('/library/show', [LibraryController::class, 'show']);
Route::get('/library/public', [LibraryController::class, 'getData'])->name('library.data');
Route::post('/library/reserve', [LibraryController::class, 'reserve']);
Route::post('/library', [LibraryController::class, 'update']);


//request-type
use App\Http\Controllers\RequestTypeController;
Route::get('request-type/data', [RequestTypeController::class, 'getData']);
Route::resource('request-type', RequestTypeController::class)->middleware('auth');

//request
use App\Http\Controllers\RequestController;
//Route::get('/demandes', [RequestController::class, 'demande']);
Route::get('/request/data', [RequestController::class, 'getData']);
Route::post('/request/data', [RequestController::class, 'dataStudent']);
Route::resource('request', RequestController::class);


//GESTION USER
//Route::get('/user/gestion', [UserController::class, 'gestion']);
Route::get('/users/data', [UserController::class, 'users']);
Route::delete('/user/{user}', [UserController::class, 'destroy']);
Route::put('/user/{user}', [UserController::class, 'verify']);
Route::put('/user/retablirPassword/{user}', [UserController::class, 'reinstatePassword']);

Route::get('/collaboration', function(){
    return view('collaboration');
});


////////////////////////////////////////////////////////////////////////////
Route::post('/roles/allJson',"App\Http\Controllers\RoleController@jsonAll");

use App\Http\Controllers\EmailController;
Route::get('/contact', function(){return view("contact.index");});
Route::post('/contact/submit',[EmailController::class,'contact_us']);
Route::post('/api/email/create',[EmailController::class,'createAccount']);
Route::get('/emailing',[EmailController::class,'getSendEmailsView']);
Route::post('/api/email/prof/send',[EmailController::class,'sendMessagePromos']);
Route::get('/api/emailing',[EmailController::class,'getSendEmailsViewapi']);

use App\Http\Controllers\ModuleController;
//Route::any('/modules/management',[ModuleController::class,'index']);
Route::post('/modules/datatable',[ModuleController::class,'show']);
Route::post('/modules/store',[ModuleController::class,'store']);
Route::delete('/modules/delete/{module}',[ModuleController::class,'destroy']);
Route::post('/modules/find/{id}',[ModuleController::class,'findById']);
Route::post('/modules/update/{module}',[ModuleController::class,'update']);  

use App\Http\Controllers\ModuleLevelController;
Route::post('/modules/courses/find',[ModuleLevelController::class,'findAll']);

use App\Http\Controllers\ProfModuleController;
//Route::any('/modules/management/prof',[ProfModuleController::class,'index']);
Route::post('/modules/management/prof/all',[ProfModuleController::class,'findAll']);
Route::post('/modules/management/prof/find/{id}',[ProfModuleController::class,'findByIdModule']);
Route::post('/modules/management/prof/add',[ProfModuleController::class,'store']);
Route::get('/prof/byLevel',[ProfModuleController::class,'findAllByLevel']);
Route::any('/api/prof/moduleLevel',[ProfModuleController::class,'findByProf']);

use App\Http\Controllers\TimetableController;
Route::get('/api/levels/getAll', [LevelController::class, 'getPromos']);
Route::get('/TimeTable', [TimetableController::class, 'index']);
Route::get('/api/timetables/getAll', [TimetableController::class, 'GetAllP']);
Route::post('/api/timetables/add', [TimetableController::class, 'store']);
Route::post('/api/timetables/edit', [TimetableController::class, 'update']);

/* Cours */
use App\Http\Controllers\CourseController;
Route::get('/cours/management',[CourseController::class,'managementIndex']);
Route::post('/api/cours/add',[CourseController::class,'store']);
Route::post('/api/cours/update/{course}',[CourseController::class,'update']);
Route::post('/api/cours/delete/{course}',[CourseController::class,'destroy']);
Route::post('/api/cours/deletebulk',[CourseController::class,'destroyArray']);
Route::post('/api/cours/data',[CourseController::class,'DataTable']);
Route::post('/api/cours/find/{course}',[CourseController::class,'findById']);
Route::get('/api/cours/download/{course}',[CourseController::class,'Download']);
Route::post('/api/cours/video/{course}',[CourseController::class,'VideoUpload']);
Route::any('/api/cours/video/get/{course}',[CourseController::class,'VideoURL']);
Route::any('/cours/{course}',[CourseController::class,'findOne']);
Route::any('/cours/module/{module}',[CourseController::class,'findAllByModule']);
Route::any('/cours/level/{level}',[CourseController::class,'findAllByLevel']);
Route::any('/cours/filiere/{filiere}',[CourseController::class,'findAllByFiliere']);
Route::any('/cours/archive/module/{module}',[CourseController::class,'findAllByModuleArchive']);
Route::any('/cours/archive/level/{level}',[CourseController::class,'findAllByLevelArchive']);
Route::any('/cours/archive/filiere/{filiere}',[CourseController::class,'findAllByFiliereArchive']);
Route::any('/coursMaClasse',[CourseController::class,'myClass']);

/* PDF Viewers */
use App\Http\Controllers\PDFPreviewController;
Route::post('/api/cours/visit/add',[PDFPreviewController::class,'store']);
Route::post('/api/cours/visit/count/{course}',[PDFPreviewController::class,'countVisit']);

/*Questions*/
use App\Http\Controllers\QuestionController;
//Route::any('/questions',[QuestionController::class,'index']);
Route::post('/api/questions/add',[QuestionController::class,'store']);
Route::get('/api/questions/student/all',[QuestionController::class,'findAllStudent']);
Route::post('/api/questions/delete/{question}',[QuestionController::class,'destroy']);
Route::post('/api/questions/confirm/{question}',[QuestionController::class,'confirm']);
Route::post('/api/questions/reply/{question}',[QuestionController::class,'reply']);
Route::get('/api/questions/prof/all',[QuestionController::class,'findAllProf']);

Route::get('/about', function(){
    return view('about');
});

use App\Http\Controllers\DepartementController;
Route::any('/departement', [DepartementController::class, 'departement']);

Route::get('/etudes', [ModuleLevelController::class, 'etude']);

use App\Http\Controllers\Auth\ForgotPasswordController;
Route::get("/forget",[ForgotPasswordController::class,'indexForget']);
Route::get("/forget/{vkey}",[ForgotPasswordController::class,'indexChange']);
Route::post("/forget",[ForgotPasswordController::class,'reset'])->name('reset');
Route::post("/forget/{vkey}",[ForgotPasswordController::class,'changePass'])->name('changepass');
/*********************************/
Route::get('/api/cours/getlevels',[CourseController::class,'GetMbyLevels']);
Route::get('/api/cours/Modulescc/{module}',[CourseController::class,'GetMCrs']);
Route::get('/api/cours/getone/{c}',[CourseController::class,'getOneCours']);

Route::get('/api/levels/{l}', [LevelController::class, 'getPromosbyf']);
Route::get('/modules/getMbyle/{l}',[ModuleLevelController::class,'findbyLevel']);
Route::get('/api/modules/getAllModules',[ModuleController::class,'GetAllModules']);
Route::get('/api/cours/ModulesccArchive/{module}',[CourseController::class,'GetMCrsALL']);
Route::get('/api/modules/getlevels/{m}',[ModuleLevelController::class,'findbyModules']);
Route::get('/api/internship/getdata', [InternshipController::class, 'Intershipshowdata']);
Route::get('/api/demande/get', [RequestController::class, 'getDemandes']);
Route::get('/api/demande/getCNE', [RequestController::class, 'getCNE']);

/*********************************/
Route::get('/api/mark/prof', [MarkController::class, 'GetModuleForP']);
Route::get('/api/mark/Stud/{level}', [MarkController::class, 'GetStudentForM']);

/* Statistics */
use App\Http\Controllers\StatisticController;
Route::get('/api/statistic/dashboard',[StatisticController::class,"dashboard"]);
Route::get('/statistic/dashboard',[StatisticController::class,"dashboardIndex"]);

//React's Route

Route::view('/Dashbord/{path?}', 'Dashbord.index')->middleware(['auth',"checkUSer"]);
Route::view('/Dashbord/{path?}/{p?}', 'Dashbord.index')->middleware(['auth',"checkUSer"]);
Route::view('/Dashbord/{path?}/{p?}/{f?}', 'Dashbord.index')->middleware(['auth',"checkUSer"]);

use App\Http\Controllers\MessageController;
Route::get('/api/message/getUsers', [MessageController::class, 'getUsers']);
Route::post('/api/message/getConv', [MessageController::class, 'getConversation']);
Route::get('/api/message/UserId', [MessageController::class, 'getId']);
Route::post('/api/message/send', [MessageController::class, 'SendMessage']);
Route::post('/api/message/getCovbyId', [MessageController::class, 'getConversationbyId']);
Route::get('/api/message/getListConv', [MessageController::class, 'getConversationList']);
Route::get('/api/mark/show/{module_level}', [MarkController::class, 'showModulenote']);
Route::get('/api/profil/getUserProfile', [UserController::class, 'getUserProfile']);
Route::get('/api/message/NotSeen', [MessageController::class, 'getSEen']);
Route::get('/api/user/ROles', [MessageController::class, 'getRoleId']);
Route::get('/api/mark/affichage', [MarkController::class, 'affichageUser']);
Route::get('/api/user/photo', [MessageController::class, 'getPathimg']);

/* History */
use App\Http\Controllers\HistoryController;
Route::get('/api/history/findAll', [HistoryController::class, 'findAll']);
Route::view('/history',"history.index")->middleware('auth');
/*test emails 
Route::get('/email/{level}', [CourseController::class, 'getEmailsFromLevel']);
/* end test */
use App\Http\Controllers\HomewoorkController;

Route::get('/api/Homewoork/getModules', [HomewoorkController::class, 'getModules']);
Route::post('/api/Homewoork/store', [HomewoorkController::class, 'store']);
Route::get('/api/Homewoork/getdDataProf', [HomewoorkController::class, 'getHomeworksProf']);
Route::delete('/api/Homewoork/delete/{id}', [HomewoorkController::class, 'destroy']);
Route::get('/api/Homewoork/getdDataStudent', [HomewoorkController::class, 'getHomeworksStudents']);
Route::post('/api/Homewoork/UploadStudnt', [HomewoorkController::class, 'ulpoadtStudent']);
Route::get('/api/Homewoork/getdata/levels/{id}', [HomewoorkController::class, 'getHomeworksProfdata']);
Route::get('/api/Homewoork/download/{id}', [HomewoorkController::class, 'Download']);


/* Exams */
use App\Http\Controllers\ExamController;
Route::get('/prof/exam', [ExamController::class, 'addView']);
Route::get('/prof/exam/{exam}', [ExamController::class, 'qstView']);
Route::get('/api/prof/exam/all', [ExamController::class, 'getExams']);
Route::post('/api/prof/exam/add', [ExamController::class, 'createExam']);
Route::post('/prof/exam/{exam}', [ExamController::class, 'addQst']);
Route::post('/api/prof/exam/{exam}', [ExamController::class, 'editQst']);
/*Route::get('/api/student/exam/{exam}', [ExamController::class, 'getQuestion']);*/
Route::post('/api/student/exam/cheated/{exam}', [ExamController::class, 'cheated']);
Route::post('/api/student/exam/response', [ExamController::class, 'responseValidate']);
Route::get('/exam/{exam}', [ExamController::class, 'getExamView']);
Route::post('/exam/{exam}', [ExamController::class, 'getQuestion']);
Route::get('/exam/result/{exam}', [ExamController::class, 'getResultView']);
Route::get('/exam/prof/result', [ExamController::class, 'getExamResultProf']);
Route::get('/api/exam/prof/result', [ExamController::class, 'getExamReultapi']);
Route::get('api/exam/prof/result/{exam}', [ExamController::class, 'getMarksByExam']); 

use Illuminate\Support\Facades\Storage;
Route::get('/logo', function(){
    return Storage::download("/logo.png");
});

Route::get('/total/{cne}', [MarkController::class, 'getNoteTotal']);
Route::get('/getVerified', function(){
    return view('notverified');
});

route::get('/testinglevelup/{cne}', [UserController::class, 'DecisionAvancement']);
