<form role="search" method="get" action="<?php echo home_url(); ?>">
	<div class="input-group">
	    <input type="text" class="form-control" autocomplete="off" placeholder="Search" value="<?php the_search_query(); ?>" name="s" id="search">
	    <span class="input-group-btn">
	        <button class="btn btn-danger" type="submit"><i class="icon-search"></i></button>
	    </span>
	</div>
</form>