<?php
/*
 * Created on Tue July 23 2020
 * @author: Deepika
 * Details: index page
 */

include 'db.php';
?>
 <!DOCTYPE html>
 <html>
      <head>
         <!--Load external jquery, bootstarp, datatables libraries-->
           <title>Github PHP Repositories Details with Datatables Jquery Php MySql and Bootstrap</title>
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
           <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
           <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
           <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
           <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
           <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
           <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
           <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
           <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
           <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
           <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
           <style>
                      table.fixed {table-layout:fixed; width:1300px;}/*Setting the table width is important!*/
                      table.fixed td {overflow:hidden;}/*Hide text outside the cell.*/
                      td.details-control {
                         background: url('resources/details_open.png') no-repeat center center;
                         cursor: pointer;
                          }
                      tr.shown td.details-control {
                         background: url('resources/details_close.png') no-repeat center center;
                          }
                      .overlay{position: absolute;left: 0; top: 0; right: 0; bottom: 0;z-index: 2;background-color: rgba(255,255,255,0.8);}
                      .overlay-content {
                              position: absolute;
                              transform: translateY(-50%);
                               -webkit-transform: translateY(-50%);
                               -ms-transform: translateY(-50%);
                              top: 50%;
                              left: 0;
                              right: 0;
                              text-align: center;
                              color: #555;
                          }
          </style>
          <script>
          //show gif image
          function showLoading(){
            document.getElementById("loading").style = "visibility: visible";
          }
          //hide gif image
          function hideLoading(){
              document.getElementById("loading").style = "visibility: hidden";
          }
          var table = "";
          //fetch data from database and draw the Datatable
          function fetch_data()
          {
            $.ajax({
            url:"fetchdata.php",
            method:"POST",
            success:function(data){
              $('#tabledata').html(data);
               table = $('#repositories_data').DataTable(
                 {
                   dom: 'Bfrtip',
                   buttons: [
                     'copy', 'csv', 'excel', 'pdf', 'print'
                   ]
                 }
               );
             }
          })
         }
          $(document).ready(function(){
           //On page Load call fetch_data function to load the data into DataTable
           fetch_data();
         });
          //Event Listener to call Github api
          $(document).on('click', '#btn_add', function(){
            //call show loading function here
            showLoading();
            //Ajax call to get data from Github API and insert into Database
            $.ajax({
               url:"insertrepos.php",
               method:"POST",
               dataType:"json",
               success: function () {
                 //call hide function here
                 hideLoading();
                 alert("Data has been Uploaded: ");
                 fetch_data();
               },
               error  : function (a) {//if an error occurs
                 hideLoading();
                 alert("An error occured while uploading data.\n error code : "+a.statusText);
               }
           })
          });
          // Event listener for opening and closing details
          $(document).on('click', 'td.details-control', function () {
              var tr = $(this).closest('tr');
              var row = table.row( tr );
              var id = tr.find("td").eq(0).text();
              var outputdata = "";
              $.ajax({
                 url:"details.php",
                 method:"POST",
                 dataType:"json",
                 data:{repoid:id},
                 success:function(response)
                 {
                     for(var i = 0, len = response.length; i < len; i++) {
                      //outputdata+="<tr><td><a href='' onclick=window.open('"+response[i].childurl+"','win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=1076,height=768,directories=no,location=no');return false;>" + response[i].childurl + "</a></td></tr>";
                      outputdata+="<tr><td>Description: " + response[i].description + "</td></tr>";
                      outputdata+="<tr><td>Stars: " + response[i].stars + "</td></tr>";
                      outputdata+="<tr><td>Language: " + response[i].language + "</td></tr>";
                      outputdata+="<tr><td>Forks: " + response[i].forks + "</td></tr>";
                     }
                },
                async: false
             })

              if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                   // Open this row
                   row.child(outputdata).show();
                   tr.addClass('shown');
               }
          });
          </script>
      </head>
      <body>
           <br /><br />
           <div class="container">
               <div class="overlay" id='loading' style='visibility: hidden;'><div class="overlay-content"><img src="resources/ajax-loader.gif" alt="Loading..."/><br/><b>Uploading Content to Database</b></div></div>
                <h3 align="center">Github PHP Repositories Details</h3>
                <br />
                <td><button type="button" name="btn_add" id="btn_add" class="btn btn-success">Add Repositories</button>&nbsp;</td>
                <div class="table-responsive" id="tabledata">
                 <!--Data Table loads here-->
                </div>
           </div>
      </body>
 </html>
