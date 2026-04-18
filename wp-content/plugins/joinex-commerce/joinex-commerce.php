<?php
/*
Plugin Name: Joinex Commerce
Description: Custom Checkout for Joinex
Version: 1.0
Author: M1029_Dang Van Doan
*/

//#region THỨ TỰ CÁC FILE CỦA PLUGIN

    //Thứ tự hợp lý là: Khai báo hằng số → Load assets → Đăng ký shortcode → Require các file logic.
    // CSS/JS cần được enqueue sớm để khi WordPress render frontend, chúng đã sẵn sàng.

//#endregion


//#region ĐỊNH NGHĨA CÁC THÔNG SỐ CỐ ĐỊNH SỬ DỤNG: define trong PHP chính là cách để tạo hằng số. 

    // CÚ PHÁP: define('TEN_HANG_SO', 'gia_tri');
    //  hàm tiện ích (function) do WordPress cung cấp sẵn.

    define('JOINEX_PLUGIN_URL', plugin_dir_url(__FILE__)); //plugin_dir_url(__FILE__): trả về URL tuyệt đối đến thư mục chứa file plugin hiện tại.
    define('JOINEX_PLUGIN_PATH', plugin_dir_path(__FILE__)); // plugin_dir_path(__FILE__): tương tự, nhưng trả về đường dẫn vật lý trên server (filesystem path).
   


    // chặn truy cập trực tiếp vào file plugin, chỉ cho phép file chạy khi được WordPress load.
    //  Đây là cách bảo vệ plugin khỏi bị khai thác hoặc lộ thông tin.
    if (!defined('ABSPATH')) {
        exit;
    }
//#endregion

//#region   HÀM TẠO RA ICON ĐỂ BIẾT ICON KÍCH HOẠT.
    add_action('admin_menu', 'joinex_admin_menu');

        function joinex_admin_menu() {

            add_menu_page(
                'Joinex Commerce',          // Page title
                'Joinex Commerce',         // Menu title
                'manage_options',           // Permission
                'joinex-commerce',          // Slug
                'joinex_admin_page',        // Function hiển thị trang
                'dashicons-cart',           // Icon
                56                          // Vị trí menu
            );
        }

// #endregion 

/* LOAD CSS-JS */
    // wp_enqueue_style là một hàm (function) của WordPress, không phải hook.
    // Nó được dùng để đăng ký và đưa CSS vào hàng chờ (enqueue) để WordPress load ra ngoài.
    // Cú pháp cơ bản:  wp_enqueue_style( $handle, $src, $deps, $ver, $media );
    
       // $handle: tên định danh duy nhất cho stylesheet.

       // $src: đường dẫn URL đến file CSS.

       // $deps: mảng các stylesheet phụ thuộc (nếu có).

       // $ver: version (thường để tránh cache).

      // $media: loại media (screen, print…).

    function joinex_load_assets(){
       
        wp_enqueue_style(
            'joinex-checkout-css', // tên định danh duy nhất cho stylesheet.
            plugin_dir_url(__FILE__) . 'assets/css/checkout.css', // $src: đường dẫn URL đến file CSS.
            array(),  // $deps: mảng các stylesheet phụ thuộc (nếu có). ; array() trống = không phụ thuộc, chỉ để giữ đúng cú pháp.
            filemtime( plugin_dir_path(__FILE__) . 'assets/css/checkout.css' ) 
            // version của file CSS: filemtime() = last modified time, không phải “thời gian tạo file”
        ); // Tham số thứ 5 bỏ trống: nếu CSS dùng cho giao diện web bình thường thì có thể bỏ trống tham số thứ 5 (WordPress sẽ hiểu là "all").

        // CSS cho List product (đảm bảo load sau Elementor)
        wp_enqueue_style(
            'joinex-product-list',
            plugin_dir_url(__FILE__) . 'assets/css/List-product-HomePage.css',
            array('elementor-frontend', 'joinex-checkout-css'), // load sau Elementor và CSS plugin khác
            filemtime( plugin_dir_path(__FILE__) . 'assets/css/List-product-HomePage.css' )
        );

        // CSS cho List product ở trang SẢN PHẨM (đảm bảo load sau Elementor)
        wp_enqueue_style(
            'joinex-product-list-ProductPage',
            plugin_dir_url(__FILE__) . 'assets/css/List-product-ProductPage.css',
            array('elementor-frontend', 'joinex-checkout-css'), // load sau Elementor và CSS plugin khác
            filemtime( plugin_dir_path(__FILE__) . 'assets/css/List-product-ProductPage.css' )
        );

        // CSS cho Bộ lọc sản phẩm
        wp_enqueue_style(
            'joinex-product-filter-dropdown',
            plugin_dir_url(__FILE__) . 'assets/css/product_filter_dropdown.css',
            array('elementor-frontend', 'joinex-checkout-css'), // load sau Elementor và CSS plugin khác
            filemtime( plugin_dir_path(__FILE__) . 'assets/css/product_filter_dropdown.css' )
        );

        // CSS cho Trang chi tiết sản phẩm
        wp_enqueue_style(
            'joinex-product-detail-page',
            plugin_dir_url(__FILE__) . 'assets/css/product-detail.css',
            array('elementor-frontend', 'joinex-checkout-css'), // load sau Elementor và CSS plugin khác
            filemtime( plugin_dir_path(__FILE__) . 'assets/css/product-detail.css' )
        );

        // CSS cho SLIDER SẢN PHẨM
        wp_enqueue_style(
            'slider-product-detail',
            plugin_dir_url(__FILE__) . 'assets/css/slider-product-detail.css',
            array('elementor-frontend', 'joinex-checkout-css'), // load sau Elementor và CSS plugin khác
            filemtime( plugin_dir_path(__FILE__) . 'assets/css/slider-product-detail.css' )
        );


    }
    add_action('wp_enqueue_scripts','joinex_load_assets', 20);



/* Load logic -- XỬ LÝ CÁC HÀM. */  

require_once plugin_dir_path(__FILE__) . 'includes/checkout.php';


/* Load shortcode - Cái mà WordPress và Elementor Page sử dụng để Show ra trang mà Plugin không cần tạo ra Page */

require_once plugin_dir_path(__FILE__) . 'shortcodes/checkout-shortcode.php';

//KHAI BÁO VỚI PLUGIN là có hàm này và sử dụng hàm này 
require_once plugin_dir_path(__FILE__) . 'includes/product-utils.php';




// HÀM LOAD SHORTCODE
function joinex_commerce_load_shortcodes() {
    include_once plugin_dir_path(__FILE__) . 'shortcodes/List-product-HomePage.php';
    include_once plugin_dir_path(__FILE__) . 'shortcodes/List-product-ProductPage.php';
    include_once plugin_dir_path(__FILE__) . 'shortcodes/product_filter_dropdown.php';
    include_once plugin_dir_path(__FILE__) . 'shortcodes/product-detail.php';
    include_once plugin_dir_path(__FILE__) . 'shortcodes/slider-product-detail.php';
}

add_action('init', 'joinex_commerce_load_shortcodes');

/* Load phần Custom trang chỉnh sửa sản phẩm THÊM Ô NHẬP THÔNG SỐ KỸ THUẬT VÀ HƯỚNG DẪN LẮP ĐẶT */

require_once plugin_dir_path(__FILE__) . 'includes/product-custom-fields.php';





