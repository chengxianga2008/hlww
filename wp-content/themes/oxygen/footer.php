<?php
/**
 *	Oxygen WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

	global $theme_version;
?>
		
		<?php if( ! defined("NO_HEADER_MENU")): ?>
		</div>
		<?php endif; ?>

		<?php if( ! defined("NO_FOOTER_MENU")): ?>

			<?php get_template_part('tpls/footer-main'); ?>

		<?php endif; ?>

	</div>

	<?php wp_footer(); ?>
	
	<script type="text/javascript">
	
	// changed by jack
	jQuery(document).ready(function($){
		
		$('#matrix_form > input').addClass('btn');
		$('.summary form .variation_form_section select').addClass('button');
	       
		$('.btn-single').trigger("click");

		
		var ele_arr = $('#matrix_form_table td .qty_input');

	        ele_arr.each(function(){

	                var id_str = $(this).attr("id");
	                var id_str_arr = id_str.split("_");
	                var id = parseInt(id_str_arr[id_str_arr.length-1]);


			var qty_value_str = "#qty_input_"+ id +"_info";
			var qty_value = $(qty_value_str).find(".summary .stock").text();
			var qty_value_arr = qty_value.split(" ");
			var qty_number = parseInt(qty_value_arr[0]);

			if(isNaN(qty_number)){
				qty_number = "Sold";
			}
	 
			$(this).attr("placeholder", qty_number);
	        	
	        });
		
	if($('.tabs .size_guide_tab a').tab){
		$('.tabs .size_guide_tab a').tab('show');
	}

	if($('.offers .variation_form_section a').offers){
	     $('.offers .variation_form_section a').offers('show');
	}

	$('[data-toggle="tooltip"]').tooltip(); 

	});
	</script>
	
	<!-- <?php echo 'ET: ', microtime( true ) - STIME, 's ', $theme_version, ( is_child_theme() ? 'ch' : '' ); ?> -->

</body>
</html>