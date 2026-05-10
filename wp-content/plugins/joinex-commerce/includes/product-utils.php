<?php

// Lấy ID trang theo slug

function joinex_get_product_detail_page_id() {
    $page = get_page_by_path('chi-tiet-san-pham'); // slug của trang chi tiết
    if ($page) {
        return $page->ID;
    }
    return null; // nếu chưa tạo trang
}


// Hàm lấy link hoặc báo lỗi
function joinex_get_product_detail_page_attrs( $product_id ) {
    $product = wc_get_product( $product_id );
    if ( ! $product ) return '';

    $slug = $product->get_slug();
    // Ví dụ bạn muốn URL dạng: /chi-tiet-san-pham/{slug}
    $url = home_url( '/chi-tiet-san-pham/' . $slug );

    return 'href="' . esc_url( $url ) . '"';
}










