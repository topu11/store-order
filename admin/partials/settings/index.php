<?php
$message='<span style="color: tomato">Not Registered</span>';
$shop_name=get_option('shop_name');
$shop_secret=get_option('shop_secret');
$shop_url=get_option('shop_url');

if(isset($_POST['login'])&&!empty($_POST))
{

    update_option('shop_name',str_replace(' ', '', $_POST['shop_name']));
    update_option('shop_secret',str_replace(' ', '', $_POST['shop_secret']));
    update_option('shop_url',str_replace(' ', '', $_POST['shop_url']));
}
else
{
   $shop_name=get_option('shop_name');
   $shop_secret=get_option('shop_secret');
   $shop_url=get_option('shop_url');
   
}
if(isset($shop_name) && !empty($shop_name) && isset($shop_secret) && !empty($shop_secret) && isset($shop_url) && !empty($shop_url))
   {
    $message='<span style="color: green">Registered</span>';
   }
?>
        <style>
        @import url(https://fonts.googleapis.com/css?family=Roboto:300);

            .login-page {
              width: 820px;
              padding: 8% 0 0;
              margin: auto;
            }
            .form {
              position: relative;
              z-index: 1;
              background: #FFFFFF;
              max-width: 1000px;
              margin: 0 auto 100px;
              padding: 45px;
              text-align: center;
              box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
            }
            .form input {
              font-family: "Roboto", sans-serif;
              outline: 0;
              background: #f2f2f2;
              width: 100%;
              border: 0;
              margin: 0 0 15px;
              padding: 15px;
              box-sizing: border-box;
              font-size: 14px;
            }
            .form button {
              font-family: "Roboto", sans-serif;
              text-transform: uppercase;
              outline: 0;
              background: #4CAF50;
              width: 100%;
              border: 0;
              padding: 15px;
              color: #FFFFFF;
              font-size: 14px;
              -webkit-transition: all 0.3 ease;
              transition: all 0.3 ease;
              cursor: pointer;
            }
            .form button:hover,.form button:active,.form button:focus {
              background: #43A047;
            }
            .form .message {
              margin: 15px 0 0;
              color: #b3b3b3;
              font-size: 12px;
            }
            .form .message a {
              color: #4CAF50;
              text-decoration: none;
            }
            .form .register-form {
              display: none;
            }
            .container {
              position: relative;
              z-index: 1;
              max-width: 300px;
              margin: 0 auto;
            }
            .container:before, .container:after {
              content: "";
              display: block;
              clear: both;
            }
            .container .info {
              margin: 50px auto;
              text-align: center;
            }
            .container .info h1 {
              margin: 0 0 15px;
              padding: 0;
              font-size: 36px;
              font-weight: 300;
              color: #1a1a1a;
            }
            .container .info span {
              color: #4d4d4d;
              font-size: 12px;
            }
            .container .info span a {
              color: #000000;
              text-decoration: none;
            }
            .container .info span .fa {
              color: #EF3B3A;
            }
            label {
                display: block;
                font-weight: bold;
                margin: 15px 5px;
                float: left;
            }
            
           
</style>
           
        <div class="login-page">
        
              <div class="form">
              <h1 id="register_msg"><?=$message?> </h1>
                <form class="login-form" method="post" action="" id="encoder_option_page_Setings">
                  <label>Shop Name</label>
                  <input type="text" id="shop_name" name="shop_name" value="<?=$shop_name?>" placeholder="Shop Name"/>
                  <label>Shop Secret</label>
                  <input type="text" id="shop_secret" name="shop_secret" value="<?=$shop_secret?>" placeholder="Shop Secret"/>
                  <label>Shop URL</label>
                  <input type="text" id="shop_url" name="shop_url" value="<?=$shop_url?>" placeholder="Shop URL"/>
                  <button type="submit" id="encoder_option_page_Setings_button">Register</button>
                </form>
              </div>
            </div>

            <script>
                jQuery('#encoder_option_page_Setings_button').on('click',function(e){
               
                   e.preventDefault();
                    var formdata = new FormData();
                        formdata.append('action','shop_options_setttings');
                        //formdata.append('nonce',action_url_ajax.nonce)
                        formdata.append('shop_name',jQuery('#shop_name').val())
                        formdata.append('shop_secret',jQuery('#shop_secret').val())
                        formdata.append('shop_url',jQuery('#shop_url').val())
                        jQuery.ajax({
                        url: `<?=admin_url('admin-ajax.php')?>`,
                        type: 'post',
                        processData: false,
                        contentType: false,
                        processData: false,
                        data: formdata,
                        success: function(data) {
                         jQuery('#register_msg').html(data);
                        }
                        });
                 })
            </script>
    <?php
  
    