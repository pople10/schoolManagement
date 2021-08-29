
    
    @include("includes.head")

    @include("includes.menu")

  
    <!-- Nawal Ait Ahmed added :  home page  -->
    
    <div class="bootstrap">
     <div class=" full-content" style="width: 70%; margin: auto;" >
      
      <!-- slider show--> 
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" >
               <ol class="carousel-indicators">
                   <li data-target="#carouselExampleIndicators" id="indic-1" data-slide-to="0" class="active"></li>
                   <li data-target="#carouselExampleIndicators" id="indic-2" data-slide-to="1"></li>
                   <li data-target="#carouselExampleIndicators" id="indic-3" data-slide-to="2"></li>
                </ol>
             <div class="carousel-inner">
                   <div class="carousel-item active" id="first">
                         <img class="d-block w-100" src="/resources/images/slider-1.jpg" alt="First slide"  >
                          <div class="carousel-caption d-none d-md-block">
                                  <h3> l'Ecole Nationale des Sciences Appliquées <br> d'Al-Hoceima (ENSAH) </h3>
                                  <p> Grande école d'ingénieurs </p>
                          </div>
                   </div>
                  <div class="carousel-item" id="second">
                           <img class="d-block w-100" src="/resources/images/slider-2.jpg" style="height:100%" alt="Second slide">
                           <div class="carousel-caption d-none d-md-block">
                                  <h3> l'Ecole Nationale des Sciences Appliquées<br> d'Al-Hoceima (ENSAH) </h3>
                                  <p> Grande école d'ingénieurs </p>
                            </div>
                  </div>
                  <div class="carousel-item" id="third">
                            <img class="d-block w-100" src="/resources/images/slider-3.jpg" style="height:100%" alt="Third slide">
                            <div class="carousel-caption d-none d-md-block ">
                                  <h3> l'Ecole Nationale des Sciences Appliquées <br> d'Al-Hoceima (ENSAH) </h3>
                                  <p> Grande école d'ingénieurs </p>
                            </div>
                   </div>
             
              </div>
           <a class="carousel-control-prev carousel-ensa" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
           </a>
           <a class="carousel-control-next carousel-ensa" href="#carouselExampleIndicators" role="button" data-slide="next">
             <span class="carousel-control-next-icon" aria-hidden="true"></span>
             <span class="sr-only">Next</span>
            </a>
         </div>
      
        <!--start bloc description & présentation -->
          <div class="container-bloc" style ="text-align: center;"  >
               <div class="row" >
                  <div class="col-md" >
                   <div class="bloc-title" >
                     <h2 class="title-pr"  >Notre projet </h2>
                   </div>
                      <hr style="animation-play-state: paused;" align="right" width="100%">
          
                <div class="thumbnail" >
                  <div class="content-thumbnail" >
                    <div class="bloc-text  ">
                       <p> this laravel project that was coded by:<br>
                       <strong><em>Mohammed Amine AYACHE</em></strong>
                       <strong><em>Nawal Aït Ahmed</em></strong>
                       <strong><em>Omar Ezzarqtouni</em></strong>
                       <strong><em>Nisrine Amghar</em></strong>
                       <strong><em>Tayeb Hamdaoui</em></strong>.<br>
                       that emulates our school site, with far applicable improvements, especially
                       the administrative operations that are all automated, from student marks, internships, levels, 
                       records and faculty requests have been integrated to our site, the technologies used in this project are:
                       <em>larevel</em>, <em>react</em>, <em>javascript</em>, <em>bootstrap</em>, <em>JQuery</em>, <em>Sass</em>,
                       <em>DataTable</em>, <em>Semantic UI</em> and other javascript libraries....
                       </p>
                    </div>
                  </div>
                 </div>
           </div>
      
      
      <div class="col-md" >
                <div class="bloc-title"  >
                     <h2 class="title-pr" >Présentation </h2>
                </div>
                <hr style="animation-play-state: paused;" align="right" width="100%">
          <div class="thumbnail" >
              <div class="content-thumbnail">
                <div class="bloc-text  ">
                <p>
                    Créée en 2008, <strong>l'Ecole Nationale des Sciences Appliquées d'Al Hoceima (ENSAH)</strong> est un établissement public d'enseignement supérieur relevant de l'université Abdelmalek Essaadi. Sa création s'inscrit dans l'optique de favoriser la formation des ingénieurs d'Etat hautement qualifiés dans les spécialités les plus ouvertes et susceptibles de connaître d'importants développements au sein du tissu socio-économique régional et national.
                    Le positionnement de l'Ecole contribuera à lui conférer une dimension euro-méditerranéenne et à répondre aux besoins régionaux et nationaux en matière de formation en ingénierie.
                    <br><a href="{{URL::asset('/about')}}" target=_blanc > ...Lire la suite »</a>                 
                </p>
               </div>
              </div>
          </div>
      </div>
      
      <div class="col-md" >
                <div class="bloc-title"  >
                     <h2 class="title-pr" >Collaboration </h2>
                </div>
                <hr style="animation-play-state: paused;" align="right" width="100%">
          <div class="thumbnail" >
              <div class="content-thumbnail">
                <div class="bloc-text  ">
                <p>
                    <a href="{{URL::asset('/collaboration')}}">ENSAH et L’EIL Côte d’Opale</a>                 
                </p>
               </div>
              </div>
          </div>
      </div>      
     </div>
     
    </div>
         
        <!-- start bloc formation -->
        
      <div class="countainer-bloc" style="width: 100%;" >
          <div class="thumbnail-2" >
            <div class="content-thumbnail-2" >
                  <div class="bloc-title" >
                    <h2 class="title-pr"  >Formation </h2>
                  </div>
                   <hr style="animation-play-state: paused;" align="right" width="100%">
                  <div class="row" style="margin-top:20px;"  >
                    
                      <div class="col-md-6"  >
                         <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow p-3 mb-5 bg-white rounded position-relative">
                           <div class="col p-4 d-flex flex-column position-static   ">                         
                              <h6 class="mb-0">Cycle préparatoire  </h6>
                              <br>
                              <br>
                              <a href="{{URL::asset('/prepas')}}" class="btn btn-primary " role="button" target=_blanc > Détail >> </a> 
                            </div>
                            <div class="col-auto d-none d-lg-block" style="margin: auto; margin-right:10px;">
                               <img  class="bd-placeholder-img rounded-circle" width="140" height="140" src="/resources/images/fr2.jpg" alt="formation "  >
                            </div>
                          </div>
                      </div>
                       
                      <div class="col-md-6">
                        <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow p-3 mb-5 bg-white rounded position-relative">
                           <div class="col p-4 d-flex flex-column position-static">                         
                              <h6 class="mb-0">Génie  informatique </h6>
                              <br>
                              <br>
                              <a href="{{URL::asset('/departement')}}" class="btn btn-primary" role="button" target=_blanc > Détail >> </a> 
                            </div>
                            <div class="col-auto d-none d-lg-block" style="margin: auto; margin-right:10px;">
                               <img  class="bd-placeholder-img rounded-circle" width="140" height="140" src="/resources/images/gi.jpg" alt="formation "  >
                            </div>
                          </div>
                      </div>
                      
                      <div class="col-md-6">
                        <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow p-3 mb-5 bg-white rounded position-relative">
                           <div class="col p-4 d-flex flex-column position-static">                         
                              <h6 class="mb-0">Génie civil </h6>
                              <br>
                              <br>
                              <a href="{{URL::asset('/departement')}}" class="btn btn-primary" role="button" target=_blanc > Détail >> </a> 
                            </div>
                            <div class="col-auto d-none d-lg-block" style="margin: auto; margin-right:10px;" >
                               <img  class="bd-placeholder-img rounded-circle" width="140" height="140" src="/resources/images/gc.jpg" alt="formation " >
                            </div>
                          </div>
                      </div>
                      
                      <div class="col-md-6">
                        <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow p-3 mb-5 bg-white rounded position-relative">
                           <div class="col p-4 d-flex flex-column position-static">                         
                              <h6 class="mb-0"> Génie énergétique et énergies renouvelables </h6>
                            
                              <br>
                              <a href="{{URL::asset('/departement')}}" class="btn btn-primary" role="button" target=_blanc > Détail >> </a> 
                            </div>
                            <div class="col-auto d-none d-lg-block" style="margin: auto; margin-right:10px;" >
                               <img  class="bd-placeholder-img rounded-circle" width="140" height="140" src="/resources/images/geer.jpg" alt="formation "  >
                            </div>
                          </div>
                      </div>
                      
                      <div class="col-md-6 mx-auto" >
                        <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow p-3 mb-5 bg-white rounded position-relative">
                           <div class="col p-4 d-flex flex-column position-static">                         
                              <h6 class="mb-0"> Génie de l'eau et l'Envirounnement </h6>
                              <br>
                              <br>
                              <a href="{{URL::asset('/departement')}}" class="btn btn-primary" role="button" target=_blanc > Détail >></a> 
                            </div>
                            <div class="col-auto d-none d-lg-block " style="margin: auto; margin-right:10px;" >
                               <img  class="bd-placeholder-img rounded-circle" width="140" height="140" src="/resources/images/gee.jpeg" alt="formation "  >
                            </div>
                          </div>
                      </div>
                
                  </div>
                                    
              </div>
          </div>
      </div>
          <!--end formation-->
          
          
          
          <div class="row">
            
            <!--bloc ACTUALITEES-->
           <div class="col-md-8">  
            <div class="container-actualitées" >
              <div class="bloc-title" >
                <h2 class="title-pr"  >actualités </h2>
              </div>
                <hr style="animation-play-state: paused;" align="right" width=" 100%">
            @foreach($announcement as $ann)
            
	          <div class="blog-list-post clearfix">
              <div class="views-field views-field-field-datepub" >
                  <div class="blog-date" >
                    <span class="date-display-single" property="dc:date" datatype="xsd:dateTime" content="2021-02-16T00:00:00+01:00">
                      <i class="fas fa-calendar-alt"></i>{{$ann->created_at}}</span>
                  </div>
                </div>
                  <div class="content"  >
                   <div class="blog-list-thumb" >
                     <a href="{{URL::asset('/annonce/'.$ann->id)}}">
                      <img src="/resources/images/l.png" alt="logo-ensah" class="act-img" >
                     </a>
                    </div>
                   </div>
                    <div class="blog-list-details">
                     <h5 class="blog-list-title" style="height:85px;overflow:hidden;">
                       <a href="{{URL::asset('/annonce/'.$ann->id)}}">
                       <span class="blink_me" style="color: #000" > {{$ann->content}}</span>
                      </a>
                     </h5>
                      <a class="views-more-link" href="{{URL::asset('/annonce/'.$ann->id)}}" target=_blanc > ...Lire la suite »</a>                 
                    </div>
              </div>                
                
            @endforeach

	        	        
            <div class="text-right">
              <a class="more" href="{{URL::asset('/annonce')}}" target="_blank">
                <i class="fa fa-plus"></i> Plus d'infos
              </a>
            </div>
              
              
              
            
              </div>
           </div>
            <!--end bloc ACTUALITEES-->
            
           <!--bloc raccouris -->
            <div class="col-md-4">
              
              <div class="bloc-title" >
                <h2 class="title-pr"  >raccourcis</h2>
              </div>
                <hr style="animation-play-state: paused;" align="right" width="100%">

              <div class="list-boxed-wrap">
                <ul class="list-boxed" style="padding: 0">
                 <div class="row" >
                  <li class="list">
                      <a href="{{URL::asset('/about')}}"> <img src="/resources/images/About_us.png"  width="60" height="60" alt="About us" title="About us" /> </a>
                  </li>
                  <li class="list">
                      <a href="{{URL::asset('/Dashbord/Biblio/List')}}"> <img src="/resources/images/bibliotheque.png"  width="60" height="60" alt="bibliotheque" title="bibliotheque" /> </a>
                  </li>
                  <li class="list">
                      <a href="{{URL::asset('/Dashbord/TimesTable')}}"> <img src="/resources/images/emplois-du-temps.png"  width="60" height="60" alt="emplois du temps" title="emplois du temps" /> </a>
                  </li>
                  
                  </div>
                </ul>
              </div>
               <!--end blog raccorcis-->
               <!--start blog notes  ( here we have a problem !! slider isn't working )-->
               
               <div class="bloc-title" >
                 <h2 class="title-pr"  >LOGO </h2>
               </div>
                <hr style="animation-play-state: paused;" align="right" width=" 100%">
               <div class="list-boxed-wrap">
                   <div class="meta" style="padding:5px;">
                       <p style="color:grey" >Vous pouvez télécharger le logo officiel en grandes demensions en cliquant sur ce <a href="/logo">lien</a><center><img class="ui small image"  src="/resources/images/logo.png" alt="Ensah LOGO" /></center></p>
                   </div>
               </div>
                
             <!--s (  !! slider isn't working )-->
                <!--
               <div class="news-list">
                 <div id="notesCarousel" class="carousel slide" data-ride="carousel">
                   
                  <div class="carousel-inner">
                    
                   <div class="carousel-item active">
                    <a href="//" target="_blank">
                      <span class="news-item">
                       <img class="d-block w-100" src="/resources/images/vacances.jpg" alt="First slide" width="300px" height="150px" >
                      </span>
                       <span class="content">
                         <span class="title">Calendrier de vacances un...</span>
                          <span class="abstract">
                           <p>  Calendrier de vacances universitaire 2020-2021 </p>
                          </span>
                        </span>
                     </a>
                    </div>
                   
                     <div class="carousel-item active">
                        <a href="//" target="_blank">
                         <span class="news-item">
                           <img class="d-block w-100" src="/resources/images/calendar.jpg" alt="second slide" width="300px" height="150px" >
                          </span>
                          <span class="content">
                            <span class="title">Calendrier de vacances un...</span>
                              <span class="abstract">
                              <p> 
                                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                 Calendriers Académiques 2020 - 2021 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &amp;n...
                                </p>
                              </span>
                             </span>
                          </a>
                       </div>
                     
                     <div class="carousel-item active">
                        <a href="//" target="_blank">
                         <span class="news-item">
                           <img class="d-block w-100" src="ressources/images/assurance.jpg" alt="third slide" width="300px" height="150px" >
                          </span>
                          <span class="content">
                            <span class="title">AVIS AUX ETUDIANTS  Objet...</span>
                              <span class="abstract">
                               <p> 
                                 AVIS AUX ETUDIANTS
                                 Objet&nbsp;: Assurance Maladie Obligatoire
                                 &nbsp;
                                 Afin de permettre aux étudiants de l'ENSAH, inscrits au programme d’Assurance&nbsp;Maladie Obligatoire (AMO), de suive l'état ...
                                </p>
                              </span>
                          </span>
                          </a>
                       </div>
                     
                  </div>
                  
                  
                     <div id="slider-control">
                            <a class="left carousel-control" href="#notesCarousel" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#notesCarousel" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                      </div>

                 </div>
              
               </div>
               
                  <div class="text-right">
                      <a class="more" href="///" target="_blank">
                        <i class="fa fa-plus"></i> Plus de notes
                      </a>
                  </div> -->
                  
            <!-- end blog notes-->
           </div>
       
          <!--end blog raccorcis & notes -->

            
         </div>    
             
             
   </div>
      
  </div>   
    
 
  
    
 
 
       
     <!-- <div style="height:600px;">Sam</div> -->
      <script src="{{URL::asset('/resources/js/carousel.js')}}" ></script>
    @include("includes.footer")
