(window.__LOADABLE_LOADED_CHUNKS__=window.__LOADABLE_LOADED_CHUNKS__||[]).push([[11],{"9pre":function(e,t,a){a.d(t,"a",(function(){return i})),a.d(t,"b",(function(){return s})),a.d(t,"c",(function(){return n}));const i=5,s="V_HLSV3_MOBILE",n=[0,.01,.02,.03,.04,.05,.06,.07,.08,.09,.1,.11,.12,.13,.14,.15,.16,.17,.18,.19,.2,.21,.22,.23,.24,.25,.26,.27,.28,.29,.3,.31,.32,.33,.34,.35,.36,.37,.38,.39,.4,.41,.42,.43,.44,.45,.46,.47,.48,.49,.5,.51,.52,.53,.54,.55,.56,.57,.58,.59,.6,.61,.62,.63,.64,.65,.66,.67,.68,.69,.7,.71,.72,.73,.74,.75,.76,.77,.78,.79,.8,.81,.82,.83,.84,.85,.86,.87,.88,.89,.9,.91,.92,.93,.94,.95,.96,.97,.98,.99,1]},Lic6:function(e,t,a){a.d(t,"b",(function(){return h})),a.d(t,"c",(function(){return d})),a.d(t,"a",(function(){return c}));var i=a("7w6Q"),s=a("Xy1J");const n=["isCellular","videoUrl","sessionMark"],r=["fatalError"];let l={},o="";const h=e=>{const{browserName:t,browserVersion:a,country:i,isAuthenticated:s,isBot:n,isSocialBot:r,view:h="unknown",viewParameter:d="unknown"}=e;o=(r?"socialBot":n&&"bot")||"nonbot";const c=(e=>{switch(e){case"BR":case"MX":case"AR":case"CL":case"CO":return"LatAm";case"US":return"US";default:return"OTHER"}})(i);l={browserName:t,browserVersion:(null==a?void 0:a.split(".")[0])||"0",isAuthenticated:s,region:c,view:h,viewParameter:d}};function d(e,t,a={}){const s=t?"hls":"nonHls",n={...a,...l},r=`web.video.${s}.${o}.${e}`;i.a.increment(r,1,n)}function c(e,t,a={}){const h=t?"hls":"nonHls",d=e.sessionMark===s.e?"sessionStart":"sessionEnd",c={...a,...l};Object.entries(e).forEach(([e,t])=>{const a=`web.video.${h}.${o}.${d}.${e}`,s=parseInt(t,10),l="number"==typeof s?s:-1;var u;if(!n.includes(e))if(r.includes(e)&&t)i.a.increment(a,1,c);else if(e.includes("Width")||e.includes("Height")){const e=(u=l)<0?"negative":0===u?"zero":u<200?"xs":u<400?"s":u<600?"m":u<800?"l":u<1e3?"xl":u<1200?"xxl":"over1200";i.a.increment(a,1,{dimensionBucket:e,...c})}else if("numberOfStalls"===e){let e=t;l>1e3?e="over1000":l>10?e="over10":l<0&&(e="negative"),i.a.increment(a,1,{numberOfStalls:e,...c})}else"screenPixelRatio"===e?i.a.increment(a,1,{screenPixelRatio:t||-1,...c}):l>=0?(0===l&&i.a.increment(a+".zero",1,c),i.a.timing(a,l,1),i.a.timing(a+"_with_tags",l,1,c)):l<0&&i.a.increment(a+".negative",1,c)})}},Xy1J:function(e,t,a){a.d(t,"e",(function(){return s})),a.d(t,"d",(function(){return n})),a.d(t,"c",(function(){return r})),a.d(t,"a",(function(){return l})),a.d(t,"b",(function(){return o})),a.d(t,"f",(function(){return h})),a.d(t,"g",(function(){return d}));var i=a("7Cbv");const s=1,n=2,r=1e3,l=1e3,o=1e3,h=Object.freeze({LOADING:0,PLAYING:1,PAUSED:2,SEEKING:3,STALLING:4,FAILED:5,ENDED:6});function d(e){return e+"-"+Object(i.a)()}},aFfM:function(e,t,a){var i=a("q1tI"),s=a("ulZh"),n=a.n(s),r=a("v/Q4"),l=a("U4JR"),o=a("pLLR"),h=a("n6mq"),d=a("Xy1J"),c=a("Lic6"),u=a("nKUr");function m(e,t,a){return t in e?Object.defineProperty(e,t,{value:a,enumerable:!0,configurable:!0,writable:!0}):e[t]=a,e}class p extends i.PureComponent{constructor(...e){super(...e),m(this,"state",{canPlayVideo:!1,isManifestParsed:!1,playbackState:d.f.LOADING}),m(this,"firstFragBuffered",!1),m(this,"hasPlaybackStarted",!1),m(this,"hasVideoSessionStarted",!1),m(this,"hasVideoSessionEnded",!1),m(this,"hls",null),m(this,"fragStartupTime",{}),m(this,"lastLevelSwitchKbps",null),m(this,"lastStallTime",null),m(this,"videoSessionId",""),m(this,"videoVisibleTime",null),m(this,"playbackPerformance",{canPlayTime:null,downloadedKiloBytes:0,fatalErrorMsg:"",hasFatalError:!1,loadStartTime:null,numStalls:0,playbackStartTimestamp:null,segments:[],srcString:"string"==typeof this.props.src?this.props.src:this.props.src[0].src,totalStallDurationMs:0,videoCreatedTime:null}),m(this,"initializeHls",()=>{this.destroyHls();const{src:e,hlsConfig:t}=this.props,a=new n.a(t);a.loadSource(e),this.videoPlayerRef&&a.attachMedia(this.videoPlayerRef.video),a.on(n.a.Events.FRAG_BUFFERED,this.handleHlsFragBuffered),a.on(n.a.Events.FRAG_CHANGED,this.handleHlsFragChanged),a.on(n.a.Events.FRAG_LOADING,this.handleHlsFragLoading),a.on(n.a.Events.FRAG_LOADED,this.handleHlsFragLoaded),a.on(n.a.Events.MANIFEST_PARSED,()=>{this.setState({isManifestParsed:!0})}),a.on(n.a.Events.LEVEL_SWITCHED,this.handleHlsLevelSwitched),a.on(n.a.Events.ERROR,this.handleHlsError),this.hls=a}),m(this,"destroyHls",()=>{const{hls:e}=this;e&&e.destroy()}),m(this,"addSegment",e=>{const{segments:t}=this.playbackPerformance,a=t&&t[t.length-1];if(this.hls&&t.length&&a&&a.uri!==e.url){this.updateWatchDurationForCurrentSegment();const a=this.videoPlayerRef&&this.videoPlayerRef.video,i=this.hls&&this.hls.levels||{},s=this.hls&&"number"==typeof this.hls.currentLevel?i[this.hls.currentLevel]:{},n=this.fragStartupTime[e.url];let r=-1;n&&n.startLoadTime&&n.endLoadTime&&(r=n.endLoadTime-n.startLoadTime);const l={indicatedKbps:s.bitrate/d.a,duration:e.duration,level:e.level,lastStartPlayTime:this.getCurrentVideoTime(),numServerAddressChange:-1,observedKbps:this.hls&&this.hls.bandwidthEstimate/d.a||-1,playbackStartDate:Date.now(),serverAddress:"",sn:e.sn,sourceWidth:s.width,sourceHeight:s.height,startupTimeMs:r,switchBitrateKbps:this.lastLevelSwitchKbps||-1,uri:e.url,viewportWidth:a&&a.clientWidth||-1,viewportHeight:a&&a.clientHeight||-1,watchedDurationMs:0};t.push(l)}}),m(this,"initializeSegments",e=>{const{segments:t}=this.playbackPerformance;if(!t.length)if(this.hls&&"number"==typeof this.hls.currentLevel&&this.videoPlayerRef&&this.videoPlayerRef.video){if(!t.length){const a=this.videoPlayerRef&&this.videoPlayerRef.video,i=this.hls.levels[this.hls.currentLevel]||{},s=this.fragStartupTime[e.url];let n=-1;s&&s.startLoadTime&&s.endLoadTime&&(n=s.endLoadTime-s.startLoadTime),this.lastLevelSwitchKbps=this.hls.bandwidthEstimate/d.a;const r={indicatedKbps:i.bitrate/d.a,duration:e.duration,level:e.level,lastStartPlayTime:null,numServerAddressChange:-1,observedKbps:this.hls.bandwidthEstimate/d.a||-1,playbackStartDate:null,serverAddress:"",sn:e.sn,sourceWidth:i.width,sourceHeight:i.height,startupTimeMs:n,switchBitrateKbps:this.lastLevelSwitchKbps||-1,uri:e.url,viewportWidth:a.clientWidth,viewportHeight:a.clientHeight,watchedDurationMs:0};t.push(r)}}else Object(c.c)("initializeSegmentsFailed",!0)}),m(this,"getCurrentVideoTime",()=>this.videoPlayerRef&&this.videoPlayerRef.video?this.videoPlayerRef.video.currentTime*d.c:null),m(this,"handleCanPlayVideo",e=>{const{onReady:t,playing:a}=this.props,{canPlayVideo:i}=this.state;Object(c.c)("handleCanPlayVideo",!0,{firstCanPlayEvent:!i,playing:a}),i||(this.playbackPerformance.canPlayTime=new Date),this.setState({canPlayVideo:!0}),t&&t(e)}),m(this,"handleEnded",e=>{const{loop:t,onEnded:a}=this.props,{segments:i}=this.playbackPerformance,s=i&&i[i.length-1];t&&this.videoPlayerRef&&this.videoPlayerRef.video?(this.updateWatchDurationForCurrentSegment(),s&&(s.lastStartPlayTime=0),this.fragStartupTime={}):t||this.logPlaybackPerformance(d.d,{initiator:"videoEnded",loop:t}),this.setState({playbackState:d.f.ENDED}),a&&a(e)}),m(this,"handleHlsError",(e,t)=>{t.fatal&&(this.playbackPerformance.hasFatalError=!0,this.playbackPerformance.fatalErrorMsg=t.details),this.updateWatchDurationForCurrentSegment(),this.setState({playbackState:d.f.FAILED})}),m(this,"handleHlsFragBuffered",(e,t)=>{this.firstFragBuffered||(this.initializeSegments(t.frag),this.firstFragBuffered=!0)}),m(this,"handleHlsFragChanged",(e,t)=>{this.addSegment(t.frag)}),m(this,"handleHlsFragLoading",(e,t)=>{var a;const i=null===(a=t.frag)||void 0===a?void 0:a.url;i&&!this.fragStartupTime[i]&&(this.fragStartupTime[i]={startLoadTime:new Date})}),m(this,"handleHlsFragLoaded",(e,t)=>{var a;t.frag&&t.frag.loaded&&(this.playbackPerformance.downloadedKiloBytes+=t.frag.loaded/d.b);const i=null===(a=t.frag)||void 0===a?void 0:a.url;i&&this.fragStartupTime[i]&&this.fragStartupTime[i].startLoadTime&&(this.fragStartupTime[i].endLoadTime=new Date)}),m(this,"handleHlsLevelSwitched",()=>{this.hls&&this.hls.bandwidthEstimate&&(this.lastLevelSwitchKbps=this.hls.bandwidthEstimate/d.a)}),m(this,"handleLoadStart",()=>{this.playbackPerformance.loadStartTime=new Date}),m(this,"handlePlaying",()=>{const{segments:e}=this.playbackPerformance,t=e&&e[e.length-1];this.hasPlaybackStarted||(this.playbackPerformance.playbackStartTimestamp=Date.now(),this.hasPlaybackStarted=!0),this.initializeSegments(),t&&null===t.lastStartPlayTime&&(t.lastStartPlayTime=this.getCurrentVideoTime()),t&&null===t.playbackStartDate&&(t.playbackStartDate=Date.now()),this.updateStallDuration(),this.setState({playbackState:d.f.PLAYING})}),m(this,"handlePause",()=>{this.state.playbackState!==d.f.STALLING&&this.state.playbackState!==d.f.SEEKING&&(this.updateWatchDurationForCurrentSegment(),this.updateStallDuration()),this.setState({playbackState:d.f.PAUSED})}),m(this,"handleSeeking",()=>{const{segments:e}=this.playbackPerformance,t=e&&e[e.length-1];t&&(t.lastStartPlayTime=null),this.state.playbackState!==d.f.ENDED&&this.setState({playbackState:d.f.SEEKING})}),m(this,"handleStalled",()=>{null===this.lastStallTime&&this.state.playbackState!==d.f.ENDED&&(this.lastStallTime=new Date,this.playbackPerformance.numStalls+=1),this.setState({playbackState:d.f.STALLING})}),m(this,"handleTimeUpdate",()=>{const{segments:e}=this.playbackPerformance,t=e&&e[e.length-1];this.state.playbackState===d.f.PLAYING&&(this.updateWatchDurationForCurrentSegment(),t&&null===t.lastStartPlayTime&&(t.lastStartPlayTime=this.getCurrentVideoTime()))}),m(this,"setVideoPlayerRef",e=>{const{setVideoRef:t}=this.props;if(e&&(t&&t(e),this.videoPlayerRef=e,this.videoPlayerRef.video)){const e=this.videoPlayerRef.video;e.addEventListener("loadstart",this.handleLoadStart),e.addEventListener("playing",this.handlePlaying),e.addEventListener("pause",this.handlePause),e.addEventListener("seeking",this.handleSeeking),e.addEventListener("stalled",this.handleStalled),e.addEventListener("timeupdate",this.handleTimeUpdate),e.addEventListener("waiting",this.handleStalled),e.readyState>=3&&(this.setState({canPlayVideo:!0}),this.playbackPerformance.canPlayTime=new Date)}}),m(this,"updateStallDuration",()=>{null!==this.lastStallTime&&(this.playbackPerformance.totalStallDurationMs+=new Date-this.lastStallTime,this.lastStallTime=null)}),m(this,"updateWatchDurationForCurrentSegment",()=>{const{segments:e}=this.playbackPerformance,t=e&&e[e.length-1],a=t?t.lastStartPlayTime:null,i=this.getCurrentVideoTime();if(t&&null!==a&&"number"==typeof i&&"number"==typeof a){const e=i-a;e>0&&(t.watchedDurationMs+=e,t.lastStartPlayTime=null)}}),m(this,"logPlaybackPerformance",(e,t)=>{const{contextLogData:a,userId:i}=this.props,{canPlayTime:s,downloadedKiloBytes:n,hasFatalError:r,playbackStartTimestamp:o,segments:h,srcString:u,loadStartTime:m,numStalls:p}=this.playbackPerformance,y=this.videoPlayerRef&&this.videoPlayerRef.video,b=e===d.e,f=b&&!this.hasVideoSessionStarted,S=!b&&!this.hasVideoSessionEnded&&this.hasVideoSessionStarted;if(this.hls&&y&&(f||S)){var g;let f=-1;s&&m&&(f=s>m?s-m:0);let S=-1;s&&this.videoVisibleTime&&(S=s>this.videoVisibleTime?s-this.videoVisibleTime:0);const v={averageVideoKbps:-1,downloadedKiloBytes:n,isCellular:!1,fatalError:r,nativeVideoDurationMs:y.duration*d.c||-1,numberOfStalls:p,overallWatchedDurationMs:-1,rebufferRate:-1,playbackStartTimestamp:o||-1,segments:[],sessionMark:e,screenPixelRatio:null!==(g=window)&&void 0!==g&&g.devicePixelRatio?window.devicePixelRatio:-1,startupPlayerWidth:y.clientWidth,startupPlayerHeight:y.clientHeight,startupTimeMs:f,startupLatencyMs:S,startupVariantKbps:-1,startupVariantWatchedDurationMs:-1,startupVariantWidth:-1,startupVariantHeight:-1,videoUrl:u};if(b)this.videoSessionId=Object(d.g)(i);else if(h.length>0){const e=this.hls.levels,t=h[0];this.updateWatchDurationForCurrentSegment(),this.updateStallDuration();const a=h.reduce((t,a)=>t+(e[a.level]||{}).bitrate*(a.watchedDurationMs||0)/d.c,0),i=h.reduce((e,t)=>e+(t.watchedDurationMs||0),0);let s=null,n=0,r=0;do{n+=h[r].watchedDurationMs,s=s||h[r].level,r+=1}while(r<h.length&&h[r].level===s);v.startupVariantKbps=t.indicatedKbps,v.startupVariantWatchedDurationMs=n,v.startupVariantWidth=t.sourceWidth,v.startupVariantHeight=t.sourceHeight,v.overallWatchedDurationMs=i,i>0&&(v.averageVideoKbps=a/(i/d.c),v.rebufferRate=this.playbackPerformance.totalStallDurationMs/i),v.segments=h}Object(c.a)(v,!0),Object(l.b)(3606,{...a,playback_session_id:this.videoSessionId,eventData:{videoPerformanceData:v}}),b?this.hasVideoSessionStarted=!0:(this.videoSessionId="",this.hasVideoSessionEnded=!0),Object(c.c)(b?"sessionStart":"sessionEnd",!0,t)}})}componentDidMount(){const{playing:e}=this.props;this.playbackPerformance.videoCreatedTime=new Date,this.initializeHls(),Object(c.c)("videoMounted",!0),e&&(this.videoVisibleTime=new Date,this.logPlaybackPerformance(d.e,{initiator:"mount"}))}componentDidUpdate(e,t){const{playing:a,src:i}=this.props;var s,n;(typeof(s=e.src)!=typeof(n=i)||(Array.isArray(n)?s.length!==n.length||n.some((e,t)=>!Array.isArray(s)||e.type!==s[t].type||e.src!==s[t].src):n!==s))&&this.initializeHls(),t.playbackState!==d.f.PAUSED&&t.playbackState!==d.f.SEEKING&&t.playbackState!==d.f.STALLING&&!1===e.playing&&a&&(this.videoVisibleTime=this.videoVisibleTime||new Date,this.logPlaybackPerformance(d.e,{initiator:"update"}))}componentWillUnmount(){const{loop:e}=this.props;this.logPlaybackPerformance(d.d,{initiator:"unmount",loop:e}),this.destroyHls()}render(){const{accessibilityMaximizeLabel:e,accessibilityMinimizeLabel:t,accessibilityMuteLabel:a,accessibilityPauseLabel:i,accessibilityPlayLabel:s,accessibilityUnmuteLabel:n,aspectRatio:r,captions:l,controls:o,loop:d,loopOveride:c,onDurationChange:m,onFullscreenChange:p,onLoadedChange:y,onPause:b,onPlay:f,onPlayheadDown:S,onPlayheadUp:g,onSeek:v,onTimeChange:P,onVolumeChange:L,playbackRate:w,playing:D,playsInline:E,poster:T,preload:k,src:V,volume:R}=this.props,{canPlayVideo:A,isManifestParsed:C}=this.state;return Object(u.jsx)(h.fb,{accessibilityMaximizeLabel:e,accessibilityMinimizeLabel:t,accessibilityMuteLabel:a,accessibilityPauseLabel:i,accessibilityPlayLabel:s,accessibilityUnmuteLabel:n,aspectRatio:r,captions:l,controls:o,loop:void 0===c?d:c,onDurationChange:m,onEnded:this.handleEnded,onFullscreenChange:p,onLoadedChange:y,onPause:b,onPlay:f,onPlayheadDown:S,onPlayheadUp:g,onReady:this.handleCanPlayVideo,onSeek:v,onTimeChange:P,onVolumeChange:L,playbackRate:w,playing:C&&A&&D,playsInline:E,poster:T,preload:k,ref:this.setVideoPlayerRef,src:V,volume:R})}}t.a=Object(i.memo)((function(e){const{country:t,isAuthenticated:a,isBot:i,isSocialBot:s,unauthId:n,userAgent:l}=Object(o.d)(),{browserName:h,browserVersion:d}=l,{contextLogData:m={}}=e,{view:y,viewParameter:b}=m,f=Object(r.a)(),S={browserName:h,browserVersion:d,country:t,isAuthenticated:a,isBot:i,isSocialBot:s,view:y,viewParameter:b};return Object(c.b)(S),Object(u.jsx)(p,{...e,userId:f.id||n})}))}}]);
//# sourceMappingURL=https://sm.pinimg.com/webapp/11-f549e309422120478aa5.mjs.map