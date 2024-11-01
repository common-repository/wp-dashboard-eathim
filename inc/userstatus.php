<?php
/**
 * All User Table
 */
if (!defined('ABSPATH')) die();

function wpde_userstatus_widgets(){
    wp_add_dashboard_widget(
        'wpde_userstatus_widget',
        esc_html__("WPDE User Status",'wpdeathim'),
        'wpde_userstatus_widget'
    );
}
add_action("wp_dashboard_setup","wpde_userstatus_widgets");

function wpde_userstatus_widget(){
    $args = array(
        "order"=>"ASC",
        "order_by"=>"display_name"
    );
    $users = new WP_User_Query($args);

    ?>

    <table class="wpde-userstatus-table">
        <tr>
            <th></th>
            <th><?php echo esc_html__("Name","wpdeathim");?></th>
            <th><?php echo esc_html__("Email","wpdeathim");?></th>
            <th><?php echo esc_html__("Role","wpdeathim");?></th>
            <th><?php echo esc_html__("Action","wpdeathim");?></th>
        </tr>
        <?php
        foreach ($users->get_results() as $user):
            ?>
            <tr>
                <td>
                    <img src="<?php echo esc_url(get_avatar_url( $user->ID ));?>" alt="<?php echo esc_attr($user->user_login); ?>">
                </td>
                <td><?php echo esc_html($user->first_name); ?> <?php echo esc_html($user->last_name); ?></td>
                <td><?php echo esc_html($user->user_email); ?></td>
                <td><?php echo esc_html($user->roles[0]); ?></td>
                <td><a href="<?php echo esc_url(get_edit_user_link($user->ID)); ?>"><?php echo esc_html__("Edit","wpdeathim")?></a></td>
            </tr>
        <?php endforeach;?>
    </table>

    <?php
}