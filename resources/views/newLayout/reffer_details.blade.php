@extends('newLayout.layouts.newLayout')

@section('title')
    Reffer Details
@endsection
@section('content')
    <style>
        .dataTables_wrapper {
            padding: 25px;
        }

        .dataTables_wrapper .row {
            padding: 10px;
        }

        tbody tr td {
            border-bottom: none;
        }

        .active-game-btn {
            background: #feb343;
        }

        table {
            margin: 1em 0;
            border-collapse: collapse;
            border: 0.1em solid #d6d6d6;
        }

        caption {
            text-align: left;
            font-style: italic;
            padding: 0.25em 0.5em 0.5em 0.5em;
        }

        th,
        td {
            padding: 0.25em 0.5em 0.25em 1em;
            vertical-align: text-top;
            text-align: left;
            text-indent: -0.5em;
        }

        th {
            vertical-align: bottom;
            background-color: #666;
            color: #fff;
        }

        tr:nth-child(even) th[scope=row] {
            background-color: #f2f2f2;
        }

        tr:nth-child(odd) th[scope=row] {
            background-color: #fff;
        }

        tr:nth-child(even) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        tr:nth-child(odd) {
            background-color: rgba(255, 255, 255, 0.05);
        }



        .overlay {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.7);
            transition: opacity 500ms;
            visibility: hidden;
            opacity: 0;
            z-index: 9999;
        }

        .overlay:target {
            visibility: visible;
            opacity: 1;
        }


        .popup {
            margin: 70px auto;
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            width: 50%;
            position: relative;
            transition: all 5s ease-in-out;



        }

        .popup h2 {
            margin-top: 0;
            color: #333;
            font-family: Tahoma, Arial, sans-serif;

        }

        .popup .close {
            position: absolute;
            top: 20px;
            right: 30px;
            transition: all 200ms;
            font-size: 30px;
            font-weight: bold;
            text-decoration: none;
            color: #333;

        }

        .popup .close:hover {
            color: #FF9800;
        }

        .popup .content {
            max-height: calc(100vh - 210px);
            overflow-y: auto;
        }

        @media screen and (max-width: 700px) {
            .box {
                width: 70%;
            }

            .popup {
                width: 70%;
            }
        }


        #timedate {
            font: small-caps lighter auto/150% "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
            text-align: left;

            margin: 40px auto;
            color: #fff;
            padding: 20px;
        }




        .dropdown {
            position: relative;
            display: inline-block;
        }



        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);

        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1
        }

        .dropdown:hover .dropdown-content {
            display: block;
            left: 0px;
            top: 0px;
            position: absolute;
            margin: 0rem 0rem -4rem -4rem;

        }


        .hidden {
            display: none;
        }

        .game-head-btn-div a:hover {
            background: #fdb244;
        }

        .active-game-btn .card {
            background: #fdb244;
        }

        .breadcrumb-div {
            background: #5e5050cc;
            padding: 5px;
        }

        .game-popup.game-categories-wrapper {
            border: 2px solid #e0e0e0;
            padding: 5px;
            margin: 5px;
        }

        .active-game-btn {
            background: #feb343 !important;
        }
    </style>

    <style>
        .color-red {
            color: red;
        }

        .color-green {
            color: green;
        }

        .color-yellow {
            color: yellow;
        }
    </style>
    @if (Auth::user()->role == 'admin')
    @endif
    <div class="row justify-content-center mt-5">
        <div class="col-md-12 card upCard">
            <div class="card-body">
                <div class="row">
                    {{-- @php echo $month; @endphp --}}
                    @foreach ($all_months as $m => $i)
                        <div class="col-2 game-head-btn-div">
                            {{-- @if (isset($games) && !empty($games)) --}}
                            @if ($month < 10)
                                @php
                                    $z = str_replace('0', '', $month);
                                @endphp
                           @else
                              @php
                                 $z = $month;
                              @endphp
                            @endif
                            @if ($z == $m)
                                @php
                                    $current_month = $i;
                                    //dd($memberTotal);
                                @endphp
                            @endif
                            <a href="{{ URL::to('/reffer-details?year=' . $year . '&month=' . $m . ($sel_cat ? '&category=' . $sel_cat : '')) }}"
                                class="btn btn-success w-100 mb-1 {{ $z == $m ? 'active-game-btn' : '' }}">
                                {{ $i }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="werqwerq" style="padding-top:20px;">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 datatableCustom">
                            <thead class="sticky">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        SN</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                            Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        Reffer Code</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        Total Reffer</th>

                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                        Reffer in Month</th>

                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                        Reffer Total Load</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                        FaceBook Name</th>

                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                        Total Balance</th>

                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="verified-table">
                                @php

                                    $count = 1;

                                    $refferSum = 0;


                                @endphp
                                @foreach ($usersDetails as $key => $item)
                                @if($item['countVerified'] < 3)
                                    <tr class="tr-{{ $item['users']['id'] }}" data-all="0">
                                        <!--<td class="align-middle text-center" style="text-align: center">{{ $count++ }}-->
                                        <!--</td>-->

                                        <td class="align-middle text-center" style="text-align: center">
                                            <span class="d-inline">{{ $loop->iteration }}</span>

                                        </td>

                                        <td class="align-middle text-center" style="text-align: center">
                                            {{-- {{$current_month.' ,'.$key}} --}}

                                            @if($item['totalRefferLoad'] >= 500)
                                            <i class="fa fa-circle color-red" style="margin-right: 5px;"></i>
                                            @else
                                            <i class="fa fa-circle color-yellow" style="margin-right: 5px;"></i>
                                            @endif
                                        </td>


                                        <td class="align-middle text-center" style="text-align: center">
                                          <span class="refferer-name" data-id="{{ $item['users']['id'] }}">{{ $item['users']['full_name'] }}</span>

                                        </td>
                                        <td class="align-middle text-center" style="text-align: center">
                                            {{ $item['users']['game_id'] }}
                                        </td>
                                        <td class="align-middle text-center" style="text-align: center">
                                            @foreach($item['totalReffer'] as $key => $reffer)
                                            @if($reffer['is_verified'] == 0)
                                            <span class="reffer_name">
                                                <input type="checkbox" class="reffer_conform" {{ $reffer['is_verified']==1 ? 'checked' : ''}} data-id="{{ $reffer['id'] }}">{{ $reffer['full_name'] }} [
                                                    @foreach ($memberTotal as $total)
                                                        @if($reffer['id']==$total['form_id'])
                                                        {{ $total['total'] }}
                                                        @endif
                                                    @endforeach
                                                ],
                                            </span><br>
                                            @endif
                                            @endforeach
                                        </td>
                                        <div class="modal modal-{{ $item['users']['id'] }}" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title">Verified members</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>
                                                <div class="modal-body">
                                                    <ol>
                                                        @foreach($item['totalReffer'] as $key => $reffer)
                                                        @if($reffer['is_verified']==1)
                                                        <li class="reffer_name">
                                                            <input type="checkbox" class="reffer_conform" {{ $reffer['is_verified']==1 ? 'checked' : ''}} data-id="{{ $reffer['id'] }}">{{ $reffer['full_name'] }} [
                                                                @foreach ($memberTotal as $total)
                                                                    @if($reffer['id']==$total['form_id'])
                                                                    {{ $refferSum+=$total['total'] }}
                                                                    @endif
                                                                @endforeach
                                                            ],
                                                        </li><br>
                                                        @endif
                                                    @endforeach
                                                    </ol>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        <td class="align-middle text-center" style="text-align: center">
                                            {{ $item['refferMonthCount'] }}
                                        </td>
                                        <td class="align-middle text-center" style="text-align: center">
                                            {{ $item['totalRefferLoad'] }}
                                        </td>

                                        <td class="align-middle text-center">
                                            <span class="badge  bg-gradient-success">{{ $item['users']['facebook_name'] }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge  bg-gradient-success">{{ $item['total'] }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="" class="this-day-redeem btn btn-primary"
                                                data-form="{{ $item['users']['id'] }}" data-year="{{ $year }}"
                                                data-month="{{ $month }}" data-day="{{ $key }}"
                                                data-category="{{ $sel_cat ? $sel_cat : 'all' }}"
                                                href="javascript:void(0);">
                                                View
                                            </a>
                                            <a href="" class="add-reffer-member btn btn-primary"
                                                data-form="{{ $item['users']['id'] }}" data-year="{{ $year }}"
                                                data-month="{{ $month }}" data-day="{{ $key }}"
                                                data-category="{{ $sel_cat ? $sel_cat : 'all' }}"
                                                href="javascript:void(0);">
                                                Add Refer
                                            </a>
                                            <a href="" class="edit-member btn btn-primary"
                                                data-form="{{ $item['users']['id'] }}" data-year="{{ $year }}"
                                                data-month="{{ $month }}" data-day="{{ $key }}"
                                                data-category="{{ $sel_cat ? $sel_cat : 'all' }}"
                                                href="javascript:void(0);">
                                                Undo
                                            </a>
                                            <div id="popup1" class="overlay">
                                                <div class="popup" style="width:95%">
                                                    <h2 class="popup-title">History</h2>
                                                    <a class="close" href="#">&times;</a>
                                                    <div class="content ">
                                                        <div class="row" style="padding-top:20px;">
                                                            <div class="col-12">
                                                                <div class="card mb-4">

                                                                    <div class="card-body px-0 pt-0 pb-2">

                                                                        <button
                                                                            class="filter-history btn btn-primary hidden"
                                                                            data-userId="" data-game="">Go</button>

                                                                        <div class="table-responsive p-0">
                                                                            <table class="table align-items-center mb-0">
                                                                                <thead class="sticky">
                                                                                    <tr>
                                                                                        <th
                                                                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            Name</th>
                                                                                        <th
                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            Amount</th>
                                                                                        <th
                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            FB Name</th>
                                                                                        <th
                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            Game</th>
                                                                                        <th
                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            Game ID</th>
                                                                                        <th
                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            Joined at</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody class="user-history-body">

                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                            <div id="popup33" class="overlay">
                                                <div class="popup">
                                                    <h2>User</h2>
                                                    <a class="close" href="#">&times;</a>
                                                    <div class="content ">
                                                        <label for="cars">User: Full Name [ Facebook Name ]</label>

                                                            <input type="hidden" value="" class="form-reffer">
                                                           <select name="id" id="id" class="select2 form-control" required>
                                                           @php
                                                                $users = \App\Models\Form::get();
                                                            @endphp
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}">{{ $user->full_name }} [ {{ $user->facebook_name }} ]</option>
                                                            @endforeach
                                                            </select>
                                                            <br>

                                                            <br>
                                                            <button class="btn add-member  btn-primary mb-0" style="background-color:#FF9800;"  >ADD</button>

                                                    </div>
                                                </div>
                                            </div>



                                            <div id="popup2" class="overlay">
                                                <div class="popup" style="width:95%">
                                                    <h2 class="popup-title">Reffer Member</h2>
                                                    <a class="close" href="#">&times;</a>
                                                    <div class="content ">
                                                        <div class="row" style="padding-top:20px;">
                                                            <div class="col-12">
                                                                <div class="card mb-4">

                                                                    <div class="card-body px-0 pt-0 pb-2">

                                                                        <button
                                                                            class="filter-history btn btn-primary hidden"
                                                                            data-userId="" data-game="">Go</button>

                                                                        <div class="table-responsive p-0">
                                                                            <table class="table align-items-center mb-0">
                                                                                <thead class="sticky">
                                                                                    <tr>
                                                                                        <th
                                                                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            Name</th>
                                                                                        <th
                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            REffer Id</th>
                                                                                        <th
                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            FB Name</th>
                                                                                        <!--<th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">-->
                                                                                        <!--    Game</th>-->
                                                                                        <th
                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            Game ID</th>
                                                                                        <th
                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            Joined at</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody class="user-history-body">

                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div><h2>Verified Users List</h2></div>
    <div class="row" id="werqwerq" style="padding-top:20px;">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 datatableCustom">
                            <thead class="sticky">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        SN</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                            Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        Reffer Code</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        Total Reffer</th>

                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                        Reffer in Month</th>

                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                        Reffer Total Load</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                        FaceBook Name</th>

                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                        Total Balance</th>

                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="verified-table">
                                @php

                                    $count = 1;

                                    $refferSum = 0;


                                @endphp
                                @foreach ($usersDetails as $key => $item)
                                @if($item['countVerified'] >= 3)
                                    <tr class="tr-{{ $item['users']['id'] }}" data-all="0">
                                        <!--<td class="align-middle text-center" style="text-align: center">{{ $count++ }}-->
                                        <!--</td>-->

                                        <td class="align-middle text-center" style="text-align: center">
                                            <span class="d-inline">{{ $loop->iteration }}</span>

                                        </td>

                                        <td class="align-middle text-center" style="text-align: center">
                                            {{-- {{$current_month.' ,'.$key}} --}}

                                            @if($item['totalRefferLoad'] >= 500)
                                            <i class="fa fa-circle color-red" style="margin-right: 5px;"></i>
                                            @else
                                            <i class="fa fa-circle color-yellow" style="margin-right: 5px;"></i>
                                            @endif
                                        </td>


                                        <td class="align-middle text-center" style="text-align: center">
                                          <span class="refferer-name" data-id="{{ $item['users']['id'] }}">{{ $item['users']['full_name'] }}</span>

                                        </td>
                                        <td class="align-middle text-center" style="text-align: center">
                                            {{ $item['users']['game_id'] }}
                                        </td>
                                        <td class="align-middle text-center" style="text-align: center">
                                            @foreach($item['totalReffer'] as $key => $reffer)
                                            @if($reffer['is_verified'] == 1)
                                            <span class="reffer_name">
                                                <input type="checkbox" class="reffer_conform" {{ $reffer['is_verified']==1 ? 'checked' : ''}} data-id="{{ $reffer['id'] }}">{{ $reffer['full_name'] }} [
                                                    @foreach ($memberTotal as $total)
                                                        @if($reffer['id']==$total['form_id'])
                                                        {{ $total['total'] }}
                                                        @endif
                                                    @endforeach
                                                ],
                                            </span><br>
                                            @endif
                                            @endforeach
                                        </td>
                                        <div class="modal modal-{{ $item['users']['id'] }}" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title">Verified members</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>
                                                <div class="modal-body">
                                                    <ol>
                                                        @foreach($item['totalReffer'] as $key => $reffer)
                                                        @if($reffer['is_verified']==1)
                                                        <li class="reffer_name">
                                                            <input type="checkbox" class="reffer_conform" {{ $reffer['is_verified']==1 ? 'checked' : ''}} data-id="{{ $reffer['id'] }}">{{ $reffer['full_name'] }} [
                                                                @foreach ($memberTotal as $total)
                                                                    @if($reffer['id']==$total['form_id'])
                                                                    {{ $refferSum+=$total['total'] }}
                                                                    @endif
                                                                @endforeach
                                                            ],
                                                        </li><br>
                                                        @endif
                                                    @endforeach
                                                    </ol>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        <td class="align-middle text-center" style="text-align: center">
                                            {{ $item['refferMonthCount'] }}
                                        </td>
                                        <td class="align-middle text-center" style="text-align: center">
                                            {{ $item['totalRefferLoad'] }}
                                        </td>

                                        <td class="align-middle text-center">
                                            <span class="badge  bg-gradient-success">{{ $item['users']['facebook_name'] }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge  bg-gradient-success">{{ $item['total'] }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="" class="this-day-redeem btn btn-primary"
                                                data-form="{{ $item['users']['id'] }}" data-year="{{ $year }}"
                                                data-month="{{ $month }}" data-day="{{ $key }}"
                                                data-category="{{ $sel_cat ? $sel_cat : 'all' }}"
                                                href="javascript:void(0);">
                                                View
                                            </a>
                                            <a href="" class="add-reffer-member btn btn-primary"
                                                data-form="{{ $item['users']['id'] }}" data-year="{{ $year }}"
                                                data-month="{{ $month }}" data-day="{{ $key }}"
                                                data-category="{{ $sel_cat ? $sel_cat : 'all' }}"
                                                href="javascript:void(0);">
                                                Add Refer
                                            </a>
                                            <a href="" class="edit-member btn btn-primary"
                                                data-form="{{ $item['users']['id'] }}" data-year="{{ $year }}"
                                                data-month="{{ $month }}" data-day="{{ $key }}"
                                                data-category="{{ $sel_cat ? $sel_cat : 'all' }}"
                                                href="javascript:void(0);">
                                                Undo
                                            </a>
                                            <div id="popup1" class="overlay">
                                                <div class="popup" style="width:95%">
                                                    <h2 class="popup-title">History</h2>
                                                    <a class="close" href="#">&times;</a>
                                                    <div class="content ">
                                                        <div class="row" style="padding-top:20px;">
                                                            <div class="col-12">
                                                                <div class="card mb-4">

                                                                    <div class="card-body px-0 pt-0 pb-2">

                                                                        <button
                                                                            class="filter-history btn btn-primary hidden"
                                                                            data-userId="" data-game="">Go</button>

                                                                        <div class="table-responsive p-0">
                                                                            <table class="table align-items-center mb-0">
                                                                                <thead class="sticky">
                                                                                    <tr>
                                                                                        <th
                                                                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            Name</th>
                                                                                        <th
                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            Amount</th>
                                                                                        <th
                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            FB Name</th>
                                                                                        <th
                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            Game</th>
                                                                                        <th
                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            Game ID</th>
                                                                                        <th
                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            Joined at</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody class="user-history-body">

                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                            <div id="popup33" class="overlay">
                                                <div class="popup">
                                                    <h2>User</h2>
                                                    <a class="close" href="#">&times;</a>
                                                    <div class="content ">
                                                        <label for="cars">User: Full Name [ Facebook Name ]</label>

                                                            <input type="hidden" value="" class="form-reffer">
                                                           <select name="id" id="id" class="select2 form-control" required>
                                                           @php
                                                                $users = \App\Models\Form::get();
                                                            @endphp
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}">{{ $user->full_name }} [ {{ $user->facebook_name }} ]</option>
                                                            @endforeach
                                                            </select>
                                                            <br>

                                                            <br>
                                                            <button class="btn add-member  btn-primary mb-0" style="background-color:#FF9800;"  >ADD</button>

                                                    </div>
                                                </div>
                                            </div>



                                            <div id="popup2" class="overlay">
                                                <div class="popup" style="width:95%">
                                                    <h2 class="popup-title">Reffer Member</h2>
                                                    <a class="close" href="#">&times;</a>
                                                    <div class="content ">
                                                        <div class="row" style="padding-top:20px;">
                                                            <div class="col-12">
                                                                <div class="card mb-4">

                                                                    <div class="card-body px-0 pt-0 pb-2">

                                                                        <button
                                                                            class="filter-history btn btn-primary hidden"
                                                                            data-userId="" data-game="">Go</button>

                                                                        <div class="table-responsive p-0">
                                                                            <table class="table align-items-center mb-0">
                                                                                <thead class="sticky">
                                                                                    <tr>
                                                                                        <th
                                                                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            Name</th>
                                                                                        <th
                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            REffer Id</th>
                                                                                        <th
                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            FB Name</th>
                                                                                        <!--<th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">-->
                                                                                        <!--    Game</th>-->
                                                                                        <th
                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            Game ID</th>
                                                                                        <th
                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                            Joined at</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody class="user-history-body">

                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @php
        $year = '';
        $month = '';
        if (isset($_GET['year'])) {
            $year = $_GET['year'];
        }
        if (isset($_GET['month'])) {
            $month = $_GET['month'];
        }
    @endphp
    <script>
      $('.datatableCustom').DataTable({
        "pageLength": 100
      });
        $(function() {
            $(".search-undo").on("change", function() {
                var value = $(this).val().toLowerCase();
                if (value != 0) {
                    $(".doubful-table > tr").filter(function() {
                        $(this).toggle($(this).attr('data-status').indexOf(value) > -1)
                    });
                } else {
                    // value = 'all';
                    $(".doubful-table > tr").filter(function() {
                        $(this).toggle($(this).attr('data-all').indexOf(value) > -1)
                    });
                }
            });
        });

        $(document).ready(function(){
            $('.add-reffer-member').on('click', function(){
                $(this).attr("href","#popup33");
                $('.form-reffer').val($(this).data('form'));

            });
            $('.add-member').on('click', function(){

                var form = $('.form-reffer').val();
                var member = $('#id').val();

                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            //   console.log(form);
            // console.log('1');
            var actionType = "POST";
            var ajaxurl = '/assign-reffer';
            $.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    "form": form,
                    "member": member,
                },
                dataType: 'json',
                success: function(data) {
                    toastr.success('Success',"Refferer assigned successfully");

                },
                error: function(data) {
                    alert(data.responseText);
                    toastr.error('Error', data.responseText);
                }
            });

            });
            $('.this-day-redeem').on('click',function(){
                $(this).attr("href","#popup1")
                console.log('asdf');
            var month_symbols = ['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                'September', 'October', 'November', 'December'
            ];
            var year = $(this).attr("data-year");
            var month = $(this).attr("data-month");
            var day = $(this).attr("data-day");
            var form = $(this).attr("data-form");
            var category = $(this).attr("data-category");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            //   console.log(form);
            // console.log('1');
            var actionType = "POST";
            var ajaxurl = '/reffer-details';
            $.ajax({
                type: "POST",
                url: "{{ route('reffer_member') }}",
                data: {
                    "year": year,
                    "month": month,
                    "day": day,
                    "category": category,
                    'form': form
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    if (data.usersDetails != '') {
                        var optionLoop = '',
                            options = data.usersDetails;
                        var monthShortNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug",
                            "Sep", "Oct", "Nov", "Dec"
                        ];
                        var a = 1;
                        options.forEach(function(index, value) {
                            console.log(index.user.form.game_id);

                            optionLoop +=
                                '<tr><td class="text-center">' + index.user.form.full_name + '</td>\
                                <td class="text-center"><span class="badge  bg-gradient-success"> ' + index.user.amount_loaded + '$</span></td>\
                                <td class="text-center">' + index.user.form.facebook_name + '</td>\
                                <td class="text-center">' + index.user.amount_loaded + '</td>\
                                <td class="text-center">' + index.game + '</td>\
                                <td class="text-center">' + index.user.created_at + '</td></tr>';
                        });

                    } else {
                        optionLoop = '<tr><td>No History</td></tr>';
                    }
                    $(".user-history-body").html(optionLoop);

                },
                error: function(data) {
                    alert(data.responseText);
                    toastr.error('Error', data.responseText);
                }
            });
            });


            $('.edit-member').on('click',function(){
                var form = $(this).attr("data-form");
               $(this).attr("href","#popup2")
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                //   console.log(form);
                // console.log('1');

                $.ajax({
                    type: "POST",
                    url: "{{ route('refferDetailsEdit') }}",
                    data: {
                        'form': form,
                    },
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        if (data != null) {
                            var optionLoop = '',
                                options = data.reffers;
                            var a = 1;
                            options.forEach(function(index, value) {
                                var id = index.id;
                                optionLoop +=
                                    '<tr><td class="text-center">' + index.full_name + '</td>\
                                    <td class="text-center"><span class="badge  bg-gradient-success"> <input class="reffer_code"  type="text" value="' + index.r_id + '" onchange="changeReffer('+index.id+','+ this.value+')">' + '$</span></td>\
                                    <td class="text-center">' + index.facebook_name + '</td>\
                                    <td class="text-center">' + index.game_id + '</td>\
                                    <td class="text-center">' + index.created_at + '</td></tr>';
                            });

                        } else {
                            optionLoop = '<tr><td>No History</td></tr>';
                        }
                        $(".user-history-body").html(optionLoop);

                    },
                    error: function(data) {
                        alert(data.responseText);
                        toastr.error('Error', data.responseText);
                    }
                });
            });

            $('.reffer_conform').on('change',function(){
                var id = $(this).data('id');
                if ($(this).is(':checked')) {
                    var value = 1;
                }  else{
                    var value = 0;
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
            var actionType = "POST";
            var ajaxurl = '/reffer-details';
            $.ajax({
                type: "POST",
                url: "{{ route('remove_reffer_member') }}",
                data: {
                    "id": id,
                    "value":value,
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    // $(this).parent().fadeOut();
                    toastr.success('Success',data);
                },
                error: function(data) {
                    alert(data.responseText);
                    toastr.error('Error', data.responseText);
                }
            });



                //     }else{
                //         this.checked
                //     }


                // }
            });
            $('.verified-member-card').hide();
            $('.verified-member').on('click', function(){
                var user_id = $(this).data('id');
                $("#member-"+user_id).toggle();
            });

            $('.refferer-name').on('click', function(){
                var id = $(this).data('id');

                $('.modal-'+id).show();
            });
            $('.close').on('click',function(){
                $('.modal').hide();
            });

        });

    // start Muniraj
    $(function(){
      $("#popup33").find(".select2").select2({
               dropdownParent: $('#popup33')
           });
    });

    function add_class(class_name){
        $("#popup33").addClass(class_name);
        $("#popup33 .my_select2").select2();

    }

    function changeReffer(id, value){

        var reffer_code = document.getElementsByClassName("reffer_code")[0].value;
        alert(value);
        fetch('/reffer-code-change', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}', // Use Laravel's CSRF token for security
            },
            body: JSON.stringify({
                id: id,

            }),
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json(); // Parse the response as JSON
            })
            .then(data => {
                // Handle the response data
                console.log(data);
            })
            .catch(error => {
                // Handle errors
                console.error('Fetch error:', error);
            });


    }
    </script>
    <script>
        $(document).ready(function(){
            $('.reffer_code').on('change', function(){
                alert('krkr');
            });
        });
    </script>
@endsection
