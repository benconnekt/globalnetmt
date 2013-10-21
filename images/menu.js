   //cache 2 arrow images
        imageUp = new Image();
        imageUp.src = "images/up.gif";
        imageDown = new Image();
        imageDown.src = "images/down.gif";
        var cnt;                                                                                // for doing the loop
        var objSpanCollection;                                                        // store a collecion of Menu
        var menuHeightCollection = new Array();                 // store a collection of Menulists' height
        var objMenu;                                                                        // the menu is clicked on

        function InitializeMenu()
        {
                // get a collection of menus
                objSpanCollection = document.body.getElementsByTagName("SPAN");
                for (var i = 0; i < objSpanCollection.length; i++)
                {

                        var objSpan = objSpanCollection(i);
                        // get a collection of Menus' height
                        menuHeightCollection[i] = objSpan.childNodes.item(1).clientHeight;
                        // assign the click event to every Menuheader
                        objSpan.childNodes.item(0).onclick = ControlMenu;


                }

        }

        function ControlMenu()
        {
                cnt = 1;
                objMenu = this.parentNode.childNodes.item(1);        // memorize the Menulist has been clicked
                // Get the arrow that belongs to the clicked menu
                // starting with <div> then <table> then <tbody> then <tr> then <td> and the last one is
                // what we need: <img>
                var objArrow = this.childNodes(0).childNodes(0).childNodes(0).childNodes(1).childNodes(0);
                if (objMenu.style.display == "none")
                {
                        objArrow.src = imageDown.src;  //change to the Down Arrow
                        ShowMenu();
                }
                else
                {
                        objArrow.src = imageUp.src;  //change to the Up Arrow
                        HideMenu();
                }
        }

        function ShowMenu()
        {
                var objList = objMenu.childNodes.item(0);        // get the Linkslist of the Menulist
                if (cnt < 10)
                {
                        // display the Menulist
                        objMenu.style.display = "block";
                        // increase the tranparency of the Menulist
                        objMenu.filters["alpha"].opacity = objMenu.filters["alpha"].opacity + 10;
                        // loop through the Menu collection to find the position of the clicked Menu
                        // to get the actual height of the menu list and then increase the height of the Menulist
                        for (var i = 0; i < objSpanCollection.length; i++)
                                if (objMenu.parentNode == objSpanCollection[i])
                                        objMenu.style.height = objMenu.clientHeight + (menuHeightCollection[i]/10);
                        cnt++;
                        // do this function again after 30 miliseconds until the actual Menulist's height is returned
                        setTimeout("ShowMenu()",30)
                }
                // display the Menulist if the it's actual height is returned
                if (cnt >= 10)
                        objList.style.display = "block";
        }

        function HideMenu()
        {
                var objList = objMenu.childNodes.item(0);        // get the Linkslist of the Menulist
                if (cnt < 10)
                {
                        objMenu.filters["alpha"].opacity = objMenu.filters["alpha"].opacity - 10;
                        for (var i = 0; i < objSpanCollection.length; i++)
                                if (objMenu.parentNode == objSpanCollection[i])
                                        objMenu.style.height = objMenu.clientHeight - (menuHeightCollection[i]/10);
                        objList.style.display = "none";
                        cnt++;
                        setTimeout("HideMenu()",30)
                }
                if (cnt >= 10)
                        objMenu.style.display = "none";
        }


function hideDivs()
{
alert ("Hi");
divs = new Array('div1'); /*input div id's here*/
n = divs.length;

for (i=0; i>n; i++) {
i = divs[i];
document.getElementById(i).style = "display: none";
}
}


