@php
    $data = json_decode($details['text'],true);
    // dd($data);
@endphp
<style>
    .center {
    margin: auto;
    width: 50%;
    border: 3px solid green;
    padding: 10px;
    color: white !important;
  }
  .im {
      position: absolute;
      top: 9%;
      right: 46%;
  }
  </style>

  <!-- partial:index.partial.html -->
  <div style="background: linear-gradient(to bottom right, #383875 ,#010119);
  height:85vh;
  width:70vw;
  position:absolute;
  left:50%;
  top:50%;
  transform: translate(-50%, -50%);
  box-shadow: 0 5px 15px rgba(161, 151, 151, 0.7);">
          <div class="center mt-5" style="margin-top: 2rem; width: 50%;
              border: 3px solid green;
              padding: 10px;
              color: white !important;">
              <img src="https://noorgames.net/images/dragonnn.gif" alt="" style="height: 9rem; widht:10%;   display: block;
              margin-left: auto;
              margin-right: auto;">

              <p style="color:rgb(251, 248, 248)">Congratulation !! {{ $data['referal']['full_name'] }} {{ $data['message'] }}</p>
                  <div class="mt-5">
                      <p style="color:rgb(252, 246, 246)">copyright text here</p>


                  </div>
          </div>

      </div>

  </div>


