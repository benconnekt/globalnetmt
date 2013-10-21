//Note; See the steps for implementation at the end of this file
//Developed by Sorin Militaru & Cristian Militaru

//Browser flags
var bitwdp_ie=document.all;
var bitwdp_ns=document.getElementById&&!document.all;

//state variables
var bitwdp_dropdownVisible=false; //drop down button visible or not
var bitwdp_calendarVisible=false; //calendar visible or not

var bitwdp_currentYear=null; //current year      
var bitwdp_currentMonth=null; //current month

//last valid used year; when user insert an invalid value for year, on lostfocus (blur)
//the last valid value is restored
var g_lastYear=null; 

/*Constants used by bitwdp attribute
  1-Wed Date Picker text box
  2-Drop down button
  3-Move year/month back/forward
   4-Month combo
  5-Year text box
  6-Today link
  7-Days
  8-Other elements
*/

//Settings
var g_dateFormat="d/m/y"; //used format for in and out (from and to target)
var g_date00=true; //output format writes days and months with two decimals 
var g_dateSep="/"; //date separator
var g_maxYear=2049; //used only for navigation limits
var g_minYear=1850; //used only for navigation limits 

//Labels
//used for calendar header
var g_days = new Array("Su","Mo","Tu","We","Th","Fr","Sa");
//used for combo of months
var g_months=new Array("January","February","March","April","May","June","July","August","September","October","November","December");
//day number of a month
var g_month_days=new Array(31,28,31,30,31,30,31,31,30,31,30,31);

//format calendar area
//TABLE tag
var g_TABLE="<TABLE border=0 cellPadding=1 cellSpacing=0 width=\"200px\" vspace=\"0\" hspace=\"0\">";
//bgcolor for certains areas
var g_bgcolor_workday="#F2F4F8"; //workday
var g_bgcolor_weekday="#F2F4F8"; //weekend (sa,su)
var g_bgcolor_curr="#eeeeee"; //selected day: where mouse is in 
var g_bgcolor_header="#eeeeee";//header
var g_bgcolor_footer="#F2F4F8";//footer

//styles for fonts for calendar area
var g_dayStyle="COLOR: #000000; FONT-FAMILY: 'MS Sans Serif',sans serif; FONT-SIZE: 10px; TEXT-DECORATION: none";
var g_curdayStyle="COLOR: #000000; FONT-FAMILY: 'MS Sans Serif',sans serif; FONT-WEIGHT: bold;FONT-SIZE: 10px; TEXT-DECORATION: none";
var g_todayStyle="COLOR: #ff0033; FONT-WEIGHT: bold;FONT-FAMILY: 'MS Sans Serif',sans serif; FONT-SIZE: 10px; TEXT-DECORATION: none";
var g_todayFooterStyle="COLOR: #ff0033;FONT-FAMILY: 'MS Sans Serif',sans serif; FONT-SIZE: 10px; TEXT-DECORATION: none; z-index: 100";
var g_headerStyle="FONT-FAMILY: 'MS Sans Serif',sans-serif; FONT-SIZE: 10px; FONT-WEIGHT: bold";
var g_footerStyle="FONT-FAMILY: 'MS Sans Serif',sans-serif; FONT-SIZE: 10px;";

var bitwdp_txt=null; //current target;target=HTML input (text) where calendar put the date

//these are elements needed by Web Data Picker Component

window.document.writeln("<IMG id=bitwdp_cmd_img name=bitwdp_cmd_img bitwdp=2 align=middle border=0 hspace=0 src="+img_folder+"bitcbo.gif style=\"CURSOR: hand; POSITION: absolute; LEFT: 0px; TOP: 0px; VISIBILITY: hidden; z-index: 1000\" language=javascript onmousedown=\"this.src=img_folder+'bitcbo_down.gif'\" onmouseup=\"this.src=img_folder+'bitcbo.gif'\" onmouseout=\"this.src=img_folder+'bitcbo.gif'\" onclick=\"bitwdp_clickDropDown()\">");

bitwdp_buildCalendar("");

function bitwdp_element(pstr_id)
{
  if (bitwdp_ie)
  {
    return document.all[pstr_id];
  }
  else
  {
    return document.getElementById(pstr_id);
  }
}

function bitwdp_buildCalendar(pstrName)
{
  if (pstrName!="")
  {
    document.writeln("<div bitwdp=8 id=\""+pstrName+"\" style=\"position:relative; z-index:0; width:200px; height:130px; overflow: visible; visibility: visible; background-color: #FFFFFF; border: 1px none #000000\">");
  }
  else
  {
    document.writeln("<div bitwdp=8 id=\"Calendar\" style=\"position:absolute; left:0px; top:0px; z-index:7; width:200px; height:130px; overflow: visible; visibility: hidden; background-color: #FFFFFF; border: 1px none #000000\">");
  }
  
  document.writeln("<div bitwdp=8 id=\""+pstrName+"Navigation\" style=\"position:absolute; left:0px; top:0px; z-index:9; width:200px; height:27px; overflow: visible; visibility:inherit\">");
      
  document.writeln("<table border=0 cellspacing=0 cellpadding=0 width=\"200px\" vspace=0 hspace=0>");
  document.writeln("<tr>");
  document.writeln("<td bitwdp=8 align=center valign=middle bgcolor=#999999>");
  document.writeln("<IMG vspace=0 hspace=0 bitwdp=3 align=middle SRC=\""+img_folder+"yearback.gif\" onmouseover=\"this.src=img_folder+'yearback_hover.gif';\" onmouseout=\"this.src=img_folder+'yearback.gif';\" border=0 onclick=\"moveYear('Back','"+pstrName+"')\">");
  document.writeln("</td>");
              
  document.writeln("<td bitwdp=8 align=center bgcolor=#999999>");
  document.writeln("<IMG vspace=0 hspace=0 bitwdp=3 align=middle SRC=\""+img_folder+"monthback.gif\" onmouseover=\"this.src=img_folder+'monthback_hover.gif';\" onmouseout=\"this.src=img_folder+'monthback.gif';\" border=0 onclick=\"moveMonth('Back','"+pstrName+"')\">");
  document.writeln("</td>");
            
  document.writeln("<td bitwdp=8 align=center valign=middle bgcolor=#999999 width=\"60px\">");
  document.writeln("<select bitwdp=4 id="+pstrName+"cboMonth name="+pstrName+"cboMonth style=\"font-family: 'MS Sans Serif', sans-serif; font-size: 9pt\" onChange=\"gotoMonth(this.options[this.selectedIndex].value,'"+pstrName+"')\">");
  document.writeln("<option bitwdp=4 value=\"0\">January</option>");
  document.writeln("<option bitwdp=4 value=\"1\">February</option>");
  document.writeln("<option bitwdp=4 value=\"2\">March</option>");
  document.writeln("<option bitwdp=4 value=\"3\">April</option>");
  document.writeln("<option bitwdp=4 value=\"4\">May</option>");
  document.writeln("<option bitwdp=4 value=\"5\">June</option>");
  document.writeln("<option bitwdp=4 value=\"6\">July</option>");
  document.writeln("<option bitwdp=4 value=\"7\">August</option>");
  document.writeln("<option bitwdp=4 value=\"8\">September</option>");
  document.writeln("<option bitwdp=4 value=\"9\">October</option>");
  document.writeln("<option bitwdp=4 value=\"10\">November</option>");
  document.writeln("<option bitwdp=4 value=\"11\">December</option>");
  document.writeln("</select>");
  document.writeln("</td>");
            
  document.writeln("<td bitwdp=8 align=center valign=middle bgcolor=#999999>");
  document.writeln("<INPUT type=text id="+pstrName+"txtYear name="+pstrName+"txtYear bitwdp=5 size=\"3\" style=\"font-family: 'MS Sans Serif', sans-serif; font-size: 9pt;width:40px\" onkeyup=\"return year_onkeyup('"+pstrName+"')\">");
  document.writeln("</td>");
              
  document.writeln("<td bitwdp=8 align=center bgcolor=#999999>");
  document.writeln("<IMG vspace=0 hspace=0 bitwdp=3 align=middle SRC=\""+img_folder+"monthforward.gif\" onmouseover=\"this.src=img_folder+'monthforward_hover.gif';\" onmouseout=\"this.src=img_folder+'monthforward.gif';\" border=0 onclick=\"moveMonth('Forward','"+pstrName+"')\">");
  document.writeln("</td>");
            
  document.writeln("<td bitwdp=8 align=center bgcolor=#999999>");
  document.writeln("<IMG vspace=0 hspace=0 bitwdp=3 align=middle SRC=\""+img_folder+"yearforward.gif\" onmouseover=\"this.src=img_folder+'yearforward_hover.gif';\" onmouseout=\"this.src=img_folder+'yearforward.gif';\" border=0 onclick=\"moveYear('Forward','"+pstrName+"')\">");
  document.writeln("</td>");
  document.writeln("</tr>");
  document.writeln("</table>");

  document.writeln("</div>");
  document.writeln("<div id=\""+pstrName+"calendarDays\" style=\"position:absolute; left:0px; top:26px; z-index:8; width:200px; height:17px; overflow: visible; visibility:inherit; background-color: #FFFFFF; border: 1px none #000000\"> </div></div>");
  
  if (pstrName!="")
  {
    var year=0;
    var month=0;
    var day=0;
    var targetDate;
    var todayDate=new Date();
  
    //no target date, use today as default
    year=todayDate.getFullYear();
    month=todayDate.getMonth();
    day=0;//todayDate.getDate();

    setDate(year,month,day, pstrName); //set date = creates HTML for calendar and load it dinamically
  }
}

function bitwdp_window_onclick(e)
{  
  bitwdp_possible_change(e)
}
function bitwdp_window_onkeyup(e)
{
  if (bitwdp_ie)
  {
    key_press=event.keyCode;
  }
  else
  {
    key_press=e.which;
  }
  
  //only tab key will be treated
  if (key_press!=9)
  {
    return
  }
  
  bitwdp_possible_change(e)
}

function bitwdp_possible_change(e)
{
  var obj_source
  var bitwdp_field=false;
  
  if (bitwdp_ie)
  {
    obj_source=event.srcElement;
  }
  else
  {
    obj_source=e.target;
  }
  
  bitwdp_field=true
  
  if (obj_source.disabled)
  {
    bitwdp_field=false
  }
  
  if (obj_source.getAttribute("bitwdp")==""||obj_source.getAttribute("bitwdp")==null)
  {
  bitwdp_field=false
  }
  
  if (obj_source.readOnly)
  {
    bitwdp_field=false
  }
  
  if (!bitwdp_field)
  {
    if (bitwdp_txt!=null)
    {
      //alert(obj_source.tagName)
      
      bitwdp_hideCalendar();
      bitwdp_hideDropDown();
        
      bitwdp_txt=null;
    }
    return
  }
  
  switch (parseInt(obj_source.getAttribute("bitwdp")))
  {
    case 1:
    {
    //the new element is the text of a bit combo
      if (bitwdp_txt==obj_source)
      {
        //Nothing to do
      }
      else
      {
        if (bitwdp_txt!=null)
        {
          bitwdp_hideCalendar();
          bitwdp_hideDropDown();
        }
        
        bitwdp_txt=obj_source;
        
        bitwdp_showDropDown();
      }
      break;
    }
    default:
    {
    //the new element is either 
    //the button of the active bit combo
    //or the list of the active bit combo
    //or the supl of the active bit combo
      //Nothing to do
      //alert(obj_source.getAttribute("bitwdp"))
      break;
    }
  }  
}

function bitwdp_showDropDown()
{    
  var cmd=bitwdp_element("bitwdp_cmd_img")
  
  if (bitwdp_ie)
  {    
    bitwdp_dropdownVisible=true;
    bitwdp_txt.style.width=bitwdp_txt.offsetWidth-cmd.offsetWidth
    var posTop=bitwdp_txt.offsetParent.offsetTop + bitwdp_txt.offsetTop
    var posLeft=bitwdp_txt.offsetParent.offsetLeft + bitwdp_txt.offsetLeft
    var obj=bitwdp_txt.offsetParent
    
    while (obj.tagName!="BODY")
    {
      obj=obj.offsetParent
      posTop=posTop+obj.offsetTop
      posLeft=posLeft+obj.offsetLeft
    }
    
    cmd.style.top=posTop+document.body.clientTop
    cmd.style.left=posLeft+bitwdp_txt.offsetWidth+document.body.clientLeft
    cmd.style.visibility="visible"    
    
  }
  
  if (bitwdp_ns)
  {    
    bitwdp_dropdownVisible=true;
    
    bitwdp_txt.style.width=bitwdp_txt.offsetWidth-cmd.offsetWidth
    
    var posTop=bitwdp_txt.offsetParent.offsetTop + bitwdp_txt.offsetTop
    var posLeft=bitwdp_txt.offsetParent.offsetLeft + bitwdp_txt.offsetLeft
    var obj=bitwdp_txt.offsetParent
    while (obj.tagName!="BODY")
    {
      obj=obj.offsetParent
      posTop=posTop+obj.offsetTop
      posLeft=posLeft+obj.offsetLeft
    }
    
    cmd.style.top=posTop
    cmd.style.left=posLeft+bitwdp_txt.offsetWidth
    cmd.style.visibility="visible"    
  }  
}

function bitwdp_hideDropDown()
{
  var cmd=bitwdp_element("bitwdp_cmd_img")
    
  bitwdp_dropdownVisible=false;
    
  bitwdp_txt.style.width=bitwdp_txt.offsetWidth+cmd.offsetWidth
  cmd.style.visibility="hidden";  
  
  bitwdp_hideCalendar();
}

function bitwdp_clickDropDown()
{
  if (bitwdp_calendarVisible)
  {
    bitwdp_hideCalendar();
  }
  else
  {
    var year=0;
    var month=0;
    var day=0;
    var targetDate;
    var todayDate=new Date();
  
    //get the date from target in order to navigate there
    targetDate=isDate(bitwdp_txt.value);    
    
    if (targetDate==null)
    {
      //no target date, use today as default
      year=todayDate.getFullYear();
      month=todayDate.getMonth();
      day=0;//todayDate.getDate();
    }
    else
    {
      year=targetDate.getFullYear();
      month=targetDate.getMonth();
      day=targetDate.getDate();
    }

    setDate(year,month,day,""); //set date = creates HTML for calendar and load it dinamically
    bitwdp_showCalendar();; //show calendar    
  }
  bitwdp_txt.focus();
}

function bitwdp_showCalendar()
{
  if (bitwdp_ie) 
  {
    var OFFSET=2;
    
    var posTop=bitwdp_txt.offsetParent.offsetTop + bitwdp_txt.offsetTop
    var posLeft=bitwdp_txt.offsetParent.offsetLeft + bitwdp_txt.offsetLeft
    var objParent=bitwdp_txt.offsetParent
    
    while (objParent.tagName!="BODY")
    {
      objParent=objParent.offsetParent
      posTop=posTop+objParent.offsetTop
      posLeft=posLeft+objParent.offsetLeft
    }
    
    var obj = document.all['Calendar'];
    if ((posLeft+document.body.clientLeft+document.all['calendarDays'].offsetWidth)>document.body.clientWidth)
    {
      posLeft = posLeft+document.body.clientLeft-((posLeft+document.body.clientLeft+document.all['calendarDays'].offsetWidth)-document.body.clientWidth)
    }
    else
    {
      posLeft = posLeft+document.body.clientLeft
    }
    obj.style.left = posLeft
    
    if ((posTop+bitwdp_txt.offsetHeight+document.body.clientTop+document.all['calendarDays'].offsetHeight+document.all['Navigation'].offsetHeight)>document.body.clientHeight)
    {
      posTop = posTop+document.body.clientTop-document.all['calendarDays'].offsetTop-document.all['calendarDays'].offsetHeight
    }
    else
    {
      posTop=posTop+bitwdp_txt.offsetHeight+document.body.clientTop
    }
    obj.style.top  = posTop
    
    obj.style.visibility = "visible";
  }
  
  else if (bitwdp_ns)
  {
    var obj = document.getElementById("Calendar");
    //obj.style.left = e.clientX;
    //obj.style.top  = e.clientY;
    //nu este tratat cazul cand calendarul nu incape in ecran
    obj.style.left = bitwdp_txt.offsetLeft+bitwdp_txt.offsetParent.offsetLeft;
    obj.style.top  = bitwdp_txt.offsetTop+bitwdp_txt.offsetHeight+bitwdp_txt.offsetParent.offsetTop;
    
    obj.style.visibility = "visible";    
      
  }
  bitwdp_calendarVisible=true;
}

function bitwdp_hideCalendar()
{
  if (bitwdp_ie) 
  {
    var obj = document.all['Calendar'];
    obj.style.visibility = "hidden";
  }
    
  else if (bitwdp_ns)
  {
    var obj = document.getElementById("Calendar");
    obj.style.visibility = "hidden";    
      
  }
  bitwdp_calendarVisible=false;  
}

function bitwdp_setDate(pDate,pstrName)
{
  //get date parts
  var year=0;
  var month=0;
  var day=0;
  var targetDate;
  var todayDate=new Date();
  
  //get the date from target in order to navigate there
  targetDate=isDate(pDate);    
    
  if (targetDate==null)
  {
    //no target date, use today as default
    year=todayDate.getFullYear();
    month=todayDate.getMonth();
    day=0;//todayDate.getDate();
  }
  else
  {
    year=targetDate.getFullYear();
    month=targetDate.getMonth();
    day=targetDate.getDate();
  }
  
  setDate(year,month,day,pstrName)
}

function setDate(year,month,day,pstrName)
//the most important function: creates the HTML for calendar area
//for given year,month,day
{
  var firstWeekDay;
  var lastDayOfMonth;
  var noLines;
  var i = 0;
  var j = 0;
  var k = 0;
  var tmp;
  var dayIdx=1;
  var isToday;
  var isCurday;
  var isWorkday;
  var todayMonth;
  var todayYear;
  var todayDay;
  var todayDate=new Date();
  
  //test for year limits
  if ((year<g_minYear)||(year>g_maxYear))
  {
    return(null);
  }

  //get today
  todayMonth=todayDate.getMonth();
  todayYear=todayDate.getFullYear();
  todayDay=todayDate.getDate();

  //determinate number of lines (4,5 or 6)
  //I need week day of 1th of month and tne number of days for the current month
  firstWeekDay= getFirstWeekDay(year,month);
  lastDayOfMonth=g_month_days[month];
  
  //Correction for leap year
  if ((month==1)&& (isLeapYear(year)))
  {
    lastDayOfMonth=29;
  }
  
  if (firstWeekDay+lastDayOfMonth>35)
  {
    noLines=6;
  }
  else if (firstWeekDay+lastDayOfMonth>28)
  {
    noLines=5;
  }
  else
  {
    noLines=4;
  }
  
  //CREATE HTML
  tmp=g_TABLE;
  
  //add header
  tmp=tmp+"<TR>";
  for (k=0;k<7;++k)
  {
    tmp=tmp+addTDHeader(g_days[k]);
  }
  tmp=tmp+"</TR>";

  for (i=0;i<noLines; ++i)
  {
    tmp=tmp+"<TR>";
    for (j = 0; j < 7; ++j) 
    {
      if ((i*7+j<firstWeekDay)||(i*7+j-firstWeekDay>lastDayOfMonth-1)) //index is o based
      {
        if ((j==0)||(j==6))
        {
          //empty day (before 1t or after the last day) on weekend columns
          tmp=tmp+addTD(false,false,false,null,pstrName);
        }
        else
        {
          //empty day (before 1t or after the last day) on workday columns
          tmp=tmp+addTD(true,false,false,null,pstrName);
        }
      }
      else 
      {
        //workday flag
        if ((j==0)||(j==6))
        {
          isWorkday=false;
        }
        else
        {
          isWorkday=true;
        }
        
        //current day flag
        //current day=day from target input
        isCurday=false;
        if (day!=null)
        {
          if (day==dayIdx)
          {
            isCurday=true;
          }
        }
        
        //today flag
        if ((month==todayMonth)&&(year==todayYear)&&(dayIdx==todayDay))
        {
          isToday=true;
        }
        else
        {
          isToday=false;
        }
        //add TD
        tmp=tmp+addTD(isWorkday,isToday,isCurday,dayIdx,pstrName);
          
        dayIdx=dayIdx+1;
      }
    }
    tmp=tmp+"</TR>";
  }

  //footer area: link to today and current month/year
  tmp=tmp+"<TR>";
  tmp=tmp+"<TD bitwdp=8 colspan=7>";
  
  tmp=tmp+"</TD>";
  tmp=tmp+"</TR>";
  
  tmp=tmp+"<TR>";
  
  tmp=tmp+"<TD bitwdp=8 colspan=4 align=\"left\" valign=\"middle\" bgcolor=\"" + g_bgcolor_footer + "\">";
  if (pstrName=="")
  {
    tmp=tmp+"<A bitwdp=6 href=\"javascript:setDate(" + todayYear+","+todayMonth+",null,'"+pstrName+"')\" language:javascript onmouseover=\"window.state=' ';return true;\" style=\"" + g_todayFooterStyle + "\">" + "Today: " + formatDate(todayYear,todayMonth+1,todayDay) + "</A>"   
  }
  else
  {
  //if calendar is used as interface control (not drop down) Ricardo asked to navigate to the current date.
    tmp=tmp+"<A bitwdp=6 href=\"javascript:setDate(" + todayYear+","+todayMonth+",null,'"+pstrName+"');setDay("+todayDay+",'"+pstrName+"')\" language:javascript onmouseover=\"window.state=' ';return true;\" style=\"" + g_todayFooterStyle + "\">" + "Today: " + formatDate(todayYear,todayMonth+1,todayDay) + "</A>" 
  }
  tmp=tmp+"</TD>";
  
  tmp=tmp+"<TD bitwdp=8 colspan=3 align=\"right\" valign=\"middle\" bgcolor=\"" + g_bgcolor_footer + "\">";
  tmp=tmp+"<FONT bitwdp=8 style=\"" + g_footerStyle + "\">";
  tmp=tmp+g_months[month]+g_dateSep+year;
  tmp=tmp+"</TD>";
  tmp=tmp+"</TR>";
  
  tmp=tmp+"</TABLE>";

  //set DHTML
  if (bitwdp_ie) 
  {
    document.all[pstrName+'calendarDays'].innerHTML = tmp;
  }
  else if (bitwdp_ns)
  {
    document.getElementById(pstrName+"calendarDays").innerHTML = tmp;
  }
  
  //store into state variables
  bitwdp_currentYear=parseInt(year);
  bitwdp_currentMonth=parseInt(month);
  //load values into month and year inputs
  setCbos(month,year,pstrName);
}

function getFirstWeekDay(year,month)
{
  //first week day of a month
  var vdate=new Date();
  
  vdate.setDate(1);
  vdate.setMonth(month);
  vdate.setFullYear(year);
  
  return(vdate.getDay());
  
}

function addTDHeader(label)
{
  var tmp;
  
  tmp="<TD bitwdp=8 width=\"28px\" align=\"center\" valign=\"middle\" bgcolor=\"" + g_bgcolor_header + "\">";
  tmp=tmp+"<FONT bitwdp=8 style=\"" + g_headerStyle + "\">";
  tmp=tmp+label;
  tmp=tmp + "</FONT>";
  tmp=tmp+"</TD>";
  return(tmp);

}

function addTD(workday,today,currday,day,pstrName)
{
  var tmp;
  var bgcolor;
  var linkStyle;
  
  if (workday==true)
  {
    
    bgcolor=g_bgcolor_workday;
  }
  else
  {
    bgcolor=g_bgcolor_weekday;
  }
  
  tmp="<TD bitwdp=8 width=\"28px\" align=\"center\" valign=\"middle\" bgcolor=\"" + bgcolor + "\"";
  
  if (day!==null)
  {
    if (workday==true)
    {
      tmp=tmp+" onmouseover=\"this.style.backgroundColor='" + g_bgcolor_curr + "'\" onmouseout=\"this.style.backgroundColor='" + g_bgcolor_workday + "'\">";  
    }
    else
    {
      tmp=tmp+" onmouseover=\"this.style.backgroundColor='" + g_bgcolor_curr + "'\" onmouseout=\"this.style.backgroundColor='" + g_bgcolor_weekday + "'\">";  
    }
    if (today==true)
    {
      linkStyle=g_todayStyle;
    }
    else
    {
      if (currday==true)
      {
        linkStyle=g_curdayStyle;
      }
      else
      {
        linkStyle=g_dayStyle;
      }
    }
    tmp=tmp+"<A bitwdp=7 href=\"javascript:setDay(" + day + ",'"+pstrName+"')\" onmouseover=\"window.status=' ';return true;\" style=\"" + linkStyle + "\" language=javascript>" + day + "</A>" 

  }
  else
  {
    tmp=tmp + ">&nbsp";
  }
  
  tmp=tmp+"</TD>";
  return(tmp);
  
}

function isLeapYear(year) 
{
  if ((year%400==0)||((year%4==0)&&(year%100!=0))) 
  {
    return true;
  }
  else 
  {
    return false;
  }
}

function moveMonth(direction,pstrName)
{
  if (direction=="Forward")
  {
    if (bitwdp_currentMonth==11)
    {
      setDate(bitwdp_currentYear+1,0,null,pstrName)
    }
    else
    {
      setDate(bitwdp_currentYear,bitwdp_currentMonth+1,null,pstrName)
    }
  }
  else
  {
    if (bitwdp_currentMonth==0)
    {
      setDate(bitwdp_currentYear-1,11,null,pstrName)
    }
    else
    {
      setDate(bitwdp_currentYear,bitwdp_currentMonth-1,null,pstrName)
    }
  }
}


function moveYear(direction,pstrName)
{
  if (direction=="Forward")
  {
    setDate(bitwdp_currentYear+1,bitwdp_currentMonth,null,pstrName)
  }
  else
  {
    setDate(bitwdp_currentYear-1,bitwdp_currentMonth,null,pstrName)
  }
}

function isDate(expr)
//function tests expr; if this can be considered a date, function returns
//an object of Date type, otherwise null
{

  //isDate uses the constant g_dateFormat
  var arr=expr.split(g_dateSep);
  
  //split into 3 pieces and examine each piece (day, month, year)
  if (arr.length==3)
  {
    if ((isNaN(arr[0])) || (isNaN(arr[1]))|| (isNaN(arr[2])))
    {
      return(null);
    }
    else
    {
      if (g_dateFormat=="m/d/y")
      {
        month=arr[0];
        day=arr[1];
        year=arr[2];
      }
      else if (g_dateFormat=="d/m/y")
      {
        day=arr[0];
        month=arr[1];
        year=arr[2];
      }
      else if (g_dateFormat=="y/m/d")
      {
        year=arr[0];
        month=arr[1];
        day=arr[2];
      }
      else if (g_dateFormat=="m/y/d")
      {
        month=arr[0];
        year=arr[1];
        day=arr[2];
      }
      else if (g_dateFormat=="d/y/m")
      {
        day=arr[0];
        year=arr[1];
        month=arr[2];
      }
      else if (g_dateFormat=="y/d/m")
      {
        year=arr[0];
        day=arr[1];
        month=arr[2];
      }

      if ((year<=g_maxYear)&&(year>=g_minYear)&&(month>=1)&&(month<=12))
      {
        lastDay=g_month_days[parseInt(month)-1];
        if (isLeapYear(year))
        {
          lastDay=29;
        }
        if ((day>=1)&&(day<=lastDay))
        {
          //Hurra! We've got a real date
          var retDate=new Date();
          retDate.setMonth(month-1);
          retDate.setDate(day);
          retDate.setFullYear(year);
          return(retDate);
        }
        else
        {
          return(null);
        }
      }
      else
      {
        return(null);
      }
    }
  }
  else
  {
    return(null);
  }  
}

function setCbos(month,year,pstrName)
//set month and year controls
{
  var cboM=bitwdp_element(pstrName+"cboMonth");
  var txtY=bitwdp_element(pstrName+"txtYear");
  
  cboM.options[month].selected = true;
  txtY.value=year;
}

//navigational functions
function gotoMonth(month,pstrName)
{
  setDate(bitwdp_currentYear,month,0,pstrName);
}

function gotoYear(year,pstrName)
{
  setDate(year,bitwdp_currentMonth,0,pstrName);
}

function setDay(day,pstrName)
//return date into target
{    
  var varDate=formatDate(bitwdp_currentYear,parseInt(bitwdp_currentMonth)+1,day);
//alert (varDate);
  
//alert("inside");
    document.calendarform.txt_date.value=varDate;
    //bitwdp_hideCalendar();
   // bitwdp_txt.focus();
    bitwdp_txt_changed(document.calendarform.txt_date,varDate);
 
  
}

function formatDate(year,month,day)
//format date: use g_formatDate and g_date00 for formatting
{
  var usrMonth;
  var usrDay;
  
  if (g_date00==true)
  {
    usrMonth=format00(month);
    usrDay=format00(day);
  }
  else
  {
    usrMonth=month;
    usrDay=day;
  }
  
  if (g_dateFormat=="m/d/y")
  {
    return(usrMonth+g_dateSep+usrDay+g_dateSep+year);
  }
  else if (g_dateFormat=="d/m/y")
  {
  return(usrDay+g_dateSep+usrMonth+g_dateSep+year);
  }
  else if (g_dateFormat=="y/m/d")
  {
    return(year+g_dateSep+usrMonth+g_dateSep+usrDay);
  }
  else if (g_dateFormat=="m/y/d")
  {
    return(usrMonth+g_dateSep+year+g_dateSep+usrDay);
  }
  else if (g_dateFormat=="d/y/m")
  {
    return(usrDay+g_dateSep+year+g_dateSep+usrMonth);
  }
  else if (g_dateFormat=="y/d/m")
  {
    return(year+g_dateSep+usrDay+g_dateSep+usrMonth);
  }
}

function format00(expr)
{
  var str=new String(expr);
  
  if (str.length==1)
  {
    return("0"+expr);
  }
  else
  {
    return(expr);
  }
}

//EVENT FUNCTIONS FOR YEAR INPUT: used for year navigation
function year_onkeyup(pstrName) 
{
  var txtY=bitwdp_element(pstrName+"txtYear");
  
  if (isNaN(txtY.value)==true)
  {
    //NOP
  }
  else
  {
    if ((txtY.value<g_minYear)||(txtY.value>g_maxYear))
    {
      //NOP
    }
    else
    {
      setDate(txtY.value,bitwdp_currentMonth,null,pstrName);
    }
  }
}

/*
Web Data Picker can be used in two ways
a) as a drop down data picker for a text box
b) as a stand alone component

In order to use Web Data Picker you'll have to follow the steps:
1)(a,b) - Copy files into site directory
2)(a,b) - Insert code before <BODY> tag
3)(a,b) - Modify the <BODY> tag
4)(a,b) - Insert code for data picking action
5)(a)   - Specify the datapicker text boxes
6)(b)  - Build the stand alone data picker
7)(b)  - Set the date for the stand alone data picker

1) - You need the following files to be copied into site directory:
    - bitwdp.js
    - bitcbo.gif
    - bitcbo_down.gif
    - monthforward.gif
    - monthback.gif
    - yearforward.gif
    - yearback.gif
2) - Insert this code before <BODY> tag
    <SCRIPT LANGUAGE=javascript SRC="bitwdp.js"></SCRIPT>
3) - Modify the <BODY> tag
    You'll have to specify that events 
onclick and onkeyup to execute the functions bitwdp_window_onclick(event) and bitwdp_window_onkeyup(event)
If you have some other code on this events you could modify the events like follows:
  <BODY LANGUAGE=javascript onmousedown="bitcbo_window_onmousedown(event);" onkeyup="bitcbo_window_onkeyup(event); bitwdp_window_onkeyup(event)">

4) - Insert code for datapicking action.
    Whenever a data is picked using the component you could want
to do some custom action. In order to do that the following code have to be inserted somewhere into your page:

    <SCRIPT language="JavaScript">
      //This function is called when the textbox datapicker is changed from component code
      
      function bitwdp_txt_changed(pobj,pDate)
      {
        switch (pobj.id)
        {
          case "txt_date_1":
          {
            //do some action
            
            break;
          }
          case "txt_date_2":
          {
            //do some other action
            
            break;
          }
        }
      }      
    </script>

5) Specify the Data Picker textboxes
  All you have to do is to insert "bitwdp=1" into the INPUT tag.
  Here it is some sample:
  <INPUT type=text bitwdp=1 id=txt_date name=txt_date value="">
6) Build the stand alone data picker
  Insert the following code in the place where you want the component to be placed:
  
  <SCRIPT LANGUAGE=javascript>
  <!--
    bitwdp_buildCalendar("ComponentName");
  //-->
  </SCRIPT>
7) Set the date for stand alone web data picker component
  call this function from your JavaScript code:
  
  bitwdp_setDate(pDate,pstrName)
  
*/
