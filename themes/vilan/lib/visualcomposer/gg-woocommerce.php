<?php

/*Recent products*/
vc_map( array(
   "name" => __('Recent products','okthemes'),
   "base" => "recent_products",
   "class" => "woocommerce",
   "icon" => "icon-wpb-gg_woo_icon",
   'admin_enqueue_css' => array(get_template_directory_uri().'/lib/visualcomposer/styles.css'),
   "category" => __('Woocommerce','okthemes'),
   "params" => array(
      array(
         "type" => "textfield",
         "admin_label" => true,
         "class" => "woocommerce",
         "heading" => __("Number of products to show","okthemes"),
         "param_name" => "per_page",
         "value" => '4',
         "description" => __("Insert the number of products to show. Default: 4","okthemes","okthemes")
      ),
      array(
         "type" => "textfield",
         "admin_label" => true,
         "class" => "woocommerce",
         "heading" => __("Columns","okthemes"),
         "param_name" => "columns",
         "value" => '4',
         "description" => __("Insert the number columns to show. Default: 4","okthemes","okthemes")
      )
    )
));

/*Featured products*/
vc_map( array(
   "name" => __("Featured products","okthemes"),
   "base" => "featured_products",
   "class" => "woocommerce",
   "icon" => "icon-wpb-gg_woo_icon",
   'admin_enqueue_css' => array(get_template_directory_uri().'/lib/visualcomposer/styles.css'),
   "category" => __('Woocommerce','okthemes'),
   "params" => array(
      array(
         "type" => "textfield",
         "admin_label" => true,
         "class" => "woocommerce",
         "heading" => __("Number of products to show","okthemes"),
         "param_name" => "per_page",
         "value" => '4',
         "description" => __("Insert the number of products to show. Default: 4","okthemes")
      ),
      array(
         "type" => "textfield",
         "admin_label" => true,
         "class" => "woocommerce",
         "heading" => __("Columns","okthemes"),
         "param_name" => "columns",
         "value" => '4',
         "description" => __("Insert the number columns to show. Default: 4","okthemes")
      )
    )
));

/*Product (by ID or SKU)*/
vc_map( array(
   "name" => __("Product","okthemes"),
   "base" => "product",
   "class" => "woocommerce",
   "icon" => "icon-wpb-gg_woo_icon",
   'admin_enqueue_css' => array(get_template_directory_uri().'/lib/visualcomposer/styles.css'),
   "category" => __('Woocommerce','okthemes'),
   "params" => array(
      array(
         "type" => "textfield",
         "admin_label" => true,
         "class" => "woocommerce",
         "heading" => __("Product ID","okthemes"),
         "param_name" => "id",
         "value" => '',
         "description" => __("Insert the product ID. Note: If the product is not showing, make sure it is not set to Hidden in the Catalog Visibility.","okthemes")
        ),
      array(
         "type" => "textfield",
         "admin_label" => true,
         "class" => "woocommerce",
         "heading" => __("Product SKU","okthemes"),
         "param_name" => "sku",
         "value" => '',
         "description" => __("Insert the product SKU","okthemes")
        )
    )
));

/*Products (by ID or SKU)*/
vc_map( array(
   "name" => __("Products","okthemes"),
   "base" => "products",
   "class" => "woocommerce",
   "icon" => "icon-wpb-gg_woo_icon",
   'admin_enqueue_css' => array(get_template_directory_uri().'/lib/visualcomposer/styles.css'),
   "category" => __('Woocommerce','okthemes'),
   "params" => array(
      array(
         "type" => "textfield",
         "admin_label" => true,
         "class" => "woocommerce",
         "heading" => __("Product IDs","okthemes"),
         "param_name" => "ids",
         "value" => '',
         "description" => __("Insert the product IDs, separated by commas.","okthemes")
      ),
      array(
         "type" => "textfield",
         "admin_label" => true,
         "class" => "woocommerce",
         "heading" => __("Product SKUs","okthemes"),
         "param_name" => "skus",
         "value" => '',
         "description" => __("Insert the product SKUs, separated by commas.","okthemes")
      ),
      array(
         "type" => "textfield",
         "admin_label" => true,
         "class" => "woocommerce",
         "heading" => __("Columns","okthemes"),
         "param_name" => "columns",
         "value" => '4',
         "description" => __("Insert the number columns to show. Default: 4","okthemes")
      )
    )
));

/*Add to cart*/
vc_map( array(
   "name" => __("Add to cart","okthemes"),
   "base" => "add_to_cart",
   "class" => "woocommerce",
   "icon" => "icon-wpb-gg_woo_icon",
   'admin_enqueue_css' => array(get_template_directory_uri().'/lib/visualcomposer/styles.css'),
   "category" => __('Woocommerce','okthemes'),
   "params" => array(
      array(
         "type" => "textfield",
         "admin_label" => true,
         "class" => "woocommerce",
         "heading" => __("Product ID","okthemes"),
         "param_name" => "id",
         "value" => '',
         "description" => __("Insert the product ID. Note: If the product is not showing, make sure it is not set to Hidden in the Catalog Visibility.","okthemes")
        ),
      array(
         "type" => "textfield",
         "admin_label" => true,
         "class" => "woocommerce",
         "heading" => __("Product SKU","okthemes"),
         "param_name" => "sku",
         "value" => '',
         "description" => __("Insert the product SKU.","okthemes")
        )
    )
));

/*Product page*/
vc_map( array(
   "name" => __("Product page","okthemes"),
   "base" => "product_page",
   "class" => "woocommerce",
   "icon" => "icon-wpb-gg_woo_icon",
   'admin_enqueue_css' => array(get_template_directory_uri().'/lib/visualcomposer/styles.css'),
   "category" => __('Woocommerce','okthemes'),
   "params" => array(
      array(
         "type" => "textfield",
         "admin_label" => true,
         "class" => "woocommerce",
         "heading" => __("Product ID","okthemes"),
         "param_name" => "id",
         "value" => '',
         "description" => __("Insert the product ID. Note: If the product is not showing, make sure it is not set to Hidden in the Catalog Visibility.","okthemes")
        ),
      array(
         "type" => "textfield",
         "admin_label" => true,
         "class" => "woocommerce",
         "heading" => __("Product SKU","okthemes"),
         "param_name" => "sku",
         "value" => '',
         "description" => __("Insert the product SKU.","okthemes")
        )
    )
));

/*Product category*/
vc_map( array(
   "name" => __("Product category","okthemes"),
   "base" => "product_category",
   "class" => "woocommerce",
   "icon" => "icon-wpb-gg_woo_icon",
   'admin_enqueue_css' => array(get_template_directory_uri().'/lib/visualcomposer/styles.css'),
   "category" => __('Woocommerce','okthemes'),
   "params" => array(
      array(
         "type" => "textfield",
         "class" => "woocommerce",
         "heading" => __("Category slug","okthemes"),
         "param_name" => "category",
         "value" => '',
         "description" => __("Insert the category slug.","okthemes")
      ),
      array(
         "type" => "textfield",
         "admin_label" => true,
         "class" => "woocommerce",
         "heading" => __("Number of products to show","okthemes"),
         "param_name" => "per_page",
         "value" => '4',
         "description" => __("Insert the number of products to show. Default: 4","okthemes")
      ),
      array(
         "type" => "textfield",
         "admin_label" => true,
         "class" => "woocommerce",
         "heading" => __("Columns","okthemes"),
         "param_name" => "columns",
         "value" => '4',
         "description" => __("Insert the number columns to show. Default: 4","okthemes")
      )
    )
));

/*Product Categories*/
vc_map( array(
   "name" => __("Product Categories","okthemes"),
   "base" => "product_categories",
   "class" => "woocommerce",
   "icon" => "icon-wpb-gg_woo_icon",
   'admin_enqueue_css' => array(get_template_directory_uri().'/lib/visualcomposer/styles.css'),
   "category" => __('Woocommerce','okthemes'),
   "params" => array(
      array(
         "type" => "textfield",
         "admin_label" => true,
         "class" => "woocommerce",
         "heading" => __("Number of products to show","okthemes"),
         "param_name" => "number",
         "value" => '4',
         "description" => __("Insert the number of products to show. Default: 4","okthemes")
      ),
      array(
         "type" => "textfield",
         "class" => "woocommerce",
         "heading" => __("Categories IDs","okthemes"),
         "param_name" => "ids",
         "value" => '',
         "description" => __("Insert the categories IDs, separated by commas.","okthemes")
      ),
      array(
         "type" => "textfield",
         "admin_label" => true,
         "class" => "woocommerce",
         "heading" => __("Columns","okthemes"),
         "param_name" => "columns",
         "value" => '4',
         "description" => __("Insert the number columns to show. Default: 4","okthemes")
      )
    )
));

/*Sale products*/
vc_map( array(
   "name" => __("Sale products","okthemes"),
   "base" => "sale_products",
   "class" => "woocommerce",
   "icon" => "icon-wpb-gg_woo_icon",
   'admin_enqueue_css' => array(get_template_directory_uri().'/lib/visualcomposer/styles.css'),
   "category" => __('Woocommerce','okthemes'),
   "params" => array(
      array(
         "type" => "textfield",
         "admin_label" => true,
         "class" => "woocommerce",
         "heading" => __("Number of products to show","okthemes"),
         "param_name" => "per_page",
         "value" => '4',
         "description" => __("Insert the number of products to show. Default: 4","okthemes")
      ),
      array(
         "type" => "textfield",
         "admin_label" => true,
         "class" => "woocommerce",
         "heading" => __("Columns","okthemes"),
         "param_name" => "columns",
         "value" => '4',
         "description" => __("Insert the number columns to show. Default: 4","okthemes")
      )
    )
));

/*Best selling products*/
vc_map( array(
   "name" => __("Best selling products","okthemes"),
   "base" => "best_selling_products",
   "class" => "woocommerce",
   "icon" => "icon-wpb-gg_woo_icon",
   'admin_enqueue_css' => array(get_template_directory_uri().'/lib/visualcomposer/styles.css'),
   "category" => __('Woocommerce','okthemes'),
   "params" => array(
      array(
         "type" => "textfield",
         "admin_label" => true,
         "class" => "woocommerce",
         "heading" => __("Number of products to show","okthemes"),
         "param_name" => "per_page",
         "value" => '4',
         "description" => __("Insert the number of products to show. Default: 4","okthemes")
      ),
      array(
         "type" => "textfield",
         "admin_label" => true,
         "class" => "woocommerce",
         "heading" => __("Columns","okthemes"),
         "param_name" => "columns",
         "value" => '4',
         "description" => __("Insert the number columns to show. Default: 4","okthemes")
      )
   )
));

/*Top rated products*/
vc_map( array(
   "name" => __("Top rated products","okthemes"),
   "base" => "top_rated_products",
   "class" => "woocommerce",
   "icon" => "icon-wpb-gg_woo_icon",
   'admin_enqueue_css' => array(get_template_directory_uri().'/lib/visualcomposer/styles.css'),
   "category" => __('Woocommerce','okthemes'),
   "params" => array(
      array(
         "type" => "textfield",
         "admin_label" => true,
         "class" => "woocommerce",
         "heading" => __("Number of products to show","okthemes"),
         "param_name" => "per_page",
         "value" => '4',
         "description" => __("Insert the number of products to show. Default: 4","okthemes")
      ),
      array(
         "type" => "textfield",
         "admin_label" => true,
         "class" => "woocommerce",
         "heading" => __("Columns","okthemes"),
         "param_name" => "columns",
         "value" => '4',
         "description" => __("Insert the number columns to show. Default: 4","okthemes")
      )
   )
));


?>