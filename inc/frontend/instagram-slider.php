<?php
defined( 'ABSPATH' ) or die( "No script kiddies please!" );
global $apif_settings, $insta;
    $apif_settings = get_option( 'apif_settings' );
    // $username = $apif_settings['username']; // your username
    $username = $set_username;
    //$access_token = $apif_settings['access_token'];
    $access_token = $set_access_token;
    $image_like = $apif_settings['active'];
    $count = 10; // number of images to show
    require_once('instagram.php');
    if($username == '' && $access_token ==''){
        $response = array('meta'=>array('error_message'=>'Username and access token field is empty. Please configure.'));

    }else if($username == ''){
        $response = array('meta'=>array('error_message'=>'Username field is empty.'));

    }else if ($access_token == ''){
        $response = array('meta'=>array('error_message'=>'Access token field is empty.'));
    }else{
        $response = $insta->userMedia();
    }

    if($response == NULL){
        $response = array('meta'=>array('error_message'=>'Username field is empty.'));
    }

    $ins_media_slider = $response;
    ?>
        <?php
        $j = 0;
        
        if(isset($ins_media_slider['meta']['error_message'])){
            /* <h1 class="widget-title-insta"><span><?php echo $ins_media_slider['meta']['error_message']; ?></span></h1> */ 
        } else if (is_array($ins_media_slider['data']) || is_object($ins_media_slider['data'])) { ?>
               <div class="ct_insta_list_out clearfix">
                    <div id="ct_insta_list" class="">
                <?php
                foreach ($ins_media_slider['data'] as $vm):
                    if ($count == $j) {
                        break;
                    }
                    $j++;
                    //print_r($vm);
                    $imgslider = $vm['images']['standard_resolution']['url'];
                    $img_alt = $vm['caption']['text'];

                    //print_r($vm['attribution']);
                    //#mtcode

                    $username = $vm['user']['username'];
                    $profile_picture = $vm['user']['profile_picture'];
                    $publish_date = $vm['created_time'];
                    $caption_date = $vm['caption']['created_time'];
                ?>
                     <div class="ct_insta_bx01">
                        <img src="<?php echo esc_url($imgslider); ?>" alt='<?php echo esc_attr( $img_alt ); ?>'/>
                        <?php echo $username; ?>
                        <?php echo $date; ?>
                        <?php echo date('M j, Y', $publish_date); ?>
                        <?php echo $img_alt ?>
                        <?php if ($image_like == '1') : ?>
                           
                            <!-- Image like cound section end -->
                    </div>
                    <?php endif; ?>
                    

                <?php endforeach; ?>
                </div>
            </div>
        <?php } ?>
