import{aS as n,aT as s,aU as a,aV as c}from"./index-add551ec.js";var p=':host{z-index:1000;position:fixed;top:0;left:0;width:100%;height:100%;display:-ms-flexbox;display:flex;contain:strict;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;font-family:-apple-system, BlinkMacSystemFont, "Helvetica Neue", "Roboto", sans-serif}.wrapper{-ms-flex:1;flex:1;display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center;-ms-flex-pack:center;justify-content:center;background-color:rgba(0, 0, 0, 0);-webkit-transition:400ms background-color cubic-bezier(.36,.66,.04,1);transition:400ms background-color cubic-bezier(.36,.66,.04,1)}.wrapper.open{background-color:rgba(0, 0, 0, 0.32)}.title{color:#999;height:23px;line-height:23px;padding-bottom:17px;-webkit-padding-end:16px;padding-inline-end:16px;-webkit-padding-start:16px;padding-inline-start:16px;padding-left:16px;padding-right:16px;padding-top:20px}.content{width:568px;-ms-flex-item-align:end;align-self:flex-end;background-color:#fff;-webkit-transition:400ms -webkit-transform cubic-bezier(.36,.66,.04,1);transition:400ms -webkit-transform cubic-bezier(.36,.66,.04,1);transition:400ms transform cubic-bezier(.36,.66,.04,1);transition:400ms transform cubic-bezier(.36,.66,.04,1), 400ms -webkit-transform cubic-bezier(.36,.66,.04,1);-webkit-transform:translateY(100%);transform:translateY(100%)}.wrapper.open .content{-webkit-transform:translateY(0%);transform:translateY(0%)}@media only screen and (max-width: 568px){.content{width:100%}}.action-sheet-option{cursor:pointer;height:52px;line-height:52px}.action-sheet-button{color:rgb(38, 38, 38);font-size:16px;-webkit-padding-end:16px;padding-inline-end:16px;-webkit-padding-start:16px;padding-inline-start:16px;padding-left:16px;padding-right:16px;padding-top:0px}.action-sheet-button:hover{background-color:#F6F6F6}',l=function(){function t(e){a(this,e),this.onSelection=c(this,"onSelection",7),this.header=void 0,this.cancelable=!0,this.options=[],this.open=!1}return t.prototype.componentDidLoad=function(){var e=this;requestAnimationFrame(function(){e.open=!0})},t.prototype.dismiss=function(){this.cancelable&&this.close()},t.prototype.close=function(){var e=this;this.open=!1,setTimeout(function(){e.el.parentNode.removeChild(e.el)},500)},t.prototype.handleOptionClick=function(e,i){e.stopPropagation(),this.onSelection.emit(i),this.close()},t.prototype.render=function(){var e=this;return n("div",{class:"wrapper".concat(this.open?" open":""),onClick:function(){return e.dismiss()}},n("div",{class:"content"},n("div",{class:"title"},this.header),this.options.map(function(i,o){return n("div",{class:"action-sheet-option",onClick:function(r){return e.handleOptionClick(r,o)}},n("div",{class:"action-sheet-button"},i.title))})))},Object.defineProperty(t.prototype,"el",{get:function(){return s(this)},enumerable:!1,configurable:!0}),t}();l.style=p;export{l as pwa_action_sheet};
