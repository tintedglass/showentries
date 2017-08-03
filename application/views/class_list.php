
    <button class="btn btn-success" onclick="add_horse()"><i class="glyphicon glyphicon-plus"></i> Add Horse</button>

	<div id="reorder">
	 	<ul id="list-items">
		    <?php foreach($horses as $horse) { ?>

				<li id='item_<?php echo $horse['id']; ?>' class="clearfix"> 
					<div class="order pull-left"><?php echo $horse['display_order']; ?></div>
					<?php echo $horse['name']; ?> 
					<button class="btn btn-danger pull-right" onclick="delete_horse(<?php echo $horse['id']; ?>)">
						<i class="glyphicon glyphicon-trash"></i> Scratch
					</button>
					<button class="btn btn-success pull-right" onclick="edit_horse(<?php echo $horse['id']; ?>)">
						<i class="glyphicon glyphicon-plus"></i> Edit
					</button>
					<button class="btn btn-primary pull-right" onclick="view_details(<?php echo $horse['id']; ?>)">
						<i class="glyphicon glyphicon-list-alt"></i> View Details
					</button>
				</li>
				
			<?php } ?>
		</ul>
	</div>


	<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
	<script src="<?php echo base_url();?>scripts/reorder.js"></script>

	<script type="text/javascript">
		var save_method; //for save method string

		$(document).ready(function() 
		{
			//set input/textarea/select event when change value, remove class error and remove text help block 
		    $("input").change(function(){
		        $(this).parent().parent().removeClass('has-error');
		        $(this).next().empty();
		    });
		    $("textarea").change(function(){
		        $(this).parent().parent().removeClass('has-error');
		        $(this).next().empty();
		    });
		    $("select").change(function(){
		        $(this).parent().parent().removeClass('has-error');
		        $(this).next().empty();
		    });

		});

		function add_horse()
		{
		    save_method = 'add';
		    $('#form')[0].reset(); // reset form on modals
		    $('.form-group').removeClass('has-error'); // clear error class
		    $('.help-block').empty(); // clear error string
		    $('#modal_form').modal('show'); // show bootstrap modal
		    $('.modal-title').text('Add Horse'); // Set Title to Bootstrap modal title
		}

		function edit_horse(id)
		{
			save_method = 'update';
			$('#form')[0].reset(); // reset form on modals
    		$('.form-group').removeClass('has-error'); // clear error class
    		$('.help-block').empty(); // clear error string

		    //Ajax Load data from ajax
    		$.ajax({
		        url : "<?php echo site_url('horses/ajax_edit')?>/" + id,
		        type: "GET",
		        dataType: "JSON",
		        success: function(data)
		        {

		            $('[name="id"]').val(data.id);
		            $('[name="name"]').val(data.name);
		            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
		            $('.modal-title').text('Edit Horse'); // Set title to Bootstrap modal title

		        },
		        error: function (jqXHR, textStatus, errorThrown)
		        {
		            alert('Error get data from ajax');
		        }
		    });
		}

		function view_details(id)
		{
			$('#modal_details').modal('show');

			//Ajax Load data from ajax
    		$.ajax({
		        url : "<?php echo site_url('horses/ajax_edit')?>/" + id,
		        type: "GET",
		        dataType: "JSON",
		        success: function(data)
		        {
		            $('#modal_details').modal('show'); // show bootstrap modal when complete loaded
		            $('.modal-title').text(data.name); // Set title to Bootstrap modal title
		            $('#details_name').html(data.name);

		        },
		        error: function (jqXHR, textStatus, errorThrown)
		        {
		            alert(errorThrown);
		        }
		    });
		}

		function save()
		{
		    $('#btnSave').text('Saving...'); //change button text
		    $('#btnSave').attr('disabled',true); //set button disable 
		    
		    var url;

		    if(save_method == 'add') {
		        url = "<?php echo site_url('horses/ajax_add')?>";
		    } else {
		        url = "<?php echo site_url('horses/ajax_update')?>";
		    }

		    // ajax adding data to database
		    $.ajax({
		        url : url,
		        type: "POST",
		        data: $('#form').serialize(),
		        dataType: "JSON",
		        success: function(data)
		        {
					if(data.status) //if success close modal and reload ajax table
		            {
		                $('#modal_form').modal('hide');
		                location.reload();
		            }
		            else
		            {
		                for (var i = 0; i < data.inputerror.length; i++) 
		                {
		                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); 
		                    //select parent twice to select div form-group class and add has-error class
		                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); 
		                    //select span help-block class set text error string
		                }
		            }

			        $('#btnSave').text('save'); //change button text
			        $('#btnSave').attr('disabled',false); //set button enable 
			    },
			    error: function (jqXHR, textStatus, errorThrown)
			    {
			        alert('Error adding / update data');

			    }
		    });
		}

		function delete_horse(id)
		{
		    if(confirm('Are you sure delete this data?'))
		    {
		        // ajax delete data to database
		        $.ajax({
		            url : "<?php echo site_url('horses/ajax_delete')?>/"+id,
		            type: "POST",
		            dataType: "JSON",
		            success: function(data)
		            {
		                //if success reload ajax table
		                $('#modal_form').modal('hide');
		                location.reload();
		            },
		            error: function (jqXHR, textStatus, errorThrown)
		            {
		                alert('Error deleting data');
		            }
		        });

		    }
		}
	</script>

	<!-- Bootstrap modal -->
	<div class="modal fade" id="modal_form" role="dialog">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                <h3 class="modal-title">Form</h3>
	            </div>
	            <div class="modal-body form">
	                <form action="#" id="form" class="form-horizontal">
	                    <input type="hidden" value="" name="id"/> 
	                    <div class="form-body">
	                        <div class="form-group">
	                            <label class="control-label col-md-3">Name</label>
	                            <div class="col-md-9">
	                                <input name="name" placeholder="Name" class="form-control" type="text">
	                                <span class="help-block"></span>
	                            </div>
	                        </div>
	                    </div>
	                </form>
	            </div>
	            <div class="modal-footer">
	                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
	                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	            </div>
	        </div><!-- /.modal-content -->
	    </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<!-- End Bootstrap modal -->


	<!-- Bootstrap modal no form -->
	<div class="modal fade" id="modal_details" role="dialog">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                <h3 class="modal-title">View Details</h3>
	            </div>
	            <div class="modal-body">
	            	<table class="table table-hover table-sm">
	            	<tr><th scope="row" class="col-md-1"><b>Name:</b></th><td id="details_name"></td></tr>
	                </table>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	            </div>
	        </div><!-- /.modal-content -->
	    </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<!-- End Bootstrap modal -->
    


