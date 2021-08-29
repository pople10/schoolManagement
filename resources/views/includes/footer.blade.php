  
    
  
    <footer class="bootstrap">
       <div class="container" >
         <div class="row w-100">
                <div class="col-lg-3 pt-3 pb-2">
                    <center><img  src="{{URL::asset('/resources/images/l.png')}}" width="200" height="90"></center>
                </div>
                <div class="col-lg-4 pl-2 pt-3 pb-2">
                   <div class="widget-main">
                        <div class="widget-title">
                            <h3> CONTACT US </h3>
                        </div>
                        <ul>
                            <li class="list-footer"><a href="tel:+212653827096"><i class="fas fa-phone"></i> &nbsp; +212 653827096 </a></li>
                            <li class="list-footer"><a href="mailto:support@trackiness.com"><i class="fas fa-envelope"></i> &nbsp; support@trackiness.com </a></li>
                            <li class="list-footer mt-3">Ecole Nationale des Sciences Appliquées d'Al Hoceima<br> BP 03, Ajdir Al-Hoceima</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 pl-2 pt-3 pb-2">
                    <div class="widget-main">
                        <div class="widget-title">
                            <h3> LOCALISATION </h3>   
                        </div>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3261.368736894064!2d-3.859782514589398!3d35.172361065319805!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd742cdef50e1b29%3A0x19897f71ba224d93!2z2KfZhNmF2K_Ysdiz2Kkg2KfZhNmI2LfZhtmK2Kkg2YTZhNi52YTZiNmFINin2YTYqti32KjZitmC2YrYqSDYqNin2YTYrdiz2YrZhdip!5e0!3m2!1sar!2sma!4v1612531345079!5m2!1sar!2sma" width="100%" height="150" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </div>
                </div>
         </div>       
       </div>
        <div class="footer-copyright">
                <div class="p-copyright left pl-2 mt-2"> Copyright &copy; <span class="year"></span> | All rights reserved to <span id="copyrightIntroduction" class="redColor">HOVER HERE</span>
                </div>
                <div class="right mt-2">
                    <ul class="p-copyright">
                        <li class="social-media-list"><a href="https://twitter.com/ensaalhoceima/" target="_blank"><i class="fab fa-twitter"></i></a></li>
                        <li class="social-media-list"><a href="https://www.youtube.com/ensaalhoceima/" target="_blank"><i class="fab fa-youtube"></i></a></li>
                        <li class="social-media-list"><a href="https://www.facebook.com/ensaalhoceima/" target="_blank"><i class="fab fa-facebook"></i></a></li>
                    </ul>
                </div>
                <div class="clear"></div>
        </div>
    </footer>
<div id="toTheTop">
    <img style="max-height:100%;" src="{{URL::asset('/resources/images/rocket.svg')}}">
</div>

<script src="{{URL::asset('resources/js/global.js')}}"></script>
<script src="{{URL::asset('resources/js/videojs.js')}}"></script>
<script src="{{URL::asset('resources/js/uploader.js')}}"></script>
<script>
    const rmvrole1=()=>{
        var ccad=document.getElementById('add__r_cc');
        ccad.style.opacity=0;
        ccad.style.top='-100vh';
        ccad.style.background="#0000000";
        document.getElementById('role_r').value="";
        var inp=document.getElementsByClassName("previl");
        for(let i=0;i<inp.length;i++){
            inp[i].checked=false;
        }

    }
const shwrole1=(data)=>{
        var ccad=document.getElementById('add__r_cc');
        ccad.style.opacity=1;
        ccad.style.top=0;
        setTimeout(() => {
            ccad.style.background="#00000057";
        }, 700);
            if(data!=null){
                document.getElementById('submit_r').setAttribute("onclick","send_data("+data.id+")");
                document.getElementById('submit_r').innerHTML="Modifier";
                var inp=document.getElementsByClassName("previl");
                document.getElementById('role_r').value=data.label;
                for(let i=0;i<inp.length;i++){
                         if(data.prv.includes(inp[i].value))inp[i].checked=true;
                }
            }
        
    }
    var x = localStorage.getItem("uml");
        if(x===null){
            document.getElementsByTagName("body")[0].innerHTML+='<div class="R___P"><div id="add__r_cc"> <div class="el_add__r_cc"> <div class="pr_v_t"> A propos de l\'application </div> <div class="pr_v_e"><div class="img___uml_cc"><img src="{{URL::asset("/resources/images/uml.jpg")}}" class="img___uml"></div> </div> <div class="pr_v_tp"> <div class="bootstrap"> <button id="cancel_rr" onclick="rmvrole1()" class="ui button ">I understand</button> </div> </div> </div></div>'
            localStorage.setItem("uml", true);
            shwrole1();
        }
    
</script>
</body>
</html>

