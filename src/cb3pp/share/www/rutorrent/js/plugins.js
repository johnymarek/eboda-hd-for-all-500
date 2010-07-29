function injectScript(fname,initFunc) 
{
	var h = document.getElementsByTagName("head").item(0);
	s = document.createElement("script");
	if(initFunc)
	{	
		if(browser.isIE)
			s.onreadystatechange = function()
			{
				if((this.readyState == 'loaded') || (this.readyState == 'complete')) 
					initFunc();
			}
		else
			s.onload = initFunc;
	}
	fname = fname + "?time=" + (new Date()).getTime();
	if(s.setAttribute)
		s.setAttribute('src', fname);
	else
		s.src = fname;
	s.type = "text/javascript";
	void (h.appendChild(s));
}

function injectCSS(fname) 
{
	var newSS=document.createElement('link'); 
	newSS.rel='stylesheet'; 
	newSS.href=fname; 
	var h = document.getElementsByTagName("head").item(0);
	void (h.appendChild(newSS));
}

var thePlugins = 
{
	list: {},
	restictions:  
	{
		cantChangeToolbar: 	0x0001,
		cantChangeMenu:		0x0002,
		cantChangeOptions:	0x0004,
		cantChangeTabs:		0x0008,
		cantChangeColumns:	0x0010
	},

	register: function(plg)
	{
		this.list[plg.name] = plg;
	},

	get: function(name)
	{
	        return(this.list[name]);
	},

	isInstalled: function(name,version)
	{
	        var plg = this.list[name];
	        return(plg && plg.enabled && (!version || (plg.version>=version)) ? true : false);
	}
};

function rPlugin( name, version, author, descr, restictions )
{
	this.name = name;
	this.path = "plugins/"+name+"/";
	this.version = (version==null) ? 1.0 : version;
	this.descr = (descr==null) ? "" : descr;
	this.author = (author==null) ? "unknown" : author;
	this.allStuffLoaded = false;
	this.enabled = true;
	this.restictions = restictions;
	thePlugins.register(this);
}

rPlugin.prototype.markLoaded = function() 
{
	this.allStuffLoaded = true;
}

rPlugin.prototype.enable = function() 
{
	this.enabled = true;
	return(this);
}

rPlugin.prototype.disable = function() 
{
	this.enabled = false;
	return(this);
}

rPlugin.prototype.remove = function() 
{
	if($type(this.onRemove)=="function")
		this.onRemove();
	this.disable();
	return(this);
}

rPlugin.prototype.showError = function(err) 
{
	if( this.allStuffLoaded )
		log( err );
	else
		setTimeout( 'thePlugins.get("'+this.name+'").showError(' + err + ')', 1000 );
}

rPlugin.prototype.langLoaded = function() 
{
	if($type(this.onLangLoaded)=="function")
		this.onLangLoaded();	        	
	this.markLoaded();
}

rPlugin.prototype.loadLang = function(sendNotify)
{
	var self = this;
	injectScript(this.path+"lang/"+GetActiveLanguage()+".js",sendNotify ? function()
	{
		self.langLoaded();
	} : null);
	return(this);
}

rPlugin.prototype.loadCSS = function(name)
{
	injectCSS(this.path+name+".css");
	return(this);
}

rPlugin.prototype.loadMainCSS = function()
{
	this.loadCSS(this.name);
	return(this);
}

rPlugin.prototype.canChangeMenu = function()
{
	return(!(this.restictions & thePlugins.restictions.cantChangeMenu));
}

rPlugin.prototype.canChangeOptions = function()
{
	return(!(this.restictions & thePlugins.restictions.cantChangeOptions));
}

rPlugin.prototype.canChangeToolbar = function()
{
	return(!(this.restictions & thePlugins.restictions.cantChangeToolbar));
}

rPlugin.prototype.canChangeTabs = function()
{
	return(!(this.restictions & thePlugins.restictions.cantChangeTabs));
}

rPlugin.prototype.canChangeColumns = function()
{
	return(!(this.restictions & thePlugins.restictions.cantChangeColumns));
}

rPlugin.prototype.attachPageToOptions = function(dlg,name)
{
        if(this.canChangeOptions())
	{
		$("#st_btns").before( $(dlg).addClass("stg_con").hide() );
		$(".lm ul li:last").removeClass("last");
		$(".lm ul").append( $("<li>").attr("id","hld_"+dlg.id).addClass("last").html("<a id='mnu_"+dlg.id+"' href=\"javascript://void()\" onclick=\"theOptionsSwitcher.run('"+dlg.id+"'); return(false);\">"+name+"</a>") );
	}
	return(this);
}

rPlugin.prototype.removePageFromOptions = function(id)
{
	if(theOptionsSwitcher.current==id)
		theOptionsSwitcher.run('st_gl');
	$("#"+id).remove();
	$("#hld_"+id).remove();
	$(".lm ul li:last").addClass("last");
	return(this);
}

rPlugin.prototype.attachPageToTabs = function(dlg,name,idBefore)
{
        if(this.canChangeTabs())
        {
                if(!dlg.className)
			dlg.className = "tab";
		theTabs.tabs[dlg.id] = name; 
		var newLbl = document.createElement("li");
		newLbl.id = "tab_"+dlg.id;
		newLbl.innerHTML = "<a href=\"javascript://void();\" onmousedown=\"theTabs.show('"+dlg.id+"');\" onfocus=\"this.blur();\">" + name + "</a>";
 		var beforeTab = idBefore ? $$(idBefore) : null;
	 	if(beforeTab)
 		{
			beforeTab.parentNode.insertBefore(dlg,beforeTab);
			var beforeLbl = $$("tab_"+idBefore);
			beforeLbl.parentNode.insertBefore(newLbl,beforeLbl);
		}
		else
		{
			beforeTab = $$("lcont");
			beforeTab.parentNode.appendChild(dlg);
			var beforeLbl = $$("tab_lcont");
			beforeLbl.parentNode.appendChild(newLbl);
		}
		theTabs.show("lcont");
	}
	return(this);
}

rPlugin.prototype.renameTab = function(id,name)
{
        if(this.canChangeTabs())
        {
		theTabs.tabs[id] = name;
		$("#tab_"+id+" a").text(name);
	}
	return(this);
}

rPlugin.prototype.removePageFromTabs = function(id)
{
	delete theTabs.tabs[id]; 
	$('#'+id).remove();
	$('#tab_'+id).remove();
	return(this);
}

rPlugin.prototype.addButtonToToolbar = function(id,name,onclick,idBefore)
{
        if(this.canChangeToolbar())
        {
		var newBtn = document.createElement("A");
		newBtn.id="mnu_"+id;
		newBtn.href='javascript://void();';
		newBtn.title=name;
		newBtn.innerHTML='<div id="'+id+'" onclick="'+onclick+';return(false);" ></div>';
		var targetBtn = idBefore ? $$("mnu_"+idBefore) : null;	
		if(targetBtn)
			targetBtn.parentNode.insertBefore(newBtn,targetBtn);	
		else
		{
			targetBtn = $$("mnu_remove");
			targetBtn.parentNode.appendChild(newBtn);
		}
	}
	return(this);
}

rPlugin.prototype.removeButtonFromToolbar = function(id)
{
	$("#mnu_"+id).remove();
}
	
rPlugin.prototype.addSeparatorToToolbar = function(idBefore)	
{
        if(this.canChangeToolbar())
        {
	        var targetBtn = idBefore ? $$("mnu_"+idBefore) : null;
		var sep = document.createElement("DIV");
		sep.className = "TB_Separator";
		if(targetBtn)
			targetBtn.parentNode.insertBefore(sep,targetBtn);	
		else
		{
	        	targetBtn = $$("mnu_remove");
			targetBtn.parentNode.appendChild(sep);
		}
	}
	return(this);
}

rPlugin.prototype.removeSeparatorFromToolbar = function(idBefore)
{
	$("#mnu_"+idBefore).prev().remove();
}