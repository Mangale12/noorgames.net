<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>CodePen - How To Use Switchery</title>
  <link rel='stylesheet' href='https://abpetkov.github.io/switchery/dist/switchery.min.css'>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css'>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css'>

</head>
<body>
<!-- partial:index.partial.html -->
<div class="container">
<h2>Checkbox Style, Inits, Changes, Sets</h2>
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Home</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Profile</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="contact-tab" data-toggle="tab" data-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Contact</button>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="chk_1">Spinner</label>
                    <input id="spinner" {{ $appFeatures->spinner == 1 ? 'checked' : '' }} type="checkbox" class="js-switch" data-size="small"/>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="chk_1">Missing User</label>
                    <input id="missing-user" type="checkbox" {{ $appFeatures->missing_players == 1 ? 'checked' : '' }} class="js-switch" data-size="small" style="right:-30rem"/>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="chk_1">Single device </label>
                    <input id="single-device" type="checkbox" class="js-switch" {{ $appFeatures->single_device == 1 ? 'checked' : '' }} data-size="small" />
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="chk_1">Mass Email </label>
                    <input id="mass-email" {{ $appFeatures->mass_email == 1 ? 'checked' : '' }} type="checkbox" class="js-switch" data-size="small" />
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="chk_1">Redeem Amont </label>
                    <input id="redeem-amount" type="checkbox" class="js-switch" {{ $appFeatures->redeem_amount == 1 ? 'checked' : '' }} data-size="small" />
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="chk_1">Reffer </label>
                    <input id="reffer" type="checkbox" class="js-switch" class="js-switch" {{ $appFeatures->reffer == 1 ? 'checked' : '' }} data-size="small" />
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="chk_1">Spinner 3 month  </label>
                    <input id="spinner-3-month" type="checkbox" class="js-switch" {{ $appFeatures->spinner_3_month == 1 ? 'checked' : '' }} data-size="small" />
                </div>

            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">2</div>
    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">3</div>
  </div>

</div>
<!-- partial -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js'></script>
<script src='https://abpetkov.github.io/switchery/dist/switchery.min.js'></script>
<script>
	var switchery = {};
	$.fn.initComponents = function () {
	    //Init CheckBox Style
	    var searchBy = ".js-switch";
	    $(this).find(searchBy).each(function (i, html) {
		debugger;
		if (!$(html).next().hasClass("switchery")) {
		    switchery[html.getAttribute('id')] = new Switchery(html, $(html).data());
		}
	    });
	};

	$(document).ready(function(){
	  $("body").initComponents();

	  $("#btn_1").click(function(){
	    switchery["chk_1"].setPosition(true);
	  });

	  $("#btn_2").click(function(){
	    if(switchery["chk_2"].isDisabled())
	      {
		switchery["chk_2"].enable();
	      }else{
		switchery["chk_2"].disable();
	      }
	  });

	  $("#btn_3").click(function(){
	    switchery["chk_3"].handleOnchange(true);
	  });

	  $("#chk_3").change(function(){
	    alert("change here");
	  });
	});

    $(document).ready(function(){

        $('#spinner').on('change', function(){
            // alert('change');
            var spinner;
            if($(this).is(':checked')){
                spinner = 1;
            }else{
                spinner = 0;
            }
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
            $.ajax({

                url:"{{ route('superadmin.spinner') }}",
                type:"POST",
                data:{'spinner':spinner},
                success:function(data){
                    console.log(data);
                    console.log("succcess");
                },
                error:function(xhr, status, error){
                    console.log(xhr.responseText);
                }
            });
        });

        $('#missing-user').on('change', function(){
            // alert('change');
            var missing_players;
            if($(this).is(':checked')){
                missing_players = 1;
            }else{
                missing_players = 0;
            }
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
            $.ajax({

                url:"{{ route('superadmin.spinner') }}",
                type:"POST",
                data:{'missing_players':missing_players},
                success:function(data){
                    console.log("succcess");
                },
                error:function(xhr, status, error){
                    console.log(xhr.responseText);
                }
            });
        });

        $('#single-device').on('change', function(){
            // alert('change');
            var single_device;
            if($(this).is(':checked')){
                single_device = 1;
            }else{
                single_device = 0;
            }
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
            $.ajax({

                url:"{{ route('superadmin.spinner') }}",
                type:"POST",
                data:{'single_device':single_device},
                success:function(data){
                    console.log("succcess");
                },
                error:function(xhr, status, error){
                    console.log(xhr.responseText);
                }
            });
        });

        $('#mass-email').on('change', function(){
            // alert('change');
            var mass_email;
            if($(this).is(':checked')){
                mass_email = 1;
            }else{
                mass_email = 0;
            }
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
            $.ajax({

                url:"{{ route('superadmin.spinner') }}",
                type:"POST",
                data:{'mass_email':mass_email},
                success:function(data){
                    console.log("succcess");
                },
                error:function(xhr, status, error){
                    console.log(xhr.responseText);
                }
            });
        });

        $('#redeem-amount').on('change', function(){
            // alert('change');
            var redeem_amount;
            if($(this).is(':checked')){
                redeem_amount = 1;
            }else{
                redeem_amount = 0;
            }
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
            $.ajax({

                url:"{{ route('superadmin.spinner') }}",
                type:"POST",
                data:{'redeem_amount':redeem_amount},
                success:function(data){
                    console.log("succcess");
                },
                error:function(xhr, status, error){
                    console.log(xhr.responseText);
                }
            });
        });

        $('#reffer').on('change', function(){
            // alert('change');
            var reffer;
            if($(this).is(':checked')){
                reffer = 1;
            }else{
                reffer = 0;
            }
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
            $.ajax({

                url:"{{ route('superadmin.spinner') }}",
                type:"POST",
                data:{'reffer':reffer},
                success:function(data){
                    console.log("succcess");
                },
                error:function(xhr, status, error){
                    console.log(xhr.responseText);
                }
            });
        });

        $('#spinner-3-month').on('change', function(){
            // alert('change');
            var spinner_3_month;
            if($(this).is(':checked')){
                spinner_3_month = 1;
            }else{
                spinner_3_month = 0;
            }
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
            $.ajax({

                url:"{{ route('superadmin.spinner') }}",
                type:"POST",
                data:{'spinner_3_month':spinner_3_month},
                success:function(data){
                    console.log("succcess");
                },
                error:function(xhr, status, error){
                    console.log(error);
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>

</body>
</html>
