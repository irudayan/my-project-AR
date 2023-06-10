<!-- ======= Resources Section =======  -->
<section id="resource" class="resource" style="background:#f6f9fe">
  <div class="container" data-aos="fade-up">
    <div class="section-title">
       <h3>Resource <span>Documents</span></h3>
    </div>
    <br>
    <div class="row justify-content-center">
      <div class="col-xl-10">
        <div class="row">
          @foreach($files as $value)
          <div class="col-md-4 files" align="center" style="padding-bottom: 20px;">
            <a href="{{asset('resourcefiles/'.$value->resource)}}" download>
            <h1 align="center">
              <i class="fa fa-file-pdf-o" aria-hidden="true" style="color:#801214;font-size: 60px;"></i>
            </h1>
            <h6 class="file-name">{{$value->resource}}</h6>
            </a>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>
<!-- End Resources Section