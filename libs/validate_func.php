<?php 

function validate_image($img)
{
    $img_err = "";

    $img_name = $img['name'];
    $img_size = $img['size'];
    $tmp_name = $img['tmp_name'];
    $error    = $img['error'];

    if ($error === 0)
    {
        // Make sure the file exists
        if (file_exists($tmp_name))
        {
            if ($img_size < 5000000)
            {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);

                $allowed_ex = array("jpg", "jpeg", "png");

                if (in_array($img_ex_lc, $allowed_ex))
                {
                    $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                    $img_upload_path = '../assest/Images/' . $new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);
                }
                else
                {
                    $img_err = "Invalid image format";
                }
            }
            else
            {
                $img_err = "Maximum size allowed is 5 MB";
            }
        }
        else
        {
            $img_err = "File does not exist";
        }
    }
    else
    {
        $img_err = "Error unknown occurred";
    }

    $result = array($new_img_name, $img_err);
    return $result;
}

function validate_edit_image($img)
{
    $img_err = "";
    
    $img_name = $img['name'];
    $img_size = $img['size'];
    $tmp_name = $img['tmp_name'];
    $error    = $img['error'];

    if ($error === 0)
    {
        if($img_size < 5000000)
        {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);

            $allowed_ex = array("jpg" , "jpeg" , "png" );

            if (in_array($img_ex_lc , $allowed_ex))
            {
                $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                $img_upload_path = '../assest/Images/' . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);
            }
            else
            {
                $img_err = "Invalid image format ";
            }            
        }
        else
        {
            $img_err = "Maximum size allowed is 5 MB";
        }
    }
    else
    {
        $img_err = "error unknown occurred";
    }

    $result = array($new_img_name , $img_err);
    return $result;
}

function validate($user_name,$price)
{
    $name_err = "";
    $price_err = "";

    

    if(empty($user_name))
    {
        $name_err = "Please enter a name";
    }
    else
    {
        $user_name = test_input($user_name);
        if(!preg_match("/^[a-zA-Z-' ]*$/", $user_name))
        {
            $name_err = "Only letters and white space allowed ";
        }
        if(strlen($user_name) > 12)
        {
            $name_err = "Name must be at least 12 characters";
        }
    }
    if(empty($price))
    {
        $price_err = "please enter a price";
    }
    else
    {
        $price = test_input($price);
        if(!preg_match("/^[0-9]*$/",$price))
        {
            $price_err = "Only numbers allowed ";
        }
        if(strlen($price_err) > 12)
        {
            $name_err = "Name must be at least 12 characters";          
        }

    }

    $var = array($user_name,$price);
    $err = array($name_err,$price_err);
    $result = array($var,$err);

    return $result;

}

?>