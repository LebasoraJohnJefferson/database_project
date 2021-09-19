<?php
    SESSION_START();

    //connection between database and webpage
    function authentication(){
        $host="localhost";
        $username="root";
        $password="";
        $database="movies_database";
        $con = new mysqli($host,$username,$password,$database);
        if ($con->error){
            echo "<div style=position:absolute;z-index:3;>ERROR</div>";
        }else{
            return $con;
        }
    }
                
                
    function save_data($table,$mode,$col_1,$col_2,$col_3,$col_4,$col_5  ){
        $con = authentication();
        if($mode=="INSERT"){
            if($table == "user_account"){
                //table,mode,fname,lname,username,pass;
                $sql="$mode INTO $table VALUES('','$col_1','$col_2','$col_3','$col_4')";
            }else if($table =="admin_table"){
                //table,mode,foreign_key,title,price,max_ticket,img;
                $sql="$mode INTO $table VALUES('','$col_1','$col_2','$col_3','$col_4','$col_5')";
            }
            else if($table =="reservation_table"){
                //table,mode,user_id,admin_id,Quantity;
                $sql="$mode INTO $table VALUES('$col_1','$col_2','$col_3')";
            }
        }else if($mode=="UPDATE"){
            if ($table == "user_account"){
                //table,fname,lname,username,password,primary_key;
                $sql = "$mode $table SET first_name='$col_1',last_name='$col_2',username='$col_3',password='$col_4' where user_id='$col_5'";
            }else if($table =="admin_table"){
                //table,mode,title,price,max_ticket,image,admin_id;
                $sql = "$mode $table SET title='$col_1',price='$col_2',max_ticket='$col_3',image='$col_4' where admin_id='$col_5'";
            }
        }
        $data = $con->query($sql) or die($con->error);
        return $data;
    }
                                //username,password;
    function validation($table,$mode,$col_1,$col_2,$col_3){
        $con=authentication();
        if($mode == "SELECT"){
            //retrieve the account by username;
            if($table == "user_account" && $col_2==null && $col_3==null){
                $sql = "$mode username FROM $table where username = '$col_1'";
            }
            //retrieve the account using the password and user;
            else if($table == "user_account" && isset($col_2) && $col_3==null){
                $sql = "$mode * FROM $table where username ='$col_1' and password='$col_2'";
            }
            //retrieve the account using primary_key;
            else if($table == 'user_account' && $col_1==null && $col_2 == null && isset($col_3)){
                $sql = "$mode * FROM $table where user_id='$col_3'";
            }
            else if($table == 'admin_table' && $col_1==null && $col_2 == null && isset($col_3)){
                $sql = "$mode * FROM $table where admin_id='$col_3'";
            }
        }
        $data = $con->query($sql) or die($con->error);
        return $data;
    }

    function movie_processor($user_id,$mode,$wants){
        $con=authentication();
        if(isset($user_id)){
            if($mode == "SELECT")
                if($wants == "in_user"){
                    $sql="$mode * FROM user_account,admin_table
                    where user_account.user_id=admin_table.user_id
                    and user_account.user_id='$user_id'";
                }else if($wants=="not_in_user"){
                    $sql="$mode * FROM user_account,admin_table
                    where user_account.user_id=admin_table.user_id
                    and user_account.user_id!='$user_id'";
                }
        }
        $data = $con->query($sql) or die($con->error);
        return $data;
    }

    function transaction($mode,$table_1,$table_2,$table_3,$user_id,$admin_id,$wants){
        $con=authentication();
        if($mode == "SELECT"){
            if($wants=="quantity"){
                $sql="$mode *,sum($wants) as reserve from $table_3
                natural join $table_1,$table_2
                where $table_3.user_id=$table_1.user_id
                and $table_3.admin_id=$table_2.admin_id
                and $table_2.admin_id='$admin_id'";
            }else if($wants=='details'){
                $sql="$mode *,sum(quantity) as sum from $table_3
                natural join $table_1,$table_2
                where $table_3.user_id=$table_1.user_id
                and $table_3.admin_id=$table_2.admin_id
                and $table_3.user_id='$user_id'
                GROUP BY reservation_table.admin_id";
            }else{
                $sql="$mode * from $table_3
                natural join $table_1,$table_2
                where $table_3.user_id=$table_1.user_id
                and $table_3.admin_id=$table_2.admin_id
                and $table_3.admin_id='$admin_id'";
            }
        }
        $data = $con->query($sql) or die($con->error);
        return $data;
    }



    //upload the image
    function upload_file($img_path,$img){
        //check the file if exist if not then create one;
        if(!file_exists($img_path)){
            mkdir($img_path,0777,true);
        }   $temp_file=$_FILES['img']['tmp_name'];
        //if file is not empty then process;
        if($temp_file!=""){
            //to avoid error in fetching images in UI
            $new_filepath=$img_path.'/'.time().uniqid(rand()).$_FILES['img']['name'];
            move_uploaded_file($temp_file,$new_filepath);
        }
    }

?>