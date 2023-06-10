
<style>
    HTML CSSResult Skip Results Iframe
EDIT ON

body {
  background-color: #ffff;
}

.mainbox {
  
  margin: auto;
  height: 478px;
  width: 600px;
  position: relative;
}

  .err {
    color: #801214;
    font-family: 'Nunito Sans', sans-serif;
    font-size: 9rem;
    position:absolute;
    left: 20%;
    top: 8%;
  }

.far {
  position: absolute;
  font-size: 6.5rem;
  left: 42%;
  top: 15%;
  color: #801214;
}

 .err2 {
    color: #801214;
    font-family: 'Nunito Sans', sans-serif;
    font-size: 9rem;
    position:absolute;
    left: 68%;
    top: 8%;
  }

.msg {
    text-align: center;
    font-family: 'Nunito Sans', sans-serif;
    font-size: 1.6rem;
    position:absolute;
    left: 16%;
    top: 41%;
    width: 75%;
  }



a:hover {
  text-decoration: underline;
}
#header {
    background: #fff;
    transition: all 0.5s;
    z-index: 997;
    height: 70px;
    box-shadow: 0px 2px 15px rgb(0 0 0 / 10%);
}

.align-items-center {
    -ms-flex-align: center!important;
    align-items: center!important;
}
#header .logo {
    
    font-size: 30px !important;
    margin: 0;
    padding: 0;
    line-height: 1;
    font-weight: 600;
    letter-spacing: 0.8px;
    font-family: "Avenir Next Georgian W03 Demi", sans-serif;
}
#header .logo img {
    max-height: 40px;
}
img {
    vertical-align: middle;
    border-style: none;
}
#header .logo a {
    color: #222222;
}
.navbar {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    -ms-flex-align: center;
    align-items: center;
    -ms-flex-pack: justify;
    justify-content: space-between;
    padding: 0.5rem 1rem;
}   

</style>




<head>
  <link href="{{asset('assets/img/favicon.png')}}" rel="icon">
  <link href="{{asset('assets/img/favicon.png')}}" rel="apple-touch-icon">
  
  <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <!-- Template Main CSS File -->

    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@600;900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4b9ba14b0f.js" crossorigin="anonymous"></script>
  </head>
  
  <body>
    <header id="header" class="d-flex align-items-center">
        <div class="container d-flex align-items-center justify-content-between">
    
          <h1 class="logo"><a href="/"><img src="{{asset('assets\img\Annualreportlogo.png')}}" style="padding: 4px -3px 0px 0px;" alt=""></a></h1>
        
        </div>  
      </header>
    <div class="mainbox">
      <div class="err">4</div>
      <i class="far fa-question-circle " style="padding: 13px 0 0 0;"></i>
      <div class="err2">4</div>
      <div class="msg" style="font-family: Avenir Next Georgian W03 Demi sans-serif; font-size:18px;  padding-top: 39px;"><h1 style="font-family: Avenir Next Georgian W03 Demi sans-serif;">Something's Wrong here.</h1><p> This is a 404 error, which means you're clicked on a bad link or entered an invalid URL.Maybe what you are looking for can be found at <a href="/" style="color: #801214;">home</a>.</p></div>
        </div>
  </body>
    
    <!-- ======= Footer ======= -->
    <footer id="footer">
      <div class="footer-top">
        <div class="container">
          <div class="row">
  
            <div class="col-lg-3 col-md-6 footer-contact">
              <h3><a href="/"><img src="{{asset('assets/img/cmalliance/Annualreportlogo.png')}}" alt="" style="width: 252px;"></a></h3>
              <p>The Christian and Missionary Alliance <br>
                One Alliance Place<br>
                Reynoldsburg, OH 43068 <br><br>
                <strong>Phone: </strong>(380) 208-6200<br>
               <!--  <strong>Email:</strong> info@example.com<br> -->
               <a href="" style="color: #801214;">Privacy Policy</a>
              </p>
            </div>
            <div class="col-lg-3 col-md-6 footer-links">
            </div>
          <div class="col-lg-3 col-md-6 footer-links">
          </div>
            <div class="col-lg-3 col-md-6 footer-links">
              <h4>Our Social Networks</h4>
              <p>The Christian and Missionary Alliance</p>
              <div class="social-links mt-3">
                <!-- <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a> -->
                <a href="https://www.facebook.com/cmalliance" target="_blank" class="facebook"><i class="bx bxl-facebook"></i></a>
                <a href="https://www.instagram.com/cmalliance" target="_blank" class="instagram"><i class="bx bxl-instagram"></i></a>
                <!-- <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a> -->
                <a href="https://www.linkedin.com/company/cmalliance" target="_blank" class="linkedin"><i class="bx bxl-linkedin"></i></a>
              </div>
            </div>
  
          </div>
        </div>
      </div>
      <div class="container py-4">
        <div class="copyright">
          &copy; 2022 <strong><span>The Christian and Missionary Alliance</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
          Some material used by permission.<!-- <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
        </div>
      </div>
    </footer>
    
  


    <!-- End Footer -->