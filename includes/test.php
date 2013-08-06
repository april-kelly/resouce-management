<script>
    function showHint(str)
    {
        var xmlhttp;
        if (str.length==0)
        {
            document.getElementById("txtHint").innerHTML="";
            return;
        }
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","./includes/search.php?q="+str,true);
        xmlhttp.send();
    }
</script>

<form action="./search.php" method="get" class="search">
    <input type="hidden" name="p" value="search" />
    <input type="search"
           name="q"
           value="<?php if(isset($_REQUEST['q'])){ echo $_REQUEST['q']; }?>"
           placeholder="Search here!"
           onkeyup="showHint(this.value)"
           autocomplete="off"
        />
    <input type="submit" value=" " />
</form>
<div id="txtHint" >


</div>
