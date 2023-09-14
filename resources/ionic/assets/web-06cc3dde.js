import{W as p,C as o,a as l,b as d}from"./Report-afe60be0.js";import"./index-74f59664.js";import"./datetime-49c8e94e.js";import"./ReportInterfaces-ea53f22d.js";import"./_plugin-vue_export-helper-c27b6911.js";class u extends p{async getPhoto(e){return new Promise(async(t,a)=>{if(e.webUseInput||e.source===o.Photos)this.fileInputExperience(e,t);else if(e.source===o.Prompt){let i=document.querySelector("pwa-action-sheet");i||(i=document.createElement("pwa-action-sheet"),document.body.appendChild(i)),i.header=e.promptLabelHeader||"Photo",i.cancelable=!1,i.options=[{title:e.promptLabelPhoto||"From Photos"},{title:e.promptLabelPicture||"Take Picture"}],i.addEventListener("onSelection",async n=>{n.detail===0?this.fileInputExperience(e,t):this.cameraExperience(e,t,a)})}else this.cameraExperience(e,t,a)})}async pickImages(e){return new Promise(async t=>{this.multipleFileInputExperience(t)})}async cameraExperience(e,t,a){if(customElements.get("pwa-camera-modal")){const i=document.createElement("pwa-camera-modal");i.facingMode=e.direction===l.Front?"user":"environment",document.body.appendChild(i);try{await i.componentOnReady(),i.addEventListener("onPhoto",async n=>{const r=n.detail;r===null?a(new d("User cancelled photos app")):r instanceof Error?a(r):t(await this._getCameraPhoto(r,e)),i.dismiss(),document.body.removeChild(i)}),i.present()}catch(n){this.fileInputExperience(e,t)}}else console.error("Unable to load PWA Element 'pwa-camera-modal'. See the docs: https://capacitorjs.com/docs/web/pwa-elements."),this.fileInputExperience(e,t)}fileInputExperience(e,t){let a=document.querySelector("#_capacitor-camera-input");const i=()=>{var n;(n=a.parentNode)===null||n===void 0||n.removeChild(a)};a||(a=document.createElement("input"),a.id="_capacitor-camera-input",a.type="file",a.hidden=!0,document.body.appendChild(a),a.addEventListener("change",n=>{const r=a.files[0];let c="jpeg";if(r.type==="image/png"?c="png":r.type==="image/gif"&&(c="gif"),e.resultType==="dataUrl"||e.resultType==="base64"){const s=new FileReader;s.addEventListener("load",()=>{if(e.resultType==="dataUrl")t({dataUrl:s.result,format:c});else if(e.resultType==="base64"){const m=s.result.split(",")[1];t({base64String:m,format:c})}i()}),s.readAsDataURL(r)}else t({webPath:URL.createObjectURL(r),format:c}),i()})),a.accept="image/*",a.capture=!0,e.source===o.Photos||e.source===o.Prompt?a.removeAttribute("capture"):e.direction===l.Front?a.capture="user":e.direction===l.Rear&&(a.capture="environment"),a.click()}multipleFileInputExperience(e){let t=document.querySelector("#_capacitor-camera-input-multiple");const a=()=>{var i;(i=t.parentNode)===null||i===void 0||i.removeChild(t)};t||(t=document.createElement("input"),t.id="_capacitor-camera-input-multiple",t.type="file",t.hidden=!0,t.multiple=!0,document.body.appendChild(t),t.addEventListener("change",i=>{const n=[];for(let r=0;r<t.files.length;r++){const c=t.files[r];let s="jpeg";c.type==="image/png"?s="png":c.type==="image/gif"&&(s="gif"),n.push({webPath:URL.createObjectURL(c),format:s})}e({photos:n}),a()})),t.accept="image/*",t.click()}_getCameraPhoto(e,t){return new Promise((a,i)=>{const n=new FileReader,r=e.type.split("/")[1];t.resultType==="uri"?a({webPath:URL.createObjectURL(e),format:r,saved:!1}):(n.readAsDataURL(e),n.onloadend=()=>{const c=n.result;t.resultType==="dataUrl"?a({dataUrl:c,format:r,saved:!1}):a({base64String:c.split(",")[1],format:r,saved:!1})},n.onerror=c=>{i(c)})})}async checkPermissions(){if(typeof navigator>"u"||!navigator.permissions)throw this.unavailable("Permissions API not available in this browser");try{return{camera:(await window.navigator.permissions.query({name:"camera"})).state,photos:"granted"}}catch(e){throw this.unavailable("Camera permissions are not available in this browser")}}async requestPermissions(){throw this.unimplemented("Not implemented on web.")}async pickLimitedLibraryPhotos(){throw this.unavailable("Not implemented on web.")}async getLimitedLibraryPhotos(){throw this.unavailable("Not implemented on web.")}}const P=new u;export{P as Camera,u as CameraWeb};
