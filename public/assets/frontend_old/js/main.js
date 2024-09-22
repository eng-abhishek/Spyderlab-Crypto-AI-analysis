$(document).ready(function () {
    $('.search-radio').change(function (e) {
        if($(this).val()=='email'){
            $('.search-by-phone').removeClass('d-block').addClass('d-none');
            $('.search-by-email').addClass('d-block').removeClass('d-none');
        }
        else{
            
            $('.search-by-email').removeClass('d-block').addClass('d-none');
            $('.search-by-phone').addClass('d-block').removeClass('d-none');
        }      
    });
    
    /*Tooltip*/
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
    /*Tooltip*/
    /*Scrol*/
    $("#button").click(function() {
        $('html, body').animate({
            scrollTop: $("#scrollTop").offset().top - 48
        }, 1000);
        setTimeout(function(){ $("#blockchain_search_result").fadeIn(); },1500);
    });
    /*Scrol*/

    /*Block UI CSS*/
    $.blockUI.defaults.css.border = 'none'; 
    $.blockUI.defaults.css.padding = '15px';
    $.blockUI.defaults.css.backgroundColor = '#000';
    $.blockUI.defaults.css.opacity = '0.8';
    $.blockUI.defaults.css.color = '#fff';
    $.blockUI.defaults.css.borderRadius = '10px';
    $.blockUI.defaults.baseZ = '4000';
    /*Block UI CSS*/
});

    function copyToClipboard(element,id=null) {
        
        var $temp = $("<input>");
        $("body").append($temp);
        if(id != null){
            $temp.val($(element+id).text()).select();
        }else{
            $temp.val($(element).text()).select();
        }

        document.execCommand("copy");
        $temp.remove();
        if(id != null){
            $(element+id).addClass('text-success');
        }else{
            $(element).addClass('text-success');
        }

        setTimeout(function(){
            if(id != null){
                $(element+id).removeClass('text-success');
            }else{
                $(element).removeClass('text-success');
            }
        },1200)
    }

//--------------- our service section -------------------------//


var osint_option=document.getElementsByClassName('OSINT')[0];
var crypto_tracking=document.getElementsByClassName('crypto-tracking')[0];
var dweb_intelli=document.getElementsByClassName('dweb-intelli')[0];
var others=document.getElementsByClassName('others')[0];

var crypto_under=document.getElementsByClassName('crypto-under')[0];
var osint_under=document.getElementsByClassName('osint-under')[0];
var dweb_under=document.getElementsByClassName('dweb-under')[0];
var others_under=document.getElementsByClassName('others-under')[0];


var osint_row = document.getElementsByClassName('OSINT-service-row')[0];
var crypto_tracking_row = document.getElementsByClassName('crypto-tracking-row')[0];
var dweb_intelligence_row = document.getElementsByClassName('dweb-intelligence-row')[0];
var others_row = document.getElementsByClassName('others-row')[0];


document.addEventListener('DOMContentLoaded', function () {
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', function () {
        if (window.scrollY > 0) {
            navbar.classList.add('navbar-shadow');
        } else {
            navbar.classList.remove('navbar-shadow');
        }
    });
});

function show_1() {
    osint_row.style.display = "flex";
    crypto_tracking_row.style.display = "none";
    dweb_intelligence_row.style.display = "none";
    others_row.style.display = "none";

    osint_under.style.display="block";
    crypto_under.style.display="none";
    dweb_under.style.display="none";
    others_under.style.display="none";


    osint_option.style.color="#051cad";
    crypto_tracking.style.color="black";
    dweb_intelli.style.color="black";
    others.style.color="black";
}

function show_2() {
    crypto_tracking_row.style.display = "flex";
    osint_row.style.display = "none";
    dweb_intelligence_row.style.display = "none";
    others_row.style.display = "none";

    crypto_under.style.display="block";
    osint_under.style.display="none";
    dweb_under.style.display="none";
    others_under.style.display="none";

    crypto_tracking.style.color="#051cad";
    osint_option.style.color="black";
    dweb_intelli.style.color="black";
    others.style.color="black";
}

function show_3() {
    dweb_intelligence_row.style.display = "flex";
    osint_row.style.display = "none";
    crypto_tracking_row.style.display = "none";
    others_row.style.display = "none";

    dweb_under.style.display="block";
    osint_under.style.display="none";
    crypto_under.style.display="none";
    others_under.style.display="none";

    dweb_intelli.style.color="#051cad";
    osint_option.style.color="black";
    crypto_tracking.style.color="black";
    others.style.color="black";
}

function show_4() {
    
    others_row.style.display = "flex";
    dweb_intelligence_row.style.display = "none";
    osint_row.style.display = "none";
    crypto_tracking_row.style.display = "none";

    others_under.style.display="block";
    osint_under.style.display="none";
    crypto_under.style.display="none";
    dweb_under.style.display="none";

    others.style.color="#051cad";
    osint_option.style.color="black";
    crypto_tracking.style.color="black";
    dweb_intelli.style.color="black";
}