    <header>
            <div class="f____c" style=" min-height: 30px!important; background: #353698; ">
                <div class="right fixedBar">
                     @guest
                            @if (Route::has('login'))
                                    <a style="color:white;" class="nav-link" href="{{ route('login') }}"><i class="fa fa-sign-in-alt" aria-hidden="true"></i> {{ __('Se connecter') }} </a> 
                            @endif
                                                               <span style=" color: ref; color: #ffffffb8; "> | </span>  

                            @if (Route::has('register'))
                                    <a style="color:white;" href="{{ route('register') }}"><i class="fas fa-user-plus"></i> {{ __('Registre') }}</a>
                            @endif
                        @else
                                <a style="color:white;" id="llogout" href="/profil" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                   <i class="fas fa-user-alt"></i> {{ Auth::user()->fname." ".Auth::user()->lname }}
                                </a>
                                <span style=" color: ref; color: #ffffffb8; "> | </span> 
                                <a style="color:white;" id="llogout" href="/Dashbord" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fas fa-columns"></i> {{ __('Espace d\'utilisation') }}
                                </a>
                                   <span style=" color: ref; color: #ffffffb8; "> | </span> 
                                <div  aria-labelledby="navbarDropdown">
                                    <a style="color:white;" href="{{ route('logout') }}"
                                      onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"> 
                                        <i class="fas fa-sign-out-alt"></i>{{ __('Se déconnecter') }}
                                    </a>

                                    <form style="color:white;" id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                        @endguest
                </div>
            </div>
            <div class="f____c">
                <img src="{{URL::asset('/resources/images/l.png')}}">
                <div id="fc____univ" >
                    <span class="fc___un___el01">Université</span><br>
                    <span class="fc___un___el02">Abdelmalek essaadi</span><br>
                    <span class="fc___un___el03">Ecole Nationale des Sciences</span><br>
                    <span class="fc___un___el04">Appliquées d'Al Hoceima</span><br>
                </div>
            </div>
            <div>
                <nav>
                    <ul>
                        <li onmouseover="mouseupNavel(this)" onmouseout="mouseupNavel(this)">
                            <a  href="{{url('/')}}">Accueil</a>
                            
                            <hr class="line___aft">
                        </li>
                        <li onmouseover="{mouseupNavel(this);mouseupNavel__V01(this);}" onmouseout="{mouseupNavel__V01(this);mouseupNavel(this)}" >
                            <span class="Lin____in" >
                                ENSAH
                                <span class="f___c__L__cnotsh" >
                                    <a href="{{url('/departement')}}" style="position:relative;"onmouseover="{mouseupNavelsecond(this);}" onmouseout="{mouseupNavelsecond(this);}" >
                                        departements
                                        <hr class="line___aft1">
                                    </a>
                                    <a href="{{url('/etudes')}}" style="position:relative;"onmouseover="{mouseupNavelsecond(this);}" onmouseout="{mouseupNavelsecond(this);}" >
                                        etudes
                                        <hr class="line___aft1">
                                    </a>
                                </span>
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bbq___ic" viewBox="0 0 16 16" id="chevron-down"><path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 01.708 0L8 10.293l5.646-5.647a.5.5 0 01.708.708l-6 6a.5.5 0 01-.708 0l-6-6a.5.5 0 010-.708z"></path></svg>
                            <hr class="line___aft">
                        </li>
                        <li onmouseover="{mouseupNavel(this);mouseupNavel__V01(this);}" onmouseout="{mouseupNavel__V01(this);mouseupNavel(this)}" >
                            <span class="Lin____in" >
                                espace d'etudiant
                                <span class="f___c__L__cnotsh" >
                                    <a href="{{url('/Dashbord/Cours')}}" style="position:relative;"onmouseover="{mouseupNavelsecond(this);}" onmouseout="{mouseupNavelsecond(this);}" >
                                        Cours
                                        <hr class="line___aft1">
                                    </a>
                                    <a href="{{url('/Dashbord/Modules')}}" style="position:relative;"onmouseover="{mouseupNavelsecond(this);}" onmouseout="{mouseupNavelsecond(this);}" >
                                        Modules
                                        <hr class="line___aft1">
                                    </a>
                                    <a href="{{url('/TimeTable')}}" style="position:relative;"onmouseover="{mouseupNavelsecond(this);}" onmouseout="{mouseupNavelsecond(this);}" >
                                        Emplois du temps
                                        <hr class="line___aft1">
                                    </a>
                                    <a href="{{url('/Dashbord/Biblio/List')}}" style="position:relative;"onmouseover="{mouseupNavelsecond(this);}" onmouseout="{mouseupNavelsecond(this);}" >
                                        Bibliothèque 
                                        <hr class="line___aft1">
                                    </a>
                                </span>
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bbq___ic" viewBox="0 0 16 16" id="chevron-down"><path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 01.708 0L8 10.293l5.646-5.647a.5.5 0 01.708.708l-6 6a.5.5 0 01-.708 0l-6-6a.5.5 0 010-.708z"></path></svg>
                            <hr class="line___aft">
                        </li>
                        
                        <li onmouseover="{mouseupNavel(this);mouseupNavel__V01(this);}" onmouseout="{mouseupNavel__V01(this);mouseupNavel(this)}" >
                            <span class="Lin____in" >
                                Actualité
                                <span class="f___c__L__cnotsh" >
                                    <a href="{{url('/annonce')}}" style="position:relative;"onmouseover="{mouseupNavelsecond(this);}" onmouseout="{mouseupNavelsecond(this);}" >
                                        Annonces
                                        <hr class="line___aft1">
                                    </a>
                                    <a href="{{url('/concours')}}" style="position:relative;"onmouseover="{mouseupNavelsecond(this);}" onmouseout="{mouseupNavelsecond(this);}" >
                                        Concours
                                        <hr class="line___aft1">
                                    </a>
                                    <a href="{{url('/concoursResultats')}}" style="position:relative;"onmouseover="{mouseupNavelsecond(this);}" onmouseout="{mouseupNavelsecond(this);}" >
                                        Affichage des résultats
                                        <hr class="line___aft1">
                                    </a>
                                </span>
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bbq___ic" viewBox="0 0 16 16" id="chevron-down"><path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 01.708 0L8 10.293l5.646-5.647a.5.5 0 01.708.708l-6 6a.5.5 0 01-.708 0l-6-6a.5.5 0 010-.708z"></path></svg>
                            <hr class="line___aft">
                        </li>                        
                        
                        <li onmouseover="mouseupNavel(this)" onmouseout="mouseupNavel(this)">
                            <a href="{{url('/about')}}">À propos de nous</a>
                            <hr class="line___aft">
                        </li>
                        <li onmouseover="mouseupNavel(this)" onmouseout="mouseupNavel(this)">
                            <a href="{{url('/contact')}}">CONTACTEZ NOUS</a>
                            <hr class="line___aft">
                        </li>
                    </ul>
                    <div id="s_____nvi">
                        <input  type="text" class="in___s__nv"/>
                        <button type="submit" id="bt___s__nv1">
                            <svg id="f_____nObject1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 948.97517 964.33953"><title>5613 [Converted]</title><path d="M486.85115,107.06553c-210.5006-3.92438-383.47654,168.92135-379.76777,379.42586,3.57262,202.77733,169.0539,366.05324,372.68,366.05324a370.84877,370.84877,0,0,0,205.86256-62.0415.625.625,0,0,1,.78536.0754l253.5323,260.32076a67.61668,67.61668,0,0,0,96.23395.65364l.0001-.00009a67.61669,67.61669,0,0,0,.6478-95.004L783.4458,696.35726a.62472.62472,0,0,1-.07038-.80882,370.58582,370.58582,0,0,0,69.1778-215.75475C852.55322,276.284,689.49411,110.84343,486.85115,107.06553ZM544.90373,735.23c-170.86617,37.925-322.15365-91.07661-322.15365-255.43631,0-144.778,117.37094-262.1067,262.111-262.1067,164.24275,0,293.18564,151.00915,255.53274,321.78976A257.79689,257.79689,0,0,1,544.90373,735.23Z" transform="translate(-107.02483 -107)"/></svg>
                        </button>
                    </div>
                    <div id="ic____nv">
                        <svg id="f_____nObject" onclick="{nvclickbtnsh(this)}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 948.97517 964.33953"><title>5613 [Converted]</title><path d="M486.85115,107.06553c-210.5006-3.92438-383.47654,168.92135-379.76777,379.42586,3.57262,202.77733,169.0539,366.05324,372.68,366.05324a370.84877,370.84877,0,0,0,205.86256-62.0415.625.625,0,0,1,.78536.0754l253.5323,260.32076a67.61668,67.61668,0,0,0,96.23395.65364l.0001-.00009a67.61669,67.61669,0,0,0,.6478-95.004L783.4458,696.35726a.62472.62472,0,0,1-.07038-.80882,370.58582,370.58582,0,0,0,69.1778-215.75475C852.55322,276.284,689.49411,110.84343,486.85115,107.06553ZM544.90373,735.23c-170.86617,37.925-322.15365-91.07661-322.15365-255.43631,0-144.778,117.37094-262.1067,262.111-262.1067,164.24275,0,293.18564,151.00915,255.53274,321.78976A257.79689,257.79689,0,0,1,544.90373,735.23Z" transform="translate(-107.02483 -107)"/></svg>
                        <svg id="f______nObject01" onclick="{nvclickbtnrv(this)}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 902.78325 902.00049"><title>5613 [Converted]</title><polygon points="902.783 752.58 600.812 450.609 902 149.42 752.58 0 451.391 301.188 150.203 0 0.782 149.42 301.97 450.609 0 752.58 149.42 902 451.391 600.03 753.362 902 902.783 752.58"/></svg>
                    </div>
                </nav>
            </div>
            
            <div class="mb___tp__nv">
               <div class="nv____m" >
                    <div id="ic____nv" style=" left: 15px; ">
                        <svg id="f_____nObject_topnv" onclick="lftnv()" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-justify" viewBox="0 0 16 16" id="justify"><path fill-rule="evenodd" d="M2 12.5a.5.5 0 01.5-.5h11a.5.5 0 010 1h-11a.5.5 0 01-.5-.5zm0-3a.5.5 0 01.5-.5h11a.5.5 0 010 1h-11a.5.5 0 01-.5-.5zm0-3a.5.5 0 01.5-.5h11a.5.5 0 010 1h-11a.5.5 0 01-.5-.5zm0-3a.5.5 0 01.5-.5h11a.5.5 0 010 1h-11a.5.5 0 01-.5-.5z"></path></svg>            </div>
                    <img src="{{URL::asset('/resources/images/Logo01blue.svg')}}" id="imlo___01__nv"/>
                    <div id="ic____nv">
                        <svg id="f_____nObject_m" onclick="{nvclickbtnshm(this)}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 948.97517 964.33953"><title>5613 [Converted]</title><path d="M486.85115,107.06553c-210.5006-3.92438-383.47654,168.92135-379.76777,379.42586,3.57262,202.77733,169.0539,366.05324,372.68,366.05324a370.84877,370.84877,0,0,0,205.86256-62.0415.625.625,0,0,1,.78536.0754l253.5323,260.32076a67.61668,67.61668,0,0,0,96.23395.65364l.0001-.00009a67.61669,67.61669,0,0,0,.6478-95.004L783.4458,696.35726a.62472.62472,0,0,1-.07038-.80882,370.58582,370.58582,0,0,0,69.1778-215.75475C852.55322,276.284,689.49411,110.84343,486.85115,107.06553ZM544.90373,735.23c-170.86617,37.925-322.15365-91.07661-322.15365-255.43631,0-144.778,117.37094-262.1067,262.111-262.1067,164.24275,0,293.18564,151.00915,255.53274,321.78976A257.79689,257.79689,0,0,1,544.90373,735.23Z" transform="translate(-107.02483 -107)"/></svg>
                        <svg id="f______nObject01_m" onclick="{nvclickbtnrvm(this)}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 902.78325 902.00049"><title>5613 [Converted]</title><polygon points="902.783 752.58 600.812 450.609 902 149.42 752.58 0 451.391 301.188 150.203 0 0.782 149.42 301.97 450.609 0 752.58 149.42 902 451.391 600.03 753.362 902 902.783 752.58"/></svg>
                    </div>
                    <div id="s_____nvi_b">
                        <div  id="s_____nvi_b_01" >
                            <input  type="text" class="in___s__nv"/>
                            <button type="submit" id="bt___s__nv1">
                                <svg id="f_____nObject1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 948.97517 964.33953"><title>5613 [Converted]</title><path d="M486.85115,107.06553c-210.5006-3.92438-383.47654,168.92135-379.76777,379.42586,3.57262,202.77733,169.0539,366.05324,372.68,366.05324a370.84877,370.84877,0,0,0,205.86256-62.0415.625.625,0,0,1,.78536.0754l253.5323,260.32076a67.61668,67.61668,0,0,0,96.23395.65364l.0001-.00009a67.61669,67.61669,0,0,0,.6478-95.004L783.4458,696.35726a.62472.62472,0,0,1-.07038-.80882,370.58582,370.58582,0,0,0,69.1778-215.75475C852.55322,276.284,689.49411,110.84343,486.85115,107.06553ZM544.90373,735.23c-170.86617,37.925-322.15365-91.07661-322.15365-255.43631,0-144.778,117.37094-262.1067,262.111-262.1067,164.24275,0,293.18564,151.00915,255.53274,321.78976A257.79689,257.79689,0,0,1,544.90373,735.23Z" transform="translate(-107.02483 -107)"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
                <!--Mobil Navbar-->
                    <div class="nv___l__ccc">
                        <ul id="nv___l__c">
                            <svg id="f______nObject01" class="newrmbn" onclick="{lftnv()}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 902.78325 902.00049"><title>5613 [Converted]</title><polygon points="902.783 752.58 600.812 450.609 902 149.42 752.58 0 451.391 301.188 150.203 0 0.782 149.42 301.97 450.609 0 752.58 149.42 902 451.391 600.03 753.362 902 902.783 752.58"/></svg>
        
                                <li >
                                    <a  href="{{url('/')}}">Accueil</a>
                                </li>
                                <li  class="li___m___nb">
                                    <div class="Lin____in" >
                                        ENSAH
                                        <svg onclick="minlink(this)" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bbq___ic" viewBox="0 0 16 16" ><path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 01.708 0L8 10.293l5.646-5.647a.5.5 0 01.708.708l-6 6a.5.5 0 01-.708 0l-6-6a.5.5 0 010-.708z"></path></svg>
                                    </div>
                                    <span class="f___c__L__cnotsh2" >
                                        <a href="{{url('/departement')}}" style="position:relative;" >
                                            departements
                                        </a>
                                        <a href="{{url('/etudes')}}" style="position:relative;"  >
                                            etudes
                                        </a>
                                    </span>
                                </li>
                                <li  class="li___m___nb">
                                    <div class="Lin____in" >
                                        espace d'etudiant
                                        <svg onclick="minlink(this)" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bbq___ic" viewBox="0 0 16 16" ><path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 01.708 0L8 10.293l5.646-5.647a.5.5 0 01.708.708l-6 6a.5.5 0 01-.708 0l-6-6a.5.5 0 010-.708z"></path></svg>
                                    </div>
                                    <span class="f___c__L__cnotsh2" >
                                        <a href="{{url('/Dashbord/Cours')}}" style="position:relative;" >
                                            Cours
                                        </a>
                                        <a href="{{url('/Dashbord/Modules')}}" style="position:relative;" >
                                            Modules
                                        </a>
                                        <a href="{{url('/TimeTable')}}" style="position:relative;"  >
                                            Emplois du temps
                                        </a>
                                        <a href="{{url('/Dashbord/Biblio/List')}}" style="position:relative;" >
                                            Bibliothèque
                                        </a>
                                    </span>
                                </li>
                                
                                <li  class="li___m___nb">
                                    <div class="Lin____in" >
                                        Actualités
                                        <svg onclick="minlink(this)" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bbq___ic" viewBox="0 0 16 16" ><path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 01.708 0L8 10.293l5.646-5.647a.5.5 0 01.708.708l-6 6a.5.5 0 01-.708 0l-6-6a.5.5 0 010-.708z"></path></svg>
                                    </div>
                                    <span class="f___c__L__cnotsh2" >
                                        <a href="{{url('/annonce')}}" style="position:relative;" >
                                            Annonces
                                        </a>
                                        <a href="{{url('/consours')}}" style="position:relative;" >
                                            Consours
                                        </a>
                                        <a href="{{url('/concoursResultats')}}" style="position:relative;"  >
                                            Affichage des résultats
                                        </a>
                                    </span>
                                </li>
                                
                                <li >
                                    <a href="{{url('/administration')}}">Administration</a>
                                    <hr class="line___aft">
                                </li>
                                <li >
                                    <a href="{{url('/contact')}}">CONTACTEZ NOUS</a>
                                    <hr class="line___aft">
                                </li>
                                <li class="bottom">
                                    @guest
                                        @if (Route::has('login'))
                                                <a style="color:white;" class="nav-link" href="{{ route('login') }}"><i class="fa fa-sign-in-alt" aria-hidden="true"></i> {{ __('Se connecter') }} </a> 
                                        @endif
                                                                           <br>
            
                                        @if (Route::has('register'))
                                                <a style="color:white;" href="{{ route('register') }}"><i class="fas fa-user-plus"></i> {{ __('Registre') }}</a>
                                        @endif
                                    @else
                                            <a style="color:white;" id="llogout" href="/profil" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                <i class="fas fa-user-alt"></i> {{ Auth::user()->fname." ".Auth::user()->lname }}
                                            </a>
                                            <br>
                                            <a style="color:white;" id="llogout" href="/Dashbord" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                <i class="fas fa-columns"></i> {{ __('Espace d\'utilisation') }}
                                            </a>
                                               <br>
                                            <div  aria-labelledby="navbarDropdown">
                                                <a style="color:white;" href="{{ route('logout') }}"
                                                  onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();"> 
                                                    <i class="fas fa-sign-out-alt"></i>{{ __('Se déconnecter') }}
                                                </a>
            
                                                <form style="color:white;" id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                    @csrf
                                                </form>
                                            </div>
                                    @endguest
                                </li>
                        </ul>
                </div>
            </div>
        </header>
        
        
        <script type="text/javascript">
            const lftnv=()=>{
                var lftc1=document.getElementsByClassName("nv___l__ccc")[0];
                var lftc2=document.getElementById("nv___l__c");
                if(lftc1.style.left=="-90vw"||lftc1.style.left==""){
                    lftc1.style.left=0;
                }
                else{
                    lftc1.style.left='-90vw';
                }
            }
            const minlink=(e)=>{
                var lls=e.parentElement.parentElement.getElementsByClassName("f___c__L__cnotsh2")[0];
                if(lls.style.height=="0px"||lls.style.height==0){
                    e.style.transform="rotate(0deg)"
                    lls.style.height="auto"
                }else{
                    e.style.transform="rotate(-90deg)"
                    lls.style.height=0
                }
            }
            const mouseupNavel=(e)=>{
                if(e.getElementsByClassName("line___aft")[0].style.width=="100%")e.getElementsByClassName("line___aft")[0].style.width=0;
                else e.getElementsByClassName("line___aft")[0].style.width="100%";
            }
            const mouseupNavelsecond=(e)=>{
                var x=e.getElementsByClassName("line___aft1")[0];
                if(x.style.width=="100%"){x.style.left="100%";setTimeout(() => {
                    x.style.width=0;x.style.left=0
                }, 300);}
                else {if(x.style.left!=0){x.style.width=0;x.style.left=0}x.style.width="100%";}
                
            }
            const mouseupNavel__V01=(e)=>{
                if(e.getElementsByTagName("span")[0].getElementsByTagName("span")[0].style.opacity==0){e.getElementsByTagName("span")[0].getElementsByTagName("span")[0].style.opacity=1;e.getElementsByTagName("span")[0].getElementsByTagName("span")[0].style.display="block";}
                else { e.getElementsByTagName("span")[0].getElementsByTagName("span")[0].style.opacity=0;
        
                        e.getElementsByTagName("span")[0].getElementsByTagName("span")[0].style.display="none"
                }
            }
            const mouseupNavel__V02=(e)=>{
        
            }
            const nvclickbtnsh=(e)=>{
                e.style.display="none"; 
                document.getElementById("f______nObject01").style.display="block";
                document.getElementById("s_____nvi").style.height="40px";
            }
            const nvclickbtnrv=(e)=>{
                e.style.display="none";
                document.getElementById("f_____nObject").style.display="block";
                document.getElementById("s_____nvi").style.height="0px";
            }
            const nvclickbtnshm=(e)=>{
                e.style.display="none";
                document.getElementById("f______nObject01_m").style.display="block";
                document.getElementById("s_____nvi_b_01").style.height="40px";
            }
            const nvclickbtnrvm=(e)=>{
                e.style.display="none";
                document.getElementById("f_____nObject_m").style.display="block";
                document.getElementById("s_____nvi_b_01").style.height="0px";
            }
            
        </script>