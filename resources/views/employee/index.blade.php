@extends('layouts.app')

@section('content')


<!-- Modal -->
<div class="modal fade" id="add_employee" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Employee</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="error_list"></div>
       <div class="form-group mb-3">
        <label for="names">Employee Name</label>
        <input type="text" class="names form-control">
       </div>
       <div class="form-group mb-3">
        <label for="email">Email</label>
        <input type="email" class="email form-control">
       </div>
       <div class="form-group mb-3">
        <label for="phone">Phone</label>
        <input type="text" class="phone form-control">
       </div>
       <div class="form-group mb-3">
        <label for="role">Role</label>
        <input type="text" class="role form-control">
       </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary add_employee">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- model end -->

<!-- edit model -->
<div class="modal fade" id="edit_employee" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Employee</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="edit_error_list"></div>
        <input type="hidden" id="employee_id">
       <div class="form-group mb-3">
        <label for="names">Employee Name</label>
        <input type="text" id="edit_names" class="names form-control">
       </div>
       <div class="form-group mb-3">
        <label for="email">Email</label>
        <input type="email" id="edit_email" class="email form-control">
       </div>
       <div class="form-group mb-3">
        <label for="phone">Phone</label>
        <input type="text" id="edit_phone" class="phone form-control">
       </div>
       <div class="form-group mb-3">
        <label for="role">Role</label>
        <input type="text" id="edit_role" class="role form-control">
       </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary update_employee">Edit</button>
      </div>
    </div>
  </div>
</div>

<!-- end edit modal -->
<div class="modal fade" id="delete_employee" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Confirmation</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="delete_employee_id">
        <p>Are you sure you want to delete this data?</p>
    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger delete_employee_btn">Yes,Delete</button>
      </div>
    </div>
  </div>
</div>


<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <div id="success_message"></div>
            <div class="card">
                <div class="card-header">
                    <h5>
                        Employee Data
                        <a href="" data-bs-toggle="modal" data-bs-target="#add_employee" class="btn btn-success float-end">Add Employee</a>
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>names</th>
                                <th>email</th>
                                <th>phone</th>
                                <th>role</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                        </tbody>
                    </table>
                   

                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        fetchemployees();

        function fetchemployees(){
            $.ajax({
                type: "GET",
                url: "/fetch_employees",
                dataType: "json",
                success: function (response) {
                    $('tbody').html("")
                    $.each(response.employees, function (key, item) { 
                        
                        $('tbody').append('<tr>\
                                <td>'+item.id+'</td>\
                                <td>'+item.names+'</td>\
                                <td>'+item.email+'</td>\
                                <td>'+item.phone+'</td>\
                                <td>'+item.role+'</td>\
                                <td>\
                                    <button value="'+item.id+'" class="btn btn-primary edit_employee me-2 btn-sm">Edit</button>\
                                    <button value="'+item.id+'" class="btn btn-danger delete_employee me-2 btn-sm">Delete</button>\
                                </td>\
                            </tr>'

                        )
                         
                    });
                }
            });
        }
        $(document).on('click','.delete_employee', function () {
            var emp_id = $(this).val()
            $("#delete_employee_id").val(emp_id)
            $("#delete_employee").modal('show')  
        });
        $(document).on('click','.delete_employee_btn', function () {
            var id = $("#delete_employee_id").val();
             $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "DELETE",
                url: "/delete-employee/"+id,
                success: function (response) {
                     $("#success_message").addClass("alert alert-success")
                         $("#success_message").text(response.message);
                         $("#delete_employee").modal('hide')
                         fetchemployees();
                    
                    
                }
            });
            
        });
        $(document).on('click','.edit_employee', function () {
            $("#edit_employee").modal('show')
            var emp_id = $(this).val()
            $.ajax({
                type: "GET",
                url: "/edit_employee/"+emp_id,
                success: function (response) {
                    if(response.status == 200){
                        $("#edit_names").val(response.employee.names)
                        $("#edit_email").val(response.employee.email)
                        $("#edit_phone").val(response.employee.phone)
                        $("#edit_role").val(response.employee.role)
                        $("#employee_id").val(response.employee.id)
                    } 
                }
            });
            
            
        });
        $(document).one('click','.update_employee', function (e) {
            e.preventDefault()
            var emp_id = $("#employee_id").val();
            var data = {
                'name':$("#edit_names").val(),
                'email':$("#edit_email").val(),
                'phone':$("#edit_phone").val(),
                'role':$("#edit_role").val()
            }
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "PUT",
                url: "/update_employee/"+emp_id,
                data: data,
                dataType: "json",
                success: function (response) {
                    if(response.status == 200){
                        $("#success_message").addClass("alert alert-success")
                         $("#success_message").text(response.message);
                         $("#edit_employee").modal('hide')
                         fetchemployees();

                    }
                    else if(response.status == 400){
                        $("#edit_error_list").html("")
                        $("#edit_error_list").addClass("alert alert-danger")

                        $.each(response.errors, function (key, err_values) { 
                            $("#edit_error_list").append('<li>'+err_values+"</li>")
                             
                        });

                    }
                }
            });

            
        });
        $(document).on('click','.add_employee',function(e){
            e.preventDefault();
            var data = {
                'name':$(".names").val(),
                'email':$(".email").val(),
                'phone':$(".phone").val(),
                'role':$(".role").val()
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });



            $.ajax({
                type: "POST",
                url: "/employees",
                data: data,
                dataType: "json",
                success: function (response) {
                    if(response.status == 400){
                        $("#error_list").html("")
                        $("#error_list").addClass("alert alert-danger")

                        $.each(response.errors, function (key, err_values) { 
                            $("#error_list").append('<li>'+err_values+"</li>")
                             
                        });

                    }
                    else{
                        $("#error_list").html("")
                        $("#success_message").addClass("alert alert-success")
                        $("#success_message").text(response.message);
                        $("#add_employee").modal('hide')
                        $("#add_employee").find('input').val();
                        fetchemployees()
                        


                    }
                    
                }
            });
        })
    });
</script>




@endsection