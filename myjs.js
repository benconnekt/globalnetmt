var loaded = false ;
var dtField;
var mydatepopupFlag = false;
function setMyDateFlag(flag)
{
        mydatepopupFlag = flag;
}
function datePopup( eP, dtFld )
{
        dtField = dtFld;
        loaded = true;
        var dF = document.all.CalFrame;

        var eL=0;var eT=0;
        //alert('lllll');
        for(var p=eP; p&&p.tagName!='BODY'; p=p.offsetParent){
          eL+=p.offsetLeft;
          eT+=p.offsetTop;
        }

        var eH=eP.offsetHeight;
        var dH=dF.style.pixelHeight;

        var sT=document.body.scrollTop;

        //################## CHANGE BY CHANDRA #######################################################


        var calWidth = 195;
        //for(var i=0;;i++)
        //{
           //alert("in for loop");
           //if(calWidth>(document.body.clientWidth-eL)
           //{
           //    alert("in if eL:"+eL);
           //    eL-=5;
           //}
           //else
           //{
           //    alert("in else");
           //    break;
           //}
        //}

        //################## END OF CHANGE ###########################################################


        dF.style.left=eL;
        //alert('lllll');
        if(eT-dH >= sT && eT+eH+dH > document.body.clientHeight+sT)
          dF.style.top=eT-dH;
        else
          dF.style.top=eT+eH;
        if("none"==dF.style.display)
          dF.style.display="block";

}
document.write("<IFRAME STYLE=\"display:none;position:absolute;width:195;height:255;z-index=100;left:100;top:100\" ID=\"CalFrame\" MARGINHEIGHT=0 MARGINWIDTH=0 NORESIZE FRAMEBORDER=0 SCROLLING=NO SRC=\"cal.htm\" onmouseout=\"document.all.CalFrame.style.display='none';\"></IFRAME> ");
document.write("<SCRIPT FOR=document EVENT='onclick()'>");
document.write("if( document.all.CalFrame && document.all.CalFrame.style.display != 'none' )");
document.write("{");
document.write("                document.all.CalFrame.style.display='none';");
document.write("}");
document.write("</SCRIPT>");



function setDate( dtStr )
{
        if( dtField ) dtField.value = dtStr;
        if(mydatepopupFlag)
        {
                getNoOfNights();
        }
}


function disableAll(obj){
        for(i=0;i<=obj.elements.length-1;i++)
        {
                obj.elements[i].readOnly=true;
                var str = obj.elements[i].type.toLowerCase();
                if (str =="button" || str == "submit" || str=="reset" || str=="select-one"|| str=="select-multiple") obj.elements[i].disabled=true;
                var str1 = trim(obj.elements[i].name.toLowerCase());
                if( str1 == "search_button" || str1 == "text_search")
                {
                        obj.elements[i].disabled=false;
                        obj.elements[i].readOnly=false;
                }
        }
}


// -- script to ensure restriction of special characters


function f_donotallow(s,donotstr,des){
        var ent_str=s.value;
        //var d = String.fromCharCode(window.event.keyCode);
        var i = donotstr.length
        var l = ent_str.length
        var j
        var m
        var k=0
        var p=0
        var str;
        var ent;
        err_Message="";
        has_Error="";
        for (m=0;m<=l;m++){
                for (j = 0;j <= i; j++){
                        str = donotstr.substring(k,j)
                        ent = ent_str.substring(p,m)
                        if (ent == str && str!=""){
                                has_Error="Yes";
                                err_Message = "[" +donotstr + " ... "+des;
                                s.focus();
                        }
                        k = j
                }
                p = m
        }
        has_Error=err_Message;
        return has_Error;
}


// ---  This is for the right top searches on the pages
function searchsubmit(frm, requrl)
{
frm.action="/gds/"+requrl;
frm.hidden_Action.value="activate";
frm.submit();
}

// --- This is for getting result of a particular page number --- Search
function nextfun(frm, pgno, searchfield, requrl)
{
        if(searchfield=='1')
        {
                frm.text_search.value=frm.text_search1.value;
                frm.Search_PageNo.value='1';
                if(frm.fac_type!=null)
                {
                        if(frm.fac_type.options[frm.fac_type.selectedIndex].value=="0")
                                frm.userwhereclause.value=" ";
                        else
                                frm.userwhereclause.value="and (UPPER(fac_type) = UPPER('"+frm.fac_type.options[frm.fac_type.selectedIndex].value+"'))";
                }
        }
        else
        {
                if(pgno!="")
                        frm.Search_PageNo.value=pgno;
                else
                        frm.Search_PageNo.value=frm.goselect.options[frm.goselect.selectedIndex].value;
        }
        frm.action=requrl;
        frm.submit();
}

function isTelephone(st,des)
{
        var validchars="0123456789()-";
        var str = st.value;
        var ch;
        has_Error = "";
        err_Message="";

        for(var i=0 ; i<str.length ; i++)
        {
                ch=str.charAt(i)
                if ((validchars.indexOf(ch))==-1)
                {
                        has_Error = "Yes";
                        err_Message = des + " ... ";
                        st.focus();
                        st.select();
                        break;
                }
        }
        return err_Message;
}

function ltrim ( s )
{
        return s.replace( /^\s*/, "" )
}


function rtrim ( s )
{
        return s.replace( /\s*$/, "" );
}


function trim ( s )
{
        return rtrim(ltrim(s));
}


//function for checking only numbers

function check_number(s,des)
{
        str = trim(s.value);
        check_str="1234567890";
        err_Message="";

        for(i=0;i < str.length;i++)
        {
                if(check_str.indexOf(str.charAt(i))==-1)
                {
                        has_Error="Yes";
                        err_Message = des  + " (must be a number only.) ";
                        s.focus();
                        s.select();
                }
        }
        return err_Message;
}

function f_Required ( s,des ) {
        has_Error="";
        err_Message="";
        s.value=trim(s.value);
        if (trim(s.value)=="") {
           has_Error="Yes";
            err_Message = des + " ..." ;
             s.focus()
        }
        return err_Message;
}

function f_Upper (s){
        var x = s.value;
        err_Message="";
        x=x.toUpperCase();
        s.value=trim(x);
        return x.toUpperCase();
}

function f_Number (s,des){

        s.value=trim(s.value);
        var x = s.value;
        err_Message="";
        has_Error="";
        if (isNaN(x)==true) {
           has_Error="Yes";
           err_Message = des  + " ... ";
           s.focus();
        }
        return err_Message;
}

function f_Minlen (s,l,des){

        s.value=trim(s.value);

        var x = s.value;
        has_Error="";
        err_Message="";
        if (x.length < l)  {
           has_Error="Yes";
           err_Message = l + " " + des + " (Min chars)";
           s.focus();
        }
        return err_Message;
}


function f_range (s,des,xmin,xmax){
        s.value=trim(s.value);
        var x = s.value;
        has_Error="";
        if (x<xmin || x>xmax) {
           has_Error="Yes";
           err_Message =   " ( Range is ) " + des +  xmin + " - " + xmax ;
           s.focus();
        }
        return err_Message;
}


// ************************** email validation


/* 1.1.2: Fixed a bug where trailing . in e-mail address was passing
            (the bug is actually in the weak regexp engine of the browser; I
            simplified the regexps to make it work).
   1.1.1: Removed restriction that countries must be preceded by a domain,
            so abc@host.uk is now legal.  However, there's still the
            restriction that an address must end in a two or three letter
            word.
     1.1: Rewrote most of the function to conform more closely to RFC 822.
     1.0: Original  */

function f_Email (emailStr) {
   has_Error="";

if (trim(emailStr)=="")  //  null entry is OK
{
   return has_Error;
}
/* The following pattern is used to check if the entered e-mail address
   fits the user@domain format.  It also is used to separate the username
   from the domain. */
var emailPat=/^(.+)@(.+)$/
/* The following string represents the pattern for matching all special
   characters.  We don't want to allow special characters in the address.
   These characters include ( ) < > @ , ; : \ " . [ ]    */
var specialChars="\\(\\)<>@,;:\\\\\\\"\\.\\[\\]"
/* The following string represents the range of characters allowed in a
   username or domainname.  It really states which chars aren't allowed. */
var validChars="\[^\\s" + specialChars + "\]"
/* The following pattern applies if the "user" is a quoted string (in
   which case, there are no rules about which characters are allowed
   and which aren't; anything goes).  E.g. "jiminy cricket"@disney.com
   is a legal e-mail address. */
var quotedUser="(\"[^\"]*\")"
/* The following pattern applies for domains that are IP addresses,
   rather than symbolic names.  E.g. joe@[123.124.233.4] is a legal
   e-mail address. NOTE: The square brackets are required. */
var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/
/* The following string represents an atom (basically a series of
   non-special characters.) */
var atom=validChars + '+'
/* The following string represents one word in the typical username.
   For example, in john.doe@somewhere.com, john and doe are words.
   Basically, a word is either an atom or quoted string. */
var word="(" + atom + "|" + quotedUser + ")"
// The following pattern describes the structure of the user
var userPat=new RegExp("^" + word + "(\\." + word + ")*$")
/* The following pattern describes the structure of a normal symbolic
   domain, as opposed to ipDomainPat, shown above. */
var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$")


/* Finally, let's start trying to figure out if the supplied address is
   valid. */

/* Begin with the coarse pattern to simply break up user@domain into
   different pieces that are easy to analyze. */
var matchArray=emailStr.match(emailPat)
if (matchArray==null) {
  /* Too many/few @'s or something; basically, this address doesn't
     even fit the general mould of a valid e-mail address. */
        has_Error = ("Email address seems incorrect (check @ and .'s)")
        return has_Error
}
var user=matchArray[1]
var domain=matchArray[2]

// See if "user" is valid
if (user.match(userPat)==null) {
    // user is not valid
    has_Error =("The username doesn't seem to be valid.")
    return has_Error
}

/* if the e-mail address is at an IP address (as opposed to a symbolic
   host name) make sure the IP address is valid. */
var IPArray=domain.match(ipDomainPat)
if (IPArray!=null) {
    // this is an IP address
          for (var i=1;i<=4;i++) {
            if (IPArray[i]>255) {
                has_Error =("Destination IP address is invalid!")
                return has_Error
            }
    }
    return has_Error
}

// Domain is symbolic name
var domainArray=domain.match(domainPat)
if (domainArray==null) {
    has_Error =("The domain name doesn't seem to be valid.")
    return has_Error
}

/* domain name seems valid, but now make sure that it ends in a
   three-letter word (like com, edu, gov) or a two-letter word,
   representing country (uk, nl), and that there's a hostname preceding
   the domain or country. */

/* Now we need to break up the domain to get a count of how many atoms
   it consists of. */
var atomPat=new RegExp(atom,"g")
var domArr=domain.match(atomPat)
var len=domArr.length
if (domArr[domArr.length-1].length<2 ||
    domArr[domArr.length-1].length>3) {
   // the address must end in a two letter or three letter word.
   has_Error =("The address must end in a three-letter domain, or two letter country.")
   return has_Error
}

// Make sure there's a host name preceding the domain.
if (len<2) {
   var errStr="This address is missing a hostname!"
   has_Error =(errStr)
   return has_Error
}

// If we've gotten this far, everything's valid!
return has_Error
}
// ***************************

function f_Date(objName,des) {
var datefield = objName;
has_Error="";
var temp=datefield.value;
if (temp.length == 0) {
        return has_Error;
}

if (temp.length < 6) {
        has_Error= (des+" (Date format is mm/dd/yy )");
        datefield.focus();
        return has_Error;
}
if (temp.length >10) {
        has_Error= (des+" (Date format is mm/dd/yy )");
        datefield.focus();
        return has_Error;
}
if (chkdate(objName) == false) {
datefield.select();
has_Error=("That date is invalid.  Please try again.");
datefield.focus();
return has_Error;
}
else {
return has_Error;
   }
}

function f_date(objName,des) {
var datefield = objName;
has_Error="";
var temp=datefield.value;
if (temp.length == 0) {
        has_Error= (des);
        datefield.focus();
        return has_Error;
}

if (temp.length < 6) {
        has_Error= (des);
        datefield.focus();
        return has_Error;
}
if (temp.length > 10) {
        has_Error= (des);
        datefield.focus();
        return has_Error;
}

if (chkdate(objName) == false) {
datefield.select();
has_Error=(des);
datefield.focus();
return has_Error;
}
else {
return has_Error;
   }
}




function chkdate(objName) {
var strDatestyle = "US"; //United States date style
//var strDatestyle = "EU";  //European date style
var strDate;
var strDateArray;
var strDay;
var strMonth;
var strYear;
var intday;
var intMonth;
var intYear;
var booFound = false;
var datefield = objName;
var strSeparatorArray = new Array("-"," ","/",".");
var intElementNr;
var err = 0;
var strMonthArray = new Array(12);
strMonthArray[0] = "Jan";
strMonthArray[1] = "Feb";
strMonthArray[2] = "Mar";
strMonthArray[3] = "Apr";
strMonthArray[4] = "May";
strMonthArray[5] = "Jun";
strMonthArray[6] = "Jul";
strMonthArray[7] = "Aug";
strMonthArray[8] = "Sep";
strMonthArray[9] = "Oct";
strMonthArray[10] = "Nov";
strMonthArray[11] = "Dec";
strDate = datefield.value;
if (strDate.length < 1) {
return true;
}
for (intElementNr = 0; intElementNr < strSeparatorArray.length; intElementNr++) {
if (strDate.indexOf(strSeparatorArray[intElementNr]) != -1) {
strDateArray = strDate.split(strSeparatorArray[intElementNr]);
if (strDateArray.length != 3) {
err = 1;
return false;
}
else {
strDay = strDateArray[0];
strMonth = strDateArray[1];
strYear = strDateArray[2];
}
booFound = true;
   }
}
if (booFound == false) {
if (strDate.length>5) {
strDay = strDate.substr(0, 2);
strMonth = strDate.substr(2, 2);
strYear = strDate.substr(4);
   }
}
if (strYear.length == 2) {
strYear = '20' + strYear;
}
// US style
if (strDatestyle == "US") {
strTemp = strDay;
strDay = strMonth;
strMonth = strTemp;
}
intday = parseInt(strDay, 10);
if (isNaN(intday)) {
err = 2;
return false;
}
intMonth = parseInt(strMonth, 10);
if (isNaN(intMonth)) {
for (i = 0;i<12;i++) {
if (strMonth.toUpperCase() == strMonthArray[i].toUpperCase()) {
intMonth = i+1;
strMonth = strMonthArray[i];
i = 12;
   }
}
if (isNaN(intMonth)) {
err = 3;
return false;
   }
}
intYear = parseInt(strYear, 10);
if (isNaN(intYear)) {
err = 4;
return false;
}
if (intMonth>12 || intMonth<1) {
err = 5;
return false;
}
if ((intMonth == 1 || intMonth == 3 || intMonth == 5 || intMonth == 7 || intMonth == 8 || intMonth == 10 || intMonth == 12) && (intday > 31 || intday < 1)) {
err = 6;
return false;
}
if ((intMonth == 4 || intMonth == 6 || intMonth == 9 || intMonth == 11) && (intday > 30 || intday < 1)) {
err = 7;
return false;
}
if (intMonth == 2) {
if (intday < 1) {
err = 8;
return false;
}
if (LeapYear(intYear) == true) {
if (intday > 29) {
err = 9;
return false;
}
}
else {
if (intday > 28) {
err = 10;
return false;
}
}
}
if (strDatestyle == "US") {
//############## COMMENTED BY CHANDRA #####################
//datefield.value = strMonthArray[intMonth-1] + " " + intday+" " + strYear;
}
else {
//############## COMMENTED BY CHANDRA #####################
//datefield.value = intday + " " + strMonthArray[intMonth-1] + " " + strYear;
}
return true;
}
function LeapYear(intYear) {
if (intYear % 100 == 0) {
if (intYear % 400 == 0) { return true; }
}
else {
if ((intYear % 4) == 0) { return true; }
}
return false;
}
function doDateCheck(from, to) {
if (Date.parse(from.value) <= Date.parse(to.value)) {
alert("The dates are valid.");
}
else {
if (from.value == "" || to.value == "")
alert("Both dates must be entered.");
else
alert("To date must occur after the from date.");
   }
}
//  End -->
// **********************

// The following block of scripts are added by nayeem/SoftwareEngineer b2bSoftware Technologies on 09/03/2002
// All the scripts are preceded by the description

/*********************************************************
*  chkFloat:        function for Float fields.
*  passObj :        name of the control.
*  fieldName:        label name of the control./ Value to be displayed in alert message
*  beforeDeci:        nos of digits before decimal point
*  afterDeci:        nos of digit after decimal point
*  returnvalue:        boolean
**********************************************************/
function chkFloat(passObj,fieldName,beforeDeci,afterDeci)
{
        beforeDecis='';
        for(i=0;i<beforeDeci;i++)
        beforeDecis=beforeDecis+'9';
        afterDecis='';
        for(i=0;i<afterDeci;i++)
        afterDecis=afterDecis+'9';

    passVal = trim(passObj.value);

    valLen = passVal.length;
    flag=0;
    for( var i = 0; i < valLen; i++)
    {
                if (passVal.charAt(i)=='.')
        {
             if (flag==0)
             {
               flag=1;
             }
                        else
                        {
                                alert('Enter a Valid ' + fieldName);
                                passObj.focus();
                                passObj.select();
                                return false;
                        }
                }//if
                else if(!(passVal.charAt(i)>='0' && passVal.charAt(i)<='9'))
                {
                    alert('Enter a Valid ' + fieldName);
                    passObj.focus();
                    passObj.select();
                    return false;
                }//else if
        }//for

        if (passVal.charAt(passVal.length-1)=='.')
        {
                   alert('Enter a correct value for '+fieldName);
                   passObj.focus();
                   return false;
        }


        var i=0;
        var cnt=0;
        for(i=0;i<passVal.length;i++)
        {
          if(passVal.charAt(i)=='.') break;
          cnt++;
        }

        if (cnt>beforeDeci)
        {
            alert(fieldName+' format is '+beforeDecis+'.'+afterDecis);
            passObj.focus();
            return false;
        }

        cnt=0;
        for(j=i+1;j<passVal.length;j++)
        {
          cnt++;
        }

        if (cnt>afterDeci)
        {
            alert(fieldName+' format is '+beforeDecis+'.'+afterDecis);
            passObj.focus();
            return false;
        }

        return true;

}//chkFloat


/*********************************************************
*  SpecialCharValid:function for checking special characters.
*  passObj :                name of the control.
*  returnvalue:                boolean
**********************************************************/
/*function checkemail(passObj)
{

  var result = "false";
  var email=passObj.value;
  var theStr = new String(email)
  var index = theStr.indexOf("@");
  if (index > 0)
  {
    var pindex = theStr.indexOf(".",index);
    if ((pindex > index+1) && (theStr.length > pindex+1))
        result = "true";
  }
 if(result=="false")
 {
 alert("Please enter a complete email address in the form: yourname@yourdomain.com");
 passObj.focus();
 return;

}
} */

function SpecialCharValid(passObj){
        //alert('Inside special');
        url =trim(passObj.value);
        o = 0;
                if ( url.length!=0) {
                        a = url.indexOf('@');
                    a1 = url.indexOf('!');
                    a2 = url.indexOf('#');
                    a3 = url.indexOf('$');
                    a4 = url.indexOf('%');
                    a5 = url.indexOf('^');
                    a6 = url.indexOf('&');
                    a7 = url.indexOf('$');
                    a8 = url.indexOf('*');
                    a9 = url.indexOf('(');
                    a10 = url.indexOf(')');
                    a11 = url.indexOf('+');
                    a12 = url.indexOf('=');
                    a13 = url.indexOf('-');
                    a14 = url.indexOf('~');
                    a15 = url.indexOf('`');
                    a16 = url.indexOf(';');
                    a17 = url.indexOf(',');
                    a18 = url.indexOf('{');
                    a19 = url.indexOf('}');
                    a20 = url.indexOf('?');
                    b = url.indexOf('.');
                    c = url.indexOf(':');
                    d = url.indexOf('/');
                    h = url.indexOf('[');
                    i = url.indexOf(']');
                    j = url.indexOf('<');
                    k = url.indexOf('>');
                    o = 0;
                    if (a != -1) {o++};
                    if (b != -1) {o++};
                    if (a1 != -1) {o++};
                    if (a2 != -1) {o++};
                    if (a3 != -1) {o++};
                    if (a4 != -1) {o++};
                    if (a5 != -1) {o++};
                    if (a6 != -1) {o++};
                    if (a7 != -1) {o++};
                    if (a8 != -1) {o++};
                    if (a9 != -1) {o++};
                    if (a10 != -1) {o++};
                    if (a11 != -1) {o++};
                    if (a12 != -1) {o++};
                    if (a13 != -1) {o++};
                    if (a14 != -1) {o++};
                    if (a15 != -1) {o++};
                    if (a16 != -1) {o++};
                    if (a17 != -1) {o++};
                    if (a18 != -1) {o++};
                    if (a19 != -1) {o++};
                    if (a20 != -1) {o++};
                        if(b!=-1){o++};
                    if (c != -1) {o++};
                    if (d != -1) {o++};
                    if (h != -1) {o++};
                    if (i != -1) {o++};
                    if (j != -1) {o++};
                    if (k != -1) {o++};
                    if (o != 0) {
                        alert('Special Characters not allowed !');
                                passObj.focus();
                        return false;
                    }
                    else{
                                return true;
                        }
        }
return true;
}//SpecialCharValid




/*********************************************************
*  SpecialCharValid:function for checking special characters.
*  passObj :                name of the control.
*  returnvalue:                boolean
**********************************************************/
function SpecialCharValidNames(passObj){
//        alert('Inside special character valid mobile ......');
        url =trim(passObj.value);
        o = 0;
                if ( url.length!=0) {
                        a = url.indexOf('@');
                    a1 = url.indexOf('!');
                    a2 = url.indexOf('#');
                    a3 = url.indexOf('$');
                    a4 = url.indexOf('%');
                    a5 = url.indexOf('^');
                    a7 = url.indexOf('$');
                    a8 = url.indexOf('*');
                    a11 = url.indexOf('+');
                    a12 = url.indexOf('=');
                    a14 = url.indexOf('~');
                    a15 = url.indexOf('`');
                    a16 = url.indexOf(';');
                    a17 = url.indexOf(',');
                    a18 = url.indexOf('{');
                    a19 = url.indexOf('}');
                    a20 = url.indexOf('?');
                    c = url.indexOf(':');
                    d = url.indexOf('/');
                    h = url.indexOf('[');
                    i = url.indexOf(']');
                    j = url.indexOf('<');
                    k = url.indexOf('>');
                    o = 0;
                    if (a != -1) {o++};
                    if (a1 != -1) {o++};
                    if (a2 != -1) {o++};
                    if (a3 != -1) {o++};
                    if (a4 != -1) {o++};
                    if (a5 != -1) {o++};
                    if (a7 != -1) {o++};
                    if (a8 != -1) {o++};
                    if (a11 != -1) {o++};
                    if (a12 != -1) {o++};
                    if (a14 != -1) {o++};
                    if (a15 != -1) {o++};
                    if (a16 != -1) {o++};
                    if (a17 != -1) {o++};
                    if (a18 != -1) {o++};
                    if (a19 != -1) {o++};
                    if (a20 != -1) {o++};
                    if (c != -1) {o++};
                    if (d != -1) {o++};
                    if (h != -1) {o++};
                    if (i != -1) {o++};
                    if (j != -1) {o++};
                    if (k != -1) {o++};
                    if (o != 0) {
                        alert('Special characters not allowed');
                                passObj.focus();
                        return false;
                    }
                    else{
                                return true;
                        }
        }
return true;
}//SpecialCharValid


/*********************************************************
*  validDeciaml: function to check decimal value entered is valid or not
*  passObj :        name of the control.
*  returnvalue:        boolean
**********************************************************/
function validDecimal(passObj)
{
        passVal = passObj.value;
        no_of_decimals = 0;
        for(i=0;i<passVal.length;i++)
        {
                j=i+1;
                if(passVal.substring(i,j)==".")
                        no_of_decimals++;
        }
        if(no_of_decimals <= 1)
        {
                return true
        }
        else
        {
                alert("Not a valid decimal");
                passObj.focus();
                return false;
        }
}// validDecimal

/*********************************************************
*  NoSpecials: function to check weather the value contains only numerics and a decimal
*  passObj :        name of the control.
*  returnvalue:        boolean
**********************************************************/
function NoSpecials(Obj)
{
var checkOK="1234567890.";
var checkStr =trim(Obj.value);
var allValid = true;
for (i = 0;  i < checkStr.length;  i++)
{
ch = checkStr.charAt(i);
for (j = 0;  j < checkOK.length;  j++)
if (ch == checkOK.charAt(j))
break;
if (j == checkOK.length)
{
allValid = false;
break;
}
}
if (!allValid)
{
alert("Enter valid value.");
Obj.focus();
return (false);
}
else
        {
        return (true);
        }
}        //NoSpecials



/*********************************************************
*  chkBlank:        function to check empty fields
*  passObj :        name of the control.
*  name:                label name of the control.
*  returnvalue:        boolean
**********************************************************/
function chkBlank(passObj,name)
{
   passVal = passObj.value;
   //if the textbox field is empty then an alert box appears
   if ((passVal.length ==0) || (passVal == null))
   {
        alert("Enter value for  "+ name);
        passObj.focus();
        return false
   }
   else
   {

      //if the textbox is entered only with spaces then an alert box appears
      for( i =0; i<passVal.length; i++)
      {
          j = i + 1;
          if(passVal.substring(i,j) != " ")
            return true;
      }

      if(i == passVal.length)
      {
          alert("Enter value for " +name);
          passObj.value="";
          passObj.focus();
          return false;
      }

    }
   return true;
}//chkBlank


/*********************************************************
*  trimSpaces:        function for trimming spaces.
*  field:                value to be trimmed.
*  returnvalue:        trimmed value
**********************************************************/
function trimSpaces(field){
        trimString=trim(field);
        return trimString;
}//trimSpaces


/*********************************************************
*  trim:                trimming spaces and alt255's.
*  string1 :        value to be trimmed.
*  returnvalue:        trimmed value
**********************************************************/
function trim(string1)
{
//                alert('Inside the function trim >>> The string is >>> ' + string1);
        var len=string1.length
        var copystring
        var out_printWriterputstring
        var count=0
        var count1=string1.length
        var len1=string1.length
//        alert('The length is ' + len1);
        var lcount=0
        var rcount=string1.length
        //alert(rcount);
        for(var i=0;i<len1;i++)
        {
                                //alert(string1.charAt(i));
                if(string1.charAt(i)==" " || string1.charAt(i)==" ")
                {
                                    lcount++
                                }
                else
                    break;
        }//for

        for(var j=len1-1;j>0;j--)
        {
                if(string1.charAt(j)==" " || string1.charAt(j)==" ")
                {
                                   rcount--
                                }
                else
                    break;
        }//for
        var trimstring='';
        if(rcount>lcount)
                        trimstring=string1.substring(lcount,rcount)
        return trimstring
}//trim


/*********************************************************
*  chkInt:                function for integer fields.
*  passObj :        name of the control.
*  fieldName:        label name of the control.
*  returnvalue:        boolean
**********************************************************/
function chkInt(passObj,fieldName)
{
        passVal = trim(passObj.value);
    valLen = passVal.length;
    for( var i = 0; i < valLen; i++)
    {
            if( isNaN( parseInt(passVal.charAt(i))))
                 {
                alert("Enter a Valid " + fieldName);
                passObj.focus();
                passObj.select();
                return false;
                }//if
        }//for
    return true;
}//chkInt


/*********************************************************
*  chkQuantity:        function to check quantity fields.
*  passObj :        name of the control.
*  returnvalue:        boolean
**********************************************************/
function chkQuantity(passObj)
{
        passVal = trim(passObj.value);
    valLen = passVal.length;
        if(valLen<1){
            alert("Enter Quantity");
            passObj.focus();
            return false;
        }//if

        if(!chkInt(passObj,"Quantity")){
            return false;
        }//if

        if(passVal<1){
            alert("Enter valid Quantity");
            passObj.focus();
            return false;
        }//if
        return true;
}//        chkQuantity


/*********************************************************
*  SpaceValidation:        function to check weather value contains any spaces or not
*  passObj :        name of the control.
*  returnvalue:        boolean true if spaces exists / false if don't
**********************************************************/
function SpaceValidation(passObj){
        //alert('Inside special');
        url =trim(passObj.value);
        o = 0;
                if ( url.length!=0) {
                        a = url.indexOf(' ');
                    o = 0;
                    if (a != -1) {o++};
                    if (o != 0) {
                        alert('Cannot contain blank spaces!');
                                passObj.focus();
                        return false;
                    }
                    else{
                                return true;
                        }
        }
return true;
}//SpaceValidation




/*********************************************************
*  SpecialCharValid:function for checking special characters.
*  passObj :                name of the control.
*  returnvalue:                boolean
* doesnot allow all the charecters except hyphen(-)
**********************************************************/
function SpecialCharValid1(passObj){
        //alert('Inside special');
        url =trim(passObj.value);
        o = 0;
                if ( url.length!=0) {
                        a = url.indexOf('@');
                    a1 = url.indexOf('!');
                    a2 = url.indexOf('#');
                    a3 = url.indexOf('$');
                    a4 = url.indexOf('%');
                    a5 = url.indexOf('^');
                    a6 = url.indexOf('&');
                    a7 = url.indexOf('$');
                    a8 = url.indexOf('*');
                    a9 = url.indexOf('(');
                    a10 = url.indexOf(')');
                    a11 = url.indexOf('+');
                    a12 = url.indexOf('=');
                  //  a13 = url.indexOf('-');
                    a14 = url.indexOf('~');
                    a15 = url.indexOf('`');
                    a16 = url.indexOf(';');
                    a17 = url.indexOf(',');
                    a18 = url.indexOf('{');
                    a19 = url.indexOf('}');
                    a20 = url.indexOf('?');
                    b = url.indexOf('.');
                    c = url.indexOf(':');
                    d = url.indexOf('/');
                    h = url.indexOf('[');
                    i = url.indexOf(']');
                    j = url.indexOf('<');
                    k = url.indexOf('>');
                    o = 0;
                    if (a != -1) {o++};
                    if (b != -1) {o++};
                    if (a1 != -1) {o++};
                    if (a2 != -1) {o++};
                    if (a3 != -1) {o++};
                    if (a4 != -1) {o++};
                    if (a5 != -1) {o++};
                    if (a6 != -1) {o++};
                    if (a7 != -1) {o++};
                    if (a8 != -1) {o++};
                    if (a9 != -1) {o++};
                    if (a10 != -1) {o++};
                    if (a11 != -1) {o++};
                    if (a12 != -1) {o++};
                  //  if (a13 != -1) {o++};
                    if (a14 != -1) {o++};
                    if (a15 != -1) {o++};
                    if (a16 != -1) {o++};
                    if (a17 != -1) {o++};
                    if (a18 != -1) {o++};
                    if (a19 != -1) {o++};
                    if (a20 != -1) {o++};
                    if (c != -1) {o++};
                    if (d != -1) {o++};
                    if (h != -1) {o++};
                    if (i != -1) {o++};
                    if (j != -1) {o++};
                    if (k != -1) {o++};
                    if (o != 0) {
                        alert('Special Characters not allowed !');
                                passObj.focus();
                        return false;
                    }
                    else{
                                return true;
                        }
        }
return true;
}//SpecialCharValid


var isIE = document.all?true:false;
var isNS = document.layers?true:false;
var IS_PERIOD=46;
var PERIOD_TYPED=false;

function onlyDigits(e) {
  var _ret = true;
  if (isIE) {
    if (window.event.keyCode == IS_PERIOD) {
          if (!PERIOD_TYPED) {
            PERIOD_TYPED=true;
          } else {
            window.event.keyCode=0;
            _ret = false;
          }
        }
    if (window.event.keyCode < 46 || window.event.keyCode > 57) {
      window.event.keyCode = 0;
      _ret = false;
    }
  }
  if (isNS) {
    if (e.which == IS_PERIOD) {
          if (!PERIOD_TYPED) {
            PERIOD_TYPED=true;
          } else {
            e.which=0;
            _ret = false;
          }
        }
    if (e.which < 46 || e.which > 57) {
      e.which = 0;
      _ret = false;
    }
  }
  return (_ret);
}


/*********************************************************
*  checkdate:function to check the date validity
*  tVal :                date value to check
*  returnvalue:                boolean
* function to check the date validity of format dd/mm/yyyy
**********************************************************/
function checkdateDMY(tVal)
        {
        var err=0;
        var psj=0;
        a=tVal;
        var errmsg="";
        if (a.length < 10 || a.length > 10 )
        {
                err = 1 ;
                errmsg="";
        }
        dp1 = a.substring(0,1);
        if (dp1!=0 && dp1!=1 && dp1!=2 && dp1!=3 && dp1!=4 && dp1!=5 && dp1!=6 && dp1!=7 && dp1!=8 && dp1!=9) err = 1;
        dp1 = a.substring(1, 2);
        if (dp1!=0 && dp1!=1 && dp1!=2 && dp1!=3 && dp1!=4 && dp1!=5 && dp1!=6 && dp1!=7 && dp1!=8 && dp1!=9) err = 1;
           dp1 = a.substring(3, 4);
        if (dp1!=0 && dp1!=1 && dp1!=2 && dp1!=3 && dp1!=4 && dp1!=5 && dp1!=6 && dp1!=7 && dp1!=8 && dp1!=9) err = 1;
        dp1 = a.substring(4, 5);
        if (dp1!=0 && dp1!=1 && dp1!=2 && dp1!=3 && dp1!=4 && dp1!=5 && dp1!=6 && dp1!=7 && dp1!=8 && dp1!=9) err = 1;
        dp1 = a.substring(6, 7);
        if (dp1!=0 && dp1!=1 && dp1!=2 && dp1!=3 && dp1!=4 && dp1!=5 && dp1!=6 && dp1!=7 && dp1!=8 && dp1!=9) err = 1;
        dp1 = a.substring(7, 8);
        if (dp1!=0 && dp1!=1 && dp1!=2 && dp1!=3 && dp1!=4 && dp1!=5 && dp1!=6 && dp1!=7 && dp1!=8 && dp1!=9) err = 1;
        dp1 = a.substring(8, 9);
        if (dp1!=0 && dp1!=1 && dp1!=2 && dp1!=3 && dp1!=4 && dp1!=5 && dp1!=6 && dp1!=7 && dp1!=8 && dp1!=9) err = 1;
        dp1 = a.substring(9, 10);
        if (dp1!=0 && dp1!=1 && dp1!=2 && dp1!=3 && dp1!=4 && dp1!=5 && dp1!=6 && dp1!=7 && dp1!=8 && dp1!=9) err = 1;

        b = a.substring(3, 5);  // month
        c = a.substring(2, 3);  // '/'
        d = a.substring(0, 2);  // day
        e = a.substring(5, 6);  // '/'
        f = a.substring(6, 10);  // year
        if (d.indexOf("/") != -1)
            { err = 1;
                errmsg='Invalid Day'; }
        else
                {
                if (d<1 || d>31)
                    { err = 1;
                        errmsg="Error in day"; }
                else        {
                if (b.indexOf("/") != -1)
                        errmsg='Invalid Month';
                else        {
                if (b<1 || b>12)
                        { err = 1 ;
                        errmsg="Error in Month";}
                else        {
                if (f.indexOf("/") != -1)
                        errmsg='Invalid Year';
                        {
                if (f.length < 4 || f.length > 4)
                        { err=1; errmsg="Error in Year"; }
                }}}}}
        //basic error checking
                if (c != '/') err = 1;
                if (e != '/') err = 1;
                //
                //advanced error checking
                // months with 30 days
                if (b==4 || b==6 || b==9 || b==11)
                {
                if (d==31)
                        err=1;
                }        // february, leap year
                if (b==2){                // feb
                var g=parseInt(f/4)
                if (isNaN(g))
                {
                err=1;
                }
                if (d>29)
                        err=1;
                if (d==29 && ((f/4)!=parseInt(f/4)))
                        err=1;
                }
                if (err==1){
                alert('Please enter valid date!(eg:DD/MM/YYYY)');
                //d2dLSPProUpdAd.txtEstSince.focus();
                //document.indent_first.consweekst.focus();
                return false;

}
var dd = tVal.substring(0,2);
var dm = tVal.substring(3,5);
var dy = tVal.substring(6,10);
var tDate=dm +"/"+ dd +"/"+ dy;
var today1 = new Date(tDate);
/*var td1 = today1.getDay();

if(td1 == 1)
{

}
else
{
alert("Please Enter Monday Date ...");
//document.wetnewindent.ob_cons_start.focus();
return false;
}*/

var d=parseInt(tVal.substring(0,2) * 1);
var m=parseInt(tVal.substring(3,5));
var y=parseInt(tVal.substring(6,10) );

var sm = tVal.substring(3,5);
if(sm=="08")
        {
        m = parseInt("8");
        }
if(sm=="09")
        {
        m = parseInt("9");
        }

if(((y%4)==0) && ((y%100)!=0))
                {
                        var max = new Array(31,29,31,30,31,30,31,31,30,31,30,31);
                }
                else
                {
                        var max = new Array(31,28,31,30,31,30,31,31,30,31,30,31);
                }
                d=d+6;
                while(d > max[m-1]) { d=d-max[m-1]; m++; }
                while(m > 12) { m=m-12; y++; }
                var dd,mm,yy;
                if(d<10)
                {
                dd="0"+d;
                }
                else
                {
                        dd=d;
                }
                if(m<10)
                {
                mm="0"+m;
                }
                else
                {
                        mm=m;
                }
                yyyy=y;
                var plsix = dd+"/"+mm+"/"+yyyy;
//                document.wetnewindent.ob_cons_end.value = plsix;
return true;
}

/*********************************************************
*  checkdate:function to check the date validity
*  tVal :                date value to check
*  returnvalue:                boolean
* function to check the date validity of format mm/dd/yyyy
**********************************************************/
function checkdateMDY(tVal)
        {


/////////////////////////////////
/*   var mm = "";
   var dd = "";

   var mon = tVal.substring(1,2);
   if(mon=="/")
        {
                mm = tVal.substring(0,1);
                day = tVal.substring(3,4);
                if(day=="/")
                {
                        dd = tVal.substring(2,3);
                }
                else
                {
                        dd = tVal.substring(2,4);
                }
        }
        else
        {
                mm = tVal.substring(0,2);
                day = tVal.substring(4,5);
                if(day=="/")
                {
                        dd = tVal.substring(3,4);
                }
                else
                {
                        dd = tVal.substring(3,5);
                }
        }

var temp_date = "";
if(mm.length == 1)
        temp_date = "0" + mm +"/";
else
        temp_date = mm+"/";

if(dd.length == 1)
        temp_date = temp_date + "0" + dd + "/";
else
        temp_date = temp_date + dd + "/";

temp_date = temp_date + tVal.substring((tVal.length-4),tVal.length)

alert(temp_date);

tVal = temp_date;

//////////////////////

        var err=0;
        var psj=0;
        a=tVal;
        var errmsg="";
        if (a.length < 8 || a.length > 10 )
        {
                err = 1 ;
                errmsg="";
        }

        dp1 = a.substring(0,1);
        if (dp1!=0 && dp1!=1 && dp1!=2 && dp1!=3 && dp1!=4 && dp1!=5 && dp1!=6 && dp1!=7 && dp1!=8 && dp1!=9) err = 1;
        dp1 = a.substring(1, 2);
        if (dp1!=0 && dp1!=1 && dp1!=2 && dp1!=3 && dp1!=4 && dp1!=5 && dp1!=6 && dp1!=7 && dp1!=8 && dp1!=9) err = 1;
           dp1 = a.substring(3, 4);
        if (dp1!=0 && dp1!=1 && dp1!=2 && dp1!=3 && dp1!=4 && dp1!=5 && dp1!=6 && dp1!=7 && dp1!=8 && dp1!=9) err = 1;
        dp1 = a.substring(4, 5);
        if (dp1!=0 && dp1!=1 && dp1!=2 && dp1!=3 && dp1!=4 && dp1!=5 && dp1!=6 && dp1!=7 && dp1!=8 && dp1!=9) err = 1;
        dp1 = a.substring(6, 7);
        if (dp1!=0 && dp1!=1 && dp1!=2 && dp1!=3 && dp1!=4 && dp1!=5 && dp1!=6 && dp1!=7 && dp1!=8 && dp1!=9) err = 1;
        dp1 = a.substring(7, 8);
        if (dp1!=0 && dp1!=1 && dp1!=2 && dp1!=3 && dp1!=4 && dp1!=5 && dp1!=6 && dp1!=7 && dp1!=8 && dp1!=9) err = 1;
        dp1 = a.substring(8, 9);
        if (dp1!=0 && dp1!=1 && dp1!=2 && dp1!=3 && dp1!=4 && dp1!=5 && dp1!=6 && dp1!=7 && dp1!=8 && dp1!=9) err = 1;
        dp1 = a.substring(9, 10);
        if (dp1!=0 && dp1!=1 && dp1!=2 && dp1!=3 && dp1!=4 && dp1!=5 && dp1!=6 && dp1!=7 && dp1!=8 && dp1!=9) err = 1;

        b = a.substring(0, 2);  // month
        c = a.substring(2, 3);  // '/'
        d = a.substring(3, 5);  // day
        e = a.substring(5, 6);  // '/'
        f = a.substring(6, 10);  // year
        if (d.indexOf("/") != -1)
            { err = 1;
                errmsg='Invalid Day'; }
        else
                {
                if (d<1 || d>31)
                    { err = 1;
                        errmsg="Error in day"; }
                else        {
                if (b.indexOf("/") != -1)
                        errmsg='Invalid Month';
                else        {
                if (b<1 || b>12)
                        { err = 1 ;
                        errmsg="Error in Month";}
                else        {
                if (f.indexOf("/") != -1)
                        errmsg='Invalid Year';
                        {
                if (f.length < 4 || f.length > 4)
                        { err=1; errmsg="Error in Year"; }
                }}}}}
        //basic error checking
                if (c != '/') err = 1;
                if (e != '/') err = 1;
                //
                //advanced error checking
                // months with 30 days
                if (b==4 || b==6 || b==9 || b==11)
                {
                if (d==31)
                        err=1;
                }        // february, leap year
                if (b==2){                // feb
                var g=parseInt(f/4)
                if (isNaN(g))
                {
                err=1;
                }
                if (d>29)
                        err=1;
                if (d==29 && ((f/4)!=parseInt(f/4)))
                        err=1;
                }
                if (err==1){
                alert('Please enter valid date!(eg:MM/DD/YYYY)');
                //d2dLSPProUpdAd.txtEstSince.focus();
                //document.indent_first.consweekst.focus();
                return false;

}
var dd = tVal.substring(3,5);
var dm = tVal.substring(0,2);
var dy = tVal.substring(6,10);
var tDate=dm +"/"+ dd +"/"+ dy;
var today1 = new Date(tDate);

var td1 = today1.getDay();

if(td1 == 1)
{

}
else
{
alert("Please Enter Monday Date ...");
//document.wetnewindent.ob_cons_start.focus();
return false;
}

var d=parseInt(tVal.substring(3,5) * 1);
var m=parseInt(tVal.substring(0,2));
var y=parseInt(tVal.substring(6,10) );

var sm = tVal.substring(0,2);
if(sm=="08")
        {
        m = parseInt("8");
        }
if(sm=="09")
        {
        m = parseInt("9");
        }

if(((y%4)==0) && ((y%100)!=0))
                {
                        var max = new Array(31,29,31,30,31,30,31,31,30,31,30,31);
                }
                else
                {
                        var max = new Array(31,28,31,30,31,30,31,31,30,31,30,31);
                }
                d=d+6;
                while(d > max[m-1]) { d=d-max[m-1]; m++; }
                while(m > 12) { m=m-12; y++; }
                var dd,mm,yy;
                if(d<10)
                {
                dd="0"+d;
                }
                else
                {
                        dd=d;
                }
                if(m<10)
                {
                mm="0"+m;
                }
                else
                {
                        mm=m;
                }
                yyyy=y;
                var plsix = dd+"/"+mm+"/"+yyyy;
//                document.wetnewindent.ob_cons_end.value = plsix;
return true;*/

var datePat = /^(\d{1,2})(\/|)(\d{1,2})\2(\d{4})$/;
var matchArray = tVal.match(datePat);
if (matchArray == null) {
alert("Date is not in a valid format.");
return false;
}
month = matchArray[1]; // parse date into variables
day = matchArray[3];
year = matchArray[4];
if (month < 1 || month > 12) { // check month range
alert("Invalid month");
return false;
}
if (day < 1 || day > 31) {
alert("Invalid days");
return false;
}
if ((month==4 || month==6 || month==9 || month==11) && day==31) {
alert("Invalid number of days for this month");
return false;
}
if (month == 2) { // check for february 29th
var isleap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
if (day>29 || (day==29 && !isleap)) {
alert("Invalid number of days for this month");
return false;
   }
}
return true;
}


function dateAdd(tVal, days)
{
                var m=parseInt(tVal.substring(0,2) * 1);
                var d=parseInt(tVal.substring(3,5));
                var y=parseInt(tVal.substring(6,10) );
                var sm = tVal.substring(0,2);
                if(sm=="08")
                {
                m = parseInt("8");
                }
                if(sm=="09")
                {
                m = parseInt("9");
                }
                if(((y%4)==0) && ((y%100)!=0))
                {
                        var max = new Array(31,29,31,30,31,30,31,31,30,31,30,31);
                }
                else
                {
                        var max = new Array(31,28,31,30,31,30,31,31,30,31,30,31);
                }
                d=parseInt(d)+parseInt(days);
                while(d > max[m-1]) { d=d-max[m-1]; m++; }
                while(m > 12) { m=m-12; y++; }
                var dd,mm,yy;
                if(d<10)
                {
                dd="0"+d;
                }
                else
                {
                        dd=d;
                }
                if(m<10)
                {
                mm="0"+m;
                }
                else
                {
                        mm=m;
                }
                yyyy=y;
                var plsix = mm+"/"+dd+"/"+yyyy;

return plsix;
}//date add

/**
* sysdatecheck : function to check weather the date entered is greater than system date or not
* sysdate1 : System date
* enterdate : Date to check against system date
* return : true if sysdate is greater than enterdate
                                false if enterdate is greater than sysdate
**/
function sysdatecheck(sysdate1,enterdate)
{
        var i=0;
        var sd  = sysdate1;
        var td  = enterdate;
        var sdd = parseInt(sd.substring(3,5));
        var sdm = parseInt(sd.substring(0,2));
        var sdy = parseInt(sd.substring(6,10));

        var edd = parseInt(td.substring(3,5));
        var edm = parseInt(td.substring(0,2));
        var edy = parseInt(td.substring(6,10));

        var sm = sd.substring(0,2);
        var em = td.substring(0,2);

        var sm1 = sd.substring(3,5);
        var em1 = td.substring(3,5);


           if(sm1=="09")
                {
                sdd = parseInt("9");
                }

           if(sm1=="08")
                {
                sdd = parseInt("8");
                }

                if(sm=="08")
                {
                sdm = parseInt("8");
                }
                if(sm=="09")
                {
                sdm = parseInt("9");
                }



                if(em=="08")
                {
                edm = parseInt("8");
                }
                if(em=="09")
                {
                edm = parseInt("9");
                }
                if(em1=="09")
                {
                edd = parseInt("9");
                }

                if(em1=="08")
                {
                edd = parseInt("8");
                }

                if(sdy > edy)
        {
                i=1;
                return i;
        }
        else if(sdy == edy)
        {
                if(sdm > edm)
                {
                        i=1;
                }
                else if(sdm == edm)
                {
                        if(sdd > edd)
                        {
                                i=1;

                        }
                        else
                        {i=0;}

                }
                else
                {i=0;}
          return i;
        }
        else
                {
                return 0;
                }


}
function sysdatecheck1(sysdate1,enterdate)
{
        var i=0;

        var sd  = sysdate1;
        var td  = enterdate;

        var temp_month1 = sd.substring(0,3);
        var temp_month2 = td.substring(0,3);
        var sdm = "";
        var edm = "";

        if(temp_month1=="Jan") sdm = 01;
        if(temp_month1=="Feb") sdm = 02;
        if(temp_month1=="Mar") sdm = 03;
        if(temp_month1=="Apr") sdm = 04;
        if(temp_month1=="May") sdm = 05;
        if(temp_month1=="Jun") sdm = 06;
        if(temp_month1=="Jul") sdm = 07;
        if(temp_month1=="Aug") sdm = 08;
        if(temp_month1=="Sep") sdm = 09;
        if(temp_month1=="Oct") sdm = 10;
        if(temp_month1=="Nov") sdm = 11;
        if(temp_month1=="Dec") sdm = 12;

        if(temp_month2=="Jan") edm = 01;
        if(temp_month2=="Feb") edm = 02;
        if(temp_month2=="Mar") edm = 03;
        if(temp_month2=="Apr") edm = 04;
        if(temp_month2=="May") edm = 05;
        if(temp_month2=="Jun") edm = 06;
        if(temp_month2=="Jul") edm = 07;
        if(temp_month2=="Aug") edm = 08;
        if(temp_month2=="Sep") edm = 09;
        if(temp_month2=="Oct") edm = 10;
        if(temp_month2=="Nov") edm = 11;
        if(temp_month2=="Dec") edm = 12;



        sdm = parseInt(sdm);
        edm = parseInt(edm);


        var sdd = parseInt(sd.substring(4,sd.length-5));
        var edd = parseInt(td.substring(4,td.length-5));

        var sdy = parseInt(sd.substring(sd.length-5,sd.length));
        var edy = parseInt(td.substring(td.length-5,td.length));


        sm = sdm;
        em = edm;

        sm1 = sdd;
        em1 = edd;


           if(sm1=="09")
                {
                sdd = parseInt("9");
                }

           if(sm1=="08")
                {
                sdd = parseInt("8");
                }

                if(sm=="08")
                {
                sdm = parseInt("8");
                }
                if(sm=="09")
                {
                sdm = parseInt("9");
                }



                if(em=="08")
                {
                edm = parseInt("8");
                }
                if(em=="09")
                {
                edm = parseInt("9");
                }
                if(em1=="09")
                {
                edd = parseInt("9");
                }

                if(em1=="08")
                {
                edd = parseInt("8");
                }

                if(sdy > edy)
        {
                i=1;
                return i;
        }
        else if(sdy == edy)
        {
                if(sdm > edm)
                {
                        i=1;
                }
                else if(sdm == edm)
                {
                        if(sdd > edd)
                        {
                                i=1;

                        }
                        else
                        {i=0;}

                }
                else
                {i=0;}
          return i;
        }
        else
                {
                return 0;
                }


}



function dateCharecters(tVal)
{
 var count = 0;
 var slash_count = 0;
 var year_count = 0;
 for(i=0;i<tVal.length;i++)
        {
           j=i+1;
           var ch = tVal.substring(i,j);
           if(!((ch=="/") || (ch=="0") || (ch=="1") || (ch=="2") || (ch=="3") || (ch=="4") || (ch=="5") || (ch=="6") || (ch=="7") || (ch=="8") || (ch=="9")))
                {
             count = count + 1;
                }
                 if(ch=="/")
                        {         slash_count = slash_count + 1; }
        }

   var indexes = "";

   for(i=0;i<tVal.length;i++)
        {
           j = i+1;
           if(tVal.substring(i,j)=="/")
                   indexes = indexes + i;
        }


        temp_day_start = parseInt(indexes.substring(0,1));
        temp_year_start = parseInt(indexes.substring(1,2));

        mon = tVal.substring(0,indexes.substring(0,1));
        day = tVal.substring(temp_day_start+1,indexes.substring(1,2));
        year =         tVal.substring(temp_year_start+1,tVal.length);

        if(mon.length < 1 || mon.length > 2)
                 count++;
        if(day.length < 1 || day.length > 2)
                 count++;
        if(year.length < 4 || year.length > 4)
                 count++;


        if((count > 0) || (slash_count <2) || (slash_count > 2))
        {
          alert("Invalid date format");
          return false;
        }
        else
        {
                return true;
        }
}

function dateConvertion(tVal)
{
        var mm = "";
        var dd = "";
        var yy = "";
        var convert_date = "";
        if(tVal.substring(1,2)=="/")
        {
                mm = tVal.substring(0,1);
                if(tVal.substring(3,4)=="/")
                {
                        dd = tVal.substring(2,3);
                }
                else
                {
                        dd = tVal.substring(2,4);
                }
        }
        else
        {
                mm = tVal.substring(0,2);
                if(tVal.substring(4,5)=="/")
                {
                        dd = tVal.substring(3,4);
                }
                else
                {
                        dd = tVal.substring(3,5);
                }
        }
        yy = tVal.substring(tVal.length-4,tVal.length);

        if(mm.length==1)
                convert_date = "0" + mm + "/";
        else
                convert_date = mm + "/";

        if(dd.length==1)
                convert_date = convert_date + "0" + dd + "/";
        else
                convert_date = convert_date + dd + "/";

        convert_date = convert_date + yy;

        return convert_date;
}












// End of Block added by Nayeem
// ***************************
//f_date_option() is added by nagi reddy.veam

function f_date_option(objName,des) {
var datefield = objName;
has_Error="";
var temp=datefield.value;
if (temp.length == 0) {
        return has_Error;
}
else
{
        return f_date(objName,des);
}
}
/* Added by M.Chandramouli
 * Method:addDaysToDate
 * @param date string
 * @days  Number of days to add
 * @return new date string
 */

function addDaysToDate(urdate, days)
{
        day=1000 * 60 * 60 * 24;
        date1 = urdate;
        indate = new Date(date1);
        noofNights = parseInt(days);
        inmonth = indate.getMonth();
        inday = indate.getDate();
        inyear = indate.getYear();
        /*if(inmonth==1)
        {
                days = 28;
                if((inyear%4)==0)
                        days = 29;
                else
                        if((inyear%400)==0)
                                days = 29;
                if((inday+noofNights)>days)
                {
                        alert(inday+noofNights+","+days);
                        noofNights = noofNights+1;
                }
        }*/
        if(inmonth==0 || inmonth==2 || inmonth==4 || inmonth==6 || inmonth==7 || inmonth==9)
        {
                if((inday+noofNights)>31)
                        noofNights = noofNights+1;
        }
        if(inmonth==1 || inmonth==3 || inmonth==5 || inmonth==8 || inmonth==10)
        {
                if((inday+noofNights)>30)
                        noofNights = noofNights;
        }
        if(inmonth==11)
        {
                if((inday+noofNights)>31)
                        noofNights = noofNights;
        }
        newdate1 = indate.getTime()+(day * noofNights);
        outdate = new Date(newdate1);
        outday=outdate.getDate();
        if(outday.toString().length==1)
        {
                outday = "0"+""+outday;
        }
        outmonth = (outdate.getMonth()+1).toString();
        if(outmonth.length==1)
        {
                outmonth = "0"+""+outmonth;
        }
        outyear = outdate.getYear();
        return outmonth+"/"+outday+"/"+outyear;
}