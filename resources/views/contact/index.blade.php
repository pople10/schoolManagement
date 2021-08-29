@include('includes.head')
@include('includes.menu')
<div class="bootstrap">
    <div class="w-75 p-3 mt-45 mb-10 mx-auto">
        <h2 >Contactez-nous</h2>
    </div>
    <div class="contact-contact">
       <div class="w-m-90 w-d-50 mx-auto p-3 mt-1 mb-10">
           <div class="card p-3">
               <form id="contactForm" method="POST" enctype="multipart/form-data">
                    <div class="dev-XX"> 
                       <label for="fname">Nom : </label>
                        <input type="text" id="fname" name="firstname" class="contactusInput form-control" placeholder="Nom">
                    </div> 
                    
                    <div class="dev-XX">
                        <label for="lname">Prénom : </label>
                        <input type="text" id="lname" name="lastname" class="contactusInput form-control"  placeholder="Prénom">
                    </div>   
                    
                    <div class="dev-XX"> 
                          <label for="contact-email"> E-mail : </label>
                          <input id="contact-email" type="email" name="email" class="contactusInput form-control" data-constraints="@Email @Required">
                          <span class="form-validation"></span>
                     </div> 
                     
                     <div class="dev-XX"> 
                          <label for="contact-subject" >Sujet :</label>
                          <input id="contact-subject" type="text" name="subject" class="contactusInput form-control" data-constraints="@Required">
                          <span class="form-validation"></span>
                     </div>   
                     
                      <div class="dev-XX">
                            <label for="contact-message" >Message : </label>
                            <textarea id="contact-message" name="message" class="contactusTextArea form-control" data-constraints="@Required"></textarea>
                            <span class="form-validation"></span>   
                     </div> 
                       <div class="sub" >
                            <button class="ui positive button mx-auto" type="submit" id="submit"><i class="fa fa-envelope"></i> Envoyer </button>
                     </div> 
                </form>
          </div>
        </div>
    </div>
</div>  
<script src="{{URL::asset('resources/js/contactus.js')}}"></script>
@include('includes.footer')