( () => {
        "use strict";
        var n = {
            410: (n, r, t) => {
                n.exports = t.p + "c99813d512369d25e0e6.svg"
            }
            ,
            928: (n, r, t) => {
                n.exports = t.p + "128d33617fc6b3f587e7.png"
            }
            ,
            362: (n, r, t) => {
                n.exports = t.p + "d8e7444b27513095739f.png"
            }
            ,
            43: n => {
                n.exports = function(n) {
                    var r = [];
                    return r.toString = function() {
                        return this.map((function(r) {
                                var t = n(r);
                                return r[2] ? "@media ".concat(r[2], " {").concat(t, "}") : t
                            }
                        )).join("")
                    }
                        ,
                        r.i = function(n, t, e) {
                            "string" == typeof n && (n = [[null, n, ""]]);
                            var o = {};
                            if (e)
                                for (var a = 0; a < this.length; a++) {
                                    var i = this[a][0];
                                    null != i && (o[i] = !0)
                                }
                            for (var s = 0; s < n.length; s++) {
                                var l = [].concat(n[s]);
                                e && o[l[0]] || (t && (l[2] ? l[2] = "".concat(t, " and ").concat(l[2]) : l[2] = t),
                                    r.push(l))
                            }
                        }
                        ,
                        r
                }
            }
            ,
            63: n => {
                n.exports = function(n, r) {
                    return r || (r = {}),
                        "string" != typeof (n = n && n.__esModule ? n.default : n) ? n : (/^['"].*['"]$/.test(n) && (n = n.slice(1, -1)),
                        r.hash && (n += r.hash),
                            /["'() \t\n]/.test(n) || r.needQuotes ? '"'.concat(n.replace(/"/g, '\\"').replace(/\n/g, "\\n"), '"') : n)
                }
            }
            ,
            28: (n, r, t) => {
                t.d(r, {
                    Z: () => g
                });
                var e = t(43)
                    , o = t.n(e)
                    , a = t(63)
                    , i = t.n(a)
                    , s = t(928)
                    , l = t(362)
                    , d = t(410)
                    , m = o()((function(n) {
                        return n[1]
                    }
                ))
                    , c = i()(s)
                    , p = i()(l)
                    , b = i()(d);
                m.push([n.id, "@font-face {\r\n    font-family: 'BOG';\r\n    src: url('https://webstatic.bog.ge/fonts/BOG/BOG-Regular.eot');\r\n    src: url('https://webstatic.bog.ge/fonts/BOG/BOG-Regular.eot?#iefix') format('embedded-opentype'),\r\n    url('https://webstatic.bog.ge/fonts/BOG/BOG-Regular.woff2') format('woff2'),\r\n    url('https://webstatic.bog.ge/fonts/BOG/BOG-Regular.woff') format('woff'),\r\n    url('https://webstatic.bog.ge/fonts/BOG/BOG-Regular.ttf') format('truetype'),\r\n    url('https://webstatic.bog.ge/fonts/BOG/BOG-Regular.svg#BOG-Regular') format('svg');\r\n    font-weight: normal;\r\n    font-style: normal;\r\n    font-display: swap;\r\n}\r\n@font-face {\r\n    font-family: 'BOG Headline';\r\n    src: url('https://webstatic.bog.ge/fonts/BOG/BOG-Headline-Medium.eot');\r\n    src: url('https://webstatic.bog.ge/fonts/BOG/BOG-Headline-Medium.eot?#iefix') format('embedded-opentype'),\r\n    url('https://webstatic.bog.ge/fonts/BOG/BOG-Headline-Medium.woff2') format('woff2'),\r\n    url('https://webstatic.bog.ge/fonts/BOG/BOG-Headline-Medium.woff') format('woff'),\r\n    url('https://webstatic.bog.ge/fonts/BOG/BOG-Headline-Medium.ttf') format('truetype'),\r\n    url('https://webstatic.bog.ge/fonts/BOG/BOG-Headline-Medium.svg#BOG-Headline-Medium') format('svg');\r\n    font-weight: 500;\r\n    font-style: normal;\r\n    font-display: swap;\r\n}\r\n@font-face {\r\n    font-family: 'BOG';\r\n    src: url('https://webstatic.bog.ge/fonts/BOG/BOG-SemiBold.eot');\r\n    src: url('https://webstatic.bog.ge/fonts/BOG/BOG-SemiBold.eot?#iefix') format('embedded-opentype'),\r\n    url('https://webstatic.bog.ge/fonts/BOG/BOG-SemiBold.woff2') format('woff2'),\r\n    url('https://webstatic.bog.ge/fonts/BOG/BOG-SemiBold.woff') format('woff'),\r\n    url('https://webstatic.bog.ge/fonts/BOG/BOG-SemiBold.ttf') format('truetype'),\r\n    url('https://webstatic.bog.ge/fonts/BOG/BOG-SemiBold.svg#BOG-SemiBold') format('svg');\r\n    font-weight: 600;\r\n    font-style: normal;\r\n    font-display: swap;\r\n}\r\n.bog-smart-button,\r\n.bog-smart-button *,\r\n.bog-smart-modal,\r\n.bog-smart-modal * {\r\n    line-height: normal !important;\r\n    box-sizing: border-box !important;\r\n}\r\n.bog-smart-button {\r\n    display: inline-flex;\r\n    align-items: stretch;\r\n    overflow: hidden;\r\n    box-sizing: border-box !important;\r\n    width: auto;\r\n    height: 32px;\r\n    max-height: 32px;\r\n    cursor: pointer;\r\n    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);\r\n    color: rgba(255, 255, 255, 0.92);\r\n    background-color: #ff600a;\r\n    border-radius: 4px;\r\n    font-family: BOG Headline;\r\n    font-weight: 500;\r\n    font-size: 14px;\r\n    text-transform: uppercase;\r\n    transition:  opacity 200ms ease-in-out,\r\n            color 200ms ease-in-out,\r\n            background-color 200ms ease-in-out,\r\n            box-shadow 200ms ease-in-out;\r\n    user-select: none;\r\n    padding: 0 8px;\r\n}\r\n.bog-smart-button .bog-smart-button-container {\r\n    position: relative;\r\n    display: flex;\r\n    align-items: center;\r\n    justify-content: center;\r\n    flex-grow: 1;\r\n    padding: 0 8px;\r\n    color: inherit;\r\n    text-decoration: none;\r\n}\r\n.bog-smart-button:hover {\r\n    background-color: #ff6c1d;\r\n    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1);\r\n}\r\n.bog-smart-button:active, .bog-smart-button:focus, .bog-smart-button:visited {\r\n    background-color: #ff600a;\r\n    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);\r\n}\r\n.bog-smart-button .bog-smart-button-dots-loader {\r\n    position: absolute;\r\n    width: 38px;\r\n    height: 8px;\r\n    display: none;\r\n    flex-direction: row;\r\n    justify-content: space-around;\r\n    opacity: 0.8;\r\n}\r\n.bog-smart-button.bog-smart-button-loading {\r\n    pointer-events: none;\r\n}\r\n.bog-smart-button.bog-smart-button-loading .bog-smart-button-container span {\r\n    visibility: hidden;\r\n}\r\n.bog-smart-button.bog-smart-button-loading .bog-smart-button-dots-loader {\r\n    display: flex;\r\n}\r\n@keyframes OpacityAnimation {\r\n    0%{opacity:0}\r\n    50%{opacity:1}\r\n    100%{opacity:0}\r\n}\r\n.bog-smart-button .bog-smart-button-dots-loader .bog-smart-button-dots-loader-dot {\r\n    width: 8px;\r\n    height: 8px;\r\n    background-color: rgba(255, 255, 255, 0.92);\r\n    border-radius: 50%;\r\n    animation: 1s linear 0s infinite normal none running OpacityAnimation;\r\n}\r\n@keyframes modal-reveal {\r\n    0% {\r\n        opacity: 0;\r\n    }\r\n    100% {\r\n        opacity: 1;\r\n    }\r\n}\r\n@keyframes modal-close {\r\n    0% {\r\n        opacity: 1;\r\n    }\r\n    100% {\r\n        opacity: 0;\r\n    }\r\n}\r\n@keyframes modal-container-reveal {\r\n    0% {\r\n        transform: translate(-50%, -50%) scale(0.7);\r\n    }\r\n    100% {\r\n        transform: translate(-50%, -50%) scale(1);\r\n    }\r\n}\r\n@keyframes modal-container-close {\r\n    0% {\r\n        transform: translate(-50%, -50%) scale(1);\r\n    }\r\n    100% {\r\n        transform: translate(-50%, -50%) scale(0.7);\r\n    }\r\n}\r\n@keyframes modal-container-reveal-responsive {\r\n    0% {\r\n        transform: translate(-50%, 100%) scale(1);\r\n    }\r\n    100% {\r\n        transform: translate(-50%, 0%) scale(1);\r\n    }\r\n}\r\n@keyframes modal-container-close-responsive {\r\n    0% {\r\n        transform: translate(-50%, 0%) scale(1);\r\n    }\r\n    100% {\r\n        transform: translate(-50%, 100%) scale(1);\r\n    }\r\n}\r\n.bog-smart-modal {\r\n    display: flex;\r\n    position: fixed;\r\n    z-index: 99999;\r\n    left: 0;\r\n    top: 0;\r\n    letter-spacing: 0;\r\n    width: 100%;\r\n    height: 100%;\r\n    overflow: hidden;\r\n    background: rgba(0, 0, 0, 0.68);\r\n    -webkit-tap-highlight-color: transparent;\r\n}\r\n.bog-smart-modal:not(.bog-smart-modal-close) {\r\n    animation: modal-reveal 100ms ease-in-out forwards;\r\n}\r\n.bog-smart-modal.bog-smart-modal-close {\r\n    animation: modal-close 100ms ease-in-out forwards;\r\n}\r\n.bog-smart-modal .bog-smart-modal-loader {\r\n    display: flex;\r\n    position: fixed;\r\n    top: 50%;\r\n    left: 50%;\r\n    transform: translate(-50%, -50%);\r\n    width: 38px;\r\n    height: 8px;\r\n    display: flex;\r\n    flex-direction: row;\r\n    justify-content: space-around;\r\n    opacity: 0.8;\r\n}\r\n.bog-smart-modal .bog-smart-modal-loader .bog-smart-modal-loader-dot {\r\n    width: 8px;\r\n    height: 8px;\r\n    background-color: #ffa400;\r\n    border-radius: 50%;\r\n    animation: OpacityAnimation 1s linear infinite;\r\n}\r\n.bog-smart-modal .bog-smart-modal-loader .bog-smart-modal-loader-dot:nth-child(2) {\r\n    animation-delay: 0.1s;\r\n}\r\n.bog-smart-modal .bog-smart-modal-loader .bog-smart-modal-loader-dot:nth-child(3) {\r\n    animation-delay: 0.2s;\r\n}\r\n@keyframes OpacityAnimation {\r\n    0%{opacity:0}\r\n    50%{opacity:1}\r\n    100%{opacity:0}\r\n}\r\n.bog-smart-modal .bog-smart-modal-wrapper {\r\n    display: flex;\r\n    flex-direction: column;\r\n    justify-content: flex-start;\r\n    align-items: stretch;\r\n    flex-grow: 0;\r\n    position: fixed;\r\n    top: 50%;\r\n    left: 50%;\r\n    transform: translate(-50%, -50%);\r\n    z-index: 2;\r\n    background-color: #fefefe;\r\n    max-width: 564px;\r\n    width: 100%;\r\n    min-height: 355px;\r\n    border-radius: 20px;\r\n    box-shadow: 0 12px 24px 0 rgba(0, 0, 0, 0.1);\r\n    letter-spacing: 0px;\r\n    padding: 32px;\r\n}\r\n.bog-smart-modal:not(.bog-smart-modal-close) .bog-smart-modal-wrapper {\r\n    animation: modal-container-reveal 300ms ease-in-out forwards;\r\n}\r\n.bog-smart-modal.bog-smart-modal-close .bog-smart-modal-wrapper {\r\n    animation: modal-container-close 300ms ease-in-out forwards;\r\n}\r\n.bog-smart-modal .bog-smart-modal-wrapper .bog-smart-modal-header {\r\n    display: flex;\r\n    justify-content: space-between;\r\n    align-items: center;\r\n    padding: 16px 0;\r\n    box-sizing: border-box !important;\r\n    border-bottom: 1px solid rgba(0, 0, 0, 0.07);\r\n}\r\n.bog-smart-modal .bnpl .bog-smart-modal-header {\r\n    justify-content: flex-end;\r\n    background-image: url(" + c + ");\r\n    background-repeat: no-repeat;\r\n    background-position: center;\r\n    border-bottom: none;\r\n}\r\n.bog-smart-modal .bog-smart-modal-wrapper .bog-smart-modal-header .bog-smart-modal-header-title {\r\n    font-family: 'BOG Headline', sans-serif;\r\n    font-size: 14px;\r\n    color: rgba(0, 0, 0, 0.9);\r\n}\r\n.bog-smart-modal .bnpl .bog-smart-modal-header .bog-smart-modal-header-title {\r\n    display: none;\r\n}\r\n.bog-smart-modal .bog-smart-modal-wrapper .bog-smart-modal-header .bog-smart-modal-header-close {\r\n    display: flex;\r\n    justify-content: center;\r\n    align-items: center;\r\n    width: 32px;\r\n    height: 32px;\r\n    cursor: pointer;\r\n    border-radius: 50%;\r\n    background-color: transparent;\r\n    transition: background-color 0.2s ease-in-out;\r\n    user-select: none;\r\n}\r\n.bog-smart-modal .bog-smart-modal-wrapper .bog-smart-modal-header .bog-smart-modal-header-close:hover {\r\n    background-color: rgba(0, 0, 0, 0.04);\r\n}\r\n.bog-smart-modal .bog-smart-modal-wrapper .bog-smart-modal-header .bog-smart-modal-header-close > img {\r\n    width: 16px;\r\n    height: 16px;\r\n}\r\n.bog-smart-modal .bog-smart-modal-wrapper .bog-smart-modal-content {\r\n    display: flex;\r\n    flex-direction: column;\r\n    justify-content: flex-start;\r\n    align-items: stretch;\r\n    flex: 1;\r\n    align-items: center;\r\n    box-sizing: border-box !important;\r\n}\r\n.bog-smart-modal .bog-smart-modal-wrapper.bnpl .bog-smart-modal-content {\r\n    display: none;\r\n}\r\n.bog-smart-modal .bog-smart-modal-wrapper .bog-smart-modal-content > * {\r\n    width: 100%;\r\n}\r\n.bog-smart-modal .bog-smart-modal-wrapper .bog-smart-modal-content > *:not(:last-child) {\r\n    margin: 0 0 32px 0;\r\n}\r\n.bog-smart-modal-slider-title,\r\n.bog-smart-modal-bnpl-title,\r\n.bog-smart-modal-bnpl-title-mobile {\r\n    font-family: BOG;\r\n    font-size: 18px;\r\n    font-weight: 700;\r\n    color: rgba(0, 0, 0, 0.9);\r\n    padding-top: 36px;\r\n    text-align: center;\r\n}\r\n.bnpl .bog-smart-modal-slider-title,\r\n.bog-smart-modal-bnpl-title,\r\n.bog-smart-modal-bnpl-title-mobile{\r\n    display: none;\r\n}\r\n.bnpl .bog-smart-modal-bnpl-title {\r\n    display: block;\r\n}\r\n.bog-smart-modal-wrapper-description {\r\n    display: flex;\r\n    flex-direction: column;\r\n}\r\n.bog-smart-modal-description, .bog-smart-modal-description-bnpl{\r\n    display: grid;\r\n    grid-template-columns: repeat(2, max-content);\r\n    grid-gap: 16px 7px;\r\n    align-items: flex-end;\r\n    padding-top: 24px;\r\n    padding-bottom: 32px;\r\n}\r\n.bog-smart-modal-description {\r\n    display: none;\r\n}\r\n.bog-smart-modal-slider-percent-is-standart ~ .bog-smart-modal-wrapper-description .bog-smart-modal-description-bnpl {\r\n    display: none;\r\n}\r\n.bog-smart-modal-slider-percent-is-standart ~ .bog-smart-modal-wrapper-description .bog-smart-modal-description {\r\n    display: grid;\r\n}\r\n.bog-smart-modal-description-icon {\r\n    background-image: url('https://webstatic.bog.ge/icons/bd/check.svg');\r\n    filter: invert(39%) sepia(91%) saturate(826%) hue-rotate(109deg) brightness(97%) contrast(95%);\r\n    width: 14px;\r\n    height: 14px;\r\n    background-repeat: no-repeat;\r\n    background-position: center;\r\n    background-size: cover;\r\n}\r\n.bog-smart-modal-description-text{\r\n    font-size: 12px;\r\n    color: #06A74C;\r\n}\r\n.bog-smart-modal-footer-top {\r\n    display: none;\r\n}\r\n.bnpl .bog-smart-modal-footer-top {\r\n    display: grid;\r\n    grid-gap: 32px;\r\n    padding-bottom: 24px;\r\n}\r\n.bnpl .bog-smart-modal-footer-top .bog-smart-button {\r\n    padding: 19px 32px;\r\n    max-height: 56px;\r\n    height: 56px;\r\n}\r\n.bog-smart-modal-footer-bottom{\r\n    display: flex;\r\n    justify-content: space-between;\r\n    align-items: center;\r\n    padding: 16px 0;\r\n    box-sizing: border-box !important;\r\n    border-top: 1px solid rgba(0, 0, 0, 0.07);\r\n}\r\n.bnpl .bog-smart-modal-footer-bottom{\r\n    display:none;\r\n}\r\n.bog-smart-modal-footer-amount-text {\r\n    font-family: 'BOG';\r\n    font-style: normal;\r\n    font-weight: 400;\r\n    font-size: 14px;\r\n    padding-right: 8px;\r\n}\r\n.bog-smart-modal-footer-amount-value{\r\n    font-family: 'BOG';\r\n    font-style: normal;\r\n    font-weight: 700;\r\n    font-size: 24px;\r\n}\r\n.bog-smart-modal-footer-amount {\r\n    display: flex;\r\n    grid-auto-flow: column;\r\n    align-items: center;\r\n    justify-content: space-between;\r\n}\r\n.bog-smart-modal-more-month-button{\r\n    display: flex;\r\n    align-items: flex-end;\r\n    cursor: pointer;\r\n}\r\n.bog-smart-modal-more-month-button-icon{\r\n    background-image: url('https://webstatic.bog.ge/icons/bd/chevron_right.svg');\r\n    filter: invert(51%) sepia(34%) saturate(4312%) hue-rotate(348deg) brightness(104%) contrast(101%);\r\n    width: 14px;\r\n    height: 14px;\r\n    background-repeat: no-repeat;\r\n    background-position: center;\r\n    background-size: cover;\r\n}\r\n.bog-smart-modal-more-month-button-text {\r\n    padding-left: 12px;\r\n    color: #FF6C1D;\r\n    font-size: 13px;\r\n}\r\n.bog-smart-modal .bog-smart-modal-wrapper .bog-smart-modal-footer {\r\n    display: flex;\r\n    justify-content: space-between;\r\n    box-sizing: border-box !important;\r\n    flex-direction: column;\r\n}\r\n.bog-smart-modal .bnpl .bog-smart-modal-footer {\r\n    padding: 32px 0 0;\r\n    border-top: 1px solid rgba(0, 0, 0, 0.07);\r\n}\r\n.bog-smart-modal .bog-smart-modal-wrapper .bog-smart-modal-footer .bog-smart-modal-footer-logo {\r\n    height: 36px;\r\n    width: auto;\r\n    max-width: 40vw;\r\n}\r\n.bog-smart-modal-footer-top-logo-wrapper {\r\n    display: flex;\r\n    justify-content: space-between;\r\n    align-items: center;\r\n}\r\n.bog-smart-modal-slider-wrapper {\r\n    position: relative;\r\n    display: flex;\r\n    flex-direction: column;\r\n    justify-content: flex-start;\r\n    width: 100%;\r\n    padding-left: 8px;\r\n}\r\n.bog-smart-modal-slider-basket-text-wrapper {\r\n    display: flex;\r\n    justify-content: space-between;\r\n    align-items: flex-start;\r\n    margin-bottom: 10px !important;\r\n    padding: 10px 15px;\r\n}\r\n.bog-smart-modal-slider-basket-text-icon {\r\n    background: rgba(0, 0, 0, 0.3);\r\n    width: 32px;\r\n    height: 32px;\r\n    background-repeat: no-repeat;\r\n    -webkit-mask-image: url(https://webstatic.bog.ge/icons/bd/info.svg);\r\n    mask-image: url(https://webstatic.bog.ge/icons/bd/info.svg);\r\n    -webkit-mask-size: cover;\r\n    mask-size: cover;\r\n    width: 16px;\r\n    height: 16px;\r\n}\r\n.bog-smart-modal-slider-basket-text {\r\n    max-width: 380px;\r\n    font-family: BOG;\r\n    font-size: 10px;\r\n    font-weight: 500;\r\n    font-stretch: normal;\r\n    font-style: normal;\r\n    line-height: 1.6;\r\n    letter-spacing: normal;\r\n    color: rgba(0, 0, 0, 0.3);\r\n}\r\n.bog-smart-modal-slider {\r\n    position: relative;\r\n    display: flex;\r\n    width: 100%;\r\n    height: 18px;\r\n    background: #f0f0f0;\r\n    border-color: #fefefe;\r\n    border-width: 6px 0;\r\n    border-style: solid;\r\n    margin-bottom: 6px;\r\n    margin-bottom: 6px;\r\n    border-radius: 5px;\r\n    cursor: pointer;\r\n}\r\n.bog-smart-modal-slider .bog-smart-modal-slider-handle {\r\n    position: absolute;\r\n    display: flex;\r\n    width: 20px;\r\n    height: 20px;\r\n    background: #7938EA;\r\n    border-radius: 50%;\r\n    transform: translateY(calc(-34%));\r\n    left: -7px;\r\n    cursor: pointer;\r\n    transition: left 100ms linear;\r\n    box-sizing: border-box !important;\r\n}\r\n.bog-smart-modal-slider-steps {\r\n    position: relative;\r\n    display: flex;\r\n    width: 100%;\r\n    height: 16px;\r\n}\r\n\r\n.bog-smart-modal-slider-steps > span {\r\n    position: absolute;\r\n    display: flex;\r\n    align-items: flex-end;\r\n    top: 0;\r\n    padding: 8px;\r\n    margin-top: -8px;\r\n    transform: translateX(-36%);\r\n    font-family: BOG;\r\n    font-size: 10px;\r\n    color: rgba(0, 0, 0, 0.32);\r\n    font-weight: 600;\r\n    transition: color 150ms ease-in-out;\r\n    cursor: pointer;\r\n    user-select: none;\r\n}\r\n.bog-smart-modal-slider-steps > span.active {\r\n    color: #191919;\r\n}\r\n.bog-smart-modal-slider-progress {\r\n    background: #7938EA;\r\n    border-radius: 5px;\r\n    height: 100%;\r\n    width: 0;\r\n    transition: width 100ms linear;\r\n}\r\n.bog-smart-modal-slider-counter-container {\r\n    display: flex;\r\n    flex-direction: row;\r\n    justify-content: space-between;\r\n    align-items: baseline;\r\n    /* display: grid;\r\n    grid-template-columns: 1fr 1fr 1fr;\r\n    grid-gap: 4px; */\r\n}\r\n.bog-smart-modal-slider-counter-container > .bog-smart-modal-slider-counter-list-wrapper:nth-child(1) {\r\n    justify-content: flex-start;\r\n}\r\n.bog-smart-modal-slider-counter-container > .bog-smart-modal-slider-counter-list-wrapper:nth-child(2) {\r\n    justify-content: center;\r\n}\r\n.bog-smart-modal-slider-counter-list-wrapper {\r\n    display: flex;\r\n    overflow: hidden;\r\n    overflow: hidden;\r\n    height: 37px;\r\n    min-width: 30px;\r\n    margin-bottom: -6px;\r\n    margin-right: 4px;\r\n}\r\n.bog-smart-modal-slider-counter-list {\r\n    display: flex;\r\n    flex-direction: column;\r\n    align-items: flex-end;\r\n    min-width: 30px;\r\n    transform: translateY(0);\r\n    transition: transform 100ms ease-in-out;\r\n    height: max-content;\r\n}\r\n.bog-smart-modal-slider-counter-wrapper {\r\n    display: flex;\r\n    flex-direction: row;\r\n    justify-content: flex-start;\r\n    align-items: baseline;\r\n\r\n}\r\n.bog-smart-modal-slider-counter-list > span {\r\n    font-family: BOG;\r\n    font-size: 36px;\r\n    font-weight: 700;\r\n    height: 46px;\r\n    width: max-content;\r\n    color: #000000;\r\n    user-select: none;\r\n}\r\n.bog-smart-modal-slider-counter-label {\r\n    font-family: BOG;\r\n    font-size: 12px;\r\n    color: rgba(0, 0, 0, 0.9);\r\n    height: 36px;\r\n    display: flex;\r\n    flex-direction: column;\r\n    justify-content: flex-end;\r\n    align-items: flex-start;\r\n    margin-left: 9px;\r\n}\r\n.bog-smart-modal-slider-percent-wrapper {\r\n    position: relative;\r\n    display: flex;\r\n    flex-direction: row;\r\n    justify-content: flex-start;\r\n    align-items: flex-end;\r\n    height: 36px;\r\n    min-width: 120px;\r\n    font-family: BOG;\r\n    font-size: 26px;\r\n    font-weight: 600;\r\n    color: rgba(0, 0, 0, 0.9);\r\n}\r\n.bog-smart-modal-slider-percent-wrapper > * {\r\n    position: absolute;\r\n    transition: opacity 450ms ease-in-out, left 450ms ease-in-out;\r\n}\r\n.bog-smart-modal-slider-counter-label-title {\r\n    transition: opacity 450ms ease-in-out;\r\n    color: #ff600a;\r\n    font-family: BOG;\r\n    font-size: 10px;\r\n    font-weight: 600;\r\n}\r\n.bog-smart-modal-slider-bnpl-logo {\r\n    background-image: url(" + p + ");\r\n    width: 114px;\r\n    height: 44px;\r\n    background-repeat: no-repeat;\r\n    background-position: center 3px;\r\n    background-size: cover;\r\n}\r\n.bog-smart-modal-slider-percent-label {\r\n    font-size: 24px;\r\n    font-weight: 600;\r\n    left: 8px;\r\n    bottom: 0;\r\n    color: #FF600A;\r\n    opacity: 0;\r\n}\r\n.bog-smart-modal-bnpl-list-wrapper{\r\n    display: none;\r\n    margin: 36px 0 0;\r\n    padding: 16px 24px;\r\n    border-radius: 8px;\r\n}\r\n.bnpl .bog-smart-modal-bnpl-list-wrapper {\r\n    display: block;\r\n    background-color: #00000012;\r\n}\r\n.bog-smart-modal-bnpl-list {\r\n    display: flex;\r\n    justify-content: space-between;\r\n    border-bottom: 1px solid #00000012;\r\n    padding-bottom: 20px;\r\n}\r\n.bog-smart-modal-bnpl-amount-text {\r\n    font-family: 'BOG';\r\n    font-style: normal;\r\n    font-weight: 600;\r\n    font-size: 11px;\r\n    color: #000000A8;\r\n}\r\n.bog-smart-modal-bnpl-amount {\r\n    position: relative;\r\n    display: grid;\r\n    grid-gap: 4px;\r\n    max-width: fit-content;\r\n}\r\n.bog-smart-modal-bnpl-amount:after {\r\n    content: '';\r\n    width:15px;\r\n    height:15px;\r\n    background-color: #8348EB;\r\n    border-radius: 50%;\r\n    position:absolute;\r\n    top:50px;\r\n    left:0;\r\n    background-image: url(" + b + ");\r\n    background-repeat: no-repeat;\r\n    background-position: center;\r\n}\r\n\r\n.bog-smart-modal-bnpl-amount:last-child:after {\r\n    right:0;\r\n    left:unset;\r\n}\r\n.bog-smart-modal-bnpl-amount-border {\r\n    width: 1px;\r\n    height: 40px;\r\n    background-color:#D4BFF8;\r\n}\r\n.bog-smart-modal-bnpl-amount-value {\r\n    font-weight: 600;\r\n    font-size: 16px;\r\n    font-family: 'BOG';\r\n    font-style: normal;\r\n    color: #000000A8;\r\n}\r\n.bog-smart-modal-slider-percent-is-standart .bog-smart-modal-slider-bnpl-logo {\r\n    opacity: 0;\r\n}\r\n.bog-smart-modal-slider-percent-is-standart .bog-smart-modal-slider-percent-label {\r\n    opacity: 1;\r\n}\r\n.bog-smart-modal-slider-steps .step-bnpl {\r\n    color: #d4bff8;\r\n}\r\n\r\n.bog-smart-modal-slider-steps .step-bnpl.active {\r\n    color: #7938EA;\r\n}\r\n.bog-smart-modal-slider-percent-is-standart .bog-smart-modal-slider-handle,\r\n.bog-smart-modal-slider-percent-is-standart .bog-smart-modal-slider-progress{\r\n    background: #ff5b00;\r\n}\r\n.bog-smart-modal-slider-percent-is-standart ~ .bog-smart-modal-wrapper-description .bog-smart-modal-description-icon {\r\n    background-image: url('https://webstatic.bog.ge/icons/bd/info.svg');\r\n    filter: invert(51%) sepia(34%) saturate(4312%) hue-rotate(348deg) brightness(104%) contrast(101%);\r\n}\r\n.bog-smart-modal-slider-percent-is-standart ~ .bog-smart-modal-wrapper-description .bog-smart-modal-description-text {\r\n    color: #FF6C1D;\r\n}\r\n.bog-smart-modal-installment-window-open .bog-smart-modal-wrapper {\r\n    display: none;\r\n}\r\n.bog-smart-modal-popup-close {\r\n    display: none;\r\n}\r\n.bog-smart-modal-installment-window-open .bog-smart-modal-popup-close {\r\n    display: flex;\r\n    position: fixed;\r\n    top: 16px;\r\n    right: 16px;\r\n    filter: invert(1);\r\n    width: 16px;\r\n    height: 16px;\r\n    cursor: pointer;\r\n}\r\n@media only screen and (max-width: 425px) {\r\n    .bog-smart-modal .bog-smart-modal-wrapper .bog-smart-modal-slider-wrapper {\r\n        box-sizing: border-box;\r\n    }\r\n    .bog-smart-modal .bog-smart-modal-wrapper {\r\n        bottom: 0;\r\n        top: auto;\r\n        border-radius: 20px 20px 0 0;\r\n    }\r\n    .bog-smart-modal:not(.bog-smart-modal-close) .bog-smart-modal-wrapper {\r\n        max-height: 100vh;\r\n        overflow-y: auto;\r\n        animation: modal-container-reveal-responsive 300ms ease-in-out forwards;\r\n    }\r\n    .bog-smart-modal.bog-smart-modal-close .bog-smart-modal-wrapper {\r\n        animation: modal-container-close-responsive 300ms ease-in-out forwards !important;\r\n    }\r\n    .bog-smart-modal-bnpl-amount-text {\r\n        font-size: 10px;\r\n    }\r\n    .bog-smart-modal-bnpl-amount-value {\r\n        font-size: 11px;\r\n    }\r\n\r\n    .bog-smart-modal-footer-top-logo-wrapper .bog-smart-modal-footer-logo {\r\n        margin-top: 36px;\r\n    }\r\n    .bog-smart-modal-footer-top-logo-wrapper {\r\n        flex-direction: column-reverse;\r\n        align-items: start;\r\n    }\r\n    .bog-smart-modal .bnpl .bog-smart-modal-footer {\r\n        padding: 32px 0 0;\r\n    }\r\n    .bog-smart-modal-bnpl-amount:after{\r\n        top: 43px;\r\n    }\r\n    .bog-smart-modal-slider-counter-list > span{\r\n        font-size: 18px;\r\n    }\r\n    .bog-smart-modal-slider-counter-container {\r\n        align-items: flex-end;\r\n    }\r\n    .bog-smart-modal-slider-percent-label {\r\n        font-size: 18px;\r\n        bottom: 8px;\r\n    }\r\n    .bnpl .bog-smart-modal-bnpl-title-mobile {\r\n        display: block;\r\n    }\r\n    .bnpl .bog-smart-modal-bnpl-title {\r\n        display: none;\r\n    }\r\n    .bog-smart-modal-footer-amount-text {\r\n        font-size: 13px;\r\n    }\r\n}\r\n\r\n@media only screen and (max-width: 320px) {\r\n    .bog-smart-modal-bnpl-amount {\r\n        max-width: min-content;\r\n    }\r\n    .bog-smart-modal-bnpl-amount-value {\r\n        font-size: 14px;\r\n        min-width: 50px;\r\n    }\r\n    .bog-smart-modal-footer-amount-text {\r\n        font-size: 12px;\r\n        max-width: 60%;\r\n    }\r\n    .bog-smart-modal-footer-amount-value {\r\n        font-size: 13px;\r\n    }\r\n    .bog-smart-modal-footer-logo {\r\n        height: 24px;\r\n    }\r\n    .bog-smart-button .bog-smart-button-container {\r\n        font-size: 12px;\r\n        padding: 0;\r\n    }\r\n    .bog-smart-modal-slider-percent-wrapper {\r\n        min-width: 60px;\r\n    }\r\n    .bog-smart-modal-slider-bnpl-logo {\r\n        background-position: -2px 10px;\r\n        background-size: 70px;\r\n    }\r\n    .bog-smart-modal-slider-percent-label{\r\n        font-size: 12px;\r\n        left: 0;\r\n    }\r\n    .bog-smart-modal-slider-counter-label {\r\n        margin-left: 3px;\r\n    }\r\n}\r\n", ""]);
                const g = m
            }
            ,
            379: (n, r, t) => {
                var e, o = function() {
                    var n = {};
                    return function(r) {
                        if (void 0 === n[r]) {
                            var t = document.querySelector(r);
                            if (window.HTMLIFrameElement && t instanceof window.HTMLIFrameElement)
                                try {
                                    t = t.contentDocument.head
                                } catch (n) {
                                    t = null
                                }
                            n[r] = t
                        }
                        return n[r]
                    }
                }(), a = [];
                function i(n) {
                    for (var r = -1, t = 0; t < a.length; t++)
                        if (a[t].identifier === n) {
                            r = t;
                            break
                        }
                    return r
                }
                function s(n, r) {
                    for (var t = {}, e = [], o = 0; o < n.length; o++) {
                        var s = n[o]
                            , l = r.base ? s[0] + r.base : s[0]
                            , d = t[l] || 0
                            , m = "".concat(l, " ").concat(d);
                        t[l] = d + 1;
                        var c = i(m)
                            , p = {
                            css: s[1],
                            media: s[2],
                            sourceMap: s[3]
                        };
                        -1 !== c ? (a[c].references++,
                            a[c].updater(p)) : a.push({
                            identifier: m,
                            updater: u(p, r),
                            references: 1
                        }),
                            e.push(m)
                    }
                    return e
                }
                function l(n) {
                    var r = document.createElement("style")
                        , e = n.attributes || {};
                    if (void 0 === e.nonce) {
                        var a = t.nc;
                        a && (e.nonce = a)
                    }
                    if (Object.keys(e).forEach((function(n) {
                            r.setAttribute(n, e[n])
                        }
                    )),
                    "function" == typeof n.insert)
                        n.insert(r);
                    else {
                        var i = o(n.insert || "head");
                        if (!i)
                            throw new Error("Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid.");
                        i.appendChild(r)
                    }
                    return r
                }
                var d, m = (d = [],
                        function(n, r) {
                            return d[n] = r,
                                d.filter(Boolean).join("\n")
                        }
                );
                function c(n, r, t, e) {
                    var o = t ? "" : e.media ? "@media ".concat(e.media, " {").concat(e.css, "}") : e.css;
                    if (n.styleSheet)
                        n.styleSheet.cssText = m(r, o);
                    else {
                        var a = document.createTextNode(o)
                            , i = n.childNodes;
                        i[r] && n.removeChild(i[r]),
                            i.length ? n.insertBefore(a, i[r]) : n.appendChild(a)
                    }
                }
                function p(n, r, t) {
                    var e = t.css
                        , o = t.media
                        , a = t.sourceMap;
                    if (o ? n.setAttribute("media", o) : n.removeAttribute("media"),
                    a && "undefined" != typeof btoa && (e += "\n/*# sourceMappingURL=data:application/json;base64,".concat(btoa(unescape(encodeURIComponent(JSON.stringify(a)))), " */")),
                        n.styleSheet)
                        n.styleSheet.cssText = e;
                    else {
                        for (; n.firstChild; )
                            n.removeChild(n.firstChild);
                        n.appendChild(document.createTextNode(e))
                    }
                }
                var b = null
                    , g = 0;
                function u(n, r) {
                    var t, e, o;
                    if (r.singleton) {
                        var a = g++;
                        t = b || (b = l(r)),
                            e = c.bind(null, t, a, !1),
                            o = c.bind(null, t, a, !0)
                    } else
                        t = l(r),
                            e = p.bind(null, t, r),
                            o = function() {
                                !function(n) {
                                    if (null === n.parentNode)
                                        return !1;
                                    n.parentNode.removeChild(n)
                                }(t)
                            }
                        ;
                    return e(n),
                        function(r) {
                            if (r) {
                                if (r.css === n.css && r.media === n.media && r.sourceMap === n.sourceMap)
                                    return;
                                e(n = r)
                            } else
                                o()
                        }
                }
                n.exports = function(n, r) {
                    (r = r || {}).singleton || "boolean" == typeof r.singleton || (r.singleton = (void 0 === e && (e = Boolean(window && document && document.all && !window.atob)),
                        e));
                    var t = s(n = n || [], r);
                    return function(n) {
                        if (n = n || [],
                        "[object Array]" === Object.prototype.toString.call(n)) {
                            for (var e = 0; e < t.length; e++) {
                                var o = i(t[e]);
                                a[o].references--
                            }
                            for (var l = s(n, r), d = 0; d < t.length; d++) {
                                var m = i(t[d]);
                                0 === a[m].references && (a[m].updater(),
                                    a.splice(m, 1))
                            }
                            t = l
                        }
                    }
                }
            }
        }
            , r = {};
        function t(e) {
            if (r[e])
                return r[e].exports;
            var o = r[e] = {
                id: e,
                exports: {}
            };
            return n[e](o, o.exports, t),
                o.exports
        }
        t.n = n => {
            var r = n && n.__esModule ? () => n.default : () => n;
            return t.d(r, {
                a: r
            }),
                r
        }
            ,
            t.d = (n, r) => {
                for (var e in r)
                    t.o(r, e) && !t.o(n, e) && Object.defineProperty(n, e, {
                        enumerable: !0,
                        get: r[e]
                    })
            }
            ,
            t.g = function() {
                if ("object" == typeof globalThis)
                    return globalThis;
                try {
                    return this || new Function("return this")()
                } catch (n) {
                    if ("object" == typeof window)
                        return window
                }
            }(),
            t.o = (n, r) => Object.prototype.hasOwnProperty.call(n, r),
            ( () => {
                    var n;
                    t.g.importScripts && (n = t.g.location + "");
                    var r = t.g.document;
                    if (!n && r && (r.currentScript && (n = r.currentScript.src),
                        !n)) {
                        var e = r.getElementsByTagName("script");
                        e.length && (n = e[e.length - 1].src)
                    }
                    if (!n)
                        throw new Error("Automatic publicPath is not supported in this browser");
                    n = n.replace(/#.*$/, "").replace(/\?.*$/, "").replace(/\/[^\/]+$/, "/"),
                        t.p = n
                }
            )(),
            ( () => {
                    var n = t(379)
                        , r = t.n(n)
                        , e = t(28);
                    r()(e.Z, {
                        attributes: {
                            id: "bog-sdk-styles"
                        },
                        insert: "head",
                        singleton: !1
                    }),
                        e.Z.locals;
                    var o = function(n) {
                        var r = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : ""
                            , t = !(arguments.length > 2 && void 0 !== arguments[2]) || arguments[2]
                            , e = arguments.length > 3 && void 0 !== arguments[3] && arguments[3]
                            , o = document.createElement("div");
                        o.toggleLoading = function(n) {
                            o.classList.toggle("bog-smart-button-loading", n)
                        }
                            ,
                            o.classList.add("bog-smart-button");
                        var i = document.createElement("div");
                        i.classList.add("bog-smart-button-container");
                        var s = document.createElement("span");
                        return s.innerText = r,
                            i.appendChild(s),
                            o.appendChild(i),
                            a(i),
                        t && (n.innerHTML = ""),
                            e ? (n.innerHTML = "",
                                n.classList.add("bog-smart-button"),
                                n.appendChild(i)) : n.appendChild(o),
                            o
                    }
                        , a = function(n) {
                        var r = document.createElement("div");
                        r.classList.add("bog-smart-button-dots-loader");
                        for (var t = 0; t < 3; t++) {
                            var e = document.createElement("div");
                            e.classList.add("bog-smart-button-dots-loader-dot"),
                                r.appendChild(e)
                        }
                        return n.appendChild(r),
                            r
                    };
                    const i = function(n, r) {
                        var t = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : null
                            , e = arguments.length > 3 && void 0 !== arguments[3] ? arguments[3] : null
                            , o = arguments.length > 4 && void 0 !== arguments[4] && arguments[4]
                            , a = document.createElement(n);
                        return r && a.classList.add(r),
                        t && (a.innerText = t),
                        o && (e.innerHTML = ""),
                        e && e.appendChild(a),
                            a
                    };
                    var s, l, d = {
                        mouseup: null,
                        mousemove: null
                    }, m = 0, c = [], p = [], b = [], g = [], u = function(n, r, t, e) {
                        m = 0,
                            c = [];
                        var o = [];
                        p = [],
                            b = [],
                            g = r;
                        var a = r.length - 1
                            , s = r[0].month
                            , l = r[r.length - 1].month - s + 1
                            , d = 50 / a
                            , u = 50 / l;
                        r.forEach((function(n, r) {
                                c.push(n.month);
                                var t = n.discount_code_view || n.discount_code;
                                p.push("ZERO" === t ? 0 : 1),
                                    b.push(n.amount);
                                var e = r * d + u * (n.month - s);
                                e < 0 && (e = 0),
                                e > 100 && (e = 100),
                                    o.push(e)
                            }
                        )),
                            i("span", "bog-smart-modal-slider-title", e.texts.subtitle, n);
                        var v = i("div", "bog-smart-modal-slider-counter-container", null, n)
                            , w = i("div", "bog-smart-modal-slider-wrapper", null, n)
                            , y = i("div", "bog-smart-modal-slider")
                            , L = i("div", "bog-smart-modal-slider-progress", null, y)
                            , O = i("span", "bog-smart-modal-slider-handle", null, y)
                            , C = i("div", "bog-smart-modal-slider-steps")
                            , k = !1
                            , B = -1
                            , E = [];
                        if (o.forEach((function(n, r) {
                                var t = i("span", null, c[r], C);
                                t.style.left = "".concat(n, "%"),
                                    t.classList.toggle("step-bnpl", 0 === p[r]),
                                    t.addEventListener("click", (function() {
                                            z(r)
                                        }
                                    )),
                                0 === r && t.classList.add("active")
                            }
                        )),
                            t) {
                            w.style.marginBottom = "26px";
                            var G = i("div", "bog-smart-modal-slider-basket-text-wrapper", null, n)
                                , S = document.createElement("img");
                            S.className = "bog-smart-modal-slider-basket-text-icon",
                                G.appendChild(S),
                                i("span", "bog-smart-modal-slider-basket-text", "შერჩეულ პროდუქტ(ებ)ზე სხვადასხვანაირი აქცია ვრცელდება. დაბრუნდით კალათაში, დატოვეთ ერთი აქციის ნივთები და ისარგებლეთ უკეთესი პირობით.", G)
                        }
                        var j = null;
                        O.addEventListener("mousedown", (function(n) {
                                j = y.getBoundingClientRect(),
                                    k = !0
                            }
                        ), !0),
                            O.addEventListener("touchstart", (function(n) {
                                    n.preventDefault(),
                                        j = y.getBoundingClientRect(),
                                        k = !0
                                }
                            ), !0),
                            y.addEventListener("click", (function(n) {
                                    j = y.getBoundingClientRect(),
                                        M(n)
                                }
                            ));
                        var z = function(r) {
                            var t = o[r];
                            if (B !== t) {
                                m = r;
                                var e = o.findIndex((function(n) {
                                        return n === B
                                    }
                                ));
                                B = t,
                                    O.style.left = "calc(".concat(t, "% - 7px)"),
                                    L.style.width = "".concat(t, "%"),
                                    [].slice.call(C.children).forEach((function(n) {
                                            return n.classList.remove("active")
                                        }
                                    )),
                                    C.children[r].classList.add("active"),
                                    E.forEach((function(n) {
                                            n.style.transform = "translateY(".concat(-46 * r, "px)"),
                                                n.style.transition = "transform ".concat(100 * (Math.abs(e - r) + 1), "ms ease-in-out")
                                        }
                                    )),
                                    n.classList.toggle("bog-smart-modal-slider-percent-is-standart", p[r] > 0)
                            }
                        }
                            , M = function(n) {
                            if (n.preventDefault(),
                                j) {
                                var r = n.pageX;
                                "touchmove" === n.type && (r = (n.touches[0] || n.changedTouches[0]).screenX);
                                var t, e = 100 * (r - j.left) / j.width, a = (t = e,
                                    o.reduce((function(n, r) {
                                            return Math.abs(r - t) < Math.abs(n - t) ? r : n
                                        }
                                    )));
                                if (a !== B) {
                                    var i = o.findIndex((function(n) {
                                            return n === a
                                        }
                                    ));
                                    z(i)
                                }
                            }
                        };
                        f((function() {
                                k = !1
                            }
                        ), (function(n) {
                                k && M(n)
                            }
                        )),
                            x(v, e.texts),
                            E.push(h(v, c, e.texts.month)),
                            E.push(h(v, b, e.texts.inMonth, "₾", !0)),
                            w.appendChild(y),
                            w.appendChild(C),
                            z(0)
                    }, f = function(n, r) {
                        d.mouseup && (document.removeEventListener("mouseup", d.mouseup, !0),
                            document.removeEventListener("touchend", d.mouseup, !0)),
                            d.mouseup = n,
                            document.addEventListener("mouseup", d.mouseup, !0),
                            document.addEventListener("touchend", d.mouseup, !0),
                        d.mousemove && (document.removeEventListener("mousemove", d.mousemove, !0),
                            document.removeEventListener("touchmove", d.mousemove, !0)),
                            d.mousemove = r,
                            document.addEventListener("mousemove", d.mousemove, !0),
                            document.addEventListener("touchmove", d.mousemove, !0)
                    }, h = function(n, r) {
                        var t = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : ""
                            , e = arguments.length > 3 && void 0 !== arguments[3] ? arguments[3] : ""
                            , o = arguments.length > 4 && void 0 !== arguments[4] && arguments[4]
                            , a = i("div", "bog-smart-modal-slider-counter-wrapper")
                            , s = i("div", "bog-smart-modal-slider-counter-list-wrapper", null, a)
                            , l = i("div", "bog-smart-modal-slider-counter-list", null, s);
                        r.forEach((function(n) {
                                var r = document.createElement("span");
                                if (o) {
                                    var t = n.toString().split(".")
                                        , a = t[0] || "0"
                                        , s = t[1] || "00"
                                        , d = i("div", "bog-smart-modal-slider-counter-list-number", null, r);
                                    i("span", null, "".concat(a), d),
                                        i("span", null, ".".concat(s).concat(e), d),
                                        r.appendChild(d)
                                } else
                                    r.innerText = "".concat(n).concat(e);
                                l.appendChild(r)
                            }
                        ));
                        var d = i("span", "bog-smart-modal-slider-counter-label", t, a);
                        return o && (d.innerText = "",
                            i("span", "bog-smart-modal-slider-counter-label-subtitle", t, d)),
                            n.appendChild(a),
                            l
                    }, x = function(n, r) {
                        var t = i("div", "bog-smart-modal-slider-percent-wrapper", null, n);
                        return i("div", "bog-smart-modal-slider-bnpl-logo", null, t),
                            i("span", "bog-smart-modal-slider-percent-label", r.installment, t),
                            t
                    }, v = function(n) {
                        try {
                            if (!l) {
                                var r = document.currentScript.src.substring(document.currentScript.src.indexOf("?"));
                                l = new URLSearchParams(r)
                            }
                            return l.get(n)
                        } catch (n) {
                            return null
                        }
                    };
                    const w = function() {
                        var n = BOG.IS_AGGREGATOR || "2" === v("version")
                            , r = y[BOG.TESTMODE ? "test" : "production"][n ? "v2" : "v1"];
                        return {
                            frontURL: r.frontURL,
                            calculatePath: BOG.CALCULATE_PATH || r.calculatePath,
                            apiServer: BOG.API_SERVER || r.apiServer
                        }
                    };
                    var y = {
                        test: {
                            v2: {
                                frontURL: "https://pa-online-installment-web-test.k8s.bog.ge",
                                calculatePath: "/pa-payment-services-public/v1/ecommerce/installment/calculate",
                                apiServer: "https://apim-test.k8s.bog.ge"
                            },
                            v1: {
                                frontURL: "https://installment-test.bog.ge",
                                calculatePath: "/v1/services/installment/calculate",
                                apiServer: "https://installment-test.bog.ge"
                            }
                        },
                        production: {
                            v2: {
                                frontURL: "https://installment-v2.bog.ge",
                                calculatePath: "/payments/v1/ecommerce/installment/calculate",
                                apiServer: "https://api.bog.ge"
                            },
                            v1: {
                                frontURL: "https://installment.bog.ge",
                                calculatePath: "/v1/services/installment/calculate",
                                apiServer: "https://installment.bog.ge"
                            }
                        }
                    };
                    function L(n, r) {
                        var t = Object.keys(n);
                        if (Object.getOwnPropertySymbols) {
                            var e = Object.getOwnPropertySymbols(n);
                            r && (e = e.filter((function(r) {
                                    return Object.getOwnPropertyDescriptor(n, r).enumerable
                                }
                            ))),
                                t.push.apply(t, e)
                        }
                        return t
                    }
                    function O(n, r, t) {
                        return r in n ? Object.defineProperty(n, r, {
                            value: t,
                            enumerable: !0,
                            configurable: !0,
                            writable: !0
                        }) : n[r] = t,
                            n
                    }
                    var C, k, B = {
                        onClose: function() {},
                        onRequest: function() {},
                        onComplete: function() {},
                        texts: {
                            title: "გადახდის დეტალები",
                            subtitle: "აირჩიე სასურველი ვადა",
                            bnplSubtitle: "იყიდე ახლა და გადაიხადე მოგვიანებით",
                            bnplSubtitleMobile: "იყიდე ახლა და გადაიხადე მოგვიანებით",
                            bnpltexts: ["I გადახდა", "II გადახდა", "III გადახდა", "IV გადახდა"],
                            bnplAmount: "ჯამში გადასახდელი თანხა",
                            bnplButton: "გადაინაწილე მეტ თვეზე",
                            month: "თვე",
                            inMonth: "თვეში",
                            button: "გაგრძელება",
                            installment: "განვადება",
                            description: {
                                bnpl: ["მომენტალური შენაძენი", "პირველი გადახდა ერთ თვეში", "არანაირი დამატებითი გადასახადი"],
                                installment: ["განვადება, ეფექტური 26%-დან", "გადაიხადე შენზე მორგებული გრაფიკით", "მარტივი პირობები"]
                            }
                        }
                    }, E = function(n) {
                        if (k && (k.remove(),
                            k = null),
                            n.amount) {
                            if (n) {
                                var r = Object.assign({}, n);
                                r.texts && Object.assign(B.texts, r.texts),
                                    delete r.texts,
                                    Object.assign(B, r)
                            }
                            var t;
                            S(),
                                j(),
                                (t = n,
                                    new Promise((function(n, r) {
                                            var e = new XMLHttpRequest;
                                            e.onreadystatechange = function() {
                                                if (4 == this.readyState) {
                                                    var t = {
                                                        error_code: this.status,
                                                        error_message: "",
                                                        information_link: null,
                                                        details: null
                                                    };
                                                    try {
                                                        t = JSON.parse(e.response)
                                                    } catch (n) {}
                                                    200 == this.status ? n(t) : r(t)
                                                }
                                            }
                                                ,
                                                e.onerror = function(n) {
                                                    r(n)
                                                }
                                            ;
                                            var o = w();
                                            e.open("POST", "".concat(o.apiServer).concat(o.calculatePath), !0),
                                                e.setRequestHeader("Content-Type", "application/json;charset=UTF-8"),
                                                e.send(JSON.stringify(t))
                                        }
                                    ))).then((function(n) {
                                        z(B, n)
                                    }
                                )).catch((function(r) {
                                        M(),
                                        n.onError && n.onError(r)
                                    }
                                ))
                        } else
                            console.warn("amount is missing")
                    };
                    window.addEventListener("beforeunload", (function() {
                            G()
                        }
                    )),
                        window.addEventListener("message", (function(n) {
                                if (n.origin === w().frontURL) {
                                    var r = n.data
                                        , t = !r.closed;
                                    r.closed ? B.onClose(r) : B.onComplete && (t = B.onComplete(r)),
                                        C.close(),
                                        M(),
                                    !1 !== t && (window.location.href = r.redirectUrl)
                                }
                            }
                        ));
                    var G = function() {
                        C && !C.closed && C.close(),
                            C = null
                    }
                        , S = function(n) {
                        k = i("div", "bog-smart-modal"),
                            U(!0),
                            document.body.appendChild(k),
                            k.addEventListener("click", (function() {
                                    C && !C.closed && C.focus()
                                }
                            ))
                    }
                        , j = function() {
                        var n = i("div", "bog-smart-modal-loader", null, k, !0);
                        i("div", "bog-smart-modal-loader-dot", null, n),
                            i("div", "bog-smart-modal-loader-dot", null, n),
                            i("div", "bog-smart-modal-loader-dot", null, n)
                    }
                        , z = function(n, r) {
                        "bnpl"in n && "boolean" == typeof n.bnpl && (r.bnpl = !!n.bnpl,
                            !1 === n.bnpl ? r.discounts = r.discounts.filter((function(n) {
                                    return "ZERO" !== n.discount_code
                                }
                            )) : !0 === n.bnpl && (r.discounts = r.discounts.filter((function(n) {
                                    return "ZERO" === n.discount_code
                                }
                            ))));
                        var t = i("div", "bog-smart-modal-wrapper", null, k, !0);
                        t.id = "BogModalWrapper";
                        var e = i("div", "bog-smart-modal-popup-close", null, k)
                            , o = document.createElement("img");
                        o.src = "https://webstatic.bog.ge/icons/bd/close.svg",
                            o.alt = "close",
                            e.appendChild(o),
                            e.addEventListener("click", G),
                            P(t, n),
                            i("span", "bog-smart-modal-bnpl-title", n.texts.bnplSubtitle, t),
                            i("span", "bog-smart-modal-bnpl-title-mobile", n.texts.bnplSubtitleMobile, t),
                            T(t, r.discounts, r.show_discount_warning || r.showDiscountWarning, n);
                        var a = i("div", "bog-smart-modal-wrapper-description", null, t);
                        R(a, n, r),
                            A(a, n.texts),
                            I(t, n, r),
                            t.classList.toggle("bnpl", !!r.bnpl)
                    }
                        , M = function() {
                        try {
                            U(!1),
                                B.onClose(),
                            s && document.removeEventListener("mousemove", s, !0),
                                s = null,
                            k && k.classList.add("bog-smart-modal-close"),
                                setTimeout((function() {
                                        k && k.remove()
                                    }
                                ), 300)
                        } catch (n) {}
                    }
                        , T = function(n, r, t, e) {
                        var o = i("div", "bog-smart-modal-content", null, n);
                        u(o, r, t, e)
                    }
                        , R = function(n, r, t) {
                        for (var e = i("div", "bog-smart-modal-bnpl-list-wrapper", null, n), o = i("div", "bog-smart-modal-bnpl-list", null, e), a = t.bnplValue ? t.bnplValue : (Number(r.amount) / t.discounts[0].month).toFixed(2), s = 0; s < t.discounts[0].month; s++) {
                            var l = i("div", "bog-smart-modal-bnpl-amount", null, o);
                            i("span", "bog-smart-modal-bnpl-amount-text", r.texts.bnpltexts[s], l),
                                i("span", "bog-smart-modal-bnpl-amount-value", "".concat(a, " ₾"), l)
                        }
                    }
                        , A = function(n, r) {
                        var t = i("div", "bog-smart-modal-description", null, n)
                            , e = i("div", "bog-smart-modal-description-bnpl", null, n);
                        r.description.installment.map((function(n) {
                                i("div", "bog-smart-modal-description-icon", null, t),
                                    i("span", "bog-smart-modal-description-text", n, t)
                            }
                        )),
                            r.description.bnpl.map((function(n) {
                                    i("div", "bog-smart-modal-description-icon", null, e),
                                        i("span", "bog-smart-modal-description-text", n, e)
                                }
                            ))
                    }
                        , P = function(n, r) {
                        var t = i("div", "bog-smart-modal-header", null, n);
                        i("span", "bog-smart-modal-header-title", r.texts.title, t),
                            H(t)
                    }
                        , H = function(n) {
                        var r = i("div", "bog-smart-modal-header-close", null, n)
                            , t = document.createElement("img");
                        t.src = "https://webstatic.bog.ge/icons/bd/close.svg",
                            t.alt = "close",
                            r.appendChild(t),
                            r.addEventListener("click", (function() {
                                    M()
                                }
                            ))
                    }
                        , I = function(n, r, t) {
                        var e = i("div", "bog-smart-modal-footer", null, n)
                            , a = i("div", "bog-smart-modal-footer-top", null, e)
                            , s = i("div", "bog-smart-modal-footer-bottom", null, e)
                            , l = i("div", "bog-smart-modal-footer-amount", null, a)
                            , d = (i("span", "bog-smart-modal-footer-amount-text", r.texts.bnplAmount, l),
                            t.amount ? t.amount.toFixed(2) : Number(r.amount).toFixed(2))
                            , m = (i("span", "bog-smart-modal-footer-amount-value", "".concat(d, " ₾"), l),
                            document.createElement("img"));
                        m.src = "https://webstatic.bog.ge/logo/logo.svg",
                            m.classList.add("bog-smart-modal-footer-logo"),
                            s.appendChild(m);
                        var c = o(a, r.texts.button, !1)
                            , p = o(s, r.texts.button, !1);
                        c.addEventListener("click", (function() {
                                return _(c)
                            }
                        )),
                            p.addEventListener("click", (function() {
                                    return _(p)
                                }
                            ));
                        var b = i("div", "bog-smart-modal-footer-top-logo-wrapper", null, a);
                        if (b.appendChild(m.cloneNode()),
                        t.discounts.length > 1) {
                            var g = i("div", "bog-smart-modal-more-month-button", null, b);
                            i("div", "bog-smart-modal-more-month-button-icon", null, g),
                                i("span", "bog-smart-modal-more-month-button-text", r.texts.bnplButton, g),
                                g.addEventListener("click", (function() {
                                        document.querySelector("#BogModalWrapper").classList.remove("bnpl")
                                    }
                                ))
                        }
                    }
                        , _ = function(n) {
                        !C || C.closed ? (n.toggleLoading(!0),
                        !1 !== B.onRequest(function(n) {
                            for (var r = 1; r < arguments.length; r++) {
                                var t = null != arguments[r] ? arguments[r] : {};
                                r % 2 ? L(Object(t), !0).forEach((function(r) {
                                        O(n, r, t[r])
                                    }
                                )) : Object.getOwnPropertyDescriptors ? Object.defineProperties(n, Object.getOwnPropertyDescriptors(t)) : L(Object(t)).forEach((function(r) {
                                        Object.defineProperty(n, r, Object.getOwnPropertyDescriptor(t, r))
                                    }
                                ))
                            }
                            return n
                        }({}, g[m]), (function(r) {
                                n.toggleLoading(!1);
                                var t = "".concat(w().frontURL, "/?order_id=").concat(r, "&locale=ka&window_frame=1");
                                C ? C.location.href = t : window.location.href = t
                            }
                        ), (function() {
                                G()
                            }
                        )) && F()) : C.focus()
                    }
                        , F = function() {
                        var n = window.screen.width < 768 ? window.screen.width : 768
                            , r = window.screen.height < 800 ? window.screen.height - 100 : 800
                            , t = void 0 !== window.screenLeft ? window.screenLeft : window.screenX
                            , e = void 0 !== window.screenTop ? window.screenTop : window.screenY
                            , o = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width
                            , a = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height
                            , i = o / window.screen.availWidth
                            , s = (o - n) / 2 / i + t
                            , l = (a - r) / 2 / i + e;
                        if (C = window.open("", "installmentwindow", "\n        menutbar=1,\n        resizable=0, \n        location=0,\n        menubar=0,\n        status=0,\n        width=".concat(n / i, ", \n        height=").concat(r / i, ", \n        top=").concat(l, ", \n        left=").concat(s, "\n    "))) {
                            C.document.body.innerHTML = '<!DOCTYPE html> <html lang="en"> <head> <meta charset="UTF-8"> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <meta name="viewport" content="width=device-width,initial-scale=1"> <style>body,html{padding:0;margin:0;overflow:hidden}body{display:flex;justify-content:center;align-items:center;width:100vw;height:100vh}.loader{border-radius:50%;border:6px solid #f9ede6;width:100px;height:100px;position:relative;display:flex;justify-content:center;align-items:center}.loader:after{content:"";position:absolute;top:-6px;right:-6px;bottom:-6px;left:-6px;border-radius:50%;border:6px solid transparent;border-top-color:#ff600a;-webkit-animation:spin 1s linear infinite;animation:spin 1s linear infinite}@keyframes spin{0%{-webkit-transform:rotate(0);tranform:rotate(0)}100%{-webkit-transform:rotate(360deg);tranform:rotate(360deg)}}.loader>svg{max-width:48px;max-height:48px;color:#ff600a}</style> </head> <body> <div class="loader"> <svg style="pointer-events:none;display:block;width:100%;height:100%" width="48px" height="48px" viewBox="0 0 48 48" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"> <g id="icons-48-loan-express-" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <rect id="shape" x="0" y="0" width="48" height="48"></rect> <path d="M35.1428572,3.30612241 C36.0220043,3.30612241 36.7346939,4.01881199 36.7346939,4.89795915 L36.7346939,4.89795915 L36.7346939,6.48979588 L41.5102041,6.48979588 C44.1476456,6.48979588 46.2857143,8.62786463 46.2857143,11.2653061 L46.2857143,11.2653061 L46.2857143,39.9183674 C46.2857143,42.5558088 44.1476456,44.6938776 41.5102041,44.6938776 L41.5102041,44.6938776 L11.2653061,44.6938776 C8.62786463,44.6938776 6.48979588,42.5558088 6.48979588,39.9183674 L6.48979588,39.9183674 L6.48979588,35.9387755 C6.48979588,35.0596284 7.20248547,34.3469388 8.08163262,34.3469388 C8.96077978,34.3469388 9.67346936,35.0596284 9.67346936,35.9387755 L9.67346936,35.9387755 L9.67346936,39.9183674 C9.67346936,40.7975145 10.3861589,41.5102041 11.2653061,41.5102041 L11.2653061,41.5102041 L41.5102041,41.5102041 C42.3893513,41.5102041 43.1020409,40.7975145 43.1020409,39.9183674 L43.1020409,39.9183674 L43.1020409,11.2653061 C43.1020409,10.3861589 42.3893513,9.67346936 41.5102041,9.67346936 L41.5102041,9.67346936 L36.7346939,9.67346936 L36.7346939,10.4693877 C36.7346939,11.3485349 36.0220043,12.0612245 35.1428572,12.0612245 C34.26371,12.0612245 33.5510204,11.3485349 33.5510204,10.4693877 L33.5510204,10.4693877 L33.5510204,9.67346936 L19.2244898,9.67346936 L19.2244898,10.4693877 C19.2244898,11.3485349 18.5118002,12.0612245 17.632653,12.0612245 C16.7535059,12.0612245 16.0408163,11.3485349 16.0408163,10.4693877 L16.0408163,10.4693877 L16.0408163,9.67346936 L11.2653061,9.67346936 C10.3861589,9.67346936 9.67346936,10.3861589 9.67346936,11.2653061 L9.67346936,11.2653061 L9.67346936,14.4489796 C9.67346936,15.3281267 8.96077978,16.0408163 8.08163262,16.0408163 C7.20248547,16.0408163 6.48979588,15.3281267 6.48979588,14.4489796 L6.48979588,14.4489796 L6.48979588,11.2653061 C6.48979588,8.62786463 8.62786463,6.48979588 11.2653061,6.48979588 L11.2653061,6.48979588 L16.0408163,6.48979588 L16.0408163,4.89795915 C16.0408163,4.01881199 16.7535059,3.30612241 17.632653,3.30612241 C18.5118002,3.30612241 19.2244898,4.01881199 19.2244898,4.89795915 L19.2244898,4.89795915 L19.2244898,6.48979588 L33.5510204,6.48979588 L33.5510204,4.89795915 C33.5510204,4.01881199 34.26371,3.30612241 35.1428572,3.30612241 Z M32.8983674,17.9589796 C33.5299449,17.4181104 34.4714112,17.4544751 35.0593864,18.0424504 C35.6473616,18.6304256 35.6837264,19.5718918 35.1428572,20.2034694 L35.1428572,20.2034694 L19.8214286,35.5328572 C19.4262317,35.9674406 18.8238211,36.1490658 18.2542691,36.0053515 C17.684717,35.8616373 17.2405972,35.4159425 17.0988999,34.8458853 C16.9572026,34.2758281 17.1409591,33.6740642 17.5769388,33.2804082 L17.5769388,33.2804082 L32.9063265,17.9589796 Z M32.7551021,29.5714286 C34.5133964,29.5714286 35.9387755,30.9968077 35.9387755,32.7551021 C35.9387755,34.5133964 34.5133964,35.9387755 32.7551021,35.9387755 C30.9968077,35.9387755 29.5714286,34.5133964 29.5714286,32.7551021 C29.5714286,30.9968077 30.9968077,29.5714286 32.7551021,29.5714286 Z M10.4693877,26.3877551 C11.3485349,26.3877551 12.0612245,27.1004447 12.0612245,27.9795918 C12.0612245,28.858739 11.3485349,29.5714286 10.4693877,29.5714286 L10.4693877,29.5714286 L3.30612241,29.5714286 C2.42697525,29.5714286 1.71428567,28.858739 1.71428567,27.9795918 C1.71428567,27.1004447 2.42697525,26.3877551 3.30612241,26.3877551 L3.30612241,26.3877551 Z M20.0204082,17.632653 C21.7787025,17.632653 23.2040816,19.0580322 23.2040816,20.8163265 C23.2040816,22.5746208 21.7787025,24 20.0204082,24 C18.2621138,24 16.8367347,22.5746208 16.8367347,20.8163265 C16.8367347,19.0580322 18.2621138,17.632653 20.0204082,17.632653 Z M10.4693877,20.8163265 C11.3485349,20.8163265 12.0612245,21.5290161 12.0612245,22.4081633 C12.0612245,23.2873104 11.3485349,24 10.4693877,24 L10.4693877,24 L6.48979588,24 C5.61064873,24 4.89795915,23.2873104 4.89795915,22.4081633 C4.89795915,21.5290161 5.61064873,20.8163265 6.48979588,20.8163265 L6.48979588,20.8163265 Z" id="Combined-Shape" fill="currentColor" fill-rule="nonzero"></path> </g> </svg> </div> </body> </html>',
                                k.classList.add("bog-smart-modal-installment-window-open");
                            var d = setInterval((function() {
                                    C && !C.closed || (clearInterval(d),
                                        M())
                                }
                            ), 1e3)
                        }
                    }
                        , U = function(n) {
                        n ? (document.body.style.position = "relative",
                            document.body.style.overflow = "hidden",
                            document.body.style.width = "calc(100% - ".concat(function() {
                                if (!(document.body.scrollHeight > document.body.clientHeight))
                                    return 0;
                                var n = document.createElement("p");
                                n.style.width = "100%",
                                    n.style.height = "200px";
                                var r = document.createElement("div");
                                r.style.position = "absolute",
                                    r.style.top = "0px",
                                    r.style.left = "0px",
                                    r.style.visibility = "hidden",
                                    r.style.width = "200px",
                                    r.style.height = "150px",
                                    r.style.overflow = "hidden",
                                    r.appendChild(n),
                                    document.body.appendChild(r);
                                var t = n.offsetWidth;
                                r.style.overflow = "scroll";
                                var e = n.offsetWidth;
                                return t == e && (e = r.clientWidth),
                                    document.body.removeChild(r),
                                t - e
                            }(), "px)"),
                            document.body.style.touchAction = "none") : (document.body.style.removeProperty("position"),
                            document.body.style.removeProperty("overflow"),
                            document.body.style.removeProperty("width"),
                            document.body.style.removeProperty("touch-action"))
                    }
                        , D = {};
                    function N() {
                        if (!D.clientId)
                            throw new Error("BOG client id is not defined")
                    }
                    D.TESTMODE = !1,
                        D.init = function(n) {
                            var r = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {}
                                , t = r.testMode
                                , e = r.version;
                            D.clientId = n,
                            "boolean" == typeof t && (D.TESTMODE = t),
                            2 === Number(e) && (D.IS_AGGREGATOR = !0)
                        }
                        ,
                        D.SmartButton = {},
                        D.SmartButton.render = function(n) {
                            var r = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {}
                                , t = r.onClick
                                , e = r.text
                                , a = void 0 === e ? "მოითხოვე სესხი" : e;
                            N();
                            var i = o(n, a, !0);
                            return t && i.addEventListener("click", t),
                                i
                        }
                        ,
                        D.Calculator = {},
                        D.Calculator.open = function() {
                            var n = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {};
                            return N(),
                                n.client_id = D.clientId,
                                E(n)
                        }
                        ,
                        D.Calculator.close = M;
                    const Z = D;
                    !function(n) {
                        var r = v("client_id");
                        r && (Z.clientId = r),
                            n.BOG = Z,
                            document.currentScript.addEventListener("load", (function() {
                                    n.bogAsyncInit && n.bogAsyncInit()
                                }
                            ))
                    }(window)
                }
            )()
    }
)();
