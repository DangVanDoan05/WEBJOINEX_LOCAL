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
    $page_id = joinex_get_product_detail_page_id();

    if (!$page_id || get_post_status($page_id) !== 'publish') {
        return 'href="javascript:void(0)" 
                onclick="alert(\'Trang chi tiết sản phẩm chưa được tạo hoặc chưa publish!, Hãy tạo trang với Slug"chi-tiet-san-pham"\'); return false;" 
                oncontextmenu="alert(\'Trang chi tiết sản phẩm chưa được tạo hoặc chưa publish!, Hãy tạo trang với Slug"chi-tiet-san-pham",\'); return false;"';
    } else {
        $page_link = get_permalink($page_id);
        return 'href="' . esc_url($page_link . '?product_id=' . $product_id) . '"';
    }
}







