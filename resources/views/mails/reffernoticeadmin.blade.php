@php
    $data = json_decode($details['text'],true);
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

            <p>
                <h4>Referal Details</h4>
                Name : {{ $data['referal']['full_name'] }}<br>
                facebook Name : {{ $data['referal']['facebook_name'] }}<br>
                Total Complete: {{ $data['count'] }} <br></p>
            <p>
                <h4>Meber Details</h4>
                Name : {{ $data['user']['full_name'] }}<br>
                facebook Name : {{ $data['user']['facebook_name'] }}<br>
            </p>
          </div>

      </div>

  </div>


