@include('includes.head')
@include('includes.menu')
<link href="{{URL::asset('resources/css/statistic.css')}}" rel="stylesheet"/>
<div class = "bootstrap">
        <div class="w-75 mx-auto p-3 mt-45 mb-10">
            <h2>Dashboard</h2>
        </div>
                <div class="w-95 mx-auto p-3 mt-2 mb-10">
                    <div class="row">
				        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-row">
                                        <div class="col-3 align-self-center">
                                            <div class="round">
                                                <i class="mdi mdi-school"></i>
                                            </div>
                                        </div>
                                        <div class="col-9 align-self-center text-right">
                                            <div class="m-l-10">
                                                <h5 id="nbrstudent" class="mt-0"></h5>
                                                <p class="mb-0 text-muted">Etudiant</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progressParent m-2">
                                        <div id="allprog-std" class="progressSuccess"></div>
                                    </div>
                                </div>
                                    <!--end card-body-->
                            </div>
                                <!--end card-->
                        </div>
                            <!--end col-->

                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-row">
                                        <div class="col-3 align-self-center">
                                            <div class="round">
                                                <svg style="width:30px;height:30px;top: 8px; position: relative;" viewBox="0 0 24 24"> <path fill="currentColor" d="M20,17A2,2 0 0,0 22,15V4A2,2 0 0,0 20,2H9.46C9.81,2.61 10,3.3 10,4H20V15H11V17M15,7V9H9V22H7V16H5V22H3V14H1.5V9A2,2 0 0,1 3.5,7H15M8,4A2,2 0 0,1 6,6A2,2 0 0,1 4,4A2,2 0 0,1 6,2A2,2 0 0,1 8,4Z" /> </svg>
                                            </div>
                                        </div>
                                        <div class="col-9 text-right align-self-center">
                                            <div class="m-l-10 ">
                                                <h5 id="nbrprof" class="mt-0"></h5>
                                                <p class="mb-0 text-muted">Professeurs</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progressParent m-2">
                                        <div id="allprog-prf" class="progressPrimary"></div>
                                    </div>
                                </div>
                                    <!--end card-body-->
                            </div>
                                <!--end card-->
                        </div>
                            <!--end col-->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-row">
                                        <div class="col-3 align-self-center">
                                            <div class="round">
                                                <i class="mdi mdi-account-network"></i>
                                            </div>
                                        </div>
                                        <div class="col-9 text-right align-self-center">
                                            <div class="m-l-10 ">
                                                <h5 id="nbradmin" class="mt-0"></h5>
                                                <p class="mb-0 text-muted">Administrateurs</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progressParent m-2">
                                        <div id="allprog-adm" class="progressError"></div>
                                    </div>
                                </div>
                                    <!--end card-body-->
                            </div>
                                <!--end card-->
                        </div>
                            <!--end col-->
		            </div>
		            <!-- END USERS -->
		            <div class="row">
				        <div class="col-lg-4">
                            <div class="card">
            					<div class="card-body">
            						<h5 class="header-title mt-0  mb-3">Etat des Etudiants</h5>
                                    <canvas id="ee" height="258" width="364" style="width: 364px; height: 258px;"></canvas>
            					</div>
            				</div>
                                <!--end card-->
                        </div>
                            <!--end col-->

                        <div class="col-lg-4">
                            <div class="card">
            					<div class="card-body">
            						<h5 class="header-title mt-0  mb-3">Etat des Professeurs</h5>
                                    <canvas id="ep" height="258" width="364" style="width: 364px; height: 258px;"></canvas>
            					</div>
            				</div>
                                <!--end card-->
                        </div>
                            <!--end col-->
                        <div class="col-lg-4">
                            <div class="card">
            					<div class="card-body">
            						<h5 class="header-title mt-0  mb-3">Etat des Administrateurs</h5>
                                    <canvas id="ea" height="258" width="364" style="width: 364px; height: 258px;"></canvas>
            					</div>
            				</div>
                                <!--end card-->
                        </div>
                            <!--end col-->
		            </div>
		            <!-- END USERS STATES -->
		            <div class="row">
				        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-row">
                                        <div class="ui mx-auto statistics">
                                          <div class="statistic">
                                            <div class="value">
                                              <img src="{{URL::asset('resources/images/courses.png')}}" class="ui circular inline image">
                                              <span id="coursesNBR"></span>
                                            </div>
                                            <div class="label">
                                              Nombre des cours publiés
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                    <!--end card-body-->
                            </div>
                                <!--end card-->
                        </div>
                            <!--end col-->

                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-row">
                                        <div class="ui mx-auto statistics">
                                          <div class="statistic">
                                            <div class="value">
                                              <img src="{{URL::asset('resources/images/internshipIcon.png')}}" class="ui circular inline image">
                                              <span id="internshipNBR"></span>
                                            </div>
                                            <div class="label">
                                              Nombre des offres des stages publiés
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                    <!--end card-body-->
                            </div>
                                <!--end card-->
                        </div>
                            <!--end col-->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-row">
                                        <div class="ui mx-auto statistics">
                                          <div class="statistic">
                                            <div class="value">
                                              <img src="{{URL::asset('resources/images/annoncementIcon.png')}}" class="ui circular inline image">
                                              <span id="announcementNBR"></span>
                                            </div>
                                            <div class="label">
                                              Nombre des annonces publiées
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                    <!--end card-body-->
                            </div>
                                <!--end card-->
                        </div>
                            <!--end col-->
		            </div>
		            <!-- END OTHERS -->
		            <div class="row">
				        <div class="col-lg-6">
                            <div class="card">
            					<div class="card-body">
            						<h5 class="header-title mt-0  mb-3">Ajout des utilisateurs pendant <span class="year"></span></h5>
                                    <canvas id="usersgraph" height="350" width="540" style="width: 90%; height: 600px!important;"></canvas>
            					</div>
            				</div>
                                <!--end card-->
                        </div>
                            <!--end col-->
                        <div class="col-lg-6">
                            <div class="card">
            					<div class="card-body">
            						<h5 class="header-title mt-0  mb-3">Ajout des cours pendant <span class="year"></span></h5>
                                    <canvas id="coursesgraph" height="350" width="540" style="width: 90%; height: 600px!important;"></canvas>
            					</div>
            				</div>
                                <!--end card-->
                        </div>
                            <!--end col-->
		            </div>
		            <!-- END USERS AND COURSES EVOLUTION -->
		            <div class="row">
				        <div class="col-lg-6">
                            <div class="card">
            					<div class="card-body">
            						<h5 class="header-title mt-0  mb-3">10 professeurs qui publient plus des cours pendant <span class="year"></span></h5>
                                    <canvas id="coursesprof" height="350" width="540" style="width: 90%; height: 600px!important;"></canvas>
            					</div>
            				</div>
                                <!--end card-->
                        </div>
                            <!--end col-->
                        <div class="col-lg-6">
                            <div class="card">
            					<div class="card-body">
            						<h5 class="header-title mt-0  mb-3">10 étudiants qui consultent plus des cours pendant <span class="year"></span></h5>
                                    <canvas id="coursesstudent" height="350" width="540" style="width: 90%; height: 600px!important;"></canvas>
            					</div>
            				</div>
                                <!--end card-->
                        </div>
                            <!--end col-->
		            </div>
		            <!-- END TOP 10 EVOLUTION -->
		            <div class="row">
				        <div class="col-xl-8">
                            <div class="card">
            					<div class="card-body">
            						<h5 class="header-title mt-0  mb-3">Evolution du traitement des demandes en <span class="year"></span></h5>
                                    <canvas id="requestsLine" height="350" width="540" style="width: 90%; height: 600px!important;"></canvas>
            					</div>
            				</div>
                                <!--end card-->
                        </div>
                            <!--end col-->
                        <div class="col-xl-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card" style="margin-bottom: 0px; padding-bottom: 0px;">
                    					<div class="card-body">
                    						<div class="d-flex flex-row">
                                                <div class="ui mx-auto statistics">
                                                  <div class="statistic">
                                                    <div class="value">
                                                      <img src="{{URL::asset('resources/images/request.svg')}}" class="ui circular inline image">
                                                      <span id="requestsNBR"></span>
                                                    </div>
                                                    <div class="label">
                                                      Nombre des demandes au totale
                                                    </div>
                                                  </div>
                                                </div>
                                            </div>
                    					</div>
                    				</div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="card" style="margin-bottom: 28px; padding-bottom: 0px;">
                    					<div class="card-body">
                    						<div class="d-flex flex-row">
                                                <div class="ui mx-auto statistics">
                                                  <div class="statistic">
                                                    <div class="value">
                                                      <img src="{{URL::asset('resources/images/requestTypeIcon.png')}}" class="ui circular inline image">
                                                      <span id="requestsTypeNBR"></span>
                                                    </div>
                                                    <div class="label">
                                                      Nombre des types des demandes
                                                    </div>
                                                  </div>
                                                </div>
                                            </div>
                    					</div>
                    				</div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="card">
                    					<div class="card-body">
                    						<h5 class="header-title mt-0  mb-3">L'état des demandes</h5>
                                            <canvas id="er" height="350" width="540" style="width: 90%; height: 600px!important;"></canvas>
                    					</div>
                    				</div>
                                </div>
                            </div>
                                <!--end card-->
                        </div>
                            <!--end col-->
		            </div>
                </div>
</div>
<script src="{{URL::asset('resources/js/statistic_dashboard.js')}}?t={{time()}}"></script>
@include('includes.footer')