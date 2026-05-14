<?php
function joinex_test_cart_shortcode() {
    // Xử lý thêm sản phẩm
    if ( isset($_POST['add_to_cart_195']) ) {
        WC()->cart->add_to_cart(200, 1);
    }

    ob_start();
    ?>
    <form method="post">
        <button type="submit" name="add_to_cart_195">Thêm sản phẩm ID 195</button>
    </form>

    <h3>Giỏ hàng hiện tại:</h3>
    <pre><?php print_r(WC()->cart->get_cart()); ?></pre>
    <?php
    return ob_get_clean();
}
add_shortcode('joinex_test_cart', 'joinex_test_cart_shortcode');

