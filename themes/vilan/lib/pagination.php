<?php 
global $paginated_query;
global $wp_query;
 
     if ( !$paginated_query ):
      $paginated_query = $wp_query;
     endif;
 
     if ( $paginated_query->max_num_pages > 1 ) : ?>
          <div class="pagination">
              <?php if ( !$current_page = get_query_var('paged') ) :
                  $current_page = 1;
              endif;
 
              echo paginate_links(array(
                  'base' => get_pagenum_link(1) . '%_%',
                  'current' => $current_page,
                  'total' => $wp_query->max_num_pages   
              )); ?>
          </div>
          <?php
     endif;
?>