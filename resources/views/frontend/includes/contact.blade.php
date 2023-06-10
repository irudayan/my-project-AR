
<style>
/*--------------------------------------------------------------
# About
--------------------------------------------------------------*/
.about .content h3 {
  font-weight: 600;
  font-size: 26px;
}
/* .about .content ul {
  list-style: none;
  padding: 0;
} */
.about .content ul li {
  display: flex;
  align-items: flex-start;
  margin-bottom: 10px;
}
.about .content ul li:first-child {
  margin-top: 10px;
}
.about .content ul i {
  background: #fff;
  box-shadow: 0px 6px 15px rgba(16, 110, 234, 0.12);
  font-size: 24px;
  padding: 20px;
  margin-right: 15px;
  color: #801214;
  border-radius: 50px;
}
.about .content ul h5 {
  font-size: 18px;
  color: #555555;
}
.about .content ul p {
  font-size: 15px;
}
.about .content ul{
  margin-left: 40px;
}
.about .content p:last-child {
  margin-bottom: 0;
}
.about .content ul li:before {
  content: "\f00c"; /* FontAwesome Unicode */
  font-family: FontAwesome;
  display: inline-block;
  margin-left: -1.3em; /* same as padding-left set on li */
  width: 1.3em; /* same as padding-left set on li */
}

</style>
<section id="contact" class="contact section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h3><span>Contact Us</span></h3>
        </div>

        <div class="row" data-aos="fade-up" data-aos-delay="100">
          <div class="col-lg-6">
            <div class="row">
              <div class="col-lg-12">
                <div class="info-box  mb-8">
                  <i class="bx bx-phone-call"></i>
                  <h3>Contact Us</h3>
                  <h3>877-284-3262 option 4</h3>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="info-box  mb-8">
                  <h3>Phone Support is available from Monday to Friday</h3>
                  <h3>9AM EST to 6PM EST</h3>
                </div>
              </div>
            </div>
          </div>


          <div class="col-lg-6">
            <div class="php-email-form">
            <form id="sendmessage">
              <div class="row">
                <div class="col-lg-6 form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                </div>
                <div class="col-lg-6 form-group">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                </div>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
              </div>
              <div class="form-group">
                <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
              </div>

              <label id="g-recaptcha" style="display: none;">reCaptcha is Required</label>
              <div class="my-3">
                <div class="sent-message" id="sent">Your message has been sent. Thank you!</div>
              </div>
              <div class="row">
                <div class="col form-group">
                  <span id='loader' style='display: none;'>
                      <img src="/assets/img/gif/ajaxload.gif" width='32px' height='32px' >
                  </span>
                </div>
                <div class="col form-group">
                  <div class="text-center"><button id="send-message">Send Message</button></div>
                </div>
                <div class="col form-group"></div>
              </div>
            </form>
            </div>
          </div>
        </div>
      </div>
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>
    <script type="text/javascript"> 

    jQuery.validator.addMethod("accept", function(value, element, param) {
    return value.match(/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/);
    },'The email should be in the format: abc@gmail.com');

    $("#sendmessage").validate({
      rules: {
        name : {
          required: true,
          minlength: 3
        },
        email: {
          required: true,
          email: true,
          accept: true,
          maxlength:100,
        },
        subject:{
          required: true,
        },
        message:{
           required: true,
        },
      },
      messages : {
        first_name: {
          required: "Please enter your first name",
          minlength: "Name should be at least 3 characters"
        },
        email: {
          required: "Please enter your email"
        },
        subject:{
          required: "Please enter subject"
        },
        message:{
          required: "Please enter message"
        },
      },
      submitHandler: function(form) {
        grecaptcha.ready(function() {
          grecaptcha.execute('6Lf5x_EjAAAAALmT66vx2JpTacH4gLPIBTDsPEV8').then(function(token) {
          $('#sendmessage').prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
          var formData = $(form).serialize();
          console.log(formData);
          debugger;
          $.ajax({
              method : "get",
              url: "/sendmessage",
              data : formData,
              beforeSend: function(){
                // Show image container
                $("#loader").show();
              },
              success: function(response) {
                if(response.data == "success"){
                  $("#sent").show().delay(3000).fadeOut();
                }
              },
              complete:function(response){
                // Hide image container
                $("#loader").hide();
                $("#g-recaptcha").attr('style','display:none');
                $('#sendmessage')[0].reset();
              }
            });
            $("#success").hide();
          });
        });
      }
    });

    </script>
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 


    <!-- End Contact Section -->