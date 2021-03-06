<?php $__env->startSection('content'); ?>
<table id="data-table-contact" class="table table-striped">
	<thead>
	    <tr>
	        <th>Name</th>
	        <th>Email</th>
	        <th>Phone</th>
			<!-- <th>DOB</th>
			<th>salary</th> -->
	        <th>Options</th>	        
	    </tr>
	</thead>
	<tfoot>
	    <tr>
	        <th>Name</th>
	        <th>Email</th>
	        <th>Phone</th>
			<!-- <th>DOB</th>
			<th>Salary</th> -->
	        <th>Options</th>
	    </tr>
	</tfoot>
</table>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-js'); ?>
<script>
	$(document).ready(function(){
		$('input[name="phone"]').mask('(000) 000-0000');

		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});		
		
		var dataTableContacts = $('#data-table-contact').DataTable( {			
			"ordering": false,
			searching: false,
			"processing": true,
        	"serverSide": true,
	        "ajax": {
	        	url: "<?php echo e(route('contacts.index')); ?>",
	        	"data" : function(d){
	        		 var info = $('#data-table-contact').DataTable().page.info();        		 
	        		 d.page = ( info.page + 1 );
	        	}
	        },
	        "columns": [
	            { 
	            	"data": function(data){
	            		return data.first_name + ' ' + data.last_name;
	            	}
	            },
	            { "data": "email" },
	            { "data": "phone" },
				// { "data": "dob" },
				// { "data": "salary" },
	            { 
	            	"data": function(data){	            		
	            		return '<button type="button" class="btn btn-primary btn-xs btn-edit" data-id="'+data.id+'">Edit</button> <button type="button" class="btn btn-danger btn-xs btn-delete" data-id="'+data.id+'">Delete</button>';
	            	} 
	            }	            
	        ],
	        "columnDefs": [{
                "targets": 'no-sort',
                "orderable": false
            }]
	    } );

	    $(document).on('click', '#btn-save-contact', function(){
			
			$("#form-create-contacts").modal('show');

	    	$('.text-danger').remove();
	    	var createForm = $("#form-create-contact");    	
	    	ajaxRequest(
	    		"<?php echo e(route('contacts.store')); ?>",
	    		'POST',
	    		createForm.serializeArray(),
	    		function(response){
	    			if(response.errors) {	    				
	    				$.each(response.errors, function (elem, messages) {
	    					createForm.find('input[name="'+elem+'"]').after('<p class="text-danger">'+messages.join('')+'</p>');
	    				});	    				
	    			} else {
	    				dataTableContacts.ajax.reload();
	    				$("#form-create-contact").trigger("reset");
	    				$("#modal-create-contact").modal('hide');
						// $("#modal-create").modal('show');
	    			}
	    	});
	    });

    	$(document).on('click', '.btn-edit', function(e){    		
    		e.preventDefault();    		
    		var url = "<?php echo e(route('contacts.edit', ':id')); ?>";
    		url = url.replace(':id', $(this).attr('data-id'));
    		ajaxRequest(url, 'GET', [], function(response){
    			if( response.data ){    		    			
    				var editForm = $('#form-edit-contact');    				
    				editForm.find('input[name="first_name"]').val(response.data.first_name);
    				editForm.find('input[name="last_name"]').val(response.data.last_name);
    				editForm.find('input[name="phone"]').val(response.data.phone);
					editForm.find('input[name="email"]').val(response.data.email);  
					// editForm.find('input[name="dob"]').val(response.data.dob);
    				// editForm.find('input[name="salary"]').val(response.data.salary);  
    				$("#contact_id").val(response.data.id);  
    				$("#modal-edit-contact").modal('show');
    			}
    		});
    	});

    	$(document).on('click', '#btn-update-contact', function(e){ 
    		var url = "<?php echo e(route('contacts.update', ':id')); ?>";
    		url = url.replace(':id', $("#contact_id").val()); 
    		var editForm = $("#form-edit-contact");    	
    		ajaxRequest(
	    		url,
	    		'PUT',
	    		editForm.serializeArray(),
	    		function(response){
	    			if(response.errors) {
	    				$.each(response.errors, function (elem, messages) {
	    					editForm.find('input[name="'+elem+'"]').after('<p class="text-danger">'+messages.join('')+'</p>');
	    				});
	    			} else {
	    				dataTableContacts.ajax.reload();
	    				$("#form-edit-contact").trigger("reset");
	    				$("#modal-edit-contact").modal('hide');
	    			}
	    	});	
    	});	
    	
    	$(document).on('click', '.btn-delete', function(e){ 
    		var url = "<?php echo e(route('contacts.destroy', ':id')); ?>";
    		url = url.replace(':id', $(this).attr('data-id')); 
			swal({
				title: "Are you sure you want delete this contact?",				
				icon: "warning",
				buttons: true,
				dangerMode: true,
				buttons: ["No", "Yes"]				
			})
			.then((willDelete) => {
				if (willDelete) {
					ajaxRequest(
			    		url,
			    		'DELETE',
			    		[],
			    		function(response){
			    			dataTableContacts.ajax.reload();
	    				});
				} 
			});
    	});	

    	$('#modal-create-contact').on('hidden.bs.modal', function (e) {
		  	$("#form-create-contact").trigger("reset");
		});

// $('#btn-save-contact').click(function(){
// 	$('#modal-create').toggle();

// })

$('#modal-edit-contact').on('hidden.bs.modal', function (e) {
		  	$("#form-edit-contact").trigger("reset");
		});
    	
	});

	function ajaxRequest(url, type, data, successFunction){
		$.ajax({
    		url: url,
    		method: type,
    		data: data,
    		success: successFunction
    	});
	}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\mysql\htdocs\laravel-ajax\laravel-ajax\resources\views/contacts/index.blade.php ENDPATH**/ ?>