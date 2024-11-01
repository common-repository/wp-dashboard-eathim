<?php
/**
 * TotoList Widgets
 */
if (!defined('ABSPATH')) die();

function wpde_todolists(){
    global $wpdb;
    $table_name = $wpdb->prefix."wpde_todolist";
    $sql = "CREATE TABLE {$table_name}(
        id INT NOT NULL AUTO_INCREMENT,
        item VARCHAR (250),
        PRIMARY KEY (id)
    )";
    require_once (ABSPATH."wp-admin/includes/upgrade.php");
    dbDelta($sql);
}

function wpde_todolist_widgets(){
    wp_add_dashboard_widget(
        'wpde_todolist_widget',
        esc_html__("WPDE Todo List",'wpdeathim'),
        'wpde_todolist_widget'
    );
}
add_action("wp_dashboard_setup","wpde_todolist_widgets");

function wpde_todolist_widget(){
    global $wpdb;
    $table_name = $wpdb->prefix."wpde_todolist";
    $results = $wpdb->get_results("SELECT * FROM {$table_name}");
    ?>
    <table class="wpde-userstatus-table">
        <?php foreach($results as $result):?>
            <tr>
                <td><?php echo esc_html($result->item); ?></td>
                <td>
                    <form class="deleteitem" action="<?php echo esc_url(admin_url('admin-post.php'));?>" method="post">
                        <input type="hidden" name="deleteitem" value="<?php echo esc_attr($result->id)?>">
                        <input type="hidden" name="action" value="deleteitem">
                        <input type="submit" name="delete" value="X">
                    </form>
                </td>
            </tr>
        <?php endforeach;?>
    </table>
    <form class="wpde-todolist-form" action="<?php echo esc_url(admin_url('admin-post.php'));?>" method="post">
        <?php wp_nonce_field('wpdetodolist','nonce')?>
        <input type="hidden" name="action" value="wpdetodolist">
        <input type="text" name="item" placeholder="Enter Todo Text"> <br>
        <?php submit_button("Add List");?>
    </form>
    <?php
}

// add todolist
add_action('admin_post_wpdetodolist', function (){
    global $wpdb;
    $table_name = $wpdb->prefix."wpde_todolist";
    if(isset($_POST['submit'])){
        $nonce = sanitize_text_field($_POST['nonce']);
        if(wp_verify_nonce($nonce, 'wpdetodolist')){
            $item = sanitize_text_field($_POST['item']);
            $wpdb->insert("{$table_name}",['item'=>$item]);
        }
    }
    wp_redirect(admin_url('index.php'));
});

// delete todolist
add_action('admin_post_deleteitem', function (){
    if (isset($_POST['delete'])) {
        global $wpdb;
        $table_name = $wpdb->prefix."wpde_todolist";
        $delete_id = sanitize_text_field($_POST['deleteitem']);
        $wpdb->delete($table_name, ['id' => $delete_id]);
    }
    wp_redirect(admin_url('index.php'));
});