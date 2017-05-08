YUI.add("moodle-core-tooltip",function(e,t){function n(e){e||(e={}),typeof e.draggable=="undefined"&&(e.draggable=!0),typeof e.constrain=="undefined"&&(e.constrain=!0),n.superclass.constructor.apply(this,[e])}var r={CLOSEBUTTON:".closebutton"},i={PANELTEXT:"tooltiptext"},s={WAITICON:{pix:"i/loading_small",component:"moodle"}},o={};n.NAME="moodle-core-tooltip",n.CSS_PREFIX="moodle-dialogue",n.ATTRS=o,o.initialheadertext={value:""},o.initialbodytext={value:"",setter:function(t){var n,r;return n=e.Node.create("<div />").addClass(i.PANELTEXT),r=e.Node.create("<img />").setAttribute("src",M.util.image_url(s.WAITICON.pix,s.WAITICON.component)).addClass("spinner"),t?(n.set("text",t),r.addClass("iconsmall")):n.addClass("content-lightbox"),n.append(r),n}},o.initialfootertext={value:null,setter:function(t){if(t)return e.Node.create("<div />").set("text",t)}},o.headerhandler={value:"set_header_content"},o.bodyhandler={value:"set_body_content"},o.footerhandler={value:null},o.urlmodifier={value:null},o.textcache={value:null},o.textcachesize={value:10},e.extend(n,M.core.dialogue,{bb:null,listenevents:[],textcache:null,alignpoints:[e.WidgetPositionAlign.TL,e.WidgetPositionAlign.RC],initializer:function(){return this.get("headerhandler")||this.set("headerhandler",this.set_header_content),this.get("bodyhandler")||this.set("bodyhandler",this.set_body_content),this.get("footerhandler")||this.set("footerhandler",function(){}),this.get("urlmodifier")||this.set("urlmodifier",this.modify_url),this.setAttrs({headerContent:this.get("initialheadertext"),bodyContent:this.get("initialbodytext"),footerContent:this.get("initialfootertext")}),this.hide(),this.render(),this.bb=this.get("boundingBox"),this.bb.addClass("moodle-dialogue-tooltip"),right_to_left()&&(this.alignpoints=[e.WidgetPositionAlign.TR,e.WidgetPositionAlign.LC]),this.get("textcache")||this.set("textcache",new e.Cache({max:this.get("textcachesize")})),M.cfg.developerdebug&&this.get("textcache").set("max",0),this},display_panel:function(t){var n,i,s,o,u;t.preventDefault(),this.cancel_events(),n=t.target.ancestor("a",!0),this.setAttrs({headerContent:this.get("initialheadertext"),bodyContent:this.get("initialbodytext"),footerContent:this.get("initialfootertext")}),this.show(t),this.align(n,this.alignpoints),i=this.bb.delegate("click",this.close_panel,r.CLOSEBUTTON,this),this.listenevents.push(i),i=e.one("body").on("key",this.close_panel,"esc",this),this.listenevents.push(i),i=this.bb.on("mousedownoutside",this.close_panel,this),this.listenevents.push(i),s=e.bind(this.get("urlmodifier"),this,n.get("href"))(),u=this.get("textcache").retrieve(s),u?this._set_panel_contents(u.response):(o={method:"get",context:this,sync:!1,on:{complete:function(e,t){this._set_panel_contents(t.responseText,s)}}},e.io(s,o))},_set_panel_contents:function(t,n){var r;try{r=e.JSON.parse(t);if(r.error)return this.close_panel(),e.use("moodle-core-notification-ajaxexception",function(){return(new M.core.ajaxException(r)).show()}),this}catch(i){return this.close_panel(),e.use("moodle-core-notification-exception",function(){return(new M.core.exception(i)).show()}),this}e.bind(this.get("headerhandler"),this,r)(),e.bind(this.get("bodyhandler"),this,r)(),e.bind(this.get("footerhandler"),this,r)(),n&&this.get("textcache").add(n,t),this.get("buttons").header[0].focus()},set_header_content:function(e){this.set("headerContent",e.heading)},set_body_content:function(t){var n=e.Node.create("<div />").set("innerHTML",t.text).setAttribute("role","alert").addClass(i.PANELTEXT);this.set("bodyContent",n)},modify_url:function(e){return e.replace(/\.php\?/,"_ajax.php?")},close_panel:function(e){this.hide(e),this.cancel_events(),e&&e.preventDefault()},cancel_events:function(){var e;while(this.listenevents.length)e=this.listenevents.shift(),e.detach()}}),e.Base.modifyAttrs(n,{modal:{value:!1},focusOnPreviousTargetAfterHide:{value:!0}}),M.core=M.core||{},M.core.tooltip=M.core.tooltip=n},"@VERSION@",{requires:["base","node","io-base","moodle-core-notification-dialogue","json-parse","widget-position","widget-position-align","event-outside","cache-base"]});
YUI.add("moodle-core-popuphelp",function(e,t){function n(){n.superclass.constructor.apply(this,arguments)}var r={CLICKABLELINKS:"span.helptooltip > a",FOOTER:"div.moodle-dialogue-ft"},i={ICON:"icon",ICONPRE:"icon-pre"},s={};n.NAME="moodle-core-popuphelp",n.ATTRS=s,e.extend(n,e.Base,{panel:null,initializer:function(){e.one("body").delegate("click",this.display_panel,r.CLICKABLELINKS,this)},display_panel:function(e){this.panel||(this.panel=new M.core.tooltip({bodyhandler:this.set_body_content,footerhandler:this.set_footer,initialheadertext:M.util.get_string("loadinghelp","moodle"),initialfootertext:""})),this.panel.display_panel(e)},set_footer:function(t){t.doclink?(doclink=e.Node.create("<a />").setAttrs({href:t.doclink.link}).addClass(t.doclink["class"]),helpicon=e.Node.create("<img />").setAttrs({src:M.util.image_url("docs","core")}).addClass(i.ICON).addClass(i.ICONPRE),doclink.appendChild(helpicon),doclink.appendChild(t.doclink.linktext),this.set("footerContent",doclink),this.bb.one(r.FOOTER).show()):this.bb.one(r.FOOTER).hide()}}),M.core=M.core||{},M.core.popuphelp=M.core.popuphelp||null,M.core.init_popuphelp=M.core.init_popuphelp||function(e){return M.core.popuphelp||(M.core.popuphelp=new n(e)),M.core.popuphelp}},"@VERSION@",{requires:["moodle-core-tooltip"]});
YUI.add("moodle-core-widget-focusafterclose",function(e,t){function r(){e.after(this._bindUIFocusAfterHide,this,"bindUI"),this.get("rendered")&&this._bindUIFocusAfterHide()}var n='input:not([type="hidden"]), a[href], button, textarea, select, [tabindex], [contenteditable="true"]';r.ATTRS={focusOnPreviousTargetAfterHide:{value:!1},focusAfterHide:{value:null,type:e.Node}},r.prototype={_uiHandlesFocusAfterHide:[],_showFocusAfterHide:null,_previousTargetFocusAfterHide:null,initializer:function(){this.get("focusOnPreviousTargetAfterHide")&&this.show&&(this._showFocusAfterHide=this.show,this.show=function(e){this._showFocusAfterHide.apply(this,arguments),this._previousTargetFocusAfterHide=null,e&&e.currentTarget&&(this._previousTargetFocusAfterHide=e.currentTarget)})},destructor:function(){(new e.EventHandle(this.uiHandleFocusAfterHide)).detach()},_bindUIFocusAfterHide:function(){(new e.EventHandle(this.uiHandleFocusAfterHide)).detach(),this.uiHandleFocusAfterHide=[this.after("visibleChange",this._afterHostVisibleChangeFocusAfterHide)]},_afterHostVisibleChangeFocusAfterHide:function(){this.get("visible")||this._attemptFocus(this._previousTargetFocusAfterHide)||this._attemptFocus(this.get("focusAfterHide"))},_attemptFocus:function(t){var r=e.one(t);if(r){r=r.ancestor(n,!0);if(r)return r.focus(),!0}return!1}};var i=e.namespace("M.core");i.WidgetFocusAfterHide=r},"@VERSION@",{requires:["base-build","widget"]});
YUI.add("moodle-core-dock-loader",function(e,t){var n="moodle-core-dock-loader";M.core=M.core||{},M.core.dock=M.core.dock||{},M.core.dock.ensureMoveToIconExists=function(t){if(t.one(".moveto"))return!0;var n,r=e.Node.create('<input type="image" class="moveto customcommand requiresjs" />'),i=t.one(".block_action"),s="t/block_to_dock",o=t.one(".header .title h2");return e.one(document.body).hasClass("dir-rtl")&&(s+="_rtl"),r.setAttribute("alt",M.util.get_string("addtodock","block")),o&&r.setAttribute("title",e.Escape.html(M.util.get_string("dockblock","block",o.getHTML()))),r.setAttribute("src",M.util.image_url(s,"moodle")),i?i.prepend(r):(n=t.one(".header .title .commands"),!n&&t.one(".header .title")&&(n=e.Node.create('<div class="commands"></div>'),t.one(".header .title").append(n)),n.append(r)),!0},M.core.dock.loader=M.core.dock.loader||{},M.core.dock.loader.delegationEvents=[],M.core.dock.loader.initLoader=function(){var t=e.all(".block[data-instanceid][data-dockable]"),n=e.one(document.body),r;t.each(function(){var e=parseInt(this.getData("instanceid"),10);M.core.dock.ensureMoveToIconExists(this)}),t.some(function(e){return e.hasClass("dock_on_load")})?e.use("moodle-core-dock",function(){M.core.dock.init()}):(r=function(t){var n,r=this.ancestor(".block[data-instanceid]"),i=r.getData("instanceid");t.halt();for(n in M.core.dock.loader.delegationEvents)(e.Lang.isNumber(n)||e.Lang.isString(n))&&M.core.dock.loader.delegationEvents[n].detach();r.addClass("dock_on_load"),e.use("moodle-core-dock",function(){M.util.set_user_preference("docked_block_instance_"+i,1),M.core.dock.init()})},M.core.dock.loader.delegationEvents.push(n.delegate("click",r,".moveto")),M.core.dock.loader.delegationEvents.push(n.delegate("key",r,".moveto","enter")))}},"@VERSION@",{requires:["escape"]});
YUI.add("moodle-core-notification-dialogue",function(e,t){var n,r,i,s,o,u,a;n="moodle-dialogue",r="notificationBase",i="yesLabel",s="noLabel",o="title",u="question",a={BASE:"moodle-dialogue-base",WRAP:"moodle-dialogue-wrap",HEADER:"moodle-dialogue-hd",BODY:"moodle-dialogue-bd",CONTENT:"moodle-dialogue-content",FOOTER:"moodle-dialogue-ft",HIDDEN:"hidden",LIGHTBOX:"moodle-dialogue-lightbox"},M.core=M.core||{};var f="Moodle dialogue",l,c=n+"-fullscreen",h=n+"-hidden",p=" [role=dialog]",d="[role=menubar]",v=".",m="moodle-has-zindex",g='input:not([type="hidden"]), a[href], button, textarea, select, [tabindex]';l=function(t){var n=e.clone(t);n.COUNT=e.stamp(this);var r="moodle-dialogue-"+n.COUNT;n.notificationBase=e.Node.create('<div class="'+a.BASE+'">').append(e.Node.create('<div id="'+r+'" role="dialog" aria-labelledby="'+r+'-header-text" class="'+a.WRAP+'"></div>').append(e.Node.create('<div id="'+r+'-header-text" class="'+a.HEADER+' yui3-widget-hd"></div>')).append(e.Node.create('<div class="'+a.BODY+' yui3-widget-bd"></div>')).append(e.Node.create('<div class="'+a.FOOTER+' yui3-widget-ft"></div>'))),e.one(document.body).append(n.notificationBase),n.additionalBaseClass&&n.notificationBase.addClass(n.additionalBaseClass),n.srcNode="#"+r,n.closeButton===!1?n.buttons=null:n.buttons=[{section:e.WidgetStdMod.HEADER,classNames:"closebutton",action:function(){this.hide()}}],l.superclass.constructor.apply(this,[n]),n.closeButton!==!1&&this.get("buttons").header[0].setAttribute("title",this.get("closeButtonTitle"))},e.extend(l,e.Panel,{_resizeevent:null,_orientationevent:null,_calculatedzindex:!1,initializer:function(){var t;this.get("render")&&this.render(),this.makeResponsive(),this.after("visibleChange",this.visibilityChanged,this),this.get("center")&&this.centerDialogue(),this.get("modal")&&this.plug(e.M.core.LockScroll),t=this.get("boundingBox"),t.addClass(m),e.Array.each(this.get("extraClasses"),t.addClass,t),this.get("visible")&&this.applyZIndex(),this.on("maskShow",this.applyZIndex),this.get("visible")&&(this.show(),this.keyDelegation()),this.after("destroyedChange",function(){this.get(r).remove(!0)},this)},applyZIndex:function(){var t=1,n=1,r=this.get("boundingBox"),i=this.get("maskNode"),s=this.get("zIndex");s!==0&&!this._calculatedzindex?r.setStyle("zIndex",s):(e.all(p+", "+d+", "+v+m).each(function(e){var n=this.findZIndex(e);n>t&&(t=n)},this),n=(t+1).toString(),r.setStyle("zIndex",n),this.set("zIndex",n),this.get("modal")&&(i.setStyle("zIndex",n),e.UA.ie&&e.UA.compareVersions(e.UA.ie,9)<0&&setTimeout(function(){i.setStyle("position","static"),setTimeout(function(){i.setStyle("position","fixed")},0)},0)),this._calculatedzindex=!0)},findZIndex:function(e){var t=e.getStyle("zIndex")||e.ancestor().getStyle("zIndex");return t?parseInt(t,10):0},visibilityChanged:function(t){var n,r;t.attrName==="visible"&&(this.get("maskNode").addClass(a.LIGHTBOX),t.prevVal&&!t.newVal&&(r=this.get("boundingBox"),this._resizeevent&&(this._resizeevent.detach(),this._resizeevent=null),this._orientationevent&&(this._orientationevent.detach(),this._orientationevent=null),r.detach("key",this.keyDelegation)),!t.prevVal&&t.newVal&&(this.applyZIndex(),this.makeResponsive(),this.shouldResizeFullscreen()||this.get("draggable")&&(n="#"+this.get("id")+" ."+a.HEADER,this.plug(e.Plugin.Drag,{handles:[n]}),e.one(n).setStyle("cursor","move")),this.keyDelegation()),this.get("center")&&!t.prevVal&&t.newVal&&this.centerDialogue())},makeResponsive:function(){var t=this.get("boundingBox"),n;this.shouldResizeFullscreen()?(t.addClass(c),t.setStyles({left:null,top:null,width:null,height:null,right:null,bottom:null}),n=e.one("#"+this.get("id")+" ."+a.BODY)):this.get("responsive")&&(t.removeClass(c).setStyles({width:this.get("width"),height:this.get("height")}),n=e.one("#"+this.get("id")+" ."+a.BODY))},centerDialogue:function(){var t=this.get("boundingBox"),n=t.hasClass(h),r,i;if(this.shouldResizeFullscreen())return;n&&t.setStyle("top","-1000px").removeClass(h),r=Math.max(Math.round((t.get("winWidth")-t.get("offsetWidth"))/2),15),i=Math.max(Math.round((t.get("winHeight")-t.get("offsetHeight"))/2),15)+e.one(window).get("scrollTop"),t.setStyles({left:r,top:i}),n&&t.addClass(h)},shouldResizeFullscreen:function(){return window===window.parent&&this.get("responsive")&&Math.floor(e.one(document.body).get("winWidth"))<this.get("responsiveWidth")},show:function(){var e=null,t=this.headerNode,n=this.bodyNode,r=this.get("focusOnShowSelector"),i=null;return e=l.superclass.show.call(this),this.lockScroll&&this.lockScroll.enableScrollLock(this.shouldResizeFullscreen()),r!==null&&(i=this.get("boundingBox").one(r)),i||(t&&t!==""?i=t:n&&n!==""&&(i=n)),i&&i.focus(),e},hide:function(e){if(e&&e.type==="key"&&e.keyCode===27&&!this.get("focused"))return;return this.lockScroll&&this.lockScroll.disableScrollLock(),l.superclass.hide.call(this,arguments)},keyDelegation:function(){var e=this.get("boundingBox");e.delegate("key",function(e){var t=e.target,n="forward";e.shiftKey&&(n="backward"),this.trapFocus(t,n)&&e.preventDefault()},"down:9",g,this)},trapFocus:function(e,t){var n=this.get("boundingBox"),r=n.one(g),i=n.all(g).pop();if(e===i&&t==="forward")return r.focus();if(e===r&&t==="backward")return i.focus()}},{NAME:f,CSS_PREFIX:n,ATTRS:{notificationBase:{},lightbox:{lazyAdd:!1,setter:function(e){this.set("modal",e)}},closeButton:{validator:e.Lang.isBoolean,value:!0},closeButtonTitle:{validator:e.Lang.isString,value:M.util.get_string("closebuttontitle","moodle")},center:{validator:e.Lang.isBoolean,value:!0},draggable:{validator:e.Lang.isBoolean,value:!1},COUNT:{value:null},responsive:{validator:e.Lang.isBoolean,value:!0},responsiveWidth:{value:768},focusOnShowSelector:{value:null}}}),e.Base.modifyAttrs(l,{width:{value:"400px",setter:function(e){return e==="auto"?"":e}},visible:{value:!1},centered:{setter:function(e){return e&&this.set("center",!0),!1}},render:{value:!0,writeOnce:!0},extraClasses:{value:[]}}),e.Base.mix(l,[e.M.core.WidgetFocusAfterHide]),M.core
.dialogue=l;var y=function(){y.superclass.constructor.apply(this,arguments)};e.extend(y,M.core.dialogue,{},{NAME:"Moodle information dialogue",CSS_PREFIX:n}),e.Base.modifyAttrs(y,{visible:{value:!0},modal:{validator:e.Lang.isBoolean,value:!0}}),M.core.notification=M.core.notification||{},M.core.notification.info=y},"@VERSION@",{requires:["base","node","panel","escape","event-key","dd-plugin","moodle-core-widget-focusafterclose","moodle-core-lockscroll"]});
