(window.webpackJsonp=window.webpackJsonp||[]).push([[22],{"f+ep":function(n,l,o){"use strict";o.r(l);var t,e=o("8Y7J"),u=function(){},r=o("pMnS"),a=o("s7LF"),i=o("TSSN"),g=o("iInd"),s=o("SVse"),d=o("ajia"),c=o("AytR"),p=o("IheW"),m=((t=function(){function n(n,l,o){this.http=n,this.api=l,this.router=o,this.accessToken=localStorage.getItem("accessToken")}return n.prototype.getToken=function(){return localStorage.getItem("__MMCLIENT__")},n.prototype.isAuthenticated=function(){return!!this.getToken()},n.prototype.authDetails=function(){return{sessionUserName:localStorage.getItem("userName"),role:"Manager"}},n.prototype.logout=function(){},n}()).ngInjectableDef=e["\u0275\u0275defineInjectable"]({factory:function(){return new t(e["\u0275\u0275inject"](p.c),e["\u0275\u0275inject"](d.a),e["\u0275\u0275inject"](g.l))},token:t,providedIn:"root"}),t),C=function(){function n(n,l,o){this.router=n,this.api=l,this.authService=o,this.loginData={username:"carter.merl@example.net",password:"1234"}}return n.prototype.ngOnInit=function(){},n.prototype.onLoggedin=function(){var n=this;this.loginData=this.setLoginJson(this.loginData),localStorage.setItem("isLoggedin","true"),this.api.post("oauth","token",this.loginData).subscribe((function(l){n.accessToken=l.access_token,localStorage.setItem("__MMCLIENT__",l.access_token),setTimeout((function(){n.authService.isAuthenticated()?n.router.navigate(["dashboard"]):n.router.navigate(["/"])}),400)}),(function(n){}))},n.prototype.setLoginJson=function(n){var l=n;return l.client_secret=c.b.clientSecret,l.grant_type=c.b.grantType,l.client_id=c.b.clientId,l.scope="",l},n}(),f=e["\u0275crt"]({encapsulation:0,styles:[["[_nghost-%COMP%]{display:block}.login-page[_ngcontent-%COMP%]{position:absolute;top:0;left:0;right:0;bottom:0;overflow:auto;background:#222;text-align:center;color:#fff;padding:3em}.login-page[_ngcontent-%COMP%]   .col-lg-4[_ngcontent-%COMP%]{padding:0}.login-page[_ngcontent-%COMP%]   .input-lg[_ngcontent-%COMP%]{height:46px;padding:10px 16px;font-size:18px;line-height:1.3333333;border-radius:0}.login-page[_ngcontent-%COMP%]   .input-underline[_ngcontent-%COMP%]{background:0 0;border:none;box-shadow:none;border-bottom:2px solid rgba(255,255,255,.5);color:#fff;border-radius:0}.login-page[_ngcontent-%COMP%]   .input-underline[_ngcontent-%COMP%]:focus{border-bottom:2px solid #fff;box-shadow:none}.login-page[_ngcontent-%COMP%]   .rounded-btn[_ngcontent-%COMP%]{border-radius:50px;color:rgba(255,255,255,.8);background:#222;border:2px solid rgba(255,255,255,.8);font-size:18px;line-height:40px;padding:0 25px}.login-page[_ngcontent-%COMP%]   .rounded-btn[_ngcontent-%COMP%]:active, .login-page[_ngcontent-%COMP%]   .rounded-btn[_ngcontent-%COMP%]:focus, .login-page[_ngcontent-%COMP%]   .rounded-btn[_ngcontent-%COMP%]:hover, .login-page[_ngcontent-%COMP%]   .rounded-btn[_ngcontent-%COMP%]:visited{color:#fff;border:2px solid #fff;outline:0}.login-page[_ngcontent-%COMP%]   h1[_ngcontent-%COMP%]{font-weight:300;margin-top:20px;margin-bottom:10px;font-size:36px}.login-page[_ngcontent-%COMP%]   h1[_ngcontent-%COMP%]   small[_ngcontent-%COMP%]{color:rgba(255,255,255,.7)}.login-page[_ngcontent-%COMP%]   .form-group[_ngcontent-%COMP%]{padding:8px 0}.login-page[_ngcontent-%COMP%]   .form-group[_ngcontent-%COMP%]   input[_ngcontent-%COMP%]::-webkit-input-placeholder{color:rgba(255,255,255,.6)!important}.login-page[_ngcontent-%COMP%]   .form-group[_ngcontent-%COMP%]   input[_ngcontent-%COMP%]:-moz-placeholder{color:rgba(255,255,255,.6)!important}.login-page[_ngcontent-%COMP%]   .form-group[_ngcontent-%COMP%]   input[_ngcontent-%COMP%]::-moz-placeholder{color:rgba(255,255,255,.6)!important}.login-page[_ngcontent-%COMP%]   .form-group[_ngcontent-%COMP%]   input[_ngcontent-%COMP%]:-ms-input-placeholder{color:rgba(255,255,255,.6)!important}.login-page[_ngcontent-%COMP%]   .form-content[_ngcontent-%COMP%]{padding:40px 0}.login-page[_ngcontent-%COMP%]   .user-avatar[_ngcontent-%COMP%]{border-radius:50%;border:2px solid #fff}"]],data:{animation:[{type:7,name:"routerTransition",definitions:[],options:{}}]}});function _(n){return e["\u0275vid"](0,[e["\u0275qud"](671088640,1,{loginForm:0}),(n()(),e["\u0275eld"](1,0,null,null,36,"div",[["class","login-page"]],[[24,"@routerTransition",0]],null,null,null,null)),(n()(),e["\u0275eld"](2,0,null,null,35,"div",[["class","row justify-content-md-center"]],null,null,null,null,null)),(n()(),e["\u0275eld"](3,0,null,null,34,"div",[["class","col-md-4"]],null,null,null,null,null)),(n()(),e["\u0275eld"](4,0,null,null,0,"img",[["class","user-avatar"],["src","assets/images/logo.png"],["width","150px"]],null,null,null,null,null)),(n()(),e["\u0275eld"](5,0,null,null,1,"h1",[],null,null,null,null,null)),(n()(),e["\u0275ted"](-1,null,["SB Admin BS4 Angular8"])),(n()(),e["\u0275eld"](7,0,null,null,30,"form",[["novalidate",""]],[[2,"ng-untouched",null],[2,"ng-touched",null],[2,"ng-pristine",null],[2,"ng-dirty",null],[2,"ng-valid",null],[2,"ng-invalid",null],[2,"ng-pending",null]],[[null,"submit"],[null,"reset"]],(function(n,l,o){var t=!0;return"submit"===l&&(t=!1!==e["\u0275nov"](n,9).onSubmit(o)&&t),"reset"===l&&(t=!1!==e["\u0275nov"](n,9).onReset()&&t),t}),null,null)),e["\u0275did"](8,16384,null,0,a["\u0275angular_packages_forms_forms_z"],[],null,null),e["\u0275did"](9,4210688,[[1,4],["f",4]],0,a.NgForm,[[8,null],[8,null]],null,null),e["\u0275prd"](2048,null,a.ControlContainer,null,[a.NgForm]),e["\u0275did"](11,16384,null,0,a.NgControlStatusGroup,[[4,a.ControlContainer]],null,null),(n()(),e["\u0275eld"](12,0,null,null,16,"div",[["class","form-content"]],null,null,null,null,null)),(n()(),e["\u0275eld"](13,0,null,null,7,"div",[["class","form-group"]],null,null,null,null,null)),(n()(),e["\u0275eld"](14,0,null,null,6,"input",[["class","form-control input-underline input-lg"],["id",""],["name","username"],["ng-model","name"],["type","email"]],[[8,"placeholder",0],[2,"ng-untouched",null],[2,"ng-touched",null],[2,"ng-pristine",null],[2,"ng-dirty",null],[2,"ng-valid",null],[2,"ng-invalid",null],[2,"ng-pending",null]],[[null,"ngModelChange"],[null,"input"],[null,"blur"],[null,"compositionstart"],[null,"compositionend"]],(function(n,l,o){var t=!0,u=n.component;return"input"===l&&(t=!1!==e["\u0275nov"](n,15)._handleInput(o.target.value)&&t),"blur"===l&&(t=!1!==e["\u0275nov"](n,15).onTouched()&&t),"compositionstart"===l&&(t=!1!==e["\u0275nov"](n,15)._compositionStart()&&t),"compositionend"===l&&(t=!1!==e["\u0275nov"](n,15)._compositionEnd(o.target.value)&&t),"ngModelChange"===l&&(t=!1!==(u.loginData.username=o)&&t),t}),null,null)),e["\u0275did"](15,16384,null,0,a.DefaultValueAccessor,[e.Renderer2,e.ElementRef,[2,a.COMPOSITION_BUFFER_MODE]],null,null),e["\u0275prd"](1024,null,a.NG_VALUE_ACCESSOR,(function(n){return[n]}),[a.DefaultValueAccessor]),e["\u0275did"](17,671744,null,0,a.NgModel,[[2,a.ControlContainer],[8,null],[8,null],[6,a.NG_VALUE_ACCESSOR]],{name:[0,"name"],model:[1,"model"]},{update:"ngModelChange"}),e["\u0275prd"](2048,null,a.NgControl,null,[a.NgModel]),e["\u0275did"](19,16384,null,0,a.NgControlStatus,[[4,a.NgControl]],null,null),e["\u0275pid"](131072,i.j,[i.k,e.ChangeDetectorRef]),(n()(),e["\u0275eld"](21,0,null,null,7,"div",[["class","form-group"]],null,null,null,null,null)),(n()(),e["\u0275eld"](22,0,null,null,6,"input",[["class","form-control input-underline input-lg"],["id",""],["name","password"],["type","password"]],[[8,"placeholder",0],[2,"ng-untouched",null],[2,"ng-touched",null],[2,"ng-pristine",null],[2,"ng-dirty",null],[2,"ng-valid",null],[2,"ng-invalid",null],[2,"ng-pending",null]],[[null,"ngModelChange"],[null,"input"],[null,"blur"],[null,"compositionstart"],[null,"compositionend"]],(function(n,l,o){var t=!0,u=n.component;return"input"===l&&(t=!1!==e["\u0275nov"](n,23)._handleInput(o.target.value)&&t),"blur"===l&&(t=!1!==e["\u0275nov"](n,23).onTouched()&&t),"compositionstart"===l&&(t=!1!==e["\u0275nov"](n,23)._compositionStart()&&t),"compositionend"===l&&(t=!1!==e["\u0275nov"](n,23)._compositionEnd(o.target.value)&&t),"ngModelChange"===l&&(t=!1!==(u.loginData.password=o)&&t),t}),null,null)),e["\u0275did"](23,16384,null,0,a.DefaultValueAccessor,[e.Renderer2,e.ElementRef,[2,a.COMPOSITION_BUFFER_MODE]],null,null),e["\u0275prd"](1024,null,a.NG_VALUE_ACCESSOR,(function(n){return[n]}),[a.DefaultValueAccessor]),e["\u0275did"](25,671744,null,0,a.NgModel,[[2,a.ControlContainer],[8,null],[8,null],[6,a.NG_VALUE_ACCESSOR]],{name:[0,"name"],model:[1,"model"]},{update:"ngModelChange"}),e["\u0275prd"](2048,null,a.NgControl,null,[a.NgModel]),e["\u0275did"](27,16384,null,0,a.NgControlStatus,[[4,a.NgControl]],null,null),e["\u0275pid"](131072,i.j,[i.k,e.ChangeDetectorRef]),(n()(),e["\u0275eld"](29,0,null,null,2,"a",[["class","btn rounded-btn"]],null,[[null,"click"]],(function(n,l,o){var t=!0;return"click"===l&&(t=!1!==n.component.onLoggedin()&&t),t}),null,null)),(n()(),e["\u0275ted"](30,null,["",""])),e["\u0275pid"](131072,i.j,[i.k,e.ChangeDetectorRef]),(n()(),e["\u0275ted"](-1,null,[" \xa0 "])),(n()(),e["\u0275eld"](33,0,null,null,4,"a",[["class","btn rounded-btn"]],[[1,"target",0],[8,"href",4]],[[null,"click"]],(function(n,l,o){var t=!0;return"click"===l&&(t=!1!==e["\u0275nov"](n,34).onClick(o.button,o.ctrlKey,o.metaKey,o.shiftKey)&&t),t}),null,null)),e["\u0275did"](34,671744,null,0,g.o,[g.l,g.a,s.LocationStrategy],{routerLink:[0,"routerLink"]},null),e["\u0275pad"](35,1),(n()(),e["\u0275ted"](36,null,["",""])),e["\u0275pid"](131072,i.j,[i.k,e.ChangeDetectorRef])],(function(n,l){var o=l.component;n(l,17,0,"username",o.loginData.username),n(l,25,0,"password",o.loginData.password);var t=n(l,35,0,"/signup");n(l,34,0,t)}),(function(n,l){n(l,1,0,void 0),n(l,7,0,e["\u0275nov"](l,11).ngClassUntouched,e["\u0275nov"](l,11).ngClassTouched,e["\u0275nov"](l,11).ngClassPristine,e["\u0275nov"](l,11).ngClassDirty,e["\u0275nov"](l,11).ngClassValid,e["\u0275nov"](l,11).ngClassInvalid,e["\u0275nov"](l,11).ngClassPending),n(l,14,0,e["\u0275inlineInterpolate"](1,"",e["\u0275unv"](l,14,0,e["\u0275nov"](l,20).transform("Email")),""),e["\u0275nov"](l,19).ngClassUntouched,e["\u0275nov"](l,19).ngClassTouched,e["\u0275nov"](l,19).ngClassPristine,e["\u0275nov"](l,19).ngClassDirty,e["\u0275nov"](l,19).ngClassValid,e["\u0275nov"](l,19).ngClassInvalid,e["\u0275nov"](l,19).ngClassPending),n(l,22,0,e["\u0275inlineInterpolate"](1,"",e["\u0275unv"](l,22,0,e["\u0275nov"](l,28).transform("Password")),""),e["\u0275nov"](l,27).ngClassUntouched,e["\u0275nov"](l,27).ngClassTouched,e["\u0275nov"](l,27).ngClassPristine,e["\u0275nov"](l,27).ngClassDirty,e["\u0275nov"](l,27).ngClassValid,e["\u0275nov"](l,27).ngClassInvalid,e["\u0275nov"](l,27).ngClassPending),n(l,30,0,e["\u0275unv"](l,30,0,e["\u0275nov"](l,31).transform("Log in"))),n(l,33,0,e["\u0275nov"](l,34).target,e["\u0275nov"](l,34).href),n(l,36,0,e["\u0275unv"](l,36,0,e["\u0275nov"](l,37).transform("Register")))}))}var v=e["\u0275ccf"]("app-login",C,(function(n){return e["\u0275vid"](0,[(n()(),e["\u0275eld"](0,0,null,null,1,"app-login",[],null,null,null,_,f)),e["\u0275did"](1,114688,null,0,C,[g.l,d.a,m],null,null)],(function(n,l){n(l,1,0)}),null)}),{},{},[]),h=function(){};o.d(l,"LoginModuleNgFactory",(function(){return M}));var M=e["\u0275cmf"](u,[],(function(n){return e["\u0275mod"]([e["\u0275mpd"](512,e.ComponentFactoryResolver,e["\u0275CodegenComponentFactoryResolver"],[[8,[r.a,v]],[3,e.ComponentFactoryResolver],e.NgModuleRef]),e["\u0275mpd"](4608,s.NgLocalization,s.NgLocaleLocalization,[e.LOCALE_ID,[2,s["\u0275angular_packages_common_common_a"]]]),e["\u0275mpd"](4608,a["\u0275angular_packages_forms_forms_o"],a["\u0275angular_packages_forms_forms_o"],[]),e["\u0275mpd"](1073742336,s.CommonModule,s.CommonModule,[]),e["\u0275mpd"](1073742336,i.h,i.h,[]),e["\u0275mpd"](1073742336,g.p,g.p,[[2,g.u],[2,g.l]]),e["\u0275mpd"](1073742336,h,h,[]),e["\u0275mpd"](1073742336,a["\u0275angular_packages_forms_forms_d"],a["\u0275angular_packages_forms_forms_d"],[]),e["\u0275mpd"](1073742336,a.FormsModule,a.FormsModule,[]),e["\u0275mpd"](1073742336,u,u,[]),e["\u0275mpd"](1024,g.j,(function(){return[[{path:"",component:C}]]}),[])])}))}}]);