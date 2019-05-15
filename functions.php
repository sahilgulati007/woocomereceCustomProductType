function redirect_checkout_add_cart( $url ) {
    $url = get_permalink( get_option( 'woocommerce_checkout_page_id' ) );
    return $url;
}

add_filter( 'woocommerce_add_to_cart_redirect', 'redirect_checkout_add_cart' );

add_filter( 'woocommerce_product_add_to_cart_text', 'woo_custom_product_add_to_cart_text' );

function woo_custom_product_add_to_cart_text() {

    return __( 'Buy Now', 'woocommerce' );

}

//add_action( 'init', 'bbloomer_hide_price_add_cart_not_logged_in' );

//create a catalog show website using woocommerce
//function bbloomer_hide_price_add_cart_not_logged_in() {
////    if ( !is_user_logged_in() ) {
//        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
//        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
//        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
//        remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
////    }
//}


    //Adding new product type
add_action( 'init', 'register_custom_product_type' );

function register_custom_product_type() {

    class WC_Product_Custom extends WC_Product {

        public function __construct( $product ) {
            $this->product_type = 'custom';
            parent::__construct( $product );
        }

    }
}

add_filter( 'product_type_selector', 'add_custom_product_type' );

function add_custom_product_type( $types ){
    $types[ 'custom' ] = __( 'Custom product', 'cu_product' );

    return $types;
}

add_filter( 'woocommerce_product_data_tabs', 'custom_product_tab' );

function custom_product_tab( $tabs) {

    $tabs['custom'] = array(
        'label'    => __( 'Custom Product', 'cu_product' ),
        'target' => 'custom_product_options',
        'class'  => 'show_if_custom_product',
    );
    return $tabs;
}


add_action( 'woocommerce_product_data_panels', 'custom_product_tab_product_tab_content' );

function custom_product_tab_product_tab_content() {

    ?><div id='custom_product_options' class='panel woocommerce_options_panel'><?php
    ?><div class='options_group'><?php

    woocommerce_wp_text_input(
        array(
            'id' => 'custom_product_info',
            'label' => __( 'Custom Product Spec', 'cu_product' ),
            'placeholder' => '',
            'desc_tip' => 'true',
            'description' => __( 'Enter Custom product Info.', 'cu_product' ),
            'type' => 'text'
        )
    );
    ?></div>
    </div><?php
}

add_action( 'woocommerce_process_product_meta', 'save_custom_product_settings' );

function save_custom_product_settings( $post_id ){

    $custom_product_info = $_POST['custom_product_info'];

    if( !empty( $custom_product_info ) ) {

        update_post_meta( $post_id, 'custom_product_info', esc_attr( $custom_product_info ) );
    }
}

add_action( 'woocommerce_single_product_summary', 'custom_product_front' );

function custom_product_front () {
    global $product;

    if ( 'custom' == $product->get_type() ) {
        echo( get_post_meta( $product->get_id(), 'custom_product_info' )[0] );

    }
}

//test
add_action( 'init', 'register_sahil_product_type' );

function register_sahil_product_type() {

    class WC_Product_sahil extends WC_Product {

        public function __construct( $product ) {
            $this->product_type = 'sahil';
            parent::__construct( $product );
        }
    }

}

add_filter( 'product_type_selector', 'add_sahil_product_type' );

function add_sahil_product_type( $types ){
    $types[ 'sahil' ] = __( 'sahil product', 'sg_product' );

    return $types;
}

add_filter( 'woocommerce_product_data_tabs', 'sahil_product_tab' );

function sahil_product_tab( $tabs) {

    $tabs['sahil'] = array(
        'label'    => __( 'sahil Product', 'sg_product' ),
        'target' => 'sahil_product_options',
        'class'  => 'show_if_sahil_product',
    );
    return $tabs;
}

add_action( 'woocommerce_product_data_panels', 'sahil_product_tab_product_tab_content' );

function sahil_product_tab_product_tab_content() {

    ?><div id='sahil_product_options' class='panel woocommerce_options_panel'><?php
    ?><div class='options_group'><?php
    global $post;

    woocommerce_wp_text_input(
        array(
            'id' => 'sahil_product_info',
            'label' => __( 'sahil Product Spec', 'sg_product' ),
            'placeholder' => '',
            'desc_tip' => 'true',
            'description' => __( 'Enter sahil product Info.', 'sg_product' ),
            'type' => 'text'
        )
    );
    woocommerce_wp_text_input(
        array(
            'id' => 'sahil_product_info1',
            'label' => __( 'sahil Product Spec2', 'sg_product' ),
            'placeholder' => '',
            'desc_tip' => 'true',
            'description' => __( 'Enter sahil product Info.', 'sg_product' ),
            'type' => 'text'
        )
    );
    woocommerce_wp_select( array(
        'id'      => 'sahil_select',
        'label'   => __( 'My Select Field', 'woocommerce' ),
        'options' => ['test'=>'test','car'=>'car','bike'=>'bike','cycle'=>'cycle'], //this is where I am having trouble
        'value'   =>  get_post_meta( $post->ID, 'sahil_select', true ),
    ) );

    ?></div>
    </div><?php
    ?>
    <script type='text/javascript'>
        jQuery(document).ready(function () {
            //for Price tab
            jQuery('.product_data_tabs .general_tab').addClass('show_if_sahil_product').show();
            jQuery('#general_product_data .pricing').addClass('show_if_sahil_product').show();
            //for Inventory tab
            jQuery('.inventory_options').addClass('show_if_variable_bulk').show();
            jQuery('#inventory_product_data ._manage_stock_field').addClass('show_if_sahil_product').show();
            jQuery('#inventory_product_data ._sold_individually_field').parent().addClass('show_if_sahil_product').show();
            jQuery('#inventory_product_data ._sold_individually_field').addClass('show_if_sahil_product').show();
        });
    </script>
    <?php
}

add_action( 'woocommerce_process_product_meta', 'save_sahil_product_settings' );

function save_sahil_product_settings( $post_id ){

    $sahil_product_info = $_POST['sahil_product_info'];

    if( !empty( $sahil_product_info ) ) {

        update_post_meta( $post_id, 'sahil_product_info', esc_attr( $sahil_product_info ) );
    }
    $sahil_product_info = $_POST['sahil_product_info1'];

    if( !empty( $sahil_product_info ) ) {

        update_post_meta( $post_id, 'sahil_product_info1', esc_attr( $sahil_product_info ) );
    }
    $sahil_product_info = $_POST['sahil_select'];

    if( !empty( $sahil_product_info ) ) {

        update_post_meta( $post_id, 'sahil_select', esc_attr( $sahil_product_info ) );
    }
}

add_action( 'woocommerce_single_product_summary', 'sahil_product_front' );

function sahil_product_front () {
    global $product;

    if ( 'sahil' == $product->get_type() ) {
        echo( get_post_meta( $product->get_id(), 'sahil_product_info' )[0] );
        echo "<br>";
        echo( get_post_meta( $product->get_id(), 'sahil_product_info1' )[0] );
        echo "<br>";
        echo( get_post_meta( $product->get_id(), 'sahil_select' )[0] );

    }
}
