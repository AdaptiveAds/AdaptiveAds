TextSize = {
    increment: 1,           //pt increment to increase or decrease text size
    minSize: 8,
    maxSize: 15,
    currPage: null,
    count: 0,               //range of 5 adjustments
    minCount: 0,            //range of 5 adjustments
    maxCount: 5,            //range of 5 adjustments
    inited: false,
    pt2px: 1.33,            //px = 1.33 * pt
    elements: new Array(),  //stores all the elements for text adjustment
    //Constructor
    init: function(){
        if(!this.inited){
            this.inited = true;
            //get the elements to adjust text size
            var pElems      = document.getElementsByTagName("p");
            //var divElems    = document.getElementsByTagName("div");
            var aElems      = document.getElementsByTagName("a");
            var ulElems     = document.getElementsByTagName("ul");
            var olElems     = document.getElementsByTagName("ol");
            var dlElems     = document.getElementsByTagName("dl");
            var tableElems = document.getElementsByTagName("table");
            //var pElems      = getElementsByClassName(document,"p","text_size");
            //add the individual elements arrays to the elements array
            for(var i=0; i<pElems.length; i=i+1)    {
                this.elements.push(pElems[i]);
            }
            /*
            for(i=0; i<divElems.length; i=i+1)    {
                this.elements.push(divElems[i]);
            }
            */
            for(i=0; i<aElems.length; i=i+1)    {
                this.elements.push(aElems[i]);
            }
            for(i=0; i<ulElems.length; i=i+1)    {
                this.elements.push(ulElems[i]);
            }
            for(i=0; i<olElems.length; i=i+1)    {
                this.elements.push(olElems[i]);
            }
            for(i=0; i<dlElems.length; i=i+1)    {
                this.elements.push(dlElems[i]);
            }
            for(i=0; i<tableElems.length; i=i+1)    {
                this.elements.push(tableElems[i]);
            }
            //assign the current page property
            if(this.getCurrentPageName() != "" && this.getCurrentPageName() != null)
                this.currPage = this.getCurrentPageName();
            //get the textsize cookie count value for this page
            var cookieVal = this.getCookieCountValue();
            if(cookieVal >= this.minCount && cookieVal <= this.maxCount)  this.count = cookieVal;
        }
    },
    /*---------------------------------------------------------------------------------
     * Accessor methods
    ----------------------------------------------------------------------------------*/
    getCookieCountValue: function() {
        var val = 0;
        if(navigator.cookieEnabled) {
            var cookieStr = document.cookie;
            var cookieA = cookieStr.split("; ");
            for(var i=0; i < cookieA.length; i=i+1) {
                if(this.currPage == cookieA[i].substring(0,cookieA[i].indexOf("="))) {
                    val = parseInt(cookieA[i].substring(cookieA[i].indexOf("=")+1,cookieA[i].length));
                    i = cookieA.length;
                }
            }
        }
        return val;
    },
    getCurrentPageName: function() {
        var namePrefix  = "";
        var url         = window.location.href;
        var fullName    = url.substring(url.lastIndexOf("/")+1);
        namePrefix      = fullName.substring(0,fullName.indexOf("."));
        if(namePrefix <= 0) namePrefix  = "index";
        return namePrefix;
    },
    setIncrement: function(inc) {
        if(!isNaN(inc) && inc >= 1) this.increment = Math.round(inc);
    },
    getIncrement: function() {
        return this.increment;
    },
    setMaxCount: function(num) {
        if(!isNaN(num) && num >= 0) this.maxCount = Math.round(num);
    },
    getMaxCount: function() {
        return this.maxCount;
    },
    setPt2Px: function(num) {
        if(!isNaN(num) && num >= 0) this.pt2px = num;
    },
    getPt2Px: function() {
        return this.pt2px;
    },
    setSizeLimits: function(min, max){
        this.minSize = min;
        this.maxSize = max;
    },
    getMinSize: function() {
        return this.minSize;
    },
    getMaxSize: function() {
        return this.maxSize;
    },
    getMaxAdjustments: function() {
        return this.minCount;
    },
    setCookie: function() {
        var expireDate = new Date();
        expireDate.setFullYear(expireDate.getFullYear()+1);
        document.cookie = encodeURI(this.currPage+"="+this.count)+"; expires="+expireDate.toUTCString();
    },
    /*---------------------------------------------------------------------------------
     * Modifier methods
    ----------------------------------------------------------------------------------*/
    reset: function()   {
        //delete this page's cookie
        var expireDate = new Date();
        expireDate.setFullYear(expireDate.getFullYear()-1);
        document.cookie = encodeURI(this.currPage+"="+this.count)+"; expires="+expireDate.toUTCString();
        //reload this page
        window.location.reload();
    },
    //------------------------------------------------------------------------------
    increase: function(){
        var action = "";
        //get any passed arguments
        if(arguments.length == 1) action = arguments[0];
        //check if anymore increases are allowed
        if((this.count >= this.minCount && this.count < this.maxCount) || action == 'initialise') {
            //increase the text size for each element by 1 increment
            for(i=0; i<this.elements.length; i=i+1) {
                var strCurrSize = this.getStyles(this.elements[i],'font-size');
                var currSize  = this.getFontSizePt(strCurrSize);
                //check if current font size exists and is valid
                if(currSize != null && !isNaN(currSize) && currSize > 0)  {
                    if(action == 'initialise')  {
                        currSize = currSize + (this.count * this.increment);
                    }
                    else {
                        currSize = currSize + this.increment;
                    }
                    if(currSize < this.minSize)  currSize = this.minSize;
                    if(currSize > this.maxSize)  currSize = this.maxSize;
                    //increase this element's font size
                    this.elements[i].style.fontSize = currSize + "pt";
                }
            }
        }
        //unhide the page after text size is initialised
        if(action == 'initialise') {
            var bodyElems = document.getElementsByTagName("body");
            bodyElems[0].style.display = "block";
        }
        //increment the counter
        if(action != 'initialise') this.count = this.count + 1;
        if(this.count > this.maxCount)  this.count = this.maxCount;
        if(this.count < this.minCount)  this.count = this.minCount;
        //write the textsize cookie count value
        this.setCookie();
    },
    //------------------------------------------------------------------------------
    decrease: function(){
        //check if anymore decreases are allowed
        if(this.count > this.minCount && this.count <= this.maxCount) {
            //decrease the text size for each element by 1 increment
            for(i=0; i<this.elements.length; i=i+1) {
                var strCurrSize = this.getStyles(this.elements[i],'font-size');
                var currSize  = this.getFontSizePt(strCurrSize);
                //check if curr font size exists and is valid
                if(currSize != null && !isNaN(currSize) && currSize > 0)  {
                    currSize = currSize - this.increment;
                    if(currSize < this.minSize)   currSize = this.minSize;
                    if(currSize > this.maxSize)   currSize = this.maxSize;
                    //increase this element's font size
                    this.elements[i].style.fontSize = currSize + "pt";
                }
            }
        }
        //increment the counter
        this.count = this.count - 1;
        if(this.count > this.maxCount)  this.count = this.maxCount;
        if(this.count < this.minCount)  this.count = this.minCount;
        //write the textsize cookie count value
        this.setCookie();
    },
    //------------------------------------------------------------------------------
    getSizeUnit: function(size) {
        if(size.indexOf("pt") != -1)    return "pt";
        if(size.indexOf("px") != -1)    return "px";
        return null;
    },
    //------------------------------------------------------------------------------
    getStyles: function(oElm, strCssRule){
        var strValue = "";
        if(document.defaultView && document.defaultView.getComputedStyle)   {
            strValue = document.defaultView.getComputedStyle(oElm, "").getPropertyValue(strCssRule);
        }
        else if(oElm.currentStyle)  {
            strCssRule = strCssRule.replace(/\-(\w)/g, function (strMatch, p1){
                return p1.toUpperCase();
            });
            strValue = oElm.currentStyle[strCssRule];
        }
        return strValue;
    },
    //------------------------------------------------------------------------------
    getFontSizePt: function(strSize)    {
        var unit = this.getSizeUnit(strSize);
        if(unit == "px")    {
            return Math.round(parseInt(strSize)/this.pt2px);
        }
        else if(unit == "pt")   {
            return parseInt(strSize);
        }
        else {
            return null;
        }
    }
};  
