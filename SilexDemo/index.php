<!DOCTYPE html>
<html lang="en">
<head>
  <title>GuestBook</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/custom.js"></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
<div class="navbar-wrapper">
    <div class="container-fluid">
        <nav class="navbar navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">GuestBook</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#" class="">Home</a></li>
                        
                    </ul>
                    
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- ================ INICIA FORMULARIO DE LOGIN ============================================================== -->    
<div class="container">
    
<div class="row" style="margin-top:60px">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
      <form role="form">
      <fieldset>
        <h2>Please Signup Here</h2>
        <hr class="colorgraph">
        <div class="form-group">
                    <input type="text" name="email" id="name" class="form-control input-md" placeholder="Name" required />
        </div>
        <div class="form-group">
                    <textarea type="text" name="address" id="address" class="form-control input-md" rows="5" placeholder="Address" required ></textarea>
        </div>
        <div class="form-group">
                    <input type="email" name="email" id="email" class="form-control input-md" placeholder="Email" required />
        </div>
        <div class="form-group">
                    <textarea type="text" id="message" class="form-control input-md" rows="5" placeholder="Message" required /></textarea>
        </div>
        <div class="form-group">
              <div class="g-recaptcha" data-sitekey="6LeyuC4UAAAAAMbGASh240JWS18WwYhGam7FPyDM"></div>
        </div>

        

        
        <hr class="colorgraph">
        <div class="row">
         
          <div class="col-xs-6 col-sm-6 col-md-6">
            <a href="" id="button"class="btn btn-md btn-primary btn-block">Register</a>
          </div>
        </div>
      </fieldset>
    </form>
  </div>
</div>
<div class="container">
  <h2>Guest List</h2>
  <table class="table table-bordered iterateTr">
    <thead>
      <tr>
        <th>Guest Name</th>
        <th>Address</th>
        <th>Email</th>

      </tr>
    </thead>
    <tbody class="tblrow">
     
    </tbody>
  </table>
  <ul class="pagination" style="padding-left: 75%; ">
     
  </ul>
</div>

</div>  
<script type="text/javascript">
var cnt=1;
function getRecords(count,total_pages) {
 
  var number=count;
  cnt=count;
  
  $(".tblrow tr").remove();
   $("ul.pagination li").remove();
 
 $.ajax({
            type: 'POST',
            url: 'http://guestbook.localhost.com/silex_api_demo/index.php/get_result_per_page',
            data: {'page_number': number},
            success: function(html) {
              
              var tblData = JSON.parse(html);
              var tableRow = "";
              var total_pages = 0;
              var paginationdata = "";
              $(function() {
                  $.each(tblData.data, function(i, item) {
                    tableRow += '<tr><td>' + item.name + '</td><td>' + item.message + '</td><td>' + item.email + '</td></tr>' 
                    total_pages = item.pages;
                    });
                    $('.iterateTr').append(tableRow);
                   if((cnt-1)!=0){
                    paginationdata +='<li ><a href="#/1" onclick="getRecords('+(cnt-1)+','+total_pages+');" > Previous </a></li>';
                  }
                    for (var count = 1; count <= total_pages; count++) {
                            paginationdata +='<li><a href="" value="'+count+'" onclick="getRecords('+count+','+total_pages+');" id="page_number">' +count+ '</a></li>';
                    }
                    if((cnt)<total_pages){
                    paginationdata +='<li ><a href="#/'+total_pages+'" onclick="getRecords('+(cnt+1)+','+total_pages+');" >Next </a></li>';
                  }
                    $('ul.pagination').append(paginationdata);
                })

              
            },
            error: function() {
                //alert('error');
            }
        });

       
  
}
 function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

  $(document).ready(function(){
 $.ajax({
            type: 'POST',
            url: 'http://guestbook.localhost.com/silex_api_demo/index.php/get_result_per_page',
            data: {'page_number':1},
            success: function(html) {
              var tblData = JSON.parse(html);
              var tableRow = "";
              var total_pages = 0;
              var paginationdata = "";
              $(function() {
                $(".tblrow tr").remove();

                  $.each(tblData.data, function(i, item) {
                    tableRow += '<tr><td>' + item.name + '</td><td>' + item.message + '</td><td>' + item.email + '</td></tr>' 
                    total_pages = item.pages;
                    });
                    $('.iterateTr').append(tableRow);
                   if((cnt-1)!=0){
                    paginationdata +='<li ><a href="#/1" onclick="getRecords('+(cnt-1)+','+total_pages+');"> Previous </a></li>';
                    }
                    for (var count = 1; count <= total_pages; count++) {
                            paginationdata +='<li><a href="#/'+count+'" value="'+count+'" onclick="getRecords('+count+','+total_pages+');" id="page_number">' +count+ '</a></li>';
                    }
                    if((cnt)<total_pages){
                    paginationdata +='<li ><a href="#/'+total_pages+'" onclick="getRecords('+(cnt+1)+','+total_pages+');" >Next </a></li>';
                  }
                    $('ul.pagination').append(paginationdata);
                })

              
            },
            error: function() {
                alert('error');
            }
        });

$('#button').on('click', function like(e) {
    $(this).off('click');
    e.preventDefault();
    var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
    if(isOpera==true){
    browser_name='Opera';
   }
var isFirefox = typeof InstallTrigger !== 'undefined';
   if(isFirefox==true){
    browser_name='Firefox';
   }
var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
    if(isSafari==true){
    browser_name='Safari';
   }
var isIE = /*@cc_on!@*/false || !!document.documentMode;
   if(isIE==true){
    browser_name='IE';
   }
var isEdge = !isIE && !!window.StyleMedia;
   if(isEdge==true){
    browser_name='EDGE';
   }
var isChrome = !!window.chrome && !!window.chrome.webstore;
   if(isChrome==true){
    browser_name='Chrome';
   }
var isBlink = (isChrome || isOpera) && !!window.CSS;
   var OSName="Unknown OS";
if (navigator.appVersion.indexOf("Win")!=-1) OSName="Windows";
if (navigator.appVersion.indexOf("Mac")!=-1) OSName="MacOS";
if (navigator.appVersion.indexOf("X11")!=-1) OSName="UNIX";
if (navigator.appVersion.indexOf("Linux")!=-1) OSName="Linux";
  var ipadress;
    $.getJSON("https://api.ipify.org/?format=json", function(e) {
     ipadress=e.ip;
});
    var name = $('#name').val();
    var message = $('#message').val();
    var email = $('#email').val();
    var address = $('#address').val();

   if((isEmail(email))!=true){
      alert("Please Enter Vallid Email");
   }else
    if(name==null || typeof(name)=='undefined' || name==""){
      alert("Please Enter name");
    }else if(address==null || typeof(address)=='undefined' || address==""){
      alert("Please Enter address");
    }else if(email==null || typeof(email)=='undefined' || email==""){
      alert("Please Enter email");
    }else if(message==null || typeof(message)=='undefined' || message==""){
      alert("Please Enter message");
    }else{
  

        $.ajax({
            type: 'POST',
            url: 'http://guestbook.localhost.com/silex_api_demo/index.php/add_guest',
            data: {'name': name, 'message': message, 'email': email,'address':address,'ip': ipadress,'client_browser': browser_name,'OSName' :OSName},
            success: function(html) {
               alert('record inserted');
                $.ajax({
            type: 'POST',
            url: 'http://guestbook.localhost.com/silex_api_demo/index.php/get_result_per_page',
            data: {'page_number':1},
            success: function(html) {
                $('#name').val('');
                $('#message').val('');
                $('#email').val('');
                $('#address').val('');
              var tblData = JSON.parse(html);
              var tableRow = "";
              var total_pages = 0;
              var paginationdata = "";
              $(function() {
                $(".tblrow tr").remove();
                $("ul.pagination li").remove();
                  $.each(tblData.data, function(i, item) {
                    tableRow += '<tr><td>' + item.name + '</td><td>' + item.message + '</td><td>' + item.email + '</td></tr>' 
                    total_pages = item.pages;
                    });
                    $('.iterateTr').append(tableRow);
                   if((cnt-1)!=0){
                    paginationdata +='<li ><a href="#/1"  onclick="getRecords('+(cnt-1)+','+total_pages+');"> Previous </a></li>';
                  }
                    for (var count = 1; count <= total_pages; count++) {
                            paginationdata +='<li><a href="#/'+count+'" value="'+count+'" onclick="getRecords('+count+','+total_pages+');" id="page_number">' +count+ '</a></li>';
                    }
                    if((cnt)<total_pages){
                    paginationdata +='<li ><a href="#/'+total_pages+'" onclick="getRecords('+(cnt+1)+','+total_pages+');" >Next </a></li>';
                  }
                    $('ul.pagination').append(paginationdata);
                })

              
            },
            error: function() {
                alert('error');
            }
        });
            },
            error: function() {
                alert('error');
            }
        });
    
   }
});

});
</script>
</body>
</html>
