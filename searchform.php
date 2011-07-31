<form action="/" method="get">
    <fieldset>
        <input type="text" name="s" id="search" value="<?php echo esc_html( stripslashes( get_search_query() ) ); ?>" />
		<input type="submit" id="searchsubmit" value="Search" />
    </fieldset>
</form>