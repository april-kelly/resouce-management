<script>
    function showHint(str)
    {
        var xmlhttp;
        if (str.length==0)
        {
            document.getElementById("search_results").innerHTML="";
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
                document.getElementById("search_results").innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","./includes/search_backend.php?q="+str,true);
        xmlhttp.send();
        var search = document.getElementById("search");
        search.style.width = "800px";
        search.style.padding = "15px";
        search.style.minHeight = "200px";
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
    <input type="button" name="submit" value=" " />
</form>
<div id="search_results" ><!--This is where the search results will be populated--></div>
