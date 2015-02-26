var __mmapiwsStateLendable = {}, __mmapiwsRunLendable = function (flashFonts, flashStoredId) {
    "use strict";
    if (!__mmapiwsStateLendable.alreadyRan) {
        __mmapiwsStateLendable.alreadyRan = !0;
        var fontsToTry = ["Abadi MT Condensed Light", "Adobe Fangsong Std", "Adobe Hebrew", "Adobe Ming Std", "Agency FB", "Arab", "Arabic Typesetting", "Arial Black", "Batang", "Bauhaus 93", "Bell MT", "Bitstream Vera Serif", "Bodoni MT", "Bookman Old Style", "Braggadocio", "Broadway", "Calibri", "Californian FB", "Castellar", "Casual", "Centaur", "Century Gothic", "Chalkduster", "Colonna MT", "Copperplate Gothic Light", "DejaVu LGC Sans Mono", "Desdemona", "DFKai-SB", "Dotum", "Engravers MT", "Eras Bold ITC", "Eurostile", "FangSong", "Forte", "Franklin Gothic Heavy", "French Script MT", "Gabriola", "Gigi", "Gisha", "Goudy Old Style", "Gulim", "GungSeo", "Haettenschweiler", "Harrington", "Hiragino Sans GB", "Impact", "Informal Roman", "KacstOne", "Kino MT", "Kozuka Gothic Pr6N", "Lohit Gujarati", "Loma", "Lucida Bright", "Lucida Fax", "Magneto", "Malgun Gothic", "Matura MT Script Capitals", "Menlo", "MingLiU-ExtB", "MoolBoran", "MS PMincho", "MS Reference Sans Serif", "News Gothic MT", "Niagara Solid", "Nyala", "Palace Script MT", "Papyrus", "Perpetua", "Playbill", "PMingLiU", "Rachana", "Rockwell", "Sawasdee", "Script MT Bold", "Segoe Print", "Showcard Gothic", "SimHei", "Snap ITC", "TlwgMono", "Tw Cen MT Condensed Extra Bold", "Ubuntu", "Umpush", "Univers", "Utopia", "Vladimir Script", "Wide Latin"], pluginsToTry = ["4game", "AdblockPlugin", "AdobeExManCCDetect", "AdobeExManDetect", "Alawar NPAPI utils", "Aliedit Plug-In", "Alipay Security Control 3", "AliSSOLogin plugin", "AmazonMP3DownloaderPlugin", "AOL Media Playback Plugin", "AppUp", "ArchiCAD", "AVG SiteSafety plugin", "Babylon ToolBar", "Battlelog Game Launcher", "BitCometAgent", "Bitdefender QuickScan", "BlueStacks Install Detector", "CatalinaGroup Update", "Citrix ICA Client", "Citrix online plug-in", "Citrix Receiver Plug-in", "Coowon Update", "DealPlyLive Update", "Default Browser Helper", "DivX Browser Plug-In", "DivX Plus Web Player", "DivX VOD Helper Plug-in", "doubleTwist Web Plugin", "Downloaders plugin", "downloadUpdater", "eMusicPlugin DLM6", "ESN Launch Mozilla Plugin", "ESN Sonar API", "Exif Everywhere", "Facebook Plugin", "File Downloader Plug-in", "FileLab plugin", "FlyOrDie Games Plugin", "Folx 3 Browser Plugin", "FUZEShare", "GDL Object Web Plug-in 16.00", "GFACE Plugin", "Ginger", "Gnome Shell Integration", "Google Earth Plugin", "Google Earth Plug-in", "Google Gears 0.5.33.0", "Google Talk Effects Plugin", "Google Update", "Harmony Firefox Plugin", "Harmony Plug-In", "Heroes & Generals live", "HPDetect", "Html5 location provider", "IE Tab plugin", "iGetterScriptablePlugin", "iMesh plugin", "Kaspersky Password Manager", "LastPass", "LogMeIn Plugin 1.0.0.935", "LogMeIn Plugin 1.0.0.961", "Ma-Config.com plugin", "Microsoft Office 2013", "MinibarPlugin", "Native Client", "Nitro PDF Plug-In", "Nokia Suite Enabler Plugin", "Norton Identity Safe", "npAPI Plugin", "NPLastPass", "NPPlayerShell", "npTongbuAddin", "NyxLauncher", "Octoshape Streaming Services", "Online Storage plug-in", "Orbit Downloader", "Pando Web Plugin", "Parom.TV player plugin", "PDF integrado do WebKit", "PDF-XChange Viewer", "PhotoCenterPlugin1.1.2.2", "Picasa", "PlayOn Plug-in", "QQ2013 Firefox Plugin", "QQDownload Plugin", "QQMiniDL Plugin", "QQMusic", "RealDownloader Plugin", "Roblox Launcher Plugin", "RockMelt Update", "Safer Update", "SafeSearch", "Scripting.Dictionary", "SefClient Plugin", "Shell.UIHelper", "Silverlight Plug-In", "Simple Pass", "Skype Web Plugin", "SumatraPDF Browser Plugin", "Symantec PKI Client", "Tencent FTN plug-in", "Thunder DapCtrl NPAPI Plugin", "TorchHelper", "Unity Player", "Uplay PC", "VDownloader", "Veetle TV Core", "VLC Multimedia Plugin", "Web Components", "WebKit-integrierte PDF", "WEBZEN Browser Extension", "Wolfram Mathematica", "WordCaptureX", "WPI Detector 1.4", "Yandex Media Plugin", "Yandex PDF Viewer", "YouTube Plug-in", "zako"], murmurhash3 = function (key, seed) {
            var remainder, bytes, h1, h1b, c1, c2, k1, i;
            for (remainder = 3 & key.length, bytes = key.length - remainder, h1 = seed, c1 = 3432918353, c2 = 461845907, i = 0; bytes > i;)k1 = 255 & key.charCodeAt(i) | (255 & key.charCodeAt(++i)) << 8 | (255 & key.charCodeAt(++i)) << 16 | (255 & key.charCodeAt(++i)) << 24, ++i, k1 = (65535 & k1) * c1 + (((k1 >>> 16) * c1 & 65535) << 16) & 4294967295, k1 = k1 << 15 | k1 >>> 17, k1 = (65535 & k1) * c2 + (((k1 >>> 16) * c2 & 65535) << 16) & 4294967295, h1 ^= k1, h1 = h1 << 13 | h1 >>> 19, h1b = 5 * (65535 & h1) + ((5 * (h1 >>> 16) & 65535) << 16) & 4294967295, h1 = (65535 & h1b) + 27492 + (((h1b >>> 16) + 58964 & 65535) << 16);
            switch (k1 = 0, remainder) {
                case 3:
                    k1 ^= (255 & key.charCodeAt(i + 2)) << 16;
                case 2:
                    k1 ^= (255 & key.charCodeAt(i + 1)) << 8;
                case 1:
                    k1 ^= 255 & key.charCodeAt(i), k1 = (65535 & k1) * c1 + (((k1 >>> 16) * c1 & 65535) << 16) & 4294967295, k1 = k1 << 15 | k1 >>> 17, k1 = (65535 & k1) * c2 + (((k1 >>> 16) * c2 & 65535) << 16) & 4294967295, h1 ^= k1
            }
            return h1 ^= key.length, h1 ^= h1 >>> 16, h1 = 2246822507 * (65535 & h1) + ((2246822507 * (h1 >>> 16) & 65535) << 16) & 4294967295, h1 ^= h1 >>> 13, h1 = 3266489909 * (65535 & h1) + ((3266489909 * (h1 >>> 16) & 65535) << 16) & 4294967295, h1 ^= h1 >>> 16, h1 >>> 0
        }, Detector = function () {
            var baseFonts = ["monospace", "sans-serif", "serif"], baseFontSizes = [], testString = "mmmmmmmmmmlli", testSize = "72px", body = document.body, span = document.createElement("span");
            span.style.fontSize = testSize, span.style.visibility = "hidden", span.innerHTML = testString;
            for (var calculateFontSize = function (name) {
                var size = {};
                return span.style.fontFamily = name, body.appendChild(span), size.height = span.offsetHeight, size.width = span.offsetWidth, body.removeChild(span), size
            }, i = 0; i < baseFonts.length; i++)baseFontSizes[i] = calculateFontSize(baseFonts[i]);
            this.detect = function (font) {
                for (var i = 0; i < baseFontSizes.length; i++) {
                    var fontSize = calculateFontSize(font + "," + baseFonts[i]), baseFontSize = baseFontSizes[i];
                    if (fontSize.height !== baseFontSize.height || fontSize.width !== baseFontSize.width)return !0
                }
                return !1
            }
        }, getCanvas2dHash = function () {
            var canvas, context;
            try {
                canvas = document.createElement("canvas"), context = canvas.getContext("2d")
            } catch (e) {
            }
            if (context)return context.fillStyle = "red", context.fillRect(30, 10, 200, 100), context.strokeStyle = "#1a3bc1", context.lineWidth = 6, context.lineCap = "round", context.arc(50, 50, 20, 0, Math.PI, !1), context.stroke(), context.fillStyle = "#42e1a2", context.font = "15.4px 'Arial'", context.textBaseline = "alphabetic", context.fillText("PR flacks quiz gym: TV DJ box when? â˜ ", 15, 60), context.shadowOffsetX = 1, context.shadowOffsetY = 2, context.shadowColor = "white", context.fillStyle = "rgba(0, 0, 200, 0.5)", context.font = "60px 'Not a real font'", context.fillText("Noéª—", 40, 80), murmurhash3(canvas.toDataURL())
        }, getFonts = function () {
            if (flashFonts)return flashFonts;
            for (var fonts = [], fontDetector = new Detector, i = 0; i < fontsToTry.length; i++) {
                var font = fontsToTry[i];
                fontDetector.detect(font) && fonts.push(font)
            }
            return fonts
        }, getNavigatorProperties = function () {
            var nav = {}, order = [];
            for (var property in navigator)"object" != typeof navigator[property] && (nav[property] = navigator[property]), order.push(property);
            nav.enumerationOrder = order, nav.javaEnabled = navigator.javaEnabled();
            try {
                nav.taintEnabled = navigator.taintEnabled()
            } catch (e) {
            }
            return nav
        }, getPluginsForOldIE = function () {
            for (var plugins = [], extensionsToTry = ["AcroPDF.PDF", "Adodb.Stream", "AgControl.AgControl", "DevalVRXCtrl.DevalVRXCtrl.1", "MacromediaFlashPaper.MacromediaFlashPaper", "Msxml2.DOMDocument", "Msxml2.XMLHTTP", "PDF.PdfCtrl", "QuickTime.QuickTime", "QuickTimeCheckObject.QuickTimeCheck.1", "RealPlayer", "RealPlayer.RealPlayer(tm) ActiveX Control (32-bit)", "RealVideo.RealVideo(tm) ActiveX Control (32-bit)", "rmocx.RealPlayer G2 Control", "Scripting.Dictionary", "Shell.UIHelper", "ShockwaveFlash.ShockwaveFlash", "SWCtl.SWCtl", "TDCCtl.TDCCtl", "WMPlayer.OCX"], i = 0; i < extensionsToTry.length; i++) {
                var plugin = extensionsToTry[i];
                try {
                    var obj = new ActiveXObject(plugin), p = {name: plugin};
                    try {
                        p.version = obj.GetVariable("$version")
                    } catch (e) {
                    }
                    plugins.push(p)
                } catch (e) {
                }
            }
            return plugins
        }, getPluginsForOtherBrowsers = function () {
            var plugin, i, name, plugins = [], seen = {};
            for (i = 0; i < navigator.plugins.length; i++)plugin = navigator.plugins[i], seen[plugin.name] = 1, plugins.push(getPluginProperties(plugin));
            for (i = 0; i < pluginsToTry.length; i++)name = pluginsToTry[i], seen[name] || (plugin = navigator.plugins[name], plugin && plugins.push(getPluginProperties(plugin)));
            return plugins
        }, getPluginProperties = function (plugin) {
            var p = {name: plugin.name, filename: plugin.filename.toLowerCase(), description: plugin.description};
            "undefined" != typeof plugin.version && (p.version = plugin.version), p.mimeTypes = [];
            for (var j = 0; j < plugin.length; j++) {
                var mime = plugin[j];
                p.mimeTypes.push({description: mime.description, suffixes: mime.suffixes, type: mime.type})
            }
            return p
        }, getPlugins = function () {
            return window.ActiveXObject ? getPluginsForOldIE() : getPluginsForOtherBrowsers()
        }, getScreenProperties = function () {
            for (var screenProperties = ["availHeight", "availWidth", "colorDepth", "deviceXPI", "height", "width"], deviceScreen = {}, i = 0; i < screenProperties.length; i++) {
                var prop = screenProperties[i];
                "undefined" != typeof screen[prop] && (deviceScreen[prop] = screen[prop])
            }
            return deviceScreen
        }, getStoredIds = function () {
            var ids = {};
            return ids.cookie = document.cookie.replace(/(?:(?:^|.*;\s*)__mmapiwsid\s*\=\s*([^;]*).*$)|^.*$/, "$1"), window.localStorage && (ids.localStorage = localStorage.getItem("__mmapiwsid")), flashStoredId && (ids.flash = flashStoredId), __mmapiwsStateLendable.indexedDbId && (ids.indexedDb = __mmapiwsStateLendable.indexedDbId), ids
        }, getSystemColors = function () {
            var div = document.createElement("div"), colors = {}, elements = ["ActiveBorder", "ActiveCaption", "AppWorkspace", "Background", "ButtonFace", "ButtonHighlight", "ButtonShadow", "ButtonText", "CaptionText", "GrayText", "Highlight", "HighlightText", "InactiveBorder", "InactiveCaption", "InactiveCaptionText", "InfoBackground", "InfoText", "Menu", "MenuText", "Scrollbar", "ThreeDDarkShadow", "ThreeDFace", "ThreeDHighlight", "ThreeDLightShadow", "ThreeDShadow", "Window", "WindowFrame", "WindowText"];
            if (!window.getComputedStyle)return colors;
            for (var i = 0; i < elements.length; i++)document.body.appendChild(div), div.style.color = elements[i], colors[elements[i]] = window.getComputedStyle(div).getPropertyValue("color"), document.body.removeChild(div);
            return colors
        }, getWebglHash = function (gl, canvas) {
            var vShaderTemplate = "attribute vec2 attrVertex; varying vec2 varyinTexCoordinate; uniform vec2 uniformOffset; void main() {   varyinTexCoordinate = attrVertex + uniformOffset;   gl_Position = vec4(attrVertex, 0, 1); }", fShaderTemplate = "precision mediump float; varying vec2 varyinTexCoordinate; void main() {   gl_FragColor = vec4(varyinTexCoordinate, 0, 1); }", vertexPosBuffer = gl.createBuffer();
            gl.bindBuffer(gl.ARRAY_BUFFER, vertexPosBuffer);
            var vertices = new Float32Array([-.2, -.9, 0, .4, -.26, 0, 0, .732134444, 0]);
            gl.bufferData(gl.ARRAY_BUFFER, vertices, gl.STATIC_DRAW), vertexPosBuffer.itemSize = 3, vertexPosBuffer.numItems = 3;
            var program = gl.createProgram(), vshader = gl.createShader(gl.VERTEX_SHADER);
            gl.shaderSource(vshader, vShaderTemplate), gl.compileShader(vshader);
            var fshader = gl.createShader(gl.FRAGMENT_SHADER);
            return gl.shaderSource(fshader, fShaderTemplate), gl.compileShader(fshader), gl.attachShader(program, vshader), gl.attachShader(program, fshader), gl.linkProgram(program), gl.useProgram(program), program.vertexPosAttrib = gl.getAttribLocation(program, "attrVertex"), program.offsetUniform = gl.getUniformLocation(program, "uniformOffset"), gl.enableVertexAttribArray(program.vertexPosArray), gl.vertexAttribPointer(program.vertexPosAttrib, vertexPosBuffer.itemSize, gl.FLOAT, !1, 0, 0), gl.uniform2f(program.offsetUniform, 1, 1), gl.drawArrays(gl.TRIANGLE_STRIP, 0, vertexPosBuffer.numItems), murmurhash3(canvas.toDataURL())
        }, getWebgl = function () {
            var gl, canvas = document.createElement("canvas"), props = {};
            try {
                gl = canvas.getContext("webgl") || canvas.getContext("experimental-webgl")
            } catch (e) {
            }
            if (!gl)return props;
            try {
                props.extensions = gl.getSupportedExtensions()
            } catch (e) {
            }
            try {
                props.hash = getWebglHash(gl, canvas)
            } catch (e) {
            }
            return props
        }, setStoredIdForDb = function (value) {
            var db = __mmapiwsStateLendable.db;
            if (db) {
                var storeName = "StoredId", tx = db.transaction(storeName, "readwrite"), store = tx.objectStore(storeName);
                store.put({id: 0, value: value})
            }
        }, setStoredIds = function (domain, value) {
            var key = "__mmapiwsid", date = new Date;
            date.setFullYear(date.getFullYear() + 2), domain || (domain = document.domain), document.cookie = key + "=" + value + "; expires=" + date.toGMTString() + "; domain=" + domain + "; path=/", window.localStorage && localStorage.setItem(key, value);
            var flash = document.getElementById("__mmapiwsFlash");
            flash && "function" == typeof flash.setStoredId && flash.setStoredId(value), setStoredIdForDb(value)
        }, JSON = window.JSON || {}, jsonStringify = JSON.stringify || function (obj) {
                var json, t = typeof obj;
                if ("undefined" === t || null === obj)return "null";
                if ("number" === t || "boolean" === t)return String(obj);
                if ("object" === t && obj && obj.constructor === Array) {
                    json = [];
                    for (var i = 0; i < obj.length; i++)json.push(jsonStringify(obj[i]));
                    return "[" + String(json) + "]"
                }
                if ("object" === t) {
                    var n;
                    json = [];
                    for (n in obj)obj.hasOwnProperty(n) && json.push('"' + n + '":' + jsonStringify(obj[n]));
                    return "{" + String(json) + "}"
                }
                var str = String(obj);
                return str = str.replace(/[\\"']/g, "\\$&").replace(/\u0000/g, "\\0"), '"' + str + '"'
            }, createUri = function (version) {
            return Routing.generate('_alpha_device_fingerprint');
        }, handleResponse = function (xhr, version, device) {
            var responseValues = xhr.responseText.split(/;/), domain = responseValues[0], id = responseValues[1], serverIpVersion = parseInt(responseValues[2], 10);
            "undefined" != typeof id && setStoredIds(domain, id), 6 === version && 6 === serverIpVersion && sendToServer(device, 4)
        }, sendToServer = function (device, version) {
            var xhr, stringified, uri = createUri(version);
            if (device.storedIds = getStoredIds(), stringified = jsonStringify(device), "Microsoft Internet Explorer" === navigator.appName && window.XDomainRequest)xhr = new XDomainRequest, xhr.onload = function () {
                handleResponse(xhr, version)
            }, xhr.onprogress = function () {
            }, xhr.ontimeout = function () {
            }, xhr.onerror = function () {
            }; else {
                try {
                    xhr = new window.XMLHttpRequest
                } catch (e) {
                }
                if (!xhr)try {
                    xhr = new window.ActiveXObject("Microsoft.XMLHTTP")
                } catch (e) {
                }
                if (!xhr)return;
                xhr.onreadystatechange = function () {
                    4 === xhr.readyState && 200 === xhr.status && handleResponse(xhr, version, device)
                }
            }
            try {
                xhr.open("POST", uri, !0), "function" == typeof xhr.setRequestHeader && xhr.setRequestHeader("Content-Type", "text/plain;charset=UTF-8"), xhr.send(stringified)
            } catch (e) {
            }
        }, runDevice = function () {
            var systemColors, date = new Date, userId = "undefined" != typeof survey_height_follow ? survey_height_follow : 1;
            try {
                systemColors = getSystemColors()
            } catch (e) {
            }
            var device = {
                canvas: {"2dHash": getCanvas2dHash(), webgl: getWebgl()},
                deviceTime: date.getTime() / 1e3,
                documentUrl: document.URL,
                documentMode: document.documentMode,
                fonts: getFonts(),
                navigator: getNavigatorProperties(),
                plugins: getPlugins(),
                screen: getScreenProperties(),
                systemColors: systemColors,
                timezoneOffset: date.getTimezoneOffset(),
                userId: userId
            };
            sendToServer(device, 6)
        };
        runDevice()
    }
};
!function () {
    "use strict";
    if (!document.__mmapiwsStateTestingDevice) {
        var storeName = "StoredIdLendable", retrieveDbId = function (db) {
            var tx = db.transaction(storeName, "readonly"), store = tx.objectStore(storeName), req = store.get(0);
            req.onsuccess = function (evt) {
                var record = evt.target.result;
                record && (__mmapiwsStateLendable.indexedDbId = record.value)
            }
        }, openDb = function () {
            if (window.indexedDB) {
                var req = indexedDB.open("__mmapiwsDbLendable", 1);
                req.onsuccess = function () {
                    __mmapiwsStateLendable.db = this.result, retrieveDbId(__mmapiwsStateLendable.db)
                }, req.onerror = function (evt) {
                    console.error("openDb:", evt.target.errorCode)
                }, req.onupgradeneeded = function (evt) {
                    evt.currentTarget.result.createObjectStore(storeName, {keyPath: "id"})
                }
            }
        }, maybeSetupFlash = function () {
            try{
                if (navigator.mimeTypes && navigator.mimeTypes["application/x-shockwave-flash"] && navigator.mimeTypes["application/x-shockwave-flash"].enabledPlugin || window.ActiveXObject && new ActiveXObject("ShockwaveFlash.ShockwaveFlash")) {
                    var flash = document.createElement("embed");
                    flash.src = document.location.protocol + "//device.maxmind.com/flash/Device.swf", flash.id = "__mmapiwsFlash", flash.setAttribute("allowscriptaccess", "always"), flash.style.height = 0, flash.style.width = 0, flash.style.overflow = "hidden", flash.style.position = "fixed", flash.style.right = "100%", document.body.appendChild(flash)
                }
            } catch(e){}
        }, ready = function () {
            openDb(), "undefined" != typeof document.body && document.body ? (maybeSetupFlash(), setTimeout(__mmapiwsRunLendable, 1e3)) : setTimeout(ready, 500)
        };
        ready()
    }
}();