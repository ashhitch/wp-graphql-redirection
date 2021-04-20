<?php // phpcs:ignore

/**
 * Plugin Name:     Add WPGraphQL Redirection
 * Plugin URI:      https://github.com/ashhitch/wp-graphql-redirection
 * Description:     A WPGraphQL Extension that adds WPGraphQL support support for Redirection plugin
 * Author:          Ash Hitchcock
 * Author URI:      https://www.ashleyhitchcock.com
 * Text Domain:     wp-graphql-redirection
 * Domain Path:     /languages
 * Version:         0.0.3
 *
 * @package         WP_Graphql_REDIRECTION
 */

if (!defined('ABSPATH')) {
    exit();
}

use WPGraphQL\AppContext;

add_action('admin_init', function () {
    $core_dependencies = [
        'WPGraphQL plugin' => class_exists('WPGraphQL'),
    ];

    $missing_dependencies = array_keys(
        array_diff($core_dependencies, array_filter($core_dependencies))
    );
    $display_admin_notice = static function () use ($missing_dependencies) {
?>
        <div class="notice notice-error">
            <p><?php esc_html_e(
                    'The WPGraphQL Redirection plugin can\'t be loaded because these dependencies are missing:',
                    'wp-graphql-redirection'
                ); ?>
            </p>
            <ul>
                <?php foreach ($missing_dependencies as $missing_dependency) : ?>
                    <li><?php echo esc_html($missing_dependency); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
<?php
    };

    if (!empty($missing_dependencies)) {
        add_action('network_admin_notices', $display_admin_notice);
        add_action('admin_notices', $display_admin_notice);

        return;
    }
});

add_action('graphql_init', function () {


    add_action('graphql_register_types', function () {

     

        register_graphql_object_type('RedirectionRedirect', [
            'description' => __(
                'The redirect',
                'wp-graphql-redirection'
            ),
            'fields' => [
                'origin' => ['type' => 'String'],
                'target' => ['type' => 'String'],
                'type' => ['type' => 'String'],
                'code' => ['type' => 'Int'],
                'groupId' => ['type' => 'Int'],
                'groupName' => ['type' => 'String'],
                'matchType' => ['type' => 'String'],
            ],
        ]);

        register_graphql_object_type('RedirectionRedirects', [
            'description' => __('The Redirects', 'wp-graphql-redirection'),
            'fields' => [
                'redirects' => ['type' => ['list_of' => 'RedirectionRedirect']],
            ],
        ]);


        register_graphql_field(
            'RootQuery',
            'redirection',
            [
                'type' => 'RedirectionRedirects',
                'description' => __(
                    'The redirects',
                    'wp-graphql-redirection'
                ),
                'resolve' => function (
                    $post,
                    array $args,
                    AppContext $context
                ) {

                    global $wpdb;

                    $sql = $wpdb->prepare(
                        "SELECT {$wpdb->prefix}redirection_items.*, {$wpdb->prefix}redirection_groups.name FROM {$wpdb->prefix}redirection_items
                                    INNER JOIN {$wpdb->prefix}redirection_groups ON {$wpdb->prefix}redirection_groups.id={$wpdb->prefix}redirection_items.group_id
                                    ORDER BY {$wpdb->prefix}redirection_items.position"
                    );
                    $rows = $wpdb->get_results($sql);
                    
                    $items = [];
                    
                    foreach ((array) $rows as $row) {
                        $items[] = [
                            'origin' => $row->url,
                            'target' => $row->action_data,
                            'code' => absint($row->action_code),
                            'type' => $row->action_type,
                            'groupId' => $row->group_id,
                            'groupName' => $row->name,
                            'matchType' => $row->match_type,
                        ];
                    }
                    
                    
              

                    return ['redirects' => !empty($items) ? $items : null];
                },
            ]
        );
    });
});
