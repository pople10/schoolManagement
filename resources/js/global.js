function loading(){$(".loading-container").fadeOut(300);}
$("#copyrightIntroduction").hover(function(){
        swal({
          title: "This project is made by :",
          text: "Omar Ezzarqtouni\nTayeb Hamdaoui\nNawal Ait Ahmed\nNisrine Amghar\nMohammed Amine Ayache",
          button: "Nice to meet you!",
        });
},function(){
    $("#copyrightIntroductionModal").modal("hide");
});
$(".year").text((new Date()).getFullYear());
$("#toTheTop").click(function(){
    $(this).addClass("shaking");
    setTimeout(function(){
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0; 
    },200);
});
    if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
        $("#toTheTop").css("display","block");
      } else {
        $("#toTheTop").removeClass("shaking");
        $("#toTheTop").css("display","none");
      }
window.onscroll = function() {
    if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
        $("#toTheTop").css("display","block");
      } else {
        $("#toTheTop").removeClass("shaking");
        $("#toTheTop").css("display","none");
      }
};