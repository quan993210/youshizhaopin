/*
 * DD_PNG
 * Modified:dyer
 */
var DD_PNG={ns:"DD_PNG",imgSize:{},delay:10,nodesFixed:0,createVmlNameSpace:function(){if(document.namespaces&&!document.namespaces[this.ns])document.namespaces.add(this.ns,"urn:schemas-microsoft-com:vml")},createVmlStyleSheet:function(){var B,A;B=document.createElement("style");B.setAttribute("media","screen");document.documentElement.firstChild.insertBefore(B,document.documentElement.firstChild.firstChild);if(B.styleSheet){B=B.styleSheet;B.addRule(this.ns+"\\:*","{behavior:url(#default#VML)}");B.addRule(this.ns+"\\:shape","position:absolute;");B.addRule("img."+this.ns+"_sizeFinder","behavior:none; border:none; position:absolute; z-index:-1; top:-10000px; visibility:hidden;");this.screenStyleSheet=B;A=document.createElement("style");A.setAttribute("media","print");document.documentElement.firstChild.insertBefore(A,document.documentElement.firstChild.firstChild);A=A.styleSheet;A.addRule(this.ns+"\\:*","{display: none !important;}");A.addRule("img."+this.ns+"_sizeFinder","{display: none !important;}")}},readPropertyChange:function(){var B,C,A;B=event.srcElement;if(!B.vmlInitiated)return;if(event.propertyName.search("background")!=-1||event.propertyName.search("border")!=-1)DD_PNG.applyVML(B);if(event.propertyName=="style.display"){C=(B.currentStyle.display=="none")?"none":"block";for(A in B.vml)if(B.vml.hasOwnProperty(A))B.vml[A].shape.style.display=C}if(event.propertyName.search("filter")!=-1)DD_PNG.vmlOpacity(B)},vmlOpacity:function(B){if(B.currentStyle.filter.search("lpha")!=-1){var A=B.currentStyle.filter;A=parseInt(A.substring(A.lastIndexOf("=")+1,A.lastIndexOf(")")),10)/100;B.vml.color.shape.style.filter=B.currentStyle.filter;B.vml.image.fill.opacity=A}},handlePseudoHover:function(A){setTimeout(function(){DD_PNG.applyVML(A)},1)},fix:function(A){if(this.screenStyleSheet){var B,C;B=A.split(",");for(C=0;C<B.length;C++)this.screenStyleSheet.addRule(B[C],"behavior:expression(DD_PNG.fixPng(this))")}},applyVML:function(A){A.runtimeStyle.cssText="";this.vmlFill(A);this.vmlOffsets(A);this.vmlOpacity(A);if(A.isImg)this.copyImageBorders(A)},attachHandlers:function(B){var D,G,F,A,C,E;D=this;G={resize:"vmlOffsets",move:"vmlOffsets"};if(B.nodeName=="A"){A={mouseleave:"handlePseudoHover",mouseenter:"handlePseudoHover",focus:"handlePseudoHover",blur:"handlePseudoHover"};for(C in A)if(A.hasOwnProperty(C))G[C]=A[C]}for(E in G)if(G.hasOwnProperty(E)){F=function(){D[G[E]](B)};B.attachEvent("on"+E,F)}B.attachEvent("onpropertychange",this.readPropertyChange)},giveLayout:function(A){A.style.zoom=1;if(A.currentStyle.position=="static")A.style.position="relative"},copyImageBorders:function(B){var C,A;C={"borderStyle":true,"borderWidth":true,"borderColor":true};for(A in C)if(C.hasOwnProperty(A))B.vml.color.shape.style[A]=B.currentStyle[A]},vmlFill:function(E){if(!E.currentStyle)return;else{var A,G,C,B,F,D;A=E.currentStyle}for(B in E.vml)if(E.vml.hasOwnProperty(B))E.vml[B].shape.style.zIndex=A.zIndex;E.runtimeStyle.backgroundColor="";E.runtimeStyle.backgroundImage="";G=true;if(A.backgroundImage!="none"||E.isImg){if(!E.isImg){E.vmlBg=A.backgroundImage;E.vmlBg=E.vmlBg.substr(5,E.vmlBg.lastIndexOf("\")")-5)}else E.vmlBg=E.src;C=this;if(!C.imgSize[E.vmlBg]){F=document.createElement("img");C.imgSize[E.vmlBg]=F;F.className=C.ns+"_sizeFinder";F.runtimeStyle.cssText="behavior:none; position:absolute; left:-10000px; top:-10000px; border:none; margin:0; padding:0;";D=function(){this.width=this.offsetWidth;this.height=this.offsetHeight;C.vmlOffsets(E)};F.attachEvent("onload",D);F.src=E.vmlBg;F.removeAttribute("width");F.removeAttribute("height");document.body.insertBefore(F,document.body.firstChild)}E.vml.image.fill.src=E.vmlBg;G=false}E.vml.image.fill.on=!G;E.vml.image.fill.color="none";E.vml.color.shape.style.backgroundColor=A.backgroundColor;E.runtimeStyle.backgroundImage="none";E.runtimeStyle.backgroundColor="transparent"},vmlOffsets:function(H){var K,F,I,J,L,E,A,D,B,C,G;K=H.currentStyle;F={"W":H.clientWidth+1,"H":H.clientHeight+1,"w":this.imgSize[H.vmlBg].width,"h":this.imgSize[H.vmlBg].height,"L":H.offsetLeft,"T":H.offsetTop,"bLW":H.clientLeft,"bTW":H.clientTop};I=(F.L+F.bLW==1)?1:0;J=function(B,E,C,A,F,D){B.coordsize=A+","+F;B.coordorigin=D+","+D;B.path="m0,0l"+A+",0l"+A+","+F+"l0,"+F+" xe";B.style.width=A+"px";B.style.height=F+"px";B.style.left=E+"px";B.style.top=C+"px"};J(H.vml.color.shape,(F.L+(H.isImg?0:F.bLW)),(F.T+(H.isImg?0:F.bTW)),(F.W-1),(F.H-1),0);J(H.vml.image.shape,(F.L+F.bLW),(F.T+F.bTW),(F.W),(F.H),1);L={"X":0,"Y":0};if(H.isImg){L.X=parseInt(K.paddingLeft,10)+1;L.Y=parseInt(K.paddingTop,10)+1}else for(B in L)if(L.hasOwnProperty(B))this.figurePercentage(L,F,B,K["backgroundPosition"+B]);H.vml.image.fill.position=(L.X/F.W)+","+(L.Y/F.H);E=K.backgroundRepeat;A={"T":1,"R":F.W+I,"B":F.H,"L":1+I};D={"X":{"b1":"L","b2":"R","d":"W"},"Y":{"b1":"T","b2":"B","d":"H"}};if(E!="repeat"||H.isImg){C={"T":(L.Y),"R":(L.X+F.w),"B":(L.Y+F.h),"L":(L.X)};if(E.search("repeat-")!=-1){G=E.split("repeat-")[1].toUpperCase();C[D[G].b1]=1;C[D[G].b2]=F[D[G].d]}if(C.B>F.H)C.B=F.H;H.vml.image.shape.style.clip="rect("+C.T+"px "+(C.R+I)+"px "+C.B+"px "+(C.L+I)+"px)"}else H.vml.image.shape.style.clip="rect("+A.T+"px "+A.R+"px "+A.B+"px "+A.L+"px)"},figurePercentage:function(E,F,B,A){var D,C;C=true;D=(B=="X");switch(A){case"left":case"top":E[B]=0;break;case"center":E[B]=0.5;break;case"right":case"bottom":E[B]=1;break;default:if(A.search("%")!=-1)E[B]=parseInt(A,10)/100;else C=false}E[B]=Math.ceil(C?((F[D?"W":"H"]*E[B])-(F[D?"w":"h"]*E[B])):parseInt(A,10));if(E[B]%2===0)E[B]++;return E[B]},fixPng:function(D){D.style.behavior="none";var C,F,E,A,B;if(D.nodeName=="BODY"||D.nodeName=="TD"||D.nodeName=="TR")return;D.isImg=false;if(D.nodeName=="IMG"){if(D.src.toLowerCase().search(/\.png$/)!=-1){D.isImg=true;D.style.visibility="hidden"}else return}else if(D.currentStyle.backgroundImage.toLowerCase().search(".png")==-1)return;C=DD_PNG;D.vml={color:{},image:{}};F={shape:{},fill:{}};for(A in D.vml)if(D.vml.hasOwnProperty(A)){for(B in F)if(F.hasOwnProperty(B)){E=C.ns+":"+B;D.vml[A][B]=document.createElement(E)}D.vml[A].shape.stroked=false;D.vml[A].shape.appendChild(D.vml[A].fill);D.parentNode.insertBefore(D.vml[A].shape,D)}D.vml.image.shape.fillcolor="none";if(D.nodeName=="IMG")D.vml.image.fill.type="frame";else D.vml.image.fill.type="tile";D.vml.color.fill.on=false;C.attachHandlers(D);C.giveLayout(D);C.giveLayout(D.offsetParent);D.vmlInitiated=true;C.applyVML(D)}};try{document.execCommand("BackgroundImageCache",false,true)}catch(r){}DD_PNG.createVmlNameSpace();DD_PNG.createVmlStyleSheet()