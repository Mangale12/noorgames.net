@extends('newLayout.layouts.newLayout')

@section('title')
    category
@endsection
@section('content')
@php
    use Carbon\Carbon;
@endphp
<style>
     td{
            border: none;
        }
    .count-row{
        font-weight: 700;
    }
    .name-td,.status-td{
      text-transform:capitalize;
    }
</style>
<div class="row justify-content-center">
            <div class="col-md-12 card">
                <div class="card-body">
                <div class="row justify-content-between">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg1">
                      Add category
                    </button>

                 </div>
                </div>
                <div class="table-responsive p-4" style="overflow-x:auto;">
                     <!--id="datatable-crud"-->
                    <table class="table datatable" style="font-size:14px">
                        <thead>
                            <tr>
                                    <th style="width: 26.328100000000006px!important;">No</th>
                                    <th class="big-col">Action</th>
                                    {{-- <th class="cus-width">Image</th> --}}
                                    <th class="cus-width">Name</th>
                                    {{-- <th class="cus-width">Title</th> --}}
                                    {{-- <th class="cus-width"></th> --}}
                                    <th class="cus-width">Sub Category</th>
                            </tr>
                        </thead>
                         <tbody>
                  @foreach($categories as $num)
                  <tr class="tr-{{$num->id}}">
                    <td class="count-row">{{$loop->iteration}}</th>
                     <td class="display-inline-block">
                         <a href="javascript:void(0);" data-id="{{$num->id}}" class="btn btn-success edit-game padding-5">
                            <i class="fa fa-edit font-13"></i>
                        </a>
                         <a href="javascript:void(0);" data-id="{{$num->id}}" class="btn btn-danger delete-game padding-5">
                            <i class="fa fa-trash font-13"></i>
                        </a>
                        <a href="javascript:void(0);" data-id="{{$num->id}}" class="btn btn-warning image-game padding-5">
                           <i class="fa fa-image font-13"></i>
                       </a>
                        <a href="{{route('gameImage',['id'=>$num->id])}}" data-id="{{$num->id}}" class="btn btn-success padding-5">
                           <i class="fa fa-picture font-13"></i>
                       </a>

                     </td>
                     {{-- <td>
                       <img style="max-width: 40%" src="{{asset('/public/uploads/'.$num->image)}}" alt="{{($num->name)}}">
                     </td> --}}
                    <td class="name-td td-name-{{$num->id}}">{{($num->name)}}</td>
                    {{-- <td class="title-td td-title-{{$num->id}}">{{($num->title)}}</td>
                    <td class="td-balance-{{$num->id}}">{{($num->balance)}}</td> --}}
                    <td class="status-td td-status-{{$num->id}}">
                      {{-- <span class="badge  {{($num->status == 'active')?'bg-gradient-success':'bg-gradient-danger'}}">{{ucwords($num->status)}}</span> --}}
                    </td>

                  </tr>
                  @endforeach
               </tbody>
                    </table>
                </div>

                </div>
            </div>
    </div>
    <div class="modal fade bd-example-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-body editFormModalBody">
                <div class="appendHere">
                  <form action="{{route('gameImageStore')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <input type="hidden" name="id" id="game-id-image" value="">
                      <div class="col-12 mt-2">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="file" class="form-control" id="image">
                      </div>
                      <div class="col-12 mt-2">
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </div>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="modal fade bd-example-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background:">
                  <h5 class="modal-title" id="exampleModalLabel" style="color: white">Edit Image</h5>
                </div>
                <div class="modal-body editFormModalBody">
                  <div class="appendHere">
                    <form action="{{route('gameImageStore')}}" method="post" enctype="multipart/form-data">
                      @csrf
                      <div class="row">
                        <input type="hidden" name="id" id="game-id-image" value="">
                        <div class="col-12 mt-2">
                          <label for="image" class="form-label">Image</label>
                          <input type="file" name="file" class="form-control" id="image">
                        </div>
                        <div class="col-12 mt-2">
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
        </div>
    </div> --}}
    {{-- <div class="modal fade bd-example-modal-lg editImageModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background:">
                  <h5 class="modal-title" id="exampleModalLabel" style="color: white">Edit Image</h5>
                </div>
                <div class="modal-body editFormModalBody">
                  <div class="appendHere">
                    <form action="{{route('gameImageStore')}}" method="post" enctype="multipart/form-data">
                      @csrf
                      <div class="row">
                        <input type="hidden" name="id" id="game-id-image" value="">
                        <div class="col-12 mt-2">
                          <label for="image" class="form-label">Image</label>
                          <input type="file" name="file" class="form-control" id="image">
                        </div>
                        <div class="col-12 mt-2">
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
        </div>
    </div> --}}

    <div class="modal fade bd-example-modal-lg1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add New Feature</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="{{route('category.store')}}" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                    <div class="col-6">
                      <label for="name" class="form-label">Category</label>
                      <input required name="name" type="text" class="form-control" id="name" placeholder="Name">
                    </div>
                    <div class="col-6">
                      <label for="title" class="form-label">Sub Category</label>
                      <select name="sub_category" id="sub-category" class="form-control">
                        <option value="">Select Parent Category</option>
                        @foreach ($categories as $category)
                        @if($category->sub_category == null)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endif
                        @endforeach
                      </select>
                    </div>
                    <div class="col-6">
                        <label for="title" class="form-label">Role</label>
                        <select name="role" id="sub-category" class="form-control">
                          <option value="">Select Role</option>
                          <option value="admin">Admin</option>
                          <option value="cashier">Cashier</option>
                          <option value="dataexpert">Data Expert</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="icon" class="form-label">Icon</label>
                        <input required name="icon" type="text" class="form-control category_icon" id="icon" placeholder="icon">
                    </div>
                      <div class="col-12">
                        <label for="name" class="form-label">Category link</label>
                        <input required name="category_link" type="text" class="form-control category-link" id="category-link" placeholder="Category Link">
                    </div>



                    {{-- <div class="col-6 mt-2">
                      <label for="balance" class="form-label">Balance</label>
                      <input required name="balance" type="number" class="form-control" id="balance" placeholder="Balance">
                    </div> --}}
                    {{-- <div class="col-6 mt-2">
                      <label for="status" class="form-label">Status</label>
                      <select required name="status" id="" class="form-control">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                      </select>
                    </div> --}}
                    {{-- <div class="col-6 mt-2">
                      <label for="image" class="form-label">Image</label>
                      <input type="file" name="file" class="form-control" id="image">
                    </div> --}}
                    <div class="col-12 mt-2">
                      <button type="submit">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg1 editFormModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Feature</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="{{route('category.update')}}" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                    <div class="col-6">
                      <label for="name" class="form-label">Category</label>
                      <input required name="name" type="text" class="form-control name" id="name" placeholder="Name">
                    </div>
                    <div class="col-6">
                        <label for="sub-category" class="form-label">Sub Category</label>
                        <select name="sub_category" id="sub-category" class="form-control">
                            <option value="">Select Parent Category</option>

                          @foreach ($categories as $category)
                          @if($category->sub_category == null)
                              <option value="{{ $category->id }}">{{ $category->name }}</option>
                          @endif
                          @endforeach
                        </select>
                        {{-- <input  name="title" type="text" class="form-control sub" id="title" placeholder="Title"> --}}
                      </div>
                      <div class="col-6">
                        <label for="title" class="form-label">Role</label>
                        <select name="role" id="sub-category" class="form-control">
                          <option value="">Select Role</option>
                          <option value="admin">Admin</option>
                          <option value="cashier">Cashier</option>
                          <option value="data-expert">Data Expert</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="icon" class="form-label">Icon</label>
                        <input required name="icon" type="text" class="form-control category_icon" id="icon" placeholder="icon">
                    </div>
                    <div class="col-12">
                        <label for="name" class="form-label">Category link</label>
                        <input required name="category_link" type="text" class="form-control category-link" id="category-link" placeholder="Category Link">
                    </div>


                    <input name="category_id" type="hidden" value="" class="category-id">

                    {{-- <div class="col-6 mt-2">
                      <label for="balance" class="form-label">Balance</label>
                      <input required name="balance" type="number" class="form-control" id="balance" placeholder="Balance">
                    </div> --}}
                    {{-- <div class="col-6 mt-2">
                      <label for="status" class="form-label">Status</label>
                      <select required name="status" id="" class="form-control">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                      </select>
                    </div> --}}
                    {{-- <div class="col-6 mt-2">
                      <label for="image" class="form-label">Image</label>
                      <input type="file" name="file" class="form-control" id="image">
                    </div> --}}
                    <div class="col-12 mt-2">
                      <button type="submit">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
    </div>

@endsection

@section('script')
<script>
      jQuery(document).ready( function () {

        $('.datatable tbody').on('click', '.image-game', function () {
          $('#game-id-image').val($(this).data('id'));
          $('.editImageModal').modal('show');
        });
        $('.datatable tbody').on('click', '.edit-game', function () {
            $('.editFormModal').modal('show');
            var cid = $(this).data('id');
                    $.ajax({
                        type: 'get',
                        url: "{{ route('category.edit') }}",
                        data: {
                            "category_id": $(this).data('id'),
                        },
                        dataType: 'json',
                        success: function (data) {
                            console.log(data);
                            $('.appendHere').remove();
                            $('.editFormModalBody').append('<div class="appendHere"></div>');
                            $('.appendHere').append(data);
                            $('.name').val(data.category.name);
                            $('.category-id').val(data.category.id);
                            $('.category-link').val(data.category.link);
                            $('.category_icon').val(data.category.icon);
                            // $('#summernote').summernote();
                            // $( ".count-row" ).each(function( index ) {
                                // $(this).text((index+1));
                                // console.log( index + ": " + $( this ).text() );
                            // })
                            // toastr.success('Success',"Deleted");

                        },
                        error: function (data) {
                            console.log(data);
                            toastr.error('Error',data.responseText);
                        }
                    });
        });
        var link = $('.delete-form').attr("href");
        // var link = $('.delete-form');
        $('.datatable tbody').on('click', '.delete-game', function (e) {
            e.preventDefault();
            Swal.fire({
            title: 'Are you sure you want to delete this?',
            showDenyButton: true,
            showCancelButton: true,
            showConfirmButton: false,
            // confirmButtonText: 'Save',
              denyButtonText: `Delete`,
            }).then((result) => {
                if (result.isConfirmed) {
                }
                else if (result.isDenied) {
                    var cid = $(this).data('id');
                    $.ajax({
                        type: 'get',
                        url: "/games/destroy/"+cid,
                        data: {
                            "cid": $(this).data('id'),
                        },
                        dataType: 'json',
                        success: function (data) {
                            console.log(data);
                            $('.tr-'+cid).remove();
                            $( ".count-row" ).each(function( index ) {
                                $(this).text((index+1));
                                // console.log( index + ": " + $( this ).text() );
                            });
                            toastr.success('Success',"Deleted");

                        },
                        error: function (data) {
                            console.log(data);
                            toastr.error('Error',data.responseText);
                        }
                    });
                    // window.location = link;
                }
            });
        });
      });

    </script>
@endsection

