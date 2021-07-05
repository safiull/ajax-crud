<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" />
    <title>Document</title>
</head>
<body>
    
    <section class="container py-5">
        <div class="row">
            <div class="col-6 border">
                <h5 class="text-center bg-primary text-light py-3">Student</h5>
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">name</th>
                        <th scope="col">roll</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody id="student_data_body">
                     {{-- <tr>
                         <td>bokul</td>
                         <td>4444</td>
                         <td>
                             <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                             <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                         </td>
                     </tr> --}}
                     
                    </tbody>
                  </table>




            {{-- EDIT MODAL --}}
            <div class="modal fade" id="editModal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                <form action="#" id="editForm">
                    <div class="modal-body">
                        <input type="text" name="name" placeholder="name" id="edit_show_name">
                        <input type="text" name="roll" placeholder="number" id="edit_show_roll">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onClick="updateData()">Understood</button>
                    </div>
                </form>
                </div>
                </div>
            </div>












            </div>
            <div class="col-6">
                <div class="card pb-5 px-5">
                    <h5 class="text-center bg-primary text-light py-3">Add student</h5>
                    <form id="addForm2" method="post">
                        {{-- @csrf --}}
                        <input type="text" name="name" placeholder="name" class="form-control my-2">
                        <span class="text-danger" id="nameError"></span>
                        <input type="text" name="roll" placeholder="roll" class="form-control my-2">
                        <span class="text-danger" id="rollError"></span>
                        <div>
                            <button type="submit" class="btn btn-primary">add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

     <!-----for Ajax handeling----->
     <script type="text/javascript">
        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
    <!-----for Ajax handeling----->

    

    // GET DATA
    function getData(){
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url : "{{ url('/student/show') }}",
            success: function(response){
                var data = ""
                $.each(response, function(key, value){
                    data = data + "<tr>"
                    data = data + "<td>" + value.name + "</td>"
                    data = data + "<td>" + value.roll + "</td>"
                    data = data + "<td>"
                    data = data + "<a class='btn btn-primary editButton m-1' onClick='editData("+value.id+")'>Edit</a>"
                    data = data + "<a  class='btn btn-danger m-1'>Delete</a>"
                    data = data + "</td>"
                    data = data + "</tr>"
                })
                $('#student_data_body').html(data)
            }
        });
    }
    getData();


    // SUBMIT DATA
    $("#addForm2").on("submit", function(e) {
        e.preventDefault();

        function cleanErrors(){
            $('#nameError').text('');
            $('#rollError').text('');
        }

        $.ajax({
            url: "{{url('/student/store')}}",
            data: new FormData(this),
            type: "POST",
            contentType: false,
            cache: false,
            processData: false,
            dataType: "JSON",
            success: function(data) {
                $('#addForm2')[0].reset();
                cleanErrors();
                getData();
                toastr.success('Successfully data inserted !', 'success', {
                    timeOut: 3000
                });
            },
            beforeSend: function() {
                cleanErrors();
            },
            error : function(error){
                $('#nameError').text(error.responseJSON.errors.name);
                $('#rollError').text(error.responseJSON.errors.roll);
            }

            

        });
    });



    function editData(id){

        $('#editModal').modal('show');
        $.ajax({
            type: "GET",
            dataType: "JSON",
            url: "{{ url('/student/edit') }}/"+id,
            success: function(data){
                $('#edit_show_name').val(data.name);
                $('#edit_show_roll').val(data.roll);
                $('#editModal').attr('data_id', data.id);

            }
        })
    }


    // UPDATE DATA


    






    function updateData() {
        var id = $('#editModal').attr('data_id');
        var name = $('#edit_show_name').val();
        var roll = $('#edit_show_roll').val();

        var data_all = Object.assign({},{'name': $.trim(name), 'roll': $.trim(roll), 'id': id });

        $.ajax({
            url: "/student/update/"+id,
            data: data_all,
            type: "POST",
            dataType: "JSON",
            beforeSend : function(data){
                console.log(data);
            },
            success: function(data){
                console.log(data);
            }
        })
    }

       


    </script>
</body>
</html>