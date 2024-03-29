<?php
/**
 * Plugin Name: Famivita - Pagar.me Split Payment for WooCommerce
 * Description: Define partners to split payment with using Pagar.me payment gateway.
 * Version: 1.0.3
 * Author: Raphael Batagini
 * Author URI: https://github.com/RaphaelBatagini/
 * Text Domain: pagarme-split-payment
 * Domain Path: /i18n/languages/
 *
 * @package PagarmeSplitPayment
 */

defined( 'ABSPATH' ) || exit;
define('PLUGIN_NAME', 'Pagar.me Split Payment');

require_once(__DIR__ . '/vendor/autoload.php');

class PagarmeSplitWooCommerce {
    public static function run()
    {
        \Carbon_Fields\Carbon_Fields::boot();

        // CPTs
        (new \PagarmeSplitPayment\Cpts\ProductCustomPostType())->create();
        (new \PagarmeSplitPayment\Cpts\ShopOrderCustomPostType())->create();

        // Business rules
        (new \PagarmeSplitPayment\Pagarme\SplitRules())->addSplit();

        // Admin
        (new \PagarmeSplitPayment\Admin\Actions())
            ->createRecipients()
            ->createAdminNotices()
            ->logExternalRequests();
        
        (new \PagarmeSplitPayment\Admin\PluginOptions())->create();

        // Roles
        (new \PagarmeSplitPayment\Roles\PartnerRole())->create();
    }
}

add_action('after_setup_theme', function() {
    PagarmeSplitWooCommerce::run();
});
