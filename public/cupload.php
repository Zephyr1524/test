<?php
require '/mailer/PHPMailerAutoload.php';


//$dbcon=new connectdb;
class ProfFilter{

    var $Banlist;

    public function ProfFilter($ban){$this->Banlist= $ban;}

    public function censorString($string) {
            $badwords=$this->Banlist;

            $leet_replace = array();
            $leet_replace['a']= '(a|a\.|a\-|4|@)';
            $leet_replace['b']= '(b|b\.|b\-|8|\|3)';
            $leet_replace['c']= '(c|c\.|c\-|Ç|ç|¢|€|<|\(|{|©)';
            $leet_replace['d']= '(d|d\.|d\-|&part;|\|\))';
            $leet_replace['e']= '(e|e\.|e\-|3|€|∑)';
            $leet_replace['f']= '(f|f\.|f\-|ƒ)';
            $leet_replace['g']= '(g|g\.|g\-|6|9)';
            $leet_replace['h']= '(h|h\.|h\-|Η)';
            $leet_replace['i']= '(i|i\.|i\-|!|\||\]\[|]|1)';
            $leet_replace['j']= '(j|j\.|j\-)';
            $leet_replace['k']= '(k|k\.|k\-|Κ|κ)';
            $leet_replace['l']= '(l|1\.|l\-|!|\||\]\[|]|£)';
            $leet_replace['m']= '(m|m\.|m\-)';
            $leet_replace['n']= '(n|n\.|n\-|η|Ν|Π)';
            $leet_replace['o']= '(o|o\.|o\-|0|Ο|ο|°)';
            $leet_replace['p']= '(p|p\.|p\-|ρ|Ρ|)';
            $leet_replace['q']= '(q|q\.|q\-)';
            $leet_replace['r']= '(r|r\.|r\-|®)';
            $leet_replace['s']= '(s|s\.|s\-|5|\$)';
            $leet_replace['t']= '(t|t\.|t\-|Τ|τ|\+)';
            $leet_replace['u']= '(u|u\.|u\-|υ|µ)';
            $leet_replace['v']= '(v|v\.|v\-|υ|ν)';
            $leet_replace['w']= '(w|w\.|w\-)';
            $leet_replace['x']= '(x|x\.|x\-|Χ)';
            $leet_replace['y']= '(y|y\.|y\-|¥)';
            $leet_replace['z']= '(z|z\.|z\-|Ζ)';

            foreach ($leet_replace as $key => $value) {$leet_replace[$key]=$value.'+';}

            for ($x=0; $x<count($badwords); $x++) {
                $replacement[$x] =str_repeat('*',strlen($badwords[$x]));
                $badwords[$x] =  '/([^ ]{1})?'.str_ireplace(array_keys($leet_replace),array_values($leet_replace), $badwords[$x]).'([^ ]{1})?/i';
            }
            
            // var_dump($badwords);echo "<BR><BR><BR>";

            $newstring = array();
            $newstring['orig'] = $string;#html_entity_decode($string);
            $newstring['clean'] =  preg_replace($badwords,$replacement, $newstring['orig']);

            return $newstring['clean'];

    }
}

class DbCon{
    
    var $username = "root";
    var $password = "";    
    var $database = "ut_dbase";
    var $host = "localhost";
    var $con ;
    var $msg="";
    /*

    */
    function DbCon(){$this->con = mysql_connect($this->host, $this->username, $this->password);}

    public function ConTO(){
        
        if ($this->con){
          mysql_select_db($this->database);
         // echo ("<strong>Horay!</strong> Database has been successfuly connected.");
        }else {die("<strong> ERROR!</strong> Connection Failed..");return false;}
    }

    public function ConSpe($host,$username,$password,$db){

        if (!mysql_connect($host,$username,$password,$db))
            {die("<strong> ERROR!</strong> Connection Failed..");return false;}
    }
}

class CUp extends DbCon{   
    
    var $pic;
    public $dgg;
    public $path;
    public $path_a1;


    //INSERTING IMAGE NAME TO DB
    public function img_todb($img_intoDB,$desc1="NULL"){
        //require_once("conn.php");
        //$dbdb=new connectdb;

        $this->ConTO();
        $q_Inname="iNSERT INTO image1(ImgPath,Descript) VALUES ('".$img_intoDB."','".$desc1."')";
        // echo $q_Inname;
        mysql_query($q_Inname) or die ("No insert ".mysql_error());
        //echo "Image has been Uploaded!";

    }
function mailing1($to,$cmtor)
    {
        $mail = new PHPMailer;

        // $mail->SMTPDebug = 3;                               // Enable verbose debug output
        // $mail->SMTPDebug = 4;

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'luilean1524@gmail.com';                 // SMTP username
        $mail->Password = 'ExNihilo';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        $mail->From = 'luilean1524@gmail.com';
        $mail->FromName = 'Admin';
        // $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
        $mail->addAddress($to);               // Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'New Comment';
        $mail->Body    = $cmtor." has commented on your <a href='http://localhost/bravante/profile.php'>image<a>.";
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
    }
    
    //insert comment
    public function cmt_todb($r8,$com1,$pth1,$uid){

        $this->ConTO();
        $p1=$pth1;
        $result=mysql_query("SELECt imgID from image1 where ImgPath='".$pth1."' limit 1");
        while ($row = mysql_fetch_assoc($result)) {$pth1 = $row['imgID'];}
        $q_Inname="iNSERT INTO comments1(R8ing,Comnt,ImgID,uid) VALUES (".$r8.",'".$com1."',".$pth1.",".$uid.")";
        // echo $q_Inname;
        mysql_query($q_Inname) or die ("No insert ".mysql_error()."<br>".$q_Inname);
        // echo "select SELECT CONCAT(`fullname`,' of ',`course`) as snder FROM `login` WHERE  uid=$uid<br>select SELECT username FROM `login` WHERE  uid=$p1";
        $query =  mysql_fetch_assoc(mysql_query("select CONCAT(`fullname`,' of ',`course`) as snder FROM `login` WHERE  uid=$uid"));
        $p1=explode('/', $p1)[1];
        $query2 =  mysql_fetch_assoc(mysql_query("select username FROM `login` WHERE  uid=$p1"));

        // echo mail($query2['username'],"New Comment",$query['snder']." has commented on your image.","From: luilean1524@gmail.com");
        // echo $query2['username']."New Comment",$query['snder']." has commented on your image."."From: luilean1524@gmail.com";
        // $this->mailing1($query2['username'],$query['snder']);

    }

    

    //retrieve comments
    public function fetch_comments($pth1,$sw1=true){

        $this->ConTO();
        if($sw1){
        $result=mysql_query("SELECt imgID from image1 where ImgPath='".$pth1."' limit 1");
        $row = mysql_fetch_assoc($result);$pth1 = $row['imgID'];}
        $q_Inname=mysql_query("select R8ing,Comnt,fullname from comments1 INNER JOIN login using(uid) where imgID='".$pth1."'  ORDER BY `comments1`.`ComID` DESC");
        $res1=array();
        while ($row =mysql_fetch_assoc($q_Inname)) {array_push($res1, $row);}
        return $res1 ;
    }

    public function randImg(){
        $this->ConTO();
        $que=mysql_query('sELECT `ImgPath` FROM image1 ORDER BY RAND() LIMIT 2');
        $ar1=array();
        if($que)while ($row=mysql_fetch_array($que)){array_push($ar1,$row[0]);}
        return $ar1;
    }
    public function randusr($exmp){
        $this->ConTO();
        $que=mysql_query("sELECT uid,fullname FROM login where uid<>'$exmp' ORDER BY RAND() LIMIT 5");
        $ar1=array();
        if($que)while ($row=mysql_fetch_assoc($que)){array_push($ar1,$row);}
        return $ar1;
    }


    //UPLOADING OF IMAGES
	public function image_upload ($arr,$pic1,$folPath="uploads/"){

        $tmpStr;
        $target;
        for ( $i1=0;$i1<count($arr);$i1++) {
        $pic=$pic1[$i1];
        // echo $pic.$i1;
        // print "name: ".     $arr[$pic]['name']       ."<br />";
        // print "size: ".     $arr[$pic]['size'] ." bytes<br />";
        // print "temp name: ".$arr[$pic]['tmp_name']   ."<br />";
        // print "type: ".     $arr[$pic]['type']       ."<br />";
        // print "error: ".    $arr[$pic]['error']      ."<br />";
        
        if ( ($arr[$pic]['type'] == "image/jpg")||($arr[$pic]['type'] == "image/png")||($arr[$pic]['type'] == "image/jpeg")||($arr[$pic]['type'] == "image/gif"))
        {
         $source = $arr[$pic]['tmp_name'];
         echo $target =$folPath.$arr[$pic]['name'];

         move_uploaded_file( $source, $target ) or die ("Couldn't copy");
         $size = getImageSize( $target );

         $imgstr = "<p><img width=\"$size[0]\" height=\"$size[1]\" ";
         $imgstr .= "src=\"$target\" alt=\"uploaded image\" /></p>";

         print $imgstr;
         $img_name=$arr[$pic]['name'];
         
         // return $img_name;
        }
        elseif (($arr[$pic]['type'] == "text/plain")) 
        {
            
            $fp = fopen($arr[$pic]['tmp_name'], 'r');
            while ( ($line = fgets($fp)) !== false) {
             $tmpStr.= $line.chr(0x0D).chr(0x0A);}
            

        }
        else echo "cannot upload";
        }
		#if ($target AND $tmpStr) 
            $this->img_todb ($target,$tmpStr);

	}

    //FOR DISPLAYING IMAGES FROM FILE
    public function srchImg($v1)
    {
        $this->ConTO();
        $que=mysql_query("sELECT imgpath FROM  `image1` WHERE  `Descript` LIKE  '%$v1%' order by d8 desc LIMIT 0 , 30");
        $ar1=array();
        while ($row=mysql_fetch_array($que)){array_push($ar1,$row[0]);}
        return $ar1;
        # code...
    }



    public function image_setpath($path){

        return $this->path=$path;
    }

    private function image_getdirect($path){

        return scandir($path);
    }
    public function images_get($mgs_extns=array('jpg','jpeg','png','gif')){

        $mgs=$this->image_getdirect($this->path);

        foreach ($mgs as $index => $image_s){

         $mgs_extn=strtolower(end(explode('.', $image_s)));
         //echo '<pre>',print_r($mgs_extn), '</pre>';
         if (!in_array($mgs_extn, $mgs_extns))unset($mgs[$index]);
        }


        return (count($mgs)) ? $mgs : false;
    }
}

class Sessions extends DbCon{

    var $HP='index.php';
    var $Rdirect="profile.php";
    var $error;
    var $login_session;
    function _construct(){echo "started";}

    function login($un,$pas){
        
        $this->ConTO();
        $this->error=''; // Variable To Store Error Message
        
        if (empty($un) || empty($pas)) {$this->error = "Username or Password is invalid";}
        else
        {
        // Define $username and $password
        $username=mysql_real_escape_string(stripslashes($un));
        $password=mysql_real_escape_string(stripslashes($pas));

        $query = mysql_query("select * from login where password='$password' AND username='$username'");
        if (mysql_num_rows($query)) {
        $_SESSION['login_user']=$username; // Initializing Session
        $tmp1=mysql_fetch_array($query);
        $_SESSION['uid']=$tmp1[0];
        $_SESSION['fn']=$tmp1[3];
        //selection of css
        $p1="";
        switch ($tmp1[7]) {
                case 1:
                $p1='cerulean';
                break;
                case 2:
                $p1='slate';
                break;
                case 3:
                $p1='cyborg';
                break;}

        $_SESSION['prefcss']=$p1;
        // $this->error=var_dump($_SESSION['login_user']);
        if ($_SESSION["uid"]!=$_COOKIE["uid"]||(!isset($_COOKIE['pr1']))){
        setcookie('pr1', $_SESSION['prefcss'] , time() + (86400 * 30), "/");setcookie('uid', $_SESSION["uid"], time() + (86400 * 30), "/");}



        echo '<script>window.location.replace("'.$this->Rdirect.'")</script>'; // Redirecting To Other Page
        } else {
        $this->error = "Username or Password is invalid";
        }
        
        }
        
    }
    public function ChkBday($uid)
    {
        $this->ConTO();
        $out1="";
        if((int)date("n")==1&&(int)date("j")==1)$out1.="Happy New Year! ";
        else if((int)date("n")==2&&(int)date("j")==14)$out1.="Happy Valentine's Day! ";
        else if((int)date("n")==10&&(int)date("j")==31)$out1.="Happy Halloween! ";

        $sql1=mysql_fetch_assoc(mysql_query("select bd8 from login where uid='$uid'"));
        $d1= (int)((strtotime(date(date("Y-")."m-d",strtotime($sql1['bd8'])))-strtotime(date("Y-m-d")))/(60*60*24));
        $d2= (int)((strtotime(date(((int)date("Y")+1)."-m-d"))-strtotime(date("Y-m-d")))/(60*60*24));
        if($d1<0)$d1=$d1+$d2;else $d1=abs($d1);
        $t1=($d1==0)?"Happy Birthday!!":($d1." ".(($d1==1)?"day":"days")." before User's Birthday!");
        $out1.=$t1;
        return $out1;
    }


    function ses_check($user_check){
        $this->ConTO();
        $ses_sql=mysql_query("select username from login where username='$user_check'");
        $row = mysql_fetch_assoc($ses_sql);
        $this->login_session =$row['username'];
        if(!isset($this->login_session))echo '<script>window.location.replace("'.$this->HP.'")</script>';else return true;
            
    }

    public function SavePreftoDB($p,$v){//p=preference,integer1-3;v=valueofuid;
        $this->ConTO();
        $q_Inname="uPDATE `ut_dbase`.`login` SET `pref` = '$p' WHERE `login`.`uid` = $v;";
        mysql_query($q_Inname) or die ("No insert ".mysql_error());echo "Theme saved successfuly";
    }
}

class validation extends DbCon {

    public function pvalid($str1){

        if(!preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z]).*$/", $str1)) {
            $str1= "Password must be at least 8 characters and must be alphanumeric";}
            else $str1= "valid";
        return $str1;
    }

    public function evalid($str1){

        if(!preg_match('/^([a-z0-9]+([_\.\-]{1}[a-z0-9]+)*){1}([@]){1}([a-z0-9]+([_\-]{1}[a-z0-9]+)*)+(([\.]{1}[a-z]{2,6}){0,3}){1}$/i', $str1)) {
            $str1= "Email is not Valid";}
            else $str1= "valid";
        return $str1;
    }

    public function dbhas($str1){
        $this->ConTO();
        $query = mysql_query("select * from login where username='$str1'");
        // echo "select * from login where username='$str1'";echo mysql_num_rows($query);

        if (!(mysql_num_rows($query))) {
            $str1="valid";}
            else $str1="Username has already been taken.";
        return $str1;

    }

    public function d8valid($str1)
    {
        $a1=array();
        if(preg_match('/^\d{4}-\d{1,2}-\d{1,2}$/',$str1)){
            $a1=explode("-", $str1);
            if($a1[0]<1800)$str1="please enter a year greater than 1800";
            elseif (!(checkdate($a1[1], $a1[2], $a1[0]))) 
                $str1="please enter a proper date";
            else $str1="valid";
        }else $str1="Please use a valid format of yyyy-mm-dd";
        return $str1;
    }

    public function newuser($ar){
        $this->ConTO();
        $q_Inname="iNSERT INTO login(`username`,`password`,`fullname`,`add1`,`course`,`bd8`) VALUES ('".$ar[0]."','".$ar[1]."','".$ar[2]."','".$ar[3]."','".$ar[4]."','".$ar[5]."')";
        // echo $q_Inname;
        mysql_query($q_Inname) or die ("No insert");
        $row = mysql_fetch_assoc(mysql_query('sELECT max(uid) as uid FROM `login` WHERE 1'));#echo $row['uid'];
        mkdir('uploads/'.$row['uid']);

    }


}

?>
