

<html>
<head>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

</head>

<body>



<div class="container">
    <br/>

            <div align="right" style="margin-bottom: 5px;">
                <button type="button" name="add" id="add" class="btn btn-success btn-xs">Add</button>
            </div>

    <div align="left">
        <input type="text" name="search" id="search" placeholder="Search here" class="form-control">
    </div>

    <div id="user_search" class="table-responsive"
</div>

            <div id="user_data" class="table-responsive"
        </div>

        <div id="user_dialog" title="Add Data">
            <form method="post" id="user_form">
                <div class="form-group">
                    <label>Enter Name</label>
                    <input type="text" name="user_name" id="user_name" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Enter Message</label>
                    <input type="text" name="message" id="message" class="form-control"/>
                </div>
                <div class="form-group">
                    <input type="hidden" name="action" id="action" value="insert" />
                    <input type="file" name="file" id="file" />
                    <input type="hidden" name="hidden_id" id="hidden_id">
                    <input type="submit" name="form_action" id="form_action" class="btn btn-info" value="Insert" />
                </div>
            </form>
        </div>
        <div id="action_alert" title="Action">

        </div>

        <div id="delete_confirmation" title="confirmation">
            <p>Are you sure ?</p>
        </div>


</body>
</html>

<script>


    $(document).ready(function(){

        load_data();

      function load_data()
      {
          $.ajax({
              url:"ajax.php",
              method:"POST",
              success:function (data) {
                  $('#user_data').html(data);

              }
          })
      }
      $('#user_dialog').dialog({
          autoOpen:false,
          width:400
      });
       $('#add').click(function(){
           $('#user_dialog').attr('title', 'Add Data');
           $('#action').val('insert');
           $('#form_action').val('Insert');
           $('#user_form')[0].reset();
           $('#form_action').attr('disable',false);
           $('#user_dialog').dialog('open');
       });

       $('#user_form').on('submit', function (event) {
           event.preventDefault();
           $('#form_action').attr('disable','disable');
           //var form_data = $(this).serialize();
           $.ajax({
               url:"action.php",
               method:"POST",
               data: new FormData($('#user_form')[0]),
               processData:false,
               contentType:false,
               success: function (data) {
                   $('#user_dialog').dialog('close');
                   $('#action_alert').html(data);
                   $('#action_alert').dialog('open');
                   load_data();


               }
           });
           $('#action_alert').dialog({
               autoOpen:false
           });


       });

       $(document).on('click', '.edit', function () {
           var id = $(this).attr("id");
           var action = 'fetch_single';
           $.ajax({
             url:"action.php",
             method:"POST",
             data:{user_id:id , action:action},
             dataType:"json",
             success:function(data){
                 $('#user_name').val(data.user_name);
                 $('#message').val(data.message);
                 $('#user_dialog').attr('title', 'Edit Data');
                 $('#action').val('update');
                 $('#hidden_id').val(id);
                 $('#form_action').val('Update');
                 $('#user_dialog').dialog('open');
             }
           });
       });
       $('#delete_confirmation').dialog({
           autoOpen:false,
           modal:true,
           buttons:{
               Ok :function () {
                   var id = $(this).data("id");
                   var action = 'delete';
                   $.ajax({
                       url:"action.php",
                       method:"POST",
                       data:{user_id:id, action:action},
                       success:function (data) {
                           $('#delete_confirmation').dialog('close');
                           $('#action_alert').html(data);
                           $('#action_alert').dialog('open');
                           load_data();
                       }
                   });
               },
               Cancel:function () {
                   $(this).dialog('close');

               }
           }
       });

        $(document).on('click', '.delete', function () {
            var id = $(this).attr("id");
            $('#delete_confirmation').data('id', id).dialog('open');
        });

        $('#search').keyup(function () {
            var txt = $(this).val();
            var action = 'search';
            $.ajax({
               url:"action.php",
               method:"POST",
               data:{search:txt,action:action},
                success:function (data) {
                    $('#user_search').html(data);
                }
            });
        })


    });

</script>

