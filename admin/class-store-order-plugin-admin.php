<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://touhidulit.com
 * @since      1.0.0
 *
 * @package    Store_Order_Plugin
 * @subpackage Store_Order_Plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Store_Order_Plugin
 * @subpackage Store_Order_Plugin/admin
 * @author     Touhidul <touhidulislam256@gmil.com>
 */
class Store_Order_Plugin_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Store_Order_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Store_Order_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/store-order-plugin-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Store_Order_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Store_Order_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/store-order-plugin-admin.js', array( 'jquery' ), $this->version, false );

	}
     
	    /**
	 	  * Send order to HUb 
		 */
	public function send_order_to_hub($order_id)
	{
		$order = wc_get_order($order_id);
		$order_status=$order->get_status();
		$billing_address['billing_first_name'] = $order->get_billing_first_name();
		$billing_address['billing_last_name'] = $order->get_billing_last_name();
		$billing_address['billing_email'] =$order->get_billing_email();
		$billing_address['billing_company'] =  $order->get_billing_company();
		$billing_address['billing_address_1']= $order->get_billing_address_1();
		$billing_address['billing_address_2']= $order->get_billing_address_2();
		$billing_address['billing_city'] = $order->get_billing_city();
		$billing_address['billing_state'] = $order->get_billing_state();
		$billing_address['billing_postcode'] = $order->get_billing_postcode();
		$billing_address['billing_country'] = $order->get_billing_country();
		$billing_address['billing_phone']= $order->get_billing_phone();
	
		$shipping_address['shipping_first_name']=  $order->get_shipping_first_name();
		$shipping_address['shipping_last_name']= $order->get_shipping_last_name();
		$shipping_address['shipping_company'] = $order->get_shipping_company();
		$shipping_address['shipping_address_1'] = $order->get_shipping_address_1();
		$shipping_address['shipping_address_2'] = $order->get_shipping_address_2();
		$shipping_address['shipping_city'] = $order->get_shipping_city();
		$shipping_address['shipping_state'] = $order->get_shipping_state();
		$shipping_address['shipping_postcode'] = $order->get_shipping_postcode();
		$shipping_address['shipping_country'] = $order->get_shipping_country(); 
	
	
		$products=[];
		foreach ( $order->get_items() as $item_id => $item ) {
			$single_product['product_id']= $item->get_product_id();
			$single_product['permalink']= get_permalink($single_product['product_id']);
			$single_product['product_name']= $item->get_name();
			$single_product['quantity']= $item->get_quantity();
			$single_product['subtotal']= $item->get_subtotal();
			$single_product['total']= $item->get_total();
			$single_product['tax']= $item->get_subtotal_tax();
			$single_product['tax_class']= $item->get_tax_class();
			$single_product['tax_status']= $item->get_tax_status();
			$single_product['item_type']= $item->get_type();
			$reguler_price=get_post_meta( $single_product['product_id'], '_regular_price', true );
		    $sale_price=get_post_meta( $single_product['product_id'], '_regular_price', true );
		
			$single_product['price'] = !empty($sale_price) ? $sale_price : $reguler_price;
			$single_product['image_url'] = get_the_post_thumbnail_url( $single_product['product_id'], 'thumbnail' );
			$single_product['sku'] = get_post_meta( $single_product['product_id'], '_sku', true );
			$products[]=$single_product;
			
		 }
		//  $order_notes=$order->get_order_notes();
		//  custom_dd($order_notes);
		//  $oder_note_content=[];
		//  $last_oder_notes=null;
		//  if(!empty($oder_notes) )
		//  {
		// 	foreach ( $order_notes as $note ) {
		// 		$oder_note_content[]=$note->content;
				
		// 	}
		// 	$last_oder_notes=$order_notes[0]->content;
		//  }
		//  custom_dd($oder_note_content);
		$order_notes_admin=wc_get_order_notes([
			'order_id' => $order_id,
			'orderby'  => 'date_created_gmt',
			'type'=>'internal'
			
		]);
		foreach($order_notes_admin as $note)
		{
			$order_note_content_admin[]=$note->content;
		}
	
		$note_by_customer=$order->get_customer_note();
	
		 $shop_name=get_option('shop_name');
		 $shop_url=get_option('shop_url');
		 $shop_secret=get_option('shop_secret');
		 
		 $order_date=$order->get_date_created()->format( 'Y-m-d');
		 $current_date = new DateTime($order_date);
		 $current_date->modify('+2 weeks');
		 $shipping_date = $current_date->format('Y-m-d');
		 
		 
	
		 $payload_data=[
			'shop_secret'=>$shop_secret,
			'shop_name'=>$shop_name,
			'shop_url'=>$shop_url,
			'order_id'=>$order_id,
			'order_name'=>$order_id.' '.$billing_address['billing_first_name'].' '.$billing_address['billing_last_name'].' '.$shop_name,
			'order_date'=> $order_date,
			'customer_email'=>$billing_address['billing_email'],
			'customer_name'=>$billing_address['billing_first_name'].' '.$billing_address['billing_last_name'],
			'customer_phone'=>$billing_address['billing_phone'],
			'order_date'=>$order_date,
			'order_note_content_admin'=>json_encode($order_note_content_admin),
			'shipping_date'=>$shipping_date,
			'note_by_customer'=>$note_by_customer,
			'billing_address'=>json_encode($billing_address),
			'shipping_address'=>json_encode($shipping_address),
			'products'=>json_encode($products),
			'order_status'=>$order_status,
			'currency_symbol'=>get_woocommerce_currency_symbol(),
			'currency_name'=>get_woocommerce_currency()
		 ];
         $curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => 'http://uptime-crew-wp.test/wp-json/hubstore/v1/create/order',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS =>json_encode($payload_data),
		CURLOPT_HTTPHEADER => array(
			'Accept: application/json',
			'Content-Type: application/json'
		),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$status_code=curl_getinfo($curl, CURLINFO_HTTP_CODE);
		if(empty($response))
		{
			$order_number1="The error is ".$response."Reload the page at customer end";
			$order->add_order_note( $order_number1 , true);
			error_log($response);
		}else
		{
			if($status_code == 201)
			{
				$order_number1=" your tracking number : ".json_decode($response)->order_id;
				$order->add_order_note( $order_number1 , true);
				
			}else
			{
				$order_number1="The error is ".$response."See the debug log for more details";
				$order->add_order_note( $order_number1 , true);
				error_log($response);
			}
		}
		
		 

	}

	public function custom_rest_end_point()
	{
		register_rest_route('order/store/v1', '/store/order/note', array(
			'methods' => 'POST',
			'callback' => array($this,'store_order_note'),
			'permission_callback' => '__return_true',
		));

		register_rest_route('order/store/v1', '/change/order/status', array(
			'methods' => 'POST',
			'callback' => array($this,'change_order_order_status'),
			'permission_callback' => '__return_true',
		));
	}
	public function store_order_note()
	{
		$additional_keys=[[
            'variable'=>'order_id',
            'message'=>'is required'
		],[
            'variable'=>'note',
            'message'=>'is required'
		]];
		$validated=$this->validate_input_request($additional_keys);
        if($validated->data['status']=="error")
        {
            return $validated;
        }
        $postdata = file_get_contents('php://input');
        $eventData = json_decode($postdata);

		$order = wc_get_order(  $eventData->order_id);
        $order->add_order_note( $eventData->note , true);

		$response = new WP_REST_Response([
			'status'=>'success',
			'message'=>"order note added succefully",
	   ]);
	   $response->set_status( 201 );
	   return $response;
	}
	public function change_order_order_status()
	{
		$additional_keys=[[
		'variable'=>'order_id',
		'message'=>'is required'
		],[
			'variable'=>'order_status',
			'message'=>'is required'
		]];

		$validated=$this->validate_input_request($additional_keys);
        if($validated->data['status']=="error")
        {
            return $validated;
        }
        $postdata = file_get_contents('php://input');
        $eventData = json_decode($postdata);

		$order = wc_get_order(  $eventData->order_id);
        $order->update_status( str_replace('hub','wc',$eventData->order_status), true);

		$order_notes_admin=wc_get_order_notes([
			'order_id' => $eventData->order_id,
			'orderby'  => 'date_created_gmt',
			'type'=>'internal'
			
		]);
		foreach($order_notes_admin as $note)
		{
			$order_note_content_admin[]=$note->content;
		}
		
		$response = new WP_REST_Response([
			'status'=>'success',
			'order_note_content_admin'=>json_encode($order_note_content_admin),
			'message'=>"Status Changed",
	   ]);
	   $response->set_status( 201 );
	   return $response;
	}
	public function validate_input_request($additional_keys=[])
    {
        $postdata = file_get_contents('php://input');
        $eventData = json_decode($postdata,true);
        
        
        $error_message=[];
        $rules=[[
               'variable'=>'shop_name',
               'message'=>'is required'
        ],[
            'variable'=>'shop_secret',
            'message'=>'is required'
        ],[
            'variable'=>'shop_url',
            'message'=>'is required'
		]];
		$rules=array_merge($rules,$additional_keys);
        //var_dump($rules);
        foreach($rules as $key=>$value)
        {
            if(empty($eventData[$value['variable']]))
            {
                $error_message[]=str_replace('_',' ',$value['variable']).' '.$value['message'];
                
            }elseif(in_array($value['variable'],['shop_name','shop_secret','shop_url']))
			{
				$object_key=$value['variable']; 
				$from_option_table=get_option($object_key);  
				if(($from_option_table !== $eventData[$value['variable']]) )
		    	{
				$error_message[]=str_replace('_',' ',$value['variable']).' '.str_replace('required','not registered',$value['message']);
				
			   }
			}
        }
     
        if(!empty($error_message))
        {
            
           // http_response_code(400);
           // echo json_encode();
            $response = new WP_REST_Response([
                'status'=>'error',
                 'message'=>$error_message 
            ]);

                // Set the status code for the response
            $response->set_status( 401 );

                // Return the response
            return $response;
        }else
        {
            $response = new WP_REST_Response([
                'status'=>'success',
                 'message'=>null, 
            ]);

                // Set the status code for the response
            $response->set_status( 200 );

                // Return the response
            return $response;
        }
        
        
    }
	public function custom_admin_menu()
	{
		add_menu_page(
			'Store Order Settings',        // Page title
			'Store Order Settings',        // Menu title
			'manage_options',         // Capability required to access the page
			'hub-order-custom-settings-page',   // Menu slug (unique identifier)
			array( $this, 'render_custom_settings_page' )// Callback function to render the page
	  
		);
	}
	public function render_custom_settings_page()
	{
		require_once( dirname( __FILE__ ).'/partials/settings/index.php' );
	}
	public function shop_options_setttings()
	{
		
		if ( ! is_user_logged_in() ) {
           
            echo  "401 Unauthorized ";
			
            wp_die();
        }
    
        // Check if the user is not an administrator or any other specific role
        if ( ! current_user_can( 'administrator' )) {
            // Set 401 Unauthorized status header
            echo  "401 Unauthorized ";
			
            wp_die();
        }

		update_option('shop_name',str_replace(' ', '', $_POST['shop_name']));
        update_option('shop_secret',str_replace(' ', '', $_POST['shop_secret']));
        update_option('shop_url',str_replace(' ', '', $_POST['shop_url']));
         
        $shop_name=get_option('shop_name');
        $shop_secret=get_option('shop_secret');
        $shop_url=get_option('shop_url');
		
        if(isset($shop_name) && !empty($shop_name) && isset($shop_secret) && !empty($shop_secret) && isset($shop_url) && !empty($shop_url))
        {
            $message='<span style="color: green">Registered</span>';
        }else
		{
			$message='<span style="color: red">Not Registered</span>';
		}
        echo $message;
        wp_die();
	}
}
